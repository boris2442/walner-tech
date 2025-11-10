<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from "vue";
import BackButton from '@/components/frontend/BackButton.vue';
import { type BreadcrumbItem } from '@/types';
import { dashboard } from '@/routes';
import description from '@/routes/admin/description';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'dashboard',
        href: dashboard().url,
    },
    {
        title: 'List descriptions', href: description.index().url,
    },
    { title: 'Create description', href: description.create().url },
];

const props = defineProps({
    products: Array,
});

const selectedProduct = ref("");

const form = useForm({
    content: "",
    product_id: "",
});

const addDescription = () => {
    if (!selectedProduct.value) {
        alert("Veuillez sélectionner un produit avant d’ajouter une description.");
        return;
    }

    form.product_id = selectedProduct.value;

    form.post(`/admin/products/${selectedProduct.value}/description`);
};
</script>

<template>

    <Head title="Créer description" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-4 p-4">
            <BackButton class="m-4" />

            <div class="relative min-h-[80vh] flex-1 rounded-xl border p-6">
                <h1 class="text-xl font-bold mb-4 text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">
                    Ajouter une description de produit
                </h1>

                <!-- Formulaire -->
                <form @submit.prevent="addDescription" class="flex flex-col gap-4">
                    <!-- Sélection du produit -->
                    <select v-model="selectedProduct"
                        class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-900 dark:text-white">
                        <option disabled value="" class="text-xs">Sélectionnez un produit</option>
                        <option v-for="product in products" :key="product.id" :value="product.id" class="text-xs">
                            {{ product.title }}
                        </option>
                    </select>

                    <!-- Zone de texte avec bouton flottant -->
                    <div class="relative bg-white dark:bg-gray-900 border rounded-xl p-3 shadow-sm">
                        <textarea v-model="form.content" placeholder="Écrivez ici la description du produit..."
                            class="w-full resize-none border-none outline-none bg-transparent pr-12 text-gray-800 dark:text-gray-200 placeholder-gray-400 dark:placeholder-gray-500"
                            rows="4"></textarea>

                        <!-- Bouton fixe style ChatGPT -->
                        <button type="submit" title="Submit" aria-label="Submit"
                            class="absolute bottom-2 right-2 flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white rounded-lg w-9 h-9 transition-all duration-200 shadow-sm disabled:opacity-50"
                            :disabled="form.processing || !form.content.trim()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
