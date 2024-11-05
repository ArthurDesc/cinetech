<x-app-layout>
    <div class="container mx-auto px-4 py-8 bg-dark">
        {{-- Détails du film --}}
        <div class="flex flex-col md:flex-row gap-8">
            {{-- Poster du film --}}
            <div class="w-full md:w-1/3">
                <img src="{{ config('services.tmdb.image_base_url') . $movie['poster_path'] }}"
                     alt="{{ $movie['title'] }}"
                     class="w-full rounded-lg shadow-lg">
            </div>

            {{-- Informations du film --}}
            <div class="w-full md:w-2/3">
                <h1 class="text-3xl font-bold mb-4 text-white">
                    {{ $movie['title'] }}
                </h1>
                <p class="text-gray-400 mb-4">
                    {{ $movie['overview'] }}
                </p>
                
                {{-- Informations supplémentaires --}}
                <div class="mb-4 space-y-2">
                    <p class="text-gray-300">
                        Date de sortie : <span class="text-primary-500">{{ $movie['release_date'] }}</span>
                    </p>
                    <p class="text-gray-300">
                        Note : <span class="text-primary-500">{{ $movie['vote_average'] }}/10</span>
                    </p>
                </div>

                {{-- Si vous avez des boutons ou des actions, vous pouvez les ajouter ici --}}
                <div class="mt-6">
                    <button class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg transition duration-300">
                        Voir la bande annonce
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
