<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    // ── Index ──────────────────────────────────────────────

    public function index(Request $request): View
    {
        $query = Announcement::with('author')
            ->latest('post_date');

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('body', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }

        // Filter by status
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $announcements = $query->paginate(10)->withQueryString();

        // Stats for header cards
        $stats = [
            'total'     => Announcement::count(),
            'published' => Announcement::published()->count(),
            'draft'     => Announcement::draft()->count(),
            'pinned'    => Announcement::pinned()->count(),
        ];

        return view('admin.announcements.index', compact('announcements', 'stats'));
    }

    // ── Store ───────────────────────────────────────────────

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'body'        => ['required', 'string'],
            'category'    => ['required', 'in:General,Academic,Notice,Health,Community'],
            'status'      => ['nullable', 'in:published,draft'],
            'post_date'   => ['required', 'date'],
            'expiry_date' => ['nullable', 'date', 'after:post_date'],
            'is_pinned'   => ['nullable', 'boolean'],
        ]);

        // Button value determines status (Save as Draft / Publish Now)
        $validated['status']    = $request->input('action') === 'publish' ? 'published' : 'draft';
        $validated['author_id'] = Auth::id();
        $validated['is_pinned'] = $request->boolean('is_pinned');

        Announcement::create($validated);

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Announcement ' . ($validated['status'] === 'published' ? 'published' : 'saved as draft') . ' successfully.');
    }

    // ── Edit ────────────────────────────────────────────────

    public function edit(Announcement $announcement): View
    {
        return view('admin.announcements.index', compact('announcement'));
        // The edit form is a modal on the index page,
        // so we return the index view with the record passed in.
        // Livewire will replace this entirely in the next conversion step.
    }

    // ── Update ──────────────────────────────────────────────

    public function update(Request $request, Announcement $announcement): RedirectResponse
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'body'        => ['required', 'string'],
            'category'    => ['required', 'in:General,Academic,Notice,Health,Community'],
            'status'      => ['required', 'in:published,draft'],
            'post_date'   => ['required', 'date'],
            'expiry_date' => ['nullable', 'date', 'after:post_date'],
            'is_pinned'   => ['nullable', 'boolean'],
        ]);

        $validated['is_pinned'] = $request->boolean('is_pinned');

        $announcement->update($validated);

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Announcement updated successfully.');
    }

    // ── Destroy ─────────────────────────────────────────────

    public function destroy(Announcement $announcement): RedirectResponse
    {
        $announcement->delete(); // soft delete

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Announcement deleted successfully.');
    }

    // ── Bulk destroy ────────────────────────────────────────

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $request->validate([
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer', 'exists:announcements,id'],
        ]);

        Announcement::whereIn('id', $request->input('ids'))->delete();

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', count($request->input('ids')) . ' announcements deleted.');
    }
}