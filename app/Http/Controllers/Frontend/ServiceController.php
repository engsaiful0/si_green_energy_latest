<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;

class ServiceController extends Controller
{
    /**
     * Display a listing of services.
     */
    public function index()
    {
        $services = Service::where('status', 'published')
            ->with('category')
            ->latest()
            ->paginate(12);

        $categories = ServiceCategory::where('is_active', true)
            ->withCount('services')
            ->get();

        return view('frontend.services.index', compact('services', 'categories'));
    }

    /**
     * Display the specified service.
     */
    public function show($slug)
    {
        $service = Service::where('slug', $slug)
            ->where('status', 'published')
            ->with(['category', 'images'])
            ->firstOrFail();

        $relatedServices = Service::where('category_id', $service->category_id)
            ->where('id', '!=', $service->id)
            ->where('status', 'published')
            ->take(3)
            ->get();

        return view('frontend.services.show', compact('service', 'relatedServices'));
    }
}
