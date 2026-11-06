# FRONTEND PAGE MAPPING
## HTML Template → Laravel Routes & Controllers

**Database:** si_green_energy
**Laravel Version:** 8.3

---

## PAGE ROUTING STRUCTURE

| # | HTML File | Laravel Route | Controller | Method | View Path | Notes |
|---|-----------|---------------|------------|--------|-----------|-------|
| 1 | index.html / index-2.html | `/` | HomeController | index | frontend.home | Main homepage |
| 2 | index-two.html | `/` | HomeController | index | frontend.home | Same content, different theme |
| 3 | index-three.html | `/` | HomeController | index | frontend.home | Same content, different theme |
| 4 | about.html | `/about` | AboutController | index | frontend.about | About us page |
| 5 | service.html | `/services` | ServiceController | index | frontend.services.index | Service listing |
| 6 | service-two.html | `/services` | ServiceController | index | frontend.services.index | Alternative layout (admin configurable) |
| 7 | service-left-sidebar.html | `/services/{slug}` | ServiceController | show | frontend.services.detail-left | Service detail |
| 8 | service-right-sidebar.html | `/services/{slug}` | ServiceController | show | frontend.services.detail-right | Service detail |
| 9 | pricing.html | `/pricing` | PricingController | index | frontend.pricing | Pricing plans |
| 10 | faq.html | `/faq` | FaqController | index | frontend.faq | FAQ page |
| 11 | testimonial.html | `/testimonials` | TestimonialController | index | frontend.testimonials | Testimonials |
| 12 | project-two.html | `/projects` | ProjectController | index | frontend.projects.grid-2 | 2-column grid |
| 13 | project-three.html | `/projects` | ProjectController | index | frontend.projects.grid-3 | 3-column grid |
| 14 | project-four.html | `/projects` | ProjectController | index | frontend.projects.grid-4 | 4-column grid |
| 15 | project-details.html | `/projects/{slug}` | ProjectController | show | frontend.projects.detail | Project detail |
| 16 | team.html | `/team` | TeamController | index | frontend.team.grid-1 | Team grid 01 |
| 17 | team-two.html | `/team` | TeamController | index | frontend.team.grid-2 | Team grid 02 |
| 18 | team-three.html | `/team` | TeamController | index | frontend.team.grid-3 | Team grid 03 |
| 19 | team-details.html | `/team/{slug}` | TeamController | show | frontend.team.detail | Team member detail |
| 20 | blog-grid-two.html | `/blog` | BlogController | index | frontend.blog.grid-2 | 2-column grid |
| 21 | blog-grid-three.html | `/blog` | BlogController | index | frontend.blog.grid-3 | 3-column grid |
| 22 | standard-left-sidebar.html | `/blog` | BlogController | index | frontend.blog.standard-left | List with left sidebar |
| 23 | standard-full-width.html | `/blog` | BlogController | index | frontend.blog.standard-full | List full width |
| 24 | standard-right-sidebar.html | `/blog` | BlogController | index | frontend.blog.standard-right | List with right sidebar |
| 25 | single-left-sidebar.html | `/blog/{slug}` | BlogController | show | frontend.blog.single-left | Post with left sidebar |
| 26 | single-full-width.html | `/blog/{slug}` | BlogController | show | frontend.blog.single-full | Post full width |
| 27 | single-right-sidebar.html | `/blog/{slug}` | BlogController | show | frontend.blog.single-right | Post with right sidebar |
| 28 | contact.html | `/contact` | ContactController | index | frontend.contact.style-1 | Contact style 1 |
| 29 | contact-two.html | `/contact` | ContactController | index | frontend.contact.style-2 | Contact style 2 |
| 30 | request-quote.html | `/request-quote` | QuoteController | index | frontend.quote | Request quote page |
| 31 | 404-error.html | `*` (fallback) | - | - | errors.404 | Error page |

---

## FORM SUBMISSION ROUTES

| Form Type | Route | Method | Controller | Action | Redirect |
|-----------|-------|--------|------------|--------|----------|
| Contact Form | `/contact/submit` | POST | ContactController | store | /contact (with success) |
| Quote Request | `/quote/submit` | POST | QuoteController | store | /request-quote (with success) |
| Newsletter | `/newsletter/subscribe` | POST | NewsletterController | subscribe | Previous page (AJAX) |
| Search | `/search` | GET | SearchController | index | frontend.search.results |

---

## API/AJAX ENDPOINTS (Optional)

| Purpose | Route | Method | Controller | Returns |
|---------|-------|--------|------------|---------|
| Load more blog | `/api/blog/load-more` | GET | BlogController | JSON |
| Load more projects | `/api/projects/load-more` | GET | ProjectController | JSON |
| Search autocomplete | `/api/search/autocomplete` | GET | SearchController | JSON |

---

## ROUTE NAMING CONVENTION

