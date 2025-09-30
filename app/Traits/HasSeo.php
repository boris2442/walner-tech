<?php

namespace App\Traits;

trait HasSeo
{
    /**
     * Génère un tableau de données SEO réutilisable
     *
     * @param  string      $title
     * @param  string      $description
     * @param  string      $keywords
     * @param  string|null $image
     * @return array
     */
    protected function seo(string $title, string $description, string $keywords, ?string $image = null): array
    {
        return [
            'title' => $title,
            'description' => $description,
            'keywords' => $keywords,
            // url courante (utile pour og:url)
            'url' => url()->current(),
            // image par défaut si rien n'est fourni
            'image' => $image ?? asset('assets/og-image.png'),
        ];
    }
}
