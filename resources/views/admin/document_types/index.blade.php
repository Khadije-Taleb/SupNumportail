<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Types de Documents - SupNumPortail</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background-color: #f8f9fa; color: #1e293b; }
        .header { background-color: white; border-bottom: 1px solid #e2e8f0; padding: 0 2rem; height: 64px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); margin-bottom: 2rem; }
        .header-left { display: flex; align-items: center; gap: 3rem; }
        .logo { display: flex; align-items: center; gap: 0; font-weight: 700; font-size: 1.25rem; color: #1e293b; text-decoration: none; }
        .nav { display: flex; gap: 2rem; }
        .nav-link { text-decoration: none; color: #64748b; font-size: 0.9375rem; font-weight: 500; transition: color 0.2s; height: 64px; display: flex; align-items: center; border-bottom: 2px solid transparent; }
        .nav-link:hover { color: #1e293b; }
        .nav-link.active { color: #2563eb; border-bottom-color: #2563eb; }
        .header-right { display: flex; align-items: center; gap: 2rem; }
        .user-menu { display: flex; align-items: center; gap: 0.5rem; color: #64748b; }
        .user-icon { color: #4c1d95; display: flex; align-items: center; }
        .logout-btn { color: #ef4444; font-weight: 600; font-size: 0.9375rem; text-decoration: none; background: none; border: none; cursor: pointer; padding: 0; font-family: inherit; }
        .container { max-width: 1200px; margin: 2rem auto; padding: 0 2rem; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .btn { padding: 0.6rem 1.2rem; border-radius: 0.5rem; font-weight: 600; cursor: pointer; text-decoration: none; border: none; font-size: 0.9rem; transition: 0.2s; }
        .btn-primary { background-color: #2563eb; color: white; }
        .btn-primary:hover { background-color: #1d4ed8; }
        .card { background: white; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f8fafc; padding: 1rem; text-align: left; font-size: 0.75rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #e2e8f0; }
        td { padding: 1rem; border-bottom: 1px solid #e2e8f0; font-size: 0.9rem; }
        .status-badge { padding: 0.3rem 0.6rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; }
        .status-active { background: #dcfce7; color: #166534; }
        .status-inactive { background: #fee2e2; color: #991b1b; }
        .actions { display: flex; gap: 0.5rem; }
        .alert { padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; }
        .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
    </style>
</head>
<body>
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

    <div class="container">
        <div class="page-header">
            <div>
                <h1 style="font-size: 1.8rem; font-weight: 700;">Gestion des Types de Documents</h1>
                <p style="color: #64748b; margin-top: 0.25rem;">Gérez les types de documents que les étudiants peuvent demander.</p>
            </div>
            <a href="{{ route('admin.document-types.create') }}" class="btn btn-primary">+ Ajouter un type</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>NOM DU DOCUMENT</th>
                        <th>DESCRIPTION</th>
                        <th>STATUT</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $document)
                        <tr>
                            <td style="font-weight: 600;">{{ $document->nom_document }}</td>
                            <td style="color: #64748b;">{{ $document->description ?? '-' }}</td>
                            <td>
                                <span class="status-badge {{ $document->actif ? 'status-active' : 'status-inactive' }}">
                                    {{ $document->actif ? 'Actif' : 'Désactivé' }}
                                </span>
                            </td>
                            <td class="actions">
                                <a href="{{ route('admin.document-types.edit', $document) }}" class="btn" style="background: #f1f5f9; color: #475569;">Modifier</a>
                                
                                <form action="{{ route('admin.document-types.toggle', $document) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn" style="background: {{ $document->actif ? '#fff1f2' : '#f0fdf4' }}; color: {{ $document->actif ? '#e11d48' : '#16a34a' }};">
                                        {{ $document->actif ? 'Désactiver' : 'Activer' }}
                                    </button>
                                </form>

                                <form action="{{ route('admin.document-types.destroy', $document) }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce type de document ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn" style="background: #fee2e2; color: #dc2626;">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 3rem; color: #94a3b8;">Aucun type de document défini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="margin-top: 1rem;">
            {{ $documents->links() }}
        </div>
    </div>
</body>
</html>
