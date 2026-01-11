<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Détails du certificat médical') }} #{{ $certificat->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Info Section -->
                <div class="md:col-span-1 space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-bold mb-4">Informations Étudiant</h3>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs uppercase text-gray-500 font-semibold">Nom & Prénom</p>
                                    <p class="font-medium">{{ $certificat->etudiant->nom ?? '' }} {{ $certificat->etudiant->prenom ?? '' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase text-gray-500 font-semibold">Matricule</p>
                                    <p class="font-medium">{{ $certificat->etudiant->matricule ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-bold mb-4">Contexte de l'absence</h3>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs uppercase text-gray-500 font-semibold">Matière</p>
                                    <p class="font-medium">{{ $certificat->matiere }}</p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase text-gray-500 font-semibold">Type d'évaluation</p>
                                    <p class="font-medium">{{ $certificat->type_evaluation }}</p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase text-gray-500 font-semibold">Date de l'absence</p>
                                    <p class="font-medium">{{ $certificat->date_absence ? $certificat->date_absence->format('d/m/Y') : 'Non renseignée' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-bold mb-4">Décision</h3>
                            <form action="{{ route('admin.certificats.updateStatus', $certificat) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-4">
                                    <x-input-label for="statut" :value="__('Statut')" />
                                    <select name="statut" id="statut" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="VALIDE" {{ $certificat->statut == 'VALIDE' ? 'selected' : '' }}>Accepter</option>
                                        <option value="REFUSE" {{ $certificat->statut == 'REFUSE' ? 'selected' : '' }}>Refuser</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="remarque_admin" :value="__('Remarque')" />
                                    <textarea name="remarque_admin" id="remarque_admin" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ $certificat->remarque_admin }}</textarea>
                                </div>
                                <x-primary-button class="w-full justify-center">
                                    {{ __('Enregistrer') }}
                                </x-primary-button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Preview Section -->
                <div class="md:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full">
                        <div class="p-6 h-full flex flex-col">
                            <h3 class="text-lg font-bold mb-4">Aperçu du certificat</h3>
                            <div class="flex-grow bg-gray-100 rounded border flex items-center justify-center overflow-hidden">
                                @php
                                    $extension = pathinfo($certificat->photo_certificat, PATHINFO_EXTENSION);
                                    $isPdf = strtolower($extension) === 'pdf';
                                @endphp

                                @if($isPdf)
                                    <object data="{{ route('admin.certificats.viewFile', $certificat) }}" type="application/pdf" class="w-full h-[600px]">
                                        <p>Votre navigateur ne peut pas afficher ce PDF. <a href="{{ route('admin.certificats.viewFile', $certificat) }}">Télécharger le fichier</a></p>
                                    </object>
                                @else
                                    <img src="{{ route('admin.certificats.viewFile', $certificat) }}" class="max-w-full max-h-full" alt="Certificat">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
