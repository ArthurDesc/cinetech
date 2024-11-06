<x-app-layout>
    <div class="container mx-auto px-4 py-8 bg-gradient-dark min-h-screen">
        <h2 class="text-2xl font-bold mb-4 text-white">Films</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($movies as $movie)
                <x-movie-card :movie="$movie" />
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-6 flex justify-center items-center gap-4">
            @if($currentPage > 1)
                <a href="{{ route('movies.index', ['page' => $currentPage - 1]) }}"
                   class="px-4 py-2 bg-dark-light rounded-lg text-gray-400 hover:text-primary-500 transition">
                    Page précédente
                </a>
            @endif

            <span class="text-gray-400">
                Page {{ $currentPage }} sur {{ $totalPages }}
            </span>

            @if($currentPage < $totalPages)
                <a href="{{ route('movies.index', ['page' => $currentPage + 1]) }}"
                   class="px-4 py-2 bg-dark-light rounded-lg text-gray-400 hover:text-primary-500 transition">
                    Page suivante
                </a>
            @endif
        </div>
    </div>
</x-app-layout>
