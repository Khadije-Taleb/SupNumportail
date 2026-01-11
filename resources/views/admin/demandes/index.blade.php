<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Demandes - SupNumPortail</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f8f9fa;
            color: #1e293b;
        }

        /* Header */
        .header {
            background-color: white;
            border-bottom: 1px solid #e2e8f0;
            border-top: 3px solid #2563eb;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 3rem;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            font-size: 1rem;
            color: #1e293b;
            text-decoration: none;
        }

        .logo-icon {
            width: 24px;
            height: 24px;
            background-color: #2563eb;
            border-radius: 0.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .nav {
            display: flex;
            gap: 2rem;
        }

        .nav a {
            text-decoration: none;
            color: #64748b;
            font-size: 0.9375rem;
            transition: color 0.2s;
            padding-bottom: 0.5rem;
        }

        .nav a:hover {
            color: #1e293b;
        }

        .nav a.active {
            color: #2563eb;
            border-bottom: 2px solid #2563eb;
            font-weight: 500;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #64748b;
            font-size: 0.875rem;
        }

        /* Main Container */
        .main-container {
            display: flex;
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
            gap: 2rem;
        }

        /* Left Panel */
        .left-panel {
            flex: 1;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-header h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.5rem;
        }

        .page-description {
            color: #64748b;
            font-size: 0.9375rem;
        }

        /* Table */
        .table-container {
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }

        th {
            padding: 1rem;
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
            cursor: pointer;
        }

        tbody tr:hover {
            background-color: #f8fafc;
        }

        tbody tr.active {
            background-color: #eff6ff;
            border-left: 3px solid #2563eb;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        td {
            padding: 1rem;
            font-size: 0.9375rem;
        }

        .student-name {
            font-weight: 500;
            color: #0f172a;
            margin-bottom: 0.25rem;
        }

        .student-id {
            font-size: 0.8125rem;
            color: #94a3b8;
        }

        .status-badge {
            display: inline-block;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.8125rem;
            font-weight: 500;
        }

        .status-en_attente { background-color: #fef3c7; color: #92400e; }
        .status-en_cours_traitement { background-color: #dbeafe; color: #1e40af; }
        .status-fin { background-color: #d1fae5; color: #065f46; }
        .status-rejetee { background-color: #fee2e2; color: #991b1b; }

        .action-link {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        /* Right Panel - Sidebar */
        .right-panel {
            width: 450px;
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            height: fit-content;
            position: sticky;
            top: 2rem;
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .panel-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #0f172a;
        }

        .detail-group {
            margin-bottom: 1.25rem;
        }

        .detail-label {
            font-size: 0.75rem;
            color: #64748b;
            font-weight: 600;
            margin-bottom: 0.25rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-value {
            font-size: 0.9375rem;
            color: #0f172a;
            font-weight: 500;
        }

        /* Action Buttons */
        .action-buttons {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }

        .btn {
            padding: 0.875rem 1rem;
            border: none;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
            text-decoration: none;
            width: 100%;
        }

        .btn-reject { background-color: #dc2626; color: white; }
        .btn-reject:hover { background-color: #b91c1c; }
        .btn-process { background-color: #2563eb; color: white; }
        .btn-process:hover { background-color: #1d4ed8; }
        .btn-finish { background-color: #16a34a; color: white; }
        .btn-finish:hover { background-color: #15803d; }

        textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            font-family: inherit;
            font-size: 0.9375rem;
            resize: vertical;
            min-height: 80px;
            margin-bottom: 1rem;
        }

        .placeholder-panel {
            text-align: center;
            padding: 4rem 2rem;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-left">
            <a href="{{ route('admin.dashboard') }}" class="logo">
                <div class="logo-icon">SN</div>
                <span>SupNumPortail</span>
            </a>
            <nav class="nav">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a href="{{ route('admin.etudiants.import') }}">Importation</a>
                <a href="{{ route('admin.certificats.index') }}">Certificats</a>
                <a href="{{ route('admin.demandes.index') }}" class="active">Demandes</a>
            </nav>
        </div>
        <div class="user-menu">
            <span>👤</span>
            <span>{{ Auth::user()->nom ?? 'Admin' }}</span>
            <form method="POST" action="{{ route('logout') }}" style="margin-left: 1rem;">
                @csrf
                <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 0.8125rem; font-weight: 600;">Déconnexion</button>
            </form>
        </div>
    </header>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Left Panel -->
        <div class="left-panel">
            <div class="page-header">
                <h1>Gestion des Demandes</h1>
                <p class="page-description">Traitez les demandes de documents administratifs des étudiants.</p>
                
                <form action="{{ route('admin.demandes.index') }}" method="GET" style="margin-top: 1.5rem; display: flex; gap: 1rem; align-items: center;">
                    <select name="statut" style="padding: 0.5rem; border: 1px solid #e2e8f0; border-radius: 0.375rem; background: white; font-size: 0.875rem;">
                        <option value="">Tous les statuts</option>
                        <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="en_cours_traitement" {{ request('statut') == 'en_cours_traitement' ? 'selected' : '' }}>En cours</option>
                        <option value="fin" {{ request('statut') == 'fin' ? 'selected' : '' }}>Terminé</option>
                        <option value="rejetee" {{ request('statut') == 'rejetee' ? 'selected' : '' }}>Rejetée</option>
                    </select>
                    <button type="submit" style="padding: 0.5rem 1rem; background: #2563eb; color: white; border: none; border-radius: 0.375rem; font-size: 0.875rem; cursor: pointer; font-weight: 500;">Filtrer</button>
                </form>
            </div>

            @if(session('success'))
                <div style="background-color: #d1fae5; color: #065f46; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem; border: 1px solid #6ee7b7;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ÉTUDIANT</th>
                            <th>DOCUMENT</th>
                            <th>DATE</th>
                            <th>STATUT</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $selectedId = $demande->id ?? null; @endphp
                        @forelse($demandes as $dem)
                            <tr onclick="window.location='{{ route('admin.demandes.show', $dem->id) }}'" class="{{ $selectedId == $dem->id ? 'active' : '' }}">
                                <td>
                                    <div class="student-name">{{ $dem->etudiant->prenom ?? '' }} {{ $dem->etudiant->nom ?? '' }}</div>
                                    <div class="student-id">{{ $dem->etudiant->matricule ?? '' }}</div>
                                </td>
                                <td>{{ $dem->document->nom_document ?? 'N/A' }}</td>
                                <td>{{ $dem->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <span class="status-badge status-{{ $dem->statut }}">
                                        {{ str_replace('_', ' ', $dem->statut) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.demandes.show', $dem->id) }}" class="action-link">Voir</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: #94a3b8; padding: 2rem;">Aucune demande trouvée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div style="padding: 1rem;">
                    {{ $demandes->links() }}
                </div>
            </div>
        </div>

        <!-- Right Panel -->
        <div class="right-panel">
            @if(isset($demande))
                <div class="panel-header">
                    <h3 class="panel-title">Traitement de la Demande</h3>
                </div>

                <div class="detail-group">
                    <div class="detail-label">Étudiant</div>
                    <div class="detail-value">{{ $demande->etudiant->prenom ?? '' }} {{ $demande->etudiant->nom ?? '' }}</div>
                </div>

                <div class="detail-group">
                    <div class="detail-label">Document Demandé</div>
                    <div class="detail-value" style="font-size: 1.125rem; color: #2563eb; font-weight: 700;">{{ $demande->document->nom_document ?? 'N/A' }}</div>
                </div>

                <div class="detail-group">
                    <div class="detail-label">Filière / Année</div>
                    <div class="detail-value">{{ $demande->etudiant->filiere ?? 'N/A' }} / {{ $demande->etudiant->annee ?? 'N/A' }}</div>
                </div>

                <form action="{{ route('admin.demandes.updateStatus', $demande->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="remarque-section">
                        <div class="detail-label">REMARQUE ADMINISTRATIVE</div>
                        <textarea name="remarque_admin" placeholder="Ajoutez un commentaire ou motif de rejet...">{{ $demande->remarque_admin }}</textarea>
                    </div>

                    <div class="action-buttons">
                        @if($demande->statut === 'en_attente')
                            <button type="submit" name="statut" value="en_cours_traitement" class="btn btn-process">Mettre en cours</button>
                            <button type="submit" name="statut" value="rejetee" class="btn btn-reject" style="margin-top: 0.5rem;">Rejeter la demande</button>
                        @elseif($demande->statut === 'en_cours_traitement')
                            <button type="submit" name="statut" value="fin" class="btn btn-finish">Terminer (Prêt au retrait)</button>
                            <button type="submit" name="statut" value="rejetee" class="btn btn-reject" style="margin-top: 0.5rem;">Rejeter finalement</button>
                        @else
                            <div style="text-align: center; padding: 1.5rem; background: #f8fafc; border-radius: 0.75rem; font-weight: bold; color: #64748b; border: 1px dashed #cbd5e1;">
                                Dossier Classé ({{ str_replace('_', ' ', $demande->statut) }})
                            </div>
                        @endif
                    </div>
                </form>
            @else
                <div class="placeholder-panel">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">📁</div>
                    <h3>Sélectionnez une demande</h3>
                    <p>Choisissez une demande dans la liste pour commencer le traitement.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        © {{ date('Y') }} SupNumPortail - Service Scolarité
    </div>
</body>
</html>
