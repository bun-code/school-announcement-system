<div class="modal-overlay" id="modalLogoutConfirm" role="dialog" aria-modal="true" aria-labelledby="modalLogoutConfirmTitle">
    <div class="modal modal--sm modal--confirm">
        <div class="modal__header">
            <div>
                <h2 class="modal__title" id="modalLogoutConfirmTitle">Confirm Logout</h2>
                <p class="modal__subtitle">You’re about to end this admin session.</p>
            </div>
            <button class="modal__close" onclick="closeModal('modalLogoutConfirm')" aria-label="Close">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="modal__body">
            <p>Do you want to log out now?</p>
        </div>
        <div class="modal__footer">
            <button type="button" class="btn btn--secondary" onclick="closeModal('modalLogoutConfirm')">Cancel</button>
            <button type="button" class="btn btn--danger" onclick="document.getElementById('logoutForm').submit()">Logout</button>
        </div>
    </div>
</div>
