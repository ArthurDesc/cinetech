@props(['movie'])

<div class="bg-dark-light rounded-lg shadow-lg transition duration-300 hover:scale-105 relative flex flex-col h-full">
    <a href="{{ route('movies.show', $movie['id']) }}" class="block h-full flex flex-col">
        <div class="relative aspect-[2/3] flex-shrink-0">
            <div class="absolute inset-0 bg-gray-200 dark:bg-gray-700 animate-pulse rounded-t-lg" style="opacity: 1;"></div>
            <img src="{{ config('services.tmdb.image_base_url') . $movie['poster_path'] }}"
                 alt="{{ $movie['title'] }}"
                 loading="lazy"
                 class="w-full h-full object-cover rounded-t-lg relative z-10 transition-opacity duration-300"
                 onload="this.parentElement.querySelector('div').remove(); this.style.opacity = 1;"
                 onerror="this.onerror=null; this.src='{{ asset('images/placeholder-poster.jpg') }}'; this.style.opacity=1; this.parentElement.querySelector('div').remove();"
                 style="opacity: 0;">
        </div>
        <div class="p-4 flex flex-col flex-grow justify-between">
            <div>
                <h3 class="text-lg font-semibold text-white mb-2 truncate">
                    {{ $movie['title'] }}
                </h3>
            </div>
            <span class="text-primary-500 hover:text-primary-400 text-sm mt-auto">
                Voir plus
            </span>
        </div>
    </a>
</div>
