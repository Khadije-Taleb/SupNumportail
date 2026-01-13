@extends('layouts.student')

@section('title', 'Dépôt de Certificat Médical')

@section('styles')
<style>
    .container { max-width: 1000px; margin: 0 auto; padding: 40px 20px; }
    .page-header { margin-bottom: 32px; }
    .page-header h1 { font-size: 32px; font-weight: 700; color: #1a1a1a; margin-bottom: 8px; }
    .page-header p { color: #666; font-size: 15px; }
    .alert { border-radius: 12px; padding: 16px 20px; margin-bottom: 24px; font-size: 14px; display: flex; align-items: center; gap: 12px; }
    .alert-success { background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; }
    .alert-error { background: #ffebee; color: #c62828; border: 1px solid #ffcdd2; }
    .form-card { background: white; border-radius: 16px; padding: 40px; box-shadow: 0 4px 16px rgba(0,0,0,0.08); margin-bottom: 32px; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; }
    .section-title { font-size: 18px; font-weight: 600; color: #1a1a1a; margin-bottom: 8px; }
    .section-subtitle { font-size: 13px; color: #999; margin-bottom: 24px; }
    .form-group { margin-bottom: 20px; }
    .form-label { display: block; font-size: 14px; font-weight: 600; color: #333; margin-bottom: 8px; }
    .form-select, .form-input { width: 100%; padding: 12px 16px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; outline: none; transition: all 0.2s; }
    .form-select:focus, .form-input:focus { border-color: #2196f3; box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1); }
    .upload-area { border: 2px dashed #ddd; border-radius: 12px; padding: 32px 20px; text-align: center; background: #fafbfc; cursor: pointer; transition: all 0.2s; margin-bottom: 20px; }
    .upload-area:hover { border-color: #2196f3; background: #f5f9ff; }
    .btn { padding: 12px 32px; border-radius: 8px; font-size: 15px; font-weight: 600; cursor: pointer; transition: all 0.2s; border: none; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; }
    .btn-primary { background: #2196f3; color: white; }
    .btn-primary:hover { background: #1976d2; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(33, 150, 243, 0.3); }
    .history-card { background: white; border-radius: 16px; padding: 32px; box-shadow: 0 4px 16px rgba(0,0,0,0.08); }
    .status-badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; }
    .status-badge.VALIDE { background: #e8f5e9; color: #2e7d32; }
    .status-badge.EN_ATTENTE { background: #fff3e0; color: #ef6c00; }
    .status-badge.REFUSE { background: #ffebee; color: #c62828; }
    .table-container { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    th { padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #666; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #f0f0f0; background: #fafbfc; }
    td { padding: 16px; font-size: 14px; border-bottom: 1px solid #f0f0f0; }
</style>
@endsection

@section('content')
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1>Dépôt de Certificat Médical</h1>
            <p>Veuillez remplir le formulaire ci-dessous pour justifier votre absence lors d'une évaluation.</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-card">
            <form action="{{ route('etudiant.certificats.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-grid">
                    <div class="form-section">
                        <h3 class="section-title">Informations sur l'absence</h3>
                        <div class="form-group">
                            <label class="form-label">Matière</label>
                            <input type="text" name="nom_matiere" class="form-input" placeholder="Ex: Mathématiques" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Type d'évaluation</label>
                            <select name="type_evaluation" class="form-select" required>
                                <option value="devoir_ecrit">Devoir écrit</option>
                                <option value="devoir_pratique">Devoir pratique</option>
                                <option value="tp_note">TP noté</option>
                                <option value="examen_final">Examen final</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Date de l'évaluation</label>
                            <input type="date" name="date_evaluation" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Année</label>
                            <select name="annee" class="form-select" required>
                                <option value="L1">L1</option>
                                <option value="L2">L2</option>
                                <option value="L3">L3</option>
                                <option value="M1">M1</option>
                                <option value="M2">M2</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-section">
                        <h3 class="section-title">Justificatif</h3>
                        <div class="upload-area" onclick="document.getElementById('fichier').click()">
                            <svg width="40" height="40" fill="#2196f3" viewBox="0 0 24 24"><path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"/></svg>
                            <p class="upload-text">Cliquez pour ajouter le certificat</p>
                            <p class="upload-hint">PDF, JPG, PNG (Max. 2MB)</p>
                            <input type="file" id="fichier" name="fichier" style="display:none" accept=".pdf,.jpg,.jpeg,.png" required>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Envoyer le certificat</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="history-card">
            <h2>Historique des dépôts</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Matière</th>
                            <th>Type</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($certificats as $cert)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($cert->date_absence)->format('d/m/Y') }}</td>
                                <td>{{ $cert->evaluation->nom_matiere ?? 'N/A' }}</td>
                                <td>{{ str_replace('_', ' ', $cert->evaluation->type_evaluation ?? 'N/A') }}</td>
                                <td>
                                    <span class="status-badge {{ $cert->statut }}">
                                        {{ $cert->statut }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ Storage::url($cert->photo_certificat) }}" target="_blank" style="color:#2196f3; text-decoration:none;">Voir</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
