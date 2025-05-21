# Documentation des Routes API - Projet Cinetech

Ce document liste toutes les routes API disponibles dans le projet Cinetech. Les routes sont organisées par catégorie et incluent les informations sur les méthodes HTTP, les endpoints, et leurs descriptions.

## Configuration Générale

- Toutes les routes API sont préfixées par `/api`
- L'authentification est gérée via Laravel Sanctum
- Les réponses sont au format JSON

## Routes d'Authentification

### Récupération des Informations Utilisateur
- **Endpoint**: `GET /api/user`
- **Description**: Retourne les informations de l'utilisateur connecté
- **Authentification**: Requise (middleware auth:sanctum)
- **Réponse**: Données de l'utilisateur au format JSON

## Routes de Recherche

### Autocomplétion
- **Endpoint**: `GET /api/autocomplete`
- **Description**: Fournit des suggestions de recherche basées sur l'API TMDB
- **Authentification**: Non requise
- **Paramètres**: 
  - `query`: Terme de recherche
- **Réponse**: Liste des suggestions au format JSON

## Routes de Commentaires

### Gestion des Commentaires
- **Endpoint**: `GET /api/comments`
- **Description**: Récupère la liste des commentaires (avec pagination)
- **Authentification**: Non requise

- **Endpoint**: `POST /api/comments`
- **Description**: Crée un nouveau commentaire
- **Authentification**: Requise
- **Validation**:
  - Contenu requis
  - Longueur maximale définie

- **Endpoint**: `PUT /api/comments/{id}`
- **Description**: Modifie un commentaire existant
- **Authentification**: Requise (auteur uniquement)

- **Endpoint**: `DELETE /api/comments/{id}`
- **Description**: Supprime un commentaire
- **Authentification**: Requise (auteur ou admin)

## Sécurité

- Toutes les routes sensibles sont protégées par le middleware `auth:sanctum`
- La validation des données est effectuée côté serveur
- Les policies Laravel contrôlent les autorisations d'accès
- Protection CSRF active sur les formulaires web

## Gestion des Erreurs

- **401**: Non authentifié
- **403**: Non autorisé
- **404**: Ressource non trouvée
- **422**: Erreur de validation
- **500**: Erreur serveur

## Notes

- Les réponses incluent des messages d'erreur clairs en cas de problème
- La pagination est appliquée sur les listes de ressources
- Les tokens d'authentification doivent être inclus dans l'en-tête `Authorization`