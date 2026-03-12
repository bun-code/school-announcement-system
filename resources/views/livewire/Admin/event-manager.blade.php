{{-- resources/views/livewire/admin/event-manager.blade.php --}}

@section('title', 'Events & Calendar')
@section('breadcrumb', 'Events & Calendar')
@section('page-title', 'Events & Calendar')
@section('page-subtitle', 'Schedule and manage all school events visible on the public calendar.')

<div>

    {{-- ── Toast ── --}}
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
         TWO-COLUMN LAYOUT: calendar + table
    ══════════════════════════════════════ --}}
    <div class="events-layout">

        {{-- ── LEFT: Calendar + category summary ── --}}
        <div class="events-layout__side">

            {{-- Calendar --}}
            <div class="calendar animate-fade-up">
                <div class="calendar__header">
                    <p class="calendar__month">{{ $this->calendarGrid['monthName'] }}</p>
                    <div class="calendar__nav">
                        <button wire:click="prevMonth" class="calendar__nav-btn" aria-label="Previous month">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <button wire:click="nextMonth" class="calendar__nav-btn" aria-label="Next month">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>
                <div class="calendar__grid">
                    <div class="calendar__weekdays">
                        @foreach(['S','M','T','W','T','F','S'] as $d)
                            <div class="calendar__weekday">{{ $d }}</div>
                        @endforeach
                    </div>
                    <div class="calendar__days">
                        {{-- Blank leading cells --}}
                        @for($b = 0; $b < $this->calendarGrid['blanks']; $b++)
                            <div class="calendar__day other-month"></div>
                        @endfor

                        {{-- Day cells --}}
                        @for($d = 1; $d <= $this->calendarGrid['days']; $d++)
                            <div class="calendar__day
                                {{ $this->calendarGrid['today'] === $d ? 'today' : '' }}
                                {{ isset($this->calendarEvents[$d]) ? 'has-event' : '' }}"
                                wire:key="cal-day-{{ $calYear }}-{{ $calMonth }}-{{ $d }}"
                            >
                                <span class="calendar__day-num">{{ $d }}</span>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

            {{-- Category summary --}}
            <div class="panel animate-fade-up delay-100">
                <div class="panel__header">
                    <p class="panel__title">By Category</p>
                </div>
                <div class="panel__body" style="padding-block:var(--space-2);">
                    @php
                        $catColors = [
                            'Academic'  => 'badge--blue',
                            'Sports'    => 'badge--green',
                            'Cultural'  => 'badge--orange',
                            'Program'   => 'badge--purple',
                            'Community' => 'badge--amber',
                            'Health'    => 'badge--red',
                        ];
                    @endphp
                    @forelse($this->categorySummary as $cat => $count)
                        <div style="display:flex;align-items:center;justify-content:space-between;padding:var(--space-3) 0;border-bottom:1px solid var(--admin-border);">
                            <span class="badge {{ $catColors[$cat] ?? 'badge--gray' }}">{{ $cat }}</span>
                            <span style="font-family:var(--font-display);font-weight:700;font-size:var(--text-base);color:var(--admin-text-heading);">{{ $count }}</span>
                        </div>
                    @empty
                        <p style="font-size:var(--text-sm);color:var(--admin-text-muted);padding:var(--space-4) 0;">No events yet.</p>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- ── RIGHT: Toolbar + table ── --}}
        <div class="panel animate-fade-up delay-50 events-layout__main">

            {{-- Toolbar --}}
            <div class="table-toolbar">
                <div class="table-toolbar__left">
                    <div class="search-input">
                        <svg class="search-input__icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input wire:model.live.debounce.400ms="search" type="text" placeholder="Search events…"/>
                    </div>
                    <select wire:model.live="category" class="form-select" style="width:auto;padding-block:.5rem;">
                        <option value="">All Categories</option>
                        <option value="Academic">Academic</option>
                        <option value="Sports">Sports</option>
                        <option value="Cultural">Cultural</option>
                        <option value="Program">Program</option>
                        <option value="Community">Community</option>
                        <option value="Health">Health</option>
                    </select>
                </div>
                <div class="table-toolbar__right">
                    <button wire:click="openCreateModal" class="btn btn--primary btn--sm">
                        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        Add Event
                    </button>
                </div>
            </div>

            {{-- Loading bar --}}
            <div wire:loading wire:target="search,category" class="table-loading-bar"></div>

            {{-- Table --}}
            <div class="panel__body--flush">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Category</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th class="td-actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($this->events as $event)
                        <tr wire:key="event-{{ $event->id }}">
                            <td>
                                <p class="cell-title">{{ $event->title }}</p>
                                @if($event->description)
                                    <p class="cell-excerpt">{{ Str::limit($event->description, 55) }}</p>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $catColors[$event->category] ?? 'badge--gray' }}">
                                    {{ $event->category }}
                                </span>
                            </td>
                            <td style="white-space:nowrap;color:var(--admin-text-muted);">
                                {{ $event->event_date->format('M j, Y') }}
                                @if($event->end_date && $event->end_date->ne($event->event_date))
                                    <br/>
                                    <span style="font-size:var(--text-xs);">to {{ $event->end_date->format('M j') }}</span>
                                @endif
                            </td>
                            <td style="white-space:nowrap;color:var(--admin-text-muted);font-size:var(--text-xs);">
                                @if($event->start_time)
                                    {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}
                                    @if($event->end_time)
                                        – {{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }}
                                    @endif
                                @else
                                    <span style="color:var(--admin-text-subtle);">—</span>
                                @endif
                            </td>
                            <td style="font-size:var(--text-xs);color:var(--admin-text-muted);max-width:120px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                {{ $event->location ?? '—' }}
                            </td>
                            <td>
                                <span class="badge {{ $event->status_color }}">
                                    {{ ucfirst($event->status) }}
                                </span>
                            </td>
                            <td class="td-actions">
                                <div class="table-actions">
                                    <button wire:click="openEditModal({{ $event->id }})" class="btn btn--ghost btn--icon btn--sm tooltip" data-tip="Edit" aria-label="Edit">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button wire:click="openDeleteModal({{ $event->id }})" class="btn btn--danger-soft btn--icon btn--sm tooltip" data-tip="Delete" aria-label="Delete">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <p class="empty-state__title">No events found</p>
                                    <p class="empty-state__text">
                                        {{ $search || $category ? 'Try adjusting your filters.' : 'Add your first event to get started.' }}
                                    </p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($this->events->hasPages())
            <div class="panel__footer">
                <span style="font-size:var(--text-xs);color:var(--admin-text-muted);">
                    Showing {{ $this->events->firstItem() }}–{{ $this->events->lastItem() }}
                    of {{ $this->events->total() }} events
                </span>
                {{ $this->events->links('vendor.pagination.admin') }}
            </div>
            @endif

        </div>
    </div>

    {{-- ══════════════════════════════════════
         MODAL: CREATE
    ══════════════════════════════════════ --}}
    @if($showCreateModal)
    <div class="modal-overlay open" role="dialog" aria-modal="true" aria-labelledby="modalCreateEventTitle" wire:keydown.escape="$set('showCreateModal', false)">
        <div class="modal modal--lg" wire:click.stop>
            <div class="modal__header">
                <div>
                    <h2 class="modal__title" id="modalCreateEventTitle">Add Event</h2>
                    <p class="modal__subtitle">Schedule a new event on the school calendar.</p>
                </div>
                <button wire:click="$set('showCreateModal', false)" class="modal__close" aria-label="Close">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="modal__body">
                @include('livewire.admin.partials.event-form')
            </div>
            <div class="modal__footer">
                <button wire:click="$set('showCreateModal', false)" class="btn btn--secondary">Cancel</button>
                <button wire:click="save" class="btn btn--primary" wire:loading.attr="disabled">
                    <span wire:loading wire:target="save" class="btn-spinner"></span>
                    <span wire:loading.remove wire:target="save">Add to Calendar</span>
                    <span wire:loading wire:target="save">Saving…</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- ══════════════════════════════════════
         MODAL: EDIT
    ══════════════════════════════════════ --}}
    @if($showEditModal)
    <div class="modal-overlay open" role="dialog" aria-modal="true" aria-labelledby="modalEditEventTitle" wire:keydown.escape="$set('showEditModal', false)">
        <div class="modal modal--lg" wire:click.stop>
            <div class="modal__header">
                <div>
                    <h2 class="modal__title" id="modalEditEventTitle">Edit Event</h2>
                    <p class="modal__subtitle">Update this event's details.</p>
                </div>
                <button wire:click="$set('showEditModal', false)" class="modal__close" aria-label="Close">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="modal__body">
                @include('livewire.admin.partials.event-form')
            </div>
            <div class="modal__footer">
                <button wire:click="$set('showEditModal', false)" class="btn btn--secondary">Cancel</button>
                <button wire:click="update" class="btn btn--primary" wire:loading.attr="disabled">
                    <span wire:loading wire:target="update" class="btn-spinner"></span>
                    <span wire:loading.remove wire:target="update">Save Changes</span>
                    <span wire:loading wire:target="update">Saving…</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- ══════════════════════════════════════
         MODAL: DELETE
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
                <h3 style="font-size:var(--text-lg);font-weight:700;color:var(--admin-text-heading);margin-bottom:var(--space-3);">Remove Event?</h3>
                <p style="font-size:var(--text-sm);color:var(--admin-text-muted);max-width:300px;margin:0 auto;">
                    This event will be removed from the calendar and cannot be undone.
                </p>
            </div>
            <div class="modal__footer" style="justify-content:center;">
                <button wire:click="$set('showDeleteModal', false)" class="btn btn--secondary">Cancel</button>
                <button wire:click="delete" class="btn btn--danger" wire:loading.attr="disabled">
                    <span wire:loading wire:target="delete" class="btn-spinner"></span>
                    Yes, Remove
                </button>
            </div>
        </div>
    </div>
    @endif

</div>
