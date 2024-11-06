@props(['currentPage', 'totalPages', 'route'])

<div class="mt-6 flex justify-center items-center gap-4">
    @if($currentPage > 1)
        <a href="{{ route($route, ['page' => $currentPage - 1]) }}"
           class="px-4 py-2 bg-dark-light rounded-lg text-gray-400 hover:text-primary-500 transition">
            Page précédente
        </a>
    @endif

    <span class="text-gray-400">
        Page {{ $currentPage }} sur {{ $totalPages }}
    </span>

    @if($currentPage < $totalPages)
        <a href="{{ route($route, ['page' => $currentPage + 1]) }}"
           class="px-4 py-2 bg-dark-light rounded-lg text-gray-400 hover:text-primary-500 transition">
            Page suivante
        </a>
    @endif
</div>

