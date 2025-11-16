<script setup>
import 'swiper/css';
import 'swiper/css/pagination';
import { Autoplay } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/vue';

const testimonials = [
    {
        name: 'Boris Aubin',
        role: 'Developpeur Web',
        image: '/assets/aubin.jpg',
        rating: 5,
        feedback: 'J’ai acheté un smartphone chez Walner Tech et la qualité est exceptionnelle !',
    },
    {
        name: 'Yannick Nguimfack',
        role: 'Hebergeur web/ Developpeur back-end',
        image: '/assets/yannick22.jpg',
        rating: 5,
        feedback: 'L’équipe de Walner Tech m’a conseillé le meilleur produit selon mes besoins.',
    },
    {
        name: 'George wagne',
        role: 'Entrepreneur Digital',
        image: '/assets/wagne.jpg',
        rating: 5,
        feedback: 'Des prix compétitifs pour des produits de grande qualité. Je recommande !',
    },
    {
        name: 'Miguel Tchinda',
        role: 'Etudiant',
        image: '/assets/miguel.jpg',
        rating: 5,
        feedback: 'Navigation facile sur le site, commande rapide et produits bien emballés.',
    },
    {
        name: 'David Wilson',
        role: 'Founder at StartUpHub',
        image: '/assets/yannick22.jpg',
        rating: 5,
        feedback: 'Site fiable et produits authentiques, je fais toujours mes achats chez Walner Tech.',
    },
    {
        name: 'Olivia Martinez',
        role: 'Project Manager',
        image: '/assets/aubin.jpg',
        rating: 5,
        feedback: 'Service impeccable, je suis client depuis plusieurs années et je recommande vivement !',
    },
];
</script>

<template>
    <section class="bg-[var(--background-light)] pb-16 dark:bg-[var(--dark-background)]" id="testimonials">
        <div class="container mx-auto px-6 text-center">
            <!-- Titre -->
            <h2 class="mb-12 text-2xl font-bold text-[var(--primary-blue)] sm:text-3xl dark:text-[var(--dark-white)]">
                <span class="text-[var(--highlight-gold)]">Les retours</span> de nos clients
            </h2>

            <!-- Slider -->
            <Swiper
                :modules="[Autoplay]"
                :slides-per-view="1"
                :space-between="20"
                :loop="true"
                :autoplay="{ delay: 3000, disableOnInteraction: false }"
                :breakpoints="{
                    768: { slidesPerView: 2, spaceBetween: 20 },
                    1024: { slidesPerView: 3, spaceBetween: 30 },
                }"
                class="pb-10"
            >
                <SwiperSlide v-for="(t, index) in testimonials" :key="index">
                    <div
                        class="group flex h-full flex-col rounded-xl bg-white p-6 shadow-md transition hover:bg-[var(--primary-blue)] hover:text-white hover:shadow-lg dark:bg-[#2A2A2A] dark:hover:bg-[var(--card-dark)]"
                    >
                        <!-- Image + nom + role -->
                        <div class="mb-4 flex items-center gap-4">
                            <img
                                :src="t.image"
                                :alt="t.name"
                                loading="lazy"
                                class="h-12 w-12 rounded-full border-2 border-[var(--highlight-gold)] object-cover"
                            />
                            <div class="text-left">
                                <h3 class="font-semibold text-[var(--primary-blue)] group-hover:text-[#FFE600] dark:text-[var(--dark-white)]">
                                    {{ t.name }}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-300">
                                    {{ t.role }}
                                </p>
                            </div>
                        </div>

                        <!-- Etoiles -->
                        <div class="mb-3 flex text-yellow-400">
                            <span v-for="n in t.rating" :key="n">⭐</span>
                        </div>

                        <!-- Feedback -->
                        <p class="flex-grow text-left text-sm text-gray-600 group-hover:text-gray-300 dark:text-gray-400">
                            {{ t.feedback }}
                        </p>
                    </div>
                </SwiperSlide>
            </Swiper>
        </div>
    </section>
</template>
