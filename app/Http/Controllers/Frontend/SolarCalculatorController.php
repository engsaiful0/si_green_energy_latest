<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Support\PageSections;
use App\Support\Seo;

/**
 * Solar Calculator page. Sizing and cost are calculated in the browser
 * (public/js/solar-calculator.js) from the cost rates managed in the page CMS.
 */
class SolarCalculatorController extends Controller
{
    public function index()
    {
        $settings = PageSections::settings('solar-calculator');
        $calculator = PageSections::sections('solar-calculator')->firstWhere('section_key', 'calculator')->content;

        $num = fn (string $key) => max(0, (float) ($calculator[$key] ?? 0));

        // Rates in BDT, keyed like the calculator options.
        $rates = [
            'solar' => ['mono' => $num('rate_panel_mono'), 'poly' => $num('rate_panel_poly')],
            'battery' => ['lead-acid' => $num('rate_battery_lead_acid'), 'lifepo4' => $num('rate_battery_lifepo4')],
            'inverter' => ['pwm' => $num('rate_inverter_pwm'), 'mppt' => $num('rate_inverter_mppt'), 'hybrid' => $num('rate_inverter_hybrid')],
            'chargeController' => ['pwm' => $num('rate_cc_pwm'), 'mppt' => $num('rate_cc_mppt'), 'hybrid' => 0],
        ];

        $seo = Seo::page('solar-calculator');

        return view('frontend.solar-calculator.index', compact('settings', 'calculator', 'rates', 'seo'));
    }
}
