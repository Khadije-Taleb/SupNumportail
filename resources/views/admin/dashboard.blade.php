<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-blue-600 to-green-400 py-6 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 shadow-md">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="font-semibold text-2xl text-white leading-tight">
                        {{ __('Tableau de Bord Admin') }}
                    </h2>
                    <p class="text-blue-100 text-sm mt-1">Gestion des demandes et du portail</p>
                </div>
                <a href="{{ route('admin.import') }}" class="inline-flex items-center px-4 py-2 bg-white text-blue-600 border border-transparent rounded-lg font-semibold text-xs uppercase tracking-widest hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    {{ __('Importer Étudiants') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card 1 -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl transition-transform hover:-translate-y-1 duration-300">
                    <div class="p-6 flex items-center justify-between">
                        <div>
                            <div class="text-xs font-bold text-blue-500 uppercase tracking-widest mb-1">Total Demandes</div>
                            <div class="text-4xl font-extrabold text-gray-900 dark:text-gray-100">{{ $stats['total'] }}</div>
                        </div>
                        <div class="h-14 w-14 rounded-xl bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-white text-2xl shadow-blue-200 shadow-lg">
                            📂
                        </div>
                    </div>
                    <div class="bg-blue-50 dark:bg-gray-700/50 px-6 py-3 border-t border-blue-100 dark:border-gray-700">
                        <span class="text-xs text-blue-600 dark:text-blue-400 font-medium">Toutes les demandes reçues</span>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl transition-transform hover:-translate-y-1 duration-300">
                     <div class="p-6 flex items-center justify-between">
                        <div>
                            <div class="text-xs font-bold text-yellow-500 uppercase tracking-widest mb-1">En attente</div>
                            <div class="text-4xl font-extrabold text-gray-900 dark:text-gray-100">{{ $stats['pending'] }}</div>
                        </div>
                        <div class="h-14 w-14 rounded-xl bg-gradient-to-br from-yellow-400 to-yellow-600 flex items-center justify-center text-white text-2xl shadow-yellow-200 shadow-lg">
                            ⏳
                        </div>
                    </div>
                    <div class="bg-yellow-50 dark:bg-gray-700/50 px-6 py-3 border-t border-yellow-100 dark:border-gray-700">
                         <span class="text-xs text-yellow-600 dark:text-yellow-400 font-medium">Demandes nécessitant une action</span>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl transition-transform hover:-translate-y-1 duration-300">
                     <div class="p-6 flex items-center justify-between">
                        <div>
                            <div class="text-xs font-bold text-red-500 uppercase tracking-widest mb-1">Certificats en attente</div>
                            <div class="text-4xl font-extrabold text-gray-900 dark:text-gray-100">{{ $stats['pending_certificats'] ?? 0 }}</div>
                        </div>
                        <div class="h-14 w-14 rounded-xl bg-gradient-to-br from-red-400 to-red-600 flex items-center justify-center text-white text-2xl shadow-red-200 shadow-lg">
                            🏥
                        </div>
                    </div>
                    <div class="bg-red-50 dark:bg-gray-700/50 px-6 py-3 border-t border-red-100 dark:border-gray-700 flex justify-between items-center">
                         <span class="text-xs text-red-600 dark:text-red-400 font-medium">Justificatifs à valider</span>
                         <a href="{{ route('admin.certificats.index', ['statut' => 'EN_ATTENTE']) }}" class="text-xs text-red-700 font-bold hover:underline">Voir tout →</a>
                    </div>
                </div>
            </div>

            <!-- Recent Requests Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl mb-10">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 md:flex md:justify-between md:items-center space-y-4 md:space-y-0">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                        <span class="text-blue-500">📋</span> Toutes les demandes
                    </h3>
                    
                    <form action="{{ route('admin.dashboard') }}" method="GET" class="flex items-center gap-3">
                        <select name="statut" onchange="this.form.submit()" class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">Tous les statuts</option>
                            <option value="en_attente" {{ request('statut') === 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="acceptee" {{ request('statut') === 'acceptee' ? 'selected' : '' }}>Acceptées</option>
                            <option value="rejetee" {{ request('statut') === 'rejetee' ? 'selected' : '' }}>Rejetées</option>
                        </select>
                        @if(request('statut'))
                            <a href="{{ route('admin.dashboard') }}" class="text-xs text-gray-500 hover:text-blue-600 transition-colors">Effacer</a>
                        @endif
                    </form>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700/50">
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">ÉTUDIANT</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">DOCUMENT</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">DATE</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">STATUT</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($demandes as $demande)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                                {{ substr($demande->etudiant?->prenom ?? 'U', 0, 1) }}{{ substr($demande->etudiant?->nom ?? 'N', 0, 1) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $demande->etudiant?->prenom ?? '' }} {{ $demande->etudiant?->nom ?? 'Étudiant Inconnu' }}</div>
                                                <div class="text-xs text-gray-500">{{ $demande->etudiant?->matricule ?? $demande->matricule }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $demande->document->type_document ?? 'Autre' }}</div>
                                        <div class="text-xs text-gray-500">{{ Str::limit($demande->document->description ?? '', 30) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-gray-100 font-medium">{{ $demande->date_demande->format('d/m/Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $demande->date_demande->format('H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusClasses = [
                                                'ACCEPTEE' => 'bg-green-100 text-green-800 border-green-200',
                                                'REJETEE' => 'bg-red-100 text-red-800 border-red-200',
                                                'EN_ATTENTE' => 'bg-amber-100 text-amber-800 border-amber-200',
                                            ];
                                            $class = $statusClasses[strtoupper($demande->statut)] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                        @endphp
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full border {{ $class }}">
                                            {{ strtoupper(str_replace('_', ' ', $demande->statut)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.demandes.show', $demande) }}" class="inline-flex items-center px-4 py-2 border border-blue-600 rounded-lg text-blue-600 hover:bg-blue-600 hover:text-white transition-all text-xs font-bold uppercase tracking-wider shadow-sm">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Consulter
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Aucune demande trouvée.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
