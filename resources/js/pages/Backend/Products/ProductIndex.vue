<!-- <template>
    <NavbarFrontend />
    <FloatingAction />
    <section>
        <div
            class="dark:bg-dark-background dark:text-dark-white bg-background-light text-text-dark p-4 min-h-screen transition-colors duration-300">
            <h1 class="text-xl font-semibold mb-6">Liste des produits</h1>

           
            <FlashMessage v-if="$page.props.flash?.success" :message="$page.props.flash.success" type="success" />
            <FlashMessage v-if="$page.props.flash?.error" :message="$page.props.flash.error" type="error" />

           
            <div class="mb-6 flex justify-center">
                <input v-model="search" @input="updateFilters" type="text" placeholder="Rechercher un produit..."
                    :class="darkMode ? 'border-dark-grey bg-dark-background text-dark-white placeholder-dark-grey focus:ring-dark-accent' : 'border-text-secondary bg-background-light text-text-dark placeholder-text-secondary focus:ring-accent-cyan'"
                    class="border rounded px-3 py-1 w-full max-w-md focus:outline-none focus:ring-2 transition-colors duration-300" />
            </div>


            <div class="flex flex-wrap gap-3 justify-center mb-4">
                <button @click="filterByCategory('')" :class="[
                    'px-4 py-2 text-sm font-medium transition-colors duration-300 border-none',
                    selectedCategory === ''
                        ? (darkMode ? 'bg-[var(--dark-accent)] text-dark-white' : 'bg-accent-cyan text-white')
                        : (darkMode ? 'bg-[var(--dark-grey)] text-dark-white hover:bg-[var(--dark-accent)]/60' : 'bg-gray-200 text-text-dark hover:bg-[var(--accent-cyan)]/70 hover:text-white')
                ]">
                    Tous
                </button>
                <button v-for="cat in categories" :key="cat.id" @click="filterByCategory(cat.id)" :class="[
                    'px-4 py-2 text-sm font-medium transition-colors duration-300 border-none',
                    selectedCategory === cat.id
                        ? (darkMode ? 'bg-[var(--dark-accent)] text-dark-white' : 'bg-accent-cyan text-white')
                        : (darkMode ? 'bg-[var(--dark-grey)] text-dark-white hover:bg-[var(--dark-accent)]/60' : 'bg-gray-200 text-text-dark hover:bg-[var(--accent-cyan)]/70 hover:text-white')
                ]">
                    {{ cat.name }}
                </button>
            </div>

        
            <hr class="border-t border-gray-300 dark:border-[var(--dark-grey)] mb-6" />

          
            <div v-if="loading" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                <div v-for="n in 5" :key="n"
                    class="animate-pulse rounded p-3 bg-gray-200 dark:bg-[var(--dark-grey)] flex flex-col">
                    <div class="w-full h-40 bg-gray-300 dark:bg-dark-background rounded mb-3"></div>
                    <div class="h-4 bg-gray-300 dark:bg-dark-background rounded mb-2"></div>
                    <div class="h-3 bg-gray-300 dark:bg-dark-background rounded mb-1"></div>
                    <div class="h-3 bg-gray-300 dark:bg-dark-background rounded w-1/2"></div>
                </div>
            </div>

    
            <div v-else class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                <div v-for="product in filteredProducts" :key="product.id"
                    :class="darkMode ? 'bg-[var(--dark-background)] shadow-md border border-[var(--dark-grey)]' : 'bg-background-light shadow-md'"
                    class="rounded flex flex-col transition-transform duration-300 hover:scale-105">

            
                    <div class=" overflow-hidden rounded">
                       
                        <swiper v-if="product.images.length > 1" :modules="[Autoplay, Pagination]"
                            :autoplay="{ delay: 3000 }" pagination loop>
                            <swiper-slide v-for="img in product.images" :key="img.id">
                                <img :src="getImageUrl(img.url_image)" :alt="product.name"
                                    class="w-full h-40 object-cover transition-transform duration-300 hover:scale-110 rounded" />
                            </swiper-slide>
                        </swiper>

                     
                        <img v-else :src="getImageUrl(product.images[0]?.url_image)" :alt="product.name"
                            class="w-full h-40 object-cover transition-transform duration-300 hover:scale-110 rounded" />
                    </div>

              
                    <div class="p-3 flex flex-col flex-1">
                    
                        <h3 class="dark:text-(var[--dark-white]) text-text-dark mt-2 font-medium text-sm truncate">
                            {{ product.title }}
                        </h3>

             
                        <p :class="darkMode ? 'text-[var(--dark-grey)]' : 'text-text-secondary'"
                            class="text-xs mt-1 line-clamp-3">
                            {{ product.description }}
                        </p>

                   
                        <p :class="darkMode ? 'text-dark-white' : 'text-text-dark'" class="text-sm font-semibold mt-2">
                            {{ product.prix }} FCFA
                        </p>

                    
                        <div class="mt-auto flex justify-between items-center">
                            <button
                                class="transition-transform duration-200 hover:scale-125 active:scale-90 text-[var(--accent-cyan)] dark:text-[var(--dark-gold)]">
                                <font-awesome-icon :icon="['fas', 'cart-shopping']" />
                            </button>
                         

                            <button @click="toggleLike(product)"
                                :class="['transition-transform duration-200 hover:scale-125 active:scale-90', product.liked ? 'text-red-500' : 'text-[var(--accent-cyan)]']">
                                <font-awesome-icon :icon="['far', 'heart']" />
                                <span class="ml-1 text-sm">{{ product.likes_count }}</span>
                            </button>

                        </div>
                    </div>
                </div>
            </div>

        
            <div v-if="!loading && filteredProducts.length === 0"
                class="text-center mt-6 text-gray-500 dark:text-dark-grey">
                Aucun produit trouvé
            </div>
        </div>
    </section>
    <Footer />
