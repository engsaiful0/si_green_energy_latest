/*
 * Si Green Energy - Solar Calculator (Alpine.js component).
 *
 * Sizes an off-grid / hybrid solar system from the appliance load and gives an approximate
 * cost in BDT. Formulas:
 *   Peak load (W)        = sum(qty x watts)
 *   Daily energy (kWh)   = sum(qty x watts x hours) / 1000
 *   Inverter (kW)        = ceil(peak load x 1.25 / 1000)                    (25% surge headroom)
 *   Storage needed (kWh) = daily kWh x (backup hours / 24) / DoD x battery factor
 *   Battery units        = ceil(storage / (Ah x V / 1000))
 *   Effective sun (h)    = peak sun hours x efficiency x MPPT bonus
 *   Solar array (kW)     = daily kWh / effective sun x solar factor
 *   Panels               = ceil(array W / panel W)
 *   Charge controller(A) = ceil(array W / battery V x 1.25), max 60 A per unit
 *   Cost                 = whole panels x BDT/W + whole batteries x BDT/kWh
 *                          + inverter kW x BDT/kW + controller A x BDT/A
 * Cost rates come from the page CMS (window.SOLAR_CALCULATOR.rates).
 */
(function () {
    'use strict';

    var CONFIG = window.SOLAR_CALCULATOR || {};

    var COST_RATES = CONFIG.rates || {
        solar: { mono: 22, poly: 28 },
        battery: { 'lead-acid': 10000, lifepo4: 25000 },
        inverter: { pwm: 10000, mppt: 13000, hybrid: 20000 },
        chargeController: { pwm: 45, mppt: 80, hybrid: 0 }
    };

    // Usable depth of discharge per battery chemistry.
    var DOD_MAP = { 'lead-acid': 0.5, lifepo4: 0.85 };
    // Battery storage factor per controller type.
    var SYSTEM_BATTERY_FACTOR = { pwm: 1.0, mppt: 1.0, hybrid: 1.0 };
    // Solar array sizing factor per controller type (MPPT needs a smaller array).
    var SYSTEM_SOLAR_FACTOR = { pwm: 1.0, mppt: 0.9, hybrid: 1.0 };
    // Extra harvest from MPPT tracking.
    var MPPT_EFFICIENCY_BONUS = { pwm: 1.0, mppt: 1.15, hybrid: 1.1 };
    // Largest standard charge controller (A per unit).
    var MAX_CC_AMPS = 60;

    var PANEL_SIZES = [250, 300, 400, 500, 600];
    var BATTERY_SIZES = {
        12: [20, 40, 50, 75, 100, 120, 150, 180, 200, 220, 250],
        24: [50, 100, 150, 200, 250, 300],
        48: [50, 100, 150, 200, 280, 300]
    };

    var DEFAULTS = {
        autonomy: 8,        // hours of battery-only backup
        sun: 4.5,           // peak sun hours per day
        voltage: 12,        // battery bank voltage
        battAh: 100,        // Ah per battery unit
        systemType: 'mppt',
        panelType: 'mono',
        batteryType: 'lifepo4',
        panelWatts: 500,
        sysEfficiency: 75,  // % (wiring, dust and heat losses)
        isSolarEnabled: true
    };

    var LIMITS = { qtyMax: 99, hoursMax: 24, autonomyMin: 1, autonomyMax: 72, sunMin: 2, sunMax: 7 };

    var APPLIANCES = [
        { id: 'light', name: 'LED Lights', name_bn: 'এলইডি লাইট', icon: 'fa-lightbulb', color: 'ic-yellow', watts: 20, defaultQty: 4, hours: 3, category: 'common' },
        { id: 'fan', name: 'Ceiling Fan', name_bn: 'সিলিং ফ্যান', icon: 'fa-fan', color: 'ic-sky', watts: 75, defaultQty: 4, hours: 3, category: 'common' },
        // 150 W average draw reflects the compressor duty cycle.
        { id: 'fridge', name: 'Refrigerator', name_bn: 'রেফ্রিজারেটর', icon: 'fa-icicles', color: 'ic-teal', watts: 150, defaultQty: 1, hours: 3, category: 'common' },
        { id: 'router', name: 'WiFi Router', name_bn: 'ওয়াইফাই রাউটার', icon: 'fa-wifi', color: 'ic-blue', watts: 15, defaultQty: 1, hours: 3, category: 'common' },
        { id: 'laptop', name: 'Laptop / PC', name_bn: 'ল্যাপটপ / পিসি', icon: 'fa-laptop', color: 'ic-violet', watts: 100, defaultQty: 1, hours: 3, category: 'common' },
        { id: 'washing', name: 'Washing Machine', name_bn: 'ওয়াশিং মেশিন', icon: 'fa-shirt', color: 'ic-cyan', watts: 500, defaultQty: 0, hours: 3, category: 'other', hasSurge: true },
        { id: 'oven', name: 'Microwave Oven', name_bn: 'মাইক্রোওয়েভ ওভেন', icon: 'fa-utensils', color: 'ic-orange', watts: 1200, defaultQty: 0, hours: 0.3, category: 'other' },
        { id: 'induction', name: 'Induction Cooker', name_bn: 'ইন্ডাকশন কুকার', icon: 'fa-fire', color: 'ic-red', watts: 1500, defaultQty: 0, hours: 3, category: 'other' },
        { id: 'motor', name: 'Water Pump', name_bn: 'ওয়াটার পাম্প', icon: 'fa-water', color: 'ic-green', watts: 1000, defaultQty: 0, hours: 3, category: 'other', hasSurge: true },
        { id: 'ac', name: 'Air Conditioner', name_bn: 'এয়ার কন্ডিশনার', icon: 'fa-snowflake', color: 'ic-pink', watts: 1800, defaultQty: 0, hours: 3, category: 'other', hasSurge: true }
    ];

    var TRANSLATIONS = {
        en: {
            appliancesTitle: 'Daily Appliances & Load',
            appliancesDesc: 'Set the quantity and daily usage hours of each device',
            otherAppliances: 'Other Appliances',
            showOther: 'Show Other Appliances',
            hideOther: 'Hide Other Appliances',
            qty: 'Qty',
            hoursPerDay: 'Hours / Day',
            wPerUnit: 'W per unit',
            totalWatts: 'W total',
            decrease: 'Decrease',
            increase: 'Increase',
            prefsTitle: 'System Preferences',
            prefsDesc: 'Fine-tune battery, solar and inverter parameters',
            sectionGeneral: 'General',
            sectionSolar: 'Solar Panel',
            sectionBattery: 'Battery',
            sectionInverter: 'Inverter & Controller',
            backupDuration: 'Backup Duration',
            backupHint: 'Battery-only running time without solar (night / cloudy weather)',
            peakSunHours: 'Peak Sun Hours',
            peakSunHint: 'Average daily full-sun hours at your location',
            enableSolar: 'Solar Panels',
            enabled: 'Enabled',
            disabled: 'Disabled',
            solarToggleHint: 'Turn off if you only want grid charging (IPS)',
            panelType: 'Panel Type',
            panelHint: 'Affects the panel cost per watt',
            panelStandard: 'Standard',
            panelMono: '(Monocrystalline)',
            panelPremium: 'Premium',
            panelPoly: '(Polycrystalline)',
            panelWatts: 'Panel Size',
            panelWattsHint: 'Rated wattage of each panel',
            batteryType: 'Battery Type',
            batteryHint: 'Affects the battery cost per kWh',
            leadAcid: 'Lead Acid',
            leadAcidSub: '(50% DoD)',
            lifepo4: 'LiFePO4',
            lifepo4Sub: '(85% DoD)',
            batteryBank: 'Battery Bank',
            batteryBankHint: 'Voltage and capacity of each battery unit',
            systemType: 'Controller Type',
            pwm: 'PWM',
            mppt: 'MPPT',
            hybridInverter: 'Hybrid Inverter',
            chargeControllerSub: 'Charge Controller',
            hybridSub: 'Inverter + Controller',
            systemTypeLabels: { pwm: 'PWM Charge Controller', mppt: 'MPPT Charge Controller', hybrid: 'Hybrid Inverter' },
            systemTypeHints: {
                pwm: 'Budget-friendly PWM controller: simple and reliable, best for small systems',
                mppt: 'High-efficiency MPPT controller: harvests about 15% more power from the panels',
                hybrid: 'All-in-one hybrid inverter with built-in MPPT, battery management and grid support'
            },
            loadBreakdownTitle: 'Load Breakdown',
            loadBreakdownDesc: 'Daily energy use of each appliance',
            compareTitle: 'Compare System Types',
            compareDesc: 'The same load with all three controller types',
            showCompare: 'Show Comparison',
            hideCompare: 'Hide Comparison',
            rowInverter: 'Inverter',
            rowBattery: 'Battery',
            rowSolar: 'Solar',
            rowCost: 'Est. Cost',
            quickInfo: 'How It Is Calculated',
            quickInfoItems: [
                'Battery Ah = <code>(kWh × 1000) / Voltage</code>, so you can plan the battery bank.',
                'The inverter includes 25% surge headroom above the peak load.',
                'Lead acid is limited to 50% depth of discharge, LiFePO4 to 85%.',
                'System efficiency (75%) allows for heat, dust and wiring losses.'
            ],
            systemSummary: 'System Summary',
            inverterSize: 'Inverter Size',
            storageNeeded: 'Storage Needed',
            solarArray: 'Solar Array',
            units: 'units',
            panels: 'panels',
            each: 'each',
            peakLoad: 'Peak Load',
            dailyEnergy: 'Daily Energy',
            costEstimate: 'Cost Estimate',
            solarPanels: 'Solar Panels',
            batteryBankCost: 'Battery Bank',
            inverterAcc: 'Inverter / Acc.',
            chargeController: 'Charge Controller',
            unit: 'unit',
            unitsShort: 'units',
            totalEstCost: 'Total Est. Cost',
            save: 'Save',
            saved: 'Saved',
            share: 'Share',
            shareCopied: 'Copied!',
            reset: 'Reset',
            getQuote: 'Get a Quote for This System',
            warnNoLoad: 'No appliances selected. Add devices to get a calculation.',
            warnSurge: 'Motor loads detected.',
            warnSurgeNote: 'Pumps, ACs and washing machines draw 3-6x their rated watts when starting. Make sure the inverter can handle the surge current.',
            warnPWM: 'PWM controllers are less efficient with higher-voltage panels. Best paired with 12V-24V systems.',
            warnHybrid: 'The hybrid inverter includes a built-in MPPT charge controller and grid support.',
            warnNoSolar: 'Solar is disabled: the battery is charged from the grid only (IPS).',
            saveConfigTitle: 'Save Configuration',
            saveSummaryTitle: 'System Requirements',
            saveSummaryPrefs: 'Preferences',
            saveSummaryActive: 'Active Appliances',
            noneSelected: 'None selected',
            configNameLabel: 'Configuration Name',
            configNamePlaceholder: 'e.g. My Home',
            saveSettingBtn: 'Save Setting',
            cancel: 'Cancel',
            close: 'Close',
            savedConfigsTitle: 'Saved Configurations',
            noConfigs: 'No saved configurations yet.',
            load: 'Load',
            remove: 'Delete',
            inv: 'Inv',
            pv: 'PV',
            errName: 'Please enter a name for the configuration.',
            errNameLong: 'The name may not be longer than 60 characters.',
            errStorage: 'Your browser blocked local storage, so configurations cannot be saved here.',
            errQty: 'Quantity must be a whole number from 0 to 99.',
            errHours: 'Hours must be between 0 and 24.',
            savedOk: 'Configuration saved.',
            shareFailed: 'Copy failed. Please select and copy the summary manually.',
            sun: 'Sun',
            autonomy: 'Backup',
            voltageLbl: 'Voltage',
            estCost: 'Est. Cost'
        },
        bn: {
            appliancesTitle: 'দৈনিক যন্ত্রপাতি ও লোড',
            appliancesDesc: 'প্রতিটি ডিভাইসের সংখ্যা ও দৈনিক ব্যবহারের সময় নির্ধারণ করুন',
            otherAppliances: 'অন্যান্য যন্ত্রপাতি',
            showOther: 'অন্যান্য যন্ত্রপাতি দেখান',
            hideOther: 'অন্যান্য যন্ত্রপাতি লুকান',
            qty: 'সংখ্যা',
            hoursPerDay: 'ঘণ্টা / দিন',
            wPerUnit: 'ওয়াট / ইউনিট',
            totalWatts: 'W মোট',
            decrease: 'কমান',
            increase: 'বাড়ান',
            prefsTitle: 'সিস্টেম পছন্দ',
            prefsDesc: 'ব্যাটারি, সোলার ও ইনভার্টার প্যারামিটার ঠিক করুন',
            sectionGeneral: 'সাধারণ',
            sectionSolar: 'সোলার প্যানেল',
            sectionBattery: 'ব্যাটারি',
            sectionInverter: 'ইনভার্টার ও কন্ট্রোলার',
            backupDuration: 'ব্যাকআপ সময়',
            backupHint: 'সোলার ছাড়া শুধু ব্যাটারিতে চলার সময় (রাত / মেঘলা)',
            peakSunHours: 'পিক সূর্যালোক সময়',
            peakSunHint: 'আপনার এলাকার দৈনিক গড় পূর্ণ সূর্যালোক ঘণ্টা',
            enableSolar: 'সোলার প্যানেল',
            enabled: 'চালু',
            disabled: 'বন্ধ',
            solarToggleHint: 'শুধু গ্রিড চার্জিং (আইপিএস) চাইলে বন্ধ করুন',
            panelType: 'প্যানেলের ধরন',
            panelHint: 'প্রতি ওয়াট প্যানেলের খরচ প্রভাবিত করে',
            panelStandard: 'স্ট্যান্ডার্ড',
            panelMono: '(মনোক্রিস্টালাইন)',
            panelPremium: 'প্রিমিয়াম',
            panelPoly: '(পলিক্রিস্টালাইন)',
            panelWatts: 'প্যানেলের আকার',
            panelWattsHint: 'প্রতিটি প্যানেলের রেটেড ওয়াট',
            batteryType: 'ব্যাটারির ধরন',
            batteryHint: 'প্রতি kWh ব্যাটারির খরচ প্রভাবিত করে',
            leadAcid: 'লিড অ্যাসিড',
            leadAcidSub: '(৫০% DoD)',
            lifepo4: 'LiFePO4',
            lifepo4Sub: '(৮৫% DoD)',
            batteryBank: 'ব্যাটারি ব্যাংক',
            batteryBankHint: 'প্রতিটি ব্যাটারি ইউনিটের ভোল্টেজ ও ক্ষমতা',
            systemType: 'কন্ট্রোলারের ধরন',
            pwm: 'PWM',
            mppt: 'MPPT',
            hybridInverter: 'হাইব্রিড ইনভার্টার',
            chargeControllerSub: 'চার্জ কন্ট্রোলার',
            hybridSub: 'ইনভার্টার + কন্ট্রোলার',
            systemTypeLabels: { pwm: 'PWM চার্জ কন্ট্রোলার', mppt: 'MPPT চার্জ কন্ট্রোলার', hybrid: 'হাইব্রিড ইনভার্টার' },
            systemTypeHints: {
                pwm: 'সাশ্রয়ী PWM কন্ট্রোলার: সহজ ও নির্ভরযোগ্য, ছোট সিস্টেমের জন্য উপযুক্ত',
                mppt: 'উচ্চ দক্ষতার MPPT কন্ট্রোলার: প্যানেল থেকে প্রায় ১৫% বেশি শক্তি নেয়',
                hybrid: 'বিল্ট-ইন MPPT সহ হাইব্রিড ইনভার্টার: ব্যাটারি ম্যানেজমেন্ট ও গ্রিড সাপোর্ট একসাথে'
            },
            loadBreakdownTitle: 'লোড ব্রেকডাউন',
            loadBreakdownDesc: 'প্রতিটি যন্ত্রের দৈনিক শক্তি ব্যবহার',
            compareTitle: 'সিস্টেম তুলনা',
            compareDesc: 'একই লোডে তিন ধরনের কন্ট্রোলার',
            showCompare: 'তুলনা দেখান',
            hideCompare: 'তুলনা লুকান',
            rowInverter: 'ইনভার্টার',
            rowBattery: 'ব্যাটারি',
            rowSolar: 'সোলার',
            rowCost: 'আনু. খরচ',
            quickInfo: 'যেভাবে হিসাব করা হয়',
            quickInfoItems: [
                'ব্যাটারি Ah = <code>(kWh × ১০০০) / ভোল্টেজ</code>, যাতে ব্যাটারি ব্যাংক পরিকল্পনা করা যায়।',
                'ইনভার্টারে পিক লোডের উপরে ২৫% সার্জ হেডরুম ধরা হয়।',
                'লিড অ্যাসিড সর্বোচ্চ ৫০% DoD, LiFePO4 সর্বোচ্চ ৮৫% DoD।',
                'সিস্টেম দক্ষতা (৭৫%) তাপ, ধুলা ও তারের ক্ষতি হিসাব করে।'
            ],
            systemSummary: 'সিস্টেম সারসংক্ষেপ',
            inverterSize: 'ইনভার্টারের আকার',
            storageNeeded: 'প্রয়োজনীয় স্টোরেজ',
            solarArray: 'সোলার অ্যারে',
            units: 'ইউনিট',
            panels: 'প্যানেল',
            each: 'প্রতিটি',
            peakLoad: 'পিক লোড',
            dailyEnergy: 'দৈনিক শক্তি',
            costEstimate: 'খরচের অনুমান',
            solarPanels: 'সোলার প্যানেল',
            batteryBankCost: 'ব্যাটারি ব্যাংক',
            inverterAcc: 'ইনভার্টার / আনুষঙ্গিক',
            chargeController: 'চার্জ কন্ট্রোলার',
            unit: 'ইউনিট',
            unitsShort: 'ইউনিট',
            totalEstCost: 'মোট আনুমানিক খরচ',
            save: 'সংরক্ষণ',
            saved: 'সংরক্ষিত',
            share: 'শেয়ার',
            shareCopied: 'কপি হয়েছে!',
            reset: 'রিসেট',
            getQuote: 'এই সিস্টেমের কোটেশন নিন',
            warnNoLoad: 'কোনো যন্ত্র নির্বাচন করা হয়নি। হিসাব পেতে ডিভাইস যোগ করুন।',
            warnSurge: 'মোটর লোড শনাক্ত হয়েছে।',
            warnSurgeNote: 'পাম্প, এসি ও ওয়াশিং মেশিন চালু হওয়ার সময় রেটেড ওয়াটের ৩-৬ গুণ টানে। ইনভার্টারের সার্জ ক্ষমতা নিশ্চিত করুন।',
            warnPWM: 'PWM কন্ট্রোলার উচ্চ ভোল্টেজ প্যানেলে কম কার্যকর। ১২V-২৪V সিস্টেমের জন্য উপযুক্ত।',
            warnHybrid: 'হাইব্রিড ইনভার্টারে বিল্ট-ইন MPPT চার্জ কন্ট্রোলার ও গ্রিড সাপোর্ট রয়েছে।',
            warnNoSolar: 'সোলার বন্ধ: ব্যাটারি শুধু গ্রিড থেকে চার্জ হবে (আইপিএস)।',
            saveConfigTitle: 'কনফিগারেশন সংরক্ষণ',
            saveSummaryTitle: 'সিস্টেম প্রয়োজনীয়তা',
            saveSummaryPrefs: 'পছন্দ',
            saveSummaryActive: 'সক্রিয় যন্ত্রপাতি',
            noneSelected: 'কিছু নির্বাচন করা হয়নি',
            configNameLabel: 'কনফিগারেশনের নাম',
            configNamePlaceholder: 'যেমন: আমার বাসা',
            saveSettingBtn: 'সংরক্ষণ করুন',
            cancel: 'বাতিল',
            close: 'বন্ধ করুন',
            savedConfigsTitle: 'সংরক্ষিত কনফিগারেশন',
            noConfigs: 'এখনো কোনো কনফিগারেশন সংরক্ষণ করা হয়নি।',
            load: 'লোড',
            remove: 'মুছুন',
            inv: 'ইনভা',
            pv: 'পিভি',
            errName: 'কনফিগারেশনের একটি নাম লিখুন।',
            errNameLong: 'নাম ৬০ অক্ষরের বেশি হতে পারবে না।',
            errStorage: 'আপনার ব্রাউজার লোকাল স্টোরেজ বন্ধ রেখেছে, তাই এখানে সংরক্ষণ করা যাচ্ছে না।',
            errQty: 'সংখ্যা ০ থেকে ৯৯ এর মধ্যে পূর্ণসংখ্যা হতে হবে।',
            errHours: 'ঘণ্টা ০ থেকে ২৪ এর মধ্যে হতে হবে।',
            savedOk: 'কনফিগারেশন সংরক্ষিত হয়েছে।',
            shareFailed: 'কপি করা যায়নি। সারসংক্ষেপটি নিজে কপি করুন।',
            sun: 'সূর্যালোক',
            autonomy: 'ব্যাকআপ',
            voltageLbl: 'ভোল্টেজ',
            estCost: 'আনু. খরচ'
        }
    };

    var STORAGE = { last: 'sgeSolarCalc.last', saved: 'sgeSolarCalc.saved', lang: 'sgeSolarCalc.lang' };

    function storageGet(key) {
        try { return window.localStorage.getItem(key); } catch (e) { return null; }
    }

    function storageSet(key, value) {
        try { window.localStorage.setItem(key, value); return true; } catch (e) { return false; }
    }

    function clamp(value, min, max) {
        return Math.min(max, Math.max(min, value));
    }

    function defaultState() {
        var state = {};
        APPLIANCES.forEach(function (app) {
            state[app.id] = { qty: app.defaultQty, hours: app.hours };
        });
        return state;
    }

    /**
     * Pure sizing + cost calculation (also used by the comparison table and the tests in the browser console).
     */
    function size(input, sysType) {
        var totalPeakWatts = 0;
        var dailyWattHours = 0;

        APPLIANCES.forEach(function (app) {
            var s = input.state[app.id];
            totalPeakWatts += s.qty * app.watts;
            dailyWattHours += s.qty * app.watts * s.hours;
        });

        var dailyKwh = dailyWattHours / 1000;
        var autonomyDays = input.autonomy / 24;
        var dod = DOD_MAP[input.batteryType];
        var effectiveSun = input.sun * (input.sysEfficiency / 100) * MPPT_EFFICIENCY_BONUS[sysType];
        var solarOn = input.isSolarEnabled && effectiveSun > 0;

        // Inverter: peak load + 25% surge headroom, rounded up to whole kW.
        var inverterKw = Math.ceil((totalPeakWatts * 1.25) / 1000);

        // Battery: backup share of the daily energy / depth of discharge.
        var storageNeeded = ((dailyKwh * autonomyDays) / dod) * SYSTEM_BATTERY_FACTOR[sysType];
        var battUnitKwh = (input.battAh * input.voltage) / 1000;
        var totalAhNeeded = storageNeeded > 0 ? (storageNeeded * 1000) / input.voltage : 0;
        var battCount = storageNeeded > 0 ? Math.ceil(storageNeeded / battUnitKwh) : 0;

        // Solar array: daily energy / effective sun hours.
        var pvArrayKw = solarOn ? (dailyKwh / effectiveSun) * SYSTEM_SOLAR_FACTOR[sysType] : 0;
        var panelCount = input.isSolarEnabled ? Math.ceil((pvArrayKw * 1000) / input.panelWatts) : 0;

        // Charge controller: array current at battery voltage + 25% safety margin.
        var ccAmps = solarOn ? Math.ceil(((pvArrayKw * 1000) / input.voltage) * 1.25) : 0;
        var ccCount = Math.ceil(ccAmps / MAX_CC_AMPS) || (pvArrayKw > 0 ? 1 : 0);

        var rates = {
            solarPerW: COST_RATES.solar[input.panelType],
            battPerKwh: COST_RATES.battery[input.batteryType],
            inverterPerKw: COST_RATES.inverter[sysType],
            ccPerAmp: COST_RATES.chargeController[sysType]
        };

        // Cost of what is actually bought: whole panels and whole battery units.
        var cost = {
            solar: panelCount * input.panelWatts * rates.solarPerW,
            battery: battCount * battUnitKwh * rates.battPerKwh,
            inverter: inverterKw * rates.inverterPerKw,
            chargeController: ccAmps * rates.ccPerAmp
        };
        cost.total = cost.solar + cost.battery + cost.inverter + cost.chargeController;

        return {
            res: {
                inverter: inverterKw,
                battery: storageNeeded.toFixed(1),
                battAh: Math.round(totalAhNeeded),
                battCount: battCount,
                panels: pvArrayKw.toFixed(2),
                panelCount: panelCount,
                totalPeak: totalPeakWatts,
                dailyEnergy: dailyKwh.toFixed(2),
                ccAmps: ccAmps,
                ccCount: ccCount
            },
            cost: cost,
            rates: rates
        };
    }

    window.SolarCalculatorSize = function (input, sysType) {
        return size(input, sysType || input.systemType);
    };

    window.solarCalculator = function () {
        return {
            appliances: APPLIANCES,
            commonAppliances: APPLIANCES.filter(function (a) { return a.category === 'common'; }),
            otherAppliances: APPLIANCES.filter(function (a) { return a.category === 'other'; }),
            PANEL_SIZES: PANEL_SIZES,
            VOLTAGES: [12, 24, 48],
            LIMITS: LIMITS,
            translations: TRANSLATIONS,
            quoteUrl: CONFIG.quoteUrl || '/contact',

            state: defaultState(),
            errors: {},
            voltage: DEFAULTS.voltage,
            battAh: DEFAULTS.battAh,
            autonomy: DEFAULTS.autonomy,
            sun: DEFAULTS.sun,
            panelWatts: DEFAULTS.panelWatts,
            sysEfficiency: DEFAULTS.sysEfficiency,
            systemType: DEFAULTS.systemType,
            panelType: DEFAULTS.panelType,
            batteryType: DEFAULTS.batteryType,
            isSolarEnabled: DEFAULTS.isSolarEnabled,

            lang: 'en',
            isOtherVisible: true,
            isCompareVisible: false,
            saveModalOpen: false,
            loadModalOpen: false,
            newConfigName: '',
            saveError: '',
            notice: '',
            savedConfigs: [],
            shareFeedback: '',

            res: { inverter: 0, battery: '0.0', battAh: 0, battCount: 0, panels: '0.00', panelCount: 0, totalPeak: 0, dailyEnergy: '0.00', ccAmps: 0, ccCount: 0 },
            cost: { solar: 0, battery: 0, inverter: 0, chargeController: 0, total: 0 },
            rates: { solarPerW: 0, battPerKwh: 0, inverterPerKw: 0, ccPerAmp: 0 },
            compareData: [],

            t: function (key) {
                var value = this.translations[this.lang][key];
                return value === undefined ? key : value;
            },

            toggleLang: function () {
                this.lang = this.lang === 'en' ? 'bn' : 'en';
                storageSet(STORAGE.lang, this.lang);
                if (this.isCompareVisible) { this.buildCompare(); }
            },

            appName: function (app) {
                return this.lang === 'bn' ? (app.name_bn || app.name) : app.name;
            },

            init: function () {
                var savedLang = storageGet(STORAGE.lang);
                if (savedLang === 'en' || savedLang === 'bn') { this.lang = savedLang; }

                var last = storageGet(STORAGE.last);
                if (last) {
                    try { this.applyConfig(JSON.parse(last)); } catch (e) { /* ignore a corrupt saved state */ }
                }
                this.calculate();
            },

            /** Applies a saved configuration, ignoring anything invalid. */
            applyConfig: function (cfg) {
                if (!cfg || typeof cfg !== 'object') { return; }
                var num = function (value, fallback, min, max) {
                    var n = parseFloat(value);
                    return isFinite(n) ? clamp(n, min, max) : fallback;
                };
                var pick = function (value, allowed, fallback) {
                    return allowed.indexOf(value) !== -1 ? value : fallback;
                };

                this.autonomy = Math.round(num(cfg.autonomy, DEFAULTS.autonomy, LIMITS.autonomyMin, LIMITS.autonomyMax));
                this.sun = Math.round(num(cfg.sun, DEFAULTS.sun, LIMITS.sunMin, LIMITS.sunMax) * 10) / 10;
                this.voltage = pick(parseInt(cfg.voltage, 10), [12, 24, 48], DEFAULTS.voltage);
                this.battAh = pick(parseInt(cfg.battAh, 10), BATTERY_SIZES[this.voltage], BATTERY_SIZES[this.voltage][4]);
                this.systemType = pick(cfg.systemType, ['pwm', 'mppt', 'hybrid'], DEFAULTS.systemType);
                this.panelType = pick(cfg.panelType, ['mono', 'poly'], DEFAULTS.panelType);
                this.batteryType = pick(cfg.batteryType, ['lead-acid', 'lifepo4'], DEFAULTS.batteryType);
                this.isSolarEnabled = cfg.isSolarEnabled === undefined ? DEFAULTS.isSolarEnabled : !!cfg.isSolarEnabled;
                this.panelWatts = pick(parseInt(cfg.panelWatts, 10), PANEL_SIZES, DEFAULTS.panelWatts);
                this.sysEfficiency = num(cfg.sysEfficiency, DEFAULTS.sysEfficiency, 60, 95);

                if (cfg.state && typeof cfg.state === 'object') {
                    var self = this;
                    APPLIANCES.forEach(function (app) {
                        var s = cfg.state[app.id];
                        if (s) {
                            self.state[app.id] = {
                                qty: Math.round(num(s.qty, app.defaultQty, 0, LIMITS.qtyMax)),
                                hours: Math.round(num(s.hours, app.hours, 0, LIMITS.hoursMax) * 10) / 10
                            };
                        }
                    });
                }
                this.errors = {};
            },

            currentConfig: function () {
                return {
                    state: JSON.parse(JSON.stringify(this.state)),
                    autonomy: this.autonomy,
                    sun: this.sun,
                    voltage: this.voltage,
                    battAh: this.battAh,
                    systemType: this.systemType,
                    panelType: this.panelType,
                    batteryType: this.batteryType,
                    isSolarEnabled: this.isSolarEnabled,
                    panelWatts: this.panelWatts,
                    sysEfficiency: this.sysEfficiency
                };
            },

            resetSystem: function () {
                this.applyConfig(Object.assign({}, DEFAULTS, { state: defaultState() }));
                this.state = defaultState();
                this.calculate();
            },

            battCapKwh: function () {
                return (this.battAh * this.voltage) / 1000;
            },

            /**
             * Ah choices for the selected voltage: sizes up to the first unit that alone covers
             * the storage needed (bigger single units are not useful), plus the current choice.
             */
            availableBattAh: function () {
                var sizes = BATTERY_SIZES[this.voltage] || [];
                var needed = parseFloat(this.res.battery) || 0;
                if (needed <= 0) { return sizes; }

                var result = [];
                for (var i = 0; i < sizes.length; i++) {
                    result.push(sizes[i]);
                    if ((sizes[i] * this.voltage) / 1000 > needed) { break; }
                }
                if (sizes.indexOf(this.battAh) !== -1 && result.indexOf(this.battAh) === -1) {
                    result.push(this.battAh);
                    result.sort(function (a, b) { return a - b; });
                }
                return result.length ? result : sizes;
            },

            setVoltage: function (v) {
                this.voltage = v;
                var presets = BATTERY_SIZES[v];
                if (presets.indexOf(this.battAh) === -1) {
                    this.battAh = presets[Math.floor(presets.length / 2)];
                }
                this.calculate();
                // Keep the current Ah if it is still offered, otherwise take the largest useful one.
                var available = this.availableBattAh();
                if (available.length && available.indexOf(this.battAh) === -1) {
                    this.battAh = available[available.length - 1];
                    this.calculate();
                }
            },

            setOption: function (key, value) {
                this[key] = value;
                this.calculate();
            },

            updateQty: function (id, delta) {
                this.setQty(id, (parseInt(this.state[id].qty, 10) || 0) + delta);
            },

            /** Validates a typed quantity: whole number 0-99. */
            setError: function (key, message) {
                var next = Object.assign({}, this.errors);
                if (message) { next[key] = message; } else { delete next[key]; }
                this.errors = next;
            },

            setQty: function (id, raw) {
                var text = String(raw).trim();
                var n = Number(text);
                if (text === '' || !isFinite(n) || n < 0 || n > LIMITS.qtyMax || Math.floor(n) !== n) {
                    this.setError(id, this.t('errQty'));
                    if (text !== '' && isFinite(n)) {
                        this.state[id].qty = clamp(Math.round(n), 0, LIMITS.qtyMax);
                        this.calculate();
                    }
                    return;
                }
                this.setError(id, '');
                this.state[id].qty = n;
                this.calculate();
            },

            setHours: function (id, raw) {
                var n = parseFloat(raw);
                if (!isFinite(n) || n < 0 || n > LIMITS.hoursMax) {
                    this.setError(id + '_hours', this.t('errHours'));
                    return;
                }
                this.setError(id + '_hours', '');
                this.state[id].hours = n;
                this.calculate();
            },

            hasSurgingLoads: function () {
                var state = this.state;
                return APPLIANCES.some(function (app) { return app.hasSurge && state[app.id].qty > 0; });
            },

            appTotalWatts: function (app) {
                return this.state[app.id].qty * app.watts;
            },

            loadBreakdown: function () {
                var totalKwh = parseFloat(this.res.dailyEnergy) || 0;
                if (totalKwh === 0) { return []; }
                var self = this;
                return APPLIANCES
                    .filter(function (app) { return self.state[app.id].qty > 0 && self.state[app.id].hours > 0; })
                    .map(function (app) {
                        var s = self.state[app.id];
                        var kwh = (s.qty * app.watts * s.hours) / 1000;
                        return { id: app.id, name: self.appName(app), color: app.color, kwh: kwh, pct: Math.round((kwh / totalKwh) * 100) };
                    })
                    .sort(function (a, b) { return b.kwh - a.kwh; });
            },

            buildCompare: function () {
                var self = this;
                var input = this.currentConfig();
                this.compareData = ['pwm', 'mppt', 'hybrid'].map(function (mode) {
                    var r = size(input, mode);
                    return {
                        mode: mode,
                        label: self.translations[self.lang].systemTypeLabels[mode],
                        inverter: r.res.inverter + ' kW',
                        battery: r.res.battery + ' kWh',
                        solar: r.res.panels + ' kW',
                        cost: self.formatCost(r.cost.total)
                    };
                });
            },

            toggleCompare: function () {
                this.isCompareVisible = !this.isCompareVisible;
                if (this.isCompareVisible) { this.buildCompare(); }
            },

            calculate: function () {
                var r = size(this.currentConfig(), this.systemType);
                this.res = r.res;
                this.cost = r.cost;
                this.rates = r.rates;
                if (this.isCompareVisible) { this.buildCompare(); }
                storageSet(STORAGE.last, JSON.stringify(this.currentConfig()));
            },

            formatCost: function (value) {
                return '৳ ' + Math.round(value || 0).toLocaleString('en-IN');
            },

            formatNumber: function (value) {
                return Number(value || 0).toLocaleString('en-IN');
            },

            systemTypeLabel: function () {
                return this.translations[this.lang].systemTypeLabels[this.systemType];
            },

            systemTypeHint: function () {
                return this.translations[this.lang].systemTypeHints[this.systemType];
            },

            activeAppliances: function () {
                var self = this;
                return APPLIANCES
                    .filter(function (app) { return self.state[app.id].qty > 0; })
                    .map(function (app) {
                        return self.appName(app) + ' ×' + self.state[app.id].qty + ' (' + self.state[app.id].hours + 'h/day)';
                    });
            },

            /** Plain-text summary used by Share and the quote request. */
            summaryText: function () {
                var lines = [
                    'Solar Calculator - Si Green Energy',
                    this.t('inverterSize') + ': ' + this.res.inverter + ' kW',
                    this.t('storageNeeded') + ': ' + this.res.battery + ' kWh (' + this.res.battAh + ' Ah @ ' + this.voltage + 'V, ' + this.res.battCount + ' x ' + this.battAh + ' Ah ' + this.t('units') + ')'
                ];
                if (this.isSolarEnabled) {
                    lines.push(this.t('solarArray') + ': ' + this.res.panels + ' kW (' + this.res.panelCount + ' x ' + this.panelWatts + 'W ' + this.t('panels') + ')');
                }
                lines.push(this.t('systemType') + ': ' + this.systemTypeLabel());
                lines.push(this.t('peakLoad') + ': ' + this.res.totalPeak + ' W, ' + this.t('dailyEnergy') + ': ' + this.res.dailyEnergy + ' kWh');
                lines.push(this.t('totalEstCost') + ': ' + this.formatCost(this.cost.total));
                lines.push('');
                lines.push(this.t('saveSummaryActive') + ':');
                var active = this.activeAppliances();
                return lines.concat(active.length ? active.map(function (l) { return '- ' + l; }) : [this.t('noneSelected')]).join('\n');
            },

            quoteLink: function () {
                var sep = this.quoteUrl.indexOf('?') === -1 ? '?' : '&';
                return this.quoteUrl + sep + 'subject=' + encodeURIComponent('Solar system quote request (Solar Calculator)') + '&message=' + encodeURIComponent(this.summaryText());
            },

            shareConfig: function () {
                var self = this;
                var text = this.summaryText();
                var done = function () {
                    self.shareFeedback = self.t('shareCopied');
                    setTimeout(function () { self.shareFeedback = ''; }, 2500);
                };
                var fail = function () {
                    self.notice = self.t('shareFailed');
                };

                if (navigator.share) {
                    navigator.share({ title: 'Solar Calculator - Si Green Energy', text: text, url: window.location.href }).catch(function () { /* cancelled */ });
                    return;
                }
                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(text).then(done, fail);
                    return;
                }
                // Fallback for plain-http pages.
                var area = document.createElement('textarea');
                area.value = text;
                area.setAttribute('readonly', '');
                area.style.position = 'fixed';
                area.style.opacity = '0';
                document.body.appendChild(area);
                area.select();
                try { document.execCommand('copy') ? done() : fail(); } catch (e) { fail(); }
                document.body.removeChild(area);
            },

            readSaved: function () {
                try {
                    var list = JSON.parse(storageGet(STORAGE.saved) || '[]');
                    return Array.isArray(list) ? list : [];
                } catch (e) {
                    return [];
                }
            },

            openSave: function () {
                this.newConfigName = '';
                this.saveError = '';
                this.saveModalOpen = true;
                var self = this;
                setTimeout(function () { var el = document.getElementById('sc-config-name'); if (el) { el.focus(); } }, 50);
            },

            openLoad: function () {
                this.savedConfigs = this.readSaved().reverse();
                this.loadModalOpen = true;
            },

            saveConfiguration: function () {
                var name = this.newConfigName.trim();
                if (!name) { this.saveError = this.t('errName'); return; }
                if (name.length > 60) { this.saveError = this.t('errNameLong'); return; }

                var list = this.readSaved();
                list.push({
                    id: Date.now(),
                    name: name,
                    date: new Date().toLocaleDateString(),
                    data: this.currentConfig(),
                    summary: {
                        inverter: this.res.inverter + ' kW',
                        storage: this.res.battery + ' kWh',
                        pv: this.res.panels + ' kW',
                        cost: this.formatCost(this.cost.total)
                    }
                });

                if (!storageSet(STORAGE.saved, JSON.stringify(list))) {
                    this.saveError = this.t('errStorage');
                    return;
                }
                this.saveModalOpen = false;
                this.flash(this.t('savedOk'));
            },

            loadConfig: function (config) {
                if (!config || !config.data) { return; }
                this.state = defaultState();
                this.applyConfig(config.data);
                this.calculate();
                this.loadModalOpen = false;
            },

            deleteConfig: function (config) {
                var list = this.readSaved().filter(function (c) { return c.id !== config.id; });
                storageSet(STORAGE.saved, JSON.stringify(list));
                this.savedConfigs = list.reverse();
            },

            flash: function (message) {
                var self = this;
                this.notice = message;
                setTimeout(function () { if (self.notice === message) { self.notice = ''; } }, 3000);
            },

            closeModals: function () {
                this.saveModalOpen = false;
                this.loadModalOpen = false;
            }
        };
    };
})();
