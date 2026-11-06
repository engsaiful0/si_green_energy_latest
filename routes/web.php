<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Frontend\BlogController as FrontendBlogController;
use App\Http\Controllers\Frontend\CompanyProfileController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PageController as FrontendPageController;
use App\Http\Controllers\Frontend\ProductController as FrontendProductController;
use App\Http\Controllers\Frontend\ProjectController as FrontendProjectController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\ServiceController as FrontendServiceController;
use App\Http\Controllers\Frontend\SolutionController as FrontendSolutionController;
use App\Http\Controllers\Frontend\TeamController as FrontendTeamController;
use App\Http\Controllers\Frontend\TestimonialController as FrontendTestimonialController;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Homepage Variations
Route::get('/wind', function () {
    return view('frontend.pages.home-wind');
})->name('home.wind');

Route::get('/renewable', function () {
    return view('frontend.pages.home-renewable');
})->name('home.renewable');

// About: Company Profile, Testimonials, Solar Design Engineers
Route::get('/company-profile', [CompanyProfileController::class, 'show'])->name('company-profile');
Route::redirect('/about', '/company-profile', 301)->name('about');

Route::get('/testimonials', [FrontendTestimonialController::class, 'index'])->name('testimonials');

Route::get('/team', [FrontendTeamController::class, 'index'])->defaults('columns', 3)->name('team.index');
Route::get('/team/grid-2', [FrontendTeamController::class, 'index'])->defaults('columns', 2)->name('team.grid2');
Route::get('/team/grid-3', [FrontendTeamController::class, 'index'])->defaults('columns', 4)->name('team.grid3');
Route::get('/team/{slug}', [FrontendTeamController::class, 'show'])->name('team.show');

// Catalogs: products, solutions, services (listing, category, details)
foreach ([
    'products' => FrontendProductController::class,
    'solutions' => FrontendSolutionController::class,
    'services' => FrontendServiceController::class,
] as $prefix => $controller) {
    Route::get("/{$prefix}", [$controller, 'index'])->name("{$prefix}.index");
    Route::get("/{$prefix}/category/{slug}", [$controller, 'category'])->name("{$prefix}.category");
    Route::get("/{$prefix}/{slug}", [$controller, 'show'])->name("{$prefix}.show");
}

// Pricing
Route::get('/pricing', function () {
    return view('frontend.pages.pricing');
})->name('pricing');

// FAQ
Route::get('/faq', function () {
    return view('frontend.pages.faq');
})->name('faq');

// Projects (?category=slug filters the listing)
Route::get('/projects', [FrontendProjectController::class, 'index'])->defaults('columns', 3)->name('projects.index');
Route::get('/projects/2-columns', [FrontendProjectController::class, 'index'])->defaults('columns', 2)->name('projects.grid2');
Route::get('/projects/3-columns', [FrontendProjectController::class, 'index'])->defaults('columns', 3)->name('projects.grid3');
Route::get('/projects/4-columns', [FrontendProjectController::class, 'index'])->defaults('columns', 4)->name('projects.grid4');
Route::get('/projects/{slug}', [FrontendProjectController::class, 'show'])->name('projects.show');

// Blog (?q= searches)
Route::get('/blog', [FrontendBlogController::class, 'index'])->name('blog.index');
Route::get('/blog/category/{slug}', [FrontendBlogController::class, 'category'])->name('blog.category');
Route::get('/blog/tag/{slug}', [FrontendBlogController::class, 'tag'])->name('blog.tag');
Route::get('/blog/{slug}', [FrontendBlogController::class, 'show'])->name('blog.show');

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:6,1')->name('contact.store');

Route::get('/contact-alt', function () {
    return view('frontend.pages.contact-alt');
})->name('contact.alt');

// Quote
Route::get('/quote', [ContactController::class, 'quote'])->name('quote');
Route::post('/quote', [ContactController::class, 'storeQuote'])->middleware('throttle:6,1')->name('quote.store');

// Search
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Newsletter
Route::post('/newsletter/subscribe', [ContactController::class, 'subscribe'])->middleware('throttle:6,1')->name('newsletter.subscribe');

// Privacy & Terms
Route::get('/privacy', function () {
    return view('frontend.pages.privacy');
})->name('privacy');

Route::get('/terms', function () {
    return view('frontend.pages.terms');
})->name('terms');

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PageContentController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProjectCategoryController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ServiceCategoryController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SolutionCategoryController;
use App\Http\Controllers\Admin\SolutionController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserController;

