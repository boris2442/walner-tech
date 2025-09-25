<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

import Input from "@/components/backend/forms/Input.vue";
import Textarea from "@/components/backend/forms/Textarea.vue";
import SubmitButton from "@/components/backend/forms/SubmitButton.vue";
import FlashMessage from "@/components/frontend/flash/FlashMessage.vue";

// Props venant du controller
const props = defineProps({
    categories: Array
});

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

// Pour l'aperçu des images
const imagePreviews = ref([]);

// Gestion du submit
const submitForm = () => {
    const data = new FormData();
    data.append("title", form.title);
    data.append("description", form.description);
    data.append("prix", form.prix);
    data.append("stock", form.stock);
    data.append("category_id", form.category_id);
    data.append("status", form.status);

    // Ajouter les images
    form.images.forEach((file) => {
        data.append("images[]", file);
    });

    form.post("/admin/products/store", {
        onSuccess: () => {
            form.reset();
            imagePreviews.value = [];
            // flashMessage.value = "Produit ajouté avec succès !";
        },
        // onError: () => {
        //     flashMessage.value = "Erreur lors de l'ajout du produit.";
        // },
    });
};

// Flash message
// const flashMessage = ref("");

// Quand on sélectionne des images
const handleFiles = (event) => {
    form.images = Array.from(event.target.files);
    imagePreviews.value = form.images.map(file => URL.createObjectURL(file));
};
</script>

<template>
    <div class="bg-white dark:bg-[#1E1E1E] p-6 rounded-lg shadow-md w-full max-w-lg">
        <!-- Flash message -->
        <!-- <FlashMessage v-if="flashMessage" :message="flashMessage" type="success" /> -->

        <h2 class="text-xl font-bold mb-4 text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">
            Ajouter un Produit
        </h2>

        <form @submit.prevent="submitForm" enctype="multipart/form-data">
            <Input label="Titre du produit" v-model="form.title" :error="form.errors.title" />
            <Textarea label="Description" v-model="form.description" :error="form.errors.description" />
            <Input label="Prix" v-model="form.prix" type="number" :error="form.errors.prix" />
            <Input label="Stock" v-model="form.stock" type="number" :error="form.errors.stock" />

            <div class="mb-4">
                <label class="block mb-1 font-medium text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">
                    Catégorie
                </label>
                <select v-model="form.category_id" required
                    class="p-2 border border-gray-300 rounded w-full focus:outline-none focus:ring-2 focus:ring-[var(--primary-blue)] dark:bg-[#2A2A2A] dark:border-gray-600 dark:focus:ring-[var(--dark-gold)]">
                    <option value="" disabled>Choisir une catégorie</option>
                    <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                </select>
                <p v-if="form.errors.category_id" class="text-red-500 text-sm mt-1">{{ form.errors.category_id }}</p>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">
                    Images
                </label>
                <input type="file" multiple accept="image/*" @change="handleFiles" class="block w-full" />
                <div class="flex gap-2 mt-2 flex-wrap">
                    <img v-for="(img, index) in imagePreviews" :key="index" :src="img"
                        class="h-20 w-20 object-cover rounded border" />
                </div>
                <p v-if="form.errors.images" class="text-red-500 text-sm mt-1">{{ form.errors.images }}</p>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">
                    Statut
                </label>
                <select v-model="form.status"
                    class="p-2 border border-gray-300 rounded w-full focus:outline-none focus:ring-2 focus:ring-[var(--primary-blue)] dark:bg-[#2A2A2A] dark:border-gray-600 dark:focus:ring-[var(--dark-gold)]">
                    <option value="disponible">Disponible</option>
                    <option value="indisponible">Indisponible</option>
                </select>
            </div>

            <SubmitButton :processing="form.processing" label="Enregistrer" />
        </form>
    </div>
</template>
