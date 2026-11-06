# ASSET INVENTORY
## Complete Template Asset Documentation

**Project:** SI Green Energy (Slaze Template)
**Date:** November 2, 2026
**Purpose:** Asset migration and organization for Laravel conversion

---

## 1. DIRECTORY STRUCTURE

```
slaze/
├── assets/
│   ├── css/
│   ├── font/
│   ├── img/
│   ├── js/
│   ├── sass/
│   └── webfonts/
└── *.html files (35 total)
```

---

## 2. CSS ASSETS

### 2.1 CSS Files Location: `assets/css/`

| File Name | Size | Purpose | Version | Laravel Location |
|-----------|------|---------|---------|------------------|
| bootstrap.min.css | ~200KB | Bootstrap framework | 5.x | public/assets/css/ |
| fontawesome.css | ~80KB | Font Awesome icons | 6.x | public/assets/css/ |
| animate.css | ~75KB | CSS animations | Latest | public/assets/css/ |
| swiper-bundle.min.css | ~50KB | Swiper slider | 8.x | public/assets/css/ |
| magnific-popup.css | ~15KB | Lightbox popup | 1.1.0 | public/assets/css/ |

### 2.2 SASS/Custom CSS Location: `assets/sass/`

| File Name | Purpose | Laravel Location |
|-----------|---------|------------------|
| style.css | Main custom styles | public/assets/css/style.css |

**Note:** Original SASS source files not included in template. Only compiled CSS available.

### 2.3 CSS Dependencies in HTML

```html
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<!-- Font Awesome CSS -->
<link rel="stylesheet" href="assets/css/fontawesome.css">
<!-- Animate CSS -->
<link rel="stylesheet" href="assets/css/animate.css">
<!-- Flaticon -->
<link rel="stylesheet" href="assets/font/flaticon_slaze.css">
<!-- Swiper Bundle CSS -->
<link rel="stylesheet" href="assets/css/swiper-bundle.min.css">
<!-- Magnific Popup CSS -->
<link rel="stylesheet" href="assets/css/magnific-popup.css">
<!-- Custom CSS -->
<link rel="stylesheet" href="assets/sass/style.css">
```

### 2.4 CSS Customization Requirements

**For Laravel:**
- Move all CSS to `public/assets/css/`
- Update paths in Blade templates using `asset()` helper
- Minify custom CSS for production
- Combine CSS files for performance (optional)
- Add versioning for cache busting: `asset('css/style.css?v=1.0')`

---

## 3. JAVASCRIPT ASSETS

### 3.1 JavaScript Files Location: `assets/js/`

| File Name | Size | Purpose | Version | Laravel Location |
|-----------|------|---------|---------|------------------|
| jquery-3.7.0.min.js | ~90KB | jQuery library | 3.7.0 | public/assets/js/ or CDN |
| bootstrap.min.js | ~60KB | Bootstrap JS | 5.x | public/assets/js/ or CDN |
| popper.min.js | ~20KB | Popper (Bootstrap dependency) | 2.x | public/assets/js/ or CDN |
| jquery.counterup.min.js | ~5KB | Counter animations | Latest | public/assets/js/ |
| progressbar.min.js | ~8KB | Progress bar animations | Latest | public/assets/js/ |
| jquery.magnific-popup.min.js | ~25KB | Lightbox plugin | 1.1.0 | public/assets/js/ |
| swiper-bundle.min.js | ~140KB | Slider/carousel | 8.x | public/assets/js/ |
| isotope.pkgd.min.js | ~50KB | Grid layout/filtering | 3.x | public/assets/js/ |
| jquery.waypoints.min.js | ~15KB | Scroll detection | Latest | public/assets/js/ |
| custom.js | ~20KB | Theme custom scripts | N/A | public/assets/js/ |

**Total JS Size:** ~433KB (minified)

### 3.2 JavaScript Dependencies in HTML

