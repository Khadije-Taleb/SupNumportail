@extends('layouts.admin')

@section('title', 'Gestion des Types de Documents')

@section('styles')
<style>
    .container { margin-top: 2rem; }
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .btn { padding: 0.6rem 1.2rem; border-radius: 0.5rem; font-weight: 600; cursor: pointer; text-decoration: none; border: none; font-size: 0.9rem; transition: 0.2s; }
    .btn-primary { background-color: #2563eb; color: white; }
    .btn-primary:hover { background-color: #1d4ed8; }
    .card { background: white; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden; }
    table { width: 100%; border-collapse: collapse; }
    th { background: #f8fafc; padding: 1rem; text-align: left; font-size: 0.75rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #e2e8f0; }
    td { padding: 1rem; border-bottom: 1px solid #e2e8f0; font-size: 0.9rem; }
    .status-badge { padding: 0.3rem 0.6rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; }
    .status-active { background: #dcfce7; color: #166534; }
    .status-inactive { background: #fee2e2; color: #991b1b; }
    .actions { display: flex; gap: 0.5rem; }
    .alert { padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; }
    .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
</style>
@endsection

@section('content')
    <div class="container">
        <div class="page-header">
            <div>
                <h1 style="font-size: 1.8rem; font-weight: 700;">Gestion des Types de Documents</h1>
                <p style="color: #64748b; margin-top: 0.25rem;">Gérez les types de documents que les étudiants peuvent demander.</p>
            </div>
            <a href="{{ route('admin.document-types.create') }}" class="btn btn-primary">+ Ajouter un type</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>NOM DU DOCUMENT</th>
                        <th>DESCRIPTION</th>
                        <th>STATUT</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $document)
                        <tr>
                            <td style="font-weight: 600;">{{ $document->nom_document }}</td>
                            <td style="color: #64748b;">{{ $document->description ?? '-' }}</td>
                            <td>
                                <span class="status-badge {{ $document->actif ? 'status-active' : 'status-inactive' }}">
                                    {{ $document->actif ? 'Actif' : 'Désactivé' }}
                                </span>
                            </td>
                            <td class="actions">
                                <a href="{{ route('admin.document-types.edit', $document) }}" class="btn" style="background: #f1f5f9; color: #475569;">Modifier</a>
                                
                                <form action="{{ route('admin.document-types.toggle', $document) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn" style="background: {{ $document->actif ? '#fff1f2' : '#f0fdf4' }}; color: {{ $document->actif ? '#e11d48' : '#16a34a' }};">
                                        {{ $document->actif ? 'Désactiver' : 'Activer' }}
                                    </button>
                                </form>

                                <form action="{{ route('admin.document-types.destroy', $document) }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce type de document ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn" style="background: #fee2e2; color: #dc2626;">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 3rem; color: #94a3b8;">Aucun type de document défini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="margin-top: 1rem;">
            {{ $documents->links() }}
        </div>
    </div>
@endsection
