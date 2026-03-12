{{-- resources/views/partials/admin/modal-scripts.blade.php --}}
{{-- Include once in layouts/admin.blade.php just before </body>
     OR push via @push('scripts') from each page --}}

<script>
    /**
     * Open a modal overlay by its ID.
     * @param {string} id - The modal overlay element ID
     */
    function openModal(id) {
        const el = document.getElementById(id);
        if (!el) return;
        el.classList.add('open');
        document.body.style.overflow = 'hidden';

        // Trap focus inside modal
        const focusable = el.querySelectorAll(
            'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
        );
        if (focusable.length) focusable[0].focus();
    }

    /**
     * Close a modal overlay by its ID.
     * @param {string} id - The modal overlay element ID
     */
    function closeModal(id) {
        const el = document.getElementById(id);
        if (!el) return;
        el.classList.remove('open');
        document.body.style.overflow = '';
    }

    /**
     * Set the delete form action dynamically for the confirmation modal.
     * @param {string} action
     */
    function setDeleteAction(action) {
        const form = document.getElementById('deleteForm');
        if (form && action) {
            form.action = action;
        }
    }

    // Close modal on overlay backdrop click
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('modal-overlay')) {
            e.target.classList.remove('open');
            document.body.style.overflow = '';
        }
    });

    // Close modal on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay.open').forEach(el => {
                el.classList.remove('open');
                document.body.style.overflow = '';
            });
        }
    });
</script>
