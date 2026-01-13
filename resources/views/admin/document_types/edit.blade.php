@extends('layouts.admin')

@section('title', 'Modifier le Type de Document')

@section('styles')
<style>
    .container { max-width: 600px; margin: 3rem auto; }
    .card { background: white; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 2rem; }
    .form-group { margin-bottom: 1.5rem; }
    label { display: block; font-size: 0.85rem; font-weight: 600; color: #475569; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; }
    input, textarea { width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.95rem; }
    input:focus, textarea:focus { outline: none; border-color: #2563eb; ring: 3px rgba(37,99,235,0.1); }
    .btn { padding: 0.75rem 1.5rem; border-radius: 0.5rem; font-weight: 600; cursor: pointer; border: none; font-size: 0.95rem; width: 100%; transition: 0.2s; }
    .btn-primary { background-color: #2563eb; color: white; }
    .btn-primary:hover { background-color: #1d4ed8; }
    .btn-secondary { background-color: #f1f5f9; color: #475569; display: block; text-align: center; text-decoration: none; margin-top: 1rem; }
    .error { color: #dc2626; font-size: 0.8rem; margin-top: 0.25rem; }
</style>
@endsection

@section('content')
    <div class="container">
        <div style="margin-bottom: 2rem;">
            <h1 style="font-size: 1.5rem; font-weight: 700;">Modifier le Type de Document</h1>
            <p style="color: #64748b;">Mettez à jour les informations du document.</p>
        </div>

        <div class="card">
            <form action="{{ route('admin.document-types.update', $document) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nom_document">Nom du Document</label>
                    <input type="text" name="nom_document" id="nom_document" value="{{ old('nom_document', $document->nom_document) }}" required>
                    @error('nom_document') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="description">Description (Optionnel)</label>
                    <textarea name="description" id="description" rows="3">{{ old('description', $document->description) }}</textarea>
                    @error('description') <div class="error">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-primary">Mettre à jour le Type</button>
                <a href="{{ route('admin.document-types.index') }}" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
@endsection
