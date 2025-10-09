<template>
    <section id="about" class="bg-[var(--background-light)] py-12 md:py-20 dark:bg-[var(--dark-background)]">
        <div class="container mx-auto flex flex-col-reverse items-center gap-8 px-4 md:flex-row md:gap-16 max-w-6xl">

            <!-- Texte -->
            <div class="w-full md:w-1/2 max-w-xl md:text-left">
                <h2
                    class="mb-4 text-2xl sm:text-3xl md:text-4xl font-bold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">
                    À propos de Walner Tech
                </h2>
                <p
                    class="mb-6 text-[var(--text-dark)] dark:text-[var(--dark-grey)] text-base sm:text-sm md:text-base lg:text-lg leading-relaxed sm:leading-6 md:leading-7 lg:leading-8">
                    Chez <span class="font-semibold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Walner
                        Tech</span>,
                    nous croyons que la technologie doit être <span class="text-[var(--highlight-gold)]">accessible,
                        fiable et innovante</span>.
                    Notre mission est d’accompagner particuliers et entreprises avec des solutions modernes, allant
                    des produits électroniques aux services de développement, maintenance et support technique
                    personnalisé.
                    <br /><br />
                    Chaque projet est traité avec attention pour garantir qualité, performance et satisfaction, tout
                    en restant à l’écoute des besoins de nos clients.
                </p>
                <ul
                    class="mb-6 space-y-2 text-[var(--text-secondary)] dark:text-[var(--dark-grey)] text-sm sm:text-sm md:text-base leading-relaxed">
                    <li>✔️ Expertise en produits et solutions technologiques adaptées à chaque client</li>
                    <li>✔️ Service client réactif, professionnel et disponible</li>
                    <li>✔️ Innovation constante et vision orientée vers la satisfaction totale</li>
                </ul>
                <Link :href="about().url" prefetch aria-label="En savoir plus sur Walner Tech"
                    class="inline-block rounded-lg bg-[var(--highlight-gold)] px-5 py-3 text-sm sm:text-sm md:text-base font-semibold text-[var(--secondary-white)] shadow-md transition-transform hover:-translate-y-1 hover:bg-[var(--accent-cyan)] dark:bg-[var(--dark-gold)] dark:hover:bg-[var(--dark-accent)]">
                En savoir plus
                </Link>
            </div>

            <!-- Image -->
            <div class="w-full md:w-1/2 rounded-lg overflow-hidden flex justify-center md:justify-end">
                <img src="assets/about1.jpg" alt="Walner Tech - À propos"
                    class="w-full max-w-[350px] sm:max-w-xs md:max-w-sm lg:max-w-md h-auto object-cover shadow-lg rounded-lg transition-transform duration-500 hover:scale-105" />
            </div>

        </div>
    </section>
</template>
<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import {  about } from '@/routes';
</script>