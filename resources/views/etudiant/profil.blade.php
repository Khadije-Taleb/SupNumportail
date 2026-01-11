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
            padding: 16px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
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

        /* Floating Toolbar */
        .toolbar {
            position: fixed;
            bottom: 32px;
            left: 50%;
            transform: translateX(-50%);
            background: #1a1a1a;
            border-radius: 12px;
            padding: 12px 16px;
            display: flex;
            gap: 8px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.3);
        }

        .toolbar-btn {
            width: 48px;
            height: 48px;
            border: none;
            background: transparent;
            cursor: pointer;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }

        .toolbar-btn:hover {
            background: rgba(255,255,255,0.1);
        }

        .toolbar-btn.active {
            background: #2196f3;
        }

        .toolbar-btn svg {
            width: 24px;
            height: 24px;
            fill: white;
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
            <a href="{{ route('etudiant.dashboard') }}" class="nav-link">Tableau de bord</a>
            <a href="{{ route('etudiant.profil') }}" class="nav-link active">Profil</a>
        </div>
        <div class="header-right">
            <div class="user-info">
                <div class="user-name">{{ $user->full_name }}</div>
                <div class="user-id">{{ $etudiant->matricule ?? 'N/A' }}</div>
            </div>
            <a href="{{ route('logout') }}" class="logout-btn" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Déconnexion
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
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

    <!-- Floating Toolbar -->
    <div class="toolbar">
        <a href="{{ route('etudiant.dashboard') }}" class="toolbar-btn {{ request()->routeIs('etudiant.dashboard') ? 'active' : '' }}" title="Dashboard">
            <svg viewBox="0 0 24 24">
                <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
            </svg>
        </a>
        <a href="{{ route('etudiant.demandes.index') }}" class="toolbar-btn {{ request()->routeIs('etudiant.demandes.*') ? 'active' : '' }}" title="Demandes">
            <svg viewBox="0 0 24 24">
                <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
            </svg>
        </a>
        <a href="{{ route('etudiant.certificats.create') }}" class="toolbar-btn {{ request()->routeIs('etudiant.certificats.*') ? 'active' : '' }}" title="Certificats">
            <svg viewBox="0 0 24 24">
                <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
            </svg>
        </a>
        <a href="{{ route('etudiant.profil') }}" class="toolbar-btn {{ request()->routeIs('etudiant.profil') ? 'active' : '' }}" title="Profil">
            <svg viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
            </svg>
        </a>
    </div>

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
