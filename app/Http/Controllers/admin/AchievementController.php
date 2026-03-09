<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AchievementController extends Controller
{
    // ── Index ───────────────────────────────────────────────

    public function index(Request $request): View
    {
        $tab        = $request->input('tab', 'honor'); // 'honor' | 'competition'
        $schoolYear = $request->input('school_year', '2025–2026');
        $quarter    = $request->input('quarter');

        // Honor roll
        $honorQuery = Achievement::honors()
            ->forYear($schoolYear)
            ->orderByDesc('gwa');

        if ($quarter) {
            $honorQuery->where('quarter', $quarter);
        }

        $honorees = $honorQuery->paginate(10, ['*'], 'honor_page')
            ->withQueryString();

        // Competition wins
        $compQuery = Achievement::competitions()
            ->latest('event_date');

        if ($search = $request->input('search')) {
            $compQuery->where(function ($q) use ($search) {
                $q->where('competition_name', 'like', "%{$search}%")
                  ->orWhere('student_names', 'like', "%{$search}%");
            });
        }

        $competitions = $compQuery->paginate(10, ['*'], 'comp_page')
            ->withQueryString();

        return view('admin.achievements.index', compact(
            'honorees', 'competitions', 'tab', 'schoolYear', 'quarter'
        ));
    }

    // ── Store ───────────────────────────────────────────────

    public function store(Request $request): RedirectResponse
    {
        $type = $request->input('type');

        if ($type === 'honor') {
            $validated = $request->validate([
                'student_name' => ['required', 'string', 'max:255'],
                'grade'        => ['required', 'string'],
                'section'      => ['nullable', 'string', 'max:100'],
                'gwa'          => ['required', 'numeric', 'min:75', 'max:100'],
                'honors'       => ['required', 'in:With Highest Honors,With High Honors,With Honors'],
                'quarter'      => ['required', 'string'],
                'school_year'  => ['required', 'string', 'max:20'],
            ]);
            $validated['type'] = 'honor';

        } else {
            $validated = $request->validate([
                'competition_name' => ['required', 'string', 'max:255'],
                'student_names'    => ['nullable', 'string', 'max:500'],
                'category'         => ['nullable', 'string', 'max:100'],
                'level'            => ['required', 'in:School,District,Division,Regional,National'],
                'place'            => ['required', 'in:1st Place,2nd Place,3rd Place,Finalist,Special Award'],
                'event_date'       => ['nullable', 'date'],
            ]);
            $validated['type'] = 'competition';
        }

        Achievement::create($validated);

        return redirect()
            ->route('admin.achievements.index', ['tab' => $type])
            ->with('success', ucfirst($type === 'honor' ? 'Honor student' : 'Competition win') . ' added successfully.');
    }

    // ── Update ──────────────────────────────────────────────

    public function update(Request $request, Achievement $achievement): RedirectResponse
    {
        if ($achievement->type === 'honor') {
            $validated = $request->validate([
                'student_name' => ['required', 'string', 'max:255'],
                'grade'        => ['required', 'string'],
                'section'      => ['nullable', 'string', 'max:100'],
                'gwa'          => ['required', 'numeric', 'min:75', 'max:100'],
                'honors'       => ['required', 'in:With Highest Honors,With High Honors,With Honors'],
                'quarter'      => ['required', 'string'],
                'school_year'  => ['required', 'string', 'max:20'],
            ]);
        } else {
            $validated = $request->validate([
                'competition_name' => ['required', 'string', 'max:255'],
                'student_names'    => ['nullable', 'string', 'max:500'],
                'category'         => ['nullable', 'string', 'max:100'],
                'level'            => ['required', 'in:School,District,Division,Regional,National'],
                'place'            => ['required', 'in:1st Place,2nd Place,3rd Place,Finalist,Special Award'],
                'event_date'       => ['nullable', 'date'],
            ]);
        }

        $achievement->update($validated);

        return redirect()
            ->route('admin.achievements.index', ['tab' => $achievement->type])
            ->with('success', 'Achievement updated successfully.');
    }

    // ── Destroy ─────────────────────────────────────────────

    public function destroy(Achievement $achievement): RedirectResponse
    {
        $tab = $achievement->type;
        $achievement->delete();

        return redirect()
            ->route('admin.achievements.index', ['tab' => $tab])
            ->with('success', 'Achievement removed successfully.');
    }
}