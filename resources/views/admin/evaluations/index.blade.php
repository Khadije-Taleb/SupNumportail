<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-blue-700 to-indigo-600 py-6 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 shadow-lg">
            <h2 class="font-bold text-2xl text-white leading-tight">{{ __('Gestion des évaluations') }}</h2>
            <p class="text-blue-100 text-sm mt-1">Créez, modifiez ou supprimez les évaluations (matière + type).</p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold">Liste des évaluations</h3>
                    <a href="{{ route('admin.evaluations.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Nouvelle évaluation</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300 border-b dark:border-gray-600">
                            <tr>
                                <th class="py-3 px-4">Matière</th>
                                <th class="py-3 px-4">Type d'évaluation</th>
                                <th class="py-3 px-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($evaluations as $eval)
                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="py-3 px-4">{{ $eval->matiere }}</td>
                                    <td class="py-3 px-4">{{ str_replace('_',' ', $eval->type_evaluation) }}</td>
                                    <td class="py-3 px-4">
                                        <a href="{{ route('admin.evaluations.edit', $eval) }}" class="text-sm text-indigo-600 hover:underline mr-3">Modifier</a>
                                        <form action="{{ route('admin.evaluations.destroy', $eval) }}" method="POST" class="inline" onsubmit="return confirm('Confirmer la suppression ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-600 hover:underline">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-6 px-4 text-center text-gray-500">Aucune évaluation trouvée. Créez-en une.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $evaluations->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
