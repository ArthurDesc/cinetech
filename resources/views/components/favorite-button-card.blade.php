@props(['tmdbId', 'type'])

@auth
    <button
        x-data="{ isFavorite: false }"
        x-init="
            fetch('{{ route('favorites.check') }}?tmdb_id={{ $tmdbId }}&type={{ $type }}')
                .then(response => response.json())
                .then(data => isFavorite = data.isFavorite)
        "
        @click.stop="
            fetch('{{ route('favorites.toggle') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    tmdb_id: {{ $tmdbId }},
                    type: '{{ $type }}'
                })
            })
            .then(response => response.json())
            .then(data => {
                isFavorite = data.status === 'added';
            });
        "
        class="absolute bottom-2 right-2 p-2 rounded-full bg-dark-lighter hover:bg-dark-light transition-colors duration-200"
    >
        <svg xmlns="http://www.w3.org/2000/svg"
             class="h-5 w-5 transition-colors duration-200"
             :class="isFavorite ? 'text-primary-500' : 'text-white'"
             :fill="isFavorite ? 'currentColor' : 'none'"
             viewBox="0 0 24 24"
             stroke="currentColor">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
        </svg>
    </button>
@else
    <a href="{{ route('login') }}"
       @click.stop
       class="absolute bottom-2 right-2 p-2 rounded-full bg-dark-lighter hover:bg-dark-light transition-colors duration-200">
        <svg xmlns="http://www.w3.org/2000/svg"
             class="h-5 w-5 text-white"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
        </svg>
    </a>
@endauth
