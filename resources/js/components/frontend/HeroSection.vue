<script setup>
import { ref, onMounted, nextTick } from 'vue';
import { Link } from '@inertiajs/vue3';
import { products } from '@/routes';
import { Truck, Shield, Headphones, RotateCcw } from 'lucide-vue-next'
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
    <section class="relative flex items-start bg-cover bg-center bg-no-repeat
            px-6 md:px-16 lg:px-32 pt-4 md:pt-32 lg:pt-40 overflow-hidden
            dark:bg-[var(--dark-background)] dark:text-[#e0e7ff] bg-[#3b3975] pb-10"
        style="background-image: url('/herop2.png'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed;">

        <div class="absolute inset-0 bg-blue-900/70 "></div>

        <div class="relative z-10 flex flex-col gap-6 max-w-4xl transform -translate-x-2 md:-translate-x-0">
            <h1 :class="[
                'text-2xl sm:text-3xl md:text-4xl lg:text-5xl max-w-3xl font-extrabold leading-snug drop-shadow-xl tracking-tight text-[var(--secondary-white)] dark:text-[var(--dark-grey)]',
                animateHero ? 'opacity-100 translate-y-0 transition-all duration-700 ease-out' : 'opacity-0 translate-y-10'
            ]">
                Walner Tech: <br class="sm:block">Votre expert en équipements informatiques
            </h1>

            <!-- Paragraphe avec Voir plus / Voir moins -->
            <div class="flex">
                <p :class="[
                    'text-sm sm:text-base md:text-base lg:text-lg leading-relaxed text-[var(--secondary-white)] dark:text-[var(--dark-grey)]',
                    animateHero ? 'opacity-100 translate-y-0 transition-all duration-700 ease-out delay-200' : 'opacity-0 translate-y-10'
                ]">
                    {{ showFullText ? fullText : fullText.substring(0, previewLength) + '...' }}
                    <!-- <span> -->
                    <button @click="showFullText = !showFullText"
                        class=" gap-2  text-orange-500 font-semibold  hover:underline transition-transform duration-300">
                        {{ showFullText ? 'Voir moins' : 'Voir plus' }}

                    </button>
                    <!-- </span> -->
                </p>
            </div>



        </div>
    </section>


    <section class="bg-gray-100 pt-8 pb-2 mx-auto w-full dark:bg-[var(--dark-map2)]">
        <div class="flex flex-wrap gap-4 p-2 items-center justify-center ">

            <!-- Bloc 1 -->
            <div
                class="flex items-center space-x-2 w-full sm:w-1/2  bg-white p-4 rounded-lg shadow-md md:w-[300px] dark:bg-[var(--dark-grey2)] dark:hover:bg-[var(--card-dark)]">
                <Truck class="w-6 h-6 md:w-8 md:h-8 text-yellow-600" />
                <span class="text-sm  text-gray-800 dark:text-[var(--text-grey)]">Livraison rapide à partir de 3h</span>
            </div>

            <!-- Bloc 2 -->
            <div
                class="flex items-center space-x-2 w-full sm:w-1/2 md:w-[300px] bg-white p-4 rounded-lg shadow-md dark:bg-[var(--dark-grey2)] dark:hover:bg-[var(--card-dark)]">
                <Shield class="w-6 h-6 md:w-8 md:h-8 text-yellow-600" />
                <span class="text-sm  text-gray-800 dark:text-[var(--text-grey)] ">Produits authentiques 100%
                    garantis</span>
            </div>

            <!-- Bloc 3 -->
            <div
                class="flex items-center space-x-2 w-full sm:w-1/2 md:w-[300px] bg-white p-4 rounded-lg shadow-md dark:bg-[var(--dark-grey2)] dark:hover:bg-[var(--card-dark)]">
                <Headphones class="w-6 h-6 md:w-8 md:h-8 text-yellow-600" />
                <span class="text-sm  text-gray-800 dark:text-[var(--text-grey)]">Service après vente walnertech - SAV
                    agréé</span>
            </div>

            <!-- Bloc 4 -->
            <div
                class="flex items-center space-x-2 w-full sm:w-1/2 md:w-[300px] bg-white p-4 rounded-lg shadow-md dark:bg-[var(--dark-grey2)] dark:hover:bg-[var(--card-dark)]">
                <RotateCcw class="w-6 h-6 md:w-8 md:h-8 text-yellow-600" />
                <span class="text-sm  text-gray-800 dark:text-[var(--text-grey)]">Retour rapide et facile sur 7
                    jours</span>
            </div>

        </div>
    </section>

</template>
<!-- <script setup> -->

<!-- </script> -->