<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentManagementController extends Controller
{
    public function index()
    {
        $documents = Document::orderBy('nom_document')->paginate(20);
        return view('admin.document_types.index', compact('documents'));
    }

    public function create()
    {
        return view('admin.document_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_document' => 'required|string|max:100|unique:document,nom_document',
            'description' => 'nullable|string',
        ]);

        Document::create([
            'nom_document' => $request->nom_document,
            'description' => $request->description,
            'actif' => true,
        ]);

        return redirect()->route('admin.document-types.index')->with('success', 'Type de document créé avec succès.');
    }

    public function edit(Document $document_type)
    {
        $document = $document_type;
        return view('admin.document_types.edit', compact('document'));
    }

    public function update(Request $request, Document $document_type)
    {
        $request->validate([
            'nom_document' => 'required|string|max:100|unique:document,nom_document,' . $document_type->id,
            'description' => 'nullable|string',
        ]);

        $document_type->update($request->only(['nom_document', 'description']));

        return redirect()->route('admin.document-types.index')->with('success', 'Type de document mis à jour.');
    }

    public function toggleStatus(Document $document)
    {
        $document->update(['actif' => !$document->actif]);
        $status = $document->actif ? 'activé' : 'désactivé';
        return back()->with('success', "Le document a été {$status}.");
    }

    public function destroy(Document $document_type)
    {
        // Check if there are associated demandes? 
        // If yes, maybe prevent deletion or just allow it if cascade exists (it doesn't in initial migration).
        if ($document_type->demandes()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer ce type de document car il est associé à des demandes.');
        }

        $document_type->delete();
        return redirect()->route('admin.document-types.index')->with('success', 'Type de document supprimé.');
    }
}
