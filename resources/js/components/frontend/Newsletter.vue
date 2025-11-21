<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

// ✅ Déclaration de la variable réactive
const email = ref('');

const subscribe = () => {
    if (!email.value) {
        alert('Veuillez entrer une adresse email valide');
        return;
    }

    router.post(
        '/newsletter',
        { email: email.value },
        {
            onSuccess: () => {
                // alert('Merci pour votre abonnement 🎉')
                email.value = '';
            },
            onError: (errors) => {
                if (errors.email) {
                    // alert(errors.email)
                }
            },
        },
    );
};

const placeholders = ['Entrez votre email', 'Recevez nos promos en premier', 'Ne ratez aucune promotion', 'Alertes promos instantanées'];

const currentPlaceholder = ref(placeholders[0]);
let index = 0;

onMounted(() => {
    setInterval(() => {
        index = (index + 1) % placeholders.length;
        currentPlaceholder.value = placeholders[index];
    }, 2500);
});
</script>

<template>
    <div
        class="relative flex h-[200px] w-full items-center justify-center overflow-hidden"
        :style="{
            'background-image': `url('/herop2.png')`,
            'background-size': 'cover',
            'background-position': 'center',
            'background-repeat': 'no-repeat',
            'background-attachment': 'fixed',
        }"
    >
        <div class="absolute inset-0 bg-blue-900/70"></div>

        <div class="relative z-10 flex w-full max-w-7xl flex-col items-center justify-between gap-8 px-6 md:flex-row md:px-12">
            <div class="w-full text-white md:w-2/3 md:text-left">
                <h2 class="mb-2 text-2xl font-bold md:text-3xl">Recevez nos promos en premier !</h2>

                <form @submit.prevent="subscribe" class="flex items-center">
                    <div class="relative w-full">
                        <input
                            v-model="email"
                            type="email"
                            :placeholder="currentPlaceholder"
                            class="w-full rounded-full border border-solid border-white px-4 py-3 pr-14 pl-5 text-gray-100 focus:ring-2 focus:ring-white focus:outline-none"
                        />
                        <button
                            type="submit"
                            class="absolute top-1/2 right-1 -translate-y-1/2 transform rounded-full bg-white p-2 text-blue-600 transition-colors duration-300 hover:bg-gray-200"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    fill-rule="evenodd"
                                    d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 7.414V13a1 1 0 11-2 0V7.414L4.707 11.707a1 1 0 01-1.414-1.414l6-6z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
