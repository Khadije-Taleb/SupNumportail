@extends('layouts.student')

@section('title', 'Mes Notifications')

@section('styles')
<style>
    .notifications-container {
        max-width: 800px;
        margin: 0 auto;
    }
    .page-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 24px;
        color: #1a202c;
    }
    .notification-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 16px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        display: flex;
        gap: 16px;
        transition: transform 0.2s, box-shadow 0.2s;
        border-left: 4px solid transparent;
        text-decoration: none;
        color: inherit;
    }
    .notification-card.unread {
        border-left-color: #3182ce;
        background: #ebf8ff;
    }
    .notification-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .notif-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .notif-icon.certificat { background: #e9d8fd; color: #805ad5; }
    .notif-icon.demande { background: #bee3f8; color: #3182ce; }
    .notif-body { flex: 1; }
    .notif-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 4px;
    }
    .notif-title { font-weight: 700; font-size: 16px; }
    .notif-time { font-size: 12px; color: #718096; }
    .notif-message { font-size: 14px; color: #4a5568; line-height: 1.5; }
    
    .empty-state {
        text-align: center;
        padding: 48px;
        color: #718096;
    }
    .empty-state svg {
        width: 64px;
        height: 64px;
        margin: 0 auto 16px;
        opacity: 0.5;
    }
</style>
@endsection

@section('content')
<div class="notifications-container">
    <div class="page-title">Mes Notifications</div>

    <div class="notification-list">
        @foreach($notifications as $notification)
            <a href="javascript:void(0)" 
               onclick="handleNotificationClick(this, {{ $notification->id }}, '{{ $notification->link }}')"
               class="notification-card {{ !$notification->is_read ? 'unread' : '' }}"
               data-link="{{ $notification->link }}">
                <div class="notif-icon {{ $notification->type === 'certificat' ? 'certificat' : 'demande' }}">
                    @if($notification->type === 'certificat')
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    @else
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    @endif
                </div>
                <div class="notif-body">
                    <div class="notif-header">
                        <span class="notif-title">{{ $notification->title ?? 'Notification' }}</span>
                        <span class="notif-time">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="notif-message">{{ $notification->message }}</div>
                </div>
            </a>
        @endforeach
        @if($notifications->isEmpty())
            <div class="empty-state">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <p>Vous n'avez aucune notification pour le moment.</p>
            </div>
        @endif
    </div>

    <div style="margin-top: 24px;">
        {{ $notifications->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    function handleNotificationClick(element, id, link = '') {
        if (element.classList.contains('unread')) {
            markAsRead(element, id, link);
        } else if (link) {
            window.location.href = link;
        }
    }

    function markAsRead(element, id, link = '') {
        fetch(`/etudiant/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                element.classList.remove('unread');
                
                // Update the badge in the header
                const badge = document.querySelector('.notification-badge');
                if (badge) {
                    let count = parseInt(badge.textContent);
                    count = Math.max(0, count - 1);
                    if (count > 0) {
                        badge.textContent = count;
                    } else {
                        badge.remove();
                    }
                }

                if (link) {
                    window.location.href = link;
                }
            }
        });
    }
</script>
@endpush
