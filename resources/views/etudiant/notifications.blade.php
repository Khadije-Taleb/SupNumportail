<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Notifications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @forelse($notifications as $notification)
                        <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-700 dark:text-blue-400 border border-blue-200 dark:border-blue-600 {{ $notification->lu ? 'opacity-60' : '' }}" role="alert">
                            <span class="font-medium">{{ $notification->date_notification->format('d/m/Y H:i') }}</span> - {{ $notification->message }}
                            @if(!$notification->lu)
                                <form action="{{ route('etudiant.notifications.markAsRead', $notification) }}" method="POST" class="float-right">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-xs underline hover:text-blue-600 transition-colors">Marquer comme lue</button>
                                </form>
                            @endif
                        </div>
                    @empty
                        <p class="text-center text-gray-500">Aucune notification.</p>
                    @endforelse

                    <div class="mt-4">
                        {{ $notifications->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
