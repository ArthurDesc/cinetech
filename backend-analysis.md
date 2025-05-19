# Analyse Complète du Backend - Projet Cinetech

## 1. Stack Technique et Outils Utilisés

- **Framework principal** : [Laravel 10](https://laravel.com/) (PHP 8.1+)
- **Langage** : PHP
- **ORM** : Eloquent (inclus avec Laravel)
- **Authentification API** : Laravel Sanctum
- **Gestion des dépendances** : Composer
- **Base de données** : MySQL (ou compatible, ex : MariaDB)
- **Gestion des migrations** : Artisan (outil CLI Laravel)
- **Tests** : PHPUnit (inclus)
- **Gestion des rôles et autorisations** : Policies Laravel
- **Sécurité** : Middleware CSRF, validation serveur, policies, hashing
- **API externe** : TMDB (The Movie Database) via HTTP (Guzzle)
- **Gestion des assets frontend** : Vite (pour le build JS/CSS)

## 2. Organisation des Dossiers et Fichiers Clés

```
app/
├── Http/
│   ├── Controllers/      # Logique métier (ex : CommentController, AdminController)
│   ├── Middleware/       # Middlewares (auth, rôles, CSRF...)
│   ├── Requests/         # Validation des requêtes (optionnel)
├── Models/               # Modèles Eloquent (User, Comment...)
├── Policies/             # Règles d'autorisation (ex : CommentPolicy)
database/
├── migrations/           # Scripts de création/modification de tables
├── seeders/              # Données de test (optionnel)
├── factories/            # Génération de fausses données (optionnel)
routes/
├── web.php               # Routes web (pages, vues Blade)
├── api.php               # Routes API REST (endpoints JSON)
```

## 3. Fonctionnement Général du Backend

- **MVC** : Laravel sépare la logique métier (Contrôleurs), la gestion des données (Modèles) et l'affichage (Vues Blade côté web, JSON côté API).
- **API REST** : Les routes définies dans `routes/api.php` exposent des endpoints pour le frontend (ex : `/api/comments`).
- **Authentification** :
  - Utilisateurs stockés dans la table `users`.
  - Authentification via Laravel Sanctum (tokens API pour sécuriser les routes).
  - Rôles gérés via le champ `is_admin` sur la table `users`.
- **Gestion des avis/commentaires** :
  - Table `comments` liée à `users` (relation 1-n).
  - Création, modification, suppression via endpoints API sécurisés.
  - Validation serveur systématique (ex : contenu requis, longueur max).
  - Modération : suppression possible uniquement par admin ou auteur (policies).
- **Sécurité** :
  - Protection CSRF sur tous les formulaires web.
  - Validation serveur de toutes les entrées utilisateur.
  - Middleware d'authentification et d'autorisation sur les routes sensibles.
  - Hashage des mots de passe (bcrypt).
- **Gestion des erreurs** :
  - Validation automatique (retourne erreurs 422 en JSON si champs invalides).
  - Gestion des autorisations (403 si accès refusé).
  - Gestion des exceptions Laravel (retourne erreurs claires en dev).

## 4. Base de Données

- **Tables principales** :
  - `users` : id, nickname, email, password, is_admin, timestamps
  - `comments` : id, user_id, tmdb_id, type (movie/tv), content, timestamps
- **Relations** :
  - Un utilisateur peut avoir plusieurs commentaires
  - Un commentaire appartient à un utilisateur
- **Migrations** :
  - Scripts versionnés dans `database/migrations/` pour créer/modifier les tables
  - Ajout du champ `is_admin` via migration dédiée
- **Script SQL exportable** :
  - Fichier `cinetech.sql` pour importer la structure et les données
- **Diagramme EER** :
  - Fichier DBML fourni pour visualiser le modèle conceptuel/logique

## 5. Sécurité et Gestion des Rôles

- **Authentification** :
  - Utilisation de Laravel Sanctum pour sécuriser les endpoints API
  - Middleware `auth:sanctum` sur les routes API sensibles
- **Gestion des rôles** :
  - Champ `is_admin` sur la table `users`
  - Méthode `isAdmin()` sur le modèle User
  - Policies Laravel (ex : `CommentPolicy`) pour restreindre la suppression/édition des commentaires
- **Protection des routes** :
  - Middleware d'authentification sur toutes les routes sensibles
  - Middleware d'autorisation (policies) pour les actions critiques (modération, suppression)
- **Validation** :
  - Toutes les requêtes de création/édition passent par une validation serveur stricte
  - Messages d'erreur clairs en cas de champ manquant ou invalide
- **CSRF** :
  - Protection automatique sur tous les formulaires web

## 6. API REST : Structure et Bonnes Pratiques

- **Endpoints** :
  - `/api/comments` (GET, POST, PUT, DELETE)
  - `/api/user` (GET, infos utilisateur connecté)
  - `/api/autocomplete` (recherche TMDB)
- **Format des réponses** :
  - Toutes les réponses sont en JSON
  - Gestion des statuts HTTP (201 création, 200 succès, 403 interdit, 422 validation...)
- **Gestion des erreurs** :
  - Validation automatique (retourne erreurs détaillées)
  - Gestion des autorisations (policies)
- **Pagination** :
  - Les listes (ex : commentaires) sont paginées côté backend
- **Sécurité** :
  - Authentification requise pour toute action sensible
  - Seul l'admin peut supprimer n'importe quel commentaire

## 7. Administration

- **Tableau de bord admin** :
  - Vue dédiée pour lister/modérer les commentaires
  - Accès restreint par rôle (is_admin)
- **Modération** :
  - L'admin peut supprimer n'importe quel commentaire
  - L'utilisateur peut supprimer ses propres commentaires

## 8. Bonnes Pratiques et Simplicité

- **Code simple, structuré et commenté**
- **Pas de dépendances inutiles**
- **Respect des conventions Laravel**
- **Séparation claire des responsabilités**
- **Facile à présenter et à expliquer à l'oral**

## 9. Pour aller plus loin (recommandations)

- Ajouter des tests unitaires pour les policies et contrôleurs
- Documenter les endpoints API dans le README
- Ajouter un système de rate limiting
- Logger les actions d'administration
- Optimiser les requêtes (index, cache)

---

**Ce backend est conçu pour être simple, sécurisé, et conforme aux attentes d'un projet DWWM, tout en restant facilement présentable et évolutif.** 