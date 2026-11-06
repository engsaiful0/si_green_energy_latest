<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\ContactMessage;
use App\Models\NewsletterSubscriber;
use App\Models\Page;
use App\Models\Product;
use App\Models\Project;
use App\Models\QuoteRequest;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $stats = [
            'users' => User::count(),
            'pages' => Page::count(),
            'blog_posts' => BlogPost::count(),
            'products' => Product::count(),
            'services' => Service::count(),
            'projects' => Project::count(),
            'contact_messages' => ContactMessage::count(),
            'quote_requests' => QuoteRequest::count(),
        ];

        // Monthly enquiries (last 6 months)
        // Month bucket expression for the active database driver.
        $monthExpression = DB::connection()->getDriverName() === 'sqlite'
            ? "strftime('%Y-%m', created_at)"
            : "DATE_FORMAT(created_at, '%Y-%m')";

        $monthlyEnquiries = ContactMessage::selectRaw("{$monthExpression} as month, COUNT(*) as count")
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Fill missing months with 0
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('Y-m');
            $months[$month] = $monthlyEnquiries[$month] ?? 0;
        }

        // Recent contact messages
        $recentContacts = ContactMessage::latest()->take(5)->get();

        // Recent quote requests
        $recentQuotes = QuoteRequest::latest()->take(5)->get();

        // Newsletter subscribers (recent)
        $recentSubscribers = NewsletterSubscriber::latest()->take(5)->get();

        // Content distribution (for chart)
        $contentDistribution = [
            'Pages' => Page::count(),
            'Blog Posts' => BlogPost::count(),
            'Products' => Product::count(),
            'Services' => Service::count(),
            'Projects' => Project::count(),
        ];

        return view('admin.dashboard', compact(
            'stats',
            'monthlyEnquiries',
            'months',
            'recentContacts',
            'recentQuotes',
            'recentSubscribers',
            'contentDistribution'
        ));
    }
}
