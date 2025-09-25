<script setup>
import { ref } from "vue";
import Input from "@/components/backend/forms/Input.vue";
import Textarea from "@/components/backend/forms/Textarea.vue";
import SubmitButton from "@/components/backend/forms/SubmitButton.vue";
import FlashMessage from "@/components/frontend/flash/FlashMessage.vue";
import { useForm } from "@inertiajs/vue3";
const flashMessage = ref("");
const form = useForm({
    name: "",
    description: "",
});

// const submitForm = () => {
//     form.post("/categories/store", {
//         onSuccess: () => form.reset(),
//     });

const submitForm = () => {
    form.post("/categories/store");
};
</script>

<template>
    <div class="bg-white dark:bg-[#1E1E1E] p-6 rounded-lg shadow-md w-full max-w-md">
        <!-- Flash message -->
        <FlashMessage v-if="flashMessage" :message="flashMessage" type="success" />
        <h2 class="text-xl font-bold mb-4 text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">
            Ajouter une Catégorie
        </h2>

        <form @submit.prevent="submitForm">
            <Input :required="true" id="name" label="Nom de la catégorie" v-model="form.name"
                placeholder="Ex: Téléphones" :error="form.errors.name" />

            <Textarea label="Description" v-model="form.description"
                placeholder="Ex: Catégorie pour tous les smartphones" :rows="4" :error="form.errors.description" />

            <SubmitButton :processing="form.processing" label="Enregistrer" />
        </form>
    </div>
</template>
