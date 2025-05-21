<x-app-layout>
    <div class="container mx-auto px-4 py-8 md:py-12">
        {{-- Section Principale Détails du film --}}
        <section class="flex flex-col md:flex-row gap-8 lg:gap-12 mb-12">
            {{-- Colonne Gauche (Poster) --}}
            <div class="w-full md:w-1/3 lg:w-1/4 flex-shrink-0">
                <img src="{{ config('services.tmdb.image_base_url') . $movie['poster_path'] }}"
                     alt="Poster du film {{ $movie['title'] }}"
                     class="w-full h-auto rounded-lg shadow-lg object-cover">
            </div>

            {{-- Colonne Droite (Informations et Listes) --}}
            <div class="w-full md:w-2/3 lg:w-3/4">
                {{-- Titre et Aperçu --}}
                <article class="mb-8">
                    <h1 class="text-3xl md:text-4xl font-bold mb-4 text-white tracking-wide">
                        {{ $movie['title'] }}
                    </h1>
                    <p class="text-gray-300 text-lg leading-relaxed">
                        {{ $movie['overview'] }}
                    </p>
                </article>

                {{-- Informations supplémentaires (Component) --}}
                <section class="mb-8">
                    <h2 class="text-xl font-semibold text-white mb-4">Informations</h2>
                    <x-movie-info-details :movie="$movie" />
                </section>

                {{-- Acteurs principaux (Component) --}}
                <section class="mt-8 mb-8">
                     <x-cast-list :movie="$movie" />
                </section>

                {{-- Films similaires --}}
                <section>
                    <h2 class="text-xl font-semibold text-white mb-4">Films similaires</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach(array_slice($movie['similar']['results'], 0, 4) as $similar)
                            <x-movie-card :movie="$similar" />
                        @endforeach
                    </div>
                </section>


            </div>
        </section>

        {{-- Section Commentaires (Component) --}}
        <section>
             <x-comments :tmdb-id="$movie['id']" type="movie" />
        </section>
    </div>
</x-app-layout>
