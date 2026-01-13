<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SupNumPortail') - Institut SupNum</title>
    <style>
        /* Base and Reset */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            background: #f5f7fa;
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
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
            gap: 24px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }

        .logo img {
            height: 45px;
            width: auto;
            background: transparent;
            display: block;
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

        .nav-link:hover { color: #1e293b; }

        .nav-link.active {
            color: #3b82f6;
            border-bottom-color: #3b82f6;
            font-weight: 500;
        }

        /* Right Header Icons */
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

        .icon-btn:hover { background: #e8eaf6; }

        .icon-btn svg { width: 20px; height: 20px; fill: #666; }

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

        /* User Menu */
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

        .user-info h3 { font-size: 13px; font-weight: 600; color: #333; }
        .user-info p { font-size: 11px; color: #999; }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 32px 24px;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav { display: none; }
            .header { padding: 12px 16px; }
            .user-info { display: none; }
        }

        @yield('styles')
    </style>
</head>
<body>
    @php
        $user = Auth::user();
        $etudiant = $user->etudiant;
    @endphp

    <header class="header">
        <div class="header-left">
            <a href="{{ route('etudiant.dashboard') }}" class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="SupNum logo">
                <span style="color: #16a34a; font-weight: 700; font-size: 1.25rem;">SupNum</span><span style="color: #1d4ed8; font-weight: 700; font-size: 1.25rem;">Portail</span>
            </a>
            <nav class="nav">
                <a href="{{ route('etudiant.dashboard') }}" class="nav-link {{ request()->routeIs('etudiant.dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('etudiant.demandes.index') }}" class="nav-link {{ request()->routeIs('etudiant.demandes.*') ? 'active' : '' }}">Demandes</a>
                <a href="{{ route('etudiant.certificats.create') }}" class="nav-link {{ request()->routeIs('etudiant.certificats.*') ? 'active' : '' }}">Certificats</a>
                <a href="{{ route('etudiant.profil') }}" class="nav-link {{ request()->routeIs('etudiant.profil') ? 'active' : '' }}">Profil</a>
            </nav>
        </div>

        <div class="header-right">
            <a href="{{ route('etudiant.notifications.index') }}" class="icon-btn" title="Notifications">
                <svg viewBox="0 0 24 24">
                    <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2zm-2 1H8v-6c0-2.48 1.51-4.5 4-4.5s4 2.02 4 4.5v6z"/>
                </svg>
                @if($unreadCount > 0)
                    <span class="notification-badge">{{ $unreadCount }}</span>
                @endif
            </a>

            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <button type="submit" class="icon-btn" title="Déconnexion" style="color: #ef4444;">
                    <svg viewBox="0 0 24 24" style="fill: currentColor;">
                        <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                    </svg>
                </button>
            </form>

            <div class="user-menu" onclick="window.location='{{ route('etudiant.profil') }}'">
                <div class="user-avatar">{{ $user->initials }}</div>
                <div class="user-info">
                    <h3>{{ $user->full_name }}</h3>
                    <p>Étudiant {{ $etudiant?->annee ?? '' }}</p>
                </div>
            </div>
        </div>
    </header>

    <main class="main-content">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
