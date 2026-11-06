<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSection;
use App\Support\HomepageSections;
use App\Support\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class HomepageSectionController extends Controller
{
    public function index()
    {
        $sections = HomepageSections::sections();
        $definitions = HomepageSections::definitions();

        return view('admin.homepage-sections.index', compact('sections', 'definitions'));
    }

    /**
     * Save display order and visibility for all sections at once.
     */
    public function arrange(Request $request)
    {
        $validated = $request->validate([
            'sections' => ['required', 'array'],
            'sections.*.order' => ['required', 'integer', 'min:0', 'max:999'],
            'sections.*.is_active' => ['nullable', 'boolean'],
        ]);

        foreach ($validated['sections'] as $id => $values) {
            PageSection::homepage()->whereKey($id)->update([
                'order' => $values['order'],
                'is_active' => !empty($values['is_active']),
            ]);
        }

        return redirect()->route('admin.homepage-sections.index')
            ->with('success', 'Homepage layout saved.');
    }

    public function edit(PageSection $section)
    {
        $this->ensureHomepageSection($section);

        $definition = HomepageSections::definition($section->section_key);
        $content = array_merge(HomepageSections::defaults($section->section_key), $section->content ?? []);

        return view('admin.homepage-sections.edit', compact('section', 'definition', 'content'));
    }

    public function update(Request $request, PageSection $section)
    {
        $this->ensureHomepageSection($section);

        $definition = HomepageSections::definition($section->section_key);
        $request->validate($this->rules($definition));

        $old = array_merge(HomepageSections::defaults($section->section_key), $section->content ?? []);
        $folder = 'homepage/' . $section->section_key;
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
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.homepage-sections.edit', $section)
            ->with('success', "\"{$section->section_name}\" saved.");
    }

    /**
     * Restore a section's content to the template defaults.
     */
    public function reset(PageSection $section)
    {
        $this->ensureHomepageSection($section);

        $definition = HomepageSections::definition($section->section_key);
        $defaults = HomepageSections::defaults($section->section_key);
        $this->deleteDroppedUploads($definition, $section->content ?? [], $defaults);

        $section->update(['content' => $defaults]);

        return redirect()->route('admin.homepage-sections.edit', $section)
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

    private function ensureHomepageSection(PageSection $section): void
    {
        abort_unless($section->page_id === null && HomepageSections::has($section->section_key), 404);
    }
}
