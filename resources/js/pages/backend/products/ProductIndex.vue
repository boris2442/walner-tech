<template>
    <Head :title="seo.title" />

    <!-- Loader -->
    <Loading v-if="showLoading" />

    <TopBanner />
    <NavbarFrontend :auth="$page.props.auth" class="mt-10 md:mt-12" />
    <FlashMessageFrontend v-if="$page.props.flash?.message" :message="$page.props.flash.message" :link="$page.props.flash.link" />

    <!-- Floating Action -->
    <FloatingAction />
    <FlashMessageNewsletter />
    <!-- Section Produits -->
    <section>
        <div class="dark:bg-dark-background dark:text-dark-white bg-background-light text-text-dark p-8 transition-colors duration-300">
            <!-- Barre de recherche -->

            <div class="relative mx-auto w-full max-w-md">
                <input v-model="search" @input="onSearchInput" type="text" placeholder="Rechercher un produit..." class="custom-input" />
                <font-awesome-icon icon="magnifying-glass" class="custom-icon" />
                <!-- Croix pour vider l'input, seulement si search n'est pas vide -->
                <button v-if="search" @click="search = ''" type="button" class="clear-btn">✕</button>
            </div>

            <!-- Liste des catégories -->
            <div class="mb-4 flex justify-start gap-3 overflow-x-auto px-2 whitespace-nowrap">
                <span
                    @click="filterByCategory('')"
                    :class="categoryButtonClass('')"
                    class="inline-block cursor-pointer px-4 py-2 text-sm font-medium transition-colors duration-300 dark:text-[var(--dark-grey)]"
                    >Tous</span
                >
                <span
                    v-for="cat in categories"
                    :key="cat.id"
                    @click="filterByCategory(cat.id)"
                    :class="categoryButtonClass(cat.id)"
                    class="inline-block cursor-pointer px-4 py-2 text-sm font-medium text-[var(--dark-blue)] transition-colors duration-300 dark:text-[var(--dark-grey)]"
                >
                    {{ cat.name }}
                </span>
            </div>

            <hr class="mb-6 border-t border-gray-300 dark:border-[var(--dark-grey)]" />

            <!-- Produits -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">
                <!-- Skeleton loader -->
                <template v-if="loading">
                    <div v-for="n in skeletonCount" :key="n" class="product-card flex flex-col overflow-hidden rounded shadow-md">
                        <div class="skeleton mb-3 h-40 w-full rounded"></div>
                        <div class="flex flex-1 flex-col p-3">
                            <div class="skeleton mb-2 h-4 w-3/4 rounded"></div>
                            <div class="skeleton h-3 w-1/2 rounded"></div>
                        </div>
                        <div class="mt-auto flex items-center justify-between p-3">
                            <div class="skeleton h-6 w-6 rounded-full"></div>
                            <div class="skeleton h-6 w-6 rounded-full"></div>
                        </div>
                    </div>
                </template>

                <!-- Produits réels -->
                <template v-else>
                    <div
                        v-for="product in filteredProducts"
                        :key="product.id"
                        :data-id="product.id"
                        class="product-card flex flex-col rounded transition-transform duration-300 hover:scale-105"
                        :class="darkMode ? 'border border-[var(--dark-grey)] bg-[var(--dark-background)] shadow-md' : 'bg-background-light shadow-md'"
                    >
                        <!-- Images -->
                        <div class="overflow-hidden rounded">
                            <swiper v-if="product.images.length > 1" :modules="[Autoplay, Pagination]" :autoplay="{ delay: 3000 }" pagination loop>
                                <swiper-slide v-for="img in product.images" :key="img.id">
                                    <Link :href="`/products/${product.slug}`" prefetch class="hover:underline">
                                        <img
                                            :src="getImageUrl(img.url_image)"
                                            :alt="product.title"
                                            loading="lazy"
                                            class="h-40 w-full rounded object-cover transition-transform duration-300 hover:scale-110"
                                        />
                                    </Link>
                                </swiper-slide>
                            </swiper>
                            <Link v-else :href="`/products/${product.slug}`" prefetch class="hover:underline">
                                <img
                                    :src="getImageUrl(product.images[0]?.url_image)"
                                    :alt="product.title"
                                    loading="lazy"
                                    class="h-40 w-full rounded object-cover transition-transform duration-300 hover:scale-110"
                                />
                            </Link>
                        </div>

                        <!-- Infos produit -->
                        <div class="flex flex-1 flex-col p-3">
                            <h3 class="mt-2 mb-1 truncate text-sm font-medium">{{ product.title }}</h3>
                            <!-- metttre la description et le prix en display flex -->
                            <div class="mt-1 flex justify-between">
                                <p class="dark:text-dark-grey text-[10px] text-gray-500">
                                    <span
                                        class="rounded-full border border-[var(--accent-cyan)] px-2 py-1 font-semibold text-[var(--accent-cyan)] dark:border-[var(--dark-grey)] dark:text-[var(--dark-grey)]"
                                    >
                                        {{ product.category.name }}</span
                                    >
                                </p>
                                <p class="text-sm font-bold" :class="darkMode ? 'text-dark-white' : 'text-text-dark'">{{ product.prix }} FCFA</p>
                            </div>
                        </div>

                        <!-- Boutons -->
                        <div class="mt-auto flex items-center justify-between p-3 py-1">
                            <button
                                @click="flyToCart($event, product)"
                                aria-label="Bouton ajout au panier"
                                title="ajout au panier"
                                class="text-[var(--accent-cyan)] transition-transform duration-200 hover:scale-125 active:scale-90 dark:text-white"
                            >
                                <font-awesome-icon :icon="['fas', 'cart-shopping']" />
                            </button>

                            <div class="mt-1 flex items-center gap-1 text-sm text-gray-500">
                                <Eye class="h-4 w-4 text-gray-400" />

                                <span class="text-xs">{{ product.views_count }} vue{{ product.views_count > 1 ? 's' : '' }}</span>
                            </div>

                            <button
                                @click="toggleLike(product)"
                                aria-label="Bouton liker le produit"
                                title="Liker le produit"
                                :class="[
                                    'transition-transform duration-200 hover:scale-125 active:scale-90',
                                    product.liked ? 'text-red-500' : 'text-[var(--accent-cyan)]',
                                ]"
                            >
                                <font-awesome-icon :icon="['far', 'heart']" />
                                <span class="ml-1 text-xs font-extrabold dark:text-[var(--dark-grey)]">{{ product.likes_count }}</span>
                            </button>
                        </div>
                        <div
                            class="m-2 flex items-center justify-center rounded-xl border-2 border-blue-700 px-3 py-2 text-center text-sm font-semibold text-blue-700 transition-colors duration-200 hover:bg-blue-700 hover:text-white"
                        >
                            <Link
                                :href="`/products/${product.slug}`"
                                prefetch
                                class="flex w-full items-center justify-center text-center dark:text-gray-300"
                            >
                                <ShoppingCartIcon class="animate-spin-slow mr-2" /> Voir plus
                            </Link>
                        </div>
                    </div>
                    <CartWidget />
                </template>
            </div>

            <div v-if="!loading && filteredProducts.length === 0" class="dark:text-dark-grey mt-6 text-center text-gray-500">
                Aucun produit trouvé
            </div>

            <!-- Panier -->
            <CartWidget />
        </div>
    </section>

    <Map2 />
    <HeroSection />
    <Service />
    <About2 />
    <Testimony />
    <LoginReminder />
    <Footer />

    <!-- Image volante -->
    <img
        v-if="flyingImage.show"
        :src="flyingImage.src"
        :style="{
            top: flyingImage.y + 'px',
            left: flyingImage.x + 'px',
            transform: 'translate(' + flyingImage.dx + 'px,' + flyingImage.dy + 'px) scale(0.2)',
            transition: 'transform 0.8s ease-in-out, opacity 0.8s ease-in-out',
            opacity: 1,
        }"
        class="pointer-events-none fixed z-50 h-20 w-20 rounded-lg"
    />
