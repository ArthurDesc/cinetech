<x-app-layout>
    <div class="container mx-auto px-4 py-8 bg-dark">
        {{-- Détails de la série --}}
        <div class="flex flex-col md:flex-row gap-8">
            {{-- Poster de la série --}}
            <div class="w-full md:w-1/3">
                <img src="{{ config('services.tmdb.image_base_url') . $show['poster_path'] }}"
                     alt="{{ $show['name'] }}"
                     class="w-full rounded-lg shadow-lg">
            </div>

            {{-- Informations de la série --}}
            <div class="w-full md:w-2/3">
                <h1 class="text-3xl font-bold mb-4 text-white">
                    {{ $show['name'] }}
                </h1>
                <p class="text-gray-400 mb-4">
                    {{ $show['overview'] }}
                </p>

                {{-- Informations supplémentaires --}}
                <div class="mb-4 space-y-2">
                    <p class="text-gray-300">
                        Première diffusion : <span class="text-primary-500">{{ $show['first_air_date'] }}</span>
                    </p>
                    <p class="text-gray-300">
                        Note : <span class="text-primary-500">{{ $show['vote_average'] }}/10</span>
                    </p>
                    <p class="text-gray-300">
                        Nombre de saisons : <span class="text-primary-500">{{ $show['number_of_seasons'] }}</span>
                    </p>
                </div>

            
            </div>
        </div>
    </div>
</x-app-layout>
