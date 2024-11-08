<x-app-layout>
    <div class="container mx-auto px-4 py-8 min-h-screen">
        <h2 class="text-2xl font-bold mb-4 text-white">Séries TV</h2>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach($shows as $show)
                <x-tv-shows.show-card :show="$show" />
            @endforeach
        </div>

        <x-pagination
            :currentPage="$currentPage"
            :totalPages="$totalPages"
            route="tvshows.index"
        />
    </div>
</x-app-layout>
