<?php

namespace App\Support;

use App\Models\PageSection;
use App\Support\Pages;
use Illuminate\Support\Collection;

/**
 * Registry of CMS-managed pages and their sections.
 *
 * Every page is a class in App\Support\Pages with info() and sections(). Each section is one
 * row in `page_sections` (page_id NULL, page_key = page) whose JSON `content` holds the fields
 * defined for it. Sections with a "source" also list records from their own module
 * (see SectionData). Every page has a hidden "page" section holding its banner title/image
 * and SEO meta, edited like any other section.
 *
 * Field types: text, textarea (line breaks kept), image, url, number, icon.
 */
class PageSections
{
    public const PAGE_SETTINGS = 'page';

    public const CTA = 'cta';

    /**
     * page key => definition class
     */
    private const PAGES = [
        'home' => Pages\HomePage::class,
        'company-profile' => Pages\CompanyProfilePage::class,
        'contact' => Pages\ContactPage::class,
        'services' => Pages\ServicesPage::class,
        'solutions' => Pages\SolutionsPage::class,
        'products' => Pages\ProductsPage::class,
        'projects' => Pages\ProjectsPage::class,
        'blog' => Pages\BlogPage::class,
        'team' => Pages\TeamPage::class,
        'testimonials' => Pages\TestimonialsPage::class,
        'privacy' => Pages\PrivacyPage::class,
        'terms' => Pages\TermsPage::class,
    ];

    public static function pages(): array
    {
        return array_map(fn ($class) => $class::info(), self::PAGES);
    }

    public static function hasPage(string $page): bool
    {
        return array_key_exists($page, self::PAGES);
    }

    public static function info(string $page): array
    {
        return self::PAGES[$page]::info();
    }

    public static function definitions(string $page): array
    {
        $class = self::PAGES[$page];
        $definitions = [self::PAGE_SETTINGS => $class::pageSection()] + $class::sections();

        // Every page except home ends with the shared call-to-action box (home has its own footer_cta block).
        if (method_exists($class, 'cta')) {
            $definitions[self::CTA] = static::ctaDefinition($class::cta());
        }

        return $definitions;
    }

    public static function has(string $page, string $key): bool
    {
        return self::hasPage($page) && array_key_exists($key, static::definitions($page));
    }

    public static function definition(string $page, string $key): array
    {
        return static::definitions($page)[$key];
    }

    /**
     * Default content for a section, built from the field and repeater defaults.
     */
    public static function defaults(string $page, string $key): array
    {
        $definition = static::definition($page, $key);
        $content = [];

        foreach ($definition['fields'] ?? [] as $name => $field) {
            $content[$name] = $field['default'] ?? null;
        }

        foreach ($definition['repeaters'] ?? [] as $name => $repeater) {
            $content[$name] = $repeater['default'] ?? [];
        }

        return $content;
    }

    /**
     * All section rows of a page in display order, with defaults merged in.
     * Missing rows are created from the defaults.
     */
    public static function sections(string $page): Collection
    {
        static::ensureExists($page);

        return PageSection::forPage($page)
            ->whereIn('section_key', array_keys(static::definitions($page)))
            ->orderBy('order')
            ->get()
            ->each(function (PageSection $section) use ($page) {
                // Saved values win; fields added later fall back to their defaults.
                $section->content = array_merge(static::defaults($page, $section->section_key), $section->content ?? []);
            });
    }

    /**
     * Visible, renderable sections of a page (the hidden "page" settings section excluded).
     */
    public static function visible(string $page): Collection
    {
        return static::sections($page)
            ->filter(fn (PageSection $section) => $section->is_active
                && (static::definition($page, $section->section_key)['render'] ?? true))
            ->values();
    }

    /**
     * Page banner + SEO values of a page.
     */
    public static function settings(string $page): array
    {
        $section = static::sections($page)->firstWhere('section_key', self::PAGE_SETTINGS);

        return $section ? $section->content : static::defaults($page, self::PAGE_SETTINGS);
    }

    public static function view(string $page, string $key): string
    {
        return static::definition($page, $key)['view'] ?? static::info($page)['views'] . '.' . $key;
    }

    public static function ensureExists(string $page): void
    {
        $existing = PageSection::forPage($page)->pluck('section_key')->all();
        $order = 0;

        foreach (static::definitions($page) as $key => $definition) {
            $order++;

            if (in_array($key, $existing, true)) {
                continue;
            }

            PageSection::create([
                'page_id' => null,
                'page_key' => $page,
                'section_key' => $key,
                'section_name' => $definition['name'],
                'content' => static::defaults($page, $key),
                'is_active' => true,
                'order' => $key === self::PAGE_SETTINGS ? 0 : $order,
            ]);
        }
    }

    /**
     * Shared call-to-action section (rendered at the bottom of the page by frontend.partials.page-cta).
     *
     * @param  array  $defaults  title, text, button_text, button_link (optional overrides)
     */
    public static function ctaDefinition(array $defaults = []): array
    {
        $defaults += [
            'title' => 'Get a Free Solar Consultation',
            'text' => 'Tell us about your site and energy needs. Our engineers will recommend a practical solar solution for you.',
            'button_text' => 'Contact Si Green Energy',
            'button_link' => '/contact',
        ];

        return [
            'name' => 'Call to Action',
            'description' => 'Call-to-action box shown at the bottom of this page (same design on every page).',
            'render' => false,
            'toggle' => true,
            'fields' => [
                'title' => ['label' => 'Heading', 'type' => 'textarea', 'default' => $defaults['title']],
                'text' => ['label' => 'Description', 'type' => 'textarea', 'default' => $defaults['text']],
                'button_text' => ['label' => 'Button Label', 'type' => 'text', 'default' => $defaults['button_text']],
                'button_link' => ['label' => 'Button Link', 'type' => 'url', 'default' => $defaults['button_link']],
                'help_label' => ['label' => 'Phone Label', 'type' => 'text', 'default' => 'Call our team'],
                'phone' => ['label' => 'Phone', 'type' => 'text', 'default' => Company::PHONE, 'help' => 'Leave empty to hide the phone.'],
                'image' => ['label' => 'Image', 'type' => 'image', 'default' => 'img/avatar/avatar-5.png'],
                'background_image' => ['label' => 'Background', 'type' => 'image', 'default' => 'img/shape/shape-7.png'],
            ],
        ];
    }

    /**
     * Definition of the hidden "page" section (banner + SEO) shared by every page.
     */
    public static function pageSettings(bool $withBanner, string $title, string $metaDescription = ''): array
    {
        $fields = [];

        if ($withBanner) {
            $fields['title'] = ['label' => 'Page Title (banner heading)', 'type' => 'text', 'default' => $title];
            $fields['breadcrumb_image'] = ['label' => 'Banner Background', 'type' => 'image', 'default' => 'img/pages/breadcrumb.jpg'];
        }

        $fields['meta_title'] = ['label' => 'SEO Title', 'type' => 'text', 'default' => '', 'help' => 'Browser tab / search result title. Empty = page title + site name.'];
        $fields['meta_description'] = ['label' => 'SEO Meta Description', 'type' => 'textarea', 'default' => $metaDescription, 'help' => 'About 150-160 characters.'];
        $fields['meta_keywords'] = ['label' => 'SEO Keywords', 'type' => 'text', 'default' => '', 'help' => 'Comma separated (optional).'];

        return [
            'name' => 'Page Banner & SEO',
            'description' => 'Banner heading/image and search engine meta for this page.',
            'render' => false,
            'fields' => $fields,
        ];
    }
}
