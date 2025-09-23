<template>
    <NavbarFrontend />
    <section
        class="about min-h-screen  px-6 py-16 text-[var(--text-dark)] md:px-20 dark:bg-[var(--dark-background)] dark:text-[var(--dark-white)]">
        <div class="mx-auto  space-y-16">


            <div>
                <h2 class="mt-6 text-2xl font-semibold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">
                    Notre mission
                </h2>
                <p
                    class="mb-8 text-[14px] leading-relaxed sm:text-[14px] md:text-[16px] text-[var(--text-dark)] dark:text-[var(--dark-grey)]">
                    Chez <strong>Walner Tech</strong>, notre mission est de <span
                        class="text-[var(--highlight-gold)]">fournir des appareils électroniques de qualité</span>
                    et des accessoires fiables, tout en offrant un service client exceptionnel pour simplifier votre
                    quotidien numérique.
                </p>

                <div class="grid gap-6 md:grid-cols-3">

                    <div
                        class="rounded-xl bg-white p-6 shadow-md dark:bg-[var(--dark-card)] animated-border-card transition-all duration-300 hover:scale-[1.02]">
                        <font-awesome-icon :icon="['fas', 'laptop']"
                            class="text-[var(--primary-blue)] dark:text-[var(--dark-gold)] mb-3 text-2xl" />
                        <h3 class="font-semibold text-lg mb-2">Ordinateurs & périphériques</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            Vente d’ordinateurs portables et fixes, ainsi que tous les périphériques nécessaires pour
                            travailler efficacement.
                        </p>
                    </div>


                    <div
                        class="rounded-xl bg-white p-6 shadow-md dark:bg-[var(--dark-card)] animated-border-card transition-all duration-300 hover:scale-[1.02]">
                        <font-awesome-icon :icon="['fas', 'mobile-alt']"
                            class="text-[var(--primary-blue)] dark:text-[var(--dark-gold)] mb-3 text-2xl" />
                        <h3 class="font-semibold text-lg mb-2">Téléphones & accessoires</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            Une large gamme de smartphones et accessoires, du câble aux écouteurs, pour rester connecté
                            en toute simplicité.
                        </p>
                    </div>


                    <div
                        class="rounded-xl bg-white p-6 shadow-md dark:bg-[var(--dark-card)] animated-border-card transition-all duration-300 hover:scale-[1.02]">
                        <font-awesome-icon :icon="['fas', 'headphones']"
                            class="text-[var(--primary-blue)] dark:text-[var(--dark-gold)] mb-3 text-2xl" />
                        <h3 class="font-semibold text-lg mb-2">Support & service client</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            Assistance et conseils personnalisés pour vous aider à choisir le meilleur appareil selon
                            vos besoins.
                        </p>
                    </div>
                </div>
            </div>


            <div class="flex flex-col items-center gap-8 lg:flex-row">
                <div class="lg:w-1/2">
                    <img src="assets/homepage.jpg" alt="Équipe Walner Tech"
                        class="h-auto w-full rounded-xl shadow-md" />
                </div>
                <div class="lg:w-1/2">
                    <h2 class="mb-3 text-2xl font-semibold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">
                        Notre équipe
                    </h2>
                    <p
                        class="text-[14px] leading-relaxed sm:text-[14px] md:text-[16px] text-[var(--text-dark)] dark:text-[var(--dark-grey)]">
                        L’équipe <strong>Walner Tech</strong> est composée de spécialistes en électronique et service
                        client,
                        dédiés à vous fournir les meilleurs produits et conseils pour vos besoins technologiques
                        quotidiens.
                    </p>
                </div>
            </div>


            <div class="flex flex-col-reverse items-center gap-8 lg:flex-row">
                <div class="lg:w-1/2">
                    <h2 class="mb-3 text-2xl font-semibold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Nos
                        valeurs</h2>
                    <ul class="space-y-3 text-[14px] md:text-[16px]">
                        <li class="flex items-start gap-2">
                            <font-awesome-icon :icon="['fas', 'bolt']"
                                class="text-[var(--primary-blue)] dark:text-[var(--dark-gold)] mt-1" />
                            Qualité : proposer des produits fiables et durables pour tous nos clients.
                        </li>
                        <li class="flex items-start gap-2">
                            <font-awesome-icon :icon="['fas', 'handshake']"
                                class="text-[var(--primary-blue)] dark:text-[var(--dark-gold)] mt-1" />
                            Confiance : établir des relations honnêtes et transparentes avec chaque client.
                        </li>
                        <li class="flex items-start gap-2">
                            <font-awesome-icon :icon="['fas', 'headphones-alt']"
                                class="text-[var(--primary-blue)] dark:text-[var(--dark-gold)] mt-1" />
                            Service : un accompagnement attentif pour répondre à toutes vos questions et besoins.
                        </li>
                        <li class="flex items-start gap-2">
                            <font-awesome-icon :icon="['fas', 'users']"
                                class="text-[var(--primary-blue)] dark:text-[var(--dark-gold)] mt-1" />
                            Innovation : suivre les dernières tendances technologiques pour toujours vous offrir le
                            meilleur.
                        </li>
                    </ul>
                </div>
                <div class="lg:w-1/2">
                    <img src="assets/homepage.jpg" alt="Valeurs Walner Tech"
                        class="h-auto w-full rounded-xl shadow-md" />
                </div>
            </div>


            <div class="flex flex-col items-center gap-8 lg:flex-row">
                <div class="lg:w-1/2">
                    <img src="assets/homepage.jpg" alt="Contact Walner Tech"
                        class="h-auto w-full rounded-xl shadow-md" />
                </div>
                <div class="lg:w-1/2">
                    <h2 class="mb-3 text-2xl font-semibold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">
                        Contactez-nous
                    </h2>
                    <p
                        class="text-[14px] leading-relaxed sm:text-[14px] md:text-[16px] text-[var(--text-dark)] dark:text-[var(--dark-grey)]">
                        Vous avez une question ou besoin d’aide pour choisir un produit ? L’équipe <strong>Walner
                            Tech</strong>
                        est là pour vous aider. Rendez-vous sur notre
                        <Link href="/contact"
                            class="text-[var(--accent-cyan)] underline hover:text-[var(--highlight-gold)]">
                        page de contact
                        </Link>
                        pour échanger avec nous.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <Footer />
