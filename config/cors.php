<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Ce fichier permet de configurer les règles CORS de ton application.
    | Il détermine quels chemins, méthodes, origines et en-têtes sont autorisés.
    | Voir la documentation officielle pour plus de détails. :contentReference[oaicite:0]{index=0}
    |
    */

    'paths' => [
        'api/*',
        'sanctum/csrf-cookie',
        // tu peux ajouter ici d’autres chemins web si nécessaire
        // 'frontend/*',
    ],

    'allowed_methods' => ['*'],  // autoriser toutes les méthodes HTTP (GET, POST, PUT, DELETE, OPTIONS, etc.)

    'allowed_origins' => [
        'http://127.0.0.1:8000',  // ton frontend local
        'http://localhost:8000',
        // si tu utilises un autre port ou domaine, l’ajouter ici
        // en production, remplacer par les origines autorisées réelles
    ],

    'allowed_origins_patterns' => [
        // tu peux mettre des patterns regex si besoin (ex: sous-domaines)
        // Exemple: '^https?://(.*\.)?tondomaine\.com$'
    ],

    'allowed_headers' => ['*'],  // tous les en-têtes autorisés (utile si tu envoies des en-têtes personnalisés)

    'exposed_headers' => [],  // en-têtes que le navigateur peut voir

    'max_age' => 0,  // durée pendant laquelle les résultats de pré-vol peuvent être mis en cache (en secondes)

    'supports_credentials' => false,  // définir à true si tu utilises les cookies ou l’authentification basée sur les sessions

];