</template>

<script setup>
import FlashMessage from '@/components/backend/flash/FlashMessage.vue';
import { ref, onMounted, computed } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/css";
import axios from 'axios';

import "swiper/css/pagination";
import { Autoplay, Pagination } from "swiper/modules";
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faCartShopping } from '@fortawesome/free-solid-svg-icons'
import { faHeart } from '@fortawesome/free-regular-svg-icons'
import NavbarFrontend from '@/components/frontend/NavbarFrontend.vue';
import Footer from '@/components/frontend/Footer.vue';
import FloatingAction from '@/components/frontend/FloatingAction.vue';
library.add(faCartShopping, faHeart)

const props = defineProps({
    products: Array,
    categories: Array,
    filters: Object
});

const search = ref(props.filters.search || '');
const selectedCategory = ref(props.filters.category || '');
const darkMode = ref(false);
const loading = ref(true);

onMounted(() => {
    darkMode.value = localStorage.getItem('darkMode') === 'true';
    setTimeout(() => loading.value = false, 1500)
});

function getImageUrl(path) {
    return path ? `/storage/${path}` : '/fallback.png';
}

function updateFilters() {
    Inertia.get('/products', { search: search.value, category: selectedCategory.value }, { preserveState: true, replace: true });
}

function filterByCategory(id) {
    selectedCategory.value = id;
    updateFilters();
}


const filteredProducts = computed(() => {
    return props.products.filter(product => {
        const matchSearch = product.title.toLowerCase().includes(search.value.toLowerCase());
        const matchCategory = selectedCategory.value === '' || product.category_id === selectedCategory.value;
        return matchSearch && matchCategory;
    });
});



function toggleLike(product) {
    axios.post(`/like/${product.id}`).then(res => {
        product.liked = res.data.liked;
        product.likes_count = res.data.likesCount;
    });
}

</script>

<style scoped>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style> -->


