@extends('layouts.student')

@section('title', 'Profil Étudiant')

@section('styles')
<style>
    .container { max-width: 800px; margin: 0 auto; padding: 48px 20px; }
    .page-header { border-left: 4px solid #2196f3; padding-left: 20px; margin-bottom: 40px; }
    .page-header h1 { font-size: 28px; font-weight: 700; color: #1a1a1a; margin-bottom: 8px; }
    .page-header p { color: #666; font-size: 14px; }
    .info-card { background: white; border-radius: 12px; padding: 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 24px; }
    .section-title { font-size: 11px; font-weight: 700; color: #999; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 24px; }
    .info-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 32px 40px; }
    .info-item { display: flex; flex-direction: column; }
    .info-label { font-size: 12px; color: #999; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; font-weight: 600; }
    .info-value { font-size: 15px; color: #1a1a1a; font-weight: 500; }
    .security-card { background: white; border-radius: 12px; padding: 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 24px; }
    .security-title { font-size: 18px; font-weight: 600; color: #1a1a1a; margin-bottom: 8px; }
    .security-description { font-size: 13px; color: #666; line-height: 1.6; margin-bottom: 20px; }
    .btn-primary { background: #2196f3; color: white; border: none; padding: 12px 24px; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; text-transform: uppercase; letter-spacing: 0.5px; text-decoration: none; display: inline-block; }
    .btn-primary:hover { background: #1976d2; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(33, 150, 243, 0.3); }
    .notice { text-align: center; font-size: 13px; color: #999; font-style: italic; margin: 32px 0; }
    .alert { padding: 16px 20px; border-radius: 8px; margin-bottom: 24px; font-size: 14px; }
    .alert-success { background: #e8f5e9; color: #2e7d32; border-left: 4px solid #4caf50; }
    .alert-error { background: #ffebee; color: #c62828; border-left: 4px solid #f44336; }
</style>
@endsection

@section('content')
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1>Profil Étudiant</h1>
            <p>Registre officiel des informations académiques.</p>
        </div>

        <!-- Success/Error Messages -->
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

        @if(session('warning'))
        <div class="alert" style="background: #fff3e0; color: #e65100; border-left: 4px solid #ff9800;">
            {{ session('warning') }}
        </div>
        @endif

        <!-- Personal Information -->
        <div class="info-card">
            <h3 class="section-title">Informations Personnelles</h3>
            @if($etudiant)
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Nom</div>
                        <div class="info-value">{{ $etudiant->nom }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Prénom</div>
                        <div class="info-value">{{ $etudiant->prenom }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Matricule</div>
                        <div class="info-value">{{ $etudiant->matricule }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email Institutionnel</div>
                        <div class="info-value">{{ $user->email }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Filière</div>
                        <div class="info-value">{{ $etudiant->filiere }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Année d'Étude</div>
                        <div class="info-value">{{ $etudiant->annee }}</div>
                    </div>
                </div>
            @else
                <div style="color: #f44336; padding: 20px; text-align: center;">
                    Profil étudiant incomplet. Veuillez contacter l'administration.
                </div>
            @endif
        </div>

        <!-- Security Section -->
        <div class="security-card">
            <div class="security-header">
                <div>
                    <h3 class="security-title">Sécurité du compte</h3>
                    <p class="security-description">
                        Pour garantir l'intégrité de vos données académiques, nous vous recommandons<br>
                        de mettre à jour votre mot de passe régulièrement.
                    </p>
                </div>
            </div>
            <a href="{{ route('etudiant.password.edit') }}" class="btn-primary">
                Modifier le mot de passe
            </a>
        </div>

        <!-- Notice -->
        <div class="notice">
            Une erreur dans vos informations ? Veuillez contacter la scolarité de l'établissement
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Auto-hide success/error messages after 5 seconds
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);
</script>
@endpush
