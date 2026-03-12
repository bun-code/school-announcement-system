{{-- resources/views/livewire/admin/partials/announcement-form.blade.php --}}
{{-- Shared between create and edit modals. All fields bind to the parent Livewire component. --}}

<div class="form-group">
    <label class="form-label" for="ann_title">Title</label>
    <input
        wire:model="title"
        class="form-input {{ $errors->has('title') ? 'form-input--error' : '' }}"
        type="text"
        id="ann_title"
        placeholder="Enter announcement title…"
    />
    @error('title')
        <p class="form-error">{{ $message }}</p>
    @enderror
</div>

<div class="form-grid-2">
    <div class="form-group">
        <label class="form-label" for="ann_category">Category</label>
        <select
            wire:model="formCategory"
            class="form-select {{ $errors->has('formCategory') ? 'form-input--error' : '' }}"
            id="ann_category"
        >
            <option value="">Select category…</option>
            <option value="General">General</option>
            <option value="Academic">Academic</option>
            <option value="Notice">Notice</option>
            <option value="Health">Health</option>
            <option value="Community">Community</option>
        </select>
        @error('formCategory')
            <p class="form-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="ann_status">Status</label>
        <select wire:model="formStatus" class="form-select" id="ann_status">
            <option value="published">Published</option>
            <option value="draft">Draft</option>
        </select>
    </div>
</div>

<div class="form-group">
    <label class="form-label" for="ann_body">Content</label>
    <textarea
        wire:model="body"
        class="form-textarea {{ $errors->has('body') ? 'form-input--error' : '' }}"
        id="ann_body"
        rows="6"
        placeholder="Write the full announcement here…"
    ></textarea>
    @error('body')
        <p class="form-error">{{ $message }}</p>
    @enderror
</div>

<div class="form-grid-2">
    <div class="form-group">
        <label class="form-label" for="ann_post_date">Post Date</label>
        <input
            wire:model="postDate"
            class="form-input {{ $errors->has('postDate') ? 'form-input--error' : '' }}"
            type="date"
            id="ann_post_date"
        />
        @error('postDate')
            <p class="form-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label form-label--optional" for="ann_expiry">Expiry Date</label>
        <input
            wire:model="expiryDate"
            class="form-input"
            type="date"
            id="ann_expiry"
        />
        @error('expiryDate')
            <p class="form-error">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="form-group">
    <label class="form-check">
        <input wire:model="isPinned" type="checkbox" />
        <span class="form-check-label">📌 Pin this announcement to the top of the page</span>
    </label>
</div>
