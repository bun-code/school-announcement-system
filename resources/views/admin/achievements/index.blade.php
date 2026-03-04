{{-- resources/views/admin/achievements/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Achievements')
@section('breadcrumb', 'Achievements')
@section('page-title', 'Achievements & Honor Roll')
@section('page-subtitle', 'Manage student honors, competition wins, and academic recognitions.')

@section('page-actions')
    <button class="btn btn--secondary btn--sm" onclick="openModal('modalCreateCompetition')">
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Add Competition Win
    </button>
    <button class="btn btn--primary" onclick="openModal('modalCreateHonor')">
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Add Honor Student
    </button>
@endsection

@section('content')

    {{-- ── Tabs ── --}}
    <div style="display:flex;gap:var(--space-2);margin-bottom:var(--space-6);" role="tablist">
        <button class="btn btn--primary btn--sm" role="tab" aria-selected="true" id="tab-honor" onclick="switchTab('honor')">Honor Roll</button>
        <button class="btn btn--secondary btn--sm" role="tab" aria-selected="false" id="tab-comp" onclick="switchTab('comp')">Competition Wins</button>
    </div>

    {{-- ── HONOR ROLL TAB ── --}}
    <div id="panel-honor">

        <div class="panel animate-fade-up">
            <div class="panel__header">
                <div>
                    <p class="panel__title">Honor Roll Students</p>
                    <p class="panel__subtitle">Students with highest academic performance — shown on the public achievements page</p>
                </div>
                <div class="panel__header-actions">
                    <select class="form-select" style="width:auto;padding-block:.5rem;">
                        <option>S.Y. 2025–2026</option>
                        <option>S.Y. 2024–2025</option>
                    </select>
                    <select class="form-select" style="width:auto;padding-block:.5rem;">
                        <option>All Quarters</option>
                        <option>3rd Quarter</option>
                        <option>2nd Quarter</option>
                        <option>1st Quarter</option>
                    </select>
                </div>
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
                        @php
                            $honorees = [
                                ['rank'=>1,'name'=>'Maria Santos','grade'=>'Grade 6','section'=>'Maharlika','gwa'=>'99.2','honors'=>'Highest Honors','quarter'=>'3rd','sy'=>'2025–26'],
                                ['rank'=>2,'name'=>'Juan dela Cruz','grade'=>'Grade 6','section'=>'Kalayaan','gwa'=>'98.8','honors'=>'Highest Honors','quarter'=>'3rd','sy'=>'2025–26'],
                                ['rank'=>3,'name'=>'Ana Reyes','grade'=>'Grade 5','section'=>'Katipunan','gwa'=>'98.4','honors'=>'Highest Honors','quarter'=>'3rd','sy'=>'2025–26'],
                                ['rank'=>4,'name'=>'Carlo Bautista','grade'=>'Grade 6','section'=>'Maharlika','gwa'=>'97.9','honors'=>'With Honors','quarter'=>'3rd','sy'=>'2025–26'],
                                ['rank'=>5,'name'=>'Liza Gomez','grade'=>'Grade 4','section'=>'Rizal','gwa'=>'97.5','honors'=>'With Honors','quarter'=>'3rd','sy'=>'2025–26'],
                            ];
                        @endphp
                        @foreach($honorees as $h)
                        <tr>
                            <td class="td-check"><input type="checkbox" class="row-check" aria-label="Select row"/></td>
                            <td>
                                <span style="font-family:var(--font-display);font-size:var(--text-lg);font-weight:800;color:{{ $h['rank'] === 1 ? '#d97706' : ($h['rank'] === 2 ? '#94a3b8' : ($h['rank'] === 3 ? '#b45309' : 'var(--admin-text-muted)')) }};">
                                    {{ $h['rank'] }}
                                </span>
                            </td>
                            <td>
                                <div class="cell-author">
                                    <div class="cell-author__avatar">{{ strtoupper(substr($h['name'],0,1)) }}</div>
                                    <span class="cell-title">{{ $h['name'] }}</span>
                                </div>
                            </td>
                            <td style="color:var(--admin-text-muted);">{{ $h['grade'] }} — {{ $h['section'] }}</td>
                            <td>
                                <span style="font-weight:700;color:var(--admin-text-heading);">{{ $h['gwa'] }}</span>
                            </td>
                            <td>
                                <span class="badge {{ $h['honors'] === 'Highest Honors' ? 'badge--amber' : 'badge--blue' }}">
                                    {{ $h['honors'] }}
                                </span>
                            </td>
                            <td style="color:var(--admin-text-muted);">{{ $h['quarter'] }}</td>
                            <td style="color:var(--admin-text-muted);">{{ $h['sy'] }}</td>
                            <td class="td-actions">
                                <div class="table-actions">
                                    <button class="btn btn--ghost btn--icon btn--sm tooltip" data-tip="Edit"
                                            onclick="openModal('modalCreateHonor')" aria-label="Edit">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
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
            <div class="panel__footer">
                <span style="font-size:var(--text-xs);color:var(--admin-text-muted);">Showing 5 of 8 students</span>
                <div class="pagination">
                    <button class="pagination__btn active">1</button>
                    <button class="pagination__btn">2</button>
                </div>
            </div>
        </div>

    </div>

    {{-- ── COMPETITION WINS TAB ── --}}
    <div id="panel-comp" style="display:none;">

        <div class="panel animate-fade-in">
            <div class="panel__header">
                <div>
                    <p class="panel__title">Competition Wins</p>
                    <p class="panel__subtitle">Awards and placements from competitions and contests</p>
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
                        @php
                            $wins = [
                                ['comp'=>'Regional Science Quiz Bee','student'=>'Maria Santos','cat'=>'Science','level'=>'Regional','place'=>'1st','date'=>'Feb 2026','place_class'=>'badge--blue'],
                                ['comp'=>'Division Poster Making','student'=>'Juan dela Cruz','cat'=>'Arts','level'=>'Division','place'=>'2nd','date'=>'Jan 2026','place_class'=>'badge--green'],
                                ['comp'=>'District Spelling Bee','student'=>'Ana Reyes','cat'=>'Language','level'=>'District','place'=>'1st','date'=>'Dec 2025','place_class'=>'badge--blue'],
                                ['comp'=>'Athletics — 100m Sprint','student'=>'Carlo Bautista','cat'=>'Sports','level'=>'District','place'=>'1st','date'=>'Nov 2025','place_class'=>'badge--blue'],
                            ];
                        @endphp
                        @foreach($wins as $w)
                        <tr>
                            <td class="td-check"><input type="checkbox" class="row-check" aria-label="Select row"/></td>
                            <td><p class="cell-title">{{ $w['comp'] }}</p></td>
                            <td>
                                <div class="cell-author">
                                    <div class="cell-author__avatar">{{ strtoupper(substr($w['student'],0,1)) }}</div>
                                    <span>{{ $w['student'] }}</span>
                                </div>
                            </td>
                            <td style="color:var(--admin-text-muted);">{{ $w['cat'] }}</td>
                            <td><span class="badge badge--gray">{{ $w['level'] }}</span></td>
                            <td><span class="badge {{ $w['place_class'] }}">{{ $w['place'] }} Place</span></td>
                            <td style="color:var(--admin-text-muted);">{{ $w['date'] }}</td>
                            <td class="td-actions">
                                <div class="table-actions">
                                    <button class="btn btn--ghost btn--icon btn--sm tooltip" data-tip="Edit"
                                            onclick="openModal('modalCreateCompetition')" aria-label="Edit">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
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
        </div>

    </div>

    {{-- MODAL: Add Honor Student --}}
    <div class="modal-overlay" id="modalCreateHonor" role="dialog" aria-modal="true" aria-labelledby="modalHonorTitle">
        <div class="modal">
            <div class="modal__header">
                <div>
                    <h2 class="modal__title" id="modalHonorTitle">Add Honor Student</h2>
                    <p class="modal__subtitle">Add a student to the honor roll.</p>
                </div>
                <button class="modal__close" onclick="closeModal('modalCreateHonor')" aria-label="Close">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.achievements.store') }}">
                @csrf
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
                                <option value="">Select grade…</option>
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
                            <input class="form-input" type="text" id="h_sy" name="school_year" value="2025–2026"/>
                        </div>
                    </div>
                </div>
                <div class="modal__footer">
                    <button type="button" class="btn btn--secondary" onclick="closeModal('modalCreateHonor')">Cancel</button>
                    <button type="submit" class="btn btn--primary">Save Student</button>
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
                    <p class="modal__subtitle">Record an award or recognition from a competition.</p>
                </div>
                <button class="modal__close" onclick="closeModal('modalCreateCompetition')" aria-label="Close">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.achievements.store') }}">
                @csrf
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
                    <button type="submit" class="btn btn--primary">Save Achievement</button>
                </div>
            </form>
        </div>
    </div>

    @include('partials.admin.modal-delete', ['label' => 'achievement'])

@endsection

@push('scripts')
<script>
    function switchTab(tab) {
        document.getElementById('panel-honor').style.display = tab === 'honor' ? 'block' : 'none';
        document.getElementById('panel-comp').style.display  = tab === 'comp'  ? 'block' : 'none';
        document.getElementById('tab-honor').className = tab === 'honor' ? 'btn btn--primary btn--sm'    : 'btn btn--secondary btn--sm';
        document.getElementById('tab-comp').className  = tab === 'comp'  ? 'btn btn--primary btn--sm'    : 'btn btn--secondary btn--sm';
        document.getElementById('tab-honor').setAttribute('aria-selected', tab === 'honor');
        document.getElementById('tab-comp').setAttribute('aria-selected',  tab === 'comp');
    }
</script>
@endpush