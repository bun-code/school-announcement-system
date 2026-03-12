@if(session('subscribe_success'))
<div class="info-modal-overlay" id="modalSubscribeSuccess" role="dialog" aria-modal="true" aria-labelledby="modalSubscribeSuccessTitle">
    <div class="info-modal">

        <div class="info-modal__header">
            <div class="info-modal__header-icon">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <h2 class="info-modal__title" id="modalSubscribeSuccessTitle">Subscription Update</h2>
                <p class="info-modal__subtitle">Email notifications</p>
            </div>
            <button class="info-modal__close" onclick="closeInfoModal('modalSubscribeSuccess')" aria-label="Close">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="info-modal__body">
            <p class="info-modal__lead">{{ session('subscribe_success') }}</p>
        </div>

        <div class="info-modal__footer">
            <button class="btn btn--primary" onclick="closeInfoModal('modalSubscribeSuccess')">Okay</button>
        </div>

    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof openInfoModal === 'function') {
            openInfoModal('modalSubscribeSuccess');
        } else {
            const modal = document.getElementById('modalSubscribeSuccess');
            if (modal) modal.classList.add('open');
            document.body.style.overflow = 'hidden';
        }
    });
</script>
@endpush
@endif
