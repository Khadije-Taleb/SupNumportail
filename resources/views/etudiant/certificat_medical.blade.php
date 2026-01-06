<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Certificat Médical') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ showModal: false, imageUrl: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Upload Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">Déposer un nouveau certificat</h3>
                    
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                            {{ session('success') }}
                        </div>
                    @endif

                     @if($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('etudiant.certificats.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="annee">Année</label>
                                <select name="annee" id="annee" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="L1">L1</option>
                                    <option value="L2">L2</option>
                                    <option value="L3">L3</option>
                                    <option value="M1">M1</option>
                                    <option value="M2">M2</option>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="type_evaluation">Type d'évaluation</label>
                                <select name="type_evaluation" id="type_evaluation" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="devoir">Devoir</option>
                                    <option value="examen">Examen</option>
                                    <option value="examen_pratique">Examen Pratique</option>
                                    <option value="tp">TP</option>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="matiere">Matière</label>
                                <input type="text" name="matiere" id="matiere" required placeholder="Ex: Mathématiques" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            </div>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="date_evaluation">Date de l'évaluation</label>
                            <input type="date" name="date_evaluation" id="date_evaluation" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="fichier">Certificat médical (PDF, JPG, PNG)</label>
                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="fichier" name="fichier" type="file" required>
                        </div>
                        
                        <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-md transition-all">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                {{ __('Envoyer le certificat') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- History Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">Historique des certificats</h3>
                    <div class="overflow-x-auto relative">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="py-3 px-6">Date Evaluation</th>
                                    <th scope="col" class="py-3 px-6">Type / Matière</th>
                                    <th scope="col" class="py-3 px-6">Pièce Jointe</th>
                                    <th scope="col" class="py-3 px-6">Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($certificats as $certificat)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="py-4 px-6 font-semibold">{{ $certificat->date_evaluation->format('d/m/Y') }}</td>
                                        <td class="py-4 px-6">
                                            <span class="font-medium text-gray-900 dark:text-white text-xs uppercase">{{ $certificat->type_evaluation }}</span>
                                            <div class="text-[0.65rem] font-bold text-blue-600 uppercase">{{ $certificat->matiere }}</div>
                                            <div class="text-[0.6rem] text-gray-500 uppercase">{{ $certificat->annee }}</div>
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="flex items-center gap-3">
                                                <div @click="imageUrl = '{{ asset('storage/' . $certificat->fichier) }}'; showModal = true" class="cursor-pointer group relative">
                                                    <img src="{{ asset('storage/' . $certificat->fichier) }}" class="h-10 w-10 object-cover rounded border border-gray-200 shadow-sm group-hover:opacity-75 transition-opacity" alt="Thumb">
                                                </div>
                                                <button @click="imageUrl = '{{ asset('storage/' . $certificat->fichier) }}'; showModal = true" class="text-blue-600 hover:underline text-xs font-bold flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                    Aperçu
                                                </button>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6">
                                             <span class="px-2 py-1 font-semibold leading-tight rounded-full text-[0.65rem] uppercase
                                                 {{ $certificat->statut === 'ACCEPTEE' ? 'text-green-700 bg-green-100 dark:bg-green-700/50 dark:text-green-100' : '' }}
                                                 {{ $certificat->statut === 'REJETEE' ? 'text-red-700 bg-red-100 dark:bg-red-700/50 dark:text-red-100' : '' }}
                                                 {{ $certificat->statut === 'EN_ATTENTE' ? 'text-yellow-700 bg-yellow-100 dark:bg-yellow-700/50 dark:text-yellow-100' : '' }}">
                                                {{ str_replace('_', ' ', $certificat->statut) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-4 px-6 font-italic text-center text-gray-500">Aucun certificat déposé.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Image Preview Modal -->
        <div x-show="showModal" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;"
             @keydown.escape.window="showModal = false"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" @click="showModal = false">
                    <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-90 backdrop-blur-sm"></div>
                </div>

                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full border border-gray-200 dark:border-gray-700">
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-8 sm:pb-4">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                                Visualisation du Certificat
                            </h3>
                            <button @click="showModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="mt-2 text-center bg-gray-100 dark:bg-gray-900 rounded-lg p-2">
                            <img :src="imageUrl" class="max-w-full max-h-[70vh] rounded shadow-inner mx-auto" alt="Certificat">
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700/50 px-4 py-3 sm:px-6 flex justify-end">
                        <button type="button" @click="showModal = false" class="inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-5 py-2.5 bg-white text-sm font-bold text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors">
                            Fermer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