```html
<!-- Main JS -->
<script src="assets/js/jquery-3.7.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="assets/js/bootstrap.min.js"></script>
<!-- Counter Up JS -->
<script src="assets/js/jquery.counterup.min.js"></script>
<!-- Popper JS -->
<script src="assets/js/popper.min.js"></script>
<!-- Progressbar JS -->
<script src="assets/js/progressbar.min.js"></script>
<!-- Magnific Popup JS -->
<script src="assets/js/jquery.magnific-popup.min.js"></script>
<!-- Swiper Bundle JS -->
<script src="assets/js/swiper-bundle.min.js"></script>
<!-- Isotope JS -->
<script src="assets/js/isotope.pkgd.min.js"></script>
<!-- Waypoints JS -->
<script src="assets/js/jquery.waypoints.min.js"></script>
<!-- Custom JS -->
<script src="assets/js/custom.js"></script>
```

### 3.3 Custom JS Functionality (custom.js)

**Key Functions:**
- Dark/light mode toggle
- Mobile menu clone
- Swiper slider initialization
- Counter animation on scroll
- Progress bar animation
- Scroll to top functionality
- Magnific popup initialization
- Isotope grid filtering
- Waypoint scroll triggers
- Search box toggle
- Sidebar popup toggle

**Laravel Migration Notes:**
- Review custom.js for jQuery dependencies
- Ensure all functionality works with Blade components
- Add CSRF token to AJAX requests
- Update API endpoints
- Test dark mode with Laravel session storage

---

## 4. FONT ASSETS

### 4.1 Custom Icon Font Location: `assets/font/`

| File Name | Format | Purpose | Laravel Location |
|-----------|--------|---------|------------------|
| flaticon_slaze.css | CSS | Flaticon CSS | public/assets/font/ |
| flaticon_slazee74f.ttf | TTF | Flaticon font | public/assets/font/ |
| flaticon_slazee74f.woff | WOFF | Flaticon font | public/assets/font/ |
| flaticon_slazee74f.woff2 | WOFF2 | Flaticon font | public/assets/font/ |
| flaticon_slaze.eote74f.html | HTML | Flaticon demo | (Not needed in Laravel) |
| flaticon_slazee74f.html | HTML | Flaticon demo | (Not needed in Laravel) |

**Total Icons:** ~50+ custom icons

**Icon Examples:**
- flaticon-ecology
- flaticon-renewable-energy
- flaticon-solar-energy
- flaticon-profit
- flaticon-best-customer-experience
- flaticon-phone-call
- flaticon-envelope
- flaticon-placeholder
- flaticon-menu-2
- etc.

### 4.2 Web Fonts Location: `assets/webfonts/`

| File Name | Format | Purpose |
|-----------|--------|---------|
| fa-sharp-thin-100.ttf.html | HTML | Font Awesome demo (Not needed) |

**Note:** Font Awesome fonts are typically loaded via fontawesome.css

### 4.3 Font Usage in Laravel

```html
<!-- In Blade layouts -->
<link rel="stylesheet" href="{{ asset('assets/font/flaticon_slaze.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/fontawesome.css') }}">
```

---

## 5. IMAGE ASSETS

### 5.1 Image Directory Structure

```
assets/img/
├── about/          (6 images)
├── avatar/         (7 images)
├── banner/         (6 images)
├── blog/           (7 images)
├── brand/          (8 logos)
├── icon/           (6 icons)
├── pages/          (~15 images)
├── portfolio/      (~20 images)
├── service/        (~10 images)
├── shape/          (~15 SVG shapes)
├── team/           (~15 images)
├── logo-*.png      (5 logo files)
└── favicon-*.png   (3 favicon files)
```

**Total Images:** 105+

### 5.2 About Images (`assets/img/about/`)

| File Name | Usage | Recommended CMS Field |
|-----------|-------|----------------------|
| about-1.jpg | Main about image | About Section - Image 1 |
| about-2.jpg | Secondary about image | About Section - Image 2 |
| about-3.jpg | Homepage about image 1 | Homepage About - Image 1 |
| about-4.jpg | Homepage about image 2 | Homepage About - Image 2 |
| about-5.jpg | About page image 1 | About Page - Feature Image 1 |
| about-6.jpg | About page image 2 | About Page - Feature Image 2 |

### 5.3 Avatar Images (`assets/img/avatar/`)

