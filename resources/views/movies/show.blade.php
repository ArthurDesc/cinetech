<x-app-layout>
    <div class="container mx-auto px-4 py-8">
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
                <h1 class="text-3xl font-bold mb-4">{{ $movie['title'] }}</h1>
                <p class="text-gray-600 mb-4">{{ $movie['overview'] }}</p>
                
                {{-- Informations supplémentaires --}}
                <div class="mb-4">
                    <p>Date de sortie : {{ $movie['release_date'] }}</p>
                    <p>Note : {{ $movie['vote_average'] }}/10</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
