@extends('layouts.admin')

@section('title', 'Détails de la demande - SupNumPortail')

@section('styles')
<style>
    .container { max-width: 1000px; margin: 0 auto; padding: 2rem; }
    
    .back-link { display: inline-flex; align-items: center; gap: 0.5rem; color: #64748b; text-decoration: none; font-weight: 500; margin-bottom: 1.5rem; font-size: 0.9rem; transition: color 0.2s; }
    .back-link:hover { color: #2563eb; }

    .page-header { margin-bottom: 2rem; }
    .page-title { font-size: 1.5rem; font-weight: 700; color: #0f172a; margin-bottom: 0.5rem; }
    .page-subtitle { color: #64748b; }

    .card { background: white; border-radius: 0.75rem; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 2rem; }
    .card-header { border-bottom: 1px solid #e2e8f0; padding-bottom: 1rem; margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; }
    .card-title { font-size: 1.1rem; font-weight: 600; color: #1e293b; display: flex; align-items: center; gap: 0.5rem; }

    .grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 2rem; }
    .detail-item { margin-bottom: 1rem; }
    .label { font-size: 0.75rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem; }
    .value { font-size: 1rem; font-weight: 500; color: #0f172a; }

    .status-badge { display: inline-block; padding: 0.35rem 0.75rem; border-radius: 9999px; font-size: 0.85rem; font-weight: 600; text-transform: uppercase; }
    .status-en_attente { background: #fef3c7; color: #92400e; }
    .status-en_cours_traitement { background: #dbeafe; color: #1e40af; }
    .status-fin { background: #dcfce7; color: #166534; }
    .status-rejetee { background: #fee2e2; color: #991b1b; }

    .form-group { margin-bottom: 1.5rem; }
    select, textarea { width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; font-family: inherit; font-size: 0.95rem; }
    select:focus, textarea:focus { outline: none; border-color: #2563eb; ring: 3px rgba(37,99,235,0.1); }
    .btn-primary { background: #2563eb; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 0.5rem; font-weight: 600; cursor: pointer; transition: 0.2s; font-size: 0.95rem; }
    .btn-primary:hover { background: #1d4ed8; }
</style>
@endsection

@section('content')
    <div class="container">
        <a href="{{ route('admin.demandes.index') }}" class="back-link">
            <span>←</span> Retour aux demandes
        </a>
        
        <div class="page-header">
            <h1 class="page-title">Détails de la demande #{{ $demande->id }}</h1>
            <p class="page-subtitle">Soumise le {{ $demande->created_at->format('d/m/Y à H:i') }}</p>
        </div>

        <div class="grid-2">
            <div>
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <span>👤</span> Informations de l'Étudiant
                        </div>
                    </div>
                    <div class="grid-2" style="gap: 1.5rem;">
                        <div class="detail-item">
                            <div class="label">Nom & Prénom</div>
                            <div class="value">{{ $demande->etudiant->nom ?? '' }} {{ $demande->etudiant->prenom ?? '' }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="label">Matricule</div>
                            <div class="value">{{ $demande->etudiant->matricule ?? 'N/A' }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="label">Filière</div>
                            <div class="value">{{ $demande->etudiant->filiere ?? 'N/A' }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="label">Email</div>
                            <div class="value">{{ $demande->etudiant->utilisateur->email ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <span>📄</span> Informations sur la Demande
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="label">Document Demandé</div>
                        <div class="value" style="color: #2563eb; font-weight: 700;">{{ $demande->document->nom_document ?? 'N/A' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="label">Statut Actuel</div>
                        <span class="status-badge status-{{ $demande->statut }}">
                            {{ str_replace('_', ' ', $demande->statut) }}
                        </span>
                    </div>
                    @if($demande->remarque_admin)
                    <div class="detail-item" style="margin-top: 1rem; padding: 1rem; background: #f8fafc; border-radius: 0.5rem;">
                        <div class="label">Remarque Administrative</div>
                        <div class="value">{{ $demande->remarque_admin }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <div>
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <span>⚙️</span> Traitement de la Demande
                        </div>
                    </div>
                    <form action="{{ route('admin.demandes.updateStatus', $demande->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <div class="label">Nouveau Statut</div>
                            <select name="statut" class="mt-1">
                                <option value="en_attente" {{ $demande->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                <option value="en_cours_traitement" {{ $demande->statut == 'en_cours_traitement' ? 'selected' : '' }}>En cours de traitement</option>
                                <option value="fin" {{ $demande->statut == 'fin' ? 'selected' : '' }}>Terminé (Prêt)</option>
                                <option value="rejetee" {{ $demande->statut == 'rejetee' ? 'selected' : '' }}>Rejeter</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <div class="label">Remarque (Obligatoire si rejeté)</div>
                            <textarea name="remarque_admin" rows="4" placeholder="Ajouter une note ou un motif de rejet...">{{ $demande->remarque_admin }}</textarea>
                        </div>

                        <button type="submit" class="btn-primary" style="width: 100%;">Enregistrer les modifications</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
