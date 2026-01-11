<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Evaluation;

class EvaluationController extends Controller
{
    public function index()
    {
        $evaluations = Evaluation::orderBy('matiere')->orderBy('type_evaluation')->paginate(20);
        return view('admin.evaluations.index', compact('evaluations'));
    }

    public function create()
    {
        return view('admin.evaluations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'matiere' => 'required|string|max:100',
            'type_evaluation' => 'required|string|max:100',
        ]);

        // Prevent duplicate combination
        if (Evaluation::where('matiere', $request->matiere)->where('type_evaluation', $request->type_evaluation)->exists()) {
            return back()->withInput()->with('error', 'Cette évaluation existe déjà.');
        }

        Evaluation::create($request->only(['matiere', 'type_evaluation']));

        return redirect()->route('admin.evaluations.index')->with('success', 'Évaluation ajoutée.');
    }

    public function edit(Evaluation $evaluation)
    {
        return view('admin.evaluations.edit', compact('evaluation'));
    }

    public function update(Request $request, Evaluation $evaluation)
    {
        $request->validate([
            'matiere' => 'required|string|max:100',
            'type_evaluation' => 'required|string|max:100',
        ]);

        // Check for uniqueness
        $exists = Evaluation::where('matiere', $request->matiere)
            ->where('type_evaluation', $request->type_evaluation)
            ->where('id', '!=', $evaluation->id)
            ->exists();

        if ($exists) {
            return back()->withInput()->with('error', 'Une autre évaluation avec cette combinaison existe déjà.');
        }

        $evaluation->update($request->only(['matiere', 'type_evaluation']));

        return redirect()->route('admin.evaluations.index')->with('success', 'Évaluation mise à jour.');
    }

    public function destroy(Evaluation $evaluation)
    {
        $evaluation->delete();
        return redirect()->route('admin.evaluations.index')->with('success', 'Évaluation supprimée.');
    }
}
