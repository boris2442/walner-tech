<template>

    <Head :title="seo.title" />

    <!-- Loader -->
    <Loading v-if="showLoading" />

    <TopBanner />
    <NavbarFrontend :auth="$page.props.auth" class="mt-10 md:mt-12" />
    <FlashMessageFrontend v-if="$page.props.flash?.message" :message="$page.props.flash.message"
        :link="$page.props.flash.link" />

    <!-- Floating Action -->
    <FloatingAction />

    <!-- Section Produits -->
    <section>
        <div
            class="dark:bg-dark-background dark:text-dark-white bg-background-light text-text-dark p-8 transition-colors duration-300">

            <!-- Barre de recherche -->


            <div class="relative w-full max-w-md mx-auto">
                <input v-model="search" @input="onSearchInput" type="text" placeholder="Rechercher un produit..." class="w-full pl-10 pr-4 py-2 rounded-2xl border border-gray-300 dark:border-gray-700
           bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100
           placeholder-gray-400 dark:placeholder-gray-500
           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
           transition-all duration-300 shadow-sm hover:shadow-md" />
                <font-awesome-icon icon="magnifying-glass"
                    class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 dark:text-gray-500" />
            </div>


            <!-- Liste des catégories -->
            <div class="flex gap-3 justify-start mb-4 overflow-x-auto whitespace-nowrap px-2">
                <span @click="filterByCategory('')" :class="categoryButtonClass('')"
                    class="inline-block cursor-pointer px-4 py-2 text-sm font-medium transition-colors duration-300 dark:text-[var(--dark-grey)]">Tous</span>
                <span v-for="cat in categories" :key="cat.id" @click="filterByCategory(cat.id)"
                    :class="categoryButtonClass(cat.id)"
                    class="inline-block cursor-pointer px-4 py-2 text-sm font-medium transition-colors duration-300 text-[var(--dark-blue)] dark:text-[var(--dark-grey)]">
                    {{ cat.name }}
                </span>
            </div>

            <hr class="border-t border-gray-300 dark:border-[var(--dark-grey)] mb-6" />

            <!-- Produits -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">

                <!-- Skeleton loader -->
                <template v-if="loading">
                    <div v-for="n in skeletonCount" :key="n"
                        class="product-card rounded flex flex-col shadow-md overflow-hidden">
                        <div class="h-40 w-full rounded mb-3 skeleton"></div>
                        <div class="p-3 flex flex-col flex-1">
                            <div class="h-4 rounded w-3/4 mb-2 skeleton"></div>
                            <div class="h-3 rounded w-1/2 skeleton"></div>
                        </div>
                        <div class="mt-auto flex justify-between items-center p-3">
                            <div class="h-6 w-6 rounded-full skeleton"></div>
                            <div class="h-6 w-6 rounded-full skeleton"></div>
                        </div>
                    </div>
                </template>

                <!-- Produits réels -->
                <template v-else>
                    <div v-for="product in filteredProducts" :key="product.id"
                        class="product-card rounded flex flex-col transition-transform duration-300 hover:scale-105"
                        :class="darkMode ? 'bg-[var(--dark-background)] shadow-md border border-[var(--dark-grey)]' : 'bg-background-light shadow-md'">

                        <!-- Images -->
                        <div class="overflow-hidden rounded">
                            <swiper v-if="product.images.length > 1" :modules="[Autoplay, Pagination]"
                                :autoplay="{ delay: 3000 }" pagination loop>
                                <swiper-slide v-for="img in product.images" :key="img.id">
                                    <Link :href="`/products/${product.slug}`" prefetch class="hover:underline">
                                    <img :src="getImageUrl(img.url_image)" :alt="product.title" loading="lazy"
                                        class="w-full h-40 object-cover transition-transform duration-300 hover:scale-110 rounded" />
                                    </Link>
                                </swiper-slide>
                            </swiper>
                            <Link v-else :href="`/products/${product.slug}`" prefetch class="hover:underline">
                            <img :src="getImageUrl(product.images[0]?.url_image)" :alt="product.title" loading="lazy"
                                class="w-full h-40 object-cover transition-transform duration-300 hover:scale-110 rounded" />
                            </Link>
                        </div>

                        <!-- Infos produit -->
                        <div class="p-3 flex flex-col flex-1">
                            <h3 class="text-sm font-medium truncate mt-2">{{ product.title }}</h3>
                            <p class="text-sm font-semibold mt-2 "
                                :class="darkMode ? 'text-dark-white' : 'text-text-dark'">{{ product.prix }} FCFA</p>
                        </div>

                        <!-- Boutons -->
                        <div class="mt-auto flex justify-between items-center p-3">
                            <button @click="flyToCart($event, product)"
                                class="transition-transform duration-200 hover:scale-125 active:scale-90 text-[var(--accent-cyan)] dark:text-white">
                                <font-awesome-icon :icon="['fas', 'cart-shopping']" />
                            </button>

                            <button @click="toggleLike(product)"
                                :class="['transition-transform duration-200 hover:scale-125 active:scale-90', product.liked ? 'text-red-500' : 'text-[var(--accent-cyan)]']">
                                <font-awesome-icon :icon="['far', 'heart']" />
                                <span class="ml-1 text-sm dark:text-[var(--dark-grey)]">{{ product.likes_count }}</span>
                            </button>
                        </div>

                    </div>
                    <CartWidget />
                </template>
            </div>

            <div v-if="!loading && filteredProducts.length === 0"
                class="text-center mt-6 text-gray-500 dark:text-dark-grey">
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
    <img v-if="flyingImage.show" :src="flyingImage.src" :style="{
        top: flyingImage.y + 'px',
        left: flyingImage.x + 'px',
        transform: 'translate(' + flyingImage.dx + 'px,' + flyingImage.dy + 'px) scale(0.2)',
        transition: 'transform 0.8s ease-in-out, opacity 0.8s ease-in-out',
        opacity: 1
    }" class="fixed w-20 h-20 rounded-lg pointer-events-none z-50" />
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import axios from 'axios'
import { cartStore } from '@/components/frontend/panier/stores/cart'
import TopBanner from '@/components/frontend/TopBanner.vue'
import NavbarFrontend from '@/components/frontend/NavbarFrontend.vue'
import FlashMessageFrontend from '@/components/frontend/flash/FlashMessageFrontend.vue'
import Footer from '@/components/frontend/Footer.vue'
import Service from '@/components/frontend/Service.vue'
import Testimony from '@/components/frontend/Testimony.vue'
import FloatingAction from '@/components/frontend/FloatingAction.vue'
import Loading from '@/components/frontend/Loading.vue'
import LoginReminder from '@/components/frontend/flash/LoginReminder.vue'
import About2 from '@/components/frontend/About2.vue'
import Map2 from '@/components/frontend/Map2.vue'
import HeroSection from '@/components/frontend/HeroSection.vue'
import CartWidget from '@/components/frontend/panier/CartWidget.vue'

