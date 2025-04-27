@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Tableau de bord administrateur</h1>
    <p>Bienvenue sur l'espace d'administration de Cinetech.</p>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
        <a href="{{ route('admin.comments') }}" class="block bg-dark-light rounded-lg shadow-lg p-6 hover:bg-primary-600 transition group focus:outline-none focus:ring-2 focus:ring-primary-500" tabindex="0" aria-label="Gérer les commentaires">
            <div class="flex items-center mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary-500 group-hover:text-white mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2v-8a2 2 0 012-2h2m2-4h4a2 2 0 012 2v4a2 2 0 01-2 2h-4a2 2 0 01-2-2V6a2 2 0 012-2z" />
                </svg>
                <span class="text-xl font-semibold text-white group-hover:text-white">Gestion des commentaires</span>
            </div>
            <p class="text-gray-300">Voir, modérer et supprimer les commentaires des utilisateurs.</p>
        </a>
    </div>
</div>
@endsection 