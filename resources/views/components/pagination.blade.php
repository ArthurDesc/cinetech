@props(['currentPage', 'totalPages', 'route'])

<div class="mt-6 flex flex-wrap justify-center items-center gap-4 px-4">
    @if($currentPage > 1)
        <a href="{{ route($route, ['page' => $currentPage - 1]) }}"
           class="flex items-center px-3 sm:px-4 py-2 bg-dark-light rounded-lg text-gray-400 hover:text-primary-500 transition">
            <svg class="w-5 h-5 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            <span class="text-sm sm:text-base">Précédent</span>
        </a>
    @endif

    <div class="flex items-center">
        <span class="hidden sm:inline text-gray-400 text-sm sm:text-base">Page</span>
        <span class="mx-2 px-3 py-1 bg-dark rounded-lg text-primary-500 font-medium text-sm sm:text-base">
            {{ $currentPage }}
        </span>
        <span class="text-gray-400 text-sm sm:text-base">sur {{ $totalPages }}</span>
    </div>

    @if($currentPage < $totalPages)
        <a href="{{ route($route, ['page' => $currentPage + 1]) }}"
           class="flex items-center px-3 sm:px-4 py-2 bg-dark-light rounded-lg text-gray-400 hover:text-primary-500 transition">
            <span class="text-sm sm:text-base">Suivant</span>
            <svg class="w-5 h-5 ml-1 sm:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    @endif
</div>

