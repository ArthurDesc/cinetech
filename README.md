# Cinetech - Application de Films et Séries :rocket:

Une application web permettant de découvrir et rechercher des films et séries TV en utilisant l'API TMDB. Les utilisateurs peuvent créer des comptes, gérer leurs favoris et commenter les contenus.

## Prérequis

- PHP 8.1 ou supérieur
- Composer
- Node.js et NPM
- MySQL 5.7 ou supérieur
- Git
- Compte TMDB et clé API

## Technologies Utilisées

- > Laravel 10
- MySQL
- API TMDB
- Tailwind CSS 3.1
- Alpine.js 3.4
- Vite 5.0
- Embla Carousel 8.3
- Axios 1.6

## Installation en Local

### 1. Cloner le projet
bash
git clone https://github.com/ArthurDesc/cinetech.git
cd cinetech


# 2. Installation des dépendances

### Installation des dépendances PHP de base
composer install
npm install

### Installation de Laravel Breeze
composer require laravel/breeze --dev
php artisan breeze:install

### Installation des dépendances Node.js
npm install

### Installation de Tailwind CSS
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p

### Installation d'Embla Carousel
npm install embla-carousel

# Compilation des assets
npm run build

### 3. Configuration de l'environnement


## Version
v1.0.0

## Docs
>>[Laravel Doc](https://laravel.com/docs/11.x)
