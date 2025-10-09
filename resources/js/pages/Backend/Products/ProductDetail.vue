<!-- <template>
    <TopBanner />
    <NavbarFrontend :auth="$page.props.auth" class="mt-10 md:mt-12" />
    <BackButton class="m-4" />
    <LoginReminder />
    <div class=" bg-background-light dark:bg-dark-background text-text-dark dark:text-dark-white p-4 md:p-8">

        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">
           
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

      
            <div class="flex flex-col justify-between">
                <div>
                    <h1 class="text-2xl md:text-4xl font-bold mb-4">{{ product.title }}</h1>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">{{ product.description }}</p>
                    <p class="text-xl md:text-2xl font-semibold mb-6">{{ product.prix }} FCFA</p>
                </div>

      
                <div class="flex flex-col gap-4 md:flex-row">
                    <button @click="addToCart(product)"
                        class="bg-[var(--primary-blue)] dark:bg-dark-gold text-white py-2 px-6 rounded w-full md:w-auto hover:opacity-90 transition">
                        Ajouter au panier
                    </button>
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
import TopBanner from '@/components/frontend/TopBanner.vue';
import Footer from '@/components/frontend/Footer.vue';
import axios from 'axios';
import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faHeart } from '@fortawesome/free-regular-svg-icons';
library.add(faHeart);
import LoginReminder from '@/components/frontend/flash/LoginReminder.vue';
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
</script> -->


<template>
    <TopBanner />
    <NavbarFrontend :auth="$page.props.auth" class="mt-10 md:mt-12" />
    <BackButton class="m-4" />
    <LoginReminder />
    <section
        class="bg-background-light dark:bg-dark-background text-text-dark dark:text-dark-white p-4 md:p-8 min-h-screen">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Images -->
            <div class="flex flex-col md:flex-row gap-4">
                <!-- Miniatures -->
                <div
                    class="flex md:flex-col gap-3 overflow-x-auto md:overflow-y-auto md:h-[500px] md:w-[100px] scrollbar-hide">
                    <img v-for="(img, index) in product.images" :key="img.id" :src="getImageUrl(img.url_image)"
                        :alt="'Image ' + (index + 1)"
                        class="w-20 h-20 object-cover rounded-lg border cursor-pointer hover:opacity-90 transition"
                        :class="{ 'ring-2 ring-[var(--primary-blue)]': selectedImage === img.url_image }"
                        @click="selectedImage = img.url_image" loading="lazy" />
                </div>

                <!-- Image principale -->
                <div class="flex-1 flex items-center justify-center">
                    <img :src="getImageUrl(selectedImage)" :alt="product.title"
                        class="w-full h-80 md:h-[500px] object-contain rounded-lg shadow-lg transition-transform duration-300 hover:scale-105" />
                </div>
            </div>

            <!-- Infos produit -->
            <div class="flex flex-col justify-start md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-4">{{ product.title }}</h1>
                    <p class="text-gray-700 dark:text-gray-300 mb-4 leading-relaxed">{{ product.description }}</p>
                    <p class="text-2xl font-semibold text-[var(--primary-blue)] mb-6">{{ product.prix }} FCFA</p>
                </div>

                <!-- Bouton Ajouter au panier -->
                <div>
                    <button @click="addToCart(product)"
                        class="w-full md:w-auto bg-[var(--primary-blue)] dark:bg-dark-gold text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:opacity-90 transition">
                        Ajouter au panier
                    </button>
                </div>
            </div>
        </div>
    </section>

    <Footer />
</template>

<script setup>
import { ref, onMounted } from 'vue'
import NavbarFrontend from '@/components/frontend/NavbarFrontend.vue'
import TopBanner from '@/components/frontend/TopBanner.vue'
import Footer from '@/components/frontend/Footer.vue'
import BackButton from '@/components/frontend/BackButton.vue'
import LoginReminder from '@/components/frontend/flash/LoginReminder.vue'

const props = defineProps({
    product: Object,
    auth: Object
})

const selectedImage = ref(null)

onMounted(() => {
    selectedImage.value = props.product.images?.[0]?.url_image || '/fallback.png'
})

function getImageUrl(path) {
    return path ? `/storage/${path}` : '/fallback.png'
}

function addToCart(product) {
    let cart = JSON.parse(localStorage.getItem('cart') || '[]')
    const item = cart.find(p => p.id === product.id)
    if (item) item.quantity += 1
    else cart.push({ ...product, quantity: 1 })
    localStorage.setItem('cart', JSON.stringify(cart))
    alert('✅ Produit ajouté au panier !')
}
</script>

<style scoped>
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}

.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
