<!-- AboutSection.vue -->
<script setup>
import { Link } from '@inertiajs/vue3';
// import { route } from 'ziggy-js';
import about from '@/routes'

</script>
<template>
    <section id="about2" class="bg-[var(--background-light)] py-0  dark:bg-[var(--dark-background)]">
        <div class="container mx-auto flex flex-col-reverse items-center gap-12 px-6 md:flex-row md:gap-16">
            <!-- Texte -->
            <div class="max-w-xl">
                <h2 class="mb-4 text-3xl font-bold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">À propos de
                    Walner Tech</h2>

                <p class="mb-6 text-lg text-[var(--text-dark)] dark:text-[var(--dark-grey)]">
                    Chez <span class="font-semibold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Walner
                        Tech</span>, nous croyons que la
                    technologie doit être <span class="text-[var(--highlight-gold)]">accessible, fiable et
                        innovante</span>. Notre mission est
                    d’accompagner particuliers et entreprises avec des solutions technologiques modernes, allant des
                    produits électroniques aux
                    services de développement et de maintenance.
                </p>

                <ul class="mb-6 space-y-3">
                    <li class="text-[var(--text-secondary)] dark:text-[var(--dark-grey)]">✔️ Expertise en produits et
                        solutions technologiques</li>
                    <li class="text-[var(--text-secondary)] dark:text-[var(--dark-grey)]">✔️ Un service client rapide et
                        professionnel</li>
                    <li class="text-[var(--text-secondary)] dark:text-[var(--dark-grey)]">
                        ✔️ Une vision orientée vers l’innovation et la satisfaction
                    </li>
                </ul>

                <!-- Bouton "En savoir plus" -->
                <Link :href=about().url aria-label="En savoir plus sur Walner Tech"
                    class="inline-block rounded-lg bg-[var(--highlight-gold)] px-6 py-3 font-semibold text-[var(--secondary-white)] shadow-md transition-transform hover:-translate-y-1 hover:bg-[var(--accent-cyan)] dark:bg-[var(--dark-gold)] dark:hover:bg-[var(--dark-accent)]">
                En savoir plus
                </Link>
            </div>

            <!-- Image -->
            <div class="w-full md:w-1/2">
                <img src="assets/homepage.jpg" alt="Walner Tech - À propos"
                    class="max-h-[450px] w-full rounded-lg object-cover shadow-lg" />
            </div>
        </div>
    </section>
</template>
