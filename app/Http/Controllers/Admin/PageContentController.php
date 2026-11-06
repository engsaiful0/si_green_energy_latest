<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSection;
use App\Support\PageSections;
use App\Support\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

/**
 * CMS for the pages registered in App\Support\PageSections (home, company profile, contact, ...).
 */
class PageContentController extends Controller
{
    /**
     * All CMS pages with their SEO status (SEO management overview).
     */
    public function pages()
    {
        $pages = collect(PageSections::pages())->map(function ($info, $key) {
            return $info + ['key' => $key, 'settings' => PageSections::settings($key)];
        });

        return view('admin.content.pages', compact('pages'));
    }

    /**
     * Content sources and review notes for the seeded content (CONTENT_SOURCES.md).
     */
    public function references()
    {
        $file = base_path('CONTENT_SOURCES.md');
        $html = is_file($file)
            ? \Illuminate\Support\Str::markdown(file_get_contents($file), ['html_input' => 'escape', 'allow_unsafe_links' => false], [new \League\CommonMark\Extension\Autolink\AutolinkExtension()])
            : '<p>No content sources recorded.</p>';

        return view('admin.content.references', compact('html'));
    }

    public function index(string $page)
    {
        $this->ensurePage($page);

        $sections = PageSections::sections($page);
        $definitions = PageSections::definitions($page);
        $info = PageSections::info($page);

        return view('admin.content.index', compact('page', 'info', 'sections', 'definitions'));
    }

    /**
     * Save display order and visibility for all sections at once.
     */
    public function arrange(Request $request, string $page)
    {
        $this->ensurePage($page);

        $validated = $request->validate([
            'sections' => ['required', 'array'],
            'sections.*.order' => ['nullable', 'integer', 'min:0', 'max:999'],
            'sections.*.is_active' => ['nullable', 'boolean'],
        ]);

        foreach ($validated['sections'] as $id => $values) {
            $changes = ['is_active' => !empty($values['is_active'])];
            if (isset($values['order'])) {
                $changes['order'] = $values['order'];
            }

            PageSection::forPage($page)->whereKey($id)->where('section_key', '!=', PageSections::PAGE_SETTINGS)->update($changes);
        }

        return redirect()->route('admin.content.index', $page)
            ->with('success', 'Page layout saved.');
    }

    public function edit(string $page, PageSection $section)
    {
        $this->ensureSection($page, $section);

        $definition = PageSections::definition($page, $section->section_key);
        $content = array_merge(PageSections::defaults($page, $section->section_key), $section->content ?? []);

        $info = PageSections::info($page);

        return view('admin.content.edit', compact('page', 'info', 'section', 'definition', 'content'));
    }

