@props(['show'])

<div class="movie-card bg-white dark:bg-gray-800 rounded-lg shadow-lg transition duration-300 hover:scale-105">
    <a href="{{ route('tvshows.show', $show['id']) }}" class="block">
        <div class="relative aspect-[2/3]">
            {{-- Placeholder pendant le chargement --}}
            <div class="absolute inset-0 bg-gray-200 dark:bg-gray-700 animate-pulse rounded-t-lg"></div>

            <img src="{{ config('services.tmdb.image_base_url') . $show['poster_path'] }}"
                 alt="{{ $show['name'] }}"
                 loading="lazy"
                 class="w-full h-full object-cover rounded-t-lg relative z-10 transition-opacity duration-300"
                 onload="this.parentElement.querySelector('div').remove(); this.style.opacity = 1;"
                 style="opacity: 0">
        </div>
        <div class="p-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                {{ $show['name'] }}
            </h3>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600 dark:text-gray-400">
                    {{ $show['first_air_date'] }}
                </span>
                <span class="text-sm text-gray-600 dark:text-gray-400">
                    {{ $show['vote_average'] }}/10
                </span>
            </div>
            <span class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white mt-2 block">
                Voir plus
            </span>
        </div>
    </a>
</div>
