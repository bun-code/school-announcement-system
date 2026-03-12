{{-- resources/views/admin/gallery/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Gallery & Media')
@section('breadcrumb', 'Gallery & Media')
@section('page-title', 'Gallery & Media')
@section('page-subtitle', 'Manage photos and media displayed on the public school gallery.')

@section('page-actions')
    <button class="btn btn--primary" onclick="openModal('modalUpload')">
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
        Upload Photos
    </button>
@endsection

@section('content')

    {{-- Stat row --}}
    <div class="stat-cards" style="grid-template-columns:repeat(4,1fr);margin-bottom:var(--space-6);">
        @php
            $gs = [
                ['label' => 'Total Photos', 'value' => $stats['total'] ?? 0, 'class' => 'stat-card__icon--blue'],
                ['label' => 'Albums', 'value' => $stats['albums'] ?? 0, 'class' => 'stat-card__icon--purple'],
                ['label' => 'Published', 'value' => $stats['published'] ?? 0, 'class' => 'stat-card__icon--green'],
                ['label' => 'Hidden', 'value' => $stats['hidden'] ?? 0, 'class' => 'stat-card__icon--amber'],
            ];
        @endphp
        @foreach($gs as $s)
        <div class="stat-card animate-fade-up">
            <div class="stat-card__icon {{ $s['class'] }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div class="stat-card__body">
                <p class="stat-card__label">{{ $s['label'] }}</p>
                <p class="stat-card__value">{{ $s['value'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <div style="display:grid;grid-template-columns:1fr 260px;gap:var(--space-6);align-items:start;">

        {{-- Photo grid --}}
        <div class="panel animate-fade-up delay-50">
            <div class="panel__header">
                <div>
                    <p class="panel__title">All Photos</p>
                </div>
                <form method="GET" action="{{ route('admin.gallery.index') }}" class="panel__header-actions">
                    <div class="search-input" style="min-width:160px;">
                        <svg class="search-input__icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="search" placeholder="Search photos..." value="{{ request('search') }}"/>
                    </div>
                    <select class="form-select" style="width:auto;padding-block:.5rem;" name="album_id" onchange="this.form.submit()">
                        <option value="">All Albums</option>
                        @foreach($albums as $album)
                            <option value="{{ $album->id }}" {{ (string) request('album_id') === (string) $album->id ? 'selected' : '' }}>
                                {{ $album->name }}
                            </option>
                        @endforeach
                    </select>
                    {{-- View toggle --}}
                    <div style="display:flex;border:1px solid var(--admin-border);border-radius:var(--radius-md);overflow:hidden;">
                        <button class="btn btn--primary btn--sm" style="border-radius:0;" id="viewGrid" type="button" aria-label="Grid view">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        </button>
                        <button class="btn btn--ghost btn--sm" style="border-radius:0;" id="viewList" type="button" aria-label="List view">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                        </button>
                    </div>
                </form>
            </div>

            <div class="panel__body">
                {{-- Image grid --}}
                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:var(--space-3);" id="photoGrid">
                    @forelse($photos as $photo)
                        @php
                            $caption = $photo->caption ?: ($photo->original_name ?: 'Gallery photo');
                        @endphp
                        <div class="img-preview-item" style="aspect-ratio:1;cursor:pointer;border-radius:var(--radius-lg);">
                            <img src="{{ $photo->url }}" alt="{{ $caption }}"/>
                            <button class="img-preview-item__remove" type="button"
                                    data-delete-action="{{ route('admin.gallery.destroy', $photo) }}"
                                    onclick="setDeleteAction('{{ route('admin.gallery.destroy', $photo) }}'); openModal('modalDeleteConfirm')" aria-label="Delete photo">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="10" height="10"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    @empty
                        <div class="empty-state" style="grid-column:1 / -1;">
                            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 17h18M5 7l2 10m10-10l-2 10M9 7V4h6v3"/></svg>
                            <p class="empty-state__title">No photos yet</p>
                            <p class="empty-state__desc">Upload photos to start building the school gallery.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="panel__footer">
                <span style="font-size:var(--text-xs);color:var(--admin-text-muted);">
                    @if($photos->total() > 0)
                        Showing {{ $photos->firstItem() }}-{{ $photos->lastItem() }} of {{ $photos->total() }} photos
                    @else
                        Showing 0 photos
                    @endif
                </span>
                {{ $photos->links('vendor.pagination.admin') }}
            </div>
        </div>

        {{-- Albums sidebar --}}
        <div style="display:flex;flex-direction:column;gap:var(--space-5);">
            <div class="panel animate-fade-up delay-100">
                <div class="panel__header">
                    <p class="panel__title">Albums</p>
                    <button class="btn btn--secondary btn--sm" onclick="openModal('modalCreateAlbum')">
                        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        New
                    </button>
                </div>
                <div class="panel__body" style="padding-block:var(--space-2);">
                    @php
                        $albumColors = ['#3b82f6', '#f59e0b', '#ec4899', '#8b5cf6', '#84cc16', '#14b8a6', '#0ea5e9'];
                    @endphp
                    @forelse($albums as $album)
                        @php $color = $albumColors[$loop->index % count($albumColors)]; @endphp
                        <a href="{{ route('admin.gallery.index', ['album_id' => $album->id]) }}"
                           style="display:flex;align-items:center;gap:var(--space-3);padding:var(--space-3) 0;border-bottom:1px solid var(--admin-border);cursor:pointer;">
                            <div style="width:36px;height:36px;border-radius:var(--radius-md);background:{{ $color }}22;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <svg width="16" height="16" fill="none" stroke="{{ $color }}" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <div style="flex:1;min-width:0;">
                                <p style="font-size:var(--text-sm);font-weight:600;color:var(--admin-text-heading);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $album->name }}</p>
                                <p style="font-size:var(--text-xs);color:var(--admin-text-muted);">{{ $album->photos_count }} photos</p>
                            </div>
                            <button class="btn btn--ghost btn--icon btn--sm" aria-label="Edit album">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                        </a>
                    @empty
                        <div class="empty-state">
                            <p class="empty-state__title">No albums yet</p>
                            <p class="empty-state__desc">Create an album to organize photos.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

    {{-- MODAL: Upload Photos --}}
    <div class="modal-overlay" id="modalUpload" role="dialog" aria-modal="true" aria-labelledby="modalUploadTitle">
        <div class="modal modal--lg">
            <div class="modal__header">
                <div>
                    <h2 class="modal__title" id="modalUploadTitle">Upload Photos</h2>
                    <p class="modal__subtitle">Add new photos to the school gallery.</p>
                </div>
                <button class="modal__close" onclick="closeModal('modalUpload')" aria-label="Close">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal__body">
                    {{-- Dropzone --}}
                    <div class="dropzone" id="dropzone" onclick="document.getElementById('fileInput').click()">
                        <div class="dropzone__icon">
                            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        </div>
                        <p class="dropzone__title">Click to upload or drag & drop</p>
                        <p class="dropzone__hint">PNG, JPG, WEBP up to 10MB each. Multiple files allowed.</p>
                        <input type="file" id="fileInput" name="photos[]" multiple accept="image/*" style="display:none;"/>
                    </div>
                    <div class="img-preview-grid" id="previewGrid"></div>

                    <div class="form-divider"></div>

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label" for="up_album">Album</label>
                            <select class="form-select" id="up_album" name="album_id">
                                <option value="">No album (General)</option>
                                @foreach($albums as $album)
                                    <option value="{{ $album->id }}">{{ $album->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label form-label--optional" for="up_caption">Caption</label>
                            <input class="form-input" type="text" id="up_caption" name="caption"
                                   placeholder="Optional photo caption..."/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-check">
                            <input type="checkbox" name="is_published" value="1" checked/>
                            <span class="form-check-label">Publish immediately to the public gallery</span>
                        </label>
                    </div>
                </div>
                <div class="modal__footer">
                    <button type="button" class="btn btn--secondary" onclick="closeModal('modalUpload')">Cancel</button>
                    <button type="submit" class="btn btn--primary">Upload Photos</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL: Create Album --}}
    <div class="modal-overlay" id="modalCreateAlbum" role="dialog" aria-modal="true" aria-labelledby="modalAlbumTitle">
        <div class="modal modal--sm">
            <div class="modal__header">
                <div>
                    <h2 class="modal__title" id="modalAlbumTitle">New Album</h2>
                </div>
                <button class="modal__close" onclick="closeModal('modalCreateAlbum')" aria-label="Close">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.gallery.albums.store') }}">
                @csrf
                <div class="modal__body">
                    <div class="form-group">
                        <label class="form-label" for="alb_name">Album Name</label>
                        <input class="form-input" type="text" id="alb_name" name="name"
                               placeholder="e.g. Intramurals 2026" required/>
                    </div>
                    <div class="form-group">
                        <label class="form-label form-label--optional" for="alb_desc">Description</label>
                        <textarea class="form-textarea" id="alb_desc" name="description" rows="2"
                                  placeholder="Short description..." style="min-height:70px;"></textarea>
                    </div>
                </div>
                <div class="modal__footer">
                    <button type="button" class="btn btn--secondary" onclick="closeModal('modalCreateAlbum')">Cancel</button>
                    <button type="submit" class="btn btn--primary">Create Album</button>
                </div>
            </form>
        </div>
    </div>

    @include('partials.admin.modal-delete', ['label' => 'photo'])

@endsection

@push('scripts')
<script>
    document.querySelectorAll('[data-delete-action]').forEach(btn => {
        btn.addEventListener('click', () => {
            const form = document.getElementById('deleteForm');
            if (form) form.action = btn.getAttribute('data-delete-action');
        });
    });

    // File preview on select
    const fileInput  = document.getElementById('fileInput');
    const previewGrid = document.getElementById('previewGrid');

    fileInput.addEventListener('change', () => {
        previewGrid.innerHTML = '';
        Array.from(fileInput.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
                const item = document.createElement('div');
                item.className = 'img-preview-item';
                item.innerHTML = `<img src="${e.target.result}" alt="${file.name}"/>
                    <button class="img-preview-item__remove" type="button">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="12" height="12">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>`;
                item.querySelector('.img-preview-item__remove').addEventListener('click', () => item.remove());
                previewGrid.appendChild(item);
            };
            reader.readAsDataURL(file);
        });
    });

    // Drag and drop on dropzone
    const dz = document.getElementById('dropzone');
    dz.addEventListener('dragover', e => { e.preventDefault(); dz.classList.add('dragover'); });
    dz.addEventListener('dragleave', () => dz.classList.remove('dragover'));
    dz.addEventListener('drop', e => {
        e.preventDefault();
        dz.classList.remove('dragover');
        fileInput.files = e.dataTransfer.files;
        fileInput.dispatchEvent(new Event('change'));
    });
</script>
@endpush


