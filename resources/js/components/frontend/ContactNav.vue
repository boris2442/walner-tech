<template>
    <div class="bg-orange-500 p-4 rounded-lg text-center shadow-md banner">

        <h3 class="text-white font-bold mb-2 text-2xl">Reservez en toute secutite via</h3>

        <!-- Boutons -->
        <div class="flex  sm:flex-row gap-3 justify-center text-sm">
            <!-- Bouton Téléphone (bleu foncé) -->
            <a href="https://wa.me/237651709752" target="_blank"
                class="flex items-center justify-center bg-blue-900 text-white px-2 py-2 rounded-lg font-semibold hover:bg-blue-800 transition ease-in-out duration-200  ">
                <Phone class="h-5 w-5 mr-1" />
                +237 651 70 97 52
            </a>

            <!-- Bouton WhatsApp (vert) -->
            <a href="https://wa.me/237656894773" target="_blank" rel="noopener noreferrer"
                class="flex items-center justify-center bg-green-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-600 transition ease-in-out duration-200 ">
                <!-- <MessageCircle class="h-5 w-5 ml-2" /> -->
                <FontAwesomeIcon :icon="['fab', 'whatsapp']" class="h-5 w-5 ml-2 text-xl" />
                <span class="text-sm">+237 656 89 47 731</span>

            </a>
        </div>
    </div>
</template>

<script setup>
// Import des icônes Lucide
import { Phone, MessageCircle } from 'lucide-vue-next';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faWhatsapp } from '@fortawesome/free-brands-svg-icons'
library.add(faWhatsapp)
</script>

<style scoped>
/* Optionnel : style personnalisé si besoin */
</style>