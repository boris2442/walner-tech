<script setup lang="ts">
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

// ✅ Déclaration de la variable réactive
const email = ref('')

const subscribe = () => {
    if (!email.value) {
        alert('Veuillez entrer une adresse email valide')
        return
    }

    router.post('/newsletter', { email: email.value }, {
        onSuccess: () => {
            // alert('Merci pour votre abonnement 🎉')
            email.value = ''
        },
        onError: (errors) => {
            if (errors.email) {
                // alert(errors.email)
            }
        }
    })
}
</script>

<template>
    <div class="relative w-full h-[200px] flex items-center justify-center overflow-hidden" :style="{
        'background-image': `url('/herop2.png')`,
        'background-size': 'cover',
        'background-position': 'center',
        'background-repeat': 'no-repeat',
        'background-attachment': 'fixed'
    }">

        <div class="absolute inset-0 bg-blue-900/70 "></div>

        <div
            class="relative z-10 flex flex-col md:flex-row items-center justify-between w-full max-w-7xl px-6 md:px-12 gap-8">
            <div class="md:text-left text-white w-full md:w-2/3">
                <h2 class="text-2xl md:text-3xl font-bold mb-2">S'abonner à notre newsletter</h2>

                <form @submit.prevent="subscribe" class="flex items-center">
                    <div class="relative w-full">
                        <input v-model="email" type="email" placeholder="Entrez votre email"
                            class="w-full px-4 py-3 pl-5 pr-14 rounded-full text-gray-100 focus:outline-none focus:ring-2 focus:ring-white border border-solid border-white" />
                        <button type="submit"
                            class="absolute right-1 top-1/2 transform -translate-y-1/2 bg-white hover:bg-gray-200 text-blue-600 p-2 rounded-full transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 7.414V13a1 1 0 11-2 0V7.414L4.707 11.707a1 1 0 01-1.414-1.414l6-6z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
