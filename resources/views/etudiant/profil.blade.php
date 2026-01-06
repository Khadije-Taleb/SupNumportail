<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profil Étudiant') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Information Personnelle -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informations Personnelles</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <x-input-label value="Nom" />
                            <x-text-input class="mt-1 block w-full bg-gray-100" value="{{ $user->full_name }}" disabled />
                        </div>
                        <div>
                            <x-input-label value="Email" />
                            <x-text-input class="mt-1 block w-full bg-gray-100" value="{{ $user->email }}" disabled />
                        </div>
                        
                        @if($user->etudiant)
                            <div>
                                <x-input-label value="Matricule" />
                                <x-text-input class="mt-1 block w-full bg-gray-100" value="{{ $user->etudiant->matricule }}" disabled />
                            </div>
                            <div>
                                <x-input-label value="Filière" />
                                <x-text-input class="mt-1 block w-full bg-gray-100" value="{{ $user->etudiant->filiere }}" disabled />
                            </div>
                            <div>
                                <x-input-label value="Année" />
                                <x-text-input class="mt-1 block w-full bg-gray-100" value="{{ $user->etudiant->annee }}" disabled />
                            </div>
                        @else
                           <div class="mt-4 p-4 bg-yellow-100 text-yellow-700 rounded-lg">
                                Profil étudiant incomplet. Veuillez contacter l'administration.
                           </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Update Password (using Breeze partial) -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