| File Name | Usage |
|-----------|-------|
| avatar-1.jpg | Testimonial client photo |
| avatar-2.jpg | Testimonial client photo |
| avatar-3.jpg | Testimonial client photo |
| avatar-4.jpg | Testimonial client photo |
| avatar-5.png | Footer CTA avatar |
| avatar-6.jpg | Testimonial client photo |
| user.png | User placeholder/group avatar |

### 5.4 Banner Images (`assets/img/banner/`)

| File Name | Usage |
|-----------|-------|
| banner-1.jpg | Hero slider image 1 |
| banner-3.jpg | Hero slider image 2 |
| banner-4.jpg | Homepage variation banner |
| banner-5.jpg | Homepage variation banner |
| banner-6.jpg | Homepage variation banner |

### 5.5 Blog Images (`assets/img/blog/`)

| File Name | Usage |
|-----------|-------|
| blog-1.jpg | Blog post featured image |
| blog-2.jpg | Blog post featured image |
| blog-3.jpg | Blog post featured image |
| blog-4.jpg | Blog post featured image |
| blog-5.jpg | Blog post featured image |
| blog-6.jpg | Blog post featured image |
| blog-d-1.jpg | Blog detail image |

### 5.6 Brand/Client Logos (`assets/img/brand/`)

| File Name | Usage |
|-----------|-------|
| brand-1.png | Testimonial company logo |
| brand-2.png | Partner logo slider |
| brand-3.png | Partner logo slider |
| brand-4.png | Partner logo slider |
| brand-5.png | Partner logo slider |
| brand-6.png | Partner logo slider |
| brand-7.png | Partner logo slider |
| brand-8.png | Partner logo slider |

### 5.7 Icons (`assets/img/icon/`)

| File Name | Usage |
|-----------|-------|
| moon-dark.png | Dark mode icon (dark theme) |
| moon.png | Dark mode icon (light theme) |
| star-1.png | Star decoration |
| star.png | Star decoration |
| sun-white.png | Light mode icon |
| sun.png | Light mode icon |

### 5.8 Page Images (`assets/img/pages/`)

| File Name | Usage |
|-----------|-------|
| breadcrumb.jpg | Default breadcrumb background |
| choose-us-1.jpg | Why choose us section image |
| choose-us-2.jpg | Why choose us section image |
| consultation.jpg | Consultation section image |
| experience.jpg | Experience section image |
| work-1.jpg | Work process step 1 |
| work-2.jpg | Work process step 2 |
| work-3.jpg | Work process step 3 |
| work-4.jpg | Work process step 4 |
| ...additional page-specific images |

### 5.9 Portfolio/Project Images (`assets/img/portfolio/`)

| File Name | Usage |
|-----------|-------|
| portfolio-1.jpg | Project image |
| portfolio-2.jpg | Project image |
| ...portfolio-3 through portfolio-20.jpg | Project images |

### 5.10 Service Images (`assets/img/service/`)

Service-related images (icons, backgrounds, featured images)

### 5.11 Shape Images (`assets/img/shape/`)

| File Name | Usage |
|-----------|-------|
| shape-3.png | Banner shape overlay |
| shape-5.png | Service card background |
| shape-6.png | CTA banner background |
| shape-7.png | Footer CTA background |
| shape-8.png | Section background |
| shape-9.png | Section background |
| shape-10.png | Features section background |
| shape-11.png | About section shape |
| shape-11-dark.png | About section shape (dark mode) |
| shape-12.png | About image overlay |
| shape-13.png | Footer background |
| ...additional shape overlays |

### 5.12 Team Images (`assets/img/team/`)

| File Name | Usage |
|-----------|-------|
| team-1.jpg | Team member photo |
| team-2.jpg | Team member photo |
| team-3.jpg | Team member photo |
| team-4.jpg | Team member photo |
| ...team-5 through team-15.jpg | Team member photos |

### 5.13 Logo Files (Root `assets/img/`)

| File Name | Usage | CMS Field |
|-----------|-------|-----------|
| logo-1.png | Main header logo (light mode) | Settings > Logo (Header) |
| logo-2.png | Footer/Sidebar logo (dark mode) | Settings > Logo (Footer) |
| logo-3.png | Alternative logo | Settings > Logo (Variation 1) |
| logo-4.png | Alternative logo | Settings > Logo (Variation 2) |
| logo-5.png | Alternative logo | Settings > Logo (Variation 3) |

