<template>
    <!-- flash Logout -->


    <!-- Loader -->
    <Loading v-if="showLoading" />
    <TopBanner />
    <NavbarFrontend :auth="$page.props.auth" class="mt-10 md:mt-12" />
    <FlashMessageFrontend v-if="$page.props.flash?.message" :message="$page.props.flash.message"
        :link="$page.props.flash.link" />
    <!-- <ContactNav/> -->
    <FloatingAction />

    <!-- Section Produits -->

    <section>
        <div
            class="dark:bg-dark-background dark:text-dark-white bg-background-light text-text-dark p-8 transition-colors duration-300">

            <!-- Barre de recherche -->
            <div class="mb-6 flex justify-center">
                <input v-model="search" @input="onSearchInput" type="text" placeholder="Rechercher un produit..."
                    :class="darkMode ? 'border-dark-grey bg-dark-background text-dark-white placeholder-dark-grey focus:ring-dark-accent' : 'border-text-secondary bg-background-light text-text-dark placeholder-text-secondary focus:ring-accent-cyan'"
                    class="border rounded px-3 py-1 w-full max-w-md focus:outline-none focus:ring-2 transition-colors duration-300 " />
            </div>

            <!-- Liste des catégories -->
            <div class="flex gap-3 justify-start mb-4 overflow-x-auto whitespace-nowrap px-2">
                <span @click="filterByCategory('')" :class="categoryButtonClass('')"
                    class="inline-block cursor-pointer px-4 py-2 text-sm font-medium transition-colors duration-300 dark:text-[var(--dark-grey)]">
                    Tous
                </span>
                <span v-for="cat in categories" :key="cat.id" @click="filterByCategory(cat.id)"
                    :class="categoryButtonClass(cat.id)"
                    class="inline-block cursor-pointer px-4 py-2 text-sm font-medium transition-colors duration-300 text-[var(--dark-blue)] dark:text-[var(--dark-grey)]">
                    {{ cat.name }}
                </span>
            </div>

            <hr class="border-t border-gray-300 dark:border-[var(--dark-grey)] mb-6" />

            <!-- Skeleton / Produits -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">

                <!-- Skeleton loader -->
                <template v-if="loading">
                    <div v-for="n in skeletonCount" :key="n"
                        class="product-card rounded flex flex-col shadow-md overflow-hidden">

                        <!-- Image -->
                        <div class="h-40 w-full rounded mb-3 skeleton"></div>

                        <!-- Infos produit -->
                        <div class="p-3 flex flex-col flex-1">
                            <div class="h-4 rounded w-3/4 mb-2 skeleton"></div>
                            <div class="h-3 rounded w-1/2 skeleton"></div>
                        </div>

                        <!-- Boutons placeholder -->
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
                            <Link :href="`/products/${product.uuid}`" prefetch class="hover:underline">
                            <swiper v-if="product.images.length > 1" :modules="[Autoplay, Pagination]"
                                :autoplay="{ delay: 3000 }" pagination loop>
                                <swiper-slide v-for="img in product.images" :key="img.id">
                                    <img :src="getImageUrl(img.url_image)" :alt="product.title" loading="lazy"
                                        class="w-full h-40 object-cover transition-transform duration-300 hover:scale-110 rounded" />
                                </swiper-slide>
                            </swiper>
                            <img v-else :src="getImageUrl(product.images[0]?.url_image)" :alt="product.title"
                                loading="lazy"
                                class="w-full h-40 object-cover transition-transform duration-300 hover:scale-110 rounded" />
                            </Link>
                        </div>

                        <!-- Infos produit -->
                        <div class="p-3 flex flex-col flex-1">
                            <h3 class="text-sm font-medium truncate mt-2">{{ product.title }}</h3>
                            <p class="text-sm font-semibold mt-2"
                                :class="darkMode ? 'text-dark-white' : 'text-text-dark'">
                                {{ product.prix }} FCFA
                            </p>
                        </div>

                        <!-- Boutons -->
                        <div class="mt-auto flex justify-between items-center p-3">
                            <button @click="addToCart(product, $event)"
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
                </template>
            </div>






            <div v-if="!loading && filteredProducts.length === 0"
                class="text-center mt-6 text-gray-500 dark:text-dark-grey">
                Aucun produit trouvé
            </div>


            <div class="fixed bottom-6 right-6 z-50">
                <button ref="cartButton" @click="toggleCart"
                    class="relative bg-[var(--primary-blue)] rounded-full w-12 h-12 flex items-center justify-center text-[var(--dark-gold)] shadow-lg">
                    <font-awesome-icon :icon="['fas', 'cart-shopping']" class="text-2xl" />
                    <span v-if="cart.length"
                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                        {{ totalItems }}
                    </span>
                </button>


                <transition name="fade-slide">
                    <div v-if="showCart"
                        class="mt-2 w-72 max-h-96 bg-[var(--accent-cyan)] dark:bg-dark-background shadow-lg rounded-lg overflow-y-auto p-3 cart-scroll">
                        <div v-for="item in cart" :key="item.id" class="flex items-center mb-2">
                            <img :src="getImageUrl(item.images[0]?.url_image)" loading="lazy"
                                class="w-12 h-12 object-cover rounded mr-2" />
                            <div class="flex-1">
                                <p class="text-sm font-medium truncate">{{ item.title }}</p>
                                <p class="text-xs text-gray-500 dark:text-dark-grey">{{ item.prix }} FCFA x {{
                                    item.quantity }}</p>
                                <div class="flex items-center mt-1 gap-1">
                                    <button @click="decreaseQuantity(item)"
                                        class="bg-gray-200 dark:bg-gray-700 rounded px-2 text-sm hover:bg-gray-300 dark:hover:bg-gray-600 transition">-</button>
                                    <span class="px-2">{{ item.quantity }}</span>
                                    <button @click="increaseQuantity(item)"
                                        class="bg-gray-200 dark:bg-gray-700 rounded px-2 text-sm hover:bg-gray-300 dark:hover:bg-gray-600 transition">+</button>
                                </div>
                            </div>
                        </div>
                        <hr class="my-2 border-gray-300 dark:border-[var(--dark-grey)]" />
                        <div class="flex justify-between font-semibold">
                            <span>Total :</span>
                            <span class="text-[var(--dark-white)]">{{ cartTotal }} FCFA</span>
                        </div>
                        <div class="mt-3">
                            <p v-if="cart.length === 0"
                                class="text-sm text-gray-400 dark:text-dark-grey text-center mb-2">
                                Le panier est vide. Ajoutez des produits avant de réserver.
                            </p>
                            <button @click="orderOnWhatsapp" :disabled="loading || cart.length === 0"
                                class="w-full bg-white dark:bg-[var(--dark-gold)] text-[var(--accent-cyan)] dark:text-dark-white py-2 rounded dark:hover:bg-[var(--dark-gold)]/80 transition">
                                Reserver
                            </button>
                        </div>
                    </div>
                </transition>
            </div>











        </div>
    </section>

   
    <Map2 />
    <HeroSection />
    <Service />
    <About2 />
    <Testimony />
    <LoginReminder />
    <Footer />
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import SeoHead from '@/components/frontend/seo/SeoHead.vue';
import Testimony from '@/components/frontend/Testimony.vue';
import { Head } from '@inertiajs/inertia-vue3'
import TopBanner from '@/components/frontend/TopBanner.vue';
import { Inertia } from '@inertiajs/inertia';
import NavbarFrontend from '@/components/frontend/NavbarFrontend.vue';
import ContactNav from '@/components/frontend/ContactNav.vue';
import Footer from '@/components/frontend/Footer.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/css";
import Service from '@/components/frontend/Service.vue';
import FloatingAction from '@/components/frontend/FloatingAction.vue';
import Loading from '@/components/frontend/Loading.vue';
import LoginReminder from '@/components/frontend/flash/LoginReminder.vue';
import About2 from '@/components/frontend/About2.vue';
import { Autoplay, Pagination } from "swiper/modules";
import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faCartShopping } from '@fortawesome/free-solid-svg-icons';
import Map2 from '@/components/frontend/Map2.vue';
import { faHeart } from '@fortawesome/free-regular-svg-icons';
import HeroSection from '@/components/frontend/HeroSection.vue';
import FlashMessageFrontend from '@/components/frontend/flash/FlashMessageFrontend.vue';
library.add(faCartShopping, faHeart);

