<template>
    <NavbarFrontend />
    <FloatingAction />
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
                <Link @click="filterByCategory('')" :class="[
                    'px-4 py-2 text-sm font-medium transition-colors duration-300 border-none',
                    selectedCategory === ''
                        ? (darkMode ? 'bg-[var(--dark-accent)] text-dark-white' : 'bg-accent-cyan text-white')
                        : (darkMode ? 'bg-dark-grey text-dark-white hover:bg-[var(--dark-accent)]/60' : 'bg-gray-200 text-text-dark hover:bg-[var(--accent-cyan)]/70 hover:text-white')
                ]">
                Tous
                </Link>
                <Link v-for="cat in categories" :key="cat.id" @click="filterByCategory(cat.id)" :class="[
                    'px-4 py-2 text-sm font-medium transition-colors duration-300 border-none',
                    selectedCategory === cat.id
                        ? (darkMode ? 'bg-[var(--dark-accent)] text-dark-white' : 'bg-accent-cyan text-white')
                        : (darkMode ? 'bg-dark-grey text-dark-white hover:bg-[var(--dark-accent)]/60' : 'bg-gray-200 text-text-dark hover:bg-[var(--accent-cyan)]/70 hover:text-white')
                ]">
                {{ cat.name }}
                </Link>
            </div>

            <!-- Trait séparateur sous les catégories -->
            <hr class="border-t border-gray-300 dark:border-dark-grey mb-6" />

            <!-- Skeleton Loader quand ça charge -->
            <div v-if="loading" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                <div v-for="n in 5" :key="n"
                    class="animate-pulse rounded p-3 bg-gray-200 dark:bg-dark-grey flex flex-col">
                    <div class="w-full h-40 bg-gray-300 dark:bg-dark-background rounded mb-3"></div>
                    <div class="h-4 bg-gray-300 dark:bg-dark-background rounded mb-2"></div>
                    <div class="h-3 bg-gray-300 dark:bg-dark-background rounded mb-1"></div>
                    <div class="h-3 bg-gray-300 dark:bg-dark-background rounded w-1/2"></div>
                </div>
            </div>

            <!-- Produits -->
            <div v-else class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                <div v-for="product in filteredProducts" :key="product.id"
                    :class="darkMode ? 'bg-dark-background shadow-md border border-dark-grey' : 'bg-background-light shadow-md'"
                    class="rounded flex flex-col transition-transform duration-300 hover:scale-105">

                    <!-- Zone image sans padding -->
                    <div class="-mx-3">
                        <!-- Swiper auto -->
                        <swiper v-if="product.images.length > 1" :modules="[Autoplay, Pagination]"
                            :autoplay="{ delay: 3000 }" pagination loop>
                            <swiper-slide v-for="img in product.images" :key="img.id">
                                <img :src="getImageUrl(img.url_image)" :alt="product.name"
                                    class="w-full h-40 object-contain transition-transform duration-300 hover:scale-110" />
                            </swiper-slide>
                        </swiper>

                        <!-- Si une seule image -->
                        <img v-else :src="getImageUrl(product.images[0]?.url_image)" :alt="product.name"
                            class="w-full h-40 object-contain transition-transform duration-300 hover:scale-110" />
                    </div>

                    <!-- Zone texte et boutons avec padding -->
                    <div class="p-3 flex flex-col flex-1">
                        <!-- Titre -->
                        <h3 class="dark:text-(var[--dark-white]) text-text-dark mt-2 font-medium text-sm truncate">
                            {{ product.title }}
                        </h3>

                        <!-- Description -->
                        <p :class="darkMode ? 'text-dark-grey' : 'text-text-secondary'"
                            class="text-xs mt-1 line-clamp-3">
                            {{ product.description }}
                        </p>

                        <!-- Prix -->
                        <p :class="darkMode ? 'text-dark-white' : 'text-text-dark'" class="text-sm font-semibold mt-2">
                            {{ product.prix }} FCFA
                        </p>

                        <!-- Boutons Like & Panier -->
                        <div class="mt-auto flex justify-between items-center">
                            <button
                                class="transition-transform duration-200 hover:scale-125 active:scale-90 text-[var(--accent-cyan)] dark:text-[var(--dark-gold)]">
                                <font-awesome-icon :icon="['fas', 'cart-shopping']" />
                            </button>
                            <button
                                class="transition-transform duration-200 hover:scale-125 active:scale-90 text-[var(--accent-cyan)] dark:text-[var(--dark-gold)]">
                                <font-awesome-icon :icon="['far', 'heart']" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Message quand aucun produit trouvé -->
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
import "swiper/css/pagination";
import { Autoplay, Pagination } from "swiper/modules";
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faCartShopping } from '@fortawesome/free-solid-svg-icons'
import { faHeart } from '@fortawesome/free-regular-svg-icons'
import NavbarFrontend from '@/components/frontend/NavbarFrontend.vue';
import Footer from '@/components/frontend/Footer.vue';
import FloatingAction from '@/components/frontend/FloatingAction.vue';
import { Link } from '@inertiajs/vue3';
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

// Simulation de chargement
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

// Filtrage dynamique côté front
const filteredProducts = computed(() => {
    return props.products.filter(product => {
        const matchSearch = product.title.toLowerCase().includes(search.value.toLowerCase());
        const matchCategory = selectedCategory.value === '' || product.category_id === selectedCategory.value;
        return matchSearch && matchCategory;
    });
});
</script>

<style scoped>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
