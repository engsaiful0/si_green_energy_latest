<?php

namespace App\Support\Pages;

use App\Support\PageSections;

/**
 * Solar Calculator page: an interactive sizing and cost calculator (inverter, battery bank,
 * solar array, charge controller). The calculation runs in the browser (public/js/solar-calculator.js);
 * the CMS manages the banner, SEO, intro texts and every cost rate the estimate uses.
 */
class SolarCalculatorPage
{
    public static function info(): array
    {
        return ['label' => 'Solar Calculator Page', 'route' => 'solar-calculator', 'views' => 'frontend.solar-calculator.sections'];
    }

    public static function pageSection(): array
    {
        return PageSections::pageSettings(
            true,
            'Solar Calculator',
            'Plan your solar power system in Bangladesh: estimate inverter size, battery storage, solar panels and approximate cost in BDT for your appliances.'
        );
    }

    public static function cta(): array
    {
        return ['title' => 'Get an Engineer-Checked Solar Quote', 'text' => 'Send us your calculator result and our engineers will confirm the right system for your site.', 'button_text' => 'Request a Free Quote', 'button_link' => '/contact'];
    }

    public static function sections(): array
    {
        $rate = fn (string $label, $default, string $help = '') => ['label' => $label, 'type' => 'number', 'default' => $default] + ($help ? ['help' => $help] : []);

        return [
            'calculator' => [
                'name' => 'Calculator Texts & Cost Rates',
                'description' => 'Heading texts of the calculator and the prices (in BDT) used for the cost estimate.',
                'render' => false,
                'fields' => [
                    'subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'default' => 'Solar Power Planner'],
                    'title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Solar Setup Calculator'],
                    'intro' => ['label' => 'Introduction', 'type' => 'textarea', 'default' => 'Add the appliances you want to run, set how many hours a day you use them and choose your battery and controller type. The calculator sizes the inverter, battery bank, solar array and charge controller and gives an approximate cost in BDT.'],
                    'rate_panel_mono' => $rate('Solar Panel Rate - Standard / Monocrystalline (BDT per W)', 22),
                    'rate_panel_poly' => $rate('Solar Panel Rate - Premium / Polycrystalline (BDT per W)', 28),
                    'rate_battery_lead_acid' => $rate('Battery Rate - Lead Acid (BDT per kWh)', 10000),
                    'rate_battery_lifepo4' => $rate('Battery Rate - LiFePO4 (BDT per kWh)', 25000),
                    'rate_inverter_pwm' => $rate('Inverter Rate - with PWM Controller (BDT per kW)', 10000),
                    'rate_inverter_mppt' => $rate('Inverter Rate - with MPPT Controller (BDT per kW)', 13000),
                    'rate_inverter_hybrid' => $rate('Inverter Rate - Hybrid Inverter (BDT per kW)', 20000),
                    'rate_cc_pwm' => $rate('Charge Controller Rate - PWM (BDT per A)', 45),
                    'rate_cc_mppt' => $rate('Charge Controller Rate - MPPT (BDT per A)', 80, 'The hybrid inverter has a built-in controller, so it has no separate controller cost.'),
                    'approx_note' => ['label' => 'Estimate Disclaimer', 'type' => 'textarea', 'default' => 'Approximate estimate only. Actual prices vary by brand, region and supplier. Use it as a planning reference and contact Si Green Energy for an exact quotation.'],
                ],
            ],
        ];
    }
}
