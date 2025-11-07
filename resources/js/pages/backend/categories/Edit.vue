<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import Input from "@/components/backend/forms/Input.vue";
import Textarea from "@/components/backend/forms/Textarea.vue";
import BackButton from '@/components/frontend/BackButton.vue';
import SubmitButton from "@/components/backend/forms/SubmitButton.vue";
import categories from '@/routes/categories';
import { dashboard } from '@/routes';
const props = defineProps<{
    category: {
        id: number;
        name: string;
        description: string;
    };
}>();

const form = useForm({
    name: props.category.name,
    description: props.category.description,
});

const submitForm = () => {
    form.put(`/admin/categories/${props.category.id}`);
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'dashboard',
        href: dashboard().url,
    },
    {
        title: 'Categories List',
        href: categories.index().url,

    },
    { title: 'Modifier', href: `/admin/categories/${props.category.id}/edit` },
];
</script>

<template>

    <Head title="Modifier catégorie" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <BackButton class="m-4" />
            <h2 class="text-xl font-bold mb-4">Modifier une catégorie</h2>
            <form @submit.prevent="submitForm">
                <Input id="name" label="Nom de la catégorie" v-model="form.name" :error="form.errors.name" required />
                <Textarea label="Description" v-model="form.description" :error="form.errors.description" :rows="4" />
                <SubmitButton :processing="form.processing" label="Mettre à jour" />
            </form>
        </div>
    </AppLayout>
</template>
