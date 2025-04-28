@props(['show'])

<div class="movie-card bg-dark-light rounded-lg shadow-lg transition duration-300 hover:scale-105 relative">
    <a href="{{ route('tvshows.show', $show['id']) }}" class="block">
        <div class="relative aspect-[2/3]">
            {{-- Placeholder pendant le chargement --}}
            <div class="absolute inset-0 bg-dark-lighter animate-pulse rounded-t-lg"></div>

            <img src="{{ config('services.tmdb.image_base_url') . $show['poster_path'] }}"
                 alt="{{ $show['name'] }}"
                 loading="lazy"
                 class="w-full h-full object-cover rounded-t-lg relative z-10 transition-opacity duration-300"
                 onload="this.parentElement.querySelector('div').remove(); this.style.opacity = 1;"
                 style="opacity: 0">
        </div>
        <div class="p-4">
            <h3 class="text-lg font-semibold text-white mb-2">
                {{ $show['name'] }}
            </h3>
           
            <span class="text-primary-500 hover:text-primary-400 mt-2 block">
                Voir plus
            </span>
        </div>
    </a>


</div>
