<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Détails de la demande') }} #{{ $demande->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500 mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4 text-blue-800">Informations de l'étudiant</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs uppercase text-gray-500 font-semibold">Nom & Prénom</p>
                            <p class="font-medium">{{ $demande->etudiant->nom ?? '' }} {{ $demande->etudiant->prenom ?? '' }}</p>
                        </div>
                        <div>
                            <p class="text-xs uppercase text-gray-500 font-semibold">Matricule</p>
                            <p class="font-medium">{{ $demande->etudiant->matricule ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs uppercase text-gray-500 font-semibold">Filière</p>
                            <p class="font-medium">{{ $demande->etudiant->filiere ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs uppercase text-gray-500 font-semibold">Email</p>
                            <p class="font-medium">{{ $demande->etudiant->utilisateur->email ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4">Détails de la demande</h3>
                    <div class="mb-4">
                        <p class="text-xs uppercase text-gray-500 font-semibold">Document demandé</p>
                        <p class="font-medium">{{ $demande->document->nom_document ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="text-xs uppercase text-gray-500 font-semibold">Date de soumission</p>
                        <p class="font-medium">{{ $demande->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="text-xs uppercase text-gray-500 font-semibold">Statut actuel</p>
                        <span class="px-3 py-1 inline-flex text-sm font-bold rounded-full 
                            {{ $demande->statut == 'fin' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $demande->statut == 'en_attente' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $demande->statut == 'en_cours_traitement' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $demande->statut == 'rejetee' ? 'bg-red-100 text-red-800' : '' }}
                        ">
                            {{ strtoupper(str_replace('_', ' ', $demande->statut)) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4">Mettre à jour le statut</h3>
                    <form action="{{ route('admin.demandes.updateStatus', $demande->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <x-input-label for="statut" :value="__('Nouveau statut')" />
                            <select name="statut" id="statut" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="en_cours_traitement" {{ $demande->statut == 'en_cours_traitement' ? 'selected' : '' }}>En cours de traitement</option>
                                <option value="fin" {{ $demande->statut == 'fin' ? 'selected' : '' }}>Terminé (Prêt)</option>
                                <option value="rejetee" {{ $demande->statut == 'rejetee' ? 'selected' : '' }}>Rejeter la demande</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="remarque_admin" :value="__('Remarque (obligatoire si rejeté)')" />
                            <textarea name="remarque_admin" id="remarque_admin" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ $demande->remarque_admin }}</textarea>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Enregistrer') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
