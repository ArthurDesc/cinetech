<footer class="w-full bg-dark-light text-white py-4 mt-8 border-t border-gray-700">
    <div class="max-w-7xl mx-auto flex flex-col items-center justify-center px-4 gap-2 text-base text-center">
        <div class="flex flex-col items-center gap-2">
            <div class="flex items-center gap-3 justify-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Cinetech" class="h-10 w-auto" />
                <span class="text-base">&copy; {{ date('Y') }}</span>
            </div>
        </div>
        <nav aria-label="Pied de page" class="flex gap-4 justify-center mt-2">
            <a href="{{ url('/') }}" class="hover:underline focus:outline-none focus:ring-2 focus:ring-primary rounded">Accueil</a>
            <a href="{{ url('/search') }}" class="hover:underline focus:outline-none focus:ring-2 focus:ring-primary rounded">Recherche</a>
            @auth
                <a href="{{ url('/favorites') }}" class="hover:underline focus:outline-none focus:ring-2 focus:ring-primary rounded">Favoris</a>
            @else
                <a href="{{ url('/login') }}" class="hover:underline focus:outline-none focus:ring-2 focus:ring-primary rounded">Connexion</a>
            @endauth
        </nav>
    </div>
</footer> 