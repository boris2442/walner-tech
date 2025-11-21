<script setup lang="ts">
import Input from '@/components/backend/forms/Input.vue';
import SubmitButton from '@/components/backend/forms/SubmitButton.vue';
import Textarea from '@/components/backend/forms/Textarea.vue';
import BackButton from '@/components/frontend/BackButton.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import products from '@/routes/products';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
// Props venant du controller
const props = defineProps({
    categories: Array,
});

// Breadcrumb
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'dashboard',
        href: dashboard().url,
    },
    {
        title: 'Products List',
        href: products.index().url,
    },
    {
        title: 'Products create',
        href: products.create().url,
    },
];

// Formulaire Inertia
const form = useForm({
    title: '',
    description: '',
    prix: '',
    stock: 0,
    category_id: '',
    status: 'disponible',
    images: [],
});

// Aperçu des images
const imagePreviews = ref([]);

// Submit formulaire
const submitForm = () => {
    const data = new FormData();
    data.append('title', form.title);
    data.append('description', form.description);
    data.append('prix', form.prix);
    data.append('stock', form.stock);
    data.append('category_id', form.category_id);
    data.append('status', form.status);

    form.images.forEach((file) => data.append('images[]', file));

    form.post('/admin/products/store', {
        onSuccess: () => {
            form.reset();
            imagePreviews.value = [];
        },
        onError: (errors) => {},
    });
};

// Gestion fichiers images
const handleFiles = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (!target.files) return;
    form.images = Array.from(target.files);
    imagePreviews.value = form.images.map((file) => URL.createObjectURL(file));
};

const removeImage = (index: number) => {
    form.images.splice(index, 1); // supprime le fichier du form
    imagePreviews.value.splice(index, 1); // supprime l’aperçu
};
</script>

<template>
    <Head title="Créer un Produit" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-4 p-4">
            <BackButton class="m-4" />
            <div class="relative min-h-[80vh] flex-1 rounded-xl border border-sidebar-border/70 p-6 dark:border-sidebar-border">
                <h1 class="mb-4 text-xl font-bold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Ajouter un Produit</h1>

                <form @submit.prevent="submitForm" enctype="multipart/form-data" class="flex flex-col gap-4">
                    <Input label="Titre du produit" v-model="form.title" :error="form.errors.title" />
                    <span v-if="form.errors.title" class="text-sm">{{ form.errors.title }}</span>
                    <Textarea label="Description" v-model="form.description" :error="form.errors.description" />
                    <span v-if="form.errors.description" class="text-sm">{{ form.errors.description }}</span>
                    <Input label="Prix" v-model="form.prix" type="number" :error="form.errors.prix" />
                    <Input label="Stock" v-model="form.stock" type="number" :error="form.errors.stock" />
                    <span v-if="form.errors.stock" class="text-sm">{{ form.errors.stock }}</span>
                    <div>
                        <label class="mb-1 block font-medium text-[var(--primary-blue)] dark:text-[var(--dark-gold)]"> Catégorie </label>
                        <select
                            v-model="form.category_id"
                            required
                            class="w-full rounded border p-2 focus:ring-2 focus:ring-[var(--primary-blue)] focus:outline-none dark:border-gray-600 dark:bg-[#2A2A2A] dark:focus:ring-[var(--dark-gold)]"
                        >
                            <option value="" disabled class="text-xs">Choisir une catégorie</option>
                            <option class="text-xs" v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                        </select>
                        <p v-if="form.errors.category_id" class="mt-1 text-sm text-red-500">{{ form.errors.category_id }}</p>
                    </div>

                    <div>
                        <label class="mb-1 block font-medium text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Images *</label>

                        <!-- Zone de drag & drop / clic -->
                        <div
                            class="mt-1 flex h-32 w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed hover:border-[var(--primary-blue)] dark:hover:border-[var(--dark-gold)]"
                            @click="$refs.fileInput.click()"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="mb-2 h-8 w-8 text-blue-500"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12V4m0 0l-4 4m4-4l4 4"
                                />
                            </svg>
                            <p class="text-sm text-gray-500">
                                <span class="text-purple-600">Cliquez pour uploader</span> ou glissez-déposez<br />
                                PNG, JPG, GIF, SVG, WEBP (max. 2MB)
                            </p>
                            <input
                                ref="fileInput"
                                type="file"
                                multiple
                                accept="image/png, image/jpeg, image/gif, image/svg+xml, image/webp"
                                @change="handleFiles"
                                class="hidden"
                            />
                        </div>

                        <!-- Aperçu des images -->

                        <div class="mt-2 flex flex-wrap gap-2">
                            <div v-for="(img, index) in imagePreviews" :key="index" class="relative">
                                <img :src="img" class="h-20 w-20 rounded border object-cover" />
                                <!-- Croix de suppression -->
                                <button
                                    type="button"
                                    @click="removeImage(index)"
                                    class="absolute -top-2 -right-2 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white hover:bg-red-600"
                                >
                                    ×
                                </button>
                            </div>
                        </div>

                        <!-- Erreur -->
                        <span v-if="form.errors.images" class="mt-1 text-sm text-red-500">{{ form.errors.images }}</span>
                    </div>

                    <SubmitButton :processing="form.processing" label="Enregistrer" />
                </form>
            </div>
        </div>
    </AppLayout>
</template>
