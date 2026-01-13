@extends('layouts.admin')

@section('title', 'Détails du Certificat Médical - SupNumPortail')

@section('styles')
<style>
    .container { max-width: 1200px; margin: 0 auto; padding: 2rem; }
    
    .back-link { display: inline-flex; align-items: center; gap: 0.5rem; color: #64748b; text-decoration: none; font-weight: 500; margin-bottom: 1.5rem; font-size: 0.9rem; transition: color 0.2s; }
    .back-link:hover { color: #2563eb; }

    .page-header { margin-bottom: 2rem; }
    .page-title { font-size: 1.5rem; font-weight: 700; color: #0f172a; margin-bottom: 0.5rem; }

    .grid-layout { display: grid; grid-template-columns: 350px 1fr; gap: 2rem; }

    .card { background: white; border-radius: 0.75rem; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 1.5rem; }
    .card-header { border-bottom: 1px solid #e2e8f0; padding-bottom: 1rem; margin-bottom: 1rem; }
    .card-title { font-size: 1.1rem; font-weight: 600; color: #1e293b; }

    .detail-group { margin-bottom: 1rem; }
    .label { font-size: 0.75rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem; }
    .value { font-size: 0.95rem; font-weight: 500; color: #0f172a; }

    .form-group { margin-bottom: 1rem; }
    label { display: block; font-size: 0.875rem; font-weight: 600; color: #475569; margin-bottom: 0.5rem; }
    select, textarea { width: 100%; padding: 0.6rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; font-family: inherit; font-size: 0.9rem; }
    select:focus, textarea:focus { outline: none; border-color: #2563eb; ring: 3px rgba(37,99,235,0.1); }
    .btn-primary { background: #2563eb; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 0.5rem; font-weight: 600; cursor: pointer; transition: 0.2s; font-size: 0.9rem; width: 100%; }
    .btn-primary:hover { background: #1d4ed8; }

    .preview-container { background: #f1f5f9; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; overflow: hidden; min-height: 600px; border: 1px solid #e2e8f0; }
    .preview-img { max-width: 100%; height: auto; object-fit: contain; }
    .pdf-object { width: 100%; height: 800px; }

    @media (max-width: 900px) {
        .grid-layout { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
    <div class="container">
        <a href="{{ route('admin.certificats.index') }}" class="back-link">
            <span>←</span> Retour aux certificats
        </a>
        
        <div class="page-header">
            <h1 class="page-title">Détails du certificat #{{ $certificat->id }}</h1>
        </div>

        <div class="grid-layout">
            <!-- Sidebar Info -->
            <div>
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Informations Étudiant</div>
                    </div>
                    <div class="detail-group">
                        <div class="label">Nom & Prénom</div>
                        <div class="value">{{ $certificat->etudiant->nom ?? '' }} {{ $certificat->etudiant->prenom ?? '' }}</div>
                    </div>
                    <div class="detail-group">
                        <div class="label">Matricule</div>
                        <div class="value">{{ $certificat->etudiant->matricule ?? 'N/A' }}</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Contexte de l'absence</div>
                    </div>
                    <div class="detail-group">
                        <div class="label">Matière</div>
                        <div class="value">{{ $certificat->matiere }}</div>
                    </div>
                    <div class="detail-group">
                        <div class="label">Type d'évaluation</div>
                        <div class="value">{{ str_replace('_', ' ', ucfirst($certificat->type_evaluation)) }}</div>
                    </div>
                    <div class="detail-group">
                        <div class="label">Date de l'absence</div>
                        <div class="value">{{ $certificat->date_absence ? \Carbon\Carbon::parse($certificat->date_absence)->format('d/m/Y') : 'Non renseignée' }}</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Décision</div>
                    </div>
                    <form action="{{ route('admin.certificats.updateStatus', $certificat->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="statut">Statut</label>
                            <select name="statut" id="statut">
                                <option value="EN_ATTENTE" {{ $certificat->statut == 'EN_ATTENTE' ? 'selected' : '' }}>En attente</option>
                                <option value="VALIDE" {{ $certificat->statut == 'VALIDE' ? 'selected' : '' }}>Accepter</option>
                                <option value="REFUSE" {{ $certificat->statut == 'REFUSE' ? 'selected' : '' }}>Refuser</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="remarque_admin">Remarque</label>
                            <textarea name="remarque_admin" id="remarque_admin" rows="3">{{ $certificat->remarque_admin }}</textarea>
                        </div>
                        <button type="submit" class="btn-primary">
                            Enregistrer
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Content (Preview) -->
            <div>
                <div class="card" style="height: 100%;">
                    <div class="card-header">
                        <div class="card-title">Aperçu du certificat</div>
                    </div>
                    <div class="preview-container">
                        @php
                            $extension = pathinfo($certificat->photo_certificat, PATHINFO_EXTENSION);
                            $isPdf = strtolower($extension) === 'pdf';
                        @endphp

                        @if($isPdf)
                            <object data="{{ route('admin.certificats.viewFile', $certificat->id) }}" type="application/pdf" class="pdf-object">
                                <p style="padding: 1rem; text-align: center; color: #64748b;">Votre navigateur ne peut pas afficher ce PDF. <a href="{{ route('admin.certificats.viewFile', $certificat->id) }}" style="color: #2563eb;">Télécharger le fichier</a></p>
                            </object>
                        @else
                            <img src="{{ route('admin.certificats.viewFile', $certificat->id) }}" class="preview-img" alt="Certificat">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
