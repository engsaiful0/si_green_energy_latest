<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesImages;
use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    use HandlesImages;

    private const IMAGES = ['avatar', 'company_logo'];

    public function index()
    {
        $testimonials = Testimonial::orderByDesc('is_featured')->orderBy('order')->latest()->paginate(15);

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data = $this->resolveImages($request, $data, self::IMAGES, null, 'testimonials');
        $data['order'] = $data['order'] ?? ((int) Testimonial::max('order') + 1);

        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial created successfully.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $this->validatedData($request);
        $data = $this->resolveImages($request, $data, self::IMAGES, $testimonial, 'testimonials');
        $data['order'] = $data['order'] ?? $testimonial->order;

        $testimonial->update($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $this->deleteImages($testimonial, self::IMAGES);
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial deleted successfully.');
    }

    private function validatedData(Request $request): array
    {
        $data = $request->validate(array_merge([
            'client_name' => ['required', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'testimonial' => ['required', 'string', 'max:2000'],
            'order' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:pending,approved'],
        ], $this->imageRules('avatar'), $this->imageRules('company_logo')));

        $data['is_featured'] = $request->boolean('is_featured');

        return $data;
    }
}