Route::prefix('admin')->name('admin.')->group(function () {
    // Login routes (guest only)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'login']);
    });

    // Logout route (auth only)
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');
});

/*
|--------------------------------------------------------------------------
| Admin Protected Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Pages (Resource Routes)
    Route::resource('pages', PageController::class);

    // Page CMS: home, company profile, contact, services/solutions/products, projects, blog, team, testimonials
    Route::get('/seo', [PageContentController::class, 'pages'])->name('seo.index');
    Route::get('/content/{page}', [PageContentController::class, 'index'])->name('content.index');
    Route::put('/content/{page}', [PageContentController::class, 'arrange'])->name('content.arrange');
    Route::get('/content/{page}/{section}/edit', [PageContentController::class, 'edit'])->name('content.edit');
    Route::put('/content/{page}/{section}', [PageContentController::class, 'update'])->name('content.update');
    Route::post('/content/{page}/{section}/reset', [PageContentController::class, 'reset'])->name('content.reset');
    Route::redirect('/homepage-sections', '/admin/content/home')->name('homepage-sections.index');

    // Menus
    Route::get('/menus', function () {
        return view('admin.menus.index');
    })->name('menus.index');

    // Sliders (Resource Routes)
    Route::resource('sliders', SliderController::class)->except(['show']);

    // Categories (shared category module)
    Route::resource('product-categories', ProductCategoryController::class)->except(['show']);
    Route::resource('solution-categories', SolutionCategoryController::class)->except(['show']);
    Route::resource('service-categories', ServiceCategoryController::class)->except(['show']);
    Route::resource('project-categories', ProjectCategoryController::class)->except(['show']);

    // Products, solutions, services
    Route::resource('products', ProductController::class)->except(['show']);
    Route::resource('solutions', SolutionController::class)->except(['show']);
    Route::resource('services', ServiceController::class);

    // Projects (+ gallery images)
    Route::resource('projects', ProjectController::class)->except(['show']);
    Route::delete('/projects/{project}/images/{image}', [ProjectController::class, 'destroyImage'])->name('projects.images.destroy');

    // Pricing
    Route::get('/pricing', function () {
        return view('admin.pricing.index');
    })->name('pricing.index');

    // Blog Categories (Inline Routes)
    Route::get('/blog-categories', [BlogCategoryController::class, 'index'])->name('blog-categories.index');
    Route::post('/blog-categories', [BlogCategoryController::class, 'store'])->name('blog-categories.store');
    Route::put('/blog-categories/{blogCategory}', [BlogCategoryController::class, 'update'])->name('blog-categories.update');
    Route::delete('/blog-categories/{blogCategory}', [BlogCategoryController::class, 'destroy'])->name('blog-categories.destroy');

    // Blog Posts (Resource Routes)
    Route::resource('blog-posts', BlogPostController::class);

    // Team (Solar Design Engineers)
    Route::resource('team', TeamMemberController::class)->except(['show']);

    // Testimonials
    Route::resource('testimonials', TestimonialController::class)->except(['show']);

    // Partners
    Route::resource('partners', PartnerController::class)->except(['show']);

    // FAQs
    Route::get('/faqs', function () {
        return view('admin.faqs.index');
    })->name('faqs.index');

    // Contact messages
    Route::resource('contacts', ContactMessageController::class)->only(['index', 'show', 'update', 'destroy'])
        ->parameters(['contacts' => 'message']);

    // Quotes
    Route::get('/quotes', function () {
        return view('admin.quotes.index');
    })->name('quotes.index');

    // Newsletter
    Route::get('/newsletter', function () {
        return view('admin.newsletter.index');
    })->name('newsletter.index');

    // Media
    Route::get('/media', function () {
        return view('admin.media.index');
    })->name('media.index');

    // Settings
    Route::get('/settings/general', [SettingController::class, 'general'])->name('settings.general');
    Route::put('/settings/general', [SettingController::class, 'updateGeneral'])->name('settings.general.update');
    Route::redirect('/settings/seo', '/admin/seo')->name('settings.seo');

    // Users Management (Resource Routes)
    Route::resource('users', UserController::class);

    // Roles Management (Resource Routes)
    Route::resource('roles', RoleController::class);

    // Profile
    Route::get('/profile', function () {
        return view('admin.profile');
    })->name('profile');
});

// Dynamic Pages (must be last so it does not capture /admin and other defined routes)
Route::get('/{slug}', [FrontendPageController::class, 'show'])->name('pages.show');
