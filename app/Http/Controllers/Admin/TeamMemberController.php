<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesImages;
use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TeamMemberController extends Controller
{
    use HandlesImages;

    private const IMAGES = ['photo'];

    public function index()
    {
        $members = TeamMember::orderByDesc('is_featured')->orderBy('order')->orderBy('id')->paginate(15);

        return view('admin.team.index', compact('members'));
    }

    public function create()
    {
        return view('admin.team.create');
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data = $this->resolveImages($request, $data, self::IMAGES, null, 'team');
        $data['order'] = $data['order'] ?? ((int) TeamMember::max('order') + 1);

        TeamMember::create($data);

        return redirect()->route('admin.team.index')->with('success', 'Team member created successfully.');
    }

    public function edit(TeamMember $team)
    {
        return view('admin.team.edit', ['member' => $team]);
    }

    public function update(Request $request, TeamMember $team)
    {
        $data = $this->validatedData($request, $team);
        $data = $this->resolveImages($request, $data, self::IMAGES, $team, 'team');
        $data['order'] = $data['order'] ?? $team->order;

        $team->update($data);

        return redirect()->route('admin.team.index')->with('success', 'Team member updated successfully.');
    }

    public function destroy(TeamMember $team)
    {
        // Soft delete: the image is kept so the record can be restored.
        $team->delete();

        return redirect()->route('admin.team.index')->with('success', 'Team member deleted successfully.');
    }

    private function validatedData(Request $request, ?TeamMember $member = null): array
    {
        $request->merge(['slug' => Str::slug($request->input('slug') ?: $request->input('full_name'))]);

        $socialRules = [];
        foreach (array_keys(TeamMember::SOCIAL_NETWORKS) as $network) {
            $socialRules["social_links.{$network}"] = ['nullable', 'url', 'max:255'];
        }

        $data = $request->validate(array_merge([
            'full_name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('team_members')->ignore($member?->id)],
            'position' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'short_bio' => ['nullable', 'string', 'max:1000'],
            'bio' => ['nullable', 'string', 'max:20000'],
            'qualifications' => ['nullable', 'string', 'max:5000'],
            'skills_text' => ['nullable', 'string', 'max:2000'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'experience_years' => ['nullable', 'integer', 'min:0', 'max:80'],
            'order' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
            'social_links' => ['nullable', 'array'],
        ], $socialRules, $this->imageRules('photo', true)));

        $data['social_links'] = array_filter($data['social_links'] ?? []);
        $data['skills'] = $this->parseSkills($data['skills_text'] ?? '');
        unset($data['skills_text']);
        $data['is_featured'] = $request->boolean('is_featured');

        return $data;
    }

    /**
     * "Solar Design | 90" lines to [['label' => 'Solar Design', 'percent' => 90], ...].
     */
    private function parseSkills(string $text): array
    {
        $skills = [];

        foreach (preg_split('/\R/', $text) as $line) {
            if (trim($line) === '') {
                continue;
            }

            [$label, $percent] = array_pad(array_map('trim', explode('|', $line, 2)), 2, null);
            $skills[] = ['label' => $label, 'percent' => max(0, min(100, (int) $percent))];
        }

        return $skills;
    }
}
