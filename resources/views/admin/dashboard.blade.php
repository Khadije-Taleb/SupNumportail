<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SupNumPortail - Tableau de Bord Admin</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f5f7fa;
            color: #1e293b;
        }

        /* Header Standard */
        .header {
            background-color: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 0 2rem;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 3rem;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0;
            font-weight: 700;
            font-size: 1.25rem;
            color: #1e293b;
            text-decoration: none;
        }

        .nav {
            display: flex;
            gap: 2rem;
        }

        .nav-link {
            text-decoration: none;
            color: #64748b;
            font-size: 0.9375rem;
            font-weight: 500;
            transition: color 0.2s;
            height: 64px;
            display: flex;
            align-items: center;
            border-bottom: 2px solid transparent;
        }

        .nav-link:hover {
            color: #1e293b;
        }

        .nav-link.active {
            color: #2563eb;
            border-bottom-color: #2563eb;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #64748b;
        }

        .user-icon {
            color: #4c1d95;
            display: flex;
            align-items: center;
        }

        .logout-btn {
            color: #ef4444;
            font-weight: 600;
            font-size: 0.9375rem;
            text-decoration: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            font-family: inherit;
        }


        /* Main Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Page Header */
        .page-header {
            background-color: white;
            border-radius: 0.75rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .page-header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .page-title h1 {
            font-size: 1.875rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .page-description {
            color: #64748b;
            font-size: 0.9375rem;
            line-height: 1.5;
        }

        .import-btn {
            background-color: #2563eb;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 8px;
            font-size: 0.9375rem;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: background-color 0.15s ease-in-out;
            text-decoration: none;
        }

        .import-btn:hover {
            background-color: #16a34a;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background-color: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            position: relative;
            border-left: 4px solid;
        }

        .stat-card.attente {
            border-left-color: #3b82f6;
        }

        .stat-card.encours {
            border-left-color: #06b6d4;
        }

        .stat-card.traitees {
            border-left-color: #10b981;
        }

        .stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .stat-label {
            color: #64748b;
            font-size: 0.875rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-icon {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .stat-card.attente .stat-icon {
            background-color: #dbeafe;
            color: #3b82f6;
        }

        .stat-card.encours .stat-icon {
            background-color: #cffafe;
            color: #06b6d4;
        }

        .stat-card.traitees .stat-icon {
            background-color: #d1fae5;
            color: #10b981;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.25rem;
        }

        .stat-change {
            font-size: 0.875rem;
            color: #64748b;
        }

        .stat-change.positive {
            color: #10b981;
        }

        /* Demandes Section */
        .demandes-section {
            background-color: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e293b;
        }

        .view-all {
            color: #3b82f6;
            text-decoration: none;
            font-size: 0.9375rem;
            font-weight: 500;
            transition: color 0.2s;
        }

        .view-all:hover {
            color: #2563eb;
        }

        /* Table */
        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: #f8fafc;
            border-radius: 0.5rem;
        }

        th {
            padding: 0.75rem 1rem;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tbody tr {
            border-bottom: 1px solid #e2e8f0;
            transition: background-color 0.2s;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody tr:hover {
            background-color: #f8fafc;
        }

        td {
            padding: 1rem;
        }

        .student-name {
            font-weight: 500;
            color: #1e293b;
            margin-bottom: 0.25rem;
        }

        .student-id {
            font-size: 0.8125rem;
            color: #94a3b8;
        }

        .demande-type {
            color: #64748b;
            font-size: 0.9375rem;
        }

        .status-badge {
            display: inline-block;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.8125rem;
            font-weight: 500;
        }

        .status-attente, .status-en_attente, .status-EN_ATTENTE {
            background-color: #f1f5f9;
            color: #475569;
        }

        .status-encours, .status-en_cours_traitement {
            background-color: #cffafe;
            color: #0891b2;
        }

        .status-traitee, .status-fin, .status-VALIDE {
            background-color: #d1fae5;
            color: #059669;
        }

        .status-rejetee, .status-REFUSE {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        .date-cell {
            color: #64748b;
            font-size: 0.9375rem;
        }

        .action-btn {
            color: #3b82f6;
            text-decoration: none;
            font-size: 0.9375rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.375rem;
            cursor: pointer;
            transition: color 0.2s;
        }

        .action-btn:hover {
            color: #2563eb;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 2rem;
            color: #94a3b8;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <!-- Header -->
    <header class="header">
        <div class="header-left">
            <a href="{{ route('admin.dashboard') }}" class="logo">
                <span style="color: #16a34a;">SupNum</span><span style="color: #1d4ed8;">Portail</span>
            </a>
            <nav class="nav">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('admin.document-types.index') }}" class="nav-link {{ request()->routeIs('admin.document-types.*') ? 'active' : '' }}">Documents</a>
                <a href="{{ route('admin.etudiants.import') }}" class="nav-link {{ request()->routeIs('admin.etudiants.import') ? 'active' : '' }}">Importation</a>
                <a href="{{ route('admin.certificats.index') }}" class="nav-link {{ request()->routeIs('admin.certificats.*') ? 'active' : '' }}">Certificats</a>
                <a href="{{ route('admin.demandes.index') }}" class="nav-link {{ request()->routeIs('admin.demandes.*') ? 'active' : '' }}">Demandes</a>
            </nav>
        </div>
        <div class="header-right">
            <div class="user-menu">
                <div class="user-icon">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <span>Admin</span>
            </div>
            
            <form method="POST" action="{{ route('logout') }}" style="margin: 0; display: flex;">
                @csrf
                <button type="submit" class="logout-btn">
                    Déconnexion
                </button>
            </form>
        </div>
    </header>

    <!-- Main Container -->
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-top">
                <div class="page-title">
                    <h1>Gestion des demandes et du portail</h1>
                    <p class="page-description">
                        Supervisez les inscriptions, validez les certificats et gérez les flux académiques. Accédez<br>
                        aux outils de gestion centralisée des étudiants.
                    </p>
                </div>
                <a href="{{ route('admin.etudiants.import') }}" class="import-btn">
                    <span>📤</span>
                    <span>Importer des étudiants</span>
                </a>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card attente">
                <div class="stat-header">
                    <span class="stat-label">En attente</span>
                    <div class="stat-icon">📋</div>
                </div>
                <div class="stat-value">{{ $stats['pending'] }}</div>
                <div class="stat-change positive">Action requise</div>
            </div>

            <div class="stat-card encours">
                <div class="stat-header">
                    <span class="stat-label">En cours</span>
                    <div class="stat-icon">💬</div>
                </div>
                <div class="stat-value">{{ $stats['in_progress'] }}</div>
                <div class="stat-change">Dossiers ouverts</div>
            </div>

            <div class="stat-card traitees">
                <div class="stat-header">
                    <span class="stat-label">Traitées ce mois</span>
                    <div class="stat-icon">✅</div>
                </div>
                <div class="stat-value">{{ $stats['completed_month'] }}</div>
                <div class="stat-change positive">Mois de {{ now()->translatedFormat('F') }}</div>
            </div>
        </div>

        <!-- Demandes Section -->
        <div class="demandes-section">
            <div class="section-header">
                <h2 class="section-title">Activités récentes</h2>
                <div class="flex gap-4">
                    <a href="{{ route('admin.demandes.index') }}" class="view-all">Voir documents</a>
                    <span class="text-gray-300">|</span>
                    <a href="{{ route('admin.certificats.index') }}" class="view-all">Voir certificats</a>
                </div>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ÉTUDIANT</th>
                            <th>TYPE DE DEMANDE</th>
                            <th>STATUT</th>
                            <th>DATE</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($demandes as $demande)
                            <tr>
                                <td>
                                    <div class="student-name">{{ $demande->etudiant?->prenom ?? '' }} {{ $demande->etudiant?->nom ?? 'Étudiant Inconnu' }}</div>
                                    <div class="student-id">{{ $demande->etudiant?->matricule ?? $demande->matricule_etudiant }}</div>
                                </td>
                                <td>
                                    <div class="demande-type">
                                        @if($is_certificat)
                                            Certificat Médical ({{ $demande->matiere }})
                                        @else
                                            {{ $demande->document->nom_document ?? 'Autre' }}
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge status-{{ $demande->statut }}">
                                        {{ strtoupper(str_replace('_', ' ', $demande->statut)) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="date-cell">{{ $demande->created_at ? $demande->created_at->format('d M Y') : '-' }}</div>
                                </td>
                                <td>
                                    <a href="{{ $is_certificat ? route('admin.certificats.show', $demande->id) : route('admin.demandes.show', $demande) }}" class="action-btn">
                                        <span>Gérer</span>
                                        <span>👁</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: #94a3b8; padding: 2rem;">Aucune demande récente.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        © {{ date('Y') }} SupNumPortail Admin. Système de gestion académique
    </div>
</body>
</html>
