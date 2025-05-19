# Contexte Technique du Projet Cinetech

## Présentation

Cinetech est une application web permettant de découvrir, rechercher et gérer des listes de films et séries, avec des fonctionnalités sociales comme les favoris et les avis utilisateurs. Le projet a été conçu pour répondre aux exigences du diplôme DWWM (Développeur Web et Web Mobile), en mettant l'accent sur la simplicité, la clarté et l'accessibilité.

---

## Technologies, Frameworks et Librairies Utilisés

### Back-end

- **Laravel 10**  
  Framework PHP moderne utilisé pour la structure du back-end, la gestion des routes, la sécurité (CSRF, validation, rôles), l'authentification et l'API REST.
- **PHP 8.1+**  
  Langage principal du back-end.
- **MySQL**  
  Système de gestion de base de données relationnelle pour stocker les utilisateurs, avis, favoris, etc.
- **Sanctum**  
  Gestion de l'authentification API (tokens).
- **Spatie Laravel Web Tinker**  
  Outil de débogage et d'exécution de code PHP dans l'application.
- **GuzzleHTTP**  
  Client HTTP pour les appels externes (ex : API TMDB).

### Front-end

- **Blade (Laravel)**  
  Moteur de templates utilisé pour générer les vues côté serveur, avec une intégration facilitée de la logique et des composants.
- **Tailwind CSS 3.1**  
  Framework CSS utilitaire pour un design responsive, accessible et personnalisable.  
  - Personnalisation de la charte graphique (couleurs, polices, dark mode) dans `tailwind.config.js`.
- **Alpine.js 3.4**  
  Micro-framework JavaScript pour ajouter de l'interactivité légère côté client (ex : menus, modals).
- **Vite 5.0**  
  Outil de build et de développement rapide pour le front-end.
- **Axios 1.6**  
  Librairie JavaScript pour effectuer des requêtes HTTP asynchrones (ex : appels API TMDB, gestion dynamique des favoris/avis).
- **Embla Carousel 8.3**  
  Librairie JavaScript pour l'affichage de carrousels responsives (ex : films à l'affiche).

### Autres outils

- **Composer**  
  Gestionnaire de dépendances PHP.
- **NPM**  
  Gestionnaire de paquets JavaScript.

---

## API et Services Externes

- **TMDB API**  
  Utilisée pour récupérer dynamiquement les données des films et séries (affiches, synopsis, notes, etc.).

---

## Accessibilité et Design

- Application 100% responsive (desktop, tablette, mobile)
- Navigation clavier et attributs ARIA/alt pour l'accessibilité
- Charte graphique personnalisée (voir `tailwind.config.js`)

---

## Sécurité

- Protection CSRF sur tous les formulaires
- Validation côté serveur
- Gestion des rôles (user/admin) et protection des routes

---

## Structure du projet

- **Back-end** : répertoire `app/`, routes dans `routes/`, vues dans `resources/views/`
- **Front-end** : assets dans `resources/`, configuration Tailwind et Vite à la racine
- **Base de données** : scripts SQL et diagrammes dans la racine du projet

---

Ce document permet de présenter clairement le contexte technique du projet lors de l'oral ou dans la documentation. 