{{-- resources/views/admin/events/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Events & Calendar')
@section('breadcrumb', 'Events & Calendar')
@section('page-title', 'Events & Calendar')
@section('page-subtitle', 'Schedule and manage all school events visible on the public calendar.')

@section('page-actions')
    <button class="btn btn--primary" onclick="openModal('modalCreateEvent')">
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Add Event
    </button>
@endsection

@section('content')

    <div style="display:grid;grid-template-columns:1fr 340px;gap:var(--space-6);align-items:start;">

        {{-- ── Events table ── --}}
        <div class="panel animate-fade-up">
            <div class="panel__header">
                <div>
                    <p class="panel__title">All Events</p>
                    <p class="panel__subtitle">4 upcoming events scheduled</p>
                </div>
                <div class="panel__header-actions">
                    <div class="search-input" style="min-width:180px;">
                        <svg class="search-input__icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" placeholder="Search events…"/>
                    </div>
                    <select class="form-select" style="width:auto;padding-block:.5rem;">
                        <option>All Categories</option>
                        <option>Academic</option>
                        <option>Sports</option>
                        <option>Cultural</option>
                        <option>Program</option>
                    </select>
                </div>
            </div>

            <div class="panel__body--flush">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="td-check"><input type="checkbox" aria-label="Select all"/></th>
                            <th class="sortable">Event</th>
                            <th class="sortable">Date</th>
                            <th>Time</th>
                            <th>Location</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th class="td-actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $events = [
                                ['title'=>'3rd Quarter Academic Awards Day','date'=>'Mar 15, 2026','time'=>'8:00 AM','location'=>'School Gymnasium','cat'=>'Academic','cat_class'=>'badge--blue','status'=>'Upcoming','status_class'=>'badge--blue'],
                                ['title'=>'Intramurals 2026 — Sports Festival','date'=>'Mar 22, 2026','time'=>'All Day','location'=>'School Grounds','cat'=>'Sports','cat_class'=>'badge--green','status'=>'Upcoming','status_class'=>'badge--blue'],
                                ['title'=>'Nutrition Month — Poster Making','date'=>'Mar 28, 2026','time'=>'9:00 AM','location'=>'Classrooms','cat'=>'Cultural','cat_class'=>'badge--orange','status'=>'Upcoming','status_class'=>'badge--blue'],
                                ['title'=>'Culminating Program — 3rd Quarter','date'=>'Apr 5, 2026','time'=>'7:30 AM','location'=>'School Gymnasium','cat'=>'Program','cat_class'=>'badge--purple','status'=>'Scheduled','status_class'=>'badge--gray'],
                                ['title'=>'Regional Science Quiz Bee','date'=>'Feb 20, 2026','time'=>'8:00 AM','location'=>'Division Office','cat'=>'Academic','cat_class'=>'badge--blue','status'=>'Completed','status_class'=>'badge--green'],
                            ];
                        @endphp
                        @foreach($events as $ev)
                        <tr>
                            <td class="td-check"><input type="checkbox" class="row-check" aria-label="Select row"/></td>
                            <td>
                                <p class="cell-title">{{ $ev['title'] }}</p>
                            </td>
                            <td style="white-space:nowrap;font-weight:600;color:var(--admin-text-heading);">{{ $ev['date'] }}</td>
                            <td style="white-space:nowrap;color:var(--admin-text-muted);">{{ $ev['time'] }}</td>
                            <td style="color:var(--admin-text-muted);font-size:var(--text-xs);">{{ $ev['location'] }}</td>
                            <td><span class="badge {{ $ev['cat_class'] }}">{{ $ev['cat'] }}</span></td>
                            <td><span class="badge {{ $ev['status_class'] }}">{{ $ev['status'] }}</span></td>
                            <td class="td-actions">
                                <div class="table-actions">
                                    <button class="btn btn--ghost btn--icon btn--sm tooltip" data-tip="Edit"
                                            onclick="openModal('modalCreateEvent')" aria-label="Edit">
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
                <span style="font-size:var(--text-xs);color:var(--admin-text-muted);">Showing 1–5 of 5 events</span>
                <div class="pagination">
                    <button class="pagination__btn active">1</button>
                </div>
            </div>
        </div>

        {{-- ── Calendar + quick add ── --}}
        <div style="display:flex;flex-direction:column;gap:var(--space-5);">

            {{-- Full calendar panel --}}
            <div class="calendar animate-fade-up delay-100">
                <div class="calendar__header">
                    <p class="calendar__month">March 2026</p>
                    <div class="calendar__nav">
                        <button class="calendar__nav-btn" aria-label="Previous">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <button class="calendar__nav-btn" aria-label="Next">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>
                <div class="calendar__grid">
                    <div class="calendar__weekdays">
                        @foreach(['Su','Mo','Tu','We','Th','Fr','Sa'] as $d)
                            <div class="calendar__weekday">{{ $d }}</div>
                        @endforeach
                    </div>
                    <div class="calendar__days">
                        @for($d = 1; $d <= 31; $d++)
                            <div class="calendar__day
                                {{ $d === 3  ? 'today' : '' }}
                                {{ in_array($d, [15,22,28]) ? 'has-event' : '' }}"
                                onclick="openModal('modalCreateEvent')"
                                title="{{ in_array($d, [15,22,28]) ? 'Has event' : 'Click to add event' }}">
                                <span class="calendar__day-num">{{ $d }}</span>
                            </div>
                        @endfor
                    </div>
                </div>
                {{-- Legend --}}
                <div style="padding:var(--space-3) var(--space-5);border-top:1px solid var(--admin-border);display:flex;align-items:center;gap:var(--space-3);">
                    <span style="display:flex;align-items:center;gap:5px;font-size:var(--text-xs);color:var(--admin-text-muted);">
                        <span style="width:8px;height:8px;border-radius:50%;background:var(--color-primary);display:inline-block;"></span> Today
                    </span>
                    <span style="display:flex;align-items:center;gap:5px;font-size:var(--text-xs);color:var(--admin-text-muted);">
                        <span style="width:8px;height:8px;border-radius:50%;background:var(--color-accent);display:inline-block;"></span> Event
                    </span>
                </div>
            </div>

            {{-- Event categories summary --}}
            <div class="panel animate-fade-up delay-150">
                <div class="panel__header">
                    <p class="panel__title">By Category</p>
                </div>
                <div class="panel__body">
                    @php
                        $cats = [
                            ['name'=>'Academic','count'=>2,'class'=>'badge--blue'],
                            ['name'=>'Sports','count'=>1,'class'=>'badge--green'],
                            ['name'=>'Cultural','count'=>1,'class'=>'badge--orange'],
                            ['name'=>'Program','count'=>1,'class'=>'badge--purple'],
                        ];
                    @endphp
                    @foreach($cats as $c)
                    <div style="display:flex;align-items:center;justify-content:space-between;padding:var(--space-2) 0;border-bottom:1px solid var(--admin-border);">
                        <span class="badge {{ $c['class'] }}">{{ $c['name'] }}</span>
                        <span style="font-size:var(--text-xs);font-weight:700;color:var(--admin-text-heading);">{{ $c['count'] }} event{{ $c['count'] > 1 ? 's' : '' }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    {{-- ════════════════════════════════════════
         MODAL: CREATE / EDIT EVENT
    ════════════════════════════════════════ --}}
    <div class="modal-overlay" id="modalCreateEvent" role="dialog" aria-modal="true" aria-labelledby="modalCreateEventTitle">
        <div class="modal modal--lg">
            <div class="modal__header">
                <div>
                    <h2 class="modal__title" id="modalCreateEventTitle">Add New Event</h2>
                    <p class="modal__subtitle">Schedule a new event to appear on the public calendar.</p>
                </div>
                <button class="modal__close" onclick="closeModal('modalCreateEvent')" aria-label="Close">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.events.store') }}">
                @csrf
                <div class="modal__body">

                    <div class="form-group">
                        <label class="form-label" for="ev_title">Event Title</label>
                        <input class="form-input" type="text" id="ev_title" name="title"
                               placeholder="e.g. Intramurals 2026" required/>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="ev_desc">Description</label>
                        <textarea class="form-textarea" id="ev_desc" name="description" rows="3"
                                  placeholder="Brief description shown on the events page…"></textarea>
                    </div>

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label" for="ev_date">Event Date</label>
                            <input class="form-input" type="date" id="ev_date" name="event_date" required/>
                        </div>
                        <div class="form-group">
                            <label class="form-label form-label--optional" for="ev_end_date">End Date</label>
                            <input class="form-input" type="date" id="ev_end_date" name="end_date"/>
                        </div>
                    </div>

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label" for="ev_time">Start Time</label>
                            <input class="form-input" type="time" id="ev_time" name="start_time"/>
                        </div>
                        <div class="form-group">
                            <label class="form-label form-label--optional" for="ev_end_time">End Time</label>
                            <input class="form-input" type="time" id="ev_end_time" name="end_time"/>
                        </div>
                    </div>

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label" for="ev_location">Location / Venue</label>
                            <input class="form-input" type="text" id="ev_location" name="location"
                                   placeholder="e.g. School Gymnasium"/>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="ev_category">Category</label>
                            <select class="form-select" id="ev_category" name="category" required>
                                <option value="">Select…</option>
                                <option>Academic</option>
                                <option>Sports</option>
                                <option>Cultural</option>
                                <option>Program</option>
                                <option>Community</option>
                                <option>Health</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal__footer">
                    <button type="button" class="btn btn--secondary" onclick="closeModal('modalCreateEvent')">Cancel</button>
                    <button type="submit" class="btn btn--primary">Save Event</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Delete confirm modal (shared) --}}
    @include('partials.admin.modal-delete', ['label' => 'event'])

@endsection