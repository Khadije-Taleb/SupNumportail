<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-blue-700 to-indigo-600 py-6 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 shadow-lg">
            <h2 class="font-bold text-2xl text-white leading-tight">
                {{ __('Nouvelle Demande Administrative') }}
            </h2>
            <p class="text-blue-100 text-sm mt-1">Sélectionnez le document que vous souhaitez obtenir auprès de l'administration.</p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    
                    @if(session('success'))
                        <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg shadow-sm" role="alert">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                <span class="font-bold">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('etudiant.demandes.store') }}" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="id_document" class="block mb-2 text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-widest">Type de Document</label>
                            <select id="id_document" name="id_document" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all shadow-sm" required>
                                <option value="" disabled selected>— Choisir parmi les documents disponibles —</option>
                                @foreach($documents as $document)
                                    <option value="{{ $document->id_document }}">{{ $document->type_document }}</option>
                                @endforeach
                            </select>
                            <p class="mt-2 text-xs text-gray-500 italic">Ex: Attestation de scolarité, Relevé de notes, etc.</p>
                            @error('id_document')
                                <p class="mt-2 text-sm text-red-600 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="commentaire" class="block mb-2 text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-widest">Note / Justification (Optionnel)</label>
                            <textarea id="commentaire" name="commentaire" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all shadow-sm" placeholder="Précisez l'année ou tout autre détail pertinent..."></textarea>
                            @error('commentaire')
                                <p class="mt-2 text-sm text-red-600 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-4 flex items-center justify-between border-t dark:border-gray-700">
                             <a href="{{ route('etudiant.dashboard') }}" class="text-sm font-bold text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition-colors flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                                Annuler
                             </a>
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg hover:scale-105 transform">
                                Transmettre la demande
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/></svg>
                            </button>
                        </div>
                    </form>

                </div>
            </div>
            
            <!-- Information Card -->
            <div class="mt-8 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-xl p-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-blue-800 dark:text-blue-300 uppercase tracking-wider">Processus de traitement</h3>
                        <div class="mt-2 text-sm text-blue-700 dark:text-blue-400">
                            <ul class="list-disc pl-5 space-y-1">
                                <li>Votre demande sera examinée par le service administratif.</li>
                                <li>Vous recevrez une notification dès qu'une décision sera prise.</li>
                                <li>Vous pourrez consulter l'état d'avancement dans votre espace personnel.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
