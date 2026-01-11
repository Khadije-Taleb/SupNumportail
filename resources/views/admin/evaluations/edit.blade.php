<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-blue-700 to-indigo-600 py-6 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 shadow-lg">
            <h2 class="font-bold text-2xl text-white leading-tight">{{ __('Modifier l\'évaluation') }}</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 dark:border-gray-700 p-6">
                @if(session('error'))
                    <div class="mb-4 text-red-600">{{ session('error') }}</div>
                @endif

                <form action="{{ route('admin.evaluations.update', $evaluation) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-semibold mb-2">Matière</label>
                        <input type="text" name="matiere" value="{{ old('matiere', $evaluation->matiere) }}" class="w-full border px-3 py-2 rounded" required>
                        @error('matiere') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold mb-2">Type d'évaluation</label>
                        <input type="text" name="type_evaluation" value="{{ old('type_evaluation', $evaluation->type_evaluation) }}" class="w-full border px-3 py-2 rounded" required>
                        @error('type_evaluation') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
                    </div>

                    <div class="flex items-center gap-3">
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded">Enregistrer</button>
                        <a href="{{ route('admin.evaluations.index') }}" class="text-sm text-gray-600 hover:underline">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
