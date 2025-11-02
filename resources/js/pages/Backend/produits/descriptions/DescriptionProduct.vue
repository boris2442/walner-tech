<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from "vue";
import BackButton from '@/components/frontend/BackButton.vue';
import { type BreadcrumbItem } from '@/types';
import { dashboard } from '@/routes';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Create Category',
        href: dashboard().url,
    },
];

const props = defineProps({
    products: Array, // Reçu depuis ton contrôleur
});

const selectedProduct = ref("");

const form = useForm({
    content: "",
     product_id: "", // <-- ajouter ici
});



const addDescription = () => {
    if (!selectedProduct.value) {
        alert("Veuillez sélectionner un produit avant d’ajouter une description.");
        return;
    }

    // Injecter product_id directement dans le form
    form.product_id = selectedProduct.value;

    form.post(`/admin/products/${selectedProduct.value}/description`, {
        onError: (errors) => console.log("Erreurs validation :", errors),
        onSuccess: (page) => console.log("Réponse succès :", page),
    });
};





</script>


<template>

    <Head title="Créer description" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-4 p-4">
            <BackButton class="m-4" />
            <div
                class="relative min-h-[80vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                <h2 class="text-xl font-bold mb-4 text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">
                    Ajouter un Produit
                </h2>

                <!-- Formulaire pour ajouter une nouvelle description -->
                <form @submit.prevent="addDescription" class="mb-6 relative">
                    <!-- Sélect produit -->
                    <select v-model="selectedProduct" class="w-full p-2 border rounded mb-2">
                        <option disabled value="">Sélectionnez un produit</option>
                        <option v-for="product in products" :key="product.id" :value="product.id">
                            {{ product.title }}
                        </option>
                    </select>

                    <!-- Textarea avec bouton à l'intérieur -->
                    <div class="relative">
                        <textarea v-model="form.content" placeholder="Nouvelle description..."
                            class="w-full p-3 pr-12 border rounded "></textarea>

                        <!-- Bouton icône à l'intérieur -->
                        <button type="submit"
                            class="absolute top-1/2 right-2 transform -translate-y-1/2 text-white bg-blue-600 hover:bg-blue-700 rounded p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </AppLayout>
</template>
