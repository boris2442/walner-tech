<script setup>
import { Headphones, RotateCcw, Shield, Truck } from 'lucide-vue-next';
import { nextTick, onMounted, ref } from 'vue';
const animateHero = ref(false);
const showFullText = ref(false); // contrôle "Voir plus / Voir moins"

// Le texte complet
const fullText = `La meilleure boutique en ligne à portée de main.
Bienvenue à Walner Tech, votre boutique de référence pour tous les équipements informatiques et
électroniques au Cameroun. Sur notre plateforme, nous sélectionnons uniquement les meilleurs produits
pour répondre aux besoins quotidiens de nos clients, que ce soit à Douala, Yaoundé ou partout ailleurs
dans le pays. Tous nos produits sont de marques réputées telles que Apple, Redmi, Huawei, Dell, Hp, Lenovo, Azus et bien
d’autres, afin de garantir qualité, performance et durabilité.

Commandez facilement via WhatsApp et soyez satisfait.
Chez Walner Tech, vos commandes se passent directement sur WhatsApp, ce qui rend l’expérience simple,
rapide et personnalisée. Notre équipe est disponible pour vous guider, répondre à vos questions et
assurer un service après-vente de qualité. Plus besoin de naviguer dans de multiples pages : envoyez
votre demande sur WhatsApp et recevez votre produit chez vous en toute tranquillité.

Découvrez notre catalogue de produits.
Nous proposons principalement :
Téléphones : iPhone, Redmi, Huawei, et les modèles récents les plus recherchés.
Ordinateurs : portables et PC de bureau pour usage personnel ou professionnel.
Accessoires informatiques : claviers, souris, casques, chargeurs et périphériques de qualité.
Chaque produit est choisi pour sa performance et sa fiabilité, afin de satisfaire les clients les plus
exigeants.

Promotions et offres spéciales.
Walner Tech propose régulièrement des offres exceptionnelles, ventes flash et remises limitées sur
certains produits populaires. Restez connecté pour profiter de nos promotions et découvrez comment
obtenir vos appareils préférés à des prix incroyables. Que ce soit pour un smartphone, un ordinateur ou
un accessoire, nos offres vous permettent de faire de bonnes affaires tout en bénéficiant de la qualité
Walner Tech.

Le site de confiance pour vos achats technologiques.
Avec Walner Tech, vous achetez en toute confiance. Tous nos produits sont authentiques, garantis, et
vous bénéficiez d’un service après-vente fiable pour toute assistance. Profitez d’une expérience d’achat
simple et sécurisée via WhatsApp et découvrez la technologie de pointe à portée de main.`;

// Limite du texte visible avant "Voir plus"
const previewLength = 500; // caractères

onMounted(() => {
    if (!sessionStorage.getItem('hasVisited')) {
        setTimeout(async () => {
            await nextTick();
            animateHero.value = true;
            sessionStorage.setItem('hasVisited', 'true');
        }, 2000);
    } else {
        nextTick(() => {
            animateHero.value = true;
        });
    }
});
</script>

