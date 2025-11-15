<template>
    <FlashMessageNewsletter />
    <CartWidget />

    <Head :title="product.title + ' - Détails du produit'" />
    <TopBanner />
    <FloatingAction />
    <NavbarFrontend :auth="$page.props.auth" class="mt-10 md:mt-12" />
    <BackButton class="m-4" />
    <LoginReminder />
    <section class="bg-background-light dark:bg-dark-background text-text-dark dark:text-dark-white p-4 md:p-8">
        <div class="mx-auto grid max-w-6xl grid-cols-1 gap-8 md:grid-cols-2">
            <!-- Images -->
            <div class="flex flex-col gap-4 md:flex-row">
                <!-- Miniatures -->
                <div class="scrollbar-hide flex gap-3 overflow-x-auto md:h-[500px] md:w-[100px] md:flex-col md:overflow-y-auto">
                    <img
                        v-for="(img, index) in product.images"
                        :key="img.id"
                        :src="getImageUrl(img.url_image)"
                        loading="lazy"
                        :alt="'Image ' + (index + 1)"
                        class="h-20 w-20 cursor-pointer rounded-lg border object-cover transition hover:opacity-90"
                        :class="{ 'ring-2 ring-[var(--primary-blue)]': selectedImage === img.url_image }"
                        @click="selectedImage = img.url_image"
                    />
                </div>

                <!-- Image principale -->
                <div class="relative flex flex-1 items-center justify-center">
                    <img
                        loading="lazy"
                        :src="getImageUrl(selectedImage)"
                        :alt="product.title"
                        class="h-80 w-full rounded-lg object-contain shadow-lg transition-transform duration-300 hover:scale-105 md:h-[500px]"
                    />
                    <button
                        @click="showShare = true"
                        type="button"
                        title="partager"
                        aria-label="partager dans les medias "
                        class="text-text-dark dark:text-dark-white share absolute right-4 bottom-0 flex items-center gap-2 rounded-lg px-2 py-2 transition hover:text-white hover:shadow"
                    >
                        <!-- icône share -->
                        <FontAwesomeIcon :icon="['fas', 'share-alt']" class="text-2xl text-gray-500" />
                        <!-- <span>Transférer</span> -->
                    </button>
                </div>
            </div>

            <!-- Infos produit -->
            <div class="flex flex-col justify-start md:justify-between">
                <!-- <div class="mt-4 flex items-center gap-3"> -->

                <!-- </div> -->

                <!-- Share modal -->
                <ShareModal :show="showShare" :product="product" @close="showShare = false" />
                <div>
                    <h1 class="mb-2 text-3xl font-bold">{{ product.title }}</h1>
                    <p class="mb-2 leading-relaxed text-gray-700 dark:text-gray-300">{{ product.description }}</p>
                    <p class="text-md mb-3 flex justify-between font-semibold text-[var(--primary-blue)]">
                        <span>{{ product.prix }} FCFA </span>
                        <span>
                            <a
                                href="https://wa.me/237656894773"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex h-8 items-center justify-center rounded bg-[#00CC5D] px-4 py-2 font-semibold text-white transition duration-200 ease-in-out hover:opacity-90"
                            >
                                <FontAwesomeIcon :icon="['fab', 'whatsapp']" class="ml-2 h-5 w-5 text-xl text-white" />
                                <span class="text-sm">Whatsapp</span>
                            </a>
                        </span>
                    </p>
                    <!-- {{
                                product.stock }}  -->

                    <p v-if="product.stock >= 3" class="mb-2 text-sm font-semibold text-[var(--primary-blue)] dark:text-gray-300">
                        <span class="rounded border border-solid border-[var(--primary-blue)] px-1 py-[2px] dark:border-gray-300">
                            <span>En stock </span>
                        </span>
                    </p>
                    <p v-if="!props.auth?.user" class="my-3 text-xs">
                        <span
                            ><i
                                >Vous devrez etre
                                <strong>
                                    <Link prefetch href="login" class="hover:underline"> connecter </Link> </strong
                                >pour pouvoir reserver!
                            </i></span
                        >
                    </p>
                </div>

                <!-- Bouton Ajouter au panier -->
                <div>
                    <button
                        @click="addToCart(product)"
                        type="button"
                        title="ajout au panier"
                        aria-label="Bouton ajouter au panier"
                        class="dark:bg-dark-gold w-full rounded-lg bg-[var(--primary-blue)] px-6 py-3 font-semibold text-white shadow-md transition hover:opacity-90 md:w-auto"
                    >
                        Ajouter au panier
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Dans ton ProductDetail.vue -->
    <div class="mx-auto max-w-6xl px-4" v-if="product.descriptionProduct && product.descriptionProduct.content">
        <ProductDescriptions :description-product="product.descriptionProduct" />
    </div>

    <!-- SimilarProducts components -->
    <SimilarProducts :products="similarProducts" />

    <Footer />
</template>

<script setup>
import FlashMessageNewsletter from '@/components/FlashMessageNewsletter.vue';
import BackButton from '@/components/frontend/BackButton.vue';
import LoginReminder from '@/components/frontend/flash/LoginReminder.vue';
import FloatingAction from '@/components/frontend/FloatingAction.vue';
import Footer from '@/components/frontend/Footer.vue';
import NavbarFrontend from '@/components/frontend/NavbarFrontend.vue';
import CartWidget from '@/components/frontend/panier/CartWidget.vue';
import { cartStore } from '@/components/frontend/panier/stores/cart';
import ProductDescriptions from '@/components/frontend/products/ProductDescriptions.vue';
import SimilarProducts from '@/components/frontend/products/SimilarProducts.vue';
import ShareModal from '@/components/frontend/ShareModal.vue';
import TopBanner from '@/components/frontend/TopBanner.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Head, Link, router } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

const props = defineProps({
    product: Object,
    auth: Object,
    similarProducts: Array,
});
const showShare = ref(false);
const selectedImage = ref(null);

onMounted(() => {
    selectedImage.value = props.product.images?.[0]?.url_image || '/fallback.png';
});

function getImageUrl(path) {
    if (!path) return '/fallback.png';
    return `/${path}`;
}

function addToCart(product) {
    if (!props.auth?.user) {
        if (confirm('Vous devez être connecté pour aimer un produit.\nVoulez-vous vous connecter maintenant ?')) {
            // window.location.href = '/login'
            router.visit('/login');
        }
        return;
    }

    cartStore.add(product);
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
