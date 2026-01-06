<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-blue-700 to-indigo-600 py-6 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 shadow-lg">
            <h2 class="font-bold text-2xl text-white leading-tight">
                {{ __('Gestion des Certificats Médicaux') }}
            </h2>
            <p class="text-blue-100 text-sm mt-1">Examinez et validez les justificatifs d'absence soumis par les étudiants.</p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Filters -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 dark:border-gray-700">
                <div class="p-6">
                    <form action="{{ route('admin.certificats.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
                        <div class="min-w-[200px]">
                            <label for="statut" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">État du dossier</label>
                            <select name="statut" id="statut" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all">
                                <option value="">Tous les certificats</option>
                                <option value="EN_ATTENTE" {{ request('statut') === 'EN_ATTENTE' ? 'selected' : '' }}>En attente</option>
                                <option value="VALIDE" {{ request('statut') === 'VALIDE' ? 'selected' : '' }}>Acceptés (VALIDE)</option>
                                <option value="REFUSE" {{ request('statut') === 'REFUSE' ? 'selected' : '' }}>Rejetés (REFUSE)</option>
                            </select>
                        </div>
                        <button type="submit" class="inline-flex items-center px-5 py-2.5 text-sm font-bold text-center text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 transition-all shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                            Filtrer
                        </button>
                        @if(request()->anyFilled(['statut']))
                            <a href="{{ route('admin.certificats.index') }}" class="text-gray-500 hover:text-red-600 text-sm font-semibold transition-colors mb-2.5 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                Réinitialiser
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- List -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-xl border border-gray-100 dark:border-gray-700">
                <div class="p-0 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300 border-b dark:border-gray-600">
                                <tr>
                                    <th scope="col" class="py-4 px-6 font-bold">Matricule</th>
                                    <th scope="col" class="py-4 px-6 font-bold">Étudiant</th>
                                    <th scope="col" class="py-4 px-6 font-bold">Année</th>
                                    <th scope="col" class="py-4 px-6 font-bold">Évaluation</th>
                                    <th scope="col" class="py-4 px-6 font-bold">Date Éval.</th>
                                    <th scope="col" class="py-4 px-6 font-bold">Statut</th>
                                    <th scope="col" class="py-4 px-6 font-bold">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse($certificats as $certificat)
                                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <td class="py-4 px-6">
                                            <span class="font-mono text-blue-600 dark:text-blue-400 font-bold bg-blue-50 dark:bg-blue-900/30 px-2 py-1 rounded">{{ $certificat->etudiant_matricule }}</span>
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="font-semibold text-gray-900 dark:text-white">
                                                {{ $certificat->etudiant?->prenom ?? '' }} {{ $certificat->etudiant?->nom ?? 'Étudiant Inconnu' }}
                                            </div>
                                        </td>
                                        <td class="py-4 px-6">
                                            <span class="font-semibold text-gray-600 dark:text-gray-400">{{ $certificat->annee }}</span>
                                        </td>
                                        <td class="py-4 px-6 text-xs">
                                            <span class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded-full uppercase font-bold">{{ str_replace('_', ' ', $certificat->type_evaluation) }}</span>
                                        </td>
                                        <td class="py-4 px-6 font-medium">
                                            {{ $certificat->date_evaluation->format('d/m/Y') }}
                                        </td>
                                        <td class="py-4 px-6">
                                            @php
                                                $statusClasses = [
                                                    'VALIDE' => 'text-green-700 bg-green-100 dark:bg-green-900/40 dark:text-green-300',
                                                    'REFUSE' => 'text-red-700 bg-red-100 dark:bg-red-900/40 dark:text-red-300',
                                                    'EN_ATTENTE' => 'text-amber-700 bg-amber-100 dark:bg-amber-900/40 dark:text-amber-300',
                                                ];
                                                $class = $statusClasses[$certificat->statut] ?? 'bg-gray-100 text-gray-700';
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $class }}">
                                                <span class="w-1.5 h-1.5 mr-1.5 rounded-full {{ strpos($class, 'green') !== false ? 'bg-green-500' : (strpos($class, 'red') !== false ? 'bg-red-500' : 'bg-amber-500') }}"></span>
                                                {{ $certificat->statut }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6">
                                            <a href="{{ route('admin.certificats.show', $certificat) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-bold text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-600 hover:text-white transition-all border border-blue-200 shadow-sm">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                Voir
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-10 px-6 text-center">
                                            <div class="flex flex-col items-center justify-center text-gray-400">
                                                <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 17.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                <p class="text-sm italic">Aucun certificat médical trouvé dans cette catégorie.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($certificats->hasPages())
                        <div class="p-6 border-t dark:border-gray-700">
                            {{ $certificats->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

