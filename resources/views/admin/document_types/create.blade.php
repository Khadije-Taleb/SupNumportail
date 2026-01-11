<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Type de Document - SupNumPortail</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background-color: #f8f9fa; color: #1e293b; }
        .header { background-color: white; border-bottom: 3px solid #3b82f6; padding: 1rem 2rem; display: flex; align-items: center; justify-content: space-between; }
        .logo { display: flex; align-items: center; gap: 0; font-weight: 700; font-size: 1.125rem; text-decoration: none; }
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
    <header class="header">
        <a href="{{ route('admin.dashboard') }}" class="logo">
            <span style="color: #16a34a;">SupNum</span><span style="color: #1d4ed8;">Portail</span>
        </a>
    </header>

    <div class="container">
        <div style="margin-bottom: 2rem;">
            <h1 style="font-size: 1.5rem; font-weight: 700;">Nouveau Type de Document</h1>
            <p style="color: #64748b;">Définissez un nouveau document que les étudiants pourront commander.</p>
        </div>

        <div class="card">
            <form action="{{ route('admin.document-types.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nom_document">Nom du Document</label>
                    <input type="text" name="nom_document" id="nom_document" value="{{ old('nom_document') }}" placeholder="ex: Certificat de Scolarité" required>
                    @error('nom_document') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="description">Description (Optionnel)</label>
                    <textarea name="description" id="description" rows="3" placeholder="Description courte du document...">{{ old('description') }}</textarea>
                    @error('description') <div class="error">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-primary">Créer le Type de Document</button>
                <a href="{{ route('admin.document-types.index') }}" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
</body>
</html>