const props = defineProps({
    products: Array,
    categories: Array,
    filters: Object,
    auth: Object
});

const search = ref(props.filters.search || '');
const selectedCategory = ref(props.filters.category || '');
const darkMode = ref(false);
const loading = ref(true);


const skeletonCount = computed(() => {
    if (window.innerWidth >= 1024) return 20; // lg
    if (window.innerWidth >= 768) return 12;  // md
    if (window.innerWidth >= 640) return 8;   // sm
    return 4;                                  // xs
});





// Panier
const cart = ref([]);
const showCart = ref(false);
const cartButton = ref(null);

// Debounce recherche
let searchTimeout = null;

onMounted(() => {
    darkMode.value = localStorage.getItem('darkMode') === 'true';
    const savedCart = localStorage.getItem('cart');
    if (savedCart) cart.value = JSON.parse(savedCart);
    loading.value = false;
});

// Filtrage produit
const filteredProducts = computed(() => {
    return props.products.filter(product => {
        const matchSearch = product.title.toLowerCase().includes(search.value.toLowerCase());
        const matchCategory = selectedCategory.value === '' || product.category_id === selectedCategory.value;
        return matchSearch && matchCategory;
    });
});

// Like
function toggleLike(product) {

    // Vérifier si l'utilisateur est connecté
    if (!props.auth?.user) {
        if (confirm("Vous devez être connecté pour aimer un produit.\nVoulez-vous vous connecter maintenant ?")) {
            window.location.href = '/login';
        }
        return; // Stop la fonction
    }

    axios.post(`/like/${product.id}`).then(res => {
        product.liked = res.data.liked;
        product.likes_count = res.data.likesCount;
    }).catch(() => { });
}

