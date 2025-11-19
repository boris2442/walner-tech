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
const props = defineProps<{
    product: {
        id: number;
        title: string;
        description: string;
        prix: number;
        stock: number;
        category_id: number;
        status: string;
        images: { id: number; url_image: string }[];
    };
    categories: { id: number; name: string }[];
}>();

// Anciennes images
const oldImages = ref(
    props.product.images.map((img) => ({
        id: img.id,
        url: img.url_image, // si tu veux "imageProducts/xxx" déjà accessible
    })),
);

const form = useForm({
    title: props.product.title,
    description: props.product.description,
    prix: Number(props.product.prix), // ✅ FORCÉ EN NOMBRE
    stock: Number(props.product.stock),
    category_id: Number(props.product.category_id),
    status: props.product.status,
    newImages: [] as File[],
    keepOldImages: oldImages.value.map((img) => img.id),
});

// Previews des nouvelles images
const newImagePreviews = ref<string[]>([]);

// Supprimer une ancienne image
const removeOldImage = (id: number) => {
    oldImages.value = oldImages.value.filter((img) => img.id !== id);
    form.keepOldImages = oldImages.value.map((img) => img.id);
};

// Ajouter de nouvelles images
const handleFiles = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (!target.files) return;
    form.newImages = Array.from(target.files);
    newImagePreviews.value = form.newImages.map((file) => URL.createObjectURL(file));
};

import axios from 'axios'; // ← Ajoute cette ligne en haut

const submitForm = () => {
    if (oldImages.value.length === 0 && form.newImages.length === 0) {
        alert('Le produit doit avoir au moins une image.');
        return;
    }

    const data = new FormData();
    data.append('_method', 'put');
    data.append('title', form.title);
    data.append('description', form.description);
    data.append('prix', form.prix.toString());
    data.append('stock', form.stock.toString());
    data.append('category_id', form.category_id.toString());
    data.append('status', form.status);

    form.keepOldImages.forEach((id) => {
        data.append('keepOldImages[]', id.toString());
    });

    form.newImages.forEach((file) => {
        data.append('images[]', file);
    });

    axios
        .post(`/admin/products/${props.product.id}`, data, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
            },
        })

        .then((response) => {
            // ✅ Redirige sans full reload
            router.visit('/admin/products', {
                method: 'get',
                replace: false,
                preserveState: false,
                preserveScroll: false,
                preserveOrigin: false,
                onSuccess: () => {},
                onError: (errors) => {},
            });
        })
        .catch((error) => {});
};

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: dashboard().url },
    { title: 'Products List', href: products.index().url },
    { title: 'Modifier produit', href: `/admin/products/${props.product.id}/edit` },
];
</script>

<template>
    <Head title="Modifier un produit" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <BackButton class="m-4" />
            <h1 class="mb-4 text-xl font-bold">Modifier le produit</h1>
            <form @submit.prevent="submitForm" class="flex flex-col gap-4">
                <!-- Titre -->
                <!-- <Input label="Titre du produit" v-model="form.title" :error="form.errors.title" required /> -->

                <Input label="Titre" id="title" v-model="form.title" :error="form.errors.title" />

                <!-- Description -->
                <Textarea label="Description" v-model="form.description" :error="form.errors.description" :rows="4" />

                <!-- Prix & Stock -->
                <Input label="Prix" type="number" v-model="form.prix" :error="form.errors.prix" required />
                <Input label="Stock" type="number" v-model="form.stock" :error="form.errors.stock" required />

                <!-- Catégorie -->
                <div>
                    <label class="mb-1 block font-medium">Catégorie</label>
                    <select v-model="form.category_id" class="w-full rounded border p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="" disabled>Choisir une catégorie</option>
                        <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                    </select>
                    <p v-if="form.errors.category_id" class="mt-1 text-sm text-red-500">{{ form.errors.category_id }}</p>
                </div>

                <!-- Images -->
                <div>
                    <label class="mb-1 block font-medium">Images</label>
                    <input type="file" multiple accept="image/*" @change="handleFiles" class="block w-full" />

                    <div class="mt-2 flex flex-wrap gap-2">
                        <!-- Anciennes images -->
                        <div v-for="img in oldImages" :key="img.id" class="relative">
                            <img :src="img.url" class="h-24 w-24 rounded border object-cover" />
                            <button
                                type="button"
                                @click="removeOldImage(img.id)"
                                class="absolute -top-2 -right-2 rounded-full bg-red-600 px-1.5 text-xs text-white hover:bg-red-700"
                            >
                                x
                            </button>
                        </div>

                        <!-- Nouvelles images -->
                        <div v-for="(preview, index) in newImagePreviews" :key="index" class="relative">
                            <img :src="preview" class="h-24 w-24 rounded border object-cover" />
                        </div>
                    </div>

                    <p v-if="form.errors.images" class="mt-1 text-sm text-red-500">{{ form.errors.images }}</p>
                </div>

                <!-- Statut -->
                <div>
                    <label class="mb-1 block font-medium">Statut</label>
                    <select v-model="form.status" class="w-full rounded border p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="disponible">Disponible</option>
                        <option value="indisponible">Indisponible</option>
                    </select>
                </div>

                <!-- Bouton submit -->
                <SubmitButton :processing="form.processing" label="Mettre à jour" />
            </form>
        </div>
    </AppLayout>
</template>
