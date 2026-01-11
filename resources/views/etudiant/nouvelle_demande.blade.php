<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nouvelle Demande - Institut SupNum</title>
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
            max-width: 800px;
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

        .btn-icon {
            width: 16px;
            height: 16px;
            fill: white;
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

        /* Responsive */
        @media (max-width: 768px) {
            .header {
                padding: 16px 20px;
            }
            .container {
                padding: 24px 16px;
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

    <div class="container">
        <div class="page-header">
            <h1>Nouvelle Demande Administrative</h1>
            <p>Sélectionnez le document que vous souhaitez obtenir auprès de l'administration.</p>
        </div>

        <div class="card">
            <form action="{{ route('etudiant.demandes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">Type de document</label>
                    <select name="document_id" class="form-select @error('document_id') border-red-500 @enderror" required>
                        <option value="">Choisir un document...</option>
                        @foreach($documents as $document)
                            <option value="{{ $document->id }}" {{ old('document_id') == $document->id ? 'selected' : '' }}>
                                {{ $document->nom_document }}
                            </option>
                        @endforeach
                    </select>
                    @error('document_id')
                        <p style="color: #f44336; font-size: 12px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    
                    
                        
                        
                    

                <div class="form-group">
                    <label class="form-label">Note / Justification (Optionnel)</label>
                    <textarea name="commentaire" class="form-textarea @error('commentaire') border-red-500 @enderror" placeholder="Précisez l'année ou tout autre détail pertinent...">{{ old('commentaire') }}</textarea>
                    @error('commentaire')
                        <p style="color: #f44336; font-size: 12px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between" style="display: flex; justify-content: space-between; align-items: center; margin-top: 24px;">
                    <a href="{{ route('etudiant.demandes.index') }}" style="color: #666; text-decoration: none; font-size: 14px; font-weight: 600;">Annuler</a>
                    <button type="submit" class="btn-submit">
                        <svg class="btn-icon" viewBox="0 0 24 24">
                            <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                        </svg>
                        <span>Transmettre la demande</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <footer class="footer">
        © 2024 Institut SupNum. Tous droits réservés.
    </footer>

    <script>
        // File upload preview
        const fileInput = document.getElementById('justificatif');
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