import { Swiper, SwiperSlide } from "swiper/vue"
import "swiper/css"
import { Autoplay, Pagination } from "swiper/modules"

import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faCartShopping } from '@fortawesome/free-solid-svg-icons'
import { faHeart } from '@fortawesome/free-regular-svg-icons'
library.add(faCartShopping, faHeart)

const props = defineProps({
    products: Array,
    categories: Array,
    filters: Object,
    auth: Object,
    seo: Object,
})

const search = ref(props.filters.search || '')
const selectedCategory = ref(props.filters.category || '')
const darkMode = ref(false)
const loading = ref(true)
const showLoading = ref(true)
const cart = ref([])

const skeletonCount = computed(() => {
    if (window.innerWidth >= 1024) return 20
    if (window.innerWidth >= 768) return 12
    if (window.innerWidth >= 640) return 8
    return 4
})

// Image volante
const flyingImage = ref({ show: false, src: '', x: 0, y: 0, dx: 0, dy: 0 })

onMounted(() => {
    const savedCart = localStorage.getItem('cart')
    if (savedCart) cart.value = JSON.parse(savedCart)

    darkMode.value = localStorage.getItem('darkMode') === 'true'

    const hasVisited = sessionStorage.getItem('hasVisited')
    if (!hasVisited) {
        showLoading.value = true
        loading.value = true
        setTimeout(() => {
            showLoading.value = false
            setTimeout(() => { loading.value = false }, 1000)
        }, 2000)
        sessionStorage.setItem('hasVisited', 'true')
    } else {
        showLoading.value = false
        loading.value = true
        setTimeout(() => { loading.value = false }, 1000)
    }
})