```php
// Public Frontend Routes
Route::name('frontend.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/about', [AboutController::class, 'index'])->name('about');

    // Services
    Route::prefix('services')->name('services.')->group(function () {
        Route::get('/', [ServiceController::class, 'index'])->name('index');
        Route::get('/{slug}', [ServiceController::class, 'show'])->name('show');
    });

    // Projects
    Route::prefix('projects')->name('projects.')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('index');
        Route::get('/{slug}', [ProjectController::class, 'show'])->name('show');
    });

    // Blog
    Route::prefix('blog')->name('blog.')->group(function () {
        Route::get('/', [BlogController::class, 'index'])->name('index');
        Route::get('/category/{slug}', [BlogController::class, 'category'])->name('category');
        Route::get('/tag/{slug}', [BlogController::class, 'tag'])->name('tag');
        Route::get('/{slug}', [BlogController::class, 'show'])->name('show');
    });

    // Team
    Route::prefix('team')->name('team.')->group(function () {
        Route::get('/', [TeamController::class, 'index'])->name('index');
        Route::get('/{slug}', [TeamController::class, 'show'])->name('show');
    });

    // Other pages
    Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');
    Route::get('/faq', [FaqController::class, 'index'])->name('faq');
    Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::post('/contact/submit', [ContactController::class, 'store'])->name('contact.submit');
    Route::get('/request-quote', [QuoteController::class, 'index'])->name('quote');
    Route::post('/quote/submit', [QuoteController::class, 'store'])->name('quote.submit');

    // Newsletter
    Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

    // Search
    Route::get('/search', [SearchController::class, 'index'])->name('search');

    // Dynamic Pages
    Route::get('/{slug}', [PageController::class, 'show'])->name('page');
});
```

---

## CONTROLLER STRUCTURE

### HomeController
```
index() - Load homepage with all sections from database
```

### AboutController
```
index() - Load about page sections
```

### ServiceController
```
index() - List all active services
show($slug) - Show single service detail
```

### ProjectController
```
index() - List all active projects (with category filter)
show($slug) - Show single project detail
```

### BlogController
```
index() - List all blog posts (with pagination)
category($slug) - Filter by category
tag($slug) - Filter by tag
show($slug) - Show single blog post
```

### TeamController
```
index() - List all team members
show($slug) - Show team member detail
```

### PricingController
```
index() - Show all pricing plans
```

### FaqController
```
index() - List all FAQs grouped by category
```

### TestimonialController
```
index() - List all testimonials
```

### ContactController
```
index() - Show contact page
store(Request) - Handle contact form submission
```

### QuoteController
```
index() - Show quote request page
store(Request) - Handle quote form submission
```

### NewsletterController
```
subscribe(Request) - Handle newsletter subscription
```

### SearchController
```
index(Request) - Search across all content types
```

### PageController
```
show($slug) - Load dynamic custom pages
```

---

## BLADE LAYOUT STRUCTURE

```
resources/views/
├── frontend/
│   ├── layouts/
│   │   ├── app.blade.php (Master layout)
│   │   ├── header.blade.php
│   │   ├── footer.blade.php
│   │   └── breadcrumb.blade.php
│   ├── components/
│   │   ├── hero-slider.blade.php
│   │   ├── service-card.blade.php
│   │   ├── blog-card.blade.php
│   │   ├── project-card.blade.php
│   │   ├── team-card.blade.php
│   │   ├── testimonial-card.blade.php
│   │   ├── pricing-card.blade.php
│   │   ├── counter.blade.php
│   │   ├── skill-bar.blade.php
│   │   ├── section-header.blade.php
│   │   ├── cta-banner.blade.php
│   │   └── newsletter-form.blade.php
│   ├── partials/
│   │   ├── topbar.blade.php
│   │   ├── search-box.blade.php
│   │   ├── mobile-menu.blade.php
│   │   ├── sidebar-popup.blade.php
│   │   ├── preloader.blade.php
│   │   ├── dark-mode-toggle.blade.php
│   │   └── scroll-top.blade.php
│   ├── sections/ (Homepage sections)
│   │   ├── hero.blade.php
│   │   ├── features.blade.php
│   │   ├── about.blade.php
│   │   ├── services.blade.php
│   │   ├── cta.blade.php
│   │   ├── why-choose-us.blade.php
│   │   ├── portfolio.blade.php
│   │   ├── work-process.blade.php
│   │   ├── team.blade.php
│   │   ├── testimonials.blade.php
│   │   ├── brands.blade.php
│   │   └── blog.blade.php
│   ├── home.blade.php
│   ├── about.blade.php
│   ├── pricing.blade.php
│   ├── faq.blade.php
│   ├── testimonials.blade.php
│   ├── search.blade.php
│   ├── services/
│   │   ├── index.blade.php
│   │   ├── detail-left.blade.php
│   │   └── detail-right.blade.php
│   ├── projects/
│   │   ├── grid-2.blade.php
│   │   ├── grid-3.blade.php
│   │   ├── grid-4.blade.php
│   │   └── detail.blade.php
│   ├── blog/
│   │   ├── grid-2.blade.php
│   │   ├── grid-3.blade.php
│   │   ├── standard-left.blade.php
│   │   ├── standard-full.blade.php
│   │   ├── standard-right.blade.php
│   │   ├── single-left.blade.php
│   │   ├── single-full.blade.php
│   │   └── single-right.blade.php
│   ├── team/
│   │   ├── grid-1.blade.php
│   │   ├── grid-2.blade.php
│   │   ├── grid-3.blade.php
│   │   └── detail.blade.php
│   ├── contact/
│   │   ├── style-1.blade.php
│   │   └── style-2.blade.php
│   └── quote.blade.php
└── errors/
    └── 404.blade.php
```