    public function update(Request $request, string $page, PageSection $section)
    {
        $this->ensureSection($page, $section);

        $definition = PageSections::definition($page, $section->section_key);
        $request->validate($this->rules($definition));

        $old = array_merge(PageSections::defaults($page, $section->section_key), $section->content ?? []);
        $folder = 'pages/' . $page;
        $content = [];

        foreach ($definition['fields'] ?? [] as $name => $field) {
            $content[$name] = $this->fieldValue($request, $field, "content.{$name}", "files.{$name}", "remove.{$name}", $folder);
        }

        foreach ($definition['repeaters'] ?? [] as $name => $repeater) {
            $rows = [];

            foreach ((array) $request->input("content.{$name}", []) as $index => $row) {
                $item = [];
                foreach ($repeater['fields'] as $fieldName => $field) {
                    $item[$fieldName] = $this->fieldValue(
                        $request,
                        $field,
                        "content.{$name}.{$index}.{$fieldName}",
                        "files.{$name}.{$index}.{$fieldName}",
                        "remove.{$name}.{$index}.{$fieldName}",
                        $folder
                    );
                }

                // Skip rows the admin left completely empty.
                if (collect($item)->filter(fn ($value) => $value !== null && $value !== '')->isNotEmpty()) {
                    $rows[] = $item;
                }
            }

            $content[$name] = $rows;
        }

        $this->deleteDroppedUploads($definition, $old, $content);

        $section->update([
            'content' => $content,
            // The banner/SEO section is always "active"; it is never rendered as a block.
            'is_active' => $section->section_key === PageSections::PAGE_SETTINGS || $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.content.edit', [$page, $section])
            ->with('success', "\"{$section->section_name}\" saved.");
    }

    /**
     * Restore a section's content to the template defaults.
     */
    public function reset(string $page, PageSection $section)
    {
        $this->ensureSection($page, $section);

        $definition = PageSections::definition($page, $section->section_key);
        $defaults = PageSections::defaults($page, $section->section_key);
        $this->deleteDroppedUploads($definition, $section->content ?? [], $defaults);

        $section->update(['content' => $defaults]);

        return redirect()->route('admin.content.edit', [$page, $section])
            ->with('success', "\"{$section->section_name}\" restored to default content.");
    }

    private function fieldValue(Request $request, array $field, string $key, string $fileKey, string $removeKey, string $folder)
    {
        $value = $request->input($key);

        if (($field['type'] ?? 'text') === 'image') {
            if ($request->hasFile($fileKey)) {
                // The previous file is removed by deleteDroppedUploads() once content is saved.
                return Media::store($request->file($fileKey), $folder);
            }

            if ($request->boolean($removeKey)) {
                return null;
            }
        }

        if (($field['type'] ?? 'text') === 'number') {
            return is_numeric($value) ? $value + 0 : null;
        }

        return is_string($value) ? trim($value) : $value;
    }

    private function rules(array $definition): array
    {
        $rules = ['is_active' => ['nullable', 'boolean']];

        foreach ($definition['fields'] ?? [] as $name => $field) {
            $rules = array_merge($rules, $this->fieldRules($field, "content.{$name}", "files.{$name}"));
        }

        foreach ($definition['repeaters'] ?? [] as $name => $repeater) {
            $rules["content.{$name}"] = ['nullable', 'array', 'max:24'];
            foreach ($repeater['fields'] as $fieldName => $field) {
                $rules = array_merge($rules, $this->fieldRules($field, "content.{$name}.*.{$fieldName}", "files.{$name}.*.{$fieldName}"));
            }
        }

        return $rules;
    }

    private function fieldRules(array $field, string $key, string $fileKey): array
    {
        return match ($field['type'] ?? 'text') {
            'number' => [$key => ['nullable', 'numeric', 'min:0', 'max:1000000']],
            'textarea' => [$key => ['nullable', 'string', 'max:5000']],
            'longtext' => [$key => ['nullable', 'string', 'max:50000']],
            'image' => [$key => ['nullable', 'string', 'max:500'], $fileKey => Media::rules()],
            default => [$key => ['nullable', 'string', 'max:500']],
        };
    }

    /**
     * Delete uploaded files that were referenced by the old content but not by the new content.
     */
    private function deleteDroppedUploads(array $definition, array $old, array $new): void
    {
        $removed = array_diff($this->imagePaths($definition, $old), $this->imagePaths($definition, $new));

        foreach ($removed as $path) {
            Media::delete($path);
        }
    }

    private function imagePaths(array $definition, array $content): array
    {
        $paths = [];

        foreach ($definition['fields'] ?? [] as $name => $field) {
            if (($field['type'] ?? null) === 'image' && !empty($content[$name])) {
                $paths[] = $content[$name];
            }
        }

        foreach ($definition['repeaters'] ?? [] as $name => $repeater) {
            foreach ((array) ($content[$name] ?? []) as $row) {
                foreach ($repeater['fields'] as $fieldName => $field) {
                    if (($field['type'] ?? null) === 'image' && !empty(Arr::get($row, $fieldName))) {
                        $paths[] = $row[$fieldName];
                    }
                }
            }
        }

        return array_unique($paths);
    }

    private function ensurePage(string $page): void
    {
        abort_unless(PageSections::hasPage($page), 404);
    }

    private function ensureSection(string $page, PageSection $section): void
    {
        abort_unless($section->page_id === null && $section->page_key === $page
            && PageSections::has($page, $section->section_key), 404);
    }
}
