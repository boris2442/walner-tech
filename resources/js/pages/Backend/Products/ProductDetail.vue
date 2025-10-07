<template>
    <NavbarFrontend :auth="$page.props.auth" />
      <BackButton class="m-4" />
    <div class=" bg-background-light dark:bg-dark-background text-text-dark dark:text-dark-white p-4 md:p-8">

        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Images -->
            <div>
                <swiper v-if="product.images.length > 1" :modules="[Autoplay, Pagination]" :autoplay="{ delay: 3000 }"
                    pagination loop>
                    <swiper-slide v-for="img in product.images" :key="img.id">
                        <img :src="getImageUrl(img.url_image)" :alt="product.title"
                            class="w-full h-80 md:h-[500px] object-cover rounded" />
                    </swiper-slide>
                </swiper>
                <img v-else :src="getImageUrl(product.images[0]?.url_image)" :alt="product.title"
                    class="w-full h-80 md:h-[500px] object-cover rounded" />
            </div>

            <!-- Infos produit -->
            <div class="flex flex-col justify-between">
                <div>
                    <h1 class="text-2xl md:text-4xl font-bold mb-4">{{ product.title }}</h1>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">{{ product.description }}</p>
                    <p class="text-xl md:text-2xl font-semibold mb-6">{{ product.prix }} FCFA</p>
                </div>

                <!-- Boutons actions -->
                <div class="flex flex-col gap-4 md:flex-row">
                    <button @click="addToCart(product)"
                        class="bg-[var(--primary-blue)] dark:bg-dark-gold text-white py-2 px-6 rounded w-full md:w-auto hover:opacity-90 transition">
                        Ajouter au panier
                    </button>

                    <!-- <button @click="toggleLike(product)"
                        :class="['border border-[var(--accent-cyan)] py-2 px-6 rounded w-full md:w-auto', product.liked ? 'bg-red-500 text-white' : 'text-[var(--accent-cyan)]']">
                        <font-awesome-icon :icon="['far', 'heart']" /> <span class="ml-2">{{ product.likes_count
                            }}</span>
                    </button> -->
                </div>
            </div>
        </div>

    </div>
    <Footer />
</template>

<script setup>
import { ref } from 'vue';
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/css";
import { Autoplay, Pagination } from "swiper/modules";
import NavbarFrontend from '@/components/frontend/NavbarFrontend.vue';
import Footer from '@/components/frontend/Footer.vue';
import axios from 'axios';
import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faHeart } from '@fortawesome/free-regular-svg-icons';
library.add(faHeart);
import BackButton from '@/components/frontend/BackButton.vue';
const props = defineProps({
    product: Object,
    auth: Object,
});

function getImageUrl(path) {
    return path ? `/storage/${path}` : '/fallback.png';
}

function addToCart(product) {
    let cart = JSON.parse(localStorage.getItem('cart') || '[]');
    const item = cart.find(p => p.id === product.id);
    if (item) item.quantity += 1;
    else cart.push({ ...product, quantity: 1 });
    localStorage.setItem('cart', JSON.stringify(cart));
    alert('Produit ajouté au panier !');
}

function toggleLike(product) {
    axios.post(`/like/${product.id}`).then(res => {
        product.liked = res.data.liked;
        product.likes_count = res.data.likesCount;
    });
}
</script>
