<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-blue-700 to-indigo-600 py-6 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-2xl text-white leading-tight">
                        Détails du Certificat Médical
                    </h2>
                    <p class="text-blue-100 text-sm mt-1">Examen approfondi du justificatif soumis par l'étudiant.</p>
                </div>
                <a href="{{ route('admin.certificats.index') }}" class="inline-flex items-center px-4 py-2 border border-blue-200 text-sm font-semibold rounded-lg text-white hover:bg-white hover:text-blue-700 transition-all">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Retour à la liste
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left Column: Student & Context Info -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Student Info Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Informations Étudiant
                            </h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-xs font-bold text-gray-500 uppercase">Nom Complet</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $certificat->etudiant?->prenom ?? '' }} {{ $certificat->etudiant?->nom ?? 'Étudiant Inconnu' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-500 uppercase">Matricule</p>
                                    <p class="font-mono text-blue-600 dark:text-blue-400 font-bold bg-blue-50 dark:bg-blue-900/30 px-2 py-1 rounded inline-block mt-1">{{ $certificat->etudiant_matricule }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-500 uppercase">Année Académique</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $certificat->annee }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Academic Context Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Contexte de l'Absence
                            </h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-xs font-bold text-gray-500 uppercase">Type d'Évaluation</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100 uppercase">{{ str_replace('_', ' ', $certificat->type_evaluation) }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-500 uppercase">Matière</p>
                                    <p class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $certificat->matiere }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-500 uppercase">Date de l'Évaluation</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $certificat->date_evaluation->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-500 uppercase">Date de Dépôt</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 italic">Le {{ $certificat->date_upload->format('d/m/Y à H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Card (if EN_ATTENTE) -->
                    @if($certificat->statut === 'EN_ATTENTE')
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border-2 border-blue-500 overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                Decision Administrative
                            </h3>
                            <form action="{{ route('admin.certificats.updateStatus', $certificat) }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PUT')
                                
                                <div>
                                    <label for="remarque_admin" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Remarque Administrative</label>
                                    <textarea name="remarque_admin" id="remarque_admin" rows="4" 
                                        class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all"
                                        placeholder="Optionnel pour acceptation, OBLIGATOIRE pour refus (min 5 chars)..."></textarea>
                                    @error('remarque_admin')
                                        <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <button type="submit" name="statut" value="VALIDE" 
                                        class="flex items-center justify-center px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg transition-all shadow-md active:scale-95">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Accepter
                                    </button>
                                    <button type="submit" name="statut" value="REFUSE" 
                                        class="flex items-center justify-center px-4 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg transition-all shadow-md active:scale-95">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        Rejeter
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @else
                    <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-6 border border-dashed border-gray-300 dark:border-gray-700">
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full mb-4
                                {{ $certificat->statut === 'VALIDE' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                @if($certificat->statut === 'VALIDE')
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                @else
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                @endif
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Dossier Traité: {{ $certificat->statut }}</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 italic">
                                "{{ $certificat->remarque_admin ?: 'Aucune remarque fournie.' }}"
                            </p>
                            @if($certificat->admin)
                                <p class="mt-4 text-xs text-gray-500 font-semibold uppercase tracking-widest">
                                    Traité par: {{ $certificat->admin?->prenom ?? 'Admin' }} {{ $certificat->admin?->nom ?? '' }}
                                </p>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Right Column: Certificate Preview -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden sticky top-6">
                        <div class="p-4 border-b dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-900/50">
                            <h3 class="font-bold text-gray-900 dark:text-white flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Visualisation du Document
                            </h3>
                            <a href="{{ route('admin.certificats.viewFile', $certificat) }}" target="_blank" class="text-xs font-bold text-blue-600 hover:underline flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                Ouvrir dans un nouvel onglet
                            </a>
                        </div>
                        <div class="p-4 bg-gray-200 dark:bg-gray-900 min-h-[500px] flex items-center justify-center">
                            @php
                                $extension = pathinfo($certificat->fichier, PATHINFO_EXTENSION);
                                $isPdf = strtolower($extension) === 'pdf';
                            @endphp

                            @if($isPdf)
                                <object data="{{ route('admin.certificats.viewFile', $certificat) }}" type="application/pdf" class="w-full h-[700px] rounded shadow-inner">
                                    <div class="flex flex-col items-center justify-center p-12 bg-white dark:bg-gray-800 rounded-lg shadow text-center">
                                        <svg class="w-16 h-16 text-red-500 mb-4" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h4.586A1 1 0 0111 2.414l4.586 4.586a1 1 0 01.293.707V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/></svg>
                                        <p class="text-gray-700 dark:text-gray-300 font-bold mb-4">Le navigateur ne peut pas afficher ce PDF directement.</p>
                                        <a href="{{ route('admin.certificats.viewFile', $certificat) }}" download class="px-6 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                                            Télécharger le PDF
                                        </a>
                                    </div>
                                </object>
                            @else
                                <img src="{{ route('admin.certificats.viewFile', $certificat) }}" class="max-w-full h-auto rounded shadow-lg border-4 border-white dark:border-gray-700" alt="Certificat">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
