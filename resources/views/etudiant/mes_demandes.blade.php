<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Demandes Administratives - Institut SupNum</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8eef5 100%);
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
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0;
            font-size: 1.125rem;
            font-weight: 700;
            color: #1a1a1a;
            text-decoration: none;
        }

        .nav {
            display: flex;
            gap: 32px;
            align-items: center;
        }

        .nav-link {
            text-decoration: none;
            color: #666;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 0;
            border-bottom: 2px solid transparent;
            transition: all 0.2s;
        }

        .nav-link:hover {
            color: #2196f3;
        }

        .nav-link.active {
            color: #2196f3;
            border-bottom-color: #2196f3;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        /* Page Header */
        .page-header {
            margin-bottom: 40px;
        }

        .page-header h1 {
            font-size: 32px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .page-header p {
            color: #666;
            font-size: 15px;
        }

        /* Card */
        .card {
            background: white;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            margin-bottom: 32px;
        }

        .card h2 {
            font-size: 20px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 24px;
        }

        /* Alert */
        .alert {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 24px;
            display: flex;
            gap: 12px;
        }

        .alert-icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
            fill: #2196f3;
        }

        .alert-content {
            flex: 1;
            font-size: 14px;
            color: #1565c0;
            line-height: 1.5;
        }

        .alert.success {
            background: #e8f5e9;
            border-left-color: #4caf50;
            color: #2e7d32;
        }

        /* Form */
        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .form-select,
        .form-input,
        .form-textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.2s;
            outline: none;
        }

        .form-select:focus,
        .form-input:focus,
        .form-textarea:focus {
            border-color: #2196f3;
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }

        /* Upload Area */
        .upload-area {
            border: 2px dashed #ddd;
            border-radius: 12px;
            padding: 40px;
            text-align: center;
            background: #fafbfc;
            cursor: pointer;
            transition: all 0.2s;
        }

        .upload-area:hover {
            border-color: #2196f3;
            background: #f5f9ff;
        }

        .upload-icon {
            width: 48px;
            height: 48px;
            margin: 0 auto 16px;
            fill: #999;
        }

        .upload-text {
            font-size: 14px;
            color: #666;
            margin-bottom: 4px;
        }

        .upload-hint {
            font-size: 12px;
            color: #999;
        }

        .upload-input {
            display: none;
        }

        /* Button */
        .btn-submit {
            background: #2196f3;
            color: white;
            border: none;
            padding: 12px 32px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            float: right;
        }

        .btn-submit:hover {
            background: #1976d2;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(33, 150, 243, 0.3);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-icon {
            width: 16px;
            height: 16px;
            fill: white;
        }

        /* Table Section */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .section-header h2 {
            font-size: 24px;
            font-weight: 600;
            color: #1a1a1a;
            margin: 0;
        }

        .view-history {
            color: #2196f3;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .view-history:hover {
            text-decoration: underline;
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
            background: #f8f9fa;
        }

        th {
            padding: 14px 16px;
            text-align: left;
            font-size: 12px;
            font-weight: 600;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e0e0e0;
        }

        td {
            padding: 16px;
            font-size: 14px;
            color: #333;
            border-bottom: 1px solid #f0f0f0;
        }

        tr:hover {
            background: #f8f9fa;
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-badge.completed {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .status-badge.pending {
            background: #fff3e0;
            color: #ef6c00;
        }

        .status-badge.in-progress {
            background: #e3f2fd;
            color: #1565c0;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .status-badge.completed .status-dot {
            background: #4caf50;
        }

        .status-badge.pending .status-dot {
            background: #ff9800;
        }

        .status-badge.in-progress .status-dot {
            background: #2196f3;
        }

        /* Action Buttons */
        .action-btns {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            border: none;
            background: #f5f5f5;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .action-btn:hover {
            background: #e0e0e0;
        }

        .action-btn svg {
            width: 16px;
            height: 16px;
            fill: #666;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 32px 20px;
            color: #666;
            font-size: 13px;
        }

        .footer a {
            color: #2196f3;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        /* Pagination */
        .pagination-container {
            margin-top: 24px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header {
                padding: 16px 20px;
            }

            .nav {
                gap: 16px;
            }

            .container {
                padding: 24px 16px;
            }

            .card {
                padding: 20px;
            }

            .page-header h1 {
                font-size: 24px;
            }

            table {
                font-size: 13px;
            }

            th, td {
                padding: 12px 8px;
            }
        }
    </style>
</head>
<body>
    @php
        $user = Auth::user();
        $initials = '';
        if($user && $user->full_name) {
            $parts = explode(' ', $user->full_name);
            $initials = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
        }
    @endphp

    <!-- Header -->
    <header class="header">
        <a href="{{ route('etudiant.dashboard') }}" class="logo">
            <span style="color: #16a34a;">SupNum</span><span style="color: #1d4ed8;">Portail</span>
        </a>
        <nav class="nav">
            <a href="{{ route('etudiant.dashboard') }}" class="nav-link">Dashboard</a>
            <a href="{{ route('etudiant.demandes.index') }}" class="nav-link active">Demandes</a>
            <a href="{{ route('etudiant.certificats.create') }}" class="nav-link">Certificats</a>
            <a href="{{ route('etudiant.profil') }}" class="nav-link">Profil</a>
            <div class="user-avatar" onclick="window.location='{{ route('etudiant.profil') }}'">{{ $initials }}</div>
        </nav>
    </header>

    <!-- Main Content -->
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1>Demandes Administratives</h1>
            <p>Formulaire de demande de documents officiels et suivi de vos dossiers.</p>
        </div>

        <!-- Session Status / Success Messages -->
        @if(session('success'))
            <div class="alert success" style="margin-bottom: 24px;">
                <svg class="alert-icon" viewBox="0 0 24 24">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                </svg>
                <div class="alert-content">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert" style="background: #ffebee; border-left-color: #f44336; color: #c62828;">
                <svg class="alert-icon" style="fill: #f44336" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                </svg>
                <div class="alert-content">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <!-- New Request Form -->
        <div class="card">
            <h2>Nouvelle Demande</h2>

            <div class="alert">
                <svg class="alert-icon" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                </svg>
                <div class="alert-content">
                    Veuillez sélectionner le type de document requis. Pour une justification d'absence, veuillez joindre votre <strong>certificat médical</strong> au format PDF uniquement. Les délais de traitement varient de <strong>48h à 72h ouvrables</strong>.
                </div>
            </div>

            <form action="{{ route('etudiant.demandes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label class="form-label">Type de document</label>
                    <select name="document_id" class="form-select @error('document_id') border-red-500 @enderror" required>
                        <option value="">Choisir un document...</option>
                        @foreach($documents as $doc)
                            <option value="{{ $doc->id }}" {{ old('document_id') == $doc->id ? 'selected' : '' }}>
                                {{ $doc->nom_document }}
                            </option>
                        @endforeach
                    </select>
                    @error('document_id')
                        <p style="color: #f44336; font-size: 12px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    

                <div class="form-group">
                    <label class="form-label">Commentaires supplémentaires</label>
                    <textarea name="commentaire" class="form-textarea @error('commentaire') border-red-500 @enderror" placeholder="Précisez l'année académique ou le motif de la demande...">{{ old('commentaire') }}</textarea>
                    @error('commentaire')
                        <p style="color: #f44336; font-size: 12px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">
                    <svg class="btn-icon" viewBox="0 0 24 24">
                        <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                    </svg>
                    <span>Soumettre la demande</span>
                </button>
                <div style="clear: both;"></div>
            </form>
        </div>

        <!-- Requests History -->
        <div class="card">
            <div class="section-header">
                <h2>Suivi de vos demandes</h2>
                @if($demandes->count() > 5)
                    <a href="#" class="view-history">
                        Voir l'historique complet
                        <svg style="width: 16px; height: 16px; fill: currentColor;" viewBox="0 0 24 24">
                            <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/>
                        </svg>
                    </a>
                @endif
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Date de demande</th>
                            <th>Type de document</th>
                            <th>Observations Admin</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($demandes as $demande)
                            <tr>
                                <td>{{ $demande->created_at ? $demande->created_at->format('d M Y') : '-' }}</td>
                                <td>{{ $demande->document->nom_document }}</td>
                                <td>
                                    @if($demande->remarque_admin)
                                        <span title="{{ $demande->remarque_admin }}">{{ Str::limit($demande->remarque_admin, 30) }}</span>
                                    @else
                                        <span style="color: #999; font-style: italic; font-size: 12px;">Aucune observation</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $statusClass = 'pending';
                                        $statusLabel = 'En attente';
                                        $val = strtoupper($demande->statut);
                                        
                                        if($val === 'FIN' || $val === 'ACCEPTEE') {
                                            $statusClass = 'completed';
                                            $statusLabel = 'Fini / Acceptée';
                                        } elseif($val === 'EN_COURS_TRAITEMENT') {
                                            $statusClass = 'in-progress';
                                            $statusLabel = 'En cours';
                                        } elseif($val === 'REJETEE') {
                                            $statusClass = 'pending';
                                            $statusLabel = 'Rejetée';
                                        }
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}" @if($statusLabel === 'Rejetée') style="background: #ffebee; color: #c62828;" @endif>
                                        <span class="status-dot" @if($statusLabel === 'Rejetée') style="background: #f44336;" @endif></span>
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <button class="action-btn" title="Voir détails">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: #999; padding: 40px;">
                                    Vous n'avez soumis aucune demande pour le moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($demandes->hasPages())
                <div class="pagination-container">
                    {{ $demandes->links() }}
                </div>
            @endif
        </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        © 2024 Institut SupNum. Tous droits réservés. Besoin d'aide ? Contactez 
        <a href="mailto:support@supnum.edu">support@supnum.edu</a>
    </footer>

    <script>
        // File upload preview
        const fileInput = document.getElementById('file-upload');
        const uploadArea = document.querySelector('.upload-area');
        const uploadText = document.getElementById('upload-feedback');

        fileInput.addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            if (fileName) {
                uploadText.textContent = fileName;
                uploadArea.style.borderColor = '#4caf50';
                uploadArea.style.background = '#f1f8f4';
            }
        });

        // Drag and drop
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.style.borderColor = '#2196f3';
            this.style.background = '#f5f9ff';
        });

        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.style.borderColor = '#ddd';
            this.style.background = '#fafbfc';
        });

        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.style.borderColor = '#ddd';
            this.style.background = '#fafbfc';
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                const event = new Event('change');
                fileInput.dispatchEvent(event);
            }
        });
    </script>
</body>
</html>