### 5.14 Favicon Files

| File Name | Size | Usage |
|-----------|------|-------|
| favicon-1.png | 32x32 | Browser tab icon |
| favicon-2.png | 180x180 | Apple touch icon |
| favicon-3.png | 192x192 | Android icon |

---

## 6. ASSET MIGRATION PLAN

### 6.1 Laravel Public Directory Structure

```
public/
├── assets/
│   ├── css/
│   │   ├── bootstrap.min.css
│   │   ├── fontawesome.css
│   │   ├── animate.css
│   │   ├── swiper-bundle.min.css
│   │   ├── magnific-popup.css
│   │   └── style.css
│   ├── js/
│   │   ├── jquery-3.7.0.min.js
│   │   ├── bootstrap.min.js
│   │   ├── popper.min.js
│   │   ├── jquery.counterup.min.js
│   │   ├── progressbar.min.js
│   │   ├── jquery.magnific-popup.min.js
│   │   ├── swiper-bundle.min.js
│   │   ├── isotope.pkgd.min.js
│   │   ├── jquery.waypoints.min.js
│   │   └── custom.js
│   ├── font/
│   │   ├── flaticon_slaze.css
│   │   ├── flaticon_slazee74f.ttf
│   │   ├── flaticon_slazee74f.woff
│   │   └── flaticon_slazee74f.woff2
│   ├── webfonts/ (Font Awesome fonts)
│   └── img/
│       ├── (Copy all subdirectories as-is)
│       └── (Initial template images)
└── uploads/ (New directory for CMS uploaded media)
    ├── services/
    ├── projects/
    ├── blog/
    ├── team/
    ├── testimonials/
    ├── pages/
    ├── logos/
    └── general/
```

### 6.2 Storage Directory (Dynamic Uploads)

```
storage/
└── app/
    └── public/
        ├── services/
        ├── projects/
        ├── blog/
        ├── team/
        ├── testimonials/
        ├── pages/
        ├── logos/
        └── general/
```

**Symlink:** `php artisan storage:link`

### 6.3 Asset Loading in Blade

```blade
<!-- CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

<!-- JS -->
<script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>

<!-- Images (Template) -->
<img src="{{ asset('assets/img/logo-1.png') }}" alt="Logo">

<!-- Images (Uploaded via CMS) -->
<img src="{{ Storage::url($service->image) }}" alt="{{ $service->title }}">
<!-- or -->
<img src="{{ asset('uploads/services/' . $service->image) }}" alt="{{ $service->title }}">
```

---

## 7. ASSET OPTIMIZATION REQUIREMENTS

### 7.1 Images
- ✅ Compress all images (TinyPNG, ImageOptim)
- ✅ Convert large images to WebP format
- ✅ Generate responsive image sizes (thumbnail, medium, large)
- ✅ Lazy load images below the fold
- ✅ Use appropriate image dimensions
- ✅ Add alt attributes to all images

### 7.2 CSS
- ✅ Minify CSS files for production
- ✅ Combine CSS files where possible
- ✅ Remove unused CSS (PurgeCSS)
- ✅ Use critical CSS for above-the-fold content
- ✅ Enable Gzip compression

### 7.3 JavaScript
- ✅ Minify JS files for production
- ✅ Combine JS files where possible
- ✅ Defer non-critical JavaScript
- ✅ Use async loading for third-party scripts
- ✅ Remove console.log statements in production

### 7.4 Fonts
- ✅ Use modern font formats (WOFF2)
- ✅ Subset fonts to include only used characters
- ✅ Preload critical fonts
- ✅ Use font-display: swap for web fonts

---

## 8. CDN RECOMMENDATIONS

Consider using CDN for common libraries:

| Library | CDN URL | Fallback |
|---------|---------|----------|
| jQuery | https://code.jquery.com/jquery-3.7.0.min.js | Local copy |
| Bootstrap CSS | https://cdn.jsdelivr.net/npm/bootstrap@5.x/dist/css/bootstrap.min.css | Local copy |
| Bootstrap JS | https://cdn.jsdelivr.net/npm/bootstrap@5.x/dist/js/bootstrap.bundle.min.js | Local copy |
| Font Awesome | https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.x/css/all.min.css | Local copy |

