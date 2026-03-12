{{-- resources/views/admin/achievements/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Achievements')
@section('breadcrumb', 'Achievements')
@section('page-title', 'Achievements & Honor Roll')
@section('page-subtitle', 'Manage student honors, competition wins, and academic recognitions.')

@section('page-actions')
    <button class="btn btn--secondary btn--sm" id="btnCreateCompetition" onclick="openModal('modalCreateCompetition')">
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Add Competition Win
    </button>
    <button class="btn btn--primary" id="btnCreateHonor" onclick="openModal('modalCreateHonor')">
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Add Honor Student
    </button>
@endsection

@section('content')

    {{-- --- Tabs --- --}}
    @php
        $currentTab = $tab ?? 'honor';
        $honorUrl = route('admin.achievements.index', array_merge(request()->query(), ['tab' => 'honor']));
        $compUrl  = route('admin.achievements.index', array_merge(request()->query(), ['tab' => 'competition']));
    @endphp
    <div style="display:flex;gap:var(--space-2);margin-bottom:var(--space-6);" role="tablist">
        <a href="{{ $honorUrl }}"
           class="btn {{ $currentTab === 'honor' ? 'btn--primary' : 'btn--secondary' }} btn--sm"
           role="tab"
           aria-selected="{{ $currentTab === 'honor' ? 'true' : 'false' }}">
            Honor Roll
        </a>
        <a href="{{ $compUrl }}"
           class="btn {{ $currentTab === 'competition' ? 'btn--primary' : 'btn--secondary' }} btn--sm"
           role="tab"
           aria-selected="{{ $currentTab === 'competition' ? 'true' : 'false' }}">
            Competition Wins
        </a>
    </div>

    {{-- --- HONOR ROLL TAB --- --}}
    <div id="panel-honor" style="{{ $currentTab === 'honor' ? '' : 'display:none;' }}">

        <div class="panel animate-fade-up">
            <div class="panel__header">
                <div>
                    <p class="panel__title">Honor Roll Students</p>
                    <p class="panel__subtitle">Students with highest academic performance - shown on the public achievements page</p>
                </div>
                <form method="GET" action="{{ route('admin.achievements.index') }}" class="panel__header-actions">
                    <input type="hidden" name="tab" value="honor" />
                    @php
                        $years = ['2025-2026', '2024-2025', '2023-2024'];
                    @endphp
                    <select name="school_year" class="form-select" style="width:auto;padding-block:.5rem;" onchange="this.form.submit()">
                        @foreach($years as $year)
                            <option value="{{ $year }}" {{ ($schoolYear ?? '') === $year ? 'selected' : '' }}>
                                S.Y. {{ $year }}
                            </option>
                        @endforeach
                    </select>
                    @php
                        $quarters = ['All Quarters', '1st Quarter', '2nd Quarter', '3rd Quarter', '4th Quarter', 'Final'];
                    @endphp
                    <select name="quarter" class="form-select" style="width:auto;padding-block:.5rem;" onchange="this.form.submit()">
                        @foreach($quarters as $q)
                            <option value="{{ $q === 'All Quarters' ? '' : $q }}" {{ ($quarter ?? '') === ($q === 'All Quarters' ? '' : $q) ? 'selected' : '' }}>
                                {{ $q }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="panel__body--flush">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="td-check"><input type="checkbox" aria-label="Select all"/></th>
                            <th>Rank</th>
                            <th class="sortable">Student Name</th>
                            <th>Grade &amp; Section</th>
                            <th class="sortable">GWA</th>
                            <th>Honors</th>
                            <th>Quarter</th>
                            <th>S.Y.</th>
                            <th class="td-actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($honorees as $h)
                        <tr>
                            <td class="td-check"><input type="checkbox" class="row-check" aria-label="Select row"/></td>
                            <td>
                                @php
                                    $rank = ($honorees->firstItem() ?? 1) + $loop->index;
                                    $rankColor = $rank === 1 ? '#d97706' : ($rank === 2 ? '#94a3b8' : ($rank === 3 ? '#b45309' : 'var(--admin-text-muted)'));
                                @endphp
                                <span style="font-family:var(--font-display);font-size:var(--text-lg);font-weight:800;color:{{ $rankColor }};">
                                    {{ $rank }}
                                </span>
                            </td>
                            <td>
                                <div class="cell-author">
                                    <div class="cell-author__avatar">{{ strtoupper(substr($h->student_name,0,1)) }}</div>
                                    <span class="cell-title">{{ $h->student_name }}</span>
                                </div>
                            </td>
                            <td style="color:var(--admin-text-muted);">{{ $h->grade }} - {{ $h->section ?? '-' }}</td>
                            <td>
                                <span style="font-weight:700;color:var(--admin-text-heading);">{{ $h->gwa }}</span>
                            </td>
                            <td>
                                <span class="badge {{ $h->honors_color }}">
                                    {{ $h->honors }}
                                </span>
                            </td>
                            <td style="color:var(--admin-text-muted);">{{ $h->quarter }}</td>
                            <td style="color:var(--admin-text-muted);">{{ $h->school_year }}</td>
                            <td class="td-actions">
                                <div class="table-actions">
                                    <button class="btn btn--ghost btn--icon btn--sm tooltip js-edit-honor" data-tip="Edit"
                                            data-update-action="{{ route('admin.achievements.update', $h) }}"
                                            data-student-name="{{ $h->student_name }}"
                                            data-grade="{{ $h->grade }}"
                                            data-section="{{ $h->section ?? '' }}"
                                            data-gwa="{{ $h->gwa }}"
                                            data-honors="{{ $h->honors }}"
                                            data-quarter="{{ $h->quarter }}"
                                            data-school-year="{{ $h->school_year }}"
                                            onclick="openModal('modalCreateHonor')" aria-label="Edit">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button class="btn btn--danger-soft btn--icon btn--sm tooltip" data-tip="Delete"
                                            data-delete-action="{{ route('admin.achievements.destroy', $h) }}" onclick="openModal('modalDeleteConfirm')" aria-label="Delete">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <p class="empty-state__title">No honor roll records yet</p>
                                    <p class="empty-state__desc">Add honor students to feature them on the public achievements page.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="panel__footer">
                <span style="font-size:var(--text-xs);color:var(--admin-text-muted);">
                    @if($honorees->total() > 0)
                        Showing {{ $honorees->firstItem() }}-{{ $honorees->lastItem() }} of {{ $honorees->total() }} students
                    @else
                        Showing 0 students
                    @endif
                </span>
                {{ $honorees->links('vendor.pagination.admin') }}
            </div>
        </div>

    </div>

    {{-- --- COMPETITION WINS TAB --- --}}
    <div id="panel-comp" style="{{ $currentTab === 'competition' ? '' : 'display:none;' }}">

        <div class="panel animate-fade-in">
            <div class="panel__header">
                <div>
                    <p class="panel__title">Competition Wins</p>
                    <p class="panel__subtitle">Awards and placements from competitions and contests</p>
                <form method="GET" action="{{ route('admin.achievements.index') }}" class="panel__header-actions">
                    <input type="hidden" name="tab" value="competition" />
                    <div class="search-input" style="min-width:180px;">
                        <svg class="search-input__icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="search" placeholder="Search competitions..." value="{{ request('search') }}" />
                    </div>
                    <button type="submit" class="btn btn--secondary btn--sm">Search</button>
                </form>
                </div>
            </div>
            <div class="panel__body--flush">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="td-check"><input type="checkbox" aria-label="Select all"/></th>
                            <th>Competition</th>
                            <th>Student(s)</th>
                            <th>Category</th>
                            <th>Level</th>
                            <th>Place</th>
                            <th>Date</th>
                            <th class="td-actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                                                @forelse($competitions as $w)
                        <tr>
                            <td class="td-check"><input type="checkbox" class="row-check" aria-label="Select row"/></td>
                            <td><p class="cell-title">{{ $w->competition_name }}</p></td>
                            <td>
                                <div class="cell-author">
                                    <div class="cell-author__avatar">{{ strtoupper(substr($w->student_names ?? 'S',0,1)) }}</div>
                                    <span>{{ $w->student_names ?? '-' }}</span>
                                </div>
                            </td>
                            <td style="color:var(--admin-text-muted);">{{ $w->category ?? '-' }}</td>
                            <td><span class="badge badge--gray">{{ $w->level }}</span></td>
                            <td><span class="badge {{ $w->place_color }}">{{ $w->place }}</span></td>
                            <td style="color:var(--admin-text-muted);">{{ $w->event_date?->format('M Y') ?? '-' }}</td>
                            <td class="td-actions">
                                <div class="table-actions">
                                    <button class="btn btn--ghost btn--icon btn--sm tooltip js-edit-competition" data-tip="Edit"
                                            data-update-action="{{ route('admin.achievements.update', $w) }}"
                                            data-competition-name="{{ $w->competition_name }}"
                                            data-student-names="{{ $w->student_names ?? '' }}"
                                            data-category="{{ $w->category ?? '' }}"
                                            data-level="{{ $w->level }}"
                                            data-place="{{ $w->place }}"
                                            data-event-date="{{ $w->event_date?->format('Y-m') ?? '' }}"
                                            onclick="openModal('modalCreateCompetition')" aria-label="Edit">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button class="btn btn--danger-soft btn--icon btn--sm tooltip" data-tip="Delete"
                                            data-delete-action="{{ route('admin.achievements.destroy', $w) }}" onclick="openModal('modalDeleteConfirm')" aria-label="Delete">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                    <p class="empty-state__title">No competition wins yet</p>
                                    <p class="empty-state__desc">Add a competition win to highlight student achievements.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="panel__footer">
                <span style="font-size:var(--text-xs);color:var(--admin-text-muted);">
                    @if($competitions->total() > 0)
                        Showing {{ $competitions->firstItem() }}-{{ $competitions->lastItem() }} of {{ $competitions->total() }} records
                    @else
                        Showing 0 records
                    @endif
                </span>
                {{ $competitions->links('vendor.pagination.admin') }}
            </div>
        </div>

    </div>

    {{-- MODAL: Add Honor Student --}}
    <div class="modal-overlay" id="modalCreateHonor" role="dialog" aria-modal="true" aria-labelledby="modalHonorTitle">
        <div class="modal">
            <div class="modal__header">
                <div>
                    <h2 class="modal__title" id="modalHonorTitle">Add Honor Student</h2>
                    <p class="modal__subtitle" id="modalHonorSubtitle">Add a student to the honor roll.</p>
                </div>
                <button class="modal__close" onclick="closeModal('modalCreateHonor')" aria-label="Close">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.achievements.store') }}" id="honorForm" data-store-action="{{ route('admin.achievements.store') }}">
                @csrf
                <input type="hidden" name="_method" value="PUT" id="honorMethod" disabled>
                <input type="hidden" name="type" value="honor"/>
                <div class="modal__body">
                    <div class="form-group">
                        <label class="form-label" for="h_name">Student Full Name</label>
                        <input class="form-input" type="text" id="h_name" name="student_name"
                               placeholder="e.g. Maria Santos" required/>
                    </div>
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label" for="h_grade">Grade Level</label>
                            <select class="form-select" id="h_grade" name="grade" required>
                                <option value="">Select grade...</option>
                                @for($g = 1; $g <= 6; $g++)
                                    <option>Grade {{ $g }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="h_section">Section</label>
                            <input class="form-input" type="text" id="h_section" name="section" placeholder="e.g. Maharlika"/>
                        </div>
                    </div>
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label" for="h_gwa">General Weighted Average</label>
                            <input class="form-input" type="number" id="h_gwa" name="gwa" step="0.01" min="75" max="100" placeholder="e.g. 98.5" required/>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="h_honors">Honors Classification</label>
                            <select class="form-select" id="h_honors" name="honors">
                                <option>With Highest Honors</option>
                                <option>With High Honors</option>
                                <option>With Honors</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label" for="h_quarter">Quarter</label>
                            <select class="form-select" id="h_quarter" name="quarter">
                                <option>1st Quarter</option>
                                <option>2nd Quarter</option>
                                <option>3rd Quarter</option>
                                <option>4th Quarter</option>
                                <option>Final</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="h_sy">School Year</label>
                            <input class="form-input" type="text" id="h_sy" name="school_year" value="2025-2026"/>
                        </div>
                    </div>
                </div>
                <div class="modal__footer">
                    <button type="button" class="btn btn--secondary" onclick="closeModal('modalCreateHonor')">Cancel</button>
                    <button type="submit" class="btn btn--primary" id="honorSubmit">Save Student</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL: Add Competition Win --}}
    <div class="modal-overlay" id="modalCreateCompetition" role="dialog" aria-modal="true" aria-labelledby="modalCompTitle">
        <div class="modal">
            <div class="modal__header">
                <div>
                    <h2 class="modal__title" id="modalCompTitle">Add Competition Win</h2>
                    <p class="modal__subtitle" id="modalCompSubtitle">Record an award or recognition from a competition.</p>
                </div>
                <button class="modal__close" onclick="closeModal('modalCreateCompetition')" aria-label="Close">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.achievements.store') }}" id="compForm" data-store-action="{{ route('admin.achievements.store') }}">
                @csrf
                <input type="hidden" name="_method" value="PUT" id="compMethod" disabled>
                <input type="hidden" name="type" value="competition"/>
                <div class="modal__body">
                    <div class="form-group">
                        <label class="form-label" for="c_comp">Competition Name</label>
                        <input class="form-input" type="text" id="c_comp" name="competition_name"
                               placeholder="e.g. Regional Science Quiz Bee" required/>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="c_student">Student Name(s)</label>
                        <input class="form-input" type="text" id="c_student" name="student_names"
                               placeholder="e.g. Maria Santos, Juan dela Cruz"/>
                    </div>
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label" for="c_cat">Category / Subject</label>
                            <input class="form-input" type="text" id="c_cat" name="category"
                                   placeholder="e.g. Science, Arts, Sports"/>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="c_level">Competition Level</label>
                            <select class="form-select" id="c_level" name="level">
                                <option>School</option>
                                <option>District</option>
                                <option>Division</option>
                                <option>Regional</option>
                                <option>National</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label" for="c_place">Placement / Award</label>
                            <select class="form-select" id="c_place" name="place">
                                <option>1st Place</option>
                                <option>2nd Place</option>
                                <option>3rd Place</option>
                                <option>Finalist</option>
                                <option>Special Award</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="c_date">Date / Month</label>
                            <input class="form-input" type="month" id="c_date" name="event_date"/>
                        </div>
                    </div>
                </div>
                <div class="modal__footer">
                    <button type="button" class="btn btn--secondary" onclick="closeModal('modalCreateCompetition')">Cancel</button>
                    <button type="submit" class="btn btn--primary" id="compSubmit">Save Achievement</button>
                </div>
            </form>
        </div>
    </div>

    @include('partials.admin.modal-delete', ['label' => 'achievement'])

@endsection

@push('scripts')
<script>
    document.querySelectorAll('[data-delete-action]').forEach(btn => {
        btn.addEventListener('click', () => {
            const form = document.getElementById('deleteForm');
            if (form) form.action = btn.getAttribute('data-delete-action');
        });
    });

    const honorForm = document.getElementById('honorForm');
    const honorMethod = document.getElementById('honorMethod');
    const honorTitle = document.getElementById('modalHonorTitle');
    const honorSubtitle = document.getElementById('modalHonorSubtitle');
    const honorSubmit = document.getElementById('honorSubmit');
    const honorStoreAction = honorForm ? honorForm.dataset.storeAction : null;

    const compForm = document.getElementById('compForm');
    const compMethod = document.getElementById('compMethod');
    const compTitle = document.getElementById('modalCompTitle');
    const compSubtitle = document.getElementById('modalCompSubtitle');
    const compSubmit = document.getElementById('compSubmit');
    const compStoreAction = compForm ? compForm.dataset.storeAction : null;

    const setHonorCreate = () => {
        if (!honorForm) return;
        honorForm.reset();
        if (honorStoreAction) honorForm.action = honorStoreAction;
        if (honorMethod) honorMethod.disabled = true;
        if (honorTitle) honorTitle.textContent = 'Add Honor Student';
        if (honorSubtitle) honorSubtitle.textContent = 'Add a student to the honor roll.';
        if (honorSubmit) honorSubmit.textContent = 'Save Student';
    };

    const setCompCreate = () => {
        if (!compForm) return;
        compForm.reset();
        if (compStoreAction) compForm.action = compStoreAction;
        if (compMethod) compMethod.disabled = true;
        if (compTitle) compTitle.textContent = 'Add Competition Win';
        if (compSubtitle) compSubtitle.textContent = 'Record an award or recognition from a competition.';
        if (compSubmit) compSubmit.textContent = 'Save Achievement';
    };

    const openModalSafe = (id) => {
        const el = document.getElementById(id);
        if (!el) return;
        el.classList.add('open');
        document.body.style.overflow = 'hidden';
    };

    const btnCreateHonor = document.getElementById('btnCreateHonor');
    if (btnCreateHonor) btnCreateHonor.addEventListener('click', (event) => {
        event.preventDefault();
        setHonorCreate();
        if (typeof openModal === 'function') {
            openModal('modalCreateHonor');
        } else {
            openModalSafe('modalCreateHonor');
        }
    });

    const btnCreateCompetition = document.getElementById('btnCreateCompetition');
    if (btnCreateCompetition) btnCreateCompetition.addEventListener('click', (event) => {
        event.preventDefault();
        setCompCreate();
        if (typeof openModal === 'function') {
            openModal('modalCreateCompetition');
        } else {
            openModalSafe('modalCreateCompetition');
        }
    });

    document.querySelectorAll('.js-edit-honor').forEach(btn => {
        btn.addEventListener('click', () => {
            if (!honorForm) return;
            if (btn.dataset.updateAction) honorForm.action = btn.dataset.updateAction;
            if (honorMethod) honorMethod.disabled = false;
            if (honorTitle) honorTitle.textContent = 'Edit Honor Student';
            if (honorSubtitle) honorSubtitle.textContent = 'Update the honor roll record.';
            if (honorSubmit) honorSubmit.textContent = 'Save Changes';

            const nameInput = document.getElementById('h_name');
            if (nameInput) nameInput.value = btn.dataset.studentName || '';
            const gradeInput = document.getElementById('h_grade');
            if (gradeInput) gradeInput.value = btn.dataset.grade || '';
            const sectionInput = document.getElementById('h_section');
            if (sectionInput) sectionInput.value = btn.dataset.section || '';
            const gwaInput = document.getElementById('h_gwa');
            if (gwaInput) gwaInput.value = btn.dataset.gwa || '';
            const honorsInput = document.getElementById('h_honors');
            if (honorsInput) honorsInput.value = btn.dataset.honors || '';
            const quarterInput = document.getElementById('h_quarter');
            if (quarterInput) quarterInput.value = btn.dataset.quarter || '';
            const syInput = document.getElementById('h_sy');
            if (syInput) syInput.value = btn.dataset.schoolYear || '';
        });
    });

    document.querySelectorAll('.js-edit-competition').forEach(btn => {
        btn.addEventListener('click', () => {
            if (!compForm) return;
            if (btn.dataset.updateAction) compForm.action = btn.dataset.updateAction;
            if (compMethod) compMethod.disabled = false;
            if (compTitle) compTitle.textContent = 'Edit Competition Win';
            if (compSubtitle) compSubtitle.textContent = 'Update the competition record.';
            if (compSubmit) compSubmit.textContent = 'Save Changes';

            const compInput = document.getElementById('c_comp');
            if (compInput) compInput.value = btn.dataset.competitionName || '';
            const studentInput = document.getElementById('c_student');
            if (studentInput) studentInput.value = btn.dataset.studentNames || '';
            const categoryInput = document.getElementById('c_cat');
            if (categoryInput) categoryInput.value = btn.dataset.category || '';
            const levelInput = document.getElementById('c_level');
            if (levelInput) levelInput.value = btn.dataset.level || '';
            const placeInput = document.getElementById('c_place');
            if (placeInput) placeInput.value = btn.dataset.place || '';
            const dateInput = document.getElementById('c_date');
            if (dateInput) dateInput.value = btn.dataset.eventDate || '';
        });
    });
</script>
@endpush


