---

## MIDDLEWARE REQUIREMENTS

| Middleware | Route Group | Purpose |
|------------|-------------|---------|
| web | All frontend | Session, CSRF, cookies |
| SetLocale | All frontend | Multi-language support (future) |
| TrackVisitor | All frontend | Analytics tracking (optional) |
| MaintenanceMode | All frontend | Site maintenance mode |

---

## URL EXAMPLES (After Conversion)

```
Homepage:
https://sigreeenenergy.com/

About:
https://sigreeenenergy.com/about

Services:
https://sigreeenenergy.com/services
https://sigreeenenergy.com/services/solar-panel-installation

Projects:
https://sigreeenenergy.com/projects
https://sigreeenenergy.com/projects/commercial-solar-system-2024

Blog:
https://sigreeenenergy.com/blog
https://sigreeenenergy.com/blog/category/renewable-energy
https://sigreeenenergy.com/blog/solar-energy-benefits-2025

Team:
https://sigreeenenergy.com/team
https://sigreeenenergy.com/team/john-doe

Contact & Forms:
https://sigreeenenergy.com/contact
https://sigreeenenergy.com/request-quote

Utility:
https://sigreeenenergy.com/faq
https://sigreeenenergy.com/pricing
https://sigreeenenergy.com/testimonials
https://sigreeenenergy.com/search?q=solar

Custom Pages:
https://sigreeenenergy.com/privacy-policy
https://sigreeenenergy.com/terms-and-conditions
```

---

## PAGINATION SETTINGS

| Page Type | Items Per Page | Pagination Style |
|-----------|----------------|------------------|
| Blog Grid | 12 | Bootstrap pagination |
| Blog Standard | 10 | Bootstrap pagination |
| Projects | 12 | Bootstrap pagination |
| Services | 12 | Show all (no pagination) |
| Team | 12 | Show all (no pagination) |
| FAQ | All | No pagination |
| Search Results | 20 | Bootstrap pagination |

---

## SITEMAP STRUCTURE (XML)

```xml
<urlset>
  <!-- Static Pages -->
  <url><loc>/</loc><priority>1.0</priority></url>
  <url><loc>/about</loc><priority>0.8</priority></url>
  <url><loc>/services</loc><priority>0.9</priority></url>
  <url><loc>/projects</loc><priority>0.9</priority></url>
  <url><loc>/blog</loc><priority>0.9</priority></url>
  <url><loc>/team</loc><priority>0.7</priority></url>
  <url><loc>/pricing</loc><priority>0.8</priority></url>
  <url><loc>/faq</loc><priority>0.7</priority></url>
  <url><loc>/testimonials</loc><priority>0.6</priority></url>
  <url><loc>/contact</loc><priority>0.8</priority></url>
  <url><loc>/request-quote</loc><priority>0.9</priority></url>

  <!-- Dynamic Services -->
  <url><loc>/services/{slug}</loc><priority>0.8</priority></url>

  <!-- Dynamic Projects -->
  <url><loc>/projects/{slug}</loc><priority>0.7</priority></url>

  <!-- Dynamic Blog Posts -->
  <url><loc>/blog/{slug}</loc><priority>0.7</priority></url>

  <!-- Dynamic Team Members -->
  <url><loc>/team/{slug}</loc><priority>0.5</priority></url>

  <!-- Custom Pages -->
  <url><loc>/{custom-slug}</loc><priority>0.6</priority></url>
</urlset>
```

---

## ROBOTS.TXT

```
User-agent: *
Allow: /
Disallow: /admin/
Disallow: /api/
Sitemap: https://sigreeenenergy.com/sitemap.xml
```

---

## NOTES

1. **Layout Variations:** The template has multiple layout variations for the same content type (e.g., blog grid 2-column vs 3-column). These should be admin-configurable settings, not separate routes.

2. **Slug Generation:** All slugs should be auto-generated from titles with manual override option.

3. **404 Handling:** Custom 404 page using the template's 404-error.html design.

4. **Breadcrumbs:** Dynamic breadcrumb generation based on current route.

5. **SEO URLs:** Clean URLs without .html extension.

6. **Redirects:** Implement 301 redirects if URLs change.

7. **Canonical URLs:** Implement canonical tags to avoid duplicate content.

8. **Multi-language Ready:** Route structure supports future multi-language implementation.

---

**Status:** Ready for implementation
**Next Step:** Create CMS feature mapping
