<script setup>
// import About from '@/components/frontend/About.vue';
import NavbarFrontend from '@/components/frontend/NavbarFrontend.vue';
import Service from '@/components/frontend/Service.vue';
import { Link } from '@inertiajs/inertia-vue3';
import Footer from '@/components/frontend/Footer.vue';
// import { route } from 'ziggy-js';
// import { VueTyper } from 'vue-typer';
</script>
<template>
    <NavbarFrontend />
    <section
        class="flex min-h-screen items-center rounded-br-[50%] bg-[var(--primary-blue)] px-6 pt-24 text-[var(--secondary-white)] md:px-20 md:pt-32 dark:bg-[var(--dark-background)] dark:text-[var(--dark-white)]"
    >
        <div class="container mx-auto flex flex-col justify-between gap-10 rounded-lg px-6 lg:flex-row">
            <!-- Texte -->
            <div class="max-w-lg lg:text-left">
                <h1 class="animate-fade-up mb-4 text-xl font-bold opacity-0 sm:text-[26px] md:text-[24px] lg:text-[28px] xl:text-[37px]">
                    Bienvenue sur Walner Tech
                </h1>
                <p
                    class="animate-fade-up mb-8 text-lg leading-relaxed text-[var(--text-paragraph-light)] opacity-0 delay-200 dark:text-[var(--dark-grey)]"
                >
                    Découvrez les meilleurs produits électroniques et services technologiques.
                </p>
                <Link
                    href="/products"
                    class="animate-fade-up bg-boris inline-block transform rounded-lg bg-[var(--highlight-gold)] px-6 py-3 font-semibold text-[var(--secondary-white)] opacity-0 shadow-md transition-transform delay-400 hover:-translate-y-1 hover:bg-[var(--accent-cyan)] dark:bg-[var(--dark-gold)] dark:hover:bg-[var(--dark-accent)]"
                >
                    Explorer les produits
                </Link>
            </div>

            <!-- Image / Logo -->
            <div class="w-full max-w-xl lg:w-1/2">
                <img src="assets/homepage.jpg" alt="Walner Tech" class="max-h-[450px] w-full rounded-lg object-cover shadow-lg z-[-10]" />
            </div>
        </div>
    </section>
    <Service />
    <!-- <About /> -->
        <section id="about" class="bg-[var(--background-light)] py-20 dark:bg-[var(--dark-background)]">
        <div class="container mx-auto flex flex-col-reverse items-center gap-12 px-6 md:flex-row md:gap-16">
            <!-- Texte -->
            <div class="max-w-xl">
                <h2 class="mb-4 text-3xl font-bold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">À propos de Walner Tech</h2>

                <p class="mb-6 text-lg text-[var(--text-dark)] dark:text-[var(--dark-grey)]">
                    Chez <span class="font-semibold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Walner Tech</span>, nous croyons que la
                    technologie doit être <span class="text-[var(--highlight-gold)]">accessible, fiable et innovante</span>. Notre mission est
                    d’accompagner particuliers et entreprises avec des solutions technologiques modernes, allant des produits électroniques aux
                    services de développement et de maintenance.
                </p>

                <ul class="mb-6 space-y-3">
                    <li class="text-[var(--text-secondary)] dark:text-[var(--dark-grey)]">✔️ Expertise en produits et solutions technologiques</li>
                    <li class="text-[var(--text-secondary)] dark:text-[var(--dark-grey)]">✔️ Un service client rapide et professionnel</li>
                    <li class="text-[var(--text-secondary)] dark:text-[var(--dark-grey)]">
                        ✔️ Une vision orientée vers l’innovation et la satisfaction
                    </li>
                </ul>

                <!-- Bouton "En savoir plus" -->
                <Link
                    href="/about"
                    aria-label="En savoir plus sur Walner Tech"
                    class="inline-block rounded-lg bg-[var(--highlight-gold)] px-6 py-3 font-semibold text-[var(--secondary-white)] shadow-md transition-transform hover:-translate-y-1 hover:bg-[var(--accent-cyan)] dark:bg-[var(--dark-gold)] dark:hover:bg-[var(--dark-accent)]"
                >
                    En savoir plus
                </Link>
            </div>

            <!-- Image -->
            <div class="w-full md:w-1/2">
                <img src="assets/homepage.jpg" alt="Walner Tech - À propos" class="max-h-[450px] w-full rounded-lg object-cover shadow-lg" />
            </div>
        </div>
    </section>
    <section>
        <Footer/>
    </section>
</template>

<style scoped>
/* Animations */
@keyframes fadeUp {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-up {
    animation: fadeUp 0.8s forwards;
}

.delay-200 {
    animation-delay: 0.2s;
}

.delay-400 {
    animation-delay: 0.4s;
}
</style>
