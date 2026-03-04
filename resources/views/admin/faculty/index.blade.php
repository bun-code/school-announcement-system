{{-- resources/views/admin/faculty/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Faculty & Staff')
@section('breadcrumb', 'Faculty & Staff')
@section('page-title', 'Faculty & Staff')
@section('page-subtitle', 'Manage all teachers and staff members of Taboc Elementary School.')

@section('page-actions')
    <button class="btn btn--primary" onclick="openModal('modalCreateFaculty')">
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Add Member
    </button>
@endsection

@section('content')

    {{-- Stats --}}
    <div class="stat-cards" style="grid-template-columns:repeat(4,1fr);">
        @php $fs = [['label'=>'Total Staff','value'=>'34','class'=>'stat-card__icon--blue'],['label'=>'Teachers','value'=>'28','class'=>'stat-card__icon--green'],['label'=>'Non-Teaching','value'=>'6','class'=>'stat-card__icon--orange'],['label'=>'Active','value'=>'34','class'=>'stat-card__icon--purple']]; @endphp
        @foreach($fs as $s)
        <div class="stat-card animate-fade-up">
            <div class="stat-card__icon {{ $s['class'] }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div class="stat-card__body">
                <p class="stat-card__label">{{ $s['label'] }}</p>
                <p class="stat-card__value">{{ $s['value'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Table panel --}}
    <div class="panel animate-fade-up delay-100">
        <div class="panel__header">
            <div>
                <p class="panel__title">All Faculty & Staff</p>
                <p class="panel__subtitle">Teachers and staff assigned to Taboc Elementary School</p>
            </div>
            <div class="panel__header-actions">
                <div class="search-input">
                    <svg class="search-input__icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" placeholder="Search faculty…"/>
                </div>
                <select class="form-select" style="width:auto;padding-block:.5rem;">
                    <option>All Types</option>
                    <option>Teaching</option>
                    <option>Non-Teaching</option>
                    <option>Administrative</option>
                </select>
            </div>
        </div>

        <div class="panel__body--flush">
            <table class="data-table">
                <thead>
                    <tr>
                        <th class="td-check"><input type="checkbox" aria-label="Select all"/></th>
                        <th class="sortable">Name</th>
                        <th>Position</th>
                        <th>Subject / Specialization</th>
                        <th>Grade Handled</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th class="td-actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $faculty = [
                            ['name'=>'Mrs. Rosa Dela Cruz','position'=>'Teacher I','subject'=>'Mathematics','grade'=>'Grade 6','type'=>'Teaching','status'=>'Active','initials'=>'RD'],
                            ['name'=>'Mr. Jose Santos','position'=>'Teacher II','subject'=>'Science','grade'=>'Grade 5 & 6','type'=>'Teaching','status'=>'Active','initials'=>'JS'],
                            ['name'=>'Ms. Ana Reyes','position'=>'Teacher I','subject'=>'English','grade'=>'Grade 4','type'=>'Teaching','status'=>'Active','initials'=>'AR'],
                            ['name'=>'Mrs. Liza Gomez','position'=>'Teacher III','subject'=>'Filipino','grade'=>'Grade 3','type'=>'Teaching','status'=>'Active','initials'=>'LG'],
                            ['name'=>'Mr. Carlo Bautista','position'=>'Teacher I','subject'=>'MAPEH','grade'=>'Grade 1 – 3','type'=>'Teaching','status'=>'Active','initials'=>'CB'],
                            ['name'=>'Mrs. Elena Torres','position'=>'Teacher II','subject'=>'Araling Panlipunan','grade'=>'Grade 5','type'=>'Teaching','status'=>'Active','initials'=>'ET'],
                            ['name'=>'Ms. Maria Villanueva','position'=>'Guidance Counselor','subject'=>'Guidance','grade'=>'All Levels','type'=>'Non-Teaching','status'=>'Active','initials'=>'MV'],
                            ['name'=>'Mr. Pedro Ramos','position'=>'School Custodian','subject'=>'—','grade'=>'—','type'=>'Non-Teaching','status'=>'Active','initials'=>'PR'],
                        ];
                    @endphp
                    @foreach($faculty as $f)
                    <tr>
                        <td class="td-check"><input type="checkbox" class="row-check" aria-label="Select row"/></td>
                        <td>
                            <div class="cell-author">
                                <div class="cell-author__avatar">{{ $f['initials'] }}</div>
                                <div>
                                    <p class="cell-title" style="font-weight:600;">{{ $f['name'] }}</p>
                                </div>
                            </div>
                        </td>
                        <td style="color:var(--admin-text-muted);">{{ $f['position'] }}</td>
                        <td style="color:var(--admin-text-muted);">{{ $f['subject'] }}</td>
                        <td style="font-size:var(--text-xs);color:var(--admin-text-muted);">{{ $f['grade'] }}</td>
                        <td>
                            <span class="badge {{ $f['type'] === 'Teaching' ? 'badge--blue' : 'badge--gray' }}">
                                {{ $f['type'] }}
                            </span>
                        </td>
                        <td><span class="badge badge--green">{{ $f['status'] }}</span></td>
                        <td class="td-actions">
                            <div class="table-actions">
                                <button class="btn btn--ghost btn--icon btn--sm tooltip" data-tip="Edit"
                                        onclick="openModal('modalCreateFaculty')" aria-label="Edit">
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
            <span style="font-size:var(--text-xs);color:var(--admin-text-muted);">Showing 8 of 34 members</span>
            <div class="pagination">
                <button class="pagination__btn active">1</button>
                <button class="pagination__btn">2</button>
                <button class="pagination__btn">3</button>
                <button class="pagination__btn">4</button>
            </div>
        </div>
    </div>

    {{-- MODAL: Add / Edit Faculty --}}
    <div class="modal-overlay" id="modalCreateFaculty" role="dialog" aria-modal="true" aria-labelledby="modalFacultyTitle">
        <div class="modal modal--lg">
            <div class="modal__header">
                <div>
                    <h2 class="modal__title" id="modalFacultyTitle">Add Faculty / Staff Member</h2>
                    <p class="modal__subtitle">Fill in the details for the new faculty or staff member.</p>
                </div>
                <button class="modal__close" onclick="closeModal('modalCreateFaculty')" aria-label="Close">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.faculty.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal__body">

                    <p class="form-section-title">Personal Information</p>

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label" for="fac_fname">First Name</label>
                            <input class="form-input" type="text" id="fac_fname" name="first_name"
                                   placeholder="e.g. Rosa" required/>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="fac_lname">Last Name</label>
                            <input class="form-input" type="text" id="fac_lname" name="last_name"
                                   placeholder="e.g. Dela Cruz" required/>
                        </div>
                    </div>

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label form-label--optional" for="fac_email">Email</label>
                            <input class="form-input" type="email" id="fac_email" name="email"
                                   placeholder="email@example.com"/>
                        </div>
                        <div class="form-group">
                            <label class="form-label form-label--optional" for="fac_phone">Phone</label>
                            <input class="form-input" type="tel" id="fac_phone" name="phone"
                                   placeholder="09XX XXX XXXX"/>
                        </div>
                    </div>

                    <div class="form-divider"></div>
                    <p class="form-section-title">School Assignment</p>

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label" for="fac_position">Position / Designation</label>
                            <input class="form-input" type="text" id="fac_position" name="position"
                                   placeholder="e.g. Teacher I, Principal I"/>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="fac_type">Staff Type</label>
                            <select class="form-select" id="fac_type" name="type">
                                <option value="teaching">Teaching</option>
                                <option value="non-teaching">Non-Teaching</option>
                                <option value="administrative">Administrative</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label form-label--optional" for="fac_subject">Subject / Specialization</label>
                            <input class="form-input" type="text" id="fac_subject" name="subject"
                                   placeholder="e.g. Mathematics, Science"/>
                        </div>
                        <div class="form-group">
                            <label class="form-label form-label--optional" for="fac_grade">Grade Level Handled</label>
                            <input class="form-input" type="text" id="fac_grade" name="grade_handled"
                                   placeholder="e.g. Grade 5 & 6"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label form-label--optional" for="fac_photo">Profile Photo</label>
                        <input class="form-input" type="file" id="fac_photo" name="photo"
                               accept="image/*" style="padding-block:.4rem;"/>
                        <p class="form-hint">JPG or PNG, max 2MB. Optional.</p>
                    </div>

                    <div class="form-group">
                        <label class="form-check">
                            <input type="checkbox" name="show_on_site" value="1" checked/>
                            <span class="form-check-label">Display this member on the public About page</span>
                        </label>
                    </div>

                </div>
                <div class="modal__footer">
                    <button type="button" class="btn btn--secondary" onclick="closeModal('modalCreateFaculty')">Cancel</button>
                    <button type="submit" class="btn btn--primary">Save Member</button>
                </div>
            </form>
        </div>
    </div>

    @include('partials.admin.modal-delete', ['label' => 'faculty member'])

@endsection