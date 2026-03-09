{{-- resources/views/livewire/admin/partials/event-form.blade.php --}}

<div class="form-group">
    <label class="form-label" for="event_title">Event Title</label>
    <input wire:model="title" class="form-input {{ $errors->has('title') ? 'form-input--error' : '' }}" type="text" id="event_title" placeholder="e.g. Intramurals 2026"/>
    @error('title') <p class="form-error">{{ $message }}</p> @enderror
</div>

<div class="form-grid-2">
    <div class="form-group">
        <label class="form-label" for="event_category">Category</label>
        <select wire:model="formCategory" class="form-select {{ $errors->has('formCategory') ? 'form-input--error' : '' }}" id="event_category">
            <option value="">Select category…</option>
            <option value="Academic">Academic</option>
            <option value="Sports">Sports</option>
            <option value="Cultural">Cultural</option>
            <option value="Program">Program</option>
            <option value="Community">Community</option>
            <option value="Health">Health</option>
        </select>
        @error('formCategory') <p class="form-error">{{ $message }}</p> @enderror
    </div>
    <div class="form-group">
        <label class="form-label" for="event_status">Status</label>
        <select wire:model="formStatus" class="form-select" id="event_status">
            <option value="upcoming">Upcoming</option>
            <option value="scheduled">Scheduled</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
        </select>
    </div>
</div>

<div class="form-grid-2">
    <div class="form-group">
        <label class="form-label" for="event_date">Event Date</label>
        <input wire:model="eventDate" class="form-input {{ $errors->has('eventDate') ? 'form-input--error' : '' }}" type="date" id="event_date"/>
        @error('eventDate') <p class="form-error">{{ $message }}</p> @enderror
    </div>
    <div class="form-group">
        <label class="form-label form-label--optional" for="event_end_date">End Date</label>
        <input wire:model="endDate" class="form-input" type="date" id="event_end_date"/>
    </div>
</div>

<div class="form-grid-2">
    <div class="form-group">
        <label class="form-label form-label--optional" for="event_start_time">Start Time</label>
        <input wire:model="startTime" class="form-input" type="time" id="event_start_time"/>
    </div>
    <div class="form-group">
        <label class="form-label form-label--optional" for="event_end_time">End Time</label>
        <input wire:model="endTime" class="form-input" type="time" id="event_end_time"/>
    </div>
</div>

<div class="form-group">
    <label class="form-label form-label--optional" for="event_location">Location</label>
    <input wire:model="location" class="form-input" type="text" id="event_location" placeholder="e.g. School Gymnasium"/>
</div>

<div class="form-group">
    <label class="form-label form-label--optional" for="event_description">Description</label>
    <textarea wire:model="description" class="form-textarea" id="event_description" rows="3" placeholder="Brief description of the event…"></textarea>
</div>