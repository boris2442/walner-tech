<template>
    <FlashMessageNewsletter />
    <CartWidget />

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
                        loading="lazy" :alt="'Image ' + (index + 1)"
                        class="w-20 h-20 object-cover rounded-lg border cursor-pointer hover:opacity-90 transition"
                        :class="{ 'ring-2 ring-[var(--primary-blue)]': selectedImage === img.url_image }"
                        @click="selectedImage = img.url_image" />
                </div>

                <!-- Image principale -->
                <div class="flex-1 flex items-center justify-center relative">
                    <img loading="lazy" :src="getImageUrl(selectedImage)" :alt="product.title"
                        class="w-full h-80 md:h-[500px] object-contain rounded-lg shadow-lg transition-transform duration-300 hover:scale-105" />
                    <button @click="showShare = true" type="button" title="partager"
                        aria-label="partager dans les medias "
                        class="flex items-center gap-2  px-2 py-2 rounded-lg hover:shadow absolute bottom-0 right-4  text-text-dark dark:text-dark-white  hover:text-white transition share">
                        <!-- icône share -->
                        <FontAwesomeIcon :icon="['fas', 'share-alt']" class=" text-gray-500 text-2xl " />
                        <!-- <span>Transférer</span> -->
                    </button>
                </div>

            </div>

            <!-- Infos produit -->
            <div class="flex flex-col justify-start md:justify-between ">

                <!-- <div class="mt-4 flex items-center gap-3"> -->

                <!-- </div> -->


                <!-- Share modal -->
                <ShareModal :show="showShare" :product="product" @close="showShare = false" />
                <div>
                    <h1 class="text-3xl font-bold mb-2">{{ product.title }}</h1>
                    <p class="text-gray-700 dark:text-gray-300 mb-2 leading-relaxed">{{ product.description }}</p>
                    <p class="text-md font-semibold text-[var(--primary-blue)] flex justify-between mb-3"> <span>{{
                        product.prix }} FCFA </span>
                        <span>
                            <a href="https://wa.me/237656894773" target="_blank" rel="noopener noreferrer"
                                class='bg-[#00CC5D]  h-8 flex items-center justify-center text-white px-4 py-2 rounded font-semibold hover:opacity-90 transition ease-in-out duration-200 '>

                                <FontAwesomeIcon :icon="['fab', 'whatsapp']" class="h-5 w-5 ml-2 text-xl text-white" />
                                <span class="text-sm">Whatsapp</span>
                            </a>
                        </span>
                    </p>
                    <!-- {{
                                product.stock }}  -->

                    <p v-if="product.stock >= 3"
                        class="text-sm font-semibold text-[var(--primary-blue)] mb-2 dark:text-gray-300">
                        <span
                            class="border border-solid border-[var(--primary-blue)] py-[2px] px-1 rounded dark:border-gray-300">
                            <span>En stock </span>
                        </span>
                    </p>
                    <p v-if="!props.auth?.user" class="text-xs my-3"><span><i>Vous devrez etre
                                <strong>
                                    <Link prefetch href="login" class="hover:underline"> connecter </Link>
                                </strong>pour pouvoir
                                reserver!
                            </i></span></p>
                </div>

                <!-- Bouton Ajouter au panier -->
                <div>
                    <button @click="addToCart(product)" type="button" title="ajout au panier"
                        aria-label="Bouton ajouter au panier"
                        class="w-full md:w-auto bg-[var(--primary-blue)] dark:bg-dark-gold text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:opacity-90 transition">
                        Ajouter au panier
                    </button>
                </div>
            </div>


        </div>
    </section>

    <!-- Dans ton ProductDetail.vue -->
    <div class="max-w-6xl mx-auto px-4" v-if="product.descriptionProduct && product.descriptionProduct.content">
        <ProductDescriptions :description-product="product.descriptionProduct" />
    </div>


    <!-- SimilarProducts components -->
    <SimilarProducts :products="similarProducts" />

    <Footer />
</template>

<script setup>
import { ref, onMounted } from 'vue'
import NavbarFrontend from '@/components/frontend/NavbarFrontend.vue'
import TopBanner from '@/components/frontend/TopBanner.vue'
import { cartStore } from '@/components/frontend/panier/stores/cart'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import FlashMessageNewsletter from '@/components/FlashMessageNewsletter.vue'
import CartWidget from '@/components/frontend/panier/CartWidget.vue'
import Footer from '@/components/frontend/Footer.vue'
import BackButton from '@/components/frontend/BackButton.vue'
import LoginReminder from '@/components/frontend/flash/LoginReminder.vue'
import FloatingAction from '@/components/frontend/FloatingAction.vue'
import ShareModal from '@/components/frontend/ShareModal.vue'
import { Link } from '@inertiajs/vue3';
import { Head, router } from '@inertiajs/vue3'
import SimilarProducts from '@/components/frontend/products/SimilarProducts.vue'
import ProductDescriptions from '@/components/frontend/products/ProductDescriptions.vue'

const props = defineProps({
    product: Object,
    auth: Object,
    similarProducts: Array,
})
const showShare = ref(false)
const selectedImage = ref(null)

onMounted(() => {
    selectedImage.value = props.product.images?.[0]?.url_image || '/fallback.png'
})


function getImageUrl(path) {
    if (!path) return '/fallback.png';
    return `/${path}`;
}


function addToCart(product) {
    if (!props.auth?.user) {
        if (confirm("Vous devez être connecté pour aimer un produit.\nVoulez-vous vous connecter maintenant ?")) {
            // window.location.href = '/login'
            router.visit('/login')
        }
        return
    }


    cartStore.add(product)
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

.share {
    animation: share 3s linear infinite;
}

@keyframes share {
    0% {
        transform: scale(0);
    }

    50% {
        transform: scale(1.02);
    }

    100% {
        transform: scale(1.05);
    }
}
</style>
