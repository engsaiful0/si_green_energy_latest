<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesImages;
use App\Http\Controllers\Controller;
use App\Models\GalleryCategory;
use App\Models\GalleryImage;
use App\Support\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Gallery images: multi-upload, editing, publishing and the homepage carousel selection.
 */
class GalleryImageController extends Controller
{
    use HandlesImages;

    public function index(Request $request)
    {
        $images = GalleryImage::with('category')
            ->when($request->filled('search'), fn ($query) => $query->where('title', 'like', '%' . $request->search . '%'))
            ->when($request->filled('category'), fn ($query) => $query->where('category_id', $request->category))
            ->when(in_array($request->status, ['draft', 'published'], true), fn ($query) => $query->where('status', $request->status))
            ->when($request->boolean('home'), fn ($query) => $query->where('show_on_home', true))
            ->ordered()
            ->paginate(24)->withQueryString();

        return view('admin.gallery.index', [
            'images' => $images,
            'categories' => GalleryCategory::ordered()->get(),
        ]);
    }

    public function create()
    {
        return view('admin.gallery.create', ['categories' => GalleryCategory::ordered()->get()]);
    }

    /**
     * Upload one or more images with shared settings.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'images' => ['required', 'array', 'min:1', 'max:30'],
            'images.*' => Media::rules(true),
            'category_id' => ['nullable', 'exists:gallery_categories,id'],
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'status' => ['required', 'in:draft,published'],
        ], [
            'images.required' => 'Please choose at least one image.',
        ]);

        $order = (int) GalleryImage::max('order');
        $homeOrder = (int) GalleryImage::max('home_order');
        $files = $request->file('images');

        foreach ($files as $index => $file) {
            $title = $data['title']
                ? (count($files) > 1 ? $data['title'] . ' ' . ($index + 1) : $data['title'])
                : Str::headline(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));

            GalleryImage::create([
                'category_id' => $data['category_id'] ?? null,
                'title' => Str::limit($title, 250, ''),
                'description' => $data['description'] ?? null,
                'image' => Media::store($file, 'gallery'),
                'alt_text' => Str::limit($title, 250, ''),
                'status' => $data['status'],
                'is_featured' => $request->boolean('is_featured'),
                'show_on_home' => $request->boolean('show_on_home'),
                'home_order' => $request->boolean('show_on_home') ? ++$homeOrder : 0,
                'order' => ++$order,
            ]);
        }

        return redirect()->route('admin.gallery.index')
            ->with('success', count($files) . ' ' . Str::plural('image', count($files)) . ' uploaded. Edit each image to refine its title, description and alt text.');
    }

    public function edit(GalleryImage $gallery)
    {
        return view('admin.gallery.edit', ['image' => $gallery, 'categories' => GalleryCategory::ordered()->get()]);
    }

    public function update(Request $request, GalleryImage $gallery)
    {
        $data = $request->validate(array_merge([
            'category_id' => ['nullable', 'exists:gallery_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'alt_text' => ['nullable', 'string', 'max:255'],
            'order' => ['nullable', 'integer', 'min:0'],
            'home_order' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:draft,published'],
        ], $this->imageRules('image', true)));

        $data = $this->resolveImages($request, $data, ['image'], $gallery, 'gallery');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['show_on_home'] = $request->boolean('show_on_home');
        $data['order'] = $data['order'] ?? $gallery->order;
        $data['home_order'] = $data['home_order'] ?? $gallery->home_order;

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Image updated.');
    }

    public function destroy(GalleryImage $gallery)
    {
        $this->deleteImages($gallery, ['image']);
        $gallery->delete();

        return redirect()->back()->with('success', 'Image deleted.');
    }

    /**
     * Quick actions from the image grid: show/hide on homepage, publish/unpublish.
     */
    public function toggle(Request $request, GalleryImage $gallery)
    {
        $field = $request->validate(['field' => ['required', 'in:show_on_home,status,is_featured']])['field'];

        if ($field === 'status') {
            $gallery->status = $gallery->status === 'published' ? 'draft' : 'published';
        } else {
            $gallery->{$field} = !$gallery->{$field};
            if ($field === 'show_on_home' && $gallery->show_on_home) {
                $gallery->home_order = (int) GalleryImage::max('home_order') + 1;
            }
        }
        $gallery->save();

        return redirect()->back()->with('success', 'Image updated.');
    }

    /**
     * Save the display order of the images shown in the grid.
     */
    public function reorder(Request $request)
    {
        $data = $request->validate([
            'order' => ['required', 'array'],
            'order.*' => ['nullable', 'integer', 'min:0'],
        ]);

        foreach ($data['order'] as $id => $order) {
            GalleryImage::whereKey($id)->update(['order' => (int) $order]);
        }

        return redirect()->back()->with('success', 'Gallery order saved.');
    }

    /**
     * Homepage carousel: selected images and their order.
     */
    public function home()
    {
        return view('admin.gallery.home', [
            'selected' => GalleryImage::with('category')->where('show_on_home', true)->orderBy('home_order')->orderBy('id')->get(),
            'available' => GalleryImage::published()->where('show_on_home', false)->ordered()->get(),
        ]);
    }

    public function updateHome(Request $request)
    {
        $data = $request->validate([
            'images' => ['nullable', 'array'],
            'images.*.home_order' => ['nullable', 'integer', 'min:0'],
            'images.*.keep' => ['nullable', 'boolean'],
            'add' => ['nullable', 'array'],
            'add.*' => ['integer', 'exists:gallery_images,id'],
        ]);

        foreach ($data['images'] ?? [] as $id => $values) {
            GalleryImage::whereKey($id)->update([
                'show_on_home' => !empty($values['keep']),
                'home_order' => (int) ($values['home_order'] ?? 0),
            ]);
        }

        $next = (int) GalleryImage::where('show_on_home', true)->max('home_order');
        foreach ($data['add'] ?? [] as $id) {
            GalleryImage::whereKey($id)->update(['show_on_home' => true, 'home_order' => ++$next]);
        }

        return redirect()->route('admin.gallery.home')->with('success', 'Homepage carousel saved.');
    }
}
