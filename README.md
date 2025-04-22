# Cinetech - Application de Films et Séries

## Description
Application web permettant de découvrir et gérer une liste de films et séries en utilisant l'API TMDB.

## Prérequis
- PHP >= 8.1
- Composer
- MySQL
- Node.js & NPM

## Installation

1. Cloner le projet
```bash
git clone <votre-repo>
cd cinetech
```

2. Installer les dépendances
```bash
composer install
npm install
```

3. Configurer l'environnement
```bash
cp .env.example .env
php artisan key:generate
```

4. Configuration de la base de données
- Créer une base de données MySQL nommée `cinetech`
- Configurer les accès dans le fichier `.env` :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cinetech
DB_USERNAME=root
DB_PASSWORD=root
```

5. Migrer la base de données
```bash
php artisan migrate
```

6. Compiler les assets
```bash
npm run dev
```

7. Lancer le serveur
```bash
php artisan serve
```

## Accès
- Application : http://127.0.0.1:8000
- Base de données : 
  - Host : 127.0.0.1
  - Port : 3306
  - Utilisateur : root
  - Mot de passe : root

## Fonctionnalités
- Affichage des films et séries populaires
- Carousel des films tendances
- Système de favoris
- Recherche de films et séries
- Système d'authentification
- Interface responsive

## Notes techniques
- L'application utilise l'API TMDB pour récupérer les données des films et séries
- La vérification SSL est désactivée en développement pour les appels API
- Pour la production, il est recommandé de configurer correctement les certificats SSL

## Technologies Used

- Laravel 10
- MySQL
- TMDB API
- Tailwind CSS 3.1
- Alpine.js 3.4
- Vite 5.0
- Embla Carousel 8.3
- Axios 1.6

## Version
- v1.0.0

## Links
- [Laravel Doc](https://laravel.com/docs/11.x)
- [TMDB API](https://developer.themoviedb.org/reference/intro/getting-started)
- [Download Composer](https://getcomposer.org/download/)
- [Download Node Js](https://nodejs.org/en/learn/getting-started/how-to-install-nodejs
