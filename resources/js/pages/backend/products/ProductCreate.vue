<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ref } from "vue";
import Input from "@/components/backend/forms/Input.vue";
import Textarea from "@/components/backend/forms/Textarea.vue";
import SubmitButton from "@/components/backend/forms/SubmitButton.vue";
import { useForm } from "@inertiajs/vue3";
import BackButton from '@/components/frontend/BackButton.vue';

// Props venant du controller
const props = defineProps({
    categories: Array
});

// Breadcrumb
const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Créer un Produit', href: dashboard().url }
];

// Formulaire Inertia
const form = useForm({
    title: "",
    description: "",
    prix: "",
    stock: 0,
    category_id: "",
    status: "disponible",
    images: []
});

// Aperçu des images
const imagePreviews = ref([]);

// Submit formulaire
const submitForm = () => {
    const data = new FormData();
    data.append("title", form.title);
    data.append("description", form.description);
    data.append("prix", form.prix);
    data.append("stock", form.stock);
    data.append("category_id", form.category_id);
    data.append("status", form.status);

    form.images.forEach((file) => data.append("images[]", file));

    form.post("/admin/products/store", {
        onSuccess: () => {
            form.reset();
            imagePreviews.value = [];
        }, onError: (errors) => {

        }
    });
};

// Gestion fichiers images
const handleFiles = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (!target.files) return;
    form.images = Array.from(target.files);
    imagePreviews.value = form.images.map(file => URL.createObjectURL(file));
};
</script>

<template>

    <Head title="Créer un Produit" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-4 p-4">
            <BackButton class="m-4" />
            <div
                class="relative min-h-[80vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                <h2 class="text-xl font-bold mb-4 text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">
                    Ajouter un Produit
                </h2>

                <form @submit.prevent="submitForm" enctype="multipart/form-data" class="flex flex-col gap-4">
                    <Input label="Titre du produit" v-model="form.title" :error="form.errors.title" />
                    <span v-if="form.errors.title" class="text-sm">{{ form.errors.title }}</span>
                    <Textarea label="Description" v-model="form.description" :error="form.errors.description" />
                    <span v-if="form.errors.description" class="text-sm">{{ form.errors.description }}</span>
                    <Input label="Prix" v-model="form.prix" type="number" :error="form.errors.prix" />
                    <Input label="Stock" v-model="form.stock" type="number" :error="form.errors.stock" />
                    <span v-if="form.errors.stock" class="text-sm">{{ form.errors.stock }}</span>
                    <div>
                        <label class="block mb-1 font-medium text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">
                            Catégorie
                        </label>
                        <select v-model="form.category_id" required
                            class="p-2 border rounded w-full focus:outline-none focus:ring-2 focus:ring-[var(--primary-blue)] dark:bg-[#2A2A2A] dark:border-gray-600 dark:focus:ring-[var(--dark-gold)]">
                            <option value="" disabled>Choisir une catégorie</option>
                            <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                        </select>
                        <p v-if="form.errors.category_id" class="text-red-500 text-sm mt-1">{{ form.errors.category_id
                        }}</p>
                    </div>

                    <div>
                        <label
                            class="block mb-1 font-medium text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Images</label>
                        <input type="file" multiple accept="image/*" @change="handleFiles" class="block w-full" />
                        <div class="flex gap-2 mt-2 flex-wrap">
                            <img v-for="(img, index) in imagePreviews" :key="index" :src="img"
                                class="h-20 w-20 object-cover rounded border" />
                        </div>
                        <span v-if="form.errors.images" class="text-red-500 text-sm mt-1">{{ form.errors.images
                        }}</span>

                    </div>

                    <SubmitButton :processing="form.processing" label="Enregistrer" />
                </form>
            </div>
        </div>
    </AppLayout>
</template>