// Ajouter au panier avec animation
function addToCart(product, event) {


    // Vérifier si l'utilisateur est connecté
    if (!props.auth?.user) {
        // Afficher une alerte ou un toast personnalisé
        if (confirm("Vous devez être connecté pour ajouter un produit au panier.\nVoulez-vous vous connecter maintenant ?")) {
            // Rediriger vers la page de login
            window.location.href = '/login';
        }
        return; // Stop la fonction
    }

    const item = cart.value.find(p => p.id === product.id);
    if (item) item.quantity += 1;
    else cart.value.push({ ...product, quantity: 1 });
    saveCart();

    if (!event) return;
    const img = event.currentTarget.closest('.product-card').querySelector('img');
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
        if (document.body.contains(clone)) document.body.removeChild(clone);
    });
}

// Gérer quantité
function increaseQuantity(item) { item.quantity += 1; saveCart(); }
function decreaseQuantity(item) { if (item.quantity > 1) item.quantity -= 1; else cart.value = cart.value.filter(p => p.id !== item.id); saveCart(); }
function saveCart() { localStorage.setItem('cart', JSON.stringify(cart.value)); }

// Toggle mini-panier
function toggleCart() { showCart.value = !showCart.value; }

// Total items et total prix
const totalItems = computed(() => cart.value.reduce((acc, p) => acc + p.quantity, 0));
const cartTotal = computed(() => cart.value.reduce((acc, p) => acc + (p.prix * p.quantity), 0));

function categoryButtonClass(id) {
    const selected = selectedCategory.value === id;
    return [
        'border-none',
        selected
            ? 'underline text-[var(--accent-cyan)]'
            : 'text-text-dark hover:text-[var(--accent-cyan)]'
    ];
}

// Filtrage et recherche
function updateFilters() {
    Inertia.get('/products', { search: search.value, category: selectedCategory.value }, { preserveState: true, replace: true });
}
function filterByCategory(id) {
    selectedCategory.value = id;
    updateFilters();
}

// Debounce recherche
function onSearchInput() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(updateFilters, 300);
}

// Obtenir URL image

// function getImageUrl(path) {
//     if (!path) return '/fallback.png';
//     return path.startsWith('imageProducts/') ? `/storage/${path}` : `/storage/imageProducts/${path}//`;
// }
function getImageUrl(path) {
    if (!path) return '/fallback.png';
    return `/${path}`;
}




// Commander sur WhatsApp
function orderOnWhatsapp() {
    const userName = props?.auth?.user?.name || 'Client';
    const userId = props.auth?.user?.id || null;
    const entreprisePhone = "237656894773";

    cart.value.forEach(item => {
        axios.post('/api/track-order-click', {
            product_id: item.id,
            quantity: item.quantity,
            user_id: userId,
        }).catch(() => { });
    });

    let message = `Hello Walner, je suis ${userName}.\n\nJe souhaite commander les articles suivants :\n`;
    cart.value.forEach(item => {
        message += `- ${item.title} (x${item.quantity}) : ${item.prix * item.quantity} FCFA\n`;
    });
    message += `\nTotal : ${cartTotal.value} FCFA\n\nMerci !`;

    const whatsappUrl = `https://wa.me/${entreprisePhone}?text=${encodeURIComponent(message)}`;
    window.open(whatsappUrl, "_blank");
}

// Loader : true si on doit afficher le loader
const showLoading = ref(true);

onMounted(() => {
    if (!sessionStorage.getItem('hasVisited')) {
        // Affiche le loader 2s
        setTimeout(async () => {
            showLoading.value = false;   // Fin du loader
            await nextTick();             // attendre que le DOM soit mis à jour

            sessionStorage.setItem('hasVisited', 'true');
        }, 2000);
    } else {
        // Pas la première visite → pas de loader
        showLoading.value = false;

    }
});



</script>

<style scoped>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Fade slide transition */
.fade-slide-enter-active,
.fade-slide-leave-active {
    transition: all 0.3s ease;
}

.fade-slide-enter-from {
    opacity: 0;
    transform: translateY(-20px);
}

.fade-slide-enter-to {
    opacity: 1;
    transform: translateY(0);
}

.fade-slide-leave-from {
    opacity: 1;
    transform: translateY(0);
}

.fade-slide-leave-to {
    opacity: 0;
    transform: translateY(-20px);
}

/* Scroll invisible panier */
.cart-scroll {
    max-height: 350px;
    overflow-y: auto;
}

.cart-scroll::-webkit-scrollbar {
    width: 0px;
    background: transparent;
}

.cart-scroll {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

@keyframes shimmer {
    0% {
        background-position: -450px 0;
    }

    100% {
        background-position: 450px 0;
    }
}

.skeleton {
    background: linear-gradient(to right, #3d3939 0%, #351717 50%, #583838 100%);
    background-size: 450px 100%;
    animation: shimmer 1.5s infinite linear;
}

.dark .skeleton {
    background: linear-gradient(to right, #333 0%, #444 50%, #333 100%);
}
</style>
