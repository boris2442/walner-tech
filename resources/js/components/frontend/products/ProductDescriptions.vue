<template>
    <section class="bg-background-light py-8 shadow-inner dark:bg-[var(--highlight-gold)] product-descriptions">
        <h2 class="text-2xl font-bold mb-6">Descriptions supplémentaires</h2>

        <!-- Si la description existe -->
        <div v-if="descriptionProduct && descriptionProduct.content"
            class="bg-white dark:bg-gray-800 p-4 md:p-6 rounded-lg shadow-sm border-l-4 border-[var(--primary-blue)] text-gray-700 dark:text-gray-300 leading-relaxed text-sm md:text-base">
            {{ descriptionProduct.content }}
        </div>

    </section>
</template>

<script setup>
const props = defineProps({
    descriptionProduct: {
        type: Object,
        default: null,
    },
});
</script>

<style scoped>
/* Tu peux rajouter un effet scroll si la description est longue */
.product-descriptions div {
    max-height: 400px;
    overflow-y: auto;
}
</style>
