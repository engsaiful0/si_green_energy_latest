# Content Sources & Review Notes

This file records the references used to write the initial Si Green Energy website content. Admins can read it under **Admin › SEO & Settings › Content References**.

The initial content was seeded by `Database\Seeders\SiGreenEnergyContentSeeder` from `database/data/catalog.php` and `database/data/blog.php`. All of it is original text written for Si Green Energy, and all of it can be edited in the admin panel.

## Items to review before launch

- **Products are real manufacturer products** (24 products in 8 categories, seeded by `ProductCatalogSeeder` from `database/data/products.php`). Specifications include only values that the manufacturer's documents or several distributor copies of them agree on. Values can differ between datasheet revisions and regional variants, so confirm the exact model and current datasheet before quoting. The website does not claim that Si Green Energy is an authorised distributor of any brand; remove the products you do not supply.
- **Datasheet links.** Some datasheet links point to copies hosted by distributors, because the official PDF could not be confirmed. Replace them with official links where you have them (Admin › Products › Edit › Manufacturer).
- **Product images.** Manufacturer product photos were not reused (no permission). Electrical products use placeholder illustrations from `public/img/products`, and panels and mounting systems use licensed template photos. Replace them with photos you are allowed to use.
- **Gallery images are demonstration images.** The 20 gallery photos are licensed stock photographs from the website template, not Si Green Energy projects; each description says so. Replace them with your own project photos under Admin › Gallery Management.
- **Other photos** come from the licensed website template. Replace them over time with photos of Si Green Energy's own installations.
- **Projects, team members, testimonials and partner logos are empty on purpose.** The template's demo entries were fictional, so they were removed. Add real projects, staff profiles, customer feedback (with the customer's permission) and partner logos. Those sections appear automatically once records exist.
- **Statistics.** Use only figures you can verify, such as the number of completed projects or installed capacity. The current counters show only facts about the website's own content.
- **Net metering details.** The rules can change. Check the current guideline with SREDA and your distribution utility before updating the blog article.
- **Office hours and map.** Add opening hours in Contact Page CMS › Offices. The map currently searches for "East Bakalia Access Road, Chattogram". You can replace it with an exact Google Maps embed of the office.

## References

### Net metering and solar in Bangladesh
- Bangladesh Net Metering Guidelines 2018 (English translation, ESMAP RISE library): https://rise.esmap.org/data/files/library/bangladesh/Renewable%20Energy/Bangladesh_NET%20METERING%20GUIDELINES_2018.pdf
- UNDP Bangladesh, *Net Metering Guideline 2018*: https://www.undp.org/node/150296
- SREDA, National Solar Help Desk page: https://sreda.portal.gov.bd/pages/static-pages/6922dee1933eb65569e1e16b
- The Business Standard, *Net metering: Struggling to take off with trimmed wings*: https://www.tbsnews.net/node/93373
- EU Delegation, *Barriers and Opportunities of Rooftop Solar in Bangladesh* (2024): https://www.eeas.europa.eu/sites/default/files/documents/2024/Final%20Report-%20Barriers%20and%20Opportunities%20of%20Rooftop%20Solar-%202024.03.07.pdf
- IDCOL Solar Irrigation Program: https://idcol.org/idcol_new/public/renewable/solar-irrigation-program
- ESMAP, *IDCOL Solar Irrigation Program* presentation: https://www.esmap.org/sites/default/files/Presentations/IDCOL%20Solar%20Irrigation%20Program_Farzana%20Rahman.pdf

### Solar panel technology (PERC, TOPCon, bifacial)
- pv magazine, *TOPCon vs PERC*: https://www.pv-magazine.com/2022/01/20/topcon-vs-perc/
- PV Tech, *From PERC to TOPCon: Navigating the evolution of solar technology*: https://pv-tech.org/cea-on-perc-and-topcon-solar-technology

### Inverters
- Solar Power World, *Different types of solar inverters*: https://www.solarpowerworldonline.com/2016/05/different-types-solar-inverters/
- Clean Energy Reviews, *Solar Inverters Introduction*: https://www.cleanenergyreviews.info/solar-inverters
- Sinovoltaics, *Inverters: Main Technologies*: https://sinovoltaics.com/learning-center/inverters/inverters-main-technologies/

### Batteries (LiFePO4 vs lead-acid)
- PowMr, *Lead-acid vs LiFePO4 battery for solar*: https://powmr.com/blogs/news/lead-acid-vs-lifepo4-battery-for-solar
- SolaX Power, *LiFePO4 vs lead-acid battery*: https://www.solaxpower.com/blogs/lifepo4-vs-lead-acid-battery.html

Note: battery cycle-life and depth-of-discharge figures vary by product and test conditions, and most published comparisons come from manufacturers. For that reason the website content avoids specific numbers.

