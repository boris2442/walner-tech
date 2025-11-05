<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import Input from "@/components/backend/forms/Input.vue";
import Textarea from "@/components/backend/forms/Textarea.vue";
import SubmitButton from "@/components/backend/forms/SubmitButton.vue";


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
    { title: 'Categories', href: '/admin/categories' },
    { title: 'Modifier', href: `/admin/categories/${props.category.id}/edit` },
];
</script>

<template>

    <Head title="Modifier catégorie" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <h1 class="text-xl font-bold mb-4">Modifier un Utilisateur</h1>
            <form @submit.prevent="submitForm">
                <Input id="name" label="Nom de la catégorie" v-model="form.name" :error="form.errors.name" required />
                <Textarea label="Description" v-model="form.description" :error="form.errors.description" :rows="4" />
                <SubmitButton :processing="form.processing" label="Mettre à jour" />
            </form>
        </div>
    </AppLayout>
</template>
