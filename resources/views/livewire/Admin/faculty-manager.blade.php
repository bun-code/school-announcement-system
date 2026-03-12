{{-- resources/views/livewire/admin/faculty-manager.blade.php --}}

<div>

    {{-- Local page header (keeps Livewire actions functional) --}}
    <div class="page-header animate-fade-up">
        <div>
            <h1 class="page-header__title">Faculty & Staff</h1>
            <p class="page-header__subtitle">Manage all teachers and staff members of Taboc Elementary School.</p>
        </div>
        <div class="page-header__actions">
            <button type="button" wire:click="openCreateModal" class="btn btn--primary">
                <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Add Member
            </button>
        </div>
    </div>

    {{-- Toast Notification --}}
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

    {{-- Stats Cards --}}
    <div class="stat-cards" style="grid-template-columns:repeat(4,1fr);">
        @php
            $stats_defs = [
                ['label' => 'Total Staff', 'key' => 'total', 'icon_class' => 'stat-card__icon--blue'],
                ['label' => 'Teachers', 'key' => 'teaching', 'icon_class' => 'stat-card__icon--green'],
                ['label' => 'Non-Teaching', 'key' => 'non_teaching', 'icon_class' => 'stat-card__icon--orange'],
                ['label' => 'Active', 'key' => 'active', 'icon_class' => 'stat-card__icon--purple'],
            ];
        @endphp
        @foreach($stats_defs as $s)
        <div class="stat-card animate-fade-up">
            <div class="stat-card__icon {{ $s['icon_class'] }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div class="stat-card__body">
                <p class="stat-card__label">{{ $s['label'] }}</p>
                <p class="stat-card__value">{{ $this->stats[$s['key']] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Table Panel --}}
    <div class="panel animate-fade-up delay-100">
        {{-- Toolbar --}}
        <div class="table-toolbar">
            <div class="table-toolbar__left">
                <div class="search-input">
                    <svg class="search-input__icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input
                        wire:model.live.debounce.400ms="search"
                        type="text"
                        placeholder="Search faculty…"
                    />
                </div>

                <select wire:model.live="type" class="form-select" style="width:auto;padding-block:.5rem;">
                    <option value="">All Types</option>
                    <option value="teaching">Teaching</option>
                    <option value="non-teaching">Non-Teaching</option>
                    <option value="administrative">Administrative</option>
                </select>

                <select wire:model.live="sort" class="form-select" style="width:auto;padding-block:.5rem;">
                    <option value="latest">Latest</option>
                    <option value="name">Name (A-Z)</option>
                </select>
            </div>
        </div>

        <div wire:loading wire:target="search,type,sort" class="table-loading-bar"></div>

        <div class="panel__body--flush">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Subject / Specialization</th>
                        <th>Grade Handled</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th class="td-actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($this->faculty as $member)
                    <tr wire:key="fac-{{ $member->id }}">
                        <td>
                            <div class="cell-author">
                                <div class="cell-author__avatar">{{ strtoupper(substr($member->first_name, 0, 1) . substr($member->last_name, 0, 1)) }}</div>
                                <div>
                                    <p class="cell-title" style="font-weight:600;">{{ $member->first_name }} {{ $member->last_name }}</p>
                                </div>
                            </div>
                        </td>
                        <td style="color:var(--admin-text-muted);">{{ $member->position }}</td>
                        <td style="color:var(--admin-text-muted);">{{ $member->subject ?? '—' }}</td>
                        <td style="font-size:var(--text-xs);color:var(--admin-text-muted);">{{ $member->grade_handled ?? '—' }}</td>
                        <td>
                            <span class="badge {{ $member->type === 'teaching' ? 'badge--blue' : 'badge--gray' }}">
                                {{ ucfirst($member->type) }}
                            </span>
                        </td>
                        <td><span class="badge badge--green">{{ ucfirst($member->status ?? 'Active') }}</span></td>
                        <td class="td-actions">
                            <div class="table-actions">
                                <button type="button" wire:click="openDeleteModal({{ $member->id }})" class="btn btn--danger-soft btn--icon btn--sm tooltip" data-tip="Delete" aria-label="Delete">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:2rem;color:var(--admin-text-muted);">
                            No faculty members found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="panel__footer">
            {{ $this->faculty->links() }}
        </div>
    </div>

    {{-- Create Modal --}}
    @if($showCreateModal)
    <div class="modal-overlay" style="display:flex !important;z-index:9999;">
        <div class="modal modal--lg">
            <div class="modal__header">
                <div>
                    <h2 class="modal__title">Add Faculty / Staff Member</h2>
                    <p class="modal__subtitle">Fill in the details for the new faculty or staff member.</p>
                </div>
                <button wire:click="closeCreateModal" class="modal__close" aria-label="Close">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form wire:submit="saveFaculty" style="display:flex;flex-direction:column;height:100%;overflow:hidden;">
                <div class="modal__body" style="overflow-y:auto;padding:1.5rem;flex:1;">
                    <p class="form-section-title">Personal Information</p>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
                        <div>
                            <label class="form-label">First Name</label>
                            <input wire:model="first_name" type="text" placeholder="e.g. Rosa" class="form-input" style="width:100%"/>
                            @error('first_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="form-label">Last Name</label>
                            <input wire:model="last_name" type="text" placeholder="e.g. Dela Cruz" class="form-input" style="width:100%"/>
                            @error('last_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.5rem;">
                        <div>
                            <label class="form-label">Email (optional)</label>
                            <input wire:model="email" type="email" placeholder="email@example.com" class="form-input" style="width:100%"/>
                        </div>
                        <div>
                            <label class="form-label">Phone (optional)</label>
                            <input wire:model="phone" type="tel" placeholder="09XX XXX XXXX" class="form-input" style="width:100%"/>
                        </div>
                    </div>

                    <hr style="border:none;border-top:1px solid #e5e7eb;margin:1.5rem 0;">

                    <p class="form-section-title">School Assignment</p>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
                        <div>
                            <label class="form-label">Position / Designation</label>
                            <input wire:model="position" type="text" placeholder="e.g. Teacher I" class="form-input" style="width:100%"/>
                            @error('position') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="form-label">Staff Type</label>
                            <select wire:model="faculty_type" class="form-select" style="width:100%">
                                <option value="teaching">Teaching</option>
                                <option value="non-teaching">Non-Teaching</option>
                                <option value="administrative">Administrative</option>
                            </select>
                        </div>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
                        <div>
                            <label class="form-label">Subject / Specialization (optional)</label>
                            <input wire:model="subject" type="text" placeholder="e.g. Mathematics" class="form-input" style="width:100%"/>
                        </div>
                        <div>
                            <label class="form-label">Grade Level Handled (optional)</label>
                            <input wire:model="grade_handled" type="text" placeholder="e.g. Grade 5 & 6" class="form-input" style="width:100%"/>
                        </div>
                    </div>

                    <div>
                        <label class="form-check" style="display:flex;align-items:center;gap:0.75rem;cursor:pointer;">
                            <input wire:model="show_on_site" type="checkbox" style="width:1.125rem;height:1.125rem;"/>
                            <span>Display on the public faculty page</span>
                        </label>
                    </div>
                </div>

                <div class="modal__footer" style="padding:1.5rem;border-top:1px solid #e5e7eb;background:#f9fafb;display:flex;gap:1rem;justify-content:flex-end;">
                    <button type="button" wire:click="closeCreateModal" class="btn btn--secondary">Cancel</button>
                    <button type="submit" class="btn btn--primary">Save Member</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- Delete Modal --}}
    @if($showDeleteModal && $deleteId)
    <div class="modal-overlay" style="display:flex !important;z-index:9999;">
        <div class="modal modal--sm">
            <div class="modal__body" style="text-align:center;padding-top:var(--space-8);">
                <div class="modal--confirm">
                    <div class="modal__icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </div>
                </div>
                <h3 style="font-size:var(--text-lg);font-weight:700;color:var(--admin-text-heading);margin-bottom:var(--space-3);">
                    Delete Faculty Member?
                </h3>
                <p style="font-size:var(--text-sm);color:var(--admin-text-muted);max-width:300px;margin:0 auto;">
                    This action cannot be undone. This faculty member will be permanently removed from the site.
                </p>
            </div>
            <div class="modal__footer" style="justify-content:center;">
                <button type="button" wire:click="closeDeleteModal" class="btn btn--secondary">Cancel</button>
                <button type="button" wire:click="deleteFaculty" class="btn btn--danger">Yes, Delete</button>
            </div>
        </div>
    </div>
    @endif
</div>
