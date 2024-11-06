@props(['tmdbId', 'type'])

@auth
    <button
        x-data="{ isFavorite: false }"
        x-init="
            fetch('{{ route('favorites.check') }}?tmdb_id={{ $tmdbId }}&type={{ $type }}')
                .then(response => response.json())
                .then(data => isFavorite = data.isFavorite)
        "
        @click="
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
        {{ $attributes->merge(['class' => 'w-full flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-dark-lighter hover:bg-dark-light transition-colors duration-200']) }}
    >
        <svg xmlns="http://www.w3.org/2000/svg"
             class="h-6 w-6 transition-colors duration-200"
             :class="isFavorite ? 'text-primary-500' : 'text-gray-400'"
             :fill="isFavorite ? 'currentColor' : 'none'"
             viewBox="0 0 24 24"
             stroke="currentColor">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
        </svg>
        <span class="text-gray-400" x-text="isFavorite ? 'Retirer des favoris' : 'Ajouter aux favoris'"></span>
    </button>
@else
    <a href="{{ route('login') }}"
       {{ $attributes->merge(['class' => 'w-full flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-dark-lighter hover:bg-dark-light transition-colors duration-200']) }}>
        <svg xmlns="http://www.w3.org/2000/svg"
             class="h-6 w-6 text-gray-400"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M11 11V9a3 3 0 00-3-3m0 0V5a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2h14a2 2 0 012 2z" />
        </svg>
        <span class="text-gray-400">Se connecter</span>
    </a>
@endauth 
