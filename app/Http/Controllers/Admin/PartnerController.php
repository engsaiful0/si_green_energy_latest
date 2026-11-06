<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesImages;
use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    use HandlesImages;

    private const IMAGES = ['logo', 'logo_dark'];

    public function index()
    {
        $partners = Partner::orderBy('order')->orderBy('id')->paginate(20);

        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data = $this->resolveImages($request, $data, self::IMAGES, null, 'partners');
        $data['order'] = $data['order'] ?? ((int) Partner::max('order') + 1);

        Partner::create($data);

        return redirect()->route('admin.partners.index')->with('success', 'Partner created successfully.');
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $data = $this->validatedData($request);
        $data = $this->resolveImages($request, $data, self::IMAGES, $partner, 'partners');
        $data['order'] = $data['order'] ?? $partner->order;

        $partner->update($data);

        return redirect()->route('admin.partners.index')->with('success', 'Partner updated successfully.');
    }

    public function destroy(Partner $partner)
    {
        $this->deleteImages($partner, self::IMAGES);
        $partner->delete();

        return redirect()->route('admin.partners.index')->with('success', 'Partner deleted successfully.');
    }

    private function validatedData(Request $request): array
    {
        $data = $request->validate(array_merge([
            'name' => ['required', 'string', 'max:255'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'order' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
        ], $this->imageRules('logo', true), $this->imageRules('logo_dark')));

        $data['is_featured'] = $request->boolean('is_featured');

        return $data;
    }
}
