<script setup>
import { ref } from 'vue'

// Messages à faire défiler
const messages = [
    '📞 656 89 47 73',
    '📞 651 70 97 52',
    '💬 Disponible 24h/24 sur WhatsApp'
]

// Lien direct WhatsApp
const whatsappLink = 'https://wa.me/237656894773'

// Ref pour contrôler l'animation
const isPaused = ref(false)
</script>

<template>
    <div class="fixed top-0 left-0 w-full z-50 overflow-hidden
             bg-[var(--flash)] text-[var(--secondary-white)]
             dark:bg-[var(--dark-blue)] dark:text-[var(--dark-white)]
             h-10 md:h-12 flex items-center">

        <div class="whitespace-nowrap flex items-center gap-8 px-6" :class="{ 'animate-marquee': !isPaused }"
            @mouseenter="isPaused = true" @mouseleave="isPaused = false">
            <template v-for="(msg, i) in messages" :key="i">
                <span v-if="msg.includes('WhatsApp')">
                    <a :href="whatsappLink" target="_blank"
                        class="flex items-center gap-1 hover:text-[var(--accent-cyan)] transition">
                        💬 Disponible 24h/24 sur WhatsApp
                    </a>
                </span>
                <span v-else>{{ msg }}</span>
            </template>
        </div>
    </div>
</template>

<style scoped>
@keyframes marquee {
    from {
        transform: translateX(100%);
    }

    to {
        transform: translateX(-100%);
    }
}

.animate-marquee {
    animation: marquee 20s linear infinite;
}
</style>
