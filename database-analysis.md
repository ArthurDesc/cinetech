# Analyse Complète de la Base de Données - Projet Cinetech

## 1. Outils et Environnement Utilisés

- **SGBD** : MySQL (compatible MariaDB)
- **Interface de gestion** : [phpMyAdmin](https://www.phpmyadmin.net/) (inclus avec Laragon)
- **Serveur local** : [Laragon](https://laragon.org/) (environnement de développement tout-en-un)
- **Gestion des migrations** : Artisan (CLI Laravel)
- **Export/Import SQL** : Fichier `cinetech.sql` (dump complet)
- **Modélisation** : Fichier DBML (diagramme EER conceptuel et logique)

## 2. Création et Gestion de la Base de Données

- **Création** :
  - La base de données `cinetech` est créée via phpMyAdmin ou en ligne de commande.
  - Les tables sont créées automatiquement via les migrations Laravel (`php artisan migrate`).
- **Configuration** :
  - Les accès à la base sont définis dans le fichier `.env` de Laravel :
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=cinetech
    DB_USERNAME=root
    DB_PASSWORD=root
    ```
- **Gestion** :
  - phpMyAdmin permet de visualiser, éditer, exporter et importer les données facilement.
  - Les migrations assurent la versioning et la reproductibilité de la structure.

## 3. Structure de la Base de Données

### Tables Principales

- **users**
  - `id` (PK, auto-incrément)
  - `nickname` (string, pseudo utilisateur)
  - `email` (string, unique)
  - `password` (string, hashé)
  - `is_admin` (booléen, gestion des rôles)
  - `email_verified_at` (timestamp, nullable)
  - `remember_token` (string, nullable)
  - `created_at`, `updated_at` (timestamps)

- **comments**
  - `id` (PK, auto-incrément)
  - `user_id` (FK vers users.id)
  - `tmdb_id` (int, identifiant du film/série TMDB)
  - `type` (string, 'movie' ou 'tv')
  - `content` (text, contenu du commentaire)
  - `created_at`, `updated_at` (timestamps)

- **Autres tables techniques**
  - `password_reset_tokens` (gestion des resets de mot de passe)
  - `personal_access_tokens` (authentification API)
  - `failed_jobs`, `migrations` (technique Laravel)

### Relations et Contraintes

- **users <1---n> comments** : Un utilisateur peut avoir plusieurs commentaires, chaque commentaire appartient à un utilisateur.
- **Clés étrangères** :
  - `comments.user_id` → `users.id` (avec suppression en cascade)
- **Contraintes d'intégrité** :
  - Unicité sur `users.email`
  - Non-null sur les champs critiques

## 4. Scripts et Modélisation

- **Migrations Laravel** :
  - Scripts PHP versionnés dans `database/migrations/` pour chaque table et modification.
  - Permettent de créer, modifier, supprimer les tables de façon reproductible.
- **Script SQL exportable** :
  - Fichier `cinetech.sql` généré via phpMyAdmin (ou commande mysqldump)
  - Permet d'importer la structure et les données sur un autre environnement.
- **Diagramme EER (DBML)** :
  - Fichier `.dbml` fourni pour visualiser le modèle conceptuel et logique (entités, relations, cardinalités).
  - Utile pour la présentation à l'oral et la documentation.

## 5. Sécurité et Bonnes Pratiques

- **Accès** :
  - Utilisation d'un utilisateur MySQL dédié (ex : `root` en local, à restreindre en prod)
  - Mot de passe fort recommandé en production
- **Protection des données** :
  - Hashage des mots de passe (jamais stockés en clair)
  - Accès restreint aux données sensibles via les rôles (is_admin)
- **Sauvegarde/Export** :
  - Utilisation de phpMyAdmin pour exporter la base (format SQL, CSV, etc.)
  - Possibilité de restaurer rapidement en cas de problème
- **Conformité RGPD** :
  - Possibilité de supprimer un utilisateur et ses données associées (cascade)

## 6. Conformité DWWM

- [x] Table `users` (utilisateurs, rôles)
- [x] Table `comments` (avis)
- [x] Script SQL exportable (`cinetech.sql`)
- [x] Diagramme EER (DBML)
- [x] Relations et contraintes d'intégrité

## 7. Procédures courantes avec phpMyAdmin

- **Créer la base** : Onglet "Bases de données" > Créer > `cinetech`
- **Importer le script** : Onglet "Importer" > Sélectionner `cinetech.sql`
- **Visualiser le schéma** : Onglet "Designer" pour voir les relations
- **Exporter** : Onglet "Exporter" > Choisir le format (SQL recommandé)
- **Éditer les données** : Cliquer sur une table > "Parcourir" ou "Insérer"

## 8. Pour aller plus loin

- Ajouter des index sur les colonnes utilisées en recherche (ex : `tmdb_id`, `type`)
- Séparer les accès admin/utilisateur en production
- Automatiser les sauvegardes régulières
- Documenter le modèle dans le README

---

**La base de données Cinetech est conçue pour être simple, robuste, sécurisée et conforme aux attentes d'un projet DWWM, tout en restant facile à manipuler et à présenter avec phpMyAdmin et Laragon.** 