<!-- resources/js/Pages/About.vue -->
<template>
    <NavbarFrontend />
    <section
        class="about min-h-screen bg-[var(--background-light)] px-6 py-16 text-[var(--text-dark)] md:px-20 dark:bg-[var(--dark-background)] dark:text-[var(--dark-white)]"
    >
        <div class="mx-auto max-w-6xl space-y-16">
            <!-- Date -->
            <p class="mb-6 text-sm italic">
                Dernière mise à jour :
                <span class="text-[var(--highlight-gold)]">
                    {{ formattedDate }}
                </span>
            </p>

            <!-- MISSION -->
            <div class="flex flex-col-reverse items-center gap-8 lg:flex-row">
                <div class="lg:w-1/2">
                    <h2 class="mb-3 text-2xl font-semibold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Notre mission / Our Mission</h2>
                    <p class="text-[14px] leading-relaxed text-[var(--text-dark)] sm:text-[14px] md:text-[16px] dark:text-[var(--dark-grey)]">
                        Chez <strong>Walner Tech</strong>, notre mission est de rendre la technologie
                        <span class="text-[var(--highlight-gold)]">accessible à tous</span>. À travers nos produits et services, nous accompagnons
                        particuliers et entreprises avec des solutions fiables, innovantes et modernes.
                    </p>
                </div>
                <div class="lg:w-1/2">
                    <img src="assets/homepage.jpg" alt="Mission de Walner Tech" class="h-auto w-full rounded-xl shadow-md" />
                </div>
            </div>

            <!-- ÉQUIPE -->
            <div class="flex flex-col items-center gap-8 lg:flex-row">
                <div class="lg:w-1/2">
                    <img src="assets/homepage.jpg" alt="Équipe de Walner Tech" class="h-auto w-full rounded-xl shadow-md" />
                </div>
                <div class="lg:w-1/2">
                    <h2 class="mb-3 text-2xl font-semibold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Notre équipe</h2>
                    <p class="text-[14px] leading-relaxed text-[var(--text-dark)] sm:text-[14px] md:text-[16px] dark:text-[var(--dark-grey)]">
                        Notre équipe est composée de passionnés de technologie, de développeurs web, de designers graphiques et de créateurs de
                        contenu. Ensemble, nous unissons nos compétences pour offrir une plateforme fiable, esthétique et utile. Chaque membre
                        contribue avec expertise et engagement à l’évolution de Walner Tech.
                    </p>
                </div>
            </div>

            <!-- VALEURS -->
            <div class="flex flex-col-reverse items-center gap-8 lg:flex-row">
                <div class="lg:w-1/2">
                    <h2 class="mb-3 text-2xl font-semibold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Nos valeurs</h2>
                    <p class="text-[14px] leading-relaxed text-[var(--text-dark)] sm:text-[14px] md:text-[16px] dark:text-[var(--dark-grey)]">
                        Nous croyons en la puissance de la connaissance partagée, en l’innovation responsable, et en l’humain au cœur de la
                        technologie. Notre travail repose sur la transparence, l’intégrité et la qualité. Chez Walner Tech, nous valorisons
                        l’apprentissage continu, l’excellence et l’accessibilité.
                    </p>
                </div>
                <div class="lg:w-1/2">
                    <img src="assets/homepage.jpg" alt="Nos valeurs" class="h-auto w-full rounded-xl shadow-md" />
                </div>
            </div>

            <!-- CONTACT -->
            <div class="flex flex-col items-center gap-8 lg:flex-row">
                <div class="lg:w-1/2">
                    <img src="assets/homepage.jpg" alt="Contactez-nous" class="h-auto w-full rounded-xl shadow-md" />
                </div>
                <div class="lg:w-1/2">
                    <h2 class="mb-3 text-2xl font-semibold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Contactez-nous</h2>
                    <p class="text-[14px] leading-relaxed text-[var(--text-dark)] sm:text-[14px] md:text-[16px] dark:text-[var(--dark-grey)]">
                        Une question, une suggestion ou un partenariat ? Notre équipe est à votre écoute. Rendez-vous sur notre
                        <Link href="/contact" class="text-[var(--accent-cyan)] underline hover:text-[var(--highlight-gold)]"> page de contact </Link>
                        pour nous écrire. Nous serons ravis d’échanger avec vous.
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import NavbarFrontend from '@/components/frontend/NavbarFrontend.vue';
import { Link } from '@inertiajs/vue3';

// formatage simple de la date
const date = new Date();
date.setDate(date.getDate() - 1);
const formattedDate = date.toLocaleDateString('fr-FR', {
    day: '2-digit',
    month: 'long',
    year: 'numeric',
});
</script>
