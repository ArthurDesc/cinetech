# Cinetech - Dépendances et Technologies

Ce document détaille les dépendances, technologies et fonctionnalités du projet Cinetech, une application web de gestion de films et séries utilisant l'API TMDB.

## Présentation du Projet

Cinetech est une application web responsive permettant aux utilisateurs de découvrir des films et séries, de les ajouter à leurs favoris et de laisser des commentaires. Le projet est développé avec Laravel et utilise l'API TMDB (The Movie Database) pour récupérer les informations sur les films et séries.

## Technologies Principales

### Backend
- **PHP 8.1+** : Langage de programmation principal
- **Laravel 10** : Framework PHP moderne pour le développement web
- **MySQL** : Système de gestion de base de données relationnel
- **PHPmyadmin** : Interface de base de données relationnel
- **Laragon** : Pour lancer serveur de base de donnée et aussi phpmyadmin

### Frontend
- **JavaScript** : Pour les interactions côté client
- **Tailwind CSS 3.1** : Framework CSS utilitaire pour le design responsive
- **Alpine.js 3.4** : Framework JavaScript minimaliste pour le comportement interactif
- **Embla Carousel 8.3** : Bibliothèque pour les carrousels
- **Axios 1.6** : Client HTTP basé sur les promesses pour effectuer des requêtes AJAX

### API Externe
- **TMDB API** : The Movie Database API pour les données de films et séries

### Environnement Docker
- Conteneurs Docker pour faciliter le développement et le déploiement
- Configuration multi-conteneurs (frontend, backend)

## Liste Complète des Dépendances PHP (composer.json)

### Production
- **php**: ^8.1
- **guzzlehttp/guzzle**: ^7.2 - Client HTTP pour les requêtes API
- **laravel/framework**: ^10.10 - Framework Laravel
- **laravel/sanctum**: ^3.3 - Système d'authentification API
- **laravel/tinker**: ^2.8 - REPL pour Laravel
- **spatie/laravel-web-tinker**: ^1.10 - Interface web pour Tinker

### Développement
- **fakerphp/faker**: ^1.9.1 - Génération de données factices pour tests
- **laravel/breeze**: ^1.29 - Scaffolding d'authentification
- **laravel/pint**: ^1.0 - Outil de formatage de code PHP
- **laravel/sail**: ^1.18 - Environnement de développement Docker
- **mockery/mockery**: ^1.4.4 - Framework de mock pour tests
- **nunomaduro/collision**: ^7.0 - Gestion améliorée des erreurs
- **phpunit/phpunit**: ^10.1 - Framework de tests
- **spatie/laravel-ignition**: ^2.0 - Gestion des erreurs pour Laravel

## Liste des Dépendances JavaScript (package.json)

### Production
- **embla-carousel**: ^8.3.1 - Bibliothèque pour les carrousels

### Développement
- **@tailwindcss/forms**: ^0.5.2 - Plugin Tailwind pour styliser les formulaires
- **alpinejs**: ^3.4.2 - Framework JavaScript minimaliste
- **autoprefixer**: ^10.4.2 - Plugin PostCSS pour ajouter des préfixes vendeurs
- **axios**: ^1.6.4 - Client HTTP pour les requêtes API
- **laravel-vite-plugin**: ^1.0.0 - Plugin Vite pour Laravel
- **postcss**: ^8.4.31 - Outil de transformation CSS
- **tailwindcss**: ^3.1.0 - Framework CSS
- **vite**: ^5.0.0 - Bundler/serveur de développement

## Structure de la Base de Données

### Tables Principales
1. **users**
   - id (PK)
   - nickname
   - email (unique)
   - password (hashed)
   - is_admin (boolean)
   - email_verified_at
   - remember_token
   - timestamps

2. **favorites**
   - id (PK)
   - user_id (FK -> users.id)
   - tmdb_id (ID externe du film/série)
   - type (movie/tv)
   - timestamps

3. **comments**
   - id (PK)
   - user_id (FK -> users.id)
   - tmdb_id (ID externe du film/série)
   - type (movie/tv)
   - content (texte du commentaire)
   - parent_id (FK -> comments.id, pour les réponses)
   - timestamps

4. **password_reset_tokens** (gestion des réinitialisations de mot de passe)
5. **failed_jobs** (gestion des tâches échouées)
6. **personal_access_tokens** (gestion des tokens d'API)

## Fonctionnalités Principales

### Visiteurs (non authentifiés)
- Parcourir les films et séries populaires
- Visualiser les détails d'un film ou d'une série
- Effectuer des recherches
- Voir les commentaires
- S'inscrire/se connecter

### Utilisateurs (authentifiés)
- Toutes les fonctionnalités des visiteurs
- Ajouter/supprimer des films et séries aux favoris
- Ajouter des commentaires sur les films et séries
- Répondre aux commentaires existants
- Gérer son profil

### Administrateurs
- Toutes les fonctionnalités des utilisateurs
- Accès au tableau de bord administrateur
- Modération des commentaires (visualisation et suppression)

## Intégration avec TMDB API

L'application interagit avec l'API TMDB pour récupérer :
- Films populaires
- Séries populaires
- Films et séries tendances
- Détails d'un film/série (synopsis, casting, etc.)
- Recherche de films et séries

## Optimisations et Performances
- Système de cache pour les requêtes API fréquentes
- Gestion efficace des images externes via l'API TMDB
- Chargement dynamique des données (lazy loading) pour les listes
- Validation des données côté serveur et client
- Protection CSRF pour tous les formulaires

## Commandes pour Exécuter le Projet

```bash
# Installer les dépendances PHP (dans le conteneur backend)
composer install

# Installer les dépendances JS (dans le conteneur frontend)
npm install

# Compiler les assets (dans le conteneur frontend)
npm run dev
# ou en production
npm run build
```

```bash
# Installer les dépendances
composer install
npm install

# Configurer l'environnement
cp .env.example .env
php artisan key:generate

# Créer la base de données et migrer
php artisan migrate

# Lancer le serveur de développement
php artisan serve
# Dans un autre terminal
npm run dev
```

## Accessibilité
- Site 100% responsive (desktop / tablette / mobile)
- Navigation au clavier fonctionnelle
- Attributs ARIA pour les éléments importants
- Textes lisibles et contrastés
- Structure sémantique HTML5

## Tests
Le projet contient des tests unitaires et fonctionnels pour garantir la qualité du code. Vous pouvez les exécuter avec la commande :
```bash
php artisan test
```

## Documentation Externe
- [Laravel Documentation](https://laravel.com/docs/10.x)
- [TMDB API Documentation](https://developer.themoviedb.org/reference/intro/getting-started)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Alpine.js Documentation](https://alpinejs.dev/start-here) 