<template>
    <NavbarFrontend />

    <section>
        <div
            class="dark:bg-dark-background dark:text-dark-white bg-background-light text-text-dark p-4 min-h-screen transition-colors duration-300">
            <h1 class="text-xl font-semibold mb-6">Liste des produits</h1>

            <!-- Flash global -->
            <FlashMessage v-if="$page.props.flash?.success" :message="$page.props.flash.success" type="success" />
            <FlashMessage v-if="$page.props.flash?.error" :message="$page.props.flash.error" type="error" />

            <!-- Barre de recherche -->
            <div class="mb-6 flex justify-center">
                <input v-model="search" @input="updateFilters" type="text" placeholder="Rechercher un produit..."
                    :class="darkMode ? 'border-dark-grey bg-dark-background text-dark-white placeholder-dark-grey focus:ring-dark-accent' : 'border-text-secondary bg-background-light text-text-dark placeholder-text-secondary focus:ring-accent-cyan'"
                    class="border rounded px-3 py-1 w-full max-w-md focus:outline-none focus:ring-2 transition-colors duration-300" />
            </div>

            <!-- Liste des catégories -->
            <div class="flex flex-wrap gap-3 justify-center mb-4">
                <button @click="filterByCategory('')" :class="categoryButtonClass('')">Tous</button>
                <button v-for="cat in categories" :key="cat.id" @click="filterByCategory(cat.id)"
                    :class="categoryButtonClass(cat.id)">
                    {{ cat.name }}
                </button>
            </div>

            <hr class="border-t border-gray-300 dark:border-[var(--dark-grey)] mb-6" />

            <!-- Skeleton Loader -->
            <div v-if="loading" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                <div v-for="n in 5" :key="n"
                    class="animate-pulse rounded p-3 bg-gray-200 dark:bg-[var(--dark-grey)] flex flex-col">
                    <div class="w-full h-40 bg-gray-300 dark:bg-dark-background rounded mb-3"></div>
                    <div class="h-4 bg-gray-300 dark:bg-dark-background rounded mb-2"></div>
                    <div class="h-3 bg-gray-300 dark:bg-dark-background rounded mb-1"></div>
                    <div class="h-3 bg-gray-300 dark:bg-dark-background rounded w-1/2"></div>
                </div>
            </div>

            <!-- Produits -->
            <div v-else class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                <div v-for="product in filteredProducts" :key="product.id"
                    class="product-card rounded flex flex-col transition-transform duration-300 hover:scale-105"
                    :class="darkMode ? 'bg-[var(--dark-background)] shadow-md border border-[var(--dark-grey)]' : 'bg-background-light shadow-md'">

                    <!-- Images -->
                    <div class="overflow-hidden rounded">
                        <swiper v-if="product.images.length > 1" :modules="[Autoplay, Pagination]"
                            :autoplay="{ delay: 3000 }" pagination loop>
                            <swiper-slide v-for="img in product.images" :key="img.id">
                                <img :src="getImageUrl(img.url_image)" :alt="product.title"
                                    class="w-full h-40 object-cover transition-transform duration-300 hover:scale-110 rounded" />
                            </swiper-slide>
                        </swiper>
                        <img v-else :src="getImageUrl(product.images[0]?.url_image)" :alt="product.title"
                            class="w-full h-40 object-cover transition-transform duration-300 hover:scale-110 rounded" />
                    </div>

                    <!-- Infos produit -->
                    <div class="p-3 flex flex-col flex-1">
                        <h3 class="text-sm font-medium truncate mt-2">{{ product.title }}</h3>
                        <p class="text-xs mt-1 line-clamp-3"
                            :class="darkMode ? 'text-[var(--dark-grey)]' : 'text-text-secondary'">{{ product.description
                            }}</p>
                        <p class="text-sm font-semibold mt-2" :class="darkMode ? 'text-dark-white' : 'text-text-dark'">
                            {{ product.prix }} FCFA</p>

                        <!-- Boutons -->
                        <div class="mt-auto flex justify-between items-center">
                            <button @click="flyToCart(product, $event)"
                                class="transition-transform duration-200 hover:scale-125 active:scale-90 text-[var(--accent-cyan)] dark:text-[var(--dark-gold)]">
                                <font-awesome-icon :icon="['fas', 'cart-shopping']" />
                            </button>

                            <button @click="toggleLike(product)"
                                :class="['transition-transform duration-200 hover:scale-125 active:scale-90', product.liked ? 'text-red-500' : 'text-[var(--accent-cyan)]']">
                                <font-awesome-icon :icon="['far', 'heart']" />
                                <span class="ml-1 text-sm">{{ product.likes_count }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aucun produit -->
            <div v-if="!loading && filteredProducts.length === 0"
                class="text-center mt-6 text-gray-500 dark:text-dark-grey">
                Aucun produit trouvé
            </div>
        </div>

        <!-- Panier flottant -->
        <div class="fixed bottom-6 right-6 z-50">
            <button ref="cartButton"
                class="relative bg-accent-cyan dark:bg-dark-gold rounded-full w-12 h-12 flex items-center justify-center text-white shadow-lg">
                <font-awesome-icon :icon="['fas', 'cart-shopping']" class="text-2xl" />
                <span v-if="cart.length"
                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                    {{ totalItems }}
                </span>
            </button>
        </div>

    </section>

    <Footer />
</template>

<script setup>
import FlashMessage from '@/components/backend/flash/FlashMessage.vue';
import { ref, onMounted, computed } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/css";
import "swiper/css/pagination";
import { Autoplay, Pagination } from "swiper/modules";
import axios from 'axios';
import NavbarFrontend from '@/components/frontend/NavbarFrontend.vue';
import Footer from '@/components/frontend/Footer.vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faCartShopping } from '@fortawesome/free-solid-svg-icons';
import { faHeart } from '@fortawesome/free-regular-svg-icons';
library.add(faCartShopping, faHeart);

const props = defineProps({
    products: Array,
    categories: Array,
    filters: Object
});

const search = ref(props.filters.search || '');
const selectedCategory = ref(props.filters.category || '');
const darkMode = ref(false);
const loading = ref(true);

const cartButton = ref(null);
const cart = ref(JSON.parse(localStorage.getItem('cart') || '[]'));
const totalItems = computed(() => cart.value.reduce((acc, item) => acc + item.quantity, 0));

onMounted(() => {
    darkMode.value = localStorage.getItem('darkMode') === 'true';
    setTimeout(() => loading.value = false, 1500);
});

function getImageUrl(path) {
    return path ? `/storage/${path}` : '/fallback.png';
}

function updateFilters() {
    Inertia.get('/products', { search: search.value, category: selectedCategory.value }, { preserveState: true, replace: true });
}

function filterByCategory(id) {
    selectedCategory.value = id;
    updateFilters();
}

function categoryButtonClass(id) {
    const base = 'px-4 py-2 text-sm font-medium transition-colors duration-300 border-none';
    if (selectedCategory.value === id) {
        return darkMode.value ? `${base} bg-[var(--dark-accent)] text-dark-white` : `${base} bg-accent-cyan text-white`;
    } else {
        return darkMode.value ? `${base} bg-[var(--dark-grey)] text-dark-white hover:bg-[var(--dark-accent)]/60` : `${base} bg-gray-200 text-text-dark hover:bg-[var(--accent-cyan)]/70 hover:text-white`;
    }
}

// Filtrage dynamique côté front
const filteredProducts = computed(() => {
    return props.products.filter(product => {
        const matchSearch = product.title.toLowerCase().includes(search.value.toLowerCase());
        const matchCategory = selectedCategory.value === '' || product.category_id === selectedCategory.value;
        return matchSearch && matchCategory;
    });
});

// Like
function toggleLike(product) {
    axios.post(`/like/${product.id}`).then(res => {
        product.liked = res.data.liked;
        product.likes_count = res.data.likesCount;
    });
}

// Fly to cart
function flyToCart(product, event) {
    const img = event.target.closest('.product-card').querySelector('img');
    if (!img) return;

    const imgRect = img.getBoundingClientRect();
    const clone = img.cloneNode();
    clone.style.position = 'fixed';
    clone.style.top = imgRect.top + 'px';
    clone.style.left = imgRect.left + 'px';
    clone.style.width = imgRect.width + 'px';
    clone.style.height = imgRect.height + 'px';
    clone.style.transition = 'all 0.7s ease-in-out';
    clone.style.zIndex = 1000;

    // Info produit
    const info = document.createElement('div');
    info.innerHTML = `<p style="color:white;font-size:12px;margin:0;">${product.title}</p>
                      <p style="color:white;font-size:12px;margin:0;">${product.prix} FCFA</p>`;
    info.style.position = 'absolute';
    info.style.bottom = '0';
    info.style.left = '0';
    clone.appendChild(info);

    document.body.appendChild(clone);

    const cartRect = cartButton.value.getBoundingClientRect();

    setTimeout(() => {
        clone.style.top = cartRect.top + 'px';
        clone.style.left = cartRect.left + 'px';
        clone.style.width = '30px';
        clone.style.height = '30px';
        clone.style.opacity = '0.5';
    }, 50);

    clone.addEventListener('transitionend', () => {
        document.body.removeChild(clone);
        // Ajouter au panier local
        const item = cart.value.find(p => p.id === product.id);
        if (item) item.quantity += 1;
        else cart.value.push({ ...product, quantity: 1 });
        localStorage.setItem('cart', JSON.stringify(cart.value));
    });
}
</script>

<style scoped>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
