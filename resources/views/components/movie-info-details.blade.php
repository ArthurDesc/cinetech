<dl class="mb-4 space-y-3 text-gray-300">
    <div class="flex items-start">
        <dt class="w-1/3 font-semibold">Date de sortie :</dt>
        <dd class="w-2/3 text-white">{{ $movie['release_date'] }}</dd>
    </div>
    <div class="flex items-start">
        <dt class="w-1/3 font-semibold">Note :</dt>
        <dd class="w-2/3 text-white">{{ $movie['vote_average'] }}/10</dd>
    </div>
    <div class="flex items-start">
        <dt class="w-1/3 font-semibold">Réalisateur :</dt>
        <dd class="w-2/3 text-white">
            {{ collect($movie['credits']['crew'])->where('job', 'Director')->first()['name'] ?? 'Non disponible' }}
        </dd>
    </div>
    <div class="flex items-start">
        <dt class="w-1/3 font-semibold">Genres :</dt>
        <dd class="w-2/3 text-white">
            {{ collect($movie['genres'])->pluck('name')->join(', ') }}
        </dd>
    </div>
    <div class="flex items-start">
        <dt class="w-1/3 font-semibold">Pays d'origine :</dt>
        <dd class="w-2/3 text-white">
            {{ collect($movie['production_countries'])->pluck('name')->join(', ') }}
        </dd>
    </div>
</dl> 