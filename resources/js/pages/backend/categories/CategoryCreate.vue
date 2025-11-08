<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { Head } from '@inertiajs/vue3';
import BackButton from '@/components/frontend/BackButton.vue';
import categories from '@/routes/categories';
import { ref } from "vue";
import Input from "@/components/backend/forms/Input.vue";
import Textarea from "@/components/backend/forms/Textarea.vue";
import SubmitButton from "@/components/backend/forms/SubmitButton.vue";
// import FlashMessage from "@/components/frontend/flash/FlashMessage.vue";
import { useForm } from "@inertiajs/vue3";
import { type BreadcrumbItem } from '@/types';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'dashboard',
        href: dashboard().url,
    },
    {
        title: 'List categories', href: categories.index().url,
    },
    {
        title: 'Create Category',
        href: categories.create().url
    },
];


const flashMessage = ref("");
const form = useForm({
    name: "",
    description: "",
});

const submitForm = () => {
    // form.post("/categories/store");
    form.post("/admin/categories");
};

</script>

<template>

    <Head title="Category create" />
    <!-- <Head title="Dashboard" /> -->
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <BackButton class="m-4" />
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <!-- <PlaceholderPattern /> -->

                <div class="m-3">
                    <h1 class="text-xl font-bold mb-4 ">
                        Ajouter une Catégorie
                    </h1>

                    <form @submit.prevent="submitForm">
                        <Input :required="true" id="name" label="Nom de la catégorie" v-model="form.name"
                            placeholder="Ex: Téléphones" :error="form.errors.name" />

                        <Textarea label="Description" v-model="form.description"
                            placeholder="Ex: Catégorie pour tous les smartphones" :rows="4"
                            :error="form.errors.description" />

                        <SubmitButton :processing="form.processing" label="Enregistrer" />
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
