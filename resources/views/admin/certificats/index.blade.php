<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validation des Certificats Médicaux - SupNumPortail</title>
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

        .status-EN_ATTENTE {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-EN_COURS {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .status-VALIDE {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-REFUSE {
            background-color: #fee2e2;
            color: #991b1b;
        }

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

        /* Document Preview */
        .document-preview {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            border-radius: 0.75rem;
            padding: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 250px;
            margin-bottom: 1rem;
            border: 1px solid #e2e8f0;
        }

        .document-preview img {
            max-width: 100%;
            max-height: 400px;
            border-radius: 0.25rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .document-preview iframe {
            width: 100%;
            height: 400px;
            border: none;
        }

        /* Remarque */
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

        /* Action Buttons */
        .action-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
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
        }

        .btn-reject { background-color: #dc2626; color: white; }
        .btn-reject:hover { background-color: #b91c1c; }
        .btn-accept { background-color: #16a34a; color: white; }
        .btn-accept:hover { background-color: #15803d; }

        .placeholder-panel {
            text-align: center;
            padding: 4rem 2rem;
            color: #94a3b8;
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
    <div class="main-container">
        <!-- Left Panel -->
        <div class="left-panel">
            <div class="page-header">
                <h1>Validation des Certificats Médicaux</h1>
                <p class="page-description">Passez en revue et traitez les justificatifs d'absence soumis par les étudiants.</p>
                
                <form action="{{ route('admin.certificats.index') }}" method="GET" style="margin-top: 1.5rem; display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
                    <select name="statut" style="padding: 0.5rem; border: 1px solid #e2e8f0; border-radius: 0.375rem; background: white; font-size: 0.875rem;">
                        <option value="">Tous les statuts</option>
                        <option value="EN_ATTENTE" {{ request('statut') == 'EN_ATTENTE' ? 'selected' : '' }}>En attente</option>
                        <option value="VALIDE" {{ request('statut') == 'VALIDE' ? 'selected' : '' }}>Accepté</option>
                        <option value="REFUSE" {{ request('statut') == 'REFUSE' ? 'selected' : '' }}>Refusé</option>
                    </select>
                    
                    <select name="matiere" style="padding: 0.5rem; border: 1px solid #e2e8f0; border-radius: 0.375rem; background: white; font-size: 0.875rem;">
                        <option value="">Toutes les matières</option>
                        @foreach($matieres ?? [] as $matiere)
                            <option value="{{ $matiere }}" {{ request('matiere') == $matiere ? 'selected' : '' }}>{{ $matiere }}</option>
                        @endforeach
                    </select>
                    
                    <select name="type_evaluation" style="padding: 0.5rem; border: 1px solid #e2e8f0; border-radius: 0.375rem; background: white; font-size: 0.875rem;">
                        <option value="">Tous les types</option>
                        @foreach($typesEvaluation ?? [] as $type)
                            <option value="{{ $type }}" {{ request('type_evaluation') == $type ? 'selected' : '' }}>{{ str_replace('_', ' ', ucfirst($type)) }}</option>
                        @endforeach
                    </select>
                    
                    <button type="submit" style="padding: 0.5rem 1rem; background: #2563eb; color: white; border: none; border-radius: 0.375rem; font-size: 0.875rem; cursor: pointer; font-weight: 500;">Filtrer</button>
                    @if(request('statut') || request('matiere') || request('type_evaluation'))
                        <a href="{{ route('admin.certificats.index') }}" style="font-size: 0.875rem; color: #64748b; text-decoration: none;">Réinitialiser</a>
                    @endif
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
                            <th>DATE D'ABSENCE</th>
                            <th>MATIÈRE</th>
                            <th>STATUT</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $selectedId = $certificat->id ?? null;
                        @endphp
                        @forelse($certificats as $cert)
                            <tr onclick="window.location='{{ route('admin.certificats.show', $cert->id) }}'" class="{{ $selectedId == $cert->id ? 'active' : '' }}">
                                <td>
                                    <div class="student-name">{{ $cert->etudiant->prenom ?? '' }} {{ $cert->etudiant->nom ?? '' }}</div>
                                    <div class="student-id">{{ $cert->etudiant->matricule ?? '' }}</div>
                                </td>
                                <td>{{ $cert->date_absence ? $cert->date_absence->format('d M Y') : 'N/A' }}</td>
                                <td>
                                    <div style="font-weight: 500;">{{ $cert->evaluation->nom_matiere ?? 'N/A' }}</div>
                                    <div style="font-size: 0.75rem; color: #64748b;">{{ str_replace('_', ' ', ucfirst($cert->evaluation->type_evaluation ?? '')) }}</div>
                                </td>
                                <td>
                                    <span class="status-badge status-{{ $cert->statut }}">
                                        {{ $cert->statut }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.certificats.show', $cert->id) }}" class="action-link">Voir</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: #94a3b8; padding: 2rem;">Aucun certificat trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div style="padding: 1rem;">
                    {{ $certificats->links() }}
                </div>
            </div>
        </div>

        <!-- Right Panel -->
        <div class="right-panel">
            @if(isset($certificat))
                <div class="panel-header">
                    <h3 class="panel-title">Détails du Certificat</h3>
                </div>

                <div class="detail-group">
                    <div class="detail-label">Étudiant</div>
                    <div class="detail-value">{{ $certificat->etudiant->prenom ?? '' }} {{ $certificat->etudiant->nom ?? '' }}</div>
                </div>

                <div class="detail-group">
                    <div class="detail-label">Matricule</div>
                    <div class="detail-value">{{ $certificat->etudiant->matricule ?? 'N/A' }}</div>
                </div>

                <div class="detail-group">
                    <div class="detail-label">Date d'absence</div>
                    <div class="detail-value">{{ $certificat->date_absence ? $certificat->date_absence->format('d F Y') : 'N/A' }}</div>
                </div>

                <div class="detail-group">
                    <div class="detail-label">Matière</div>
                    <div class="detail-value">{{ $certificat->evaluation->nom_matiere ?? 'N/A' }}</div>
                </div>

                <div class="detail-group">
                    <div class="detail-label">Type d'évaluation</div>
                    <div class="detail-value">{{ str_replace('_', ' ', ucfirst($certificat->evaluation->type_evaluation ?? 'N/A')) }}</div>
                </div>

                <div class="detail-label">APERÇU DU DOCUMENT</div>
                <div class="document-preview">
                    @php
                        $extension = pathinfo($certificat->photo_certificat, PATHINFO_EXTENSION);
                        $isPdf = strtolower($extension) === 'pdf';
                    @endphp

                    @if($isPdf)
                        <iframe src="{{ route('admin.certificats.viewFile', $certificat) }}"></iframe>
                    @else
                        <img src="{{ route('admin.certificats.viewFile', $certificat) }}" alt="Certificat">
                    @endif
                </div>

                <form action="{{ route('admin.certificats.updateStatus', $certificat) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="remarque-section">
                        <div class="detail-label">REMARQUE ADMINISTRATIVE</div>
                        <textarea name="remarque_admin" placeholder="Justifiez votre décision ici...">{{ $certificat->remarque_admin }}</textarea>
                    </div>

                    <div class="action-buttons">
                        @if($certificat->statut === 'EN_ATTENTE')
                            <button type="submit" name="statut" value="REFUSE" class="btn btn-reject">Rejeter</button>
                            <button type="submit" name="statut" value="VALIDE" class="btn btn-accept">Accepter</button>
                        @else
                            <div style="grid-column: span 2; text-align: center; padding: 1rem; background: #f8fafc; border-radius: 0.5rem; font-weight: bold;">
                                Déjà traité ({{ $certificat->statut }})
                            </div>
                        @endif
                    </div>
                </form>
            @else
                <div class="placeholder-panel">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">📄</div>
                    <h3>Sélectionnez un certificat</h3>
                    <p>Cliquez sur un certificat dans la liste pour voir les détails et le traiter.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        © {{ date('Y') }} SupNumPortail - Administration des Certificats Médicaux
    </div>
</body>
</html>
