<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mes Notifications - SupNumPortail</title>
    <style>
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
            border-bottom: 3px solid #2196f3;
            padding: 12px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0;
            font-size: 1.125rem;
            font-weight: 700;
            text-decoration: none;
        }

        .nav {
            display: flex;
            gap: 1.5rem;
        }

        .nav-link {
            text-decoration: none;
            color: #64748b;
            font-size: 0.9375rem;
            transition: color 0.2s;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid transparent;
        }

        .nav-link:hover {
            color: #1e293b;
        }

        .nav-link.active {
            color: #3b82f6;
            border-bottom-color: #3b82f6;
            font-weight: 500;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .icon-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: #f5f7fa;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            position: relative;
            text-decoration: none;
            color: inherit;
        }

        .icon-btn:hover {
            background: #e8eaf6;
        }

        .icon-btn svg {
            width: 20px;
            height: 20px;
            fill: #666;
        }

        .notification-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background: #f44336;
            color: white;
            min-width: 18px;
            height: 18px;
            padding: 0 4px;
            border-radius: 9px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            line-height: 1;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 12px;
            border-radius: 8px;
            background: #f5f7fa;
            cursor: pointer;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }

        .user-info h3 {
            font-size: 13px;
            font-weight: 600;
            color: #333;
        }

        .user-info p {
            font-size: 11px;
            color: #999;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0;
            font-size: 1.125rem;
            font-weight: 700;
            text-decoration: none;
        }
        .header-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .icon-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: #f5f7fa;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            position: relative;
            text-decoration: none;
            color: inherit;
        }

        .icon-btn:hover {
            background: #e8eaf6;
        }

        .icon-btn svg {
            width: 20px;
            height: 20px;
            fill: #666;
        }

        .notification-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background: #f44336;
            color: white;
            min-width: 18px;
            height: 18px;
            padding: 0 4px;
            border-radius: 9px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            line-height: 1;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 12px;
            border-radius: 8px;
            background: #f5f7fa;
            cursor: pointer;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }

        .user-info h3 {
            font-size: 13px;
            font-weight: 600;
            color: #333;
        }

        .user-info p {
            font-size: 11px;
            color: #999;
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
            color: #2196f3;
        }

        .nav-link.active {
            color: #2196f3;
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
            border-left: 4px solid #2196f3;
            padding-left: 20px;
        }

        .notification-checkbox {
            width: 20px;
            height: 20px;
            margin-top: 2px;
            cursor: pointer;
            accent-color: #2196f3;
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
            background: #2196f3;
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
            background: #2196f3;
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
            background: #e8eaf6;
            color: #2196f3;
        }

        .sidebar-action svg {
            width: 16px;
            height: 16px;
            fill: currentColor;
        }

        /* Load More */
        .load-more {
            text-align: center;
            margin-top: 32px;
        }

        .load-more-btn {
            color: #2196f3;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 12px 24px;
            border-radius: 8px;
            transition: all 0.2s;
            border: 1px solid #e3f2fd;
            background: white;
            cursor: pointer;
        }

        .load-more-btn:hover {
            background: #e3f2fd;
        }

        .load-more-btn svg {
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
    <!-- Header -->
    <header class="header">
        <div class="header-left">
            <a href="{{ route('etudiant.dashboard') }}" class="logo">
                <span style="color: #16a34a;">SupNum</span><span style="color: #1d4ed8;">Portail</span>
            </a>
            <nav class="nav">
                <a href="{{ route('etudiant.dashboard') }}" class="nav-link {{ request()->routeIs('etudiant.dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('etudiant.demandes.index') }}" class="nav-link {{ request()->routeIs('etudiant.demandes.*') ? 'active' : '' }}">Demandes</a>
                <a href="{{ route('etudiant.certificats.create') }}" class="nav-link {{ request()->routeIs('etudiant.certificats.*') ? 'active' : '' }}">Certificats</a>
                <a href="{{ route('etudiant.profil') }}" class="nav-link {{ request()->routeIs('etudiant.profil') ? 'active' : '' }}">Profil</a>
            </nav>
        </div>
        <div class="header-right">
             <a href="{{ route('etudiant.notifications.index') }}" class="icon-btn" style="text-decoration: none;">
                <svg viewBox="0 0 24 24">
                    <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2zm-2 1H8v-6c0-2.48 1.51-4.5 4-4.5s4 2.02 4 4.5v6z"/>
                </svg>
                @if(isset($unreadCount) && $unreadCount > 0)
                    <span class="notification-badge">{{ $unreadCount }}</span>
                @endif
            </a>
            <form method="POST" action="{{ route('logout') }}" style="display: flex; align-items: center;">
                @csrf
                <button type="submit" class="icon-btn" title="Déconnexion" style="color: #ef4444;">
                    <svg viewBox="0 0 24 24" style="fill: currentColor;">
                        <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                    </svg>
                </button>
            </form>
            <div class="user-menu" onclick="window.location='{{ route('etudiant.profil') }}'">
                <div class="user-avatar">{{ Auth::user()->initials }}</div>
                <div class="user-info">
                    <h3>{{ Auth::user()->full_name }}</h3>
                    <p>Étudiant {{ Auth::user()->etudiant->annee ?? '' }}</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1>Mes Notifications</h1>
            <p>Gérez vos mises à jour administratives et académiques.</p>
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
                                    Mise à jour Certificat Médical
                                @elseif(str_contains(strtolower($notification->message), 'demande'))
                                    Mise à jour Demande Administrative
                                @else
                                    Notification Système
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
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        © {{ date('Y') }} SupNumPortail - Tous droits réservés.
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
            
            fetch(`/etudiant/notifications/${id}/read`, {
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
            fetch('/etudiant/notifications/mark-all-read', {
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

        // Checkbox selection (visual only for now)
        const checkboxes = document.querySelectorAll('.notification-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function(e) {
                e.stopPropagation();
            });
        });
    </script>
</body>
</html>
