@extends('layouts.frontend')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/solar-calculator.css') }}?v={{ filemtime(public_path('css/solar-calculator.css')) }}">
@endpush

@section('content')
@include('frontend.partials.breadcrumb', ['title' => $settings['title'], 'image' => $settings['breadcrumb_image']])

<!-- Solar Calculator Area Start -->
<div class="solar-calc section-padding-three" x-data="solarCalculator()" x-init="init()" x-on:keydown.escape.window="closeModals()">
    <div class="container">
        <div class="row align-items-end mb-40">
            <div class="col-lg-9">
                <div class="solar-calc__head">
                    @if($calculator['subtitle'])<span class="subtitle-one">{{ $calculator['subtitle'] }}</span>@endif
                    @if($calculator['title'])<h2>{{ $calculator['title'] }}</h2>@endif
                    @if($calculator['intro'])<p>{!! nl2br(e($calculator['intro'])) !!}</p>@endif
                </div>
            </div>
            <div class="col-lg-3 solar-calc__lang-wrap">
                <button type="button" class="solar-calc__lang" x-on:click="toggleLang()" x-bind:title="lang === 'en' ? 'বাংলায় দেখুন' : 'Switch to English'">
                    <i class="fa-solid fa-language"></i>
                    <span x-text="lang === 'en' ? 'বাংলা' : 'English'">বাংলা</span>
                </button>
            </div>
        </div>

        <noscript><p class="solar-calc__notice is-error">Please enable JavaScript to use the solar calculator.</p></noscript>

        <div class="row">
            <!-- Inputs -->
            <div class="col-lg-7">
                <!-- Appliances -->
                <div class="solar-calc__card">
                    <div class="solar-calc__card-head">
                        <span class="solar-calc__card-icon"><i class="fa-solid fa-plug"></i></span>
                        <div>
                            <h5 x-text="t('appliancesTitle')">Daily Appliances & Load</h5>
                            <span x-text="t('appliancesDesc')">Set the quantity and daily usage hours of each device</span>
                        </div>
                    </div>

                    @foreach(['commonAppliances' => null, 'otherAppliances' => 'otherAppliances'] as $list => $divider)
                    <div @if($divider) x-show="isOtherVisible" x-cloak @endif>
                        @if($divider)
                        <div class="solar-calc__divider"><span x-text="t('otherAppliances')">Other Appliances</span></div>
                        @endif
                        <div class="solar-calc__appliances">
                            <template x-for="app in {{ $list }}" x-bind:key="app.id">
                                <div class="solar-calc__appliance" x-bind:class="state[app.id].qty > 0 ? 'is-active' : ''">
                                    <div class="solar-calc__appliance-info">
                                        <span class="solar-calc__appliance-icon" x-bind:class="app.color"><i class="fa-solid" x-bind:class="app.icon"></i></span>
                                        <div>
                                            <h6 x-text="appName(app)"></h6>
                                            <span class="solar-calc__appliance-watts">
                                                <span x-text="app.watts + ' ' + t('wPerUnit')"></span>
                                                <strong x-show="state[app.id].qty > 0" x-text="'· ' + appTotalWatts(app) + ' ' + t('totalWatts')"></strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="solar-calc__appliance-controls">
                                        <div class="solar-calc__control">
                                            <label class="solar-calc__control-label" x-bind:for="'qty-' + app.id" x-text="t('qty')"></label>
                                            <div class="solar-calc__stepper">
                                                <button type="button" x-on:click="updateQty(app.id, -1)" x-bind:disabled="state[app.id].qty <= 0" x-bind:aria-label="t('decrease') + ' ' + appName(app)">&minus;</button>
                                                <input type="number" inputmode="numeric" min="0" x-bind:max="LIMITS.qtyMax" step="1" x-bind:id="'qty-' + app.id"
                                                       x-bind:value="state[app.id].qty" x-on:change="setQty(app.id, $event.target.value); $event.target.value = state[app.id].qty"
                                                       x-bind:aria-invalid="errors[app.id] ? 'true' : 'false'">
                                                <button type="button" x-on:click="updateQty(app.id, 1)" x-bind:disabled="state[app.id].qty >= LIMITS.qtyMax" x-bind:aria-label="t('increase') + ' ' + appName(app)">+</button>
                                            </div>
                                        </div>
                                        <div class="solar-calc__control solar-calc__control--hours">
                                            <label class="solar-calc__control-label" x-bind:for="'hours-' + app.id" x-text="t('hoursPerDay')"></label>
                                            <div class="solar-calc__hours">
                                                <input type="range" min="0" max="24" step="0.5" class="solar-calc__range" x-bind:id="'hours-' + app.id"
                                                       x-bind:value="state[app.id].hours" x-on:input="setHours(app.id, $event.target.value)">
                                                <span class="solar-calc__hours-val" x-text="state[app.id].hours + 'h'"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="solar-calc__error" role="alert" x-show="errors[app.id] || errors[app.id + '_hours']" x-text="errors[app.id] || errors[app.id + '_hours']" x-cloak></p>
                                </div>
                            </template>
                        </div>
                    </div>
                    @endforeach

                    <button type="button" class="solar-calc__toggle" x-on:click="isOtherVisible = !isOtherVisible" x-bind:aria-expanded="isOtherVisible ? 'true' : 'false'">
                        <i class="fa-solid" x-bind:class="isOtherVisible ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                        <span x-text="isOtherVisible ? t('hideOther') : t('showOther')"></span>
                    </button>
                </div>

                <!-- System preferences -->
                <div class="solar-calc__card">
                    <div class="solar-calc__card-head">
                        <span class="solar-calc__card-icon is-amber"><i class="fa-solid fa-sliders"></i></span>
                        <div>
                            <h5 x-text="t('prefsTitle')">System Preferences</h5>
                            <span x-text="t('prefsDesc')">Fine-tune battery, solar and inverter parameters</span>
                        </div>
                    </div>

                    <div class="solar-calc__prefs">
                        <div class="solar-calc__divider is-full"><span x-text="t('sectionGeneral')"></span></div>

                        <div class="solar-calc__pref">
                            <label for="sc-autonomy"><span x-text="t('backupDuration')"></span><strong x-text="autonomy + 'h'"></strong></label>
                            <input id="sc-autonomy" type="range" class="solar-calc__range" x-bind:min="LIMITS.autonomyMin" x-bind:max="LIMITS.autonomyMax" step="1"
                                   x-bind:value="autonomy" x-on:input="setOption('autonomy', parseInt($event.target.value, 10))">
                            <p class="solar-calc__hint" x-text="t('backupHint')"></p>
                        </div>

                        <div class="solar-calc__pref" x-show="isSolarEnabled">
                            <label for="sc-sun"><span x-text="t('peakSunHours')"></span><strong x-text="sun + 'h'"></strong></label>
                            <input id="sc-sun" type="range" class="solar-calc__range" x-bind:min="LIMITS.sunMin" x-bind:max="LIMITS.sunMax" step="0.1"
                                   x-bind:value="sun" x-on:input="setOption('sun', parseFloat($event.target.value))">
                            <p class="solar-calc__hint" x-text="t('peakSunHint')"></p>
                        </div>

                        <div class="solar-calc__divider is-full"><span x-text="t('sectionSolar')"></span></div>

                        <div class="solar-calc__pref is-full">
                            <label><span x-text="t('enableSolar')"></span><strong x-text="isSolarEnabled ? t('enabled') : t('disabled')"></strong></label>
                            <div class="solar-calc__options">
                                <button type="button" class="solar-calc__option" x-bind:class="isSolarEnabled ? 'is-active' : ''" x-bind:aria-pressed="isSolarEnabled ? 'true' : 'false'" x-on:click="setOption('isSolarEnabled', true)">
                                    <i class="fa-solid fa-sun"></i> <span x-text="t('enabled')"></span>
                                </button>
                                <button type="button" class="solar-calc__option" x-bind:class="!isSolarEnabled ? 'is-active' : ''" x-bind:aria-pressed="!isSolarEnabled ? 'true' : 'false'" x-on:click="setOption('isSolarEnabled', false)">
                                    <i class="fa-solid fa-xmark"></i> <span x-text="t('disabled')"></span>
                                </button>
                            </div>
                            <p class="solar-calc__hint" x-text="t('solarToggleHint')"></p>
                        </div>

                        <div class="solar-calc__pref" x-show="isSolarEnabled">
                            <label><span x-text="t('panelType')"></span><strong x-text="rates.solarPerW + ' ৳/W'"></strong></label>
                            <div class="solar-calc__options">
                                <button type="button" class="solar-calc__option" x-bind:class="panelType === 'mono' ? 'is-active' : ''" x-on:click="setOption('panelType', 'mono')">
                                    <span x-text="t('panelStandard')"></span><small x-text="t('panelMono')"></small>
                                </button>
                                <button type="button" class="solar-calc__option" x-bind:class="panelType === 'poly' ? 'is-active' : ''" x-on:click="setOption('panelType', 'poly')">
                                    <span x-text="t('panelPremium')"></span><small x-text="t('panelPoly')"></small>
                                </button>
                            </div>
                            <p class="solar-calc__hint" x-text="t('panelHint')"></p>
                        </div>

                        <div class="solar-calc__pref" x-show="isSolarEnabled">
                            <label><span x-text="t('panelWatts')"></span><strong x-text="panelWatts + 'W'"></strong></label>
                            <div class="solar-calc__chips">
                                <template x-for="pw in PANEL_SIZES" x-bind:key="pw">
                                    <button type="button" class="solar-calc__chip" x-bind:class="panelWatts === pw ? 'is-active' : ''" x-on:click="setOption('panelWatts', pw)" x-text="pw + 'W'"></button>
                                </template>
                            </div>
                            <p class="solar-calc__hint" x-text="t('panelWattsHint')"></p>
                        </div>

                        <div class="solar-calc__divider is-full"><span x-text="t('sectionBattery')"></span></div>

                        <div class="solar-calc__pref">
                            <label><span x-text="t('batteryType')"></span><strong x-text="formatNumber(rates.battPerKwh) + ' ৳/kWh'"></strong></label>
                            <div class="solar-calc__options">
                                <button type="button" class="solar-calc__option" x-bind:class="batteryType === 'lead-acid' ? 'is-active' : ''" x-on:click="setOption('batteryType', 'lead-acid')">
                                    <span x-text="t('leadAcid')"></span><small x-text="t('leadAcidSub')"></small>
                                </button>
                                <button type="button" class="solar-calc__option" x-bind:class="batteryType === 'lifepo4' ? 'is-active' : ''" x-on:click="setOption('batteryType', 'lifepo4')">
                                    <span x-text="t('lifepo4')"></span><small x-text="t('lifepo4Sub')"></small>
                                </button>
                            </div>
                            <p class="solar-calc__hint" x-text="t('batteryHint')"></p>
                        </div>

                        <div class="solar-calc__pref">
                            <label><span x-text="t('batteryBank')"></span><strong x-text="voltage + 'V · ' + battAh + ' Ah · ' + battCapKwh().toFixed(2) + ' kWh'"></strong></label>
                            <div class="solar-calc__chips">
                                <template x-for="v in VOLTAGES" x-bind:key="v">
                                    <button type="button" class="solar-calc__chip is-volt" x-bind:class="voltage === v ? 'is-active' : ''" x-on:click="setVoltage(v)" x-text="v + 'V'"></button>
                                </template>
                            </div>
                            <div class="solar-calc__chips mt-10">
                                <template x-for="ah in availableBattAh()" x-bind:key="ah">
                                    <button type="button" class="solar-calc__chip is-small" x-bind:class="battAh === ah ? 'is-active' : ''" x-on:click="setOption('battAh', ah)" x-text="ah + ' Ah'"></button>
                                </template>
                            </div>
                            <p class="solar-calc__hint" x-text="t('batteryBankHint')"></p>
                        </div>

                        <div class="solar-calc__divider is-full"><span x-text="t('sectionInverter')"></span></div>

                        <div class="solar-calc__pref is-full">
                            <label><span x-text="t('systemType')"></span><strong x-text="systemTypeLabel()"></strong></label>
                            <div class="solar-calc__options is-three">
                                <button type="button" class="solar-calc__option" x-bind:class="systemType === 'pwm' ? 'is-active' : ''" x-on:click="setOption('systemType', 'pwm')">
                                    <span><i class="fa-solid fa-microchip"></i> <span x-text="t('pwm')"></span></span><small x-text="t('chargeControllerSub')"></small>
                                </button>
                                <button type="button" class="solar-calc__option" x-bind:class="systemType === 'mppt' ? 'is-active' : ''" x-on:click="setOption('systemType', 'mppt')">
                                    <span><i class="fa-solid fa-bolt"></i> <span x-text="t('mppt')"></span></span><small x-text="t('chargeControllerSub')"></small>
                                </button>
                                <button type="button" class="solar-calc__option" x-bind:class="systemType === 'hybrid' ? 'is-active' : ''" x-on:click="setOption('systemType', 'hybrid')">
                                    <span><i class="fa-solid fa-layer-group"></i> <span x-text="t('hybridInverter')"></span></span><small x-text="t('hybridSub')"></small>
                                </button>
                            </div>
                            <p class="solar-calc__hint" x-text="systemTypeHint()"></p>
                        </div>
                    </div>
                </div>

                <!-- Load breakdown -->
                <div class="solar-calc__card" x-show="parseFloat(res.dailyEnergy) > 0" x-cloak>
                    <div class="solar-calc__card-head">
                        <span class="solar-calc__card-icon"><i class="fa-solid fa-chart-bar"></i></span>
                        <div>
                            <h5 x-text="t('loadBreakdownTitle')"></h5>
                            <span x-text="t('loadBreakdownDesc')"></span>
                        </div>
                    </div>
                    <div class="solar-calc__bars">
                        <template x-for="item in loadBreakdown()" x-bind:key="item.id">
                            <div class="solar-calc__bar">
                                <div class="solar-calc__bar-label"><span class="solar-calc__dot" x-bind:class="item.color"></span><span x-text="item.name"></span></div>
                                <div class="solar-calc__bar-track"><div class="solar-calc__bar-fill" x-bind:class="item.color" x-bind:style="'width:' + item.pct + '%'"></div></div>
                                <div class="solar-calc__bar-val"><span x-text="item.kwh.toFixed(2) + ' kWh'"></span><small x-text="item.pct + '%'"></small></div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Comparison -->
                <div class="solar-calc__card">
                    <button type="button" class="solar-calc__toggle mt-0" x-on:click="toggleCompare()" x-bind:aria-expanded="isCompareVisible ? 'true' : 'false'">
                        <i class="fa-solid" x-bind:class="isCompareVisible ? 'fa-chevron-up' : 'fa-scale-balanced'"></i>
                        <span x-text="isCompareVisible ? t('hideCompare') : t('showCompare')">Show Comparison</span>
                    </button>
                    <div x-show="isCompareVisible" x-cloak class="mt-25">
                        <div class="solar-calc__card-head">
                            <span class="solar-calc__card-icon is-amber"><i class="fa-solid fa-scale-balanced"></i></span>
                            <div>
                                <h5 x-text="t('compareTitle')"></h5>
                                <span x-text="t('compareDesc')"></span>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table solar-calc__compare">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <template x-for="col in compareData" x-bind:key="col.mode">
                                            <th scope="col" x-bind:class="col.mode === systemType ? 'is-active' : ''" x-text="col.label"></th>
                                        </template>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(['inverter' => 'rowInverter', 'battery' => 'rowBattery', 'solar' => 'rowSolar', 'cost' => 'rowCost'] as $field => $label)
                                    <tr @if($field === 'cost') class="is-cost" @endif>
                                        <th scope="row" x-text="t('{{ $label }}')"></th>
                                        <template x-for="col in compareData" x-bind:key="col.mode">
                                            <td x-bind:class="col.mode === systemType ? 'is-active' : ''" x-text="col.{{ $field }}"></td>
                                        </template>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- How it is calculated -->
                <div class="solar-calc__info">
                    <h6><i class="fa-solid fa-lightbulb"></i> <span x-text="t('quickInfo')">How It Is Calculated</span></h6>
                    <ul>
                        <template x-for="(item, i) in t('quickInfoItems')" x-bind:key="i">
                            <li x-html="item"></li>
                        </template>
                    </ul>
                </div>
            </div>

            <!-- Results -->
            <div class="col-lg-5">
                <div class="solar-calc__sticky">
                    <div class="solar-calc__results" aria-live="polite">
                        <h5 class="solar-calc__results-title" x-text="t('systemSummary')">System Summary</h5>

                        <div class="solar-calc__result">
                            <div>
                                <span class="solar-calc__result-label" x-text="t('inverterSize')"></span>
                                <span class="solar-calc__result-value is-blue" x-text="res.inverter + ' kW'"></span>
                            </div>
                            <span class="solar-calc__result-icon is-blue"><i class="fa-solid fa-microchip"></i></span>
                        </div>

                        <div class="solar-calc__result">
                            <div>
                                <span class="solar-calc__result-label" x-text="t('storageNeeded')"></span>
                                <span class="solar-calc__result-value is-purple" x-text="res.battery + ' kWh'"></span>
                                <span class="solar-calc__result-sub">
                                    <strong x-text="res.battAh + ' Ah'"></strong> @ <span x-text="voltage + 'V'"></span> &middot;
                                    <span x-text="res.battCount + ' × ' + battAh + ' Ah ' + t('units')"></span>
                                </span>
                            </div>
                            <span class="solar-calc__result-icon is-purple"><i class="fa-solid fa-car-battery"></i></span>
                        </div>

                        <div class="solar-calc__result" x-show="isSolarEnabled">
                            <div>
                                <span class="solar-calc__result-label" x-text="t('solarArray')"></span>
                                <span class="solar-calc__result-value is-orange" x-text="res.panels + ' kW'"></span>
                                <span class="solar-calc__result-sub" x-text="res.panelCount + ' ' + t('panels') + ' (' + panelWatts + 'W ' + t('each') + ')'"></span>
                            </div>
                            <span class="solar-calc__result-icon is-orange"><i class="fa-solid fa-sun"></i></span>
                        </div>

                        <div class="solar-calc__stats">
                            <div><span x-text="t('peakLoad')"></span><strong><span x-text="formatNumber(res.totalPeak)"></span> <small>W</small></strong></div>
                            <div><span x-text="t('dailyEnergy')"></span><strong><span x-text="res.dailyEnergy"></span> <small>kWh</small></strong></div>
                        </div>

                        <h6 class="solar-calc__cost-title" x-text="t('costEstimate')"></h6>
                        <div class="solar-calc__cost" x-show="isSolarEnabled">
                            <span><span x-text="t('solarPanels')"></span> <small x-text="'(' + rates.solarPerW + ' ৳/W)'"></small></span>
                            <strong x-text="formatCost(cost.solar)"></strong>
                        </div>
                        <div class="solar-calc__cost">
                            <span><span x-text="t('batteryBankCost')"></span> <small x-text="'(' + formatNumber(rates.battPerKwh) + ' ৳/kWh)'"></small></span>
                            <strong x-text="formatCost(cost.battery)"></strong>
                        </div>
                        <div class="solar-calc__cost">
                            <span><span x-text="t('inverterAcc')"></span> <small x-text="'(' + formatNumber(rates.inverterPerKw) + ' ৳/kW)'"></small></span>
                            <strong x-text="formatCost(cost.inverter)"></strong>
                        </div>
                        <div class="solar-calc__cost" x-show="res.ccAmps > 0">
                            <span><span x-text="t('chargeController')"></span> <small x-text="'(' + res.ccAmps + 'A · ' + res.ccCount + ' ' + (res.ccCount > 1 ? t('unitsShort') : t('unit')) + ')'"></small></span>
                            <strong x-text="formatCost(cost.chargeController)"></strong>
                        </div>
                        <div class="solar-calc__total">
                            <span x-text="t('totalEstCost')"></span>
                            <strong x-text="formatCost(cost.total)"></strong>
                        </div>
                        @if($calculator['approx_note'])
                        <p class="solar-calc__note"><i class="fa-solid fa-circle-info"></i> {{ $calculator['approx_note'] }}</p>
                        @endif

                        <div class="solar-calc__actions">
                            <button type="button" x-on:click="openSave()"><i class="fa-solid fa-floppy-disk"></i> <span x-text="t('save')"></span></button>
                            <button type="button" x-on:click="openLoad()"><i class="fa-solid fa-clock-rotate-left"></i> <span x-text="t('saved')"></span></button>
                            <button type="button" x-on:click="shareConfig()"><i class="fa-solid" x-bind:class="shareFeedback ? 'fa-check' : 'fa-share-nodes'"></i> <span x-text="shareFeedback || t('share')"></span></button>
                            <button type="button" x-on:click="resetSystem()"><i class="fa-solid fa-rotate-left"></i> <span x-text="t('reset')"></span></button>
                        </div>
                        <a class="btn-one solar-calc__quote" x-bind:href="quoteLink()" href="{{ route('contact') }}"><span x-text="t('getQuote')">Get a Quote for This System</span></a>
                        <p class="solar-calc__notice" role="status" x-show="notice" x-text="notice" x-cloak></p>
                    </div>

                    <div class="solar-calc__warnings">
                        <div class="solar-calc__warning is-info" x-show="res.totalPeak === 0" x-cloak>
                            <i class="fa-solid fa-circle-info"></i><span x-text="t('warnNoLoad')"></span>
                        </div>
                        <div class="solar-calc__warning is-caution" x-show="hasSurgingLoads()" x-cloak>
                            <i class="fa-solid fa-triangle-exclamation"></i><span><strong x-text="t('warnSurge')"></strong> <span x-text="t('warnSurgeNote')"></span></span>
                        </div>
                        <div class="solar-calc__warning is-info" x-show="systemType === 'pwm'" x-cloak>
                            <i class="fa-solid fa-microchip"></i><span x-text="t('warnPWM')"></span>
                        </div>
                        <div class="solar-calc__warning is-info" x-show="systemType === 'hybrid'" x-cloak>
                            <i class="fa-solid fa-layer-group"></i><span x-text="t('warnHybrid')"></span>
                        </div>
                        <div class="solar-calc__warning is-info" x-show="!isSolarEnabled" x-cloak>
                            <i class="fa-solid fa-plug"></i><span x-text="t('warnNoSolar')"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Save modal -->
    <div class="solar-calc__modal" x-show="saveModalOpen" x-cloak x-transition.opacity x-on:click.self="saveModalOpen = false" role="dialog" aria-modal="true" aria-labelledby="sc-save-title">
        <div class="solar-calc__modal-box">
            <div class="solar-calc__modal-head">
                <h5 id="sc-save-title" x-text="t('saveConfigTitle')"></h5>
                <button type="button" class="solar-calc__modal-close" x-on:click="saveModalOpen = false" x-bind:aria-label="t('close')"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="solar-calc__summary">
                <strong x-text="t('saveSummaryTitle')"></strong>
                <span x-text="t('rowInverter') + ': ' + res.inverter + ' kW · ' + t('rowBattery') + ': ' + res.battery + ' kWh · ' + t('rowSolar') + ': ' + res.panels + ' kW'"></span>
                <span x-text="t('estCost') + ': ' + formatCost(cost.total)"></span>
                <strong x-text="t('saveSummaryPrefs')"></strong>
                <span x-text="t('sun') + ': ' + sun + 'h · ' + t('autonomy') + ': ' + autonomy + 'h · ' + t('voltageLbl') + ': ' + voltage + 'V'"></span>
                <strong x-text="t('saveSummaryActive')"></strong>
                <template x-if="activeAppliances().length === 0"><span x-text="t('noneSelected')"></span></template>
                <template x-for="line in activeAppliances()" x-bind:key="line"><span x-text="'• ' + line"></span></template>
            </div>
            <form x-on:submit.prevent="saveConfiguration()" novalidate>
                <label class="solar-calc__control-label" for="sc-config-name" x-text="t('configNameLabel')"></label>
                <input type="text" id="sc-config-name" class="solar-calc__input" maxlength="80" x-model="newConfigName" x-on:input="saveError = ''"
                       x-bind:placeholder="t('configNamePlaceholder')" x-bind:aria-invalid="saveError ? 'true' : 'false'">
                <p class="solar-calc__error" role="alert" x-show="saveError" x-text="saveError"></p>
                <div class="solar-calc__modal-foot">
                    <button type="button" class="solar-calc__btn-light" x-on:click="saveModalOpen = false" x-text="t('cancel')"></button>
                    <button type="submit" class="btn-one"><span x-text="t('saveSettingBtn')"></span></button>
                </div>
            </form>
        </div>
    </div>

    <!-- Saved configurations modal -->
    <div class="solar-calc__modal" x-show="loadModalOpen" x-cloak x-transition.opacity x-on:click.self="loadModalOpen = false" role="dialog" aria-modal="true" aria-labelledby="sc-load-title">
        <div class="solar-calc__modal-box">
            <div class="solar-calc__modal-head">
                <h5 id="sc-load-title" x-text="t('savedConfigsTitle')"></h5>
                <button type="button" class="solar-calc__modal-close" x-on:click="loadModalOpen = false" x-bind:aria-label="t('close')"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <p class="solar-calc__empty" x-show="savedConfigs.length === 0"><i class="fa-solid fa-folder-open"></i><span x-text="t('noConfigs')"></span></p>
            <div class="solar-calc__configs">
                <template x-for="c in savedConfigs" x-bind:key="c.id">
                    <div class="solar-calc__config">
                        <button type="button" class="solar-calc__config-load" x-on:click="loadConfig(c)">
                            <strong x-text="c.name"></strong>
                            <span x-text="c.date + ' · ' + t('inv') + ': ' + c.summary.inverter + ' · ' + t('pv') + ': ' + c.summary.pv + ' · ' + (c.summary.cost || '')"></span>
                        </button>
                        <button type="button" class="solar-calc__config-delete" x-on:click="deleteConfig(c)" x-bind:aria-label="t('remove') + ' ' + c.name"><i class="fa-solid fa-trash-can"></i></button>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
<!-- Solar Calculator Area End -->

@include('frontend.partials.page-cta', ['page' => 'solar-calculator'])
@endsection

@push('scripts')
<script>
    window.SOLAR_CALCULATOR = {
        rates: @json($rates),
        quoteUrl: @json(route('contact'))
    };
</script>
<script src="{{ asset('js/solar-calculator.js') }}?v={{ filemtime(public_path('js/solar-calculator.js')) }}"></script>
<script defer src="{{ asset('js/vendor/alpine-3.14.1.min.js') }}"></script>
@endpush
