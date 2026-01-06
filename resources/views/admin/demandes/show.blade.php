<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-blue-700 to-indigo-600 py-6 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 shadow-lg">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="font-bold text-2xl text-white leading-tight">
                        {{ __('Détails de la Demande') }}
                    </h2>
                    <p class="text-blue-100 text-sm mt-1">Examen de la demande administrative #{{ $demande->id_demande }}</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg transition-colors border border-white/30 backdrop-blur-sm text-sm font-bold">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Retour à la liste
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left Column: Student & Request Info -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Request Identity Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/20">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 flex items-center">
                                <span class="bg-blue-100 dark:bg-blue-900/40 p-2 rounded-lg mr-3">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </span>
                                Informations sur la Demande
                            </h3>
                        </div>
                        <div class="p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Type de Document</p>
                                    <p class="text-xl font-extrabold text-blue-700 dark:text-blue-400">{{ $demande->document->type_document }}</p>
                                    <p class="text-sm text-gray-500 mt-1 italic">{{ $demande->document->description }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Date de Soumission</p>
                                    <p class="text-lg font-bold text-gray-800 dark:text-gray-100">{{ $demande->date_demande->format('d/m/Y') }} à {{ $demande->date_demande->format('H:i') }}</p>
                                </div>
                                <div class="md:col-span-2 pt-4 border-t dark:border-gray-700">
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Commentaires de l'étudiant</p>
                                    <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700 text-gray-700 dark:text-gray-300 italic">
                                        {{ $demande->remarque_admin ? '"'.$demande->remarque_admin.'"' : 'Aucun commentaire fourni par l\'étudiant.' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Student Profile Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/20">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 flex items-center">
                                <span class="bg-green-100 dark:bg-green-900/40 p-2 rounded-lg mr-3">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </span>
                                Profil Étudiant
                            </h3>
                        </div>
                        <div class="p-8 flex flex-col md:flex-row gap-8 items-center md:items-start text-center md:text-left">
                            <div class="w-32 h-32 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center text-white text-4xl font-black shadow-lg shadow-blue-200 dark:shadow-none">
                                {{ substr($demande->etudiant?->prenom ?? 'U', 0, 1) }}{{ substr($demande->etudiant?->nom ?? 'N', 0, 1) }}
                            </div>
                            <div class="flex-1 space-y-4 w-full">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Nom Complet</p>
                                        <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $demande->etudiant?->prenom ?? '' }} {{ $demande->etudiant?->nom ?? 'Étudiant Inconnu' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Matricule</p>
                                        <p class="text-lg font-mono font-bold text-blue-600 dark:text-blue-400 uppercase">{{ $demande->etudiant?->matricule ?? $demande->matricule }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Filière</p>
                                        <p class="text-md font-semibold text-gray-700 dark:text-gray-300">{{ $demande->etudiant?->filiere ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Niveau / Année</p>
                                        <p class="text-md font-semibold text-gray-700 dark:text-gray-300">{{ $demande->etudiant?->annee ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Decision Panel -->
                <div class="lg:col-span-1">
                    <div class="sticky top-6 space-y-6">
                        @if($demande->statut === 'EN_ATTENTE')
                            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border-2 border-blue-500 overflow-hidden">
                                <div class="p-6 bg-blue-500 text-white">
                                    <h3 class="text-lg font-bold flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Action Administrative
                                    </h3>
                                    <p class="text-blue-100 text-xs mt-1">Prenez une décision sur cette demande.</p>
                                </div>
                                <div class="p-6">
                                    <form action="{{ route('admin.demandes.updateStatus', $demande) }}" method="POST" class="space-y-6">
                                        @csrf
                                        @method('PUT')
                                        
                                        <div>
                                            <label for="remarque_admin" class="block mb-2 text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-widest">Remarque / Justification</label>
                                            <textarea id="remarque_admin" name="remarque_admin" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all shadow-sm" placeholder="Obligatoire en cas de rejet..."></textarea>
                                            @error('remarque_admin')
                                                <p class="mt-2 text-sm text-red-600 font-bold">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="grid grid-cols-1 gap-3">
                                            <button type="submit" name="statut" value="ACCEPTEE" class="w-full flex items-center justify-center px-6 py-4 bg-green-600 hover:bg-green-700 text-white rounded-xl font-black uppercase tracking-widest transition-all transform hover:scale-105 shadow-lg shadow-green-100 dark:shadow-none">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                Accepter la demande
                                            </button>
                                            
                                            <button type="submit" name="statut" value="REJETEE" class="w-full flex items-center justify-center px-6 py-4 bg-white border-2 border-red-600 text-red-600 hover:bg-red-50 rounded-xl font-black uppercase tracking-widest transition-all transform hover:scale-105">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                Rejeter la demande
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 p-8 text-center">
                                <div class="mb-4 inline-flex items-center justify-center w-16 h-16 rounded-full {{ $demande->statut === 'ACCEPTEE' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                    @if($demande->statut === 'ACCEPTEE')
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    @else
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    @endif
                                </div>
                                <h3 class="text-xl font-black uppercase tracking-tighter mb-2 {{ $demande->statut === 'ACCEPTEE' ? 'text-green-700' : 'text-red-700' }}">
                                    Demande {{ $demande->statut === 'ACCEPTEE' ? 'Acceptée' : 'Rejetée' }}
                                </h3>
                                <p class="text-sm text-gray-500 mb-6">Traitée par {{ $demande->admin?->prenom ?? 'Admin' }} {{ $demande->admin?->nom ?? '' }} le {{ $demande->updated_at ? $demande->updated_at->format('d/m/Y') : '' }}</p>
                                
                                @if($demande->remarque_admin)
                                    <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl text-left border border-gray-100 dark:border-gray-700">
                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 text-center">Remarque administrative</p>
                                        <p class="text-gray-700 dark:text-gray-300 text-sm italic py-2">"{{ $demande->remarque_admin }}"</p>
                                    </div>
                                @endif
                                
                                <div class="mt-8 pt-6 border-t dark:border-gray-700">
                                    <p class="text-xs text-gray-400">Cette décision a été notifiée à l'étudiant.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
