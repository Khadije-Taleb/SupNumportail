<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tableau de bord - Institut SupNum</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            background: #f5f7fa;
            color: #333;
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

        /* Removed old logo styles */

        .header-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
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

        /* Layout */
        .layout {
            display: flex;
            min-height: calc(100vh - 61px);
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            background: white;
            border-right: 1px solid #e0e0e0;
            padding: 20px 0;
            display: flex;
            flex-direction: column;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 24px;
            color: #666;
            text-decoration: none;
            transition: all 0.2s;
            border-left: 3px solid transparent;
            cursor: pointer;
        }

        .nav-item:hover {
            background: #f5f7fa;
            color: #2196f3;
        }

        .nav-item.active {
            background: #e3f2fd;
            color: #2196f3;
            border-left-color: #2196f3;
            font-weight: 500;
        }

        .nav-item svg {
            width: 20px;
            height: 20px;
            fill: currentColor;
        }

        .nav-item-logout {
            color: #f44336;
            margin-top: auto;
            border: none;
            background: none;
            width: 100%;
            font-family: inherit;
            font-size: inherit;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 32px;
            max-width: 1400px;
        }

        .welcome {
            margin-bottom: 32px;
        }

        .welcome h2 {
            font-size: 28px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .welcome p {
            color: #666;
            font-size: 15px;
        }

        /* Info Cards */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .info-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        .info-card-label {
            font-size: 12px;
            text-transform: uppercase;
            color: #999;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .info-card-value {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 4px;
        }

        .info-card-sub {
            font-size: 13px;
            color: #666;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            background: #e8f5e9;
            color: #2e7d32;
        }

        /* Section */
        .section {
            margin-bottom: 32px;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .section-header svg {
            width: 24px;
            height: 24px;
            fill: #2196f3;
        }

        .section-header h3 {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
        }

        /* Quick Actions */
        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .action-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .action-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.12);
        }

        .action-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }

        .action-icon.blue {
            background: #e3f2fd;
        }

        .action-icon.blue svg {
            fill: #2196f3;
        }

        .action-icon.purple {
            background: #f3e5f5;
        }

        .action-icon.purple svg {
            fill: #9c27b0;
        }

        .action-icon svg {
            width: 24px;
            height: 24px;
        }

        .action-card h4 {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .action-card p {
            font-size: 13px;
            color: #666;
            line-height: 1.5;
        }

        /* Notifications */
        .notifications-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .view-all {
            color: #2196f3;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        .view-all:hover {
            text-decoration: underline;
        }

        .notification-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .notification-item {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            display: flex;
            gap: 16px;
            transition: all 0.2s;
            cursor: pointer;
        }

        .notification-item:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .notification-icon.success {
            background: #e8f5e9;
        }

        .notification-icon.success svg {
            fill: #4caf50;
        }

        .notification-icon.info {
            background: #e3f2fd;
        }

        .notification-icon.info svg {
            fill: #2196f3;
        }

        .notification-icon.warning {
            background: #fff3e0;
        }

        .notification-icon.warning svg {
            fill: #ff9800;
        }

        .notification-icon svg {
            width: 20px;
            height: 20px;
        }

        .notification-content {
            flex: 1;
        }

        .notification-content h5 {
            font-size: 15px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 6px;
        }

        .notification-content p {
            font-size: 13px;
            color: #666;
            line-height: 1.5;
            margin-bottom: 8px;
        }

        .notification-time {
            font-size: 12px;
            color: #999;
        }

        @media (max-width: 968px) {
            .sidebar {
                display: none;
            }
            
            .main-content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    @php
        $initials = '';
        if($user && $user->full_name) {
            $parts = explode(' ', $user->full_name);
            $initials = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
        }
    @endphp

    <!-- Header -->
    <header class="header">
        <div class="header-left">
            <div class="logo">
                <span style="color: #16a34a;">SupNum</span><span style="color: #1d4ed8;">Portail</span>
            </div>
            <span class="header-title">Tableau de bord</span>
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
            <div class="user-menu" onclick="window.location='{{ route('etudiant.profil') }}'">
                <div class="user-avatar">{{ $initials }}</div>
                <div class="user-info">
                    <h3>{{ $user->full_name }}</h3>
                    <p>Étudiant {{ $etudiant->annee ?? '' }}</p>
                </div>
            </div>
        </div>
    </header>

    <div class="layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <a href="{{ route('etudiant.dashboard') }}" class="nav-item active">
                <svg viewBox="0 0 24 24">
                    <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                </svg>
                <span>Accueil</span>
            </a>
            <a href="{{ route('etudiant.demandes.index') }}" class="nav-item">
                <svg viewBox="0 0 24 24">
                    <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                </svg>
                <span>Mes Demandes</span>
            </a>
            <a href="{{ route('etudiant.certificats.create') }}" class="nav-item">
                <svg viewBox="0 0 24 24">
                    <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                </svg>
                <span>Certificat Médical</span>
            </a>
            <a href="{{ route('etudiant.notifications.index') }}" class="nav-item">
                <svg viewBox="0 0 24 24">
                    <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
                </svg>
                <span>Notifications</span>
            </a>
            
            <form method="POST" action="{{ route('logout') }}" id="logout-form" style="margin-top:auto">
                @csrf
                <button type="submit" class="nav-item nav-item-logout">
                    <svg viewBox="0 0 24 24">
                        <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                    </svg>
                    <span>Déconnexion</span>
                </button>
            </form>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Welcome Section -->
            <div class="welcome">
                <h2>Bienvenue, {{ $user->etudiant->prenom ?? $user->email }} !</h2>
                <p>Voici un aperçu de votre situation académique et de vos demandes en cours.</p>
            </div>

            @if(!$etudiant)
                <div class="section" style="margin-bottom: 20px;">
                    <div style="background: #fff3e0; border-left: 4px solid #ff9800; padding: 15px; border-radius: 8px; color: #e65100; font-size: 14px;">
                        Votre profil étudiant n'est pas encore complet. <a href="{{ route('etudiant.profil') }}" style="text-decoration: underline; font-weight: bold; color: inherit;">Complétez-le ici</a>.
                    </div>
                </div>
            @endif

            <!-- Info Cards -->
            <div class="info-grid">
                <div class="info-card">
                    <div class="info-card-label">Nom Complet</div>
                    <div class="info-card-value">{{ $user->full_name }}</div>
                </div>
                <div class="info-card">
                    <div class="info-card-label">Matricule</div>
                    <div class="info-card-value">{{ $etudiant->matricule ?? 'N/A' }}</div>
                </div>
                <div class="info-card">
                    <div class="info-card-label">Filière</div>
                    <div class="info-card-value">{{ $etudiant->filiere ?? 'N/A' }}</div>
                </div>
                <div class="info-card">
                    <div class="info-card-label">Année Académique</div>
                    <div class="info-card-value">{{ $etudiant->annee ?? 'N/A' }}</div>
                </div>
                <div class="info-card">
                    <div class="info-card-label">Email Institutionnel</div>
                    <div class="info-card-value">{{ $user->email }}</div>
                </div>
                <div class="info-card">
                    <div class="info-card-label">Statut</div>
                    <div class="info-card-value">
                        <span class="status-badge">Inscrit</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="section">
                <div class="section-header">
                    <svg viewBox="0 0 24 24">
                        <path d="M7 2v11h3v9l7-12h-4l4-8z"/>
                    </svg>
                    <h3>Actions rapides</h3>
                </div>
                <div class="actions-grid">
                    <a href="{{ route('etudiant.demandes.create') }}" class="action-card">
                        <div class="action-icon blue">
                            <svg viewBox="0 0 24 24">
                                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                            </svg>
                        </div>
                        <h4>Nouvelle demande</h4>
                        <p>Effectuez une demande administrative (relevé, attestation, duplicata).</p>
                    </a>
                    <a href="{{ route('etudiant.certificats.create') }}" class="action-card">
                        <div class="action-icon purple">
                            <svg viewBox="0 0 24 24">
                                <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                            </svg>
                        </div>
                        <h4>Déposer un certificat</h4>
                        <p>Transmettez vos justificatifs d'absence ou certificats médicaux en ligne.</p>
                    </a>
                </div>
            </div>

            <!-- Notifications -->
            <div class="section">
                <div class="notifications-header">
                    <div class="section-header">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
                        </svg>
                        <h3>Dernières notifications</h3>
                    </div>
                    <a href="{{ route('etudiant.notifications.index') }}" class="view-all">Voir tout</a>
                </div>
                <div class="notification-list">
                    @forelse($notifications as $notification)
                        <div class="notification-item">
                            <div class="notification-icon {{ $notification->lu ? 'info' : 'warning' }}">
                                <svg viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                                </svg>
                            </div>
                            <div class="notification-content">
                                <h5>Notification</h5>
                                <p>{{ $notification->message }}</p>
                                <div class="notification-time">{{ $notification->created_at ? $notification->created_at->diffForHumans() : '' }}</div>
                            </div>
                        </div>
                    @empty
                        <p style="text-align: center; color: #999; font-size: 14px; padding: 20px;">Aucune notification pour le moment.</p>
                    @endforelse
                </div>
            </div>
        </main>
    </div>
</body>
</html>

