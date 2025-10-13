<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @class(['dark' => ($appearance ?? 'system') == 'dark'])>

<head>
    {{-- 1️⃣ Charset, viewport, CSRF --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- 2️⃣ Apparence : mode sombre --}}
    <script>
        (function() {
            const appearance = '{{ $appearance ?? 'system' }}';
            if (appearance === 'system') {
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (prefersDark) document.documentElement.classList.add('dark');
            }
        })();
    </script>

    <style>
        html {
            background-color: oklch(1 0 0);
        }

        html.dark {
            background-color: oklch(0.145 0 0);
        }
    </style>


    <title inertia>{{ config('app.name', 'Walner Tech - Expert en équipements informatiques') }}</title>


    <link rel="icon" href="/walner.svg" sizes="any" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/walner.svg">
    <link rel="icon" type="image/png" href="{{ asset('assets/walner.png') }}">


    <meta name="description"
        content="Walner Tech est votre boutique informatique de référence à Bafoussam et Yaoundé, Cameroun. Découvrez nos ordinateurs portables, accessoires high-tech, composants PC et périphériques. Livraison rapide dans tout le Cameroun et à l’international. Service professionnel, produits garantis et assistance personnalisée.">
    <meta name="keywords"
        content="Walner Tech, boutique informatique Cameroun, ordinateurs portables, accessoires PC, high-tech, Bafoussam, Yaoundé, matériel informatique, composants PC, livraison Cameroun, boutique technologique, vente ordinateur, accessoires informatiques, technologie, innovation, électronique">
    <meta name="author" content="Walner Tech">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">


    <meta property="og:title" content="Walner Tech - Votre expert en équipements informatiques au Cameroun">
    <meta property="og:description"
        content="Commandez vos ordinateurs, accessoires et produits high-tech chez Walner Tech. Livraison rapide à Bafoussam, Yaoundé et partout au Cameroun. Service professionnel et fiable.">
    <meta property="og:image" content="{{ asset('assets/walner.jpg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Walner Tech">
    <meta property="og:locale" content="fr_FR">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">


    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Walner Tech - Équipements informatiques & accessoires high-tech">
    <meta name="twitter:description"
        content="Walner Tech, boutique high-tech à Bafoussam et Yaoundé. Ordinateurs, accessoires, composants PC. Livraison rapide au Cameroun et à l’international.">
    <meta name="twitter:image" content="{{ asset('assets/walner.jpg') }}">


    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="fr" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="en" href="{{ url()->current() }}">


    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/js/app.ts', "resources/js/pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="font-sans antialiased">
    @inertia
</body>

</html>
