<template>
    <FlashMessageNewsletter />
    <CartWidget />

    <!-- Le composant Inertia Head assure aussi le rendu côté serveur -->

    <Head title="A propos de " />
    <TopBanner />

    <NavbarFrontend :auth="$page.props.auth as Record<string, any> | undefined" class="mt-10 md:mt-12" />

    <FloatingAction />
    <LoginReminder />

    <!-- 💥 Notification flash visible sur TOUTES les pages -->

    <section
        class="about min-h-screen px-6 py-6 text-[var(--text-dark)] md:px-20 lg:px-32 dark:bg-[var(--dark-background)] dark:text-[var(--dark-white)]"
    >
        <h1 class="space-x-10 text-2xl">A propos de Walner Tech</h1>
        <div class="mx-auto max-w-6xl space-y-10">
            <!-- Notre mission -->
            <div>
                <h2 class="mt-6 text-2xl font-semibold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Notre mission</h2>
                <p class="mb-8 text-[14px] leading-relaxed text-[var(--text-dark)] sm:text-[14px] md:text-[16px] dark:text-[var(--dark-grey)]">
                    Chez <strong>Walner Tech</strong>, notre mission est de
                    <span class="text-[var(--highlight-gold)]"> fournir des appareils électroniques de qualité</span> et des accessoires fiables, tout
                    en offrant un service client exceptionnel pour simplifier votre quotidien numérique. <br /><br />
                    Nous combinons expertise technique et approche client pour garantir une expérience optimale à chaque étape, du choix du produit au
                    support après-vente.
                </p>

                <div class="grid gap-6 md:grid-cols-3">
                    <div
                        v-for="(product, index) in products"
                        :key="index"
                        class="group rounded-xl bg-white p-6 shadow-md transition hover:bg-[var(--primary-blue)] hover:text-white hover:shadow-lg dark:bg-[#2A2A2A] hover:dark:bg-[#000]"
                    >
                        <font-awesome-icon
                            :icon="product.icon"
                            class="mb-3 text-2xl text-[var(--primary-blue)] group-hover:text-[#FFE600] dark:text-[var(--dark-gold)]"
                        />

                        <h3 class="mb-2 text-lg font-semibold text-[var(--primary-blue)] group-hover:text-[#FFE600] dark:text-[var(--dark-white)]">
                            {{ product.title }}
                        </h3>

                        <p class="text-sm text-gray-600 group-hover:text-gray-300 dark:text-gray-300">
                            {{ product.description }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Notre équipe -->
            <div class="mx-auto flex max-w-6xl flex-col-reverse items-center gap-8 p-6 lg:flex-row lg:items-start">
                <div class="lg:w-1/2">
                    <h2 class="mb-4 text-3xl font-bold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Notre équipe</h2>
                    <p
                        class="text-[15px] leading-relaxed text-[var(--text-dark)] sm:text-[16px] md:text-[17px] lg:leading-[2.2] dark:text-[var(--dark-grey)]"
                    >
                        L’équipe <strong>Walner Tech</strong> rassemble des spécialistes en électronique et service client, dédiés à fournir les
                        meilleurs produits et conseils pour vos besoins technologiques. <br /><br />
                        Nous combinons expertise technique et approche client pour garantir une expérience optimale, que ce soit dans la sélection des
                        produits, la résolution de problèmes techniques ou l’accompagnement personnalisé.
                        <br /><br />
                        Notre objectif : offrir des conseils adaptés, des recommandations fiables et un support réactif. Chez
                        <strong>Walner Tech</strong>, innovation, qualité et proximité guident chaque interaction.
                    </p>
                </div>

                <div class="flex justify-center lg:w-1/2">
                    <div class="overflow-hidden rounded-xl shadow-xl">
                        <img
                            src="assets/about1.jpg"
                            alt="Équipe Walner Tech"
                            loading="lazy"
                            class="h-auto w-full max-w-sm object-cover transition-transform duration-500 hover:scale-105 lg:max-w-md"
                        />
                    </div>
                </div>
            </div>

            <!-- Nos valeurs -->
            <div class="mx-auto flex max-w-6xl flex-col-reverse items-center gap-8 p-6 lg:flex-row lg:items-start">
                <div class="flex justify-center lg:w-1/2">
                    <div class="overflow-hidden rounded-xl shadow-xl">
                        <img
                            src="assets/homepage.jpg"
                            alt="Valeurs Walner Tech"
                            loading="lazy"
                            class="h-auto w-full max-w-sm object-cover transition-transform duration-500 hover:scale-105 lg:max-w-md"
                        />
                    </div>
                </div>
                <div class="lg:w-1/2">
                    <h2 class="mb-4 text-3xl font-bold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Nos valeurs</h2>
                    <ul class="space-y-5 text-[15px] leading-relaxed text-[var(--text-dark)] md:text-[16px] dark:text-[var(--dark-grey)]">
                        <li class="flex items-start gap-4">
                            <font-awesome-icon :icon="['fas', 'bolt']" class="mt-1 text-[var(--primary-blue)] dark:text-[var(--dark-gold)]" />
                            <span
                                ><strong>Qualité :</strong> proposer des produits fiables et durables. Chaque produit est testé pour garantir une
                                expérience optimale.</span
                            >
                        </li>
                        <li class="flex items-start gap-4">
                            <font-awesome-icon :icon="['fas', 'handshake']" class="mt-1 text-[var(--primary-blue)] dark:text-[var(--dark-gold)]" />
                            <span
                                ><strong>Confiance :</strong> établir des relations honnêtes et transparentes. Nous valorisons l’intégrité et les
                                liens durables.</span
                            >
                        </li>
                        <li class="flex items-start gap-4">
                            <font-awesome-icon
                                :icon="['fas', 'headphones-alt']"
                                class="mt-1 text-[var(--primary-blue)] dark:text-[var(--dark-gold)]"
                            />
                            <span
                                ><strong>Service :</strong> accompagnement attentif pour répondre à toutes vos questions et besoins. Nous guidons et
                                conseillons à chaque étape.</span
                            >
                        </li>
                        <li class="flex items-start gap-4">
                            <font-awesome-icon :icon="['fas', 'users']" class="mt-1 text-[var(--primary-blue)] dark:text-[var(--dark-gold)]" />
                            <span
                                ><strong>Innovation :</strong> suivre les dernières tendances technologiques pour offrir le meilleur. Nous
                                investissons dans la recherche et les nouvelles technologies.</span
                            >
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Contactez-nous -->
            <div class="mx-auto flex max-w-6xl flex-col-reverse items-center gap-8 p-6 lg:flex-row lg:items-start">
                <div class="lg:w-1/2">
                    <h2 class="mb-4 text-3xl font-bold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Contactez-nous</h2>
                    <p class="text-[15px] leading-relaxed text-[var(--text-dark)] md:text-[16px] lg:leading-[2.2] dark:text-[var(--dark-grey)]">
                        Vous avez une question ou besoin d’aide pour choisir un produit ? L’équipe <strong>Walner Tech</strong>
                        vous accompagne à chaque étape.
                        <br /><br />
                        Nous vous aidons à trouver le produit adapté à vos besoins, expliquons ses fonctionnalités et proposons les meilleures options
                        disponibles. Que ce soit pour vérifier la compatibilité, résoudre un problème technique ou obtenir des recommandations
                        personnalisées, nous garantissons un support rapide et efficace.
                        <br /><br />
                        N’hésitez pas à nous contacter via notre
                        <Link
                            :href="contact()"
                            class="text-[var(--accent-cyan)] underline hover:text-[var(--highlight-gold)] dark:text-[var(--dark-gold)]"
                        >
                            page de contact
                        </Link>
                        pour échanger directement avec nous. Nous sommes disponibles pour répondre à toutes vos questions et assurer votre entière
                        satisfaction.
                    </p>
                </div>

                <div class="flex justify-center lg:w-1/2">
                    <div class="overflow-hidden rounded-xl shadow-xl">
                        <img
                            src="assets/about2.jpg"
                            alt="Contact Walner Tech"
                            loading="lazy"
                            class="h-auto w-full max-w-sm object-cover transition-transform duration-500 hover:scale-105 lg:max-w-md"
                        />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <Footer />
</template>

<script lang="ts" setup>
import FlashMessageNewsletter from '@/components/FlashMessageNewsletter.vue';
import LoginReminder from '@/components/frontend/flash/LoginReminder.vue';
import FloatingAction from '@/components/frontend/FloatingAction.vue';
import Footer from '@/components/frontend/Footer.vue';
import NavbarFrontend from '@/components/frontend/NavbarFrontend.vue';
import CartWidget from '@/components/frontend/panier/CartWidget.vue';
import TopBanner from '@/components/frontend/TopBanner.vue';
import { contact } from '@/routes';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faBolt, faHandshake, faHeadphones, faLaptop, faMobileAlt, faUsers } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Head, Link } from '@inertiajs/vue3';
// import FlashMessageNewsletter from '@/components/FlashMessageNewsletter.vue';

library.add(faLaptop, faMobileAlt, faHeadphones, faBolt, faUsers, faHandshake);

const products = [
    {
        icon: ['fas', 'laptop'],
        title: 'Ordinateurs & périphériques',
        description: 'Vente d’ordinateurs portables et fixes, ainsi que tous les périphériques nécessaires pour travailler efficacement.',
    },
    {
        icon: ['fas', 'mobile-alt'],
        title: 'Téléphones & accessoires',
        description: 'Une large gamme de smartphones et accessoires, du câble aux écouteurs, pour rester connecté en toute simplicité.',
    },
    {
        icon: ['fas', 'headphones'],
        title: 'Support & service client',
        description: 'Assistance et conseils personnalisés pour vous aider à choisir le meilleur appareil selon vos besoins.',
    },
];
</script>
