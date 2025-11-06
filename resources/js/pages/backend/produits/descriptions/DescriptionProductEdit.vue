<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import Input from "@/components/backend/forms/Input.vue";
import Textarea from "@/components/backend/forms/Textarea.vue";
import SubmitButton from "@/components/backend/forms/SubmitButton.vue";
import BackButton from '@/components/frontend/BackButton.vue';
import { type BreadcrumbItem } from '@/types';

// ✅ Props venant du contrôleur
const props = defineProps<{
    description: {
        id: number;
        product_id: number;
        content: string;
        product: { id: number; title: string };
    };
    products: { id: number; title: string }[];
}>();

// ✅ Formulaire Inertia pré-rempli
const form = useForm({
    product_id: props.description.product_id,
    content: props.description.content,
});

// ✅ Soumission du formulaire
///products/description/{id}
const submitForm = () => {
    form.put(`/admin/products/description/${props.description.id}`, {
        preserveScroll: true,
    });
};

// ✅ Fil d’Ariane
const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Descriptions produits', href: '/admin/description' },
    { title: 'Modifier', href: `/admin/products/description/${props.description.id}/edit` },
];
</script>

<template>

    <Head title="Modifier la description d’un produit" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6 w-full mx-auto bg-white dark:bg-slate-800 rounded-2xl shadow">
            <BackButton class="mb-4" />
            <h1 class="text-2xl font-bold mb-6 text-slate-800 dark:text-slate-100">
                Modifier la description d’un produit
            </h1>

            <form @submit.prevent="submitForm" class="flex flex-col gap-6">

                <!-- Produit concerné -->
                <div>
                    <label class="block mb-1 font-medium text-slate-700 dark:text-slate-200">Produit</label>
                    <select v-model="form.product_id"
                        class="p-2 border rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option disabled value="">Sélectionner un produit</option>
                        <option v-for="prod in products" :key="prod.id" :value="prod.id">
                            {{ prod.title }}
                        </option>
                    </select>
                    <p v-if="form.errors.product_id" class="text-red-500 text-sm mt-1">
                        {{ form.errors.product_id }}
                    </p>
                </div>

                <!-- Contenu -->
                <Textarea label="Contenu de la description" v-model="form.content" :error="form.errors.content"
                    :rows="6" required />

                <SubmitButton :processing="form.processing" label="Mettre à jour la description"
                class="max-w-[300px] " />
            </form>
        </div>
    </AppLayout>
</template>
