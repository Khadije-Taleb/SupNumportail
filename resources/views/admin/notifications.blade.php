<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Notifications Admin - SupNumPortail</title>
    <style>
        /* [Same CSS as student version] */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            background: #f8f9fa;
            color: #333;
            min-height: 100vh;
        }

        /* Header */
        .header {
            background: white;
            padding: 16px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 16px;
            font-weight: 700;
            color: #1a1a1a;
            text-decoration: none;
        }

        .logo-icon {
            width: 24px;
            height: 24px;
            background: #4caf50; /* Green for Admin */
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transform: rotate(45deg);
        }

        .logo-icon-inner {
            width: 12px;
            height: 12px;
            background: white;
            border-radius: 2px;
            transform: rotate(-45deg);
        }

        .nav {
            display: flex;
            gap: 32px;
            align-items: center;
        }

        .nav-link {
            text-decoration: none;
            color: #666;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 0;
            transition: color 0.2s;
        }

        .nav-link:hover {
            color: #4caf50;
        }

        .nav-link.active {
            color: #4caf50;
            font-weight: 600;
        }

        /* Container */
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 48px 20px;
        }

        /* Page Header */
        .page-header {
            margin-bottom: 40px;
        }

        .page-header h1 {
            font-size: 32px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .page-header p {
            color: #666;
            font-size: 15px;
        }

        /* Notifications List */
        .notifications-container {
            display: flex;
            gap: 24px;
        }

        .notifications-list {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* Notification Item */
        .notification-item {
            background: white;
            border-radius: 12px;
            padding: 20px 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            display: flex;
            gap: 16px;
            transition: all 0.2s;
            cursor: pointer;
            position: relative;
        }

        .notification-item:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }

        .notification-item.unread {
            border-left: 4px solid #4caf50;
            padding-left: 20px;
        }

        .notification-checkbox {
            width: 20px;
            height: 20px;
            margin-top: 2px;
            cursor: pointer;
            accent-color: #4caf50;
        }

        .notification-content {
            flex: 1;
        }

        .notification-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 6px;
        }

        .notification-title {
            font-size: 15px;
            font-weight: 600;
            color: #1a1a1a;
        }

        .badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge.nouveau {
            background: #4caf50;
            color: white;
        }

        .notification-date {
            font-size: 12px;
            color: #999;
            margin-bottom: 8px;
        }

        .notification-text {
            font-size: 14px;
            color: #666;
            line-height: 1.6;
        }

        .notification-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #4caf50;
            flex-shrink: 0;
            margin-top: 6px;
        }

        .notification-item.read .notification-indicator {
            background: transparent;
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            flex-shrink: 0;
        }

        .sidebar-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            position: sticky;
            top: 100px;
        }

        .sidebar-title {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 16px;
        }

        .sidebar-action {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            background: #f5f7fa;
            border-radius: 8px;
            font-size: 13px;
            color: #666;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
        }

        .sidebar-action:hover {
            background: #e8f5e9;
            color: #4caf50;
        }

        .sidebar-action svg {
            width: 16px;
            height: 16px;
            fill: currentColor;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 40px 20px;
            color: #999;
            font-size: 12px;
            margin-top: 48px;
            border-top: 1px solid #e0e0e0;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        .empty-state svg {
            width: 80px;
            height: 80px;
            fill: #ccc;
            margin-bottom: 24px;
        }

        .empty-state h3 {
            font-size: 20px;
            font-weight: 600;
            color: #666;
            margin-bottom: 8px;
        }

        .empty-state p {
            color: #999;
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 968px) {
            .notifications-container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .sidebar-card {
                position: static;
            }
        }

        @media (max-width: 768px) {
            .header {
                padding: 16px 20px;
            }

            .nav {
                display: none;
            }

            .container {
                padding: 32px 16px;
            }

            .page-header h1 {
                font-size: 24px;
            }

            .notification-item {
                padding: 16px;
            }

            .notification-item.unread {
                padding-left: 12px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <a href="{{ route('admin.dashboard') }}" class="logo">
            <div class="logo-icon">
                <div class="logo-icon-inner"></div>
            </div>
            <span>Admin Portal</span>
        </a>
        <nav class="nav">
            <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
            <a href="{{ route('admin.demandes.index') }}" class="nav-link">Demandes</a>
            <a href="{{ route('admin.certificats.index') }}" class="nav-link">Certificats</a>
            <a href="{{ route('admin.etudiants.import') }}" class="nav-link">Import</a>
        </nav>
    </header>

    <!-- Main Content -->
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1>Notifications Admin</h1>
            <p>Gérez vos notifications système et alertes de gestion.</p>
        </div>

        <div class="notifications-container">
            <!-- Notifications List -->
            <div class="notifications-list">
                @forelse($notifications as $notification)
                <div class="notification-item {{ $notification->lu ? 'read' : 'unread' }}" 
                     data-id="{{ $notification->id }}">
                    <input type="checkbox" class="notification-checkbox" 
                           data-id="{{ $notification->id }}">
                    <div class="notification-content">
                        <div class="notification-header">
                            <span class="notification-title">
                                @if(str_contains(strtolower($notification->message), 'certificat'))
                                    Alerte Certificat Médical
                                @elseif(str_contains(strtolower($notification->message), 'demande'))
                                    Alerte Nouvelle Demande
                                @else
                                    Alerte Système
                                @endif
                            </span>
                            @if(!$notification->lu)
                                <span class="badge nouveau">Nouveau</span>
                            @endif
                        </div>
                        <div class="notification-date">
                            {{ $notification->created_at ? $notification->created_at->format('d M Y à H:i') : '' }}
                        </div>
                        <div class="notification-text">
                            {{ $notification->message }}
                        </div>
                    </div>
                    @if(!$notification->lu)
                        <div class="notification-indicator"></div>
                    @endif
                </div>
                @empty
                <div class="empty-state">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
                    </svg>
                    <h3>Aucune notification</h3>
                    <p>Vous n'avez pas de nouvelles notifications pour le moment.</p>
                </div>
                @endforelse

                <!-- Pagination Links -->
                <div class="mt-4">
                    {{ $notifications->links() }}
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="sidebar">
                <div class="sidebar-card">
                    <h3 class="sidebar-title">Actions rapides</h3>
                    <a href="#" class="sidebar-action" onclick="markAllAsRead(); return false;">
                        <svg viewBox="0 0 24 24">
                            <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/>
                        </svg>
                        <span>Tout marquer comme lu</span>
                    </a>
                </div>
            </aside>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        © {{ date('Y') }} SupNumPortail Admin - Tous droits réservés.
    </footer>

    <script>
        // Mark notification as read when clicked
        document.querySelectorAll('.notification-item.unread').forEach(item => {
            item.addEventListener('click', function(e) {
                if (e.target.type !== 'checkbox') {
                    const notificationId = this.dataset.id;
                    markAsRead(notificationId, this);
                }
            });
        });

        // Mark individual notification as read
        function markAsRead(id, element) {
            if (!id) {
                console.error('Notification ID is missing');
                alert('Erreur: ID de notification manquant.');
                return;
            }

            console.log('Marking notification as read:', id);
            
            fetch(`/admin/notifications/${id}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
            .then(async response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    const errorText = await response.text();
                    console.error('Error response:', errorText);
                    let errorData;
                    try {
                        errorData = JSON.parse(errorText);
                    } catch (e) {
                        errorData = { message: 'Erreur serveur: ' + response.status + ' - ' + errorText.substring(0, 100) };
                    }
                    throw new Error(errorData.message || 'Network response was not ok');
                }
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('application/json')) {
                    return response.json();
                } else {
                    throw new Error('Réponse serveur invalide');
                }
            })
            .then(data => {
                console.log('Success response:', data);
                if (data.success) {
                    element.classList.remove('unread');
                    element.classList.add('read');
                    const indicator = element.querySelector('.notification-indicator');
                    if (indicator) indicator.remove();
                    const badge = element.querySelector('.badge.nouveau');
                    if (badge) badge.remove();
                } else {
                    console.error('Error marking notification as read:', data.message || 'Unknown error');
                    alert(data.message || 'Erreur lors de la mise à jour de la notification.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erreur lors de la communication avec le serveur: ' + error.message);
            });
        }

        // Mark all notifications as read
        function markAllAsRead() {
            fetch('/admin/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(async response => {
                if (!response.ok) {
                    const errorText = await response.text();
                    let errorData;
                    try {
                        errorData = JSON.parse(errorText);
                    } catch (e) {
                        errorData = { message: 'Erreur serveur: ' + response.status };
                    }
                    throw new Error(errorData.message || 'Network response was not ok');
                }
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('application/json')) {
                    return response.json();
                } else {
                    throw new Error('Réponse serveur invalide');
                }
            })
            .then(data => {
                if (data.success) {
                    document.querySelectorAll('.notification-item.unread').forEach(item => {
                        item.classList.remove('unread');
                        item.classList.add('read');
                        const indicator = item.querySelector('.notification-indicator');
                        if (indicator) indicator.remove();
                        const badge = item.querySelector('.badge.nouveau');
                        if (badge) badge.remove();
                    });
                    alert(data.message || 'Toutes les notifications ont été marquées comme lues.');
                } else {
                    console.error('Error marking all notifications as read:', data.message || 'Unknown error');
                    alert(data.message || 'Erreur lors de la mise à jour des notifications.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erreur lors de la communication avec le serveur. Veuillez réessayer.');
            });
        }
    </script>
</body>
</html>
