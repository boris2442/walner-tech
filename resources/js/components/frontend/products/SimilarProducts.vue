<template>
    <section v-if="products && products.length"
        class="bg-background-light py-8 shadow-inner dark:bg-[var(--highlight-gold)]">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-2xl font-bold mb-6">Produits similaires</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                <div v-for="sp in products" :key="sp.id"
                    class="bg-white dark:bg-[var(--card-dark)] rounded-lg shadow-md hover:scale-105 transition-transform product-card flex flex-col overflow-hidden">
                    <Link prefetch :href="`/products/${sp.slug}`">
                    <img :src="getImageUrl(sp.images?.[0]?.url_image)" :alt="sp.title"
                        class="w-full h-40 object-cover rounded-md mb-4">
                    <h3 class="font-semibold mb-2 pl-2">{{ sp.title }}</h3>
                    </Link>
                    <p class="text-[var(--primary-blue)] font-bold mb-2 pl-2">{{ sp.prix }} FCFA</p>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    products: {
        type: Array,
        default: () => [],
    },
})

function getImageUrl(path) {
    if (!path) return '/fallback.png'
    return `/${path}`
}
</script>
