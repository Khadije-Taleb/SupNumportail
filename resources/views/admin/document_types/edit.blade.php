<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Type de Document - SupNumPortail</title>
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
        .container { max-width: 600px; margin: 3rem auto; padding: 0 2rem; }
        .card { background: white; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 2rem; }
        .form-group { margin-bottom: 1.5rem; }
        label { display: block; font-size: 0.85rem; font-weight: 600; color: #475569; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; }
        input, textarea { width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.95rem; }
        input:focus, textarea:focus { outline: none; border-color: #2563eb; ring: 3px rgba(37,99,235,0.1); }
        .btn { padding: 0.75rem 1.5rem; border-radius: 0.5rem; font-weight: 600; cursor: pointer; border: none; font-size: 0.95rem; width: 100%; transition: 0.2s; }
        .btn-primary { background-color: #2563eb; color: white; }
        .btn-primary:hover { background-color: #1d4ed8; }
        .btn-secondary { background-color: #f1f5f9; color: #475569; display: block; text-align: center; text-decoration: none; margin-top: 1rem; }
        .error { color: #dc2626; font-size: 0.8rem; margin-top: 0.25rem; }
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
        <div style="margin-bottom: 2rem;">
            <h1 style="font-size: 1.5rem; font-weight: 700;">Modifier le Type de Document</h1>
            <p style="color: #64748b;">Mettez à jour les informations du document.</p>
        </div>

        <div class="card">
            <form action="{{ route('admin.document-types.update', $document) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nom_document">Nom du Document</label>
                    <input type="text" name="nom_document" id="nom_document" value="{{ old('nom_document', $document->nom_document) }}" required>
                    @error('nom_document') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="description">Description (Optionnel)</label>
                    <textarea name="description" id="description" rows="3">{{ old('description', $document->description) }}</textarea>
                    @error('description') <div class="error">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-primary">Mettre à jour le Type</button>
                <a href="{{ route('admin.document-types.index') }}" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
</body>
</html>