</template>



<script setup>
import NavbarFrontend from '@/components/frontend/NavbarFrontend.vue'
import { Link } from '@inertiajs/vue3'
import Footer from '@/components/frontend/Footer.vue';

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { library } from '@fortawesome/fontawesome-svg-core'

import {
    faLaptop,
    faMobileAlt,
    faHeadphones,
    faBolt,
    faUsers,
    faHandshake
} from '@fortawesome/free-solid-svg-icons'

library.add(faLaptop, faMobileAlt, faHeadphones, faBolt, faUsers, faHandshake)
</script>
<style scoped>
.animated-border-card {
    position: relative;
    overflow: hidden;
    border-radius: 0.75rem;
    /* rounded-xl */
}

.animated-border-card::before {
    content: '';
    position: absolute;
    top: -2px;
    right: -2px;
    bottom: -2px;
    left: -2px;
    z-index: -1;
    background: linear-gradient(45deg,
            var(--primary-blue, #007BFF),
            var(--highlight-gold, #FFD700),
            var(--accent-cyan, #00C8FF),
            var(--primary-blue, #007BFF));
    background-size: 400% 400%;
    border-radius: 0.875rem;
    opacity: 0;
    transition: opacity 0.4s ease;
}

.animated-border-card:hover::before {
    opacity: 1;
    animation: borderSweep 2s ease infinite;
}

@keyframes borderSweep {
    0% {
        background-position: 0% 50%;
    }

    50% {
        background-position: 100% 50%;
    }

    100% {
        background-position: 0% 50%;
    }
}
</style>