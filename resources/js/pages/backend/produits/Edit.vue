<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import Input from "@/components/backend/forms/Input.vue";
import Textarea from "@/components/backend/forms/Textarea.vue";
import SubmitButton from "@/components/backend/forms/SubmitButton.vue";
import BackButton from '@/components/frontend/BackButton.vue';
import { ref } from 'vue';
import products from '@/routes/products';
import { dashboard } from '@/routes';
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
        images: { url_image: string }[];
    };
    categories: { id: number; name: string }[];
}>();

// Formulaire Inertia pré-rempli
const form = useForm({
    title: props.product.title,
    description: props.product.description,
    prix: props.product.prix,
    stock: props.product.stock,
    category_id: props.product.category_id,
    status: props.product.status,
    images: []
});

// Aperçu des images existantes + nouvelles
const imagePreviews = ref(props.product.images.map(img => `/storage/${img.url_image}`));

// Submit formulaire
const submitForm = () => {
    const data = new FormData();
    data.append("title", form.title);
    data.append("description", form.description);
    data.append("prix", form.prix.toString());
    data.append("stock", form.stock.toString());
    data.append("category_id", form.category_id.toString());
    data.append("status", form.status);

    form.images.forEach(file => data.append("images[]", file));

    form.put(`/admin/products/${props.product.id}`);
};

// Gestion fichiers images
const handleFiles = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (!target.files) return;
    form.images = Array.from(target.files);
    imagePreviews.value = [
        ...props.product.images.map(img => `/storage/${img.url_image}`),
        ...form.images.map(file => URL.createObjectURL(file))
    ];
};

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'dashboard',
        href: dashboard().url,
    },
    {
        title: 'Products List',
        href: products.index().url,

    },
    { title: 'Modifier produit', href: `/admin/products/${props.product.id}/edit` },
];
</script>

<template>

    <Head title="Modifier un produit" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <BackButton class="m-4" />
            <h1 class="text-xl font-bold mb-4">Modifier le produit</h1>
            <form @submit.prevent="submitForm" class="flex flex-col gap-4">
                <Input label="Titre du produit" v-model="form.title" :error="form.errors.title" required />
                <Textarea label="Description" v-model="form.description" :error="form.errors.description" :rows="4" />
                <Input label="Prix" type="number" v-model="form.prix" :error="form.errors.prix" required />
                <Input label="Stock" type="number" v-model="form.stock" :error="form.errors.stock" required />

                <div>
                    <label class="block mb-1 font-medium">Catégorie</label>
                    <select v-model="form.category_id"
                        class="p-2 border rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="" disabled class="text-xs">Choisir une catégorie</option>
                        <option v-for="cat in categories" :key="cat.id" :value="cat.id" class="text-xs">{{ cat.name }}</option>
                    </select>
                    <p v-if="form.errors.category_id" class="text-red-500 text-sm mt-1">{{ form.errors.category_id }}
                    </p>
                </div>

                <div>
                    <label class="block mb-1 font-medium">Images</label>
                    <input type="file" multiple accept="image/*" @change="handleFiles" class="block w-full" />
                    <div class="flex gap-2 mt-2 flex-wrap">
                        <img v-for="(img, index) in imagePreviews" :key="index" :src="img"
                            class="h-20 w-20 object-cover rounded border" />
                    </div>
                    <p v-if="form.errors.images" class="text-red-500 text-sm mt-1">{{ form.errors.images }}</p>
                </div>

                <div>
                    <label class="block mb-1 font-medium">Statut</label>
                    <select v-model="form.status"
                        class="p-2 border rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="disponible" class="text-xs">Disponible</option>
                        <option value="indisponible" class="text-xs">Indisponible</option>
                    </select>
                </div>

                <SubmitButton :processing="form.processing" label="Mettre à jour" />
            </form>
        </div>
    </AppLayout>
</template>
