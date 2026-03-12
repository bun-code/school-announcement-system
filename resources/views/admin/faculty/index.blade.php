{{-- resources/views/admin/faculty/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Faculty & Staff')
@section('breadcrumb', 'Faculty & Staff')
@section('page-title', 'Faculty & Staff')
@section('page-subtitle', 'Manage all teachers and staff members of Taboc Elementary School.')

@section('page-actions')
    <button class="btn btn--primary" onclick="document.getElementById('modalCreateFaculty').style.display='flex'">
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Add Member
    </button>
@endsection

@section('content')

    {{-- Stats --}}
    <div class="stat-cards" style="grid-template-columns:repeat(4,1fr);">
        @php $stats_display = [['label'=>'Total Staff','value'=>$stats['total'],'class'=>'stat-card__icon--blue'],['label'=>'Teachers','value'=>$stats['teaching'],'class'=>'stat-card__icon--green'],['label'=>'Non-Teaching','value'=>$stats['non_teaching'],'class'=>'stat-card__icon--orange'],['label'=>'Active','value'=>$stats['active'],'class'=>'stat-card__icon--purple']]; @endphp
        @foreach($stats_display as $s)
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
                <form method="GET" action="{{ route('admin.faculty.index') }}" style="display:flex;gap:0.75rem;align-items:center;">
                    <div class="search-input" style="flex:1;max-width:280px;position:relative;">
                        <svg class="search-input__icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="position:absolute;left:0.75rem;top:50%;transform:translateY(-50%);width:18px;height:18px;color:var(--admin-text-muted);"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="search" placeholder="Search faculty…" value="{{ request('search') }}" style="width:100%;padding:0.625rem 0.75rem 0.625rem 2.5rem;border:1px solid var(--admin-border);border-radius:0.375rem;font-size:var(--text-sm);transition:all 0.2s;" onmouseover="this.style.borderColor='var(--admin-text-muted)'" onmouseout="this.style.borderColor='var(--admin-border)'"/>
                    </div>
                    <select name="type" style="padding:0.625rem 0.75rem;border:1px solid var(--admin-border);border-radius:0.375rem;font-size:var(--text-sm);background-color:white;color:var(--admin-text);cursor:pointer;transition:all 0.2s;" onmouseover="this.style.borderColor='var(--admin-text-muted)'" onmouseout="this.style.borderColor='var(--admin-border)'">
                        <option value="">All Types</option>
                        <option value="teaching" {{ request('type') === 'teaching' ? 'selected' : '' }}>Teaching</option>
                        <option value="non-teaching" {{ request('type') === 'non-teaching' ? 'selected' : '' }}>Non-Teaching</option>
                        <option value="administrative" {{ request('type') === 'administrative' ? 'selected' : '' }}>Administrative</option>
                    </select>
                    @if(request('search') || request('type'))
                        <a href="{{ route('admin.faculty.index') }}" style="padding:0.625rem 1rem;border:1px solid var(--admin-border);border-radius:0.375rem;font-size:var(--text-sm);color:var(--admin-text);text-decoration:none;background:white;cursor:pointer;transition:all 0.2s;" onmouseover="this.style.backgroundColor='var(--admin-bg-hover)'" onmouseout="this.style.backgroundColor='white'">Clear</a>
                    @endif
                </form>
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
                    @forelse($faculty as $member)
                    <tr>
                        <td class="td-check"><input type="checkbox" class="row-check" aria-label="Select row"/></td>
                        <td>
                            <div class="cell-author">
                                <div class="cell-author__avatar">{{ strtoupper(substr($member->first_name, 0, 1) . substr($member->last_name, 0, 1)) }}</div>
                                <div>
                                    <p class="cell-title" style="font-weight:600;">{{ $member->first_name }} {{ $member->last_name }}</p>
                                </div>
                            </div>
                        </td>
                        <td style="color:var(--admin-text-muted);">{{ $member->position }}</td>
                        <td style="color:var(--admin-text-muted);">{{ $member->subject }}</td>
                        <td style="font-size:var(--text-xs);color:var(--admin-text-muted);">{{ $member->grade_handled }}</td>
                        <td>
                            <span class="badge {{ $member->type === 'teaching' ? 'badge--blue' : 'badge--gray' }}">
                                {{ ucfirst($member->type) }}
                            </span>
                        </td>
                        <td><span class="badge badge--green">{{ $member->status ?? 'Active' }}</span></td>
                        <td class="td-actions">
                            <div class="table-actions">
                                <button class="btn btn--ghost btn--icon btn--sm tooltip" data-tip="Edit"
                                        onclick="document.getElementById('modalCreateFaculty').style.display='flex'" aria-label="Edit">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <button class="btn btn--danger-soft btn--icon btn--sm tooltip" data-tip="Delete"
                                        data-delete-url="{{ route('admin.faculty.destroy', $member->id) }}"
                                        onclick="document.getElementById('deleteForm').action=this.dataset.deleteUrl; document.getElementById('modalDeleteConfirm').style.display='flex'" aria-label="Delete">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align:center;padding:2rem;color:var(--admin-text-muted);">
                            No faculty members found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="panel__footer" style="display:flex;align-items:center;justify-content:space-between;padding:1rem 1.5rem;">
            <span style="font-size:var(--text-sm);color:var(--admin-text-muted);font-weight:500;">
                Showing <strong style="color:var(--admin-text-heading);">{{ $faculty->firstItem() ?? 0 }}-{{ $faculty->lastItem() ?? 0 }}</strong> of <strong>{{ $faculty->total() }}</strong> members
            </span>
            <div class="pagination" style="display:flex;gap:0.5rem;align-items:center;">
                {{-- Previous Button --}}
                @if($faculty->onFirstPage())
                    <button class="pagination__btn" disabled style="opacity:0.5;cursor:not-allowed;padding:0.5rem 0.75rem;border-radius:0.375rem;border:1px solid var(--admin-border);background:transparent;color:var(--admin-text-muted);font-size:var(--text-sm);">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;display:inline-block;margin-right:0.25rem;"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        Previous
                    </button>
                @else
                    <a href="{{ $faculty->previousPageUrl() }}" class="pagination__btn" style="padding:0.5rem 0.75rem;border-radius:0.375rem;border:1px solid var(--admin-border);background:transparent;color:var(--admin-text);text-decoration:none;font-size:var(--text-sm);transition:all 0.2s;display:flex;align-items:center;cursor:pointer;"
                       onmouseover="this.style.backgroundColor='var(--admin-bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;display:inline-block;margin-right:0.25rem;"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        Previous
                    </a>
                @endif
                
                {{-- Page Numbers --}}
                <div style="display:flex;gap:0.25rem;margin:0 0.5rem;">
                    @php
                        $start = max(1, $faculty->currentPage() - 2);
                        $end = min($faculty->lastPage(), $faculty->currentPage() + 2);
                    @endphp
                    
                    @if($start > 1)
                        <a href="{{ $faculty->url(1) }}" class="pagination__btn" style="padding:0.5rem 0.75rem;border-radius:0.375rem;border:1px solid var(--admin-border);background:transparent;color:var(--admin-text);text-decoration:none;font-size:var(--text-sm);min-width:2.5rem;text-align:center;transition:all 0.2s;"
                           onmouseover="this.style.backgroundColor='var(--admin-bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">1</a>
                        @if($start > 2)
                            <span style="padding:0.5rem 0.25rem;color:var(--admin-text-muted);">...</span>
                        @endif
                    @endif
                    
                    @foreach(range($start, $end) as $page)
                        @if($page == $faculty->currentPage())
                            <button class="pagination__btn" style="padding:0.5rem 0.75rem;border-radius:0.375rem;border:none;background:#2563EB;color:white;font-weight:600;font-size:var(--text-sm);min-width:2.5rem;cursor:default;box-shadow:0 1px 3px rgba(0,0,0,0.1);">{{ $page }}</button>
                        @else
                            <a href="{{ $faculty->url($page) }}" class="pagination__btn" style="padding:0.5rem 0.75rem;border-radius:0.375rem;border:1px solid var(--admin-border);background:transparent;color:var(--admin-text);text-decoration:none;font-size:var(--text-sm);min-width:2.5rem;text-align:center;transition:all 0.2s;"
                               onmouseover="this.style.backgroundColor='var(--admin-bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">{{ $page }}</a>
                        @endif
                    @endforeach
                    
                    @if($end < $faculty->lastPage())
                        @if($end < $faculty->lastPage() - 1)
                            <span style="padding:0.5rem 0.25rem;color:var(--admin-text-muted);">...</span>
                        @endif
                        <a href="{{ $faculty->url($faculty->lastPage()) }}" class="pagination__btn" style="padding:0.5rem 0.75rem;border-radius:0.375rem;border:1px solid var(--admin-border);background:transparent;color:var(--admin-text);text-decoration:none;font-size:var(--text-sm);min-width:2.5rem;text-align:center;transition:all 0.2s;"
                           onmouseover="this.style.backgroundColor='var(--admin-bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">{{ $faculty->lastPage() }}</a>
                    @endif
                </div>
                
                {{-- Next Button --}}
                @if($faculty->hasMorePages())
                    <a href="{{ $faculty->nextPageUrl() }}" class="pagination__btn" style="padding:0.5rem 0.75rem;border-radius:0.375rem;border:1px solid var(--admin-border);background:transparent;color:var(--admin-text);text-decoration:none;font-size:var(--text-sm);transition:all 0.2s;display:flex;align-items:center;cursor:pointer;"
                       onmouseover="this.style.backgroundColor='var(--admin-bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                        Next
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;display:inline-block;margin-left:0.25rem;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                @else
                    <button class="pagination__btn" disabled style="opacity:0.5;cursor:not-allowed;padding:0.5rem 0.75rem;border-radius:0.375rem;border:1px solid var(--admin-border);background:transparent;color:var(--admin-text-muted);font-size:var(--text-sm);">
                        Next
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;display:inline-block;margin-left:0.25rem;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                @endif
            </div>
        </div>
    </div>

    {{-- MODAL: Add / Edit Faculty --}}
    <div class="modal-overlay" id="modalCreateFaculty" role="dialog" aria-modal="true" aria-labelledby="modalFacultyTitle" style="display:none;position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;padding:1rem;">
        <div class="modal modal--lg" style="width:100%;max-width:600px;max-height:90vh;display:flex;flex-direction:column;border-radius:0.5rem;background:white;box-shadow:0 20px 25px -5px rgba(0,0,0,0.1);">
            <div class="modal__header" style="padding:1.5rem;border-bottom:1px solid #e5e7eb;flex-shrink:0;">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                    <div>
                        <h2 class="modal__title" id="modalFacultyTitle" style="font-size:1.25rem;font-weight:700;color:var(--admin-text-heading);margin:0;">Add Faculty / Staff Member</h2>
                        <p class="modal__subtitle" style="font-size:0.875rem;color:var(--admin-text-muted);margin:0.5rem 0 0 0;">Fill in the details for the new faculty or staff member.</p>
                    </div>
                    <button class="modal__close" onclick="document.getElementById('modalCreateFaculty').style.display='none'" aria-label="Close" style="background:none;border:none;font-size:1.5rem;cursor:pointer;color:var(--admin-text-muted);padding:0;width:2rem;height:2rem;display:flex;align-items:center;justify-content:center;">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.faculty.store') }}" enctype="multipart/form-data" style="display:flex;flex-direction:column;height:100%;overflow:hidden;">
                @csrf
                <div class="modal__body" style="overflow-y:auto;padding:1.5rem;flex:1;min-height:0;">

                    <p class="form-section-title" style="font-size:0.875rem;font-weight:600;text-transform:uppercase;color:var(--admin-text-muted);margin:0 0 1rem 0;letter-spacing:0.05em;">Personal Information</p>

                    <div class="form-grid-2" style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
                        <div class="form-group">
                            <label class="form-label" for="fac_fname" style="display:block;font-weight:500;color:var(--admin-text-heading);margin-bottom:0.5rem;font-size:0.875rem;">First Name</label>
                            <input class="form-input" type="text" id="fac_fname" name="first_name"
                                   placeholder="e.g. Rosa" required style="width:100%;padding:0.625rem 0.75rem;border:1px solid var(--admin-border);border-radius:0.375rem;font-size:0.875rem;"/>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="fac_lname" style="display:block;font-weight:500;color:var(--admin-text-heading);margin-bottom:0.5rem;font-size:0.875rem;">Last Name</label>
                            <input class="form-input" type="text" id="fac_lname" name="last_name"
                                   placeholder="e.g. Dela Cruz" required style="width:100%;padding:0.625rem 0.75rem;border:1px solid var(--admin-border);border-radius:0.375rem;font-size:0.875rem;"/>
                        </div>
                    </div>

                    <div class="form-grid-2" style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.5rem;">
                        <div class="form-group">
                            <label class="form-label form-label--optional" for="fac_email" style="display:block;font-weight:500;color:var(--admin-text-heading);margin-bottom:0.5rem;font-size:0.875rem;">Email <span style="color:var(--admin-text-muted);font-weight:400;">(optional)</span></label>
                            <input class="form-input" type="email" id="fac_email" name="email"
                                   placeholder="email@example.com" style="width:100%;padding:0.625rem 0.75rem;border:1px solid var(--admin-border);border-radius:0.375rem;font-size:0.875rem;"/>
                        </div>
                        <div class="form-group">
                            <label class="form-label form-label--optional" for="fac_phone" style="display:block;font-weight:500;color:var(--admin-text-heading);margin-bottom:0.5rem;font-size:0.875rem;">Phone <span style="color:var(--admin-text-muted);font-weight:400;">(optional)</span></label>
                            <input class="form-input" type="tel" id="fac_phone" name="phone"
                                   placeholder="09XX XXX XXXX" style="width:100%;padding:0.625rem 0.75rem;border:1px solid var(--admin-border);border-radius:0.375rem;font-size:0.875rem;"/>
                        </div>
                    </div>

                    <div style="border-top:1px solid #e5e7eb;margin:1.5rem 0;padding:0;"></div>
                    <p class="form-section-title" style="font-size:0.875rem;font-weight:600;text-transform:uppercase;color:var(--admin-text-muted);margin:1.5rem 0 1rem 0;letter-spacing:0.05em;">School Assignment</p>

                    <div class="form-grid-2" style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
                        <div class="form-group">
                            <label class="form-label" for="fac_position" style="display:block;font-weight:500;color:var(--admin-text-heading);margin-bottom:0.5rem;font-size:0.875rem;">Position / Designation</label>
                            <input class="form-input" type="text" id="fac_position" name="position"
                                   placeholder="e.g. Teacher I, Principal I" required style="width:100%;padding:0.625rem 0.75rem;border:1px solid var(--admin-border);border-radius:0.375rem;font-size:0.875rem;"/>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="fac_type" style="display:block;font-weight:500;color:var(--admin-text-heading);margin-bottom:0.5rem;font-size:0.875rem;">Staff Type</label>
                            <select class="form-select" id="fac_type" name="type" style="width:100%;padding:0.625rem 0.75rem;border:1px solid var(--admin-border);border-radius:0.375rem;font-size:0.875rem;background-color:white;cursor:pointer;">
                                <option value="teaching">Teaching</option>
                                <option value="non-teaching">Non-Teaching</option>
                                <option value="administrative">Administrative</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-grid-2" style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
                        <div class="form-group">
                            <label class="form-label form-label--optional" for="fac_subject" style="display:block;font-weight:500;color:var(--admin-text-heading);margin-bottom:0.5rem;font-size:0.875rem;">Subject / Specialization <span style="color:var(--admin-text-muted);font-weight:400;">(optional)</span></label>
                            <input class="form-input" type="text" id="fac_subject" name="subject"
                                   placeholder="e.g. Mathematics, Science" style="width:100%;padding:0.625rem 0.75rem;border:1px solid var(--admin-border);border-radius:0.375rem;font-size:0.875rem;"/>
                        </div>
                        <div class="form-group">
                            <label class="form-label form-label--optional" for="fac_grade" style="display:block;font-weight:500;color:var(--admin-text-heading);margin-bottom:0.5rem;font-size:0.875rem;">Grade Level Handled <span style="color:var(--admin-text-muted);font-weight:400;">(optional)</span></label>
                            <input class="form-input" type="text" id="fac_grade" name="grade_handled"
                                   placeholder="e.g. Grade 5 & 6" style="width:100%;padding:0.625rem 0.75rem;border:1px solid var(--admin-border);border-radius:0.375rem;font-size:0.875rem;"/>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:1rem;">
                        <label class="form-label form-label--optional" for="fac_photo" style="display:block;font-weight:500;color:var(--admin-text-heading);margin-bottom:0.5rem;font-size:0.875rem;">Profile Photo <span style="color:var(--admin-text-muted);font-weight:400;">(optional)</span></label>
                        <input class="form-input" type="file" id="fac_photo" name="photo"
                               accept="image/*" style="width:100%;padding:0.625rem 0.75rem;border:1px solid var(--admin-border);border-radius:0.375rem;font-size:0.875rem;"/>
                        <p class="form-hint" style="font-size:0.75rem;color:var(--admin-text-muted);margin-top:0.5rem;margin-bottom:0;">JPG or PNG, max 2MB.</p>
                    </div>

                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-check" style="display:flex;align-items:center;gap:0.75rem;cursor:pointer;font-size:0.875rem;color:var(--admin-text);">
                            <input type="checkbox" name="show_on_site" value="1" checked style="width:1.125rem;height:1.125rem;cursor:pointer;"/>
                            <span style="margin:0;">Display this member on the public faculty page</span>
                        </label>
                    </div>

                </div>
                <div class="modal__footer" style="padding:1.5rem;border-top:1px solid #e5e7eb;background:#f9fafb;display:flex;gap:1rem;justify-content:flex-end;flex-shrink:0;">
                    <button type="button" class="btn btn--secondary" onclick="document.getElementById('modalCreateFaculty').style.display='none'" style="padding:0.625rem 1.5rem;border:1px solid var(--admin-border);background:white;color:var(--admin-text);border-radius:0.375rem;font-weight:500;font-size:0.875rem;cursor:pointer;transition:all 0.2s;" onmouseover="this.style.backgroundColor='var(--admin-bg-hover)'" onmouseout="this.style.backgroundColor='white'">Cancel</button>
                    <button type="submit" class="btn btn--primary" style="padding:0.625rem 1.5rem;background:#2563EB;color:white;border:none;border-radius:0.375rem;font-weight:500;font-size:0.875rem;cursor:pointer;transition:all 0.2s;" onmouseover="this.style.backgroundColor='#1d4ed8'" onmouseout="this.style.backgroundColor='#2563EB'">Save Member</button>
                </div>
            </form>
        </div>
    </div>

    @include('partials.admin.modal-delete', ['label' => 'faculty member'])

    <script>
        // Close modals when clicking overlay
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.style.display = 'none';
                }
            });
        });

        // Close modals with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal-overlay').forEach(modal => {
                    if (modal.style.display === 'flex') {
                        modal.style.display = 'none';
                    }
                });
            }
        });
    </script>

@endsection