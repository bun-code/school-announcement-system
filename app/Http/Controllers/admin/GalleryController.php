<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\GalleryPhoto;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class GalleryController extends Controller
{
    // ── Index ───────────────────────────────────────────────

    public function index(Request $request): View
    {
        $query = GalleryPhoto::with('album')->latest();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('caption', 'like', "%{$search}%")
                  ->orWhere('original_name', 'like', "%{$search}%");
            });
        }

        if ($albumId = $request->input('album_id')) {
            $query->where('album_id', $albumId);
        }

        $photos = $query->paginate(24)->withQueryString();
        $albums = Album::withCount('photos')->get();

        $stats = [
            'total'     => GalleryPhoto::count(),
            'albums'    => Album::count(),
            'published' => GalleryPhoto::published()->count(),
            'hidden'    => GalleryPhoto::where('is_published', false)->count(),
        ];

        return view('admin.gallery.index', compact('photos', 'albums', 'stats'));
    }

    // ── Store (upload photos) ────────────────────────────────

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'photos'       => ['required', 'array', 'max:20'],
            'photos.*'     => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            'album_id'     => ['nullable', 'exists:albums,id'],
            'caption'      => ['nullable', 'string', 'max:255'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $uploaded = 0;

        foreach ($request->file('photos') as $file) {
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path     = $file->storeAs('gallery', $filename, 'public');

            GalleryPhoto::create([
                'album_id'      => $request->input('album_id'),
                'filename'      => $filename,
                'original_name' => $file->getClientOriginalName(),
                'caption'       => $request->input('caption'),
                'disk'          => 'public',
                'path'          => $path,
                'mime_type'     => $file->getMimeType(),
                'size'          => $file->getSize(),
                'is_published'  => $request->boolean('is_published', true),
            ]);

            $uploaded++;
        }

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', $uploaded . ' photo' . ($uploaded > 1 ? 's' : '') . ' uploaded successfully.');
    }

    // ── Update (caption / album / visibility) ───────────────

    public function update(Request $request, GalleryPhoto $gallery): RedirectResponse
    {
        $validated = $request->validate([
            'caption'      => ['nullable', 'string', 'max:255'],
            'album_id'     => ['nullable', 'exists:albums,id'],
            'is_published' => ['boolean'],
        ]);

        $gallery->update($validated);

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Photo updated successfully.');
    }

    // ── Destroy (single photo) ───────────────────────────────

    public function destroy(GalleryPhoto $gallery): RedirectResponse
    {
        // Delete file from disk
        Storage::disk($gallery->disk)->delete($gallery->path);

        $gallery->delete();

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Photo deleted successfully.');
    }

    // ── Bulk destroy ─────────────────────────────────────────

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $request->validate([
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer', 'exists:gallery_photos,id'],
        ]);

        $photos = GalleryPhoto::whereIn('id', $request->input('ids'))->get();

        foreach ($photos as $photo) {
            Storage::disk($photo->disk)->delete($photo->path);
            $photo->delete();
        }

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', count($request->input('ids')) . ' photos deleted.');
    }

    // ── Album store ──────────────────────────────────────────

    public function storeAlbum(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255', 'unique:albums,name'],
            'description' => ['nullable', 'string'],
        ]);

        Album::create($validated);

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Album "' . $validated['name'] . '" created.');
    }

    // ── Album destroy ────────────────────────────────────────

    public function destroyAlbum(Album $album): RedirectResponse
    {
        // Unlink photos from this album (don't delete the photos themselves)
        $album->photos()->update(['album_id' => null]);
        $album->delete();

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Album deleted. Photos have been moved to General.');
    }
}