### Charge controllers (MPPT vs PWM)
- Renogy, *What is the difference between MPPT and PWM charge controllers*: https://www.renogy.com/es/blog/what-is-the-difference-between-mppt-and-pwm-charge-controllers/
- Goal Zero, *MPPT vs PWM charge controllers*: https://goalzero.com/blogs/news/what-the-tech-mppt-vs-pwm-charge-controllers

## Claims deliberately avoided

The content does not state specific savings, payback periods, returns on investment, efficiency percentages, warranty terms or current government policy limits. These depend on the project and on rules that change, so they should come from project-specific proposals and official sources.

### Real products (manufacturer and source URLs are also stored on each product)
- LONGi Hi-MO X6 Explorer LR5-72HTH: https://amaranzero.es/en/catalogue/solar/modules/110-0069-longi-lr5-72hth-575w-hi-mo-x6-expl-silver-f-mc4-1500v (power classes differ by variant; no official datasheet confirmed)
- JinkoSolar Tiger Neo 72HL4-(V): https://www.jinkosolar.com/uploads/JKM555-575N-72HL4-(V)-F1-CN.pdf
- Trina Solar Vertex N TSM-NEG19RC.20: https://solaroutlet.com.au/cdn/shop/files/Datasheet_Trina_tsm-neg19rc595-625w_EN.pdf (2024 global datasheet; earlier versions list 570–600 W)
- JA Solar DeepBlue 4.0 Pro JAM72D40: https://sun.store/en/product/ja-solar-jam72d40-585-mb-570-595-1500v-silver-frame-mc4-evo2a-40283 (no official datasheet confirmed)
- Growatt MIN 2500-6000TL-X: https://cdn.enf.com.cn/z/pp/2023/8/b517xdn7u5yuc7gn/MIN-2500-6000TL-X-Datasheet.pdf
- Huawei SUN2000-3-10KTL-M1: https://solar.huawei.com/pk/products/SUN2000-3-4-5-6-8-10KTL-M1/specs
- Sungrow SG2.0-6.0RS: https://info-support.sungrowpower.com/application/pdf/2022/12/03/SG2.0-6.0RS-UPTBR-Ver16-202211.pdf
- Pylontech US5000: https://www.portlandiaelectric.supply/pages/specs-us5000
- BYD Battery-Box Premium HVS: https://www.enfsolar.com/pv/storage-system-datasheet/16366
- Deye SE-G5.1 Pro-B: https://deye.com/product/se-g5-1-pro-b and https://deyeess.com/wp-content/uploads/2025/12/Datasheet_SE-G5.1-Pro-B-250918.pdf
- Deye SUN-5K-SG04LP1: https://trade-depot.s3.ap-southeast-2.amazonaws.com/files/products/manuals/SUN-3K-5K-SG04LP1-AU_Data_Sheet.pdf (regional versions differ)
- GoodWe ET series: https://cdn.shopify.com/s/files/1/0017/8847/7489/files/Goodwe-datasheet.pdf
- Growatt SPH 3000-6000TL BL-UP: https://www.solartraders.com/en/producers/growatt/sph-tl-bl-up
- Victron SmartSolar MPPT 100/30: https://www.victronenergy.fr/upload/documents/Datasheet-SmartSolar-charge-controller-MPPT-100-30-&-100-50-FR.pdf
- EPEVER Tracer4210AN: https://www.epever.com/product/tracer-an-g3-series-mppt-charge-controller/
- Morningstar TS-MPPT-60: https://www.solar-electric.com/motr60ampmps.html
- Philips SunStay (Signify): https://www.signify.com/api/assets/v1/file/Signify/content/LP_CF_7456095_EU.en_IN.PROF.CF-1/SunStay.pdf
- Felicity Solar P2 Series: https://cdn.autosolar.pe/pdf/ficha-tecnica-luminaria-solar-serie-p2-felicity-solar.pdf (distributor copy; check felicitysolar.com)
- K2 Systems CrossRail: https://k2-systems.com/en-us/product-solutions/crossrail-system/
- Schletter FS Uno: https://portal.segensolar.co.za/reseller/docs/Schletter-ProductSheet-FixedTilt-FSUno-EN.pdf
- Schletter Park@Sol: https://pveurope.eu/mounting/schletters-parksol-modular-solar-carport-electric-cars
- Stäubli MC4 PV-KBT4 / PV-KST4: https://midsummer.ie/pdfs/mc4-datasheet.pdf
- DEHN DEHNguard M YPV SCI 1000: https://rmsonline.co.za/wp-content/uploads/2025/08/952515_DS.pdf (base version 952 510 marked discontinued in some 2025 documents; confirm with DEHN)
- ABB S800PV-S: https://cdn.shopify.com/s/files/1/0755/7165/9042/files/ABB_miniature_circuit_breaker_s800PV.pdf

Only two street light products are listed: no third product with verifiable manufacturer information was confirmed.
