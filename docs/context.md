# Cinetech – Projet DWWM

## Contexte

Ce projet a été réalisé dans le cadre de ma formation. L’objectif est de concevoir une application web concrète, simple et accessible, mettant en avant les bonnes pratiques de développement front-end et back-end.  
Le site **Cinetech** permet aux utilisateurs de rechercher des films et séries, de consulter leurs détails, de laisser des avis.
L’accent a été mis sur l’accessibilité, la sécurité, la gestion des rôles, et l’interaction dynamique avec une API externe (TMDB).

---

## Fonctionnalités principales

### Front-end

- **Site 100% responsive** : Adapté à tous les écrans (desktop, tablette, mobile)
- **Navigation accessible** : Clavier, contraste, hiérarchie visuelle, attributs ARIA/alt
- **Pages principales** :
  - Accueil
  - Résultats de recherche
  - Détail d’un film/série
  - Connexion / Inscription
  - Laisser un avis
- **Interactions dynamiques** :
  - Recherche et affichage de films/séries via l’API TMDB
  - Formulaire d’avis avec feedback utilisateur
  - Gestion des erreurs (ex : champ vide, API indisponible)

### Back-end

- **Base de données relationnelle** (MySQL/PostgreSQL) :
  - Utilisateurs
  - Avis/commentaires
- **Sécurité** :
  - Protection CSRF
  - Validation serveur de tous les formulaires
  - Gestion des rôles : utilisateur / admin
  - Protection des routes selon le rôle
- **Composants** :
  - Gestion des favoris
  - Création/édition/suppression d’avis (modération par admin)
  - Tableau de bord admin (liste des utilisateurs et avis)

---

## Focus de la présentation

- **Ajout de commentaires (avis) côté utilisateur** :
  - Formulaire accessible et sécurisé
  - Validation et feedback en temps réel
  - Enregistrement en base et affichage dynamique
- **Suppression/modération de commentaires côté admin** :
  - Accès réservé à l’admin
  - Workflow complet : visualisation, suppression, feedback, gestion des erreurs
---

## Technologies utilisées

- **Front-end** : HTML5, CSS3, JavaScript, Blade (Laravel)
- **Back-end** : PHP, Laravel, MySQL/PostgreSQL
- **API externe** : TMDB (The Movie Database)

---

> Ce projet met en avant la simplicité, la clarté et la robustesse, conformément aux attentes du diplôme DWWM.