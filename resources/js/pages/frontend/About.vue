<template>
    <!-- Le composant Inertia Head assure aussi le rendu côté serveur -->

    <Head :title="props.data?.title ?? 'Walner Tech'" />
    <TopBanner />
    <NavbarFrontend :auth="$page.props.auth" class="mt-10 md:mt-12" />
    <FloatingAction />
    <LoginReminder />
    <section
        class="about min-h-screen px-6 py-6 text-[var(--text-dark)] md:px-20 lg:px-32 dark:bg-[var(--dark-background)] dark:text-[var(--dark-white)]">
        <h1 class="text-3xl">A propos de Walner Tech</h1>
        <div class="mx-auto max-w-6xl space-y-10">

            <!-- Notre mission -->
            <div>
                <h2 class="mt-6 text-2xl font-semibold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">
                    Notre mission
                </h2>
                <p
                    class="mb-8 text-[14px] sm:text-[14px] md:text-[16px] leading-relaxed text-[var(--text-dark)] dark:text-[var(--dark-grey)]">
                    Chez <strong>Walner Tech</strong>, notre mission est de <span class="text-[var(--highlight-gold)]">
                        fournir des appareils électroniques de qualité</span> et des accessoires fiables, tout en
                    offrant un
                    service client exceptionnel pour simplifier votre quotidien numérique.
                    <br /><br />
                    Nous combinons expertise technique et approche client pour garantir une expérience optimale à chaque
                    étape, du choix du produit au support après-vente.
                </p>

                <div class="grid gap-6 md:grid-cols-3">
                    <div v-for="(product, index) in products" :key="index"
                        class="rounded-xl bg-white p-6 shadow-md transition hover:shadow-lg dark:bg-[#2A2A2A] hover:bg-[var(--primary-blue)] hover:text-white group">

                        <font-awesome-icon :icon="product.icon"
                            class="mb-3 text-2xl text-[var(--primary-blue)] dark:text-[var(--dark-gold)] group-hover:text-[#FFE600]" />

                        <h3
                            class="font-semibold text-lg mb-2 text-[var(--primary-blue)] dark:text-[var(--dark-white)] group-hover:text-[#FFE600]">
                            {{ product.title }}
                        </h3>

                        <p class="text-sm text-gray-600 dark:text-gray-300 group-hover:text-gray-300">
                            {{ product.description }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Notre équipe -->
            <div class="flex flex-col-reverse lg:flex-row items-center lg:items-start gap-8 max-w-6xl mx-auto p-6">
                <div class="lg:w-1/2">
                    <h2 class="mb-4 text-3xl font-bold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">
                        Notre équipe
                    </h2>
                    <p
                        class="text-[15px] sm:text-[16px] md:text-[17px] leading-relaxed lg:leading-[2.2] text-[var(--text-dark)] dark:text-[var(--dark-grey)]">
                        L’équipe <strong>Walner Tech</strong> rassemble des spécialistes en électronique et service
                        client, dédiés
                        à fournir les meilleurs produits et conseils pour vos besoins technologiques.
                        <br /><br />
                        Nous combinons expertise technique et approche client pour garantir une expérience optimale, que
                        ce soit
                        dans la sélection des produits, la résolution de problèmes techniques ou l’accompagnement
                        personnalisé.
                        <br /><br />
                        Notre objectif : offrir des conseils adaptés, des recommandations fiables et un support réactif.
                        Chez
                        <strong>Walner Tech</strong>, innovation, qualité et proximité guident chaque interaction.
                    </p>
                </div>

                <div class="lg:w-1/2 flex justify-center">
                    <div class="overflow-hidden rounded-xl shadow-xl">
                        <img src="assets/about1.jpg" alt="Équipe Walner Tech" loading="lazy"
                            class="w-full max-w-sm lg:max-w-md h-auto object-cover transition-transform duration-500 hover:scale-105" />
                    </div>
                </div>
            </div>

            <!-- Nos valeurs -->
            <div class="flex flex-col-reverse lg:flex-row items-center lg:items-start gap-8 max-w-6xl mx-auto p-6">
                <div class="lg:w-1/2 flex justify-center">
                    <div class="overflow-hidden rounded-xl shadow-xl">
                        <img src="assets/homepage.jpg" alt="Valeurs Walner Tech" loading="lazy"
                            class="w-full max-w-sm lg:max-w-md h-auto object-cover transition-transform duration-500 hover:scale-105" />
                    </div>
                </div>
                <div class="lg:w-1/2">
                    <h2 class="mb-4 text-3xl font-bold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">
                        Nos valeurs
                    </h2>
                    <ul
                        class="space-y-5 text-[15px] md:text-[16px] leading-relaxed text-[var(--text-dark)] dark:text-[var(--dark-grey)]">
                        <li class="flex items-start gap-4">
                            <font-awesome-icon :icon="['fas', 'bolt']"
                                class="text-[var(--primary-blue)] dark:text-[var(--dark-gold)] mt-1" />
                            <span><strong>Qualité :</strong> proposer des produits fiables et durables. Chaque produit
                                est testé
                                pour garantir une expérience optimale.</span>
                        </li>
                        <li class="flex items-start gap-4">
                            <font-awesome-icon :icon="['fas', 'handshake']"
                                class="text-[var(--primary-blue)] dark:text-[var(--dark-gold)] mt-1" />
                            <span><strong>Confiance :</strong> établir des relations honnêtes et transparentes. Nous
                                valorisons
                                l’intégrité et les liens durables.</span>
                        </li>
                        <li class="flex items-start gap-4">
                            <font-awesome-icon :icon="['fas', 'headphones-alt']"
                                class="text-[var(--primary-blue)] dark:text-[var(--dark-gold)] mt-1" />
                            <span><strong>Service :</strong> accompagnement attentif pour répondre à toutes vos
                                questions et besoins.
                                Nous guidons et conseillons à chaque étape.</span>
                        </li>
                        <li class="flex items-start gap-4">
                            <font-awesome-icon :icon="['fas', 'users']"
                                class="text-[var(--primary-blue)] dark:text-[var(--dark-gold)] mt-1" />
                            <span><strong>Innovation :</strong> suivre les dernières tendances technologiques pour
                                offrir le meilleur.
                                Nous investissons dans la recherche et les nouvelles technologies.</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Contactez-nous -->
            <div class="flex flex-col-reverse lg:flex-row items-center lg:items-start gap-8 max-w-6xl mx-auto p-6">
                <div class="lg:w-1/2">
                    <h2 class="mb-4 text-3xl font-bold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">
                        Contactez-nous
                    </h2>
                    <p
                        class="text-[15px] md:text-[16px] leading-relaxed lg:leading-[2.2] text-[var(--text-dark)] dark:text-[var(--dark-grey)]">
                        Vous avez une question ou besoin d’aide pour choisir un produit ? L’équipe <strong>Walner
                            Tech</strong>
                        vous accompagne à chaque étape.
                        <br /><br />
                        Nous vous aidons à trouver le produit adapté à vos besoins, expliquons ses fonctionnalités et
                        proposons
                        les meilleures options disponibles. Que ce soit pour vérifier la compatibilité, résoudre un
                        problème
                        technique ou obtenir des recommandations personnalisées, nous garantissons un support rapide et
                        efficace.
                        <br /><br />
                        N’hésitez pas à nous contacter via notre
                        <Link :href="contact()"
                            class="text-[var(--accent-cyan)] underline hover:text-[var(--highlight-gold)]">
                        page de contact
                        </Link> pour échanger directement avec nous. Nous sommes disponibles pour répondre à toutes vos
                        questions et assurer votre entière satisfaction.
                    </p>
                </div>

                <div class="lg:w-1/2 flex justify-center">
                    <div class="overflow-hidden rounded-xl shadow-xl">
                        <img src="assets/about2.jpg" alt="Contact Walner Tech" loading="lazy"
                            class="w-full max-w-sm lg:max-w-md h-auto object-cover transition-transform duration-500 hover:scale-105" />
                    </div>
                </div>
            </div>

        </div>
    </section>
    <Footer />
</template>

<script lang="ts" setup>
import NavbarFrontend from '@/components/frontend/NavbarFrontend.vue'
import FloatingAction from '@/components/frontend/FloatingAction.vue'
import { Link, Head } from '@inertiajs/vue3'
import Footer from '@/components/frontend/Footer.vue';
import { contact } from '@/routes';
import LoginReminder from '@/components/frontend/flash/LoginReminder.vue';
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
import TopBanner from '@/components/frontend/TopBanner.vue';
import { useHead } from '@vueuse/head';
import { computed } from 'vue';

library.add(faLaptop, faMobileAlt, faHeadphones, faBolt, faUsers, faHandshake)
// interface Seo {
//     data: {

//         title: string;
//         description: string;
//         image: string;
//         url: string;
//         robots?: string; // <- optionnel si certaines pages n’ont pas de robots
//     }

// }
// const props = defineProps<Seo>();

// // --- SEO avec @vueuse/head ---
// useHead({
//     title: computed(() => props.data.title),
//     meta: [
//         { name: 'description', content: computed(() => props.data.description) },
//         { property: 'og:title', content: computed(() => props.data.title) },
//         { property: 'og:description', content: computed(() => props.data.description) },
//         { name: 'robots', content: computed(() => props.data.robots || 'index, follow') },

//         { property: 'og:image', content: computed(() => props.data.image) },
//         { property: 'og:url', content: computed(() => props.data.url) },
//         { property: 'og:type', content: 'website' },
//         { name: 'twitter:card', content: 'summary_large_image' },
//         { name: 'twitter:title', content: computed(() => props.data.title) },
//         { name: 'twitter:description', content: computed(() => props.data.description) },
//         { name: 'twitter:image', content: computed(() => props.data.image) },
//     ],
// });

// Props sécurisées avec fallback
const props = defineProps({
    data: {
        type: Object,
        default: () => ({
            title: 'Walner Tech',
            description: '',
            image: '',
            url: window.location.href,
            robots: 'index, follow'
        })
    }
})

// SEO sécurisé
useHead({
    title: computed(() => props.data?.title ?? 'Walner Tech'),
    meta: [
        { name: 'description', content: computed(() => props.data?.description ?? '') },
        { property: 'og:title', content: computed(() => props.data?.title ?? 'Walner Tech') },
        { property: 'og:description', content: computed(() => props.data?.description ?? '') },
        { name: 'robots', content: computed(() => props.data?.robots ?? 'index, follow') },
        { property: 'og:image', content: computed(() => props.data?.image ?? '') },
        { property: 'og:url', content: computed(() => props.data?.url ?? window.location.href) },
        { property: 'og:type', content: 'website' },
        { name: 'twitter:card', content: 'summary_large_image' },
        { name: 'twitter:title', content: computed(() => props.data?.title ?? 'Walner Tech') },
        { name: 'twitter:description', content: computed(() => props.data?.description ?? '') },
        { name: 'twitter:image', content: computed(() => props.data?.image ?? '') }
    ]
})





const products = [
    {
        icon: ['fas', 'laptop'],
        title: "Ordinateurs & périphériques",
        description: "Vente d’ordinateurs portables et fixes, ainsi que tous les périphériques nécessaires pour travailler efficacement.",
    },
    {
        icon: ['fas', 'mobile-alt'],
        title: "Téléphones & accessoires",
        description: "Une large gamme de smartphones et accessoires, du câble aux écouteurs, pour rester connecté en toute simplicité.",
    },
    {
        icon: ['fas', 'headphones'],
        title: "Support & service client",
        description: "Assistance et conseils personnalisés pour vous aider à choisir le meilleur appareil selon vos besoins.",
    },
];
</script>
