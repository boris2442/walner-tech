<template>

    <Head :title="product.title + ' - Détails du produit'" />
    <TopBanner />
    <FloatingAction />
    <NavbarFrontend :auth="$page.props.auth" class="mt-10 md:mt-12" />
    <BackButton class="m-4" />
    <LoginReminder />
    <section class="bg-background-light dark:bg-dark-background text-text-dark dark:text-dark-white p-4 md:p-8 ">
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
    <section class="bg-gray-100 dark:bg-dark-background py-8">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-2xl font-bold mb-6">Produits similaires</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                <div v-for="sp in similarProducts" :key="sp.id"
                    class="bg-white dark:bg-dark-card rounded-lg shadow-md hover:scale-105 transition-transform   product-card  flex flex-col  overflow-hidden">
                    <Link prefetch="" :href="`/products/${sp.slug}`">
                    <img :src="getImageUrl(sp.images?.[0]?.url_image)" :alt="sp.title"
                        class="w-full h-40 object-cover rounded-md mb-4">

                    <h3 class="font-semibold mb-2 pl-2">{{ sp.title }}</h3>
                    </Link>
                    <p class="text-[var(--primary-blue)] font-bold mb-2 pl-2">{{ sp.prix }} FCFA</p>

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
import FloatingAction from '@/components/frontend/FloatingAction.vue'
import { Link } from '@inertiajs/vue3'
import { Head } from '@inertiajs/vue3'
const props = defineProps({
    product: Object,
    auth: Object,
    similarProducts: Array,
})

const selectedImage = ref(null)

onMounted(() => {
    selectedImage.value = props.product.images?.[0]?.url_image || '/fallback.png'
})

// function getImageUrl(path) {
//     return path ? `/storage/${path}` : '/fallback.png'
// }
function getImageUrl(path) {
    if (!path) return '/fallback.png';
    return `/${path}`;
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
