<?php

namespace Tests\Feature;

use App\Models\PageSection;
use App\Models\User;
use App\Support\PageSections;
use App\Support\SiteSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SolarCalculatorTest extends TestCase
{
    use RefreshDatabase;

    public function test_header_button_links_to_the_solar_calculator(): void
    {
        SiteSettings::flush();

        $html = $this->get('/')->assertOk()->getContent();

        $this->assertStringContainsString('>Solar Calculator</a>', $html);
        $this->assertStringContainsString('href="' . route('solar-calculator') . '"', $html);
        $this->assertStringNotContainsString('Get a Free Quote', $html);
    }

    public function test_calculator_page_renders_with_rates_and_assets(): void
    {
        $this->get('/solar-calculator')->assertOk()
            ->assertSee('x-data="solarCalculator()"', false)
            ->assertSee('js/solar-calculator.js', false)
            ->assertSee('js/vendor/alpine-3.14.1.min.js', false)
            ->assertSee('"mono":22', false)
            ->assertSee('"lifepo4":25000', false)
            ->assertSee('"hybrid":0', false)
            ->assertSee('Solar Setup Calculator')
            ->assertSee('class="cta__title-line"', false);

        $this->assertFileExists(public_path('js/solar-calculator.js'));
        $this->assertFileExists(public_path('js/vendor/alpine-3.14.1.min.js'));
        $this->assertFileExists(public_path('css/solar-calculator.css'));
    }

    public function test_cost_rates_are_managed_in_the_cms(): void
    {
        PageSections::ensureExists('solar-calculator');
        $section = PageSection::where('page_key', 'solar-calculator')->where('section_key', 'calculator')->firstOrFail();

        $this->actingAs(User::factory()->create())
            ->put(route('admin.content.update', ['solar-calculator', $section]), ['content' => array_merge($section->content, [
                'rate_panel_mono' => 24.5,
                'rate_battery_lifepo4' => 23000,
            ])])->assertRedirect()->assertSessionHasNoErrors();

        $this->get('/solar-calculator')->assertSee('"mono":24.5', false)->assertSee('"lifepo4":23000', false);
    }

    public function test_admin_cms_page_is_listed(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.content.index', 'solar-calculator'))->assertOk()
            ->assertSee('Calculator Texts &amp; Cost Rates', false);
    }

    public function test_contact_form_is_prefilled_from_the_calculator_link(): void
    {
        $this->get('/contact?subject=Solar+quote&message=Inverter%3A+2+kW')
            ->assertOk()
            ->assertSee('value="Solar quote"', false)
            ->assertSee('Inverter: 2 kW');

        // Array input must not break the page.
        $this->get('/contact?message[]=x')->assertOk();
    }
}
