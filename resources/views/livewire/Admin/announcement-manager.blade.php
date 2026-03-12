{{-- resources/views/livewire/admin/announcement-manager.blade.php --}}

<div>

    {{-- Local page header (keeps Livewire actions functional) --}}
    <div class="page-header animate-fade-up">
        <div>
            <h1 class="page-header__title">Announcements</h1>
            <p class="page-header__subtitle">Manage all school announcements published to the public site.</p>
        </div>
        <div class="page-header__actions">
            @include('livewire.admin.partials.announcement-actions')
        </div>
    </div>

    {{-- ── Toast notification (dispatched from component) ── --}}
    <div
        x-data="{ show: false, message: '', type: 'success' }"
        x-on:notify.window="show = true; message = $event.detail[0].message; type = $event.detail[0].type; setTimeout(() => show = false, 3500)"
        x-show="show"
        x-transition.opacity
        class="admin-toast"
        :class="type === 'success' ? 'admin-toast--success' : 'admin-toast--error'"
        style="display:none;"
        role="status"
        aria-live="polite"
    >
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span x-text="message"></span>
    </div>

    {{-- ══════════════════════════════════════
         STAT CARDS
    ══════════════════════════════════════ --}}
    <div class="stat-cards" style="grid-template-columns:repeat(4,1fr);">
        @php
            $statDefs = [
                ['label' => 'Total Posts', 'key' => 'total',     'icon_class' => 'stat-card__icon--blue'],
                ['label' => 'Published',   'key' => 'published', 'icon_class' => 'stat-card__icon--green'],
                ['label' => 'Drafts',      'key' => 'draft',     'icon_class' => 'stat-card__icon--amber'],
                ['label' => 'Pinned',      'key' => 'pinned',    'icon_class' => 'stat-card__icon--purple'],
            ];
        @endphp
        @foreach($statDefs as $s)
        <div class="stat-card animate-fade-up">
            <div class="stat-card__icon {{ $s['icon_class'] }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
            </div>
            <div class="stat-card__body">
                <p class="stat-card__label">{{ $s['label'] }}</p>
                <p class="stat-card__value">{{ $this->stats[$s['key']] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ══════════════════════════════════════
         TABLE PANEL
    ══════════════════════════════════════ --}}
    <div class="panel animate-fade-up delay-100">

        {{-- Toolbar --}}
        <div class="table-toolbar">
            <div class="table-toolbar__left">

                <div class="search-input">
                    <svg class="search-input__icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input
                        wire:model.live.debounce.400ms="search"
                        type="text"
                        placeholder="Search announcements…"
                    />
                </div>

                <select wire:model.live="category" class="form-select" style="width:auto;padding-block:.5rem;">
                    <option value="">All Categories</option>
                    <option value="Academic">Academic</option>
                    <option value="Notice">Notice</option>
                    <option value="Health">Health</option>
                    <option value="Community">Community</option>
                    <option value="General">General</option>
                </select>

                <select wire:model.live="status" class="form-select" style="width:auto;padding-block:.5rem;">
                    <option value="">All Statuses</option>
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                </select>

            </div>
            <div class="table-toolbar__right">

                @if(count($selected) > 0)
                    <span style="font-size:var(--text-xs);color:var(--admin-text-muted);">
                        {{ count($selected) }} selected
                    </span>
                    {{-- CHANGED: opens modal instead of wire:confirm --}}
                    <button
                        wire:click="$set('showBulkDeleteModal', true)"
                        class="btn btn--danger-soft btn--sm">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Delete Selected
                    </button>
                @endif

            </div>
        </div>

        <div wire:loading wire:target="search,category,status,sort,bulkDelete,export" class="table-loading-bar"></div>

        <div class="panel__body--flush">
            <table class="data-table">
                <thead>
                    <tr>
                        <th class="td-check">
                            <input wire:model.live="selectAll" type="checkbox" aria-label="Select all"/>
                        </th>
                        <th>
                            <button wire:click="sort('title')" class="sort-btn">
                                Title
                                @if($sortBy === 'title')
                                    <span class="sort-icon">{{ $sortDir === 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </button>
                        </th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Pinned</th>
                        <th>
                            <button wire:click="sort('post_date')" class="sort-btn">
                                Date Posted
                                @if($sortBy === 'post_date')
                                    <span class="sort-icon">{{ $sortDir === 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </button>
                        </th>
                        <th>Author</th>
                        <th class="td-actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($this->announcements as $ann)
                    <tr wire:key="ann-{{ $ann->id }}">

                        <td class="td-check">
                            <input wire:model.live="selected" type="checkbox" value="{{ $ann->id }}" aria-label="Select row"/>
                        </td>

                        <td>
                            <p class="cell-title">{{ $ann->title }}</p>
                            <p class="cell-excerpt">{{ Str::limit($ann->body, 60) }}</p>
                        </td>

                        <td>
                            <span class="badge {{ $ann->category_color }}">{{ $ann->category }}</span>
                        </td>

                        <td>
                            <span class="badge {{ $ann->status_color }}">{{ ucfirst($ann->status) }}</span>
                        </td>

                        <td>
                            @if($ann->is_pinned)
                                <span class="badge badge--blue">📌 Pinned</span>
                            @else
                                <span style="color:var(--admin-text-subtle);font-size:var(--text-xs);">—</span>
                            @endif
                        </td>

                        <td style="white-space:nowrap;color:var(--admin-text-muted);">
                            {{ $ann->post_date->format('M j, Y') }}
                        </td>

                        <td>
                            <div class="cell-author">
                                <div class="cell-author__avatar">
                                    {{ strtoupper(substr($ann->author?->name ?? 'A', 0, 1)) }}
                                </div>
                                <span>{{ $ann->author?->name ?? 'Admin' }}</span>
                            </div>
                        </td>

                        <td class="td-actions">
                            <div class="table-actions">
                                <button wire:click="openEditModal({{ $ann->id }})" class="btn btn--ghost btn--icon btn--sm tooltip" data-tip="Edit" aria-label="Edit">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <button class="btn btn--ghost btn--icon btn--sm tooltip" data-tip="View" aria-label="View">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                                <button wire:click="openDeleteModal({{ $ann->id }})" class="btn btn--danger-soft btn--icon btn--sm tooltip" data-tip="Delete" aria-label="Delete">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                                <p class="empty-state__title">No announcements found</p>
                                <p class="empty-state__text">
                                    @if($search || $category || $status)
                                        Try adjusting your search or filters.
                                    @else
                                        Create your first announcement to get started.
                                    @endif
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="panel__footer">
            <span style="font-size:var(--text-xs);color:var(--admin-text-muted);">
                Showing {{ $this->announcements->firstItem() }}–{{ $this->announcements->lastItem() }}
                of {{ $this->announcements->total() }} announcements
            </span>
            {{ $this->announcements->links('vendor.pagination.admin') }}
        </div>

    </div>

    {{-- ══════════════════════════════════════
         MODAL: CREATE
    ══════════════════════════════════════ --}}
    @if($showCreateModal)
    <div class="modal-overlay open" role="dialog" aria-modal="true" aria-labelledby="modalCreateTitle" wire:keydown.escape="$set('showCreateModal', false)">
        <div class="modal modal--lg" wire:click.stop>
            <div class="modal__header">
                <div>
                    <h2 class="modal__title" id="modalCreateTitle">New Announcement</h2>
                    <p class="modal__subtitle">Fill in the details to publish a new announcement.</p>
                </div>
                <button wire:click="$set('showCreateModal', false)" class="modal__close" aria-label="Close">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="modal__body">
                @include('livewire.admin.partials.announcement-form')
            </div>
            <div class="modal__footer">
                <button wire:click="$set('showCreateModal', false)" class="btn btn--secondary">Cancel</button>
                <button wire:click="save('draft')" class="btn btn--secondary" wire:loading.attr="disabled">Save as Draft</button>
                <button wire:click="save('publish')" class="btn btn--primary" wire:loading.attr="disabled">
                    <span wire:loading wire:target="save" class="btn-spinner"></span>
                    Publish Now
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- ══════════════════════════════════════
         MODAL: EDIT
    ══════════════════════════════════════ --}}
    @if($showEditModal)
    <div class="modal-overlay open" role="dialog" aria-modal="true" aria-labelledby="modalEditTitle" wire:keydown.escape="$set('showEditModal', false)">
        <div class="modal modal--lg" wire:click.stop>
            <div class="modal__header">
                <div>
                    <h2 class="modal__title" id="modalEditTitle">Edit Announcement</h2>
                    <p class="modal__subtitle">Update the details of this announcement.</p>
                </div>
                <button wire:click="$set('showEditModal', false)" class="modal__close" aria-label="Close">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="modal__body">
                @include('livewire.admin.partials.announcement-form')
            </div>
            <div class="modal__footer">
                <button wire:click="$set('showEditModal', false)" class="btn btn--secondary">Cancel</button>
                <button wire:click="update" class="btn btn--primary" wire:loading.attr="disabled">
                    <span wire:loading wire:target="update" class="btn-spinner"></span>
                    Save Changes
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- ══════════════════════════════════════
         MODAL: DELETE SINGLE
    ══════════════════════════════════════ --}}
    @if($showDeleteModal)
    <div class="modal-overlay open" role="dialog" aria-modal="true" wire:keydown.escape="$set('showDeleteModal', false)">
        <div class="modal modal--sm" wire:click.stop>
            <div class="modal__body" style="text-align:center;padding-top:var(--space-8);">
                <div class="modal--confirm">
                    <div class="modal__icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </div>
                </div>
                <h3 style="font-size:var(--text-lg);font-weight:700;color:var(--admin-text-heading);margin-bottom:var(--space-3);">
                    Delete Announcement?
                </h3>
                <p style="font-size:var(--text-sm);color:var(--admin-text-muted);max-width:300px;margin:0 auto;">
                    This action cannot be undone. The announcement will be removed from the public site.
                </p>
            </div>
            <div class="modal__footer" style="justify-content:center;">
                <button wire:click="$set('showDeleteModal', false)" class="btn btn--secondary">Cancel</button>
                <button wire:click="delete" class="btn btn--danger" wire:loading.attr="disabled">
                    <span wire:loading wire:target="delete" class="btn-spinner"></span>
                    Yes, Delete
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- ══════════════════════════════════════
         MODAL: BULK DELETE
    ══════════════════════════════════════ --}}
    @if($showBulkDeleteModal)
    <div class="modal-overlay open" role="dialog" aria-modal="true" wire:keydown.escape="$set('showBulkDeleteModal', false)">
        <div class="modal modal--sm" wire:click.stop>

            <div class="modal__body" style="text-align:center;padding-top:var(--space-8);padding-bottom:var(--space-4);">

                {{-- Danger icon --}}
                <div class="modal--confirm">
                    <div class="modal__icon modal__icon--danger">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </div>
                </div>

                {{-- Count badge --}}
                <div style="margin-bottom:var(--space-4);">
                    <span class="badge badge--danger" style="font-size:var(--text-sm);padding:var(--space-1) var(--space-4);">
                        {{ count($selected) }} {{ count($selected) === 1 ? 'Announcement' : 'Announcements' }} Selected
                    </span>
                </div>

                <h3 style="font-size:var(--text-lg);font-weight:700;color:var(--admin-text-heading);margin-bottom:var(--space-3);">
                    Delete All Selected?
                </h3>

                <p style="font-size:var(--text-sm);color:var(--admin-text-muted);max-width:300px;margin:0 auto var(--space-5);">
                    You are about to permanently delete
                    <strong style="color:var(--color-danger);">{{ count($selected) }} {{ count($selected) === 1 ? 'announcement' : 'announcements' }}</strong>.
                    This cannot be undone and they will be removed from the public site immediately.
                </p>

                {{-- Warning note --}}
                <div style="background:var(--color-danger-light);border:1px solid rgba(220,38,38,.2);border-radius:var(--radius-md);padding:var(--space-3) var(--space-4);margin:0 auto;max-width:300px;display:flex;align-items:center;gap:var(--space-2);">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;flex-shrink:0;color:var(--color-danger);">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <span style="font-size:var(--text-xs);color:var(--color-danger);font-weight:600;">
                        Pinned announcements will also be deleted.
                    </span>
                </div>

            </div>

            <div class="modal__footer" style="justify-content:center;gap:var(--space-3);">
                <button wire:click="$set('showBulkDeleteModal', false)" class="btn btn--secondary">
                    Cancel
                </button>
                <button wire:click="bulkDelete" class="btn btn--danger" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="bulkDelete">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;display:inline;margin-right:4px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete {{ count($selected) }} {{ count($selected) === 1 ? 'Announcement' : 'Announcements' }}
                    </span>
                    <span wire:loading wire:target="bulkDelete" class="btn-spinner"></span>
                </button>
            </div>

        </div>
    </div>
    @endif

</div>