<template>
    <section
        class="relative flex items-start overflow-hidden bg-[#3b3975] bg-cover bg-center bg-no-repeat px-6 pt-4 pb-10 md:px-16 md:pt-32 lg:px-32 lg:pt-40 dark:bg-[var(--dark-background)] dark:text-[#e0e7ff]"
        style="
            background-image: url('/herop2.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        "
    >
        <div class="absolute inset-0 bg-blue-900/70"></div>

        <div class="relative z-10 flex max-w-4xl -translate-x-2 transform flex-col gap-6 md:-translate-x-0">
            <h1
                :class="[
                    'max-w-3xl text-2xl leading-snug font-extrabold tracking-tight text-[var(--secondary-white)] drop-shadow-xl sm:text-3xl md:text-4xl lg:text-5xl dark:text-[var(--dark-grey)]',
                    animateHero ? 'translate-y-0 opacity-100 transition-all duration-700 ease-out' : 'translate-y-10 opacity-0',
                ]"
            >
                Walner Tech: <br class="sm:block" />Votre expert en équipements informatiques
            </h1>

            <!-- Paragraphe avec Voir plus / Voir moins -->
            <div class="flex">
                <p
                    :class="[
                        'text-sm leading-relaxed text-[var(--secondary-white)] sm:text-base md:text-base lg:text-lg dark:text-[var(--dark-grey)]',
                        animateHero ? 'translate-y-0 opacity-100 transition-all delay-200 duration-700 ease-out' : 'translate-y-10 opacity-0',
                    ]"
                >
                    {{ showFullText ? fullText : fullText.substring(0, previewLength) + '...' }}
                    <!-- <span> -->
                    <button
                        @click="showFullText = !showFullText"
                        class="gap-2 font-semibold text-orange-500 transition-transform duration-300 hover:underline"
                    >
                        {{ showFullText ? 'Voir moins' : 'Voir plus' }}
                    </button>
                    <!-- </span> -->
                </p>
            </div>
        </div>
    </section>

    <section class="mx-auto w-full bg-gray-100 pt-8 pb-2 dark:bg-[var(--dark-map2)]">
        <div class="mx-auto grid max-w-6xl grid-cols-2 gap-4 p-2">
            <!-- Bloc 1 -->
            <div
                class="group flex items-center space-x-2 rounded-lg bg-white p-4 shadow-md transition hover:bg-[var(--primary-blue)] hover:text-white dark:bg-[var(--dark-grey2)] dark:hover:bg-[var(--card-dark)]"
            >
                <Truck class="h-6 w-6 text-yellow-600 group-hover:text-[#FFE600] md:h-8 md:w-8" />
                <span class="text-sm text-gray-800 group-hover:text-gray-300 dark:text-[var(--text-grey)]"> Livraison rapide à partir de 3h </span>
            </div>

            <!-- Bloc 2 -->
            <div
                class="group flex items-center space-x-2 rounded-lg bg-white p-4 shadow-md transition hover:bg-[var(--primary-blue)] hover:text-white dark:bg-[var(--dark-grey2)] dark:hover:bg-[var(--card-dark)]"
            >
                <Shield class="h-6 w-6 text-yellow-600 group-hover:text-[#FFE600] md:h-8 md:w-8" />
                <span class="text-sm text-gray-800 group-hover:text-gray-300 dark:text-[var(--text-grey)]">
                    Produits authentiques 100% garantis
                </span>
            </div>

            <!-- Bloc 3 -->
            <div
                class="group flex items-center space-x-2 rounded-lg bg-white p-4 shadow-md transition hover:bg-[var(--primary-blue)] hover:text-white dark:bg-[var(--dark-grey2)] dark:hover:bg-[var(--card-dark)]"
            >
                <Headphones class="h-6 w-6 text-yellow-600 group-hover:text-[#FFE600] md:h-8 md:w-8" />
                <span class="text-sm text-gray-800 group-hover:text-gray-300 dark:text-[var(--text-grey)]">
                    Service après vente Walner Tech - SAV agréé
                </span>
            </div>

            <!-- Bloc 4 -->
            <div
                class="group flex items-center space-x-2 rounded-lg bg-white p-4 shadow-md transition hover:bg-[var(--primary-blue)] hover:text-white dark:bg-[var(--dark-grey2)] dark:hover:bg-[var(--card-dark)]"
            >
                <RotateCcw class="h-6 w-6 text-yellow-600 group-hover:text-[#FFE600] md:h-8 md:w-8" />
                <span class="text-sm text-gray-800 group-hover:text-gray-300 dark:text-[var(--text-grey)]">
                    Retour rapide et facile sur 7 jours
                </span>
            </div>
        </div>
    </section>
</template>
<!-- <script setup> -->

<!-- </script> -->
