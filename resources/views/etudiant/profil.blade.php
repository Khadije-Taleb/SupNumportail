<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profil Étudiant - SupNumPortail</title>
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

        .header-left {
            display: flex;
            gap: 32px;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0;
            font-size: 1.125rem;
            font-weight: 700;
            text-decoration: none;
        }

        .nav-link {
            text-decoration: none;
            color: #666;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 0;
            transition: color 0.2s;
            border-bottom: 2px solid transparent;
        }

        .nav-link:hover {
            color: #2196f3;
        }

        .nav-link.active {
            color: #2196f3;
            border-bottom-color: #2196f3;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
        }

        .user-id {
            font-size: 12px;
            color: #999;
        }

        .logout-btn {
            color: #f44336;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.2s;
            border: none;
            background: none;
            cursor: pointer;
            padding: 0;
            font-family: inherit;
        }

        .logout-btn:hover {
            color: #d32f2f;
            text-decoration: underline;
        }

        /* Container */
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 48px 20px;
        }

        /* Page Header */
        .page-header {
            border-left: 4px solid #2196f3;
            padding-left: 20px;
            margin-bottom: 40px;
        }

        .page-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .page-header p {
            color: #666;
            font-size: 14px;
        }

        /* Info Card */
        .info-card {
            background: white;
            border-radius: 12px;
            padding: 32px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 24px;
        }

        .section-title {
            font-size: 11px;
            font-weight: 700;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 24px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 32px 40px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 12px;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .info-value {
            font-size: 15px;
            color: #1a1a1a;
            font-weight: 500;
        }

        /* Security Card */
        .security-card {
            background: white;
            border-radius: 12px;
            padding: 32px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 24px;
        }

        .security-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .security-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .security-description {
            font-size: 13px;
            color: #666;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .btn-primary {
            background: #2196f3;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary:hover {
            background: #1976d2;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(33, 150, 243, 0.3);
        }

        /* Notice */
        .notice {
            text-align: center;
            font-size: 13px;
            color: #999;
            font-style: italic;
            margin: 32px 0;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 40px 20px;
            color: #999;
            font-size: 12px;
            border-top: 1px solid #e0e0e0;
            margin-top: 48px;
        }



        /* Alert Messages */
        .alert {
            padding: 16px 20px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 14px;
        }

        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
            border-left: 4px solid #4caf50;
        }

        .alert-error {
            background: #ffebee;
            color: #c62828;
            border-left: 4px solid #f44336;
        }

        /* Standard Header CSS */
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

        .user-info h3 {
            font-size: 13px;
            font-weight: 600;
            color: #333;
        }

        .user-info p {
            font-size: 11px;
            color: #999;
        }

        @media (max-width: 768px) {
            .header { padding: 16px 20px; flex-wrap: wrap; }
            .header-left { gap: 20px; order: 1; width: 100%; margin-bottom: 12px; }
            .header-right { order: 2; width: 100%; justify-content: space-between; }
            .nav-link { display: none; }
            .container { padding: 32px 16px; }
            .info-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    @php
        $user = Auth::user();
        $etudiant = $user->etudiant;
    @endphp

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
            <!-- Logout hidden or moved to user menu logic in future, currently kept in page or menu -->
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1>Profil Étudiant</h1>
            <p>Registre officiel des informations académiques.</p>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
        @endif

        @if(session('warning'))
        <div class="alert" style="background: #fff3e0; color: #e65100; border-left: 4px solid #ff9800;">
            {{ session('warning') }}
        </div>
        @endif

        <!-- Personal Information -->
        <div class="info-card">
            <h3 class="section-title">Informations Personnelles</h3>
            @if($etudiant)
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Nom</div>
                        <div class="info-value">{{ $etudiant->nom }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Prénom</div>
                        <div class="info-value">{{ $etudiant->prenom }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Matricule</div>
                        <div class="info-value">{{ $etudiant->matricule }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email Institutionnel</div>
                        <div class="info-value">{{ $user->email }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Filière</div>
                        <div class="info-value">{{ $etudiant->filiere }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Année d'Étude</div>
                        <div class="info-value">{{ $etudiant->annee }}</div>
                    </div>
                </div>
            @else
                <div style="color: #f44336; padding: 20px; text-align: center;">
                    Profil étudiant incomplet. Veuillez contacter l'administration.
                </div>
            @endif
        </div>

        <!-- Security Section -->
        <div class="security-card">
            <div class="security-header">
                <div>
                    <h3 class="security-title">Sécurité du compte</h3>
                    <p class="security-description">
                        Pour garantir l'intégrité de vos données académiques, nous vous recommandons<br>
                        de mettre à jour votre mot de passe régulièrement.
                    </p>
                </div>
            </div>
            <a href="{{ route('password.change') }}" class="btn-primary">
                Modifier le mot de passe
            </a>
        </div>

        <!-- Notice -->
        <div class="notice">
            Une erreur dans vos informations ? Veuillez contacter le scolarité de l'établissement
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-text">© 2024 SUPNUMPORTAIL - INSTITUT SUPÉRIEUR DU NUMÉRIQUE</div>
    </footer>



    <script>
        // Auto-hide success/error messages after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>
