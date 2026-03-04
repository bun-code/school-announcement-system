{{-- resources/views/partials/admin/modal-delete.blade.php --}}
{{-- Usage: @include('partials.admin.modal-delete', ['label' => 'announcement']) --}}

<div class="modal-overlay" id="modalDeleteConfirm" role="dialog" aria-modal="true" aria-labelledby="modalDeleteTitle">
    <div class="modal modal--sm">
        <div class="modal__body" style="text-align:center;padding-top:var(--space-8);">
            <div class="modal--confirm">
                <div class="modal__icon">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
            </div>
            <h3 id="modalDeleteTitle" style="font-size:var(--text-lg);font-weight:700;color:var(--admin-text-heading);margin-bottom:var(--space-3);">
                Delete {{ ucfirst($label ?? 'record') }}?
            </h3>
            <p style="font-size:var(--text-sm);color:var(--admin-text-muted);max-width:300px;margin:0 auto;">
                This action cannot be undone. This {{ $label ?? 'record' }} will be permanently removed from the site.
            </p>
        </div>
        <div class="modal__footer" style="justify-content:center;">
            <button class="btn btn--secondary" onclick="closeModal('modalDeleteConfirm')">Cancel</button>
            <form method="POST" action="#" id="deleteForm" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn--danger">Yes, Delete</button>
            </form>
        </div>
    </div>
</div>