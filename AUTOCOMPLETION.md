# Fonctionnalité d'autocomplétion – Documentation

## Objectif
Permettre à l'utilisateur de recevoir des suggestions de films ou séries en temps réel lors de la saisie dans la barre de recherche, grâce à l'API TMDB.

---

## Fonctionnement global

1. **L'utilisateur commence à taper dans la barre de recherche.**
2. **Une requête AJAX est envoyée automatiquement au back-end** (route `/api/autocomplete`) à chaque modification du champ (dès 2 caractères).
3. **Le back-end interroge l'API TMDB** pour obtenir des suggestions pertinentes.
4. **Le back-end retourne les suggestions** (titre, type, image, id) au front-end au format JSON.
5. **Le front-end affiche dynamiquement la liste des suggestions** sous le champ de recherche.
6. **L'utilisateur peut naviguer dans la liste au clavier ou à la souris** et sélectionner une suggestion pour accéder à la fiche détaillée.

---

## Fichiers concernés

### Back-end (Laravel)
- **app/Http/Controllers/SearchController.php**
  - Méthode `autocomplete(Request $request)` :
    - Récupère la requête utilisateur (`query`).
    - Si la requête est trop courte, retourne une liste vide.
    - Interroge l'API TMDB (`/search/multi`).
    - Filtre et formate les résultats (max 5 suggestions, films/séries uniquement).
    - Retourne les suggestions au format JSON.

- **routes/api.php**
  - Route GET `/api/autocomplete` qui pointe vers `SearchController@autocomplete`.

### Front-end (Blade + Alpine.js)
- **resources/views/layouts/navigation.blade.php**
  - Barre de recherche principale (desktop) avec autocomplétion.
  - Utilise Alpine.js (`autocompleteSearch()`) pour :
    - Gérer l'état de la requête, des suggestions, du chargement.
    - Envoyer la requête AJAX à `/api/autocomplete`.
    - Afficher dynamiquement la liste des suggestions.
    - Gérer la navigation clavier/souris dans la liste.

- **resources/views/components/mobile-menu.blade.php**
  - Barre de recherche mobile avec autocomplétion.
  - Utilise Alpine.js (`autocompleteSearchMobile()`) avec une logique similaire à la version desktop.

### Styles (optionnel)
- **resources/css/app.css**
  - Styles pour la scrollbar de la liste d'autocomplétion et l'apparence des champs de recherche.

---

## Détail du flux technique

### 1. Saisie utilisateur (front-end)
- L'utilisateur tape dans le champ de recherche.
- Un événement déclenche la fonction `fetchSuggestions()` (Alpine.js).
- Si la requête fait au moins 2 caractères, une requête AJAX est envoyée à `/api/autocomplete?query=...`.

### 2. Traitement côté back-end
- La méthode `autocomplete` du `SearchController` reçoit la requête.
- Elle interroge l'API TMDB avec la requête utilisateur.
- Elle filtre les résultats pour ne garder que les films et séries.
- Elle limite à 5 suggestions et formate les données (titre, type, image, id).
- Elle retourne la liste au format JSON.

### 3. Affichage dynamique (front-end)
- Le front-end reçoit la liste des suggestions.
- Il affiche dynamiquement la liste sous le champ de recherche.
- L'utilisateur peut naviguer dans la liste (clavier/souris) et sélectionner une suggestion.
- Un clic ou la touche Entrée redirige vers la fiche détaillée du film ou de la série.

---

## Accessibilité et UX
- Navigation clavier prise en charge (flèches, Entrée, Échap).
- Feedback visuel sur la suggestion sélectionnée.
- Affichage d'un message si aucun résultat n'est trouvé.
- Indicateur de chargement pendant la requête.

---

## Résumé des fichiers impliqués
- `app/Http/Controllers/SearchController.php`
- `routes/api.php`
- `resources/views/layouts/navigation.blade.php`
- `resources/views/components/mobile-menu.blade.php`
- `resources/css/app.css` (pour le style)

---

**Cette documentation peut être présentée à l'oral pour expliquer la fonctionnalité d'autocomplétion de A à Z.** 