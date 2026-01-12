<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dépôt de Certificat Médical - Institut SupNum</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            background: linear-gradient(135deg, #f0f4f8 0%, #e8eef5 100%);
            color: #333;
            min-height: 100vh;
        }

        /* Header */
        .header {
            background: white;
            border-top: 3px solid #2196f3;
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
            font-size: 1.125rem; /* text-lg */
            font-weight: 700; /* font-bold */
            text-decoration: none;
        }

        .logo-icon {
            width: 32px;
            height: 32px;
            background: #2196f3;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transform: rotate(45deg);
        }

        .logo-icon-inner {
            width: 16px;
            height: 16px;
            background: white;
            border-radius: 3px;
            transform: rotate(-45deg);
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
            transition: color 0.2s;
        }

        .nav-link:hover {
            color: #2196f3;
        }

        .nav-link.active {
            color: #2196f3;
            font-weight: 600;
        }

        .header-icons {
            display: flex;
            gap: 12px;
            align-items: center;
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
        }

        .icon-btn:hover {
            background: #e8eaf6;
        }

        .icon-btn svg {
            width: 20px;
            height: 20px;
            fill: #666;
        }

        /* User Avatar */
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
            cursor: pointer;
        }

        /* Container */
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        /* Page Header */
        .page-header {
            margin-bottom: 32px;
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

        /* Alerts */
        .alert {
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 24px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }

        .alert-error {
            background: #ffebee;
            color: #c62828;
            border: 1px solid #ffcdd2;
        }

        /* Form Card */
        .form-card {
            background: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            margin-bottom: 32px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }

        .form-section {
            display: flex;
            flex-direction: column;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .section-subtitle {
            font-size: 13px;
            color: #999;
            margin-bottom: 24px;
        }

        /* Form Group */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .form-select,
        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.2s;
            outline: none;
            background: white;
        }

        .form-select:focus,
        .form-input:focus {
            border-color: #2196f3;
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
        }

        /* Radio Group */
        .radio-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .radio-option {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .radio-option:hover {
            border-color: #2196f3;
            background: #f5f9ff;
        }

        .radio-option input[type="radio"] {
            margin-right: 12px;
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #2196f3;
        }

        .radio-option label {
            cursor: pointer;
            font-size: 13px;
            color: #333;
            flex: 1;
        }

        /* Calendar */
        .calendar {
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            overflow: hidden;
            background: white;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            background: #f8f9fa;
            border-bottom: 1px solid #e0e0e0;
        }

        .calendar-nav {
            background: none;
            border: none;
            cursor: pointer;
            padding: 6px;
            border-radius: 6px;
            transition: background 0.2s;
        }

        .calendar-nav:hover {
            background: #e0e0e0;
        }

        .calendar-title {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }

        .calendar-body {
            padding: 12px;
        }

        .calendar-weekdays {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
            margin-bottom: 4px;
        }

        .calendar-weekday {
            text-align: center;
            font-size: 11px;
            font-weight: 600;
            color: #999;
            padding: 4px 0;
        }

        .calendar-days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
        }

        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .calendar-day:hover:not(.disabled) {
            background: #f0f7ff;
            color: #2196f3;
        }

        .calendar-day.selected {
            background: #2196f3 !important;
            color: white !important;
            font-weight: 600;
        }

        .calendar-day.disabled {
            color: #ccc;
            cursor: not-allowed;
            opacity: 0.5;
        }

        /* Upload Area */
        .upload-area {
            border: 2px dashed #ddd;
            border-radius: 12px;
            padding: 32px 20px;
            text-align: center;
            background: #fafbfc;
            cursor: pointer;
            transition: all 0.2s;
            margin-bottom: 20px;
        }

        .upload-area:hover {
            border-color: #2196f3;
            background: #f5f9ff;
        }

        .upload-icon {
            width: 40px;
            height: 40px;
            margin: 0 auto 12px;
            fill: #2196f3;
        }

        .upload-text {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
        }

        .upload-hint {
            font-size: 12px;
            color: #999;
        }

        .upload-input {
            display: none;
        }

        /* Document Preview */
        .document-preview {
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            overflow: hidden;
            background: #f8f9fa;
        }

        .preview-header {
            padding: 10px 16px;
            background: white;
            border-bottom: 1px solid #e0e0e0;
            font-size: 12px;
            font-weight: 600;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .preview-content {
            padding: 24px;
            min-height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            color: white;
            text-align: center;
        }

        .preview-placeholder h3 {
            font-size: 16px;
            margin-bottom: 8px;
            opacity: 0.9;
        }

        .preview-placeholder p {
            font-size: 12px;
            opacity: 0.7;
            line-height: 1.5;
        }

        #file-preview-img {
            max-width: 100%;
            max-height: 300px;
            display: none;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 32px;
        }

        .btn {
            padding: 12px 32px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-secondary {
            background: #f5f5f5;
            color: #666;
        }

        .btn-secondary:hover {
            background: #e0e0e0;
        }

        .btn-primary {
            background: #2196f3;
            color: white;
        }

        .btn-primary:hover {
            background: #1976d2;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(33, 150, 243, 0.3);
        }

        .btn svg {
            width: 16px;
            height: 16px;
            fill: currentColor;
        }

        /* History Table */
        .history-card {
            background: white;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        }

        .history-card h2 {
            font-size: 20px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 24px;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            padding: 12px 16px;
            text-align: left;
            font-size: 12px;
            font-weight: 600;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #f0f0f0;
            background: #fafbfc;
        }

        td {
            padding: 16px;
            font-size: 14px;
            border-bottom: 1px solid #f0f0f0;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-badge.VALIDE { background: #e8f5e9; color: #2e7d32; }
        .status-badge.EN_ATTENTE { background: #fff3e0; color: #ef6c00; }
        .status-badge.REFUSE { background: #ffebee; color: #c62828; }

        .status-dot { width: 6px; height: 6px; border-radius: 50%; }
        .status-badge.VALIDE .status-dot { background: #4caf50; }
        .status-badge.EN_ATTENTE .status-dot { background: #ff9800; }
        .status-badge.REFUSE .status-dot { background: #f44336; }

        /* Footer */
        .footer {
            text-align: center;
            padding: 40px 20px;
            color: #999;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Header - Standardized from Dashboard */
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
            gap: 16px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0;
            font-size: 1.125rem;
            font-weight: 700;
            text-decoration: none;
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

        .nav-link:hover {
            color: #1e293b;
        }

        .nav-link.active {
            color: #3b82f6;
            border-bottom-color: #3b82f6;
            font-weight: 500;
        }

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

        .icon-btn:hover {
            background: #e8eaf6;
        }

        .icon-btn svg {
            width: 20px;
            height: 20px;
            fill: #666;
        }

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

        .user-info h3 {
            font-size: 13px;
            font-weight: 600;
            color: #333;
        }

        .user-info p {
            font-size: 11px;
            color: #999;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .form-grid { grid-template-columns: 1fr; }
            .header { padding: 16px 20px; }
            .nav { display: none; }
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
        <div class="header-left">
            <a href="{{ route('etudiant.dashboard') }}" class="logo">
                <span style="color: #16a34a;">SupNum</span><span style="color: #1d4ed8;">Portail</span>
            </a>
            <nav class="nav">
                <a href="{{ route('etudiant.dashboard') }}" class="nav-link {{ request()->routeIs('etudiant.dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('etudiant.demandes.index') }}" class="nav-link {{ request()->routeIs('etudiant.demandes.*') ? 'active' : '' }}">Demandes</a>
                <a href="{{ route('etudiant.certificats.create') }}" class="nav-link {{ request()->routeIs('etudiant.certificats.*') ? 'active' : '' }}">Certificats</a>
                <a href="{{ route('etudiant.profil') }}" class="nav-link {{ request()->routeIs('etudiant.profil') ? 'active' : '' }}">Profil</a>
            </nav>
        </div>
        <div class="header-right">
            <a href="{{ route('etudiant.notifications.index') }}" class="icon-btn" style="text-decoration: none;">
                <svg viewBox="0 0 24 24">
                    <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2zm-2 1H8v-6c0-2.48 1.51-4.5 4-4.5s4 2.02 4 4.5v6z"/>
                </svg>
                @if(isset($unreadCount) && $unreadCount > 0)
                    <span class="notification-badge">{{ $unreadCount }}</span>
                @endif
            </a>
            <form method="POST" action="{{ route('logout') }}" style="display: flex; align-items: center;">
                @csrf
                <button type="submit" class="icon-btn" title="Déconnexion" style="color: #ef4444;">
                    <svg viewBox="0 0 24 24" style="fill: currentColor;">
                        <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                    </svg>
                </button>
            </form>
            <div class="user-menu" onclick="window.location='{{ route('etudiant.profil') }}'">
                <div class="user-avatar">{{ Auth::user()->initials }}</div>
                <div class="user-info">
                    <h3>{{ Auth::user()->full_name }}</h3>
                    <p>Étudiant {{ Auth::user()->etudiant->annee ?? '' }}</p>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1>Dépôt de Certificat Médical</h1>
            <p>Veuillez remplir le formulaire ci-dessous pour justifier votre absence lors d'une évaluation.</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('etudiant.certificats.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-card">
                <div class="form-grid">
                    <!-- Left Section -->
                    <div class="form-section">
                        <h3 class="section-title">Détails académiques</h3>
                        <p class="section-subtitle">Informations sur votre cursus et l'évaluation manquée.</p>

                        <div class="form-group">
                            <label class="form-label">Année d'étude</label>
                            <select name="annee" class="form-select" required>
                                <option value="">Choisir votre année...</option>
                                <option value="L1" {{ old('annee') == 'L1' ? 'selected' : '' }}>Licence 1</option>
                                <option value="L2" {{ old('annee') == 'L2' ? 'selected' : '' }}>Licence 2</option>
                                <option value="L3" {{ old('annee') == 'L3' ? 'selected' : '' }}>Licence 3</option>
                                <option value="M1" {{ old('annee') == 'M1' ? 'selected' : '' }}>Master 1</option>
                                <option value="M2" {{ old('annee') == 'M2' ? 'selected' : '' }}>Master 2</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Nom de la matière</label>
                            <input type="text" name="nom_matiere" class="form-input" placeholder="Ex: Mathématiques, Algorithmes..." value="{{ old('nom_matiere') }}" required>
                            @error('nom_matiere') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Type d'évaluation</label>
                            <select name="type_evaluation" class="form-select" required>
                                <option value="">Choisir le type...</option>
                                <option value="devoir_ecrit" {{ old('type_evaluation') == 'devoir_ecrit' ? 'selected' : '' }}>Devoir écrit</option>
                                <option value="devoir_pratique" {{ old('type_evaluation') == 'devoir_pratique' ? 'selected' : '' }}>Devoir pratique</option>
                                <option value="tp_note" {{ old('type_evaluation') == 'tp_note' ? 'selected' : '' }}>TP noté</option>
                                <option value="examen_final" {{ old('type_evaluation') == 'examen_final' ? 'selected' : '' }}>Examen final</option>
                            </select>
                            @error('type_evaluation') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Date de l'absence</label>
                            <div class="calendar">
                                <div class="calendar-header">
                                    <button type="button" class="calendar-nav" id="prevMonth">❮</button>
                                    <span class="calendar-title" id="calendarTitle"></span>
                                    <button type="button" class="calendar-nav" id="nextMonth">❯</button>
                                </div>
                                <div class="calendar-body">
                                    <div class="calendar-weekdays">
                                        <div class="calendar-weekday">L</div>
                                        <div class="calendar-weekday">M</div>
                                        <div class="calendar-weekday">M</div>
                                        <div class="calendar-weekday">J</div>
                                        <div class="calendar-weekday">V</div>
                                        <div class="calendar-weekday">S</div>
                                        <div class="calendar-weekday">D</div>
                                    </div>
                                    <div class="calendar-days" id="calendarDays"></div>
                                </div>
                            </div>
                            <input type="hidden" name="date_evaluation" id="absence_date" value="{{ old('date_evaluation') }}" required>
                        </div>
                    </div>

                    <!-- Right Section -->
                    <div class="form-section">
                        <h3 class="section-title">Justificatif médical</h3>
                        <p class="section-subtitle">Téléchargez une photo ou un scan clair (PDF/JPG/PNG).</p>

                        <div class="upload-area" id="drop-zone">
                            <svg class="upload-icon" viewBox="0 0 24 24">
                                <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"/>
                            </svg>
                            <div class="upload-text" id="upload-status">Cliquez pour télécharger</div>
                            <div class="upload-hint">ou glissez-déposez le fichier ici</div>
                            <div class="upload-hint" style="margin-top: 8px;">MAX. 2MB</div>
                            <input type="file" id="certificate-upload" name="fichier" class="upload-input" accept=".jpg,.jpeg,.png,.pdf" required>
                        </div>

                        <div class="document-preview">
                            <div class="preview-header">Aperçu du document</div>
                            <div class="preview-content" id="preview-box">
                                <div class="preview-placeholder" id="preview-info">
                                    <h3>Aucun fichier sélectionné</h3>
                                    <p>L'aperçu apparaîtra ici après le téléchargement</p>
                                </div>
                                <img id="file-preview-img" src="">
                                <div id="pdf-preview-msg" style="display:none">Fichier PDF sélectionné</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('etudiant.dashboard') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary" {{ $evaluations->isEmpty() ? 'disabled' : '' }}>
                        <span>Soumettre mon dossier</span>
                        <svg viewBox="0 0 24 24">
                            <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </form>

        <!-- History -->
        <div class="history-card">
            <h2>Historique de vos dépôts</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Réception</th>
                            <th>Absence</th>
                            <th>Matière / Type</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($certificats as $cert)
                            <tr>
                                <td style="color: #999;">{{ $cert->created_at->format('d/m/Y') }}</td>
                                <td style="font-weight: 600;">{{ $cert->date_absence ? $cert->date_absence->format('d M Y') : '-' }}</td>
                                <td>
                                    <div style="font-weight: 500;">{{ $cert->evaluation->nom_matiere ?? 'N/A' }}</div>
                                    <div style="font-size: 11px; color: #666; text-transform: uppercase;">{{ str_replace('_', ' ', $cert->evaluation->type_evaluation ?? '') }}</div>
                                </td>
                                <td>
                                    <span class="status-badge {{ strtoupper($cert->statut) }}">
                                        <span class="status-dot"></span>
                                        {{ str_replace('_', ' ', strtoupper($cert->statut)) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ asset('storage/' . $cert->photo_certificat) }}" target="_blank" style="color: #2196f3; font-weight: 600; text-decoration: none; font-size: 13px;">Voir fichier</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: #999; padding: 40px;">Vous n'avez soumis aucun certificat médical.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer class="footer">
        © 2024 Institut Supérieur du Numérique
    </footer>

    <script>
        // Calendar Logic
        const calendarDays = document.getElementById('calendarDays');
        const calendarTitle = document.getElementById('calendarTitle');
        const prevMonth = document.getElementById('prevMonth');
        const nextMonth = document.getElementById('nextMonth');
        const hiddenInput = document.getElementById('absence_date');

        let date = new Date();
        let selectedDate = hiddenInput.value ? new Date(hiddenInput.value) : null;

        function renderCalendar() {
            calendarDays.innerHTML = '';
            const year = date.getFullYear();
            const month = date.getMonth();

            calendarTitle.innerText = new Intl.DateTimeFormat('fr-FR', { month: 'long', year: 'numeric' }).format(date);

            const lastDay = new Date(year, month + 1, 0).getDate();
            const firstDayIndex = (new Date(year, month, 1).getDay() + 6) % 7; // Adjust for Monday start

            for (let x = 0; x < firstDayIndex; x++) {
                const emptyDiv = document.createElement('div');
                emptyDiv.classList.add('calendar-day', 'disabled');
                calendarDays.appendChild(emptyDiv);
            }

            for (let i = 1; i <= lastDay; i++) {
                const dayDiv = document.createElement('div');
                dayDiv.classList.add('calendar-day');
                dayDiv.innerText = i;

                const currentStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
                if (selectedDate &&
                    selectedDate.getFullYear() === year &&
                    selectedDate.getMonth() === month &&
                    selectedDate.getDate() === i) {
                    dayDiv.classList.add('selected');
                }

                dayDiv.onclick = () => {
                    document.querySelectorAll('.calendar-day.selected').forEach(el => el.classList.remove('selected'));
                    dayDiv.classList.add('selected');
                    selectedDate = new Date(year, month, i);
                    hiddenInput.value = currentStr;
                };

                calendarDays.appendChild(dayDiv);
            }
        }

        prevMonth.onclick = () => { date.setMonth(date.getMonth() - 1); renderCalendar(); };
        nextMonth.onclick = () => { date.setMonth(date.getMonth() + 1); renderCalendar(); };
        renderCalendar();

        // File Selection Logic
        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('certificate-upload');
        const uploadStatus = document.getElementById('upload-status');
        const previewImg = document.getElementById('file-preview-img');
        const previewInfo = document.getElementById('preview-info');
        const pdfMsg = document.getElementById('pdf-preview-msg');

        dropZone.onclick = () => fileInput.click();

        fileInput.onchange = (e) => {
            const file = e.target.files[0];
            if (file) {
                uploadStatus.innerText = file.name;
                dropZone.style.borderColor = '#4caf50';
                dropZone.style.background = '#f1f8f4';

                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        previewImg.src = e.target.result;
                        previewImg.style.display = 'block';
                        previewInfo.style.display = 'none';
                        pdfMsg.style.display = 'none';
                    };
                    reader.readAsDataURL(file);
                } else if (file.type === 'application/pdf') {
                    previewImg.style.display = 'none';
                    previewInfo.style.display = 'none';
                    pdfMsg.style.display = 'block';
                }
            }
        };

        // Drag & Drop
        dropZone.ondragover = (e) => { e.preventDefault(); dropZone.style.borderColor = '#2196f3'; };
        dropZone.ondragleave = () => { dropZone.style.borderColor = '#ddd'; };
        dropZone.ondrop = (e) => {
            e.preventDefault();
            fileInput.files = e.dataTransfer.files;
            fileInput.onchange({target: fileInput});
        };
    </script>
</body>
</html>
