@props(['movie'])

<div class="movie-card bg-white dark:bg-gray-800 rounded-lg shadow-lg transition duration-300 hover:scale-105">
    <a href="{{ route('movies.show', $movie['id']) }}" class="block">
        <img src="{{ config('services.tmdb.image_base_url') . $movie['poster_path'] }}"
             alt="{{ $movie['title'] }}"
             loading="lazy"
             class="w-full h-auto rounded-t-lg">
        <div class="p-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                {{ $movie['title'] }}
            </h3>
            <span class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                Voir plus
            </span>
        </div>
    </a>
</div>
