# walner-tech

...existing code...

# Walner Tech — Application Web

Site e‑commerce / vitrine & dashboard d'administration pour Walner Tech — construit avec Laravel, Inertia.js + Vue 3, Vite et Tailwind CSS.
## Aperçu

<p align="center">
  <img src="assets/image.png" alt="Accueil Walner Tech" width="900" />
</p>

---

## Fonctionnalités principales

- Frontend Vue 3 via Inertia.js (Single Page App côté Laravel)
- Pages produits, catégories, contacts, témoignages
- Tableau de bord administrateur avec gestion utilisateurs, produits et statistiques
- Thèmes clair / sombre et animations (hero, loader)
- Composants réutilisables (sidebar, navbar, footer, etc.)

## Stack technique

- Backend: Laravel (PHP)
- Frontend: Vue 3 (Composition API) + TypeScript
- Inertia.js (inertiajs/vue3)
- Vite (dev server & build)
- Tailwind CSS
- Lucide icons, plugins NProgress, head plugin, etc.
- Dev environment: Windows (Laragon)

## Prérequis

- PHP >= 8.x
- Composer
- Node.js >= 16 (npm ou yarn)
- MySQL / MariaDB (ou autre DB supportée)
- Laragon (optionnel, recommandé pour dev sur Windows)

## Installation rapide (développement)

1. Cloner le dépôt
    - git clone <https://github.com/boris2442/walner-tech/> walner-tech
2. Installer dépendances backend
    - cd walner-tech
    - composer install
3. Copier l'environnement et générer la clé
    - copy .env.example .env (Windows) ou cp .env.example .env
    - php artisan key:generate
4. Configurer la base de données dans .env puis exécuter les migrations
    - php artisan migrate --seed
5. Installer dépendances frontend
    - npm install
6. Lancer les serveurs
    - php artisan serve --host=127.0.0.1 --port=8000
    - npm run dev
      (Si vous utilisez Laragon, démarrez les services dans Laragon et exécutez `npm run dev`)

## Commandes utiles

- Dev (Vite + HMR): npm run dev
- Build production frontend: npm run build
- Lint (si configuré): npm run lint
- Tests (si présents): php artisan test or npm run test

## Variables d'environnement importantes

- APP_NAME — nom de l'application (utilisé pour le titre)
- VITE_APP_NAME — nom affiché côté frontend (vite)
- DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD

## Structure du projet (rapide)

- resources/js — code frontend (pages, components, composables, plugins)
    - pages — pages Inertia (ex: HomePage.vue)
    - components — composants réutilisables (AppSidebar, NavbarFrontend, Footer, ...)
    - plugins — head, nprogress, etc.
    - app.ts — point d'entrée frontend (Inertia + Vue)
- resources/css — styles (Tailwind)
- routes, controllers, models — côté Laravel

## Afficher des liens réservés aux admins

Le sidebar conditionne l'affichage sur la propriété user (ex: `user.role === 'admin'` ou `user.is_admin`). Exemple :

```ts
// snippet (resources/js/components/AppSidebar.vue)
...(user.value?.role === 'admin' ? [
  { title: 'Users', href: users.index().url, icon: BookOpen },
  { title: 'Administrateurs', href: dashboardAdmin.admin().url, icon: LayoutGrid },
] : [])
```

Adapte la condition au champ réel de ton utilisateur.

## Dépannage rapide

- Erreur Vite: "Failed to fetch dynamically imported module" ou 500 en cherchant un component (.vue)
    - Vérifier que le fichier existe et que le chemin d'import correspond exactement (sensible à la casse dans certains contextes).
    - Redémarrer Vite: `npm run dev`.
    - Vider le cache de Vite ou supprimer node_modules puis `npm ci`.
    - Vérifier la configuration d'alias (`@` dans vite.config.ts) et que `resolvePageComponent` cible le bon dossier.
- Erreurs d'assets (images, fonts) : vérifier chemins relatifs et que `public/` contient les fichiers si nécessaires.
- Problèmes d'auth / props Inertia : inspecter `page.props` dans le navigateur (Inertia expose la page côté client).

## Déploiement

- Compiler le frontend : `npm run build`
- Déployer les fichiers Laravel sur l'hébergement (inclure build frontend dans public si nécessaire)
- Mettre à jour .env, exécuter `php artisan migrate --force` puis redémarrer le serveur web

## Contribuer

- Fork → feature branch → PR
- Respecter la configuration de lint / format si présente
- Ajouter tests pour nouvelles fonctionnalités

## Licence & contact

- Licence: indique la licence du projet (ex: MIT) ou supprime cette section si propriétaire
- Contact: responsable technique / mainteneur — ajoute une adresse email ou lien GitHub

Si tu veux, je peux :

- Générer un README plus détaillé (avec scripts exacts, variables .env listées),
- Ajouter des badges (build, license),
- Rédiger un guide de déploiement pour Laragon / Windows.
