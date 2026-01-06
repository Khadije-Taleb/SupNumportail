<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-blue-700 to-indigo-600 py-6 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 shadow-lg">
            <h2 class="font-bold text-2xl text-white leading-tight">
                {{ __('Historique de mes Demandes') }}
            </h2>
            <p class="text-blue-100 text-sm mt-1">Consultez l'état de traitement de vos demandes de documents administratifs.</p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="p-0">
                    
                    @if(session('success'))
                        <div class="m-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg shadow-sm" role="alert">
                            <span class="font-bold">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300 border-b dark:border-gray-600">
                                <tr>
                                    <th scope="col" class="py-4 px-6 font-bold">Document</th>
                                    <th scope="col" class="py-4 px-6 font-bold">Date de Soumission</th>
                                    <th scope="col" class="py-4 px-6 font-bold">Statut Actuel</th>
                                    <th scope="col" class="py-4 px-6 font-bold">Observations Admin</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse($demandes as $demande)
                                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <td class="py-4 px-6 font-bold text-gray-900 dark:text-white">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center text-blue-600 dark:text-blue-400 mr-3">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                </div>
                                                {{ $demande->document->type_document }}
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 font-medium text-gray-600 dark:text-gray-400">
                                            {{ $demande->date_demande->format('d/m/Y') }}
                                            <span class="text-xs text-gray-400 block">{{ $demande->date_demande->format('H:i') }}</span>
                                        </td>
                                        <td class="py-4 px-6">
                                            @php
                                                $statusClasses = [
                                                    'ACCEPTEE' => 'text-green-700 bg-green-100 dark:bg-green-900/40 dark:text-green-300',
                                                    'REJETEE' => 'text-red-700 bg-red-100 dark:bg-red-900/40 dark:text-red-300',
                                                    'EN_ATTENTE' => 'text-amber-700 bg-amber-100 dark:bg-amber-900/40 dark:text-amber-300',
                                                ];
                                                $class = $statusClasses[$demande->statut] ?? 'bg-gray-100 text-gray-700';
                                            @endphp
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold leading-tight {{ $class }}">
                                                <span class="w-1.5 h-1.5 mr-2 rounded-full {{ strpos($class, 'green') !== false ? 'bg-green-500' : (strpos($class, 'red') !== false ? 'bg-red-500' : 'bg-amber-500') }}"></span>
                                                {{ ucfirst(strtolower(str_replace('_', ' ', $demande->statut))) }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6">
                                            @if($demande->remarque_admin)
                                                <div class="text-sm text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-900/50 p-2 rounded-lg border border-gray-100 dark:border-gray-700 italic">
                                                    "{{ $demande->remarque_admin }}"
                                                </div>
                                            @else
                                                <span class="text-gray-400 italic text-xs">Aucune observation pour le moment</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-12 px-6 text-center">
                                            <div class="flex flex-col items-center justify-center text-gray-400">
                                                <svg class="w-16 h-16 mb-4 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 17.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                <p class="text-lg font-medium">Vous n'avez soumis aucune demande.</p>
                                                <a href="{{ route('etudiant.demandes.create') }}" class="mt-4 text-blue-600 hover:text-blue-700 font-bold flex items-center">
                                                    Soumettre ma première demande
                                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($demandes->hasPages())
                    <div class="p-6 border-t dark:border-gray-700">
                        {{ $demandes->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