// Filtrage
const filteredProducts = computed(() => {
    return props.products.filter(product => {
        const matchSearch = product.title.toLowerCase().includes(search.value.toLowerCase())
        const matchCategory = selectedCategory.value === '' || product.category_id === selectedCategory.value
        return matchSearch && matchCategory
    })
})

// Like
function toggleLike(product) {
    if (!props.auth?.user) {
        if (confirm("Vous devez être connecté pour aimer un produit.\nVoulez-vous vous connecter maintenant ?")) {
            window.location.href = '/login'
        }
        return
    }
    axios.post(`/like/${product.id}`).then(res => {
        product.liked = res.data.liked
        product.likes_count = res.data.likesCount
    }).catch(() => { })
}

// Catégorie
function categoryButtonClass(id) {
    const selected = selectedCategory.value === id
    return [
        'border-none',
        selected ? 'underline text-[var(--accent-cyan)]' : 'text-text-dark hover:text-[var(--accent-cyan)]'
    ]
}

function filterByCategory(id) { selectedCategory.value = id }
function onSearchInput() { }

// Cart functions
function saveCart() { localStorage.setItem('cart', JSON.stringify(cart.value)) }

function addToCart(product) {
    const existing = cart.value.find(p => p.id === product.id)
    if (existing) existing.quantity++
    else cart.value.push({ ...product, quantity: 1 })
    saveCart()
}

function increaseQuantity(item) { item.quantity++; saveCart() }
function decreaseQuantity(item) {
    if (item.quantity > 1) item.quantity--;
    else cart.value = cart.value.filter(p => p.id !== item.id)
    saveCart()
}

// Image volante

function flyToCart(event, product) {
    // Vérifier si l'utilisateur est connecté
    if (!props.auth?.user) {
        // Afficher un alert ou confirmer la connexion
        if (confirm("Vous devez être connecté pour ajouter un produit au panier.\nVoulez-vous vous connecter maintenant ?")) {
            window.location.href = '/login';
        }
        return; // arrêter la fonction si pas connecté
    }

    const img = event.currentTarget.closest('.product-card').querySelector('img')
    const cartEl = document.querySelector('.fixed.bottom-6.right-6 button')
    if (!img || !cartEl) return

    const imgRect = img.getBoundingClientRect()
    const cartRect = cartEl.getBoundingClientRect()
    const dx = cartRect.left + cartRect.width / 2 - (imgRect.left + imgRect.width / 2)
    const dy = cartRect.top + cartRect.height / 2 - (imgRect.top + imgRect.height / 2)

    flyingImage.value = { show: true, src: img.src, x: imgRect.left, y: imgRect.top, dx, dy }

    cartStore.add(product)  // ✅ un seul panier global
    setTimeout(() => { flyingImage.value.show = false }, 800)
}
// Images
function getImageUrl(path) { return path ? `/${path}` : '/fallback.png' }
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
        background-position: -400px 0
    }

    100% {
        background-position: 400px 0
    }
}
</style>
