<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Real manufacturer products (database/data/products.php).
 *
 * Idempotent and non-destructive:
 *  - products are matched by slug, so re-running never creates duplicates;
 *  - new products are created with all their data;
 *  - existing products only get fields that are still empty, so admin edits are kept.
 * The generic sample products of the first content version are removed.
 */
class ProductCatalogSeeder extends Seeder
{
    /** Generic sample products from the first content version (replaced by real products). */
    private const GENERIC_SAMPLES = [
        'monocrystalline-perc-solar-panel', 'bifacial-solar-panel', 'n-type-topcon-solar-panel',
        'on-grid-solar-inverter', 'off-grid-solar-inverter', 'hybrid-solar-inverter',
        'lifepo4-lithium-solar-battery', 'tubular-lead-acid-solar-battery',
        'mppt-solar-charge-controller', 'pwm-solar-charge-controller', 'all-in-one-solar-street-light',
        'rooftop-solar-mounting-structure', 'ground-mounted-solar-structure',
        'solar-dc-protection-box', 'solar-dc-cables-and-mc4-connectors',
    ];

    public function run(): void
    {
        $catalog = require database_path('data/catalog.php');

        $categories = [];
        foreach ($catalog['product_categories'] as $order => $category) {
            $categories[$category['slug']] = ProductCategory::firstOrCreate(
                ['slug' => $category['slug']],
                $category + ['order' => $order + 1, 'is_active' => true]
            );
        }

        Product::withTrashed()->whereIn('slug', self::GENERIC_SAMPLES)->forceDelete();

        foreach (require database_path('data/products.php') as $order => $data) {
            $attributes = [
                'name' => $data['name'],
                'brand' => $data['brand'],
                'model' => $data['model'],
                'category_id' => $categories[$data['category']]->id,
                'short_description' => $data['short'],
                'description' => $data['description'],
                'features' => $data['features'],
                'specifications' => collect($data['specs'])->map(fn ($value, $label) => ['label' => $label, 'value' => $value])->values()->all(),
                'applications' => $data['applications'],
                'manufacturer_url' => $data['manufacturer_url'],
                'datasheet_url' => $data['datasheet_url'],
                'source_url' => $data['source_url'],
                'featured_image' => $data['image'],
                'meta_title' => self::metaTitle($data['name']),
                'meta_description' => Str::limit($data['short'], 155, ''),
                'status' => 'published',
                'is_featured' => false,
                'order' => $order + 1,
            ];

            $product = Product::withTrashed()->firstOrNew(['slug' => Str::slug($data['name'])]);

            if (!$product->exists) {
                $product->fill($attributes)->save();
                continue;
            }

            // Existing record: only complete empty fields, never overwrite admin edits.
            foreach ($attributes as $key => $value) {
                if (blank($product->getAttribute($key)) && !in_array($key, ['status', 'is_featured', 'order'], true)) {
                    $product->setAttribute($key, $value);
                }
            }
            $product->save();
        }
    }

    /**
     * Full product name, with the company name appended when the title stays short enough.
     */
    public static function metaTitle(string $name): string
    {
        return mb_strlen($name) <= 42 ? $name . ' | Si Green Energy' : $name;
    }
}