</template>

<script setup>
import About2 from '@/components/frontend/About2.vue';
import FlashMessageFrontend from '@/components/frontend/flash/FlashMessageFrontend.vue';
import LoginReminder from '@/components/frontend/flash/LoginReminder.vue';
import FloatingAction from '@/components/frontend/FloatingAction.vue';
import Footer from '@/components/frontend/Footer.vue';
import HeroSection from '@/components/frontend/HeroSection.vue';
import Loading from '@/components/frontend/Loading.vue';
import Map2 from '@/components/frontend/Map2.vue';
import NavbarFrontend from '@/components/frontend/NavbarFrontend.vue';
import CartWidget from '@/components/frontend/panier/CartWidget.vue';
import { cartStore } from '@/components/frontend/panier/stores/cart';
import Service from '@/components/frontend/Service.vue';
import Testimony from '@/components/frontend/Testimony.vue';
import TopBanner from '@/components/frontend/TopBanner.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import axios from 'axios';

import 'swiper/css';
import { Autoplay, Pagination } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { computed, onMounted, ref } from 'vue';

import FlashMessageNewsletter from '@/components/FlashMessageNewsletter.vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faHeart } from '@fortawesome/free-regular-svg-icons';
import { faCartShopping } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
library.add(faCartShopping, faHeart);

const props = defineProps({
    products: Array,
    categories: Array,
    filters: Object,
    auth: Object,
    seo: Object,
});

const search = ref(props.filters.search || '');
const selectedCategory = ref(props.filters.category || '');
const darkMode = ref(false);
const loading = ref(true);
const showLoading = ref(true);
const cart = ref([]);

const skeletonCount = computed(() => {
    if (window.innerWidth >= 1024) return 20;
    if (window.innerWidth >= 768) return 12;
    if (window.innerWidth >= 640) return 8;
    return 4;
});

