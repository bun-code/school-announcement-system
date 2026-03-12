<div class="modal-overlay" id="modalAdminNotifications" role="dialog" aria-modal="true" aria-labelledby="modalAdminNotificationsTitle">
    <div class="modal modal--lg">
        <div class="modal__header">
            <div>
                <h2 class="modal__title" id="modalAdminNotificationsTitle">Notifications</h2>
                <p class="modal__subtitle">
                    @if($adminNotifCount > 0)
                        Recent announcements and upcoming events.
                    @else
                        No notifications available.
                    @endif
                </p>
            </div>
            <button class="modal__close" onclick="closeModal('modalAdminNotifications')" aria-label="Close">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="modal__body">
            <div class="notif-grid">
                <div class="notif-panel">
                    <div class="notif-panel__header">
                        <p class="notif-panel__title">Latest Announcements</p>
                        <a href="{{ route('admin.announcements.index') }}" class="btn btn--secondary btn--sm">View All</a>
                    </div>
                    <div class="notif-list">
                        @forelse($adminNotifAnnouncements as $announcement)
                            <div class="notif-item">
                                <div class="notif-item__main">
                                    <p class="notif-item__title">{{ $announcement->title }}</p>
                                    <p class="notif-item__meta">
                                        {{ $announcement->post_date?->format('M j, Y') ?? 'Draft' }}
                                    </p>
                                </div>
                                <span class="badge {{ $announcement->category_color }}">{{ $announcement->category }}</span>
                            </div>
                        @empty
                            <p class="notif-empty">No published announcements yet.</p>
                        @endforelse
                    </div>
                </div>

                <div class="notif-panel">
                    <div class="notif-panel__header">
                        <p class="notif-panel__title">Upcoming Events</p>
                        <a href="{{ route('admin.events.index') }}" class="btn btn--secondary btn--sm">View All</a>
                    </div>
                    <div class="notif-list">
                        @forelse($adminNotifEvents as $event)
                            <div class="notif-item">
                                <div class="notif-item__main">
                                    <p class="notif-item__title">{{ $event->title }}</p>
                                    <p class="notif-item__meta">
                                        {{ $event->event_date?->format('M j, Y') ?? 'TBD' }}
                                    </p>
                                </div>
                                <span class="badge {{ $event->category_color }}">{{ $event->category }}</span>
                            </div>
                        @empty
                            <p class="notif-empty">No upcoming events yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="modal__footer">
            <button type="button" class="btn btn--primary" onclick="closeModal('modalAdminNotifications')">Close</button>
        </div>
    </div>
</div>
