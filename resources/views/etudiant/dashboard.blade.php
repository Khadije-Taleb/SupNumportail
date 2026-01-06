<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Étudiant') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Welcome Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold">Bienvenue, {{ $user->full_name }} !</h3>
                        @if($etudiant)
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                Matricule: {{ $etudiant->matricule }} | Filière: {{ $etudiant->filiere }} | Année: {{ $etudiant->annee }}
                            </p>
                        @endif
                    </div>
                    @if($etudiant)
                        <a href="{{ route('etudiant.certificats.index') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-500 to-pink-600 text-white border border-transparent rounded-lg font-semibold text-xs uppercase tracking-widest hover:from-red-600 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            {{ __('Déposer Certificat') }}
                        </a>
                    @endif
                </div>
                @if(!$etudiant)
                    <div class="px-6 pb-6">
                        <div class="p-4 bg-yellow-100 dark:bg-yellow-900 border-l-4 border-yellow-500 text-yellow-700 dark:text-yellow-300 rounded">
                            <p>Votre profil étudiant n'est pas encore complet. <a href="{{ route('etudiant.profil') }}" class="underline font-bold">Complétez-le ici</a>.</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Total -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Demandes</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['total'] }}</div>
                </div>

                <!-- En attente -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">En attente</div>
                    <div class="mt-2 text-3xl font-bold text-yellow-600 dark:text-yellow-400">{{ $stats['en_attente'] }}</div>
                </div>

                <!-- Acceptées -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Acceptées</div>
                    <div class="mt-2 text-3xl font-bold text-green-600 dark:text-green-400">{{ $stats['acceptees'] }}</div>
                </div>

                <!-- Rejetées -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-red-500">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Rejetées</div>
                    <div class="mt-2 text-3xl font-bold text-red-600 dark:text-red-400">{{ $stats['rejetees'] }}</div>
                </div>
            </div>

            <!-- Notifications Preview -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Dernières Notifications</h3>
                        <a href="{{ route('etudiant.notifications.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">Voir tout</a>
                    </div>
                    
                    @if($notifications->count() > 0)
                        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($notifications as $notification)
                                <li class="py-3 {{ $notification->lu ? 'opacity-50' : '' }}">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $notification->message }}</p>
                                            <p class="text-xs text-gray-500">{{ $notification->date_notification->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm text-gray-500 text-center py-4">Aucune nouvelle notification.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
