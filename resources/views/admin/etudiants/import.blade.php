<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importation des Étudiants - SupNumPortail</title>
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
            border-bottom: 3px solid #3b82f6;
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
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2.5rem 2rem;
        }

        /* Page Header */
        .page-header {
            margin-bottom: 2rem;
        }

        .page-header h1 {
            font-size: 2.25rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.5rem;
        }

        .page-description {
            color: #64748b;
            font-size: 1rem;
        }

        /* Instructions Box */
        .instructions-box {
            background-color: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .instructions-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .info-icon {
            width: 24px;
            height: 24px;
            background-color: #2563eb;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            font-weight: bold;
        }

        .instructions-title {
            color: #2563eb;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .instructions-text {
            color: #475569;
            font-size: 0.9375rem;
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        .required-fields {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
        }

        .field-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem;
            background-color: #f8fafc;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            color: #475569;
        }

        .field-icon {
            font-size: 1rem;
        }

        /* Upload Zone */
        .upload-section {
            background-color: white;
            border-radius: 0.75rem;
            padding: 3rem 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .upload-zone {
            border: 2px dashed #cbd5e1;
            border-radius: 0.75rem;
            padding: 3rem 2rem;
            text-align: center;
            transition: all 0.3s;
            cursor: pointer;
            background-color: #f8fafc;
        }

        .upload-zone:hover {
            border-color: #2563eb;
            background-color: #eff6ff;
        }

        .upload-zone.dragover {
            border-color: #2563eb;
            background-color: #dbeafe;
            transform: scale(1.02);
        }

        .upload-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 1.5rem;
            background-color: #dbeafe;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }

        .upload-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 0.5rem;
        }

        .upload-description {
            color: #64748b;
            font-size: 0.9375rem;
            margin-bottom: 1.5rem;
        }

        .upload-btn {
            background-color: #2563eb;
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 0.5rem;
            font-size: 0.9375rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .upload-btn:hover {
            background-color: #1d4ed8;
        }

        .file-input {
            display: none;
        }

        /* Status Alerts */
        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            font-size: 0.9375rem;
            font-weight: 500;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* Help Section */
        .help-section {
            background-color: white;
            border-radius: 0.75rem;
            padding: 1.25rem 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: all 0.2s;
        }

        .help-section:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .help-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .help-title {
            font-size: 1rem;
            font-weight: 500;
            color: #0f172a;
        }

        .help-icon {
            color: #2563eb;
            font-size: 1.25rem;
            transition: transform 0.3s;
        }

        .help-section.expanded .help-icon {
            transform: rotate(180deg);
        }

        .help-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .help-section.expanded .help-content {
            max-height: 500px;
            margin-top: 1rem;
        }

        .help-text {
            color: #64748b;
            font-size: 0.9375rem;
            line-height: 1.6;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 2rem;
            color: #94a3b8;
            font-size: 0.875rem;
        }

        /* Loading Animation */
        .loading {
            display: none;
            margin-top: 1rem;
        }

        .loading.active {
            display: block;
        }

        .loading-bar {
            width: 100%;
            height: 4px;
            background-color: #e2e8f0;
            border-radius: 2px;
            overflow: hidden;
        }

        .loading-progress {
            height: 100%;
            background-color: #2563eb;
            animation: loading 1.5s ease-in-out infinite;
        }

        @keyframes loading {
            0% { width: 0%; margin-left: 0%; }
            50% { width: 50%; margin-left: 25%; }
            100% { width: 0%; margin-left: 100%; }
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
                <a href="{{ route('admin.etudiants.import') }}" class="active">Importation</a>
                <a href="{{ route('admin.certificats.index') }}">Certificats</a>
                <a href="{{ route('admin.demandes.index') }}">Demandes</a>
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
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1>Importation des Étudiants</h1>
            <p class="page-description">Gérez l'intégration massive des données étudiants via fichiers Excel ou CSV.</p>
        </div>

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

        <!-- Instructions -->
        <div class="instructions-box">
            <div class="instructions-header">
                <div class="info-icon">ℹ</div>
                <div class="instructions-title">Instructions d'importation</div>
            </div>
            <p class="instructions-text">
                Le fichier doit être au format .xlsx ou .csv. Vous pouvez télécharger le <a href="{{ route('admin.etudiants.template') }}" class="text-blue-600 font-bold hover:underline">modèle d'importation ici</a>.
            </p>
            <div class="required-fields">
                <div class="field-item">
                    <span class="field-icon">🆔</span>
                    <span>Matricule</span>
                </div>
                <div class="field-item">
                    <span class="field-icon">👤</span>
                    <span>Nom / Prénom</span>
                </div>
                <div class="field-item">
                    <span class="field-icon">✉️</span>
                    <span>Email</span>
                </div>
                <div class="field-item">
                    <span class="field-icon">🎓</span>
                    <span>Année / Filière</span>
                </div>
            </div>
        </div>

        <!-- Upload Section -->
        <div class="upload-section">
            <form id="importForm" action="{{ route('admin.etudiants.import.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="upload-zone" id="uploadZone">
                    <div class="upload-icon">☁️</div>
                    <h3 class="upload-title">Zone de téléchargement</h3>
                    <p class="upload-description">
                        Glissez-déposez votre fichier ici ou cliquez pour parcourir vos documents<br>locaux
                    </p>
                    <button type="button" class="upload-btn" onclick="document.getElementById('fileInput').click()">
                        Sélectionner un fichier
                    </button>
                    <input type="file" name="fichier_excel" id="fileInput" class="file-input" accept=".xlsx,.xls,.csv" required>
                </div>
            </form>
            <div class="loading" id="loading">
                <div class="loading-bar">
                    <div class="loading-progress"></div>
                </div>
            </div>
        </div>

        <!-- Help Section -->
        <div class="help-section" id="helpSection">
            <div class="help-header">
                <h3 class="help-title">Besoin d'aide avec le formatage ?</h3>
                <span class="help-icon">⌄</span>
            </div>
            <div class="help-content">
                <p class="help-text">
                    <strong>Format du fichier :</strong><br>
                    • Le fichier doit contenir une ligne d'en-tête exacte : matricule, nom, prenom, email, password, annee, filiere<br>
                    • Les formats acceptés sont : .xlsx, .xls, .csv<br><br>
                    
                    <strong>Conseils :</strong><br>
                    • Assurez-vous que les emails sont valides et uniques<br>
                    • Les numéros de matricule doivent être uniques<br>
                    • Évitez les caractères spéciaux dans les noms<br>
                    • Utilisez UTF-8 comme encodage pour les fichiers CSV
                </p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        © {{ date('Y') }} SupNumPortail - Administration Centralisée. Tous droits réservés.
    </div>

    <script>
        const uploadZone = document.getElementById('uploadZone');
        const fileInput = document.getElementById('fileInput');
        const importForm = document.getElementById('importForm');
        const loading = document.getElementById('loading');

        uploadZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadZone.classList.add('dragover');
        });

        uploadZone.addEventListener('dragleave', () => {
            uploadZone.classList.remove('dragover');
        });

        uploadZone.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadZone.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                handleSubmission();
            }
        });

        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                handleSubmission();
            }
        });

        function handleSubmission() {
            loading.classList.add('active');
            importForm.submit();
        }

        // Help Section - Toggle
        const helpSection = document.getElementById('helpSection');
        helpSection.addEventListener('click', () => {
            helpSection.classList.toggle('expanded');
        });
    </script>
</body>
</html>
