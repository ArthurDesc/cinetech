<x-app-layout>
    <div class="container mx-auto px-4 py-8 min-h-screen">
        {{-- Barre de recherche --}}
        <div class="mb-8">
            <form action="{{ route('search') }}" method="GET" class="flex gap-4">
                <input type="text"
                       name="query"
                       value="{{ request('query') }}"
                       placeholder="Rechercher un film ou une série..."
                       class="flex-1 px-4 py-2 rounded-lg bg-dark-light text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500">

                <button type="submit"
                        class="px-6 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition">
                    Rechercher
                </button>
            </form>
        </div>

        @if(request('query'))
            {{-- Résultats --}}
            <h2 class="text-2xl font-bold mb-4 text-white">
                Résultats pour "{{ request('query') }}"
            </h2>

            {{-- Modification du grid pour 2 colonnes en mobile --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                @forelse($results as $result)
                    @if($result['media_type'] === 'movie')
                        <x-movie-card :movie="$result" />
                    @else
                        <x-tv-shows.show-card :show="$result" />
                    @endif
                @empty
                    <p class="text-white col-span-full text-center">
                        Aucun résultat trouvé pour "{{ request('query') }}"
                    </p>
                @endforelse
            </div>

            {{-- Pagination avec le composant --}}
            @if($results->count() > 0)
                <x-pagination
                    :currentPage="$currentPage"
                    :totalPages="$totalPages"
                    route="search"
                    :query="['query' => request('query')]"
                />
            @endif
        @endif
    </div>
</x-app-layout>
