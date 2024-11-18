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

- Laravel 10
- MySQL
- API TMDB
- Tailwind CSS 3.1
- Alpine.js 3.4
- Vite 5.0
- Embla Carousel 8.3
- Axios 1.6

## Installation

### 1. Cloner le projet
- git clone https://github.com/ArthurDesc/cinetech.git
- cd cinetech

### 2. Installation des dépendances
- composer install
- npm install

### 3. Configuration
- cp .env.example .env
- Configurez votre base de données dans le fichier .env
- Ajoutez votre clé API TMDB dans le fichier .env
- php artisan key:generate
- php artisan migrate

### 4. Lancement du projet
- php artisan serve & npm run dev

## Version
- v1.0.0

## Links
- [Laravel Doc](https://laravel.com/docs/11.x)
- [API TMDB](https://developer.themoviedb.org/reference/intro/getting-started)
- [Download Composer](https://getcomposer.org/download/)
- [Download Node Js](https://nodejs.org/en/learn/getting-started/how-to-install-nodejs)
