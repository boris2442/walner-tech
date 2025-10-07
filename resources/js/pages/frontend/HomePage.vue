<script setup>
import { ref, onMounted, nextTick } from 'vue';
import NavbarFrontend from '@/components/frontend/NavbarFrontend.vue';
import Service from '@/components/frontend/Service.vue';
import Footer from '@/components/frontend/Footer.vue';
import Testimony from '@/components/frontend/Testimony.vue';
import FloatingAction from '@/components/frontend/FloatingAction.vue';
import Loading from '@/components/frontend/Loading.vue';
import { products, about } from '@/routes';
import { Link } from '@inertiajs/vue3';


// Loader : true si on doit afficher le loader
const showLoading = ref(true);

// Animation Hero : true si les animations doivent se jouer
const animateHero = ref(false);

onMounted(() => {
    if (!sessionStorage.getItem('hasVisited')) {
        // Affiche le loader 2s
        setTimeout(async () => {
            showLoading.value = false;   // Fin du loader
            await nextTick();             // attendre que le DOM soit mis à jour
            animateHero.value = true;    // lance l'animation
            sessionStorage.setItem('hasVisited', 'true');
        }, 2000);
    } else {
        // Pas la première visite → pas de loader
        showLoading.value = false;
        nextTick(() => {
            animateHero.value = true;    // lance l'animation immédiatement
        });
    }
});
</script>

<template>
    <!-- Loader -->
    <Loading v-if="showLoading" />

    <!-- Contenu principal -->
    <div v-else>
        <NavbarFrontend :auth="$page.props.auth" />
        <FloatingAction />

        <!-- Hero Section Premium -->
        <section class="relative flex items-start min-h-screen bg-cover bg-center bg-no-repeat
            px-6 md:px-16 lg:px-32 pt-24 md:pt-32 lg:pt-40 overflow-hidden
            dark:bg-[var(--dark-background)] dark:text-[#e0e7ff] bg-[#1e293b]"
            style="background-image: url('/herop2.png');
            background-size: cover; background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            ">
        

            <!-- Couche d’assombrissement -->
            <div class="absolute inset-0 bg-black/50 dark:bg-black/60"></div>

            <!-- Contenu principal offset à gauche -->
            <div class="relative z-10 flex flex-col gap-6 max-w-4xl transform -translate-x-2 md:-translate-x-0">

                <!-- H1 animé slide + fade -->
                <h1 :class="[
                    'text-2xl sm:text-3xl md:text-4xl lg:text-5xl max-w-3xl font-extrabold leading-snug drop-shadow-xl tracking-tight text-[var(--secondary-white)] dark:text-[var(--dark-grey)]',
                    animateHero ? 'opacity-100 translate-y-0 transition-all duration-700 ease-out' : 'opacity-0 translate-y-10'
                ]">
                    Walner Tech: <br class="sm:block">Votre expert en équipements informatiques
                </h1>

                <!-- Paragraphe animé fade + slide -->
                <p :class="[
                    'text-base sm:text-lg md:text-xl lg:text-2xl leading-relaxed text-[var(--secondary-white)] dark:text-[var(--dark-grey)]',
                    animateHero ? 'opacity-100 translate-y-0 transition-all duration-700 ease-out delay-200' : 'opacity-0 translate-y-10'
                ]">
                    Découvrez nos ordinateurs, smartphones et accessoires électroniques de qualité,
                    conçus pour la performance et la durabilité.
                </p>

                <!-- Bouton animé -->
                <Link :href="products().url"
                    prefetch
                    aria-label="Explorer les produits Walner Tech"
                    :class="[
                        'inline-block rounded-lg bg-[var(--highlight-gold)] px-8 py-3 font-semibold text-[var(--secondary-white)] shadow-md transition-transform hover:-translate-y-1 hover:bg-[var(--text-secondary)] dark:bg-[var(--dark-gold)] dark:hover:bg-[var(--dark-accent)] max-w-[220px]',
                        animateHero ? 'opacity-100 translate-y-0 transition-all duration-700 ease-out delay-400' : 'opacity-0 translate-y-10'
                    ]">
                    Explorer les produits
                </Link>
            </div>
        </section>

        <!-- Services / About / Testimony / Footer restent identiques -->
        <Service />
        <section id="about" class="bg-[var(--background-light)] py-20 dark:bg-[var(--dark-background)]">
            <div class="container mx-auto flex flex-col-reverse items-center gap-12 px-6 md:flex-row md:gap-16">
                <div class="max-w-xl">
                    <h2 class="mb-4 text-3xl font-bold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">
                        À propos de Walner Tech
                    </h2>
                    <p class="mb-6 text-lg text-[var(--text-dark)] dark:text-[var(--dark-grey)]">
                        Chez <span class="font-semibold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Walner
                        Tech</span>,
                        nous croyons que la technologie doit être <span class="text-[var(--highlight-gold)]">accessible,
                        fiable et innovante</span>.
                        Notre mission est d’accompagner particuliers et entreprises avec des solutions technologiques
                        modernes,
                        allant des produits électroniques aux services de développement et de maintenance.
                    </p>
                    <ul class="mb-6 space-y-3">
                        <li class="text-[var(--text-secondary)] dark:text-[var(--dark-grey)]">✔️ Expertise en produits et solutions technologiques</li>
                        <li class="text-[var(--text-secondary)] dark:text-[var(--dark-grey)]">✔️ Un service client rapide et professionnel</li>
                        <li class="text-[var(--text-secondary)] dark:text-[var(--dark-grey)]">✔️ Une vision orientée vers l’innovation et la satisfaction</li>
                    </ul>
                    <Link :href="about().url" prefetch aria-label="En savoir plus sur Walner Tech"
                        class="inline-block rounded-lg bg-[var(--highlight-gold)] px-6 py-3 font-semibold text-[var(--secondary-white)] shadow-md transition-transform hover:-translate-y-1 hover:bg-[var(--accent-cyan)] dark:bg-[var(--dark-gold)] dark:hover:bg-[var(--dark-accent)]">
                        En savoir plus
                    </Link>
                </div>
                <div class="w-full md:w-1/2 rounded-lg overflow-hidden">
                    <img src="assets/homepage.jpg" alt="Walner Tech - À propos"
                        class="w-full h-auto object-cover shadow-lg" />
                </div>
            </div>
        </section>
        <Testimony />
        <Footer />
    </div>
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