// Image volante
const flyingImage = ref({ show: false, src: '', x: 0, y: 0, dx: 0, dy: 0 });

// Fonction pour générer un nombre de vues simulé

// 🚀 Initialisation au montage

onMounted(() => {
    const savedCart = localStorage.getItem('cart');
    if (savedCart) cart.value = JSON.parse(savedCart);

    darkMode.value = localStorage.getItem('darkMode') === 'true';

    const hasVisited = sessionStorage.getItem('hasVisited');
    if (!hasVisited) {
        showLoading.value = true;
        loading.value = true;
        setTimeout(() => {
            showLoading.value = false;
            setTimeout(() => {
                loading.value = false;
            }, 1000);
        }, 2000);
        sessionStorage.setItem('hasVisited', 'true');
    } else {
        showLoading.value = false;
        loading.value = true;
        setTimeout(() => {
            loading.value = false;
        }, 1000);
    }
});

// 🔍 Filtre des produits (basé sur les vrais produits, pas une copie)
const filteredProducts = computed(() => {
    return props.products.filter((product) => {
        const matchSearch = product.title.toLowerCase().includes(search.value.toLowerCase());
        const matchCategory = selectedCategory.value === '' || product.category_id === selectedCategory.value;
        return matchSearch && matchCategory;
    });
});

// Like
function toggleLike(product) {
    if (!props.auth?.user) {
        if (confirm('Vous devez être connecté pour aimer un produit.\nVoulez-vous vous connecter maintenant ?')) {
            router.visit('/login');
        }
        return;
    }
    axios
        .post(`/like/${product.id}`)
        .then((res) => {
            product.liked = res.data.liked;
            product.likes_count = res.data.likesCount;
        })
        .catch(() => {});
}

// Catégorie
function categoryButtonClass(id) {
    const selected = selectedCategory.value === id;
    return ['border-none', selected ? 'underline text-[var(--accent-cyan)]' : 'text-text-dark hover:text-[var(--accent-cyan)]'];
}

function filterByCategory(id) {
    selectedCategory.value = id;
}
function onSearchInput() {}

// Cart functions
function saveCart() {
    localStorage.setItem('cart', JSON.stringify(cart.value));
}

function addToCart(product) {
    const existing = cart.value.find((p) => p.id === product.id);
    if (existing) existing.quantity++;
    else cart.value.push({ ...product, quantity: 1 });
    saveCart();
}

function increaseQuantity(item) {
    item.quantity++;
    saveCart();
}
function decreaseQuantity(item) {
    if (item.quantity > 1) item.quantity--;
    else cart.value = cart.value.filter((p) => p.id !== item.id);
    saveCart();
}

// Image volante

function flyToCart(event, product) {
    // Vérifier si l'utilisateur est connecté
    if (!props.auth?.user) {
        // Afficher un alert ou confirmer la connexion
        if (confirm('Vous devez être connecté pour ajouter un produit au panier.\nVoulez-vous vous connecter maintenant ?')) {
            router.visit('/login');
        }
        return; // arrêter la fonction si pas connecté
    }

    const img = event.currentTarget.closest('.product-card').querySelector('img');
    const cartEl = document.querySelector('.fixed.bottom-6.right-6 button');
    if (!img || !cartEl) return;

    const imgRect = img.getBoundingClientRect();
    const cartRect = cartEl.getBoundingClientRect();
    const dx = cartRect.left + cartRect.width / 2 - (imgRect.left + imgRect.width / 2);
    const dy = cartRect.top + cartRect.height / 2 - (imgRect.top + imgRect.height / 2);

    flyingImage.value = { show: true, src: img.src, x: imgRect.left, y: imgRect.top, dx, dy };

    cartStore.add(product); // ✅ un seul panier global
    setTimeout(() => {
        flyingImage.value.show = false;
    }, 800);
}
// Images
function getImageUrl(path) {
    return path ? `/${path}` : '/fallback.png';
}

// count views
</script>

<style scoped>
.fade-slide-enter-active,
.fade-slide-leave-active {
    transition: all 0.3s ease;
}

.fade-slide-enter-from,
.fade-slide-leave-to {
    opacity: 0;
    transform: translateY(-20px);
}

.fade-slide-enter-to,
.fade-slide-leave-from {
    opacity: 1;
    transform: translateY(0);
}

.skeleton {
    background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 37%, #e0e0e0 63%);
    background-size: 400% 100%;
    animation: shimmer 1.4s ease infinite;
    border-radius: 8px;
}

.dark .skeleton {
    background: linear-gradient(90deg, #1e293b 25%, #334155 37%, #1e293b 63%);
    background-size: 400% 100%;
    animation: shimmer 1.4s ease infinite;
}

@keyframes shimmer {
    0% {
        background-position: -400px 0;
    }

    100% {
        background-position: 400px 0;
    }
}
</style>
