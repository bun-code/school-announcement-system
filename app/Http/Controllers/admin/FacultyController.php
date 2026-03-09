<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class FacultyController extends Controller
{
    // ── Index ───────────────────────────────────────────────

    public function index(Request $request): View
    {
        $query = Faculty::latest();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        $faculty = $query->paginate(15)->withQueryString();

        $stats = [
            'total'        => Faculty::count(),
            'teaching'     => Faculty::teaching()->count(),
            'non_teaching' => Faculty::where('type', 'non-teaching')->count(),
            'active'       => Faculty::active()->count(),
        ];

        return view('admin.faculty.index', compact('faculty', 'stats'));
    }

    // ── Store ───────────────────────────────────────────────

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name'    => ['required', 'string', 'max:100'],
            'last_name'     => ['required', 'string', 'max:100'],
            'email'         => ['nullable', 'email', 'max:255', 'unique:faculty,email'],
            'phone'         => ['nullable', 'string', 'max:20'],
            'position'      => ['nullable', 'string', 'max:100'],
            'type'          => ['required', 'in:teaching,non-teaching,administrative'],
            'subject'       => ['nullable', 'string', 'max:255'],
            'grade_handled' => ['nullable', 'string', 'max:100'],
            'photo'         => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'show_on_site'  => ['nullable', 'boolean'],
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $validated['photo_path'] = $file->storeAs('faculty', $filename, 'public');
        }

        $validated['show_on_site'] = $request->boolean('show_on_site');
        $validated['status']       = 'active';

        Faculty::create($validated);

        return redirect()
            ->route('admin.faculty.index')
            ->with('success', 'Faculty member added successfully.');
    }

    // ── Update ──────────────────────────────────────────────

    public function update(Request $request, Faculty $faculty): RedirectResponse
    {
        $validated = $request->validate([
            'first_name'    => ['required', 'string', 'max:100'],
            'last_name'     => ['required', 'string', 'max:100'],
            'email'         => ['nullable', 'email', 'max:255', 'unique:faculty,email,' . $faculty->id],
            'phone'         => ['nullable', 'string', 'max:20'],
            'position'      => ['nullable', 'string', 'max:100'],
            'type'          => ['required', 'in:teaching,non-teaching,administrative'],
            'subject'       => ['nullable', 'string', 'max:255'],
            'grade_handled' => ['nullable', 'string', 'max:100'],
            'photo'         => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'show_on_site'  => ['nullable', 'boolean'],
            'status'        => ['required', 'in:active,inactive'],
        ]);

        // Replace photo if a new one is uploaded
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($faculty->photo_path) {
                Storage::disk('public')->delete($faculty->photo_path);
            }

            $file = $request->file('photo');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $validated['photo_path'] = $file->storeAs('faculty', $filename, 'public');
        }

        $validated['show_on_site'] = $request->boolean('show_on_site');

        $faculty->update($validated);

        return redirect()
            ->route('admin.faculty.index')
            ->with('success', $faculty->full_name . '\'s profile updated successfully.');
    }

    // ── Destroy ─────────────────────────────────────────────

    public function destroy(Faculty $faculty): RedirectResponse
    {
        // Delete photo from disk if exists
        if ($faculty->photo_path) {
            Storage::disk('public')->delete($faculty->photo_path);
        }

        $faculty->delete();

        return redirect()
            ->route('admin.faculty.index')
            ->with('success', 'Faculty member removed successfully.');
    }
}