<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesImages;
use App\Http\Controllers\Controller;
use App\Support\SiteSettings;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use HandlesImages;

    public function general()
    {
        return view('admin.settings.general', [
            'groups' => SiteSettings::groups(),
            'values' => SiteSettings::all(),
        ]);
    }

    public function updateGeneral(Request $request)
    {
        $fields = SiteSettings::fields();
        $current = SiteSettings::all();

        $rules = [];
        foreach ($fields as $key => $field) {
            $rules = array_merge($rules, match ($field['type']) {
                'image' => $this->imageRules($key),
                'textarea' => [$key => ['nullable', 'string', 'max:2000']],
                default => [$key => ['nullable', 'string', 'max:500']],
            });
        }
        $request->validate($rules);

        $values = [];
        foreach ($fields as $key => $field) {
            $values[$key] = $field['type'] === 'image'
                ? $this->resolveImage($request, $key, $current[$key] ?? null, 'settings')
                : trim((string) $request->input($key));
        }

        SiteSettings::save($values);

        return redirect()->route('admin.settings.general')->with('success', 'Settings saved.');
    }
}
