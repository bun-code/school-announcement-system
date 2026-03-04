{{-- resources/views/admin/announcements/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Announcements')
@section('breadcrumb', 'Announcements')
@section('page-title', 'Announcements')
@section('page-subtitle', 'Manage all school announcements published to the public site.')

@section('page-actions')
    <button class="btn btn--secondary btn--sm" id="btnExport">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        Export
    </button>
    <button class="btn btn--primary" id="btnCreateAnn" onclick="openModal('modalCreateAnn')">
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        New Announcement
    </button>
@endsection

@section('content')

    {{-- ── Stats row ── --}}
    <div class="stat-cards" style="grid-template-columns:repeat(4,1fr);">
        @php
            $stats = [
                ['label'=>'Total Posts','value'=>'12','icon_class'=>'stat-card__icon--blue'],
                ['label'=>'Published','value'=>'9','icon_class'=>'stat-card__icon--green'],
                ['label'=>'Drafts','value'=>'2','icon_class'=>'stat-card__icon--amber'],
                ['label'=>'Pinned','value'=>'1','icon_class'=>'stat-card__icon--purple'],
            ];
        @endphp
        @foreach($stats as $s)
        <div class="stat-card animate-fade-up">
            <div class="stat-card__icon {{ $s['icon_class'] }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
            </div>
            <div class="stat-card__body">
                <p class="stat-card__label">{{ $s['label'] }}</p>
                <p class="stat-card__value">{{ $s['value'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ── Table panel ── --}}
    <div class="panel animate-fade-up delay-100">

        {{-- Toolbar --}}
        <div class="table-toolbar">
            <div class="table-toolbar__left">
                <div class="search-input">
                    <svg class="search-input__icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" placeholder="Search announcements…" id="searchAnn"/>
                </div>
                <select class="form-select" style="width:auto;padding-block:.5rem;" id="filterCat">
                    <option value="">All Categories</option>
                    <option>Academic</option>
                    <option>Notice</option>
                    <option>Health</option>
                    <option>Community</option>
                    <option>General</option>
                </select>
                <select class="form-select" style="width:auto;padding-block:.5rem;" id="filterStatus">
                    <option value="">All Statuses</option>
                    <option>Published</option>
                    <option>Draft</option>
                </select>
            </div>
            <div class="table-toolbar__right">
                <span style="font-size:var(--text-xs);color:var(--admin-text-muted);" id="selCount"></span>
                <button class="btn btn--danger-soft btn--sm" id="btnBulkDelete" style="display:none;">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Delete Selected
                </button>
            </div>
        </div>

        {{-- Table --}}
        <div class="panel__body--flush">
            <table class="data-table" id="annTable">
                <thead>
                    <tr>
                        <th class="td-check">
                            <input type="checkbox" id="checkAll" aria-label="Select all"/>
                        </th>
                        <th class="sortable">Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Pinned</th>
                        <th class="sortable">Date Posted</th>
                        <th>Author</th>
                        <th class="td-actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $items = [
                            ['title'=>'Enrollment Now Open','excerpt'=>'S.Y. 2025–2026 enrollment for Grade 1','cat'=>'General','cat_class'=>'badge--blue','status'=>'Published','status_class'=>'badge--green','pinned'=>true,'date'=>'Mar 1, 2026','author'=>'Admin'],
                            ['title'=>'3rd Quarter Exam Schedule','excerpt'=>'Examination schedule for all grade levels','cat'=>'Academic','cat_class'=>'badge--purple','status'=>'Published','status_class'=>'badge--green','pinned'=>false,'date'=>'Feb 28, 2026','author'=>'Admin'],
                            ['title'=>'Early Dismissal – Feb 26','excerpt'=>'Classes end at 11:00 AM','cat'=>'Notice','cat_class'=>'badge--orange','status'=>'Published','status_class'=>'badge--green','pinned'=>false,'date'=>'Feb 25, 2026','author'=>'Admin'],
                            ['title'=>'School Feeding Program Resumes','excerpt'=>'DepEd-funded program restarts March 3','cat'=>'Health','cat_class'=>'badge--amber','status'=>'Draft','status_class'=>'badge--gray','pinned'=>false,'date'=>'Feb 20, 2026','author'=>'Admin'],
                            ['title'=>'Brigada Eskwela Volunteers Needed','excerpt'=>'Call for parent & community volunteers','cat'=>'Community','cat_class'=>'badge--green','status'=>'Draft','status_class'=>'badge--gray','pinned'=>false,'date'=>'Feb 18, 2026','author'=>'Admin'],
                        ];
                    @endphp
                    @foreach($items as $i => $ann)
                    <tr>
                        <td class="td-check">
                            <input type="checkbox" class="row-check" value="{{ $i }}" aria-label="Select row"/>
                        </td>
                        <td>
                            <p class="cell-title">{{ $ann['title'] }}</p>
                            <p class="cell-excerpt">{{ $ann['excerpt'] }}</p>
                        </td>
                        <td><span class="badge {{ $ann['cat_class'] }}">{{ $ann['cat'] }}</span></td>
                        <td><span class="badge {{ $ann['status_class'] }}">{{ $ann['status'] }}</span></td>
                        <td>
                            @if($ann['pinned'])
                                <span class="badge badge--blue">📌 Pinned</span>
                            @else
                                <span style="color:var(--admin-text-subtle);font-size:var(--text-xs);">—</span>
                            @endif
                        </td>
                        <td style="white-space:nowrap;color:var(--admin-text-muted);">{{ $ann['date'] }}</td>
                        <td>
                            <div class="cell-author">
                                <div class="cell-author__avatar">A</div>
                                <span>{{ $ann['author'] }}</span>
                            </div>
                        </td>
                        <td class="td-actions">
                            <div class="table-actions">
                                <button class="btn btn--ghost btn--icon btn--sm tooltip" data-tip="Edit"
                                        onclick="openModal('modalEditAnn')" aria-label="Edit">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <button class="btn btn--ghost btn--icon btn--sm tooltip" data-tip="View" aria-label="View">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                                <button class="btn btn--danger-soft btn--icon btn--sm tooltip" data-tip="Delete"
                                        onclick="openModal('modalDeleteConfirm')" aria-label="Delete">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="panel__footer">
            <span style="font-size:var(--text-xs);color:var(--admin-text-muted);">Showing 1–5 of 12 announcements</span>
            <div class="pagination">
                <button class="pagination__btn" aria-label="Previous">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button class="pagination__btn active">1</button>
                <button class="pagination__btn">2</button>
                <button class="pagination__btn">3</button>
                <button class="pagination__btn" aria-label="Next">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>

    </div>

    {{-- ════════════════════════════════════════
         MODAL: CREATE ANNOUNCEMENT
    ════════════════════════════════════════ --}}
    <div class="modal-overlay" id="modalCreateAnn" role="dialog" aria-modal="true" aria-labelledby="modalCreateAnnTitle">
        <div class="modal modal--lg">
            <div class="modal__header">
                <div>
                    <h2 class="modal__title" id="modalCreateAnnTitle">New Announcement</h2>
                    <p class="modal__subtitle">Fill in the details to publish a new announcement.</p>
                </div>
                <button class="modal__close" onclick="closeModal('modalCreateAnn')" aria-label="Close">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.announcements.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal__body">

                    <div class="form-group">
                        <label class="form-label" for="ann_title">Title</label>
                        <input class="form-input" type="text" id="ann_title" name="title"
                               placeholder="Enter announcement title…" required/>
                    </div>

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label" for="ann_category">Category</label>
                            <select class="form-select" id="ann_category" name="category" required>
                                <option value="">Select category…</option>
                                <option>General</option>
                                <option>Academic</option>
                                <option>Notice</option>
                                <option>Health</option>
                                <option>Community</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="ann_status">Status</label>
                            <select class="form-select" id="ann_status" name="status">
                                <option value="published">Published</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="ann_body">Content</label>
                        <textarea class="form-textarea" id="ann_body" name="body" rows="6"
                                  placeholder="Write the full announcement here…" required></textarea>
                    </div>

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label" for="ann_date">Post Date</label>
                            <input class="form-input" type="date" id="ann_date" name="post_date"
                                   value="{{ date('Y-m-d') }}"/>
                        </div>
                        <div class="form-group">
                            <label class="form-label form-label--optional" for="ann_expiry">Expiry Date</label>
                            <input class="form-input" type="date" id="ann_expiry" name="expiry_date"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-check">
                            <input type="checkbox" name="is_pinned" value="1"/>
                            <span class="form-check-label">📌 Pin this announcement to the top of the page</span>
                        </label>
                    </div>

                </div>
                <div class="modal__footer">
                    <button type="button" class="btn btn--secondary" onclick="closeModal('modalCreateAnn')">Cancel</button>
                    <button type="submit" name="action" value="draft" class="btn btn--secondary">Save as Draft</button>
                    <button type="submit" name="action" value="publish" class="btn btn--primary">Publish Now</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ════════════════════════════════════════
         MODAL: EDIT ANNOUNCEMENT
    ════════════════════════════════════════ --}}
    <div class="modal-overlay" id="modalEditAnn" role="dialog" aria-modal="true" aria-labelledby="modalEditAnnTitle">
        <div class="modal modal--lg">
            <div class="modal__header">
                <div>
                    <h2 class="modal__title" id="modalEditAnnTitle">Edit Announcement</h2>
                    <p class="modal__subtitle">Update the details of this announcement.</p>
                </div>
                <button class="modal__close" onclick="closeModal('modalEditAnn')" aria-label="Close">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form method="POST" action="#"> {{-- wire: route('admin.announcements.update', $id) --}}
                @csrf
                @method('PUT')
                <div class="modal__body">

                    <div class="form-group">
                        <label class="form-label" for="edit_ann_title">Title</label>
                        <input class="form-input" type="text" id="edit_ann_title" name="title"
                               value="Enrollment Now Open" required/>
                    </div>

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label" for="edit_ann_category">Category</label>
                            <select class="form-select" id="edit_ann_category" name="category">
                                <option selected>General</option>
                                <option>Academic</option>
                                <option>Notice</option>
                                <option>Health</option>
                                <option>Community</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="edit_ann_status">Status</label>
                            <select class="form-select" id="edit_ann_status" name="status">
                                <option value="published" selected>Published</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="edit_ann_body">Content</label>
                        <textarea class="form-textarea" id="edit_ann_body" name="body" rows="6">Enrollment for incoming Grade 1 and qualified transferees is officially open...</textarea>
                    </div>

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label" for="edit_ann_date">Post Date</label>
                            <input class="form-input" type="date" id="edit_ann_date" name="post_date" value="2026-03-01"/>
                        </div>
                        <div class="form-group">
                            <label class="form-label form-label--optional" for="edit_ann_expiry">Expiry Date</label>
                            <input class="form-input" type="date" id="edit_ann_expiry" name="expiry_date"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-check">
                            <input type="checkbox" name="is_pinned" value="1" checked/>
                            <span class="form-check-label">📌 Pin this announcement to the top of the page</span>
                        </label>
                    </div>

                </div>
                <div class="modal__footer">
                    <button type="button" class="btn btn--secondary" onclick="closeModal('modalEditAnn')">Cancel</button>
                    <button type="submit" class="btn btn--primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ════════════════════════════════════════
         MODAL: DELETE CONFIRM
    ════════════════════════════════════════ --}}
    <div class="modal-overlay" id="modalDeleteConfirm" role="dialog" aria-modal="true">
        <div class="modal modal--sm">
            <div class="modal__body" style="text-align:center;padding-top:var(--space-8);">
                <div class="modal--confirm">
                    <div class="modal__icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </div>
                </div>
                <h3 style="font-size:var(--text-lg);font-weight:700;color:var(--admin-text-heading);margin-bottom:var(--space-3);">Delete Announcement?</h3>
                <p style="font-size:var(--text-sm);color:var(--admin-text-muted);max-width:300px;margin:0 auto;">
                    This action cannot be undone. The announcement will be permanently removed from the public site.
                </p>
            </div>
            <div class="modal__footer" style="justify-content:center;">
                <button class="btn btn--secondary" onclick="closeModal('modalDeleteConfirm')">Cancel</button>
                <form method="POST" action="#" style="display:inline;"> {{-- wire: route('admin.announcements.destroy', $id) --}}
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn--danger">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // Checkbox select-all
    const checkAll  = document.getElementById('checkAll');
    const rowChecks = document.querySelectorAll('.row-check');
    const selCount  = document.getElementById('selCount');
    const bulkBtn   = document.getElementById('btnBulkDelete');

    function updateSelCount() {
        const checked = document.querySelectorAll('.row-check:checked').length;
        selCount.textContent = checked > 0 ? `${checked} selected` : '';
        bulkBtn.style.display = checked > 0 ? 'inline-flex' : 'none';
    }

    checkAll.addEventListener('change', () => {
        rowChecks.forEach(c => c.checked = checkAll.checked);
        updateSelCount();
    });

    rowChecks.forEach(c => c.addEventListener('change', updateSelCount));
</script>
@endpush