**Benefits:**
- Faster loading (cached by browsers)
- Reduced server bandwidth
- Better performance

**Risks:**
- CDN downtime
- Privacy concerns

**Recommendation:** Use local copies for production stability

---

## 9. ASSET VERSIONING

### 9.1 Cache Busting Strategy

**Option 1: Query String Versioning**
```blade
<link rel="stylesheet" href="{{ asset('assets/css/style.css?v=' . config('app.version')) }}">
```

**Option 2: Laravel Mix (Recommended)**
```blade
<link rel="stylesheet" href="{{ mix('css/app.css') }}">
<script src="{{ mix('js/app.js') }}"></script>
```

**Option 3: File Name Versioning**
```
style.v1.0.0.css
custom.v1.0.0.js
```

---

## 10. PERFORMANCE CHECKLIST

- ✅ Compress all images
- ✅ Minify CSS and JavaScript
- ✅ Enable Gzip/Brotli compression
- ✅ Implement browser caching
- ✅ Use CDN for static assets (optional)
- ✅ Lazy load images
- ✅ Defer non-critical CSS/JS
- ✅ Reduce HTTP requests
- ✅ Optimize font loading
- ✅ Enable HTTP/2

---

## 11. ASSET BACKUP STRATEGY

### 11.1 Template Assets (Static)
- Backup original template files
- Version control with Git
- Keep compressed archive

### 11.2 CMS Uploads (Dynamic)
- Regular automated backups
- Store in separate location
- Cloud storage integration (S3, Dropbox)
- Backup retention policy

---

## 12. FILE PERMISSIONS

### Linux/Unix Servers
```bash
# Directories
chmod 755 public/assets/
chmod 755 storage/app/public/

# Files
chmod 644 public/assets/css/*
chmod 644 public/assets/js/*
chmod 644 public/assets/img/*
```

### Ownership
```bash
chown -R www-data:www-data public/assets/
chown -R www-data:www-data storage/
```

---

## 13. ASSET LOADING ORDER

### In Blade Layout (head)
```html
<!-- 1. CSS Libraries (First) -->
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/fontawesome.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
<link rel="stylesheet" href="{{ asset('assets/font/flaticon_slaze.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">

<!-- 2. Custom CSS (Last) -->
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

<!-- 3. Dynamic CSS (If any) -->
@stack('styles')
```

### In Blade Layout (before </body>)
```html
<!-- 1. JavaScript Libraries (Order matters) -->
<script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('assets/js/progressbar.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.waypoints.min.js') }}"></script>

<!-- 2. Custom JS (Last) -->
<script src="{{ asset('assets/js/custom.js') }}"></script>

<!-- 3. Page-specific JS -->
@stack('scripts')
```

---

## 14. MIGRATION CHECKLIST

- [ ] Copy all CSS files to `public/assets/css/`
- [ ] Copy all JS files to `public/assets/js/`
- [ ] Copy all font files to `public/assets/font/`
- [ ] Copy all image files to `public/assets/img/`
- [ ] Create storage symlink
- [ ] Update all asset paths in Blade templates
- [ ] Test all CSS loading
- [ ] Test all JS functionality
- [ ] Test all images loading
- [ ] Verify dark mode toggle
- [ ] Verify sliders/carousels
- [ ] Verify mobile menu
- [ ] Verify search functionality
- [ ] Verify form submissions
- [ ] Verify animations
- [ ] Optimize all images
- [ ] Minify CSS/JS for production
- [ ] Enable caching headers
- [ ] Test on multiple browsers
- [ ] Test on multiple devices
- [ ] Measure page load speed
- [ ] Implement lazy loading
- [ ] Configure CDN (if using)
- [ ] Set up asset versioning
- [ ] Configure file permissions
- [ ] Create backup strategy

---

**Total Asset Size (Approximate):**
- CSS: ~420KB (before minification)
- JavaScript: ~433KB (minified)
- Fonts: ~150KB
- Images: ~15MB (can be optimized to ~8MB)
- **Total:** ~16MB

**Optimized Total:** ~9-10MB

---

**Status:** Inventory complete
**Next Step:** Create implementation roadmap
