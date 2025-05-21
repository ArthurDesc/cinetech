<div class="mt-8">
    <h2 class="text-xl font-semibold text-white mb-4">Acteurs principaux</h2>
    <ul class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @foreach(array_slice($movie['credits']['cast'], 0, 5) as $actor)
            <li class="text-center bg-dark-light rounded-lg p-3 shadow-md hover:bg-dark-lighter transition duration-200 flex flex-col items-center">
                {{-- Conteneur d'image rond et centré --}}
                <div class="w-20 h-20 rounded-full overflow-hidden mb-2">
                    <img src="{{ $actor['profile_path']
                               ? config('services.tmdb.image_base_url') . $actor['profile_path']
                               : asset('images/placeholder-actor.jpg') }}"
                         alt="Photo de {{ $actor['name'] }}"
                         loading="lazy"
                         class="w-full h-full object-cover object-center">
                </div>

                {{-- Texte centré sous l'image --}}
                <p class="text-gray-200 text-sm font-medium truncate mb-1">{{ $actor['name'] }}</p>
                <p class="text-gray-400 text-xs truncate">{{ $actor['character'] }}</p>
            </li>
        @endforeach
    </ul>
</div> 