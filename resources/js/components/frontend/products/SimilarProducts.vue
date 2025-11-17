<template>
    <section v-if="products && products.length" class="bg-background-light py-8 shadow-inner dark:bg-[var(--highlight-gold)]">
        <div class="mx-auto max-w-6xl px-4">
            <h2 class="mb-6 text-2xl font-bold">Produits similaires</h2>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">
                <div
                    v-for="sp in products"
                    :key="sp.id"
                    class="product-card flex flex-col overflow-hidden rounded-lg bg-white shadow-md transition-transform hover:scale-105 dark:bg-[var(--card-dark)]"
                >
                    <Link prefetch :href="`/products/${sp.slug}`">
                        <img :src="getImageUrl(sp.images?.[0]?.url_image)" :alt="sp.title" class="mb-4 h-40 w-full rounded-md object-cover" />
                        <h3 class="mb-2 pl-2 font-semibold">{{ sp.title }}</h3>
                    </Link>
                    <!-- <p class="dark:text-dark-grey text-[10px] text-gray-500">
                        <span
                            class="rounded-full border border-[var(--accent-cyan)] px-2 py-1 font-semibold text-[var(--accent-cyan)] dark:border-[var(--dark-grey)] dark:text-[var(--dark-grey)]"
                        >
                            {{ sp.category.name }}</span
                        >
                    </p> -->
                    <p class="mb-2 pl-2 font-bold text-[var(--primary-blue)]">{{ sp.prix }} FCFA</p>

                    <div
                        class="m-2 flex items-center justify-center rounded-xl border-2 border-blue-700 px-3 py-2 text-center text-sm font-semibold text-blue-700 transition-colors duration-200 hover:bg-blue-700 hover:text-white"
                    >
                        <Link :href="`/products/${sp.slug}`" prefetch class="flex w-full items-center justify-center text-center dark:text-gray-300 h-full">
                            <ShoppingCartIcon class="animate-spin-slow mr-2" /> Voir plus
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    products: {
        type: Array,
        default: () => [],
    },
});
//console.log(props.products)
function getImageUrl(path) {
    if (!path) return '/fallback.png';
    return `/${path}`;
}
</script>
