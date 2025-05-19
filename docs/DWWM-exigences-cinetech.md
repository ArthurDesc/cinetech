# Cinetech & Examen DWWM : Synthèse des Exigences et Réponses du Projet

## 1. Présentation du Projet

**Cinetech** est une application web permettant de découvrir, rechercher, commenter et gérer une liste de films et séries, avec gestion des utilisateurs, favoris et avis, en s'appuyant sur l'API TMDB.

---

## 2. Exigences DWWM & Réponses du Projet

### Bloc 1 : Front-end (Activité Type 1)

| Exigence DWWM | Réponse Cinetech |
|---------------|------------------|
| **Site 100% responsive** | Utilisation de Tailwind CSS, design mobile-first, tests sur desktop/tablette/mobile. |
| **Navigation clavier** | Navigation accessible via Tab/Entrée, focus visible sur les éléments interactifs. |
| **Texte lisible, contrasté, hiérarchie visuelle** | Palette de couleurs contrastées, tailles de police adaptées, titres hiérarchisés. |
| **Accessibilité (aria-*, alt)** | Attributs `alt` sur images, `aria-label` sur boutons importants. |
| **Charte graphique documentée** | Section dédiée dans la documentation (couleurs, polices, composants principaux). |
| **Pages obligatoires** | Accueil, résultats de recherche, détails film/série, connexion/inscription, favoris, laisser un avis. |
| **Appels API TMDB avec gestion des erreurs** | Utilisation d'Axios, gestion des erreurs d'API avec feedback utilisateur. |
| **Affichage dynamique** | Utilisation d'AJAX (Axios) pour chargement dynamique des contenus. |
| **Ajout aux favoris** | Bouton d'ajout/suppression, feedback visuel immédiat. |
| **Laisser un avis** | Formulaire accessible, validation côté client et serveur, feedback utilisateur. |

---

### Bloc 2 : Back-end (Activité Type 2)

| Exigence DWWM | Réponse Cinetech |
|---------------|------------------|
| **Base de données** | MySQL, tables `users`, `reviews`, script SQL exportable, EER fourni. |
| **Sécurité (CSRF, validation, rôles)** | Protection CSRF Laravel, validation serveur, gestion des rôles (user/admin), middleware de protection des routes. |
| **Gestion des favoris** | Ajout/suppression en base, routes protégées. |
| **Création/édition d'avis** | Formulaire sécurisé, modération possible par admin. |
| **Tableau de bord admin** | Liste des utilisateurs et avis, suppression/modération réservée à l'admin. |
| **Protection des routes** | Middleware Laravel pour restreindre l'accès selon le rôle. |

---

## 3. Fonctionnalité Présentée à l'Examen

### Ajout de commentaires (avis) côté utilisateur

- **Formulaire accessible** (labels, feedback, navigation clavier)
- **Validation** côté client (JS) et serveur (Laravel)
- **Protection CSRF** automatique via Blade/Laravel
- **Enregistrement en base** (table `reviews`)
- **Affichage dynamique** après soumission (AJAX)
- **Gestion des erreurs** (champ vide, API, etc.)

### Suppression/modération de commentaires côté admin

- **Liste des avis** dans le dashboard admin
- **Bouton "supprimer"** visible uniquement pour l'admin
- **Vérification du rôle** avant suppression (middleware)
- **Feedback utilisateur** après action
- **Gestion des erreurs** (tentative de suppression par un non-admin, etc.)

---

## 4. Points forts pour la soutenance

- Respect des bonnes pratiques DWWM (accessibilité, sécurité, structure claire)
- Documentation technique et charte graphique disponibles
- Démonstration possible de la fonctionnalité "ajout/suppression d'avis" en workflow complet
- Code simple, concret, sans éléments superflus

---

## 5. Annexes

- Script SQL de création de la base
- Diagramme EER
- Extraits de code pour la validation, la sécurité, l'accessibilité
- Captures d'écran des pages principales 