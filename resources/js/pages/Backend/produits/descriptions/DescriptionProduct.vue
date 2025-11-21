<script setup lang="ts">
import BackButton from '@/components/frontend/BackButton.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import description from '@/routes/admin/description';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'dashboard',
        href: dashboard().url,
    },
    {
        title: 'List descriptions',
        href: description.index().url,
    },
    { title: 'Create description', href: description.create().url },
];

const props = defineProps({
    products: Array,
});

const selectedProduct = ref('');

const form = useForm({
    content: '',
    product_id: '',
});

const addDescription = () => {
    if (!selectedProduct.value) {
        alert('Veuillez sélectionner un produit avant d’ajouter une description.');
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
                <h1 class="mb-4 text-xl font-bold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Ajouter une description de produit</h1>

                <!-- Formulaire -->
                <form @submit.prevent="addDescription" class="flex flex-col gap-4">
                    <!-- Sélection du produit -->
                    <select
                        v-model="selectedProduct"
                        class="w-full rounded-lg border p-2 focus:ring-2 focus:ring-blue-500 dark:bg-gray-900 dark:text-white"
                    >
                        <option disabled value="" class="text-xs">Sélectionnez un produit</option>
                        <option v-for="product in products" :key="product.id" :value="product.id" class="text-xs">
                            {{ product.title }}
                        </option>
                    </select>

                    <!-- Zone de texte avec bouton flottant -->
                    <div class="relative rounded-xl border bg-white p-3 shadow-sm dark:bg-gray-900">
                        <textarea
                            v-model="form.content"
                            placeholder="Écrivez ici la description du produit..."
                            class="w-full resize-none border-none bg-transparent pr-12 text-gray-800 placeholder-gray-400 outline-none dark:text-gray-200 dark:placeholder-gray-500"
                            rows="4"
                        ></textarea>

                        <!-- <RichTextEditor v-model="form.content" placeholder="Écrivez ici la description du produit..." /> -->

                        <!-- Bouton fixe style ChatGPT -->
                        <button
                            type="submit"
                            title="Submit"
                            aria-label="Submit"
                            class="absolute right-2 bottom-2 flex h-9 w-9 items-center justify-center rounded-lg bg-blue-600 text-white shadow-sm transition-all duration-200 hover:bg-blue-700 disabled:opacity-50"
                            :disabled="form.processing || !form.content.trim()"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
