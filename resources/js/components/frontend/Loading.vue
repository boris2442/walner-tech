<script setup>
import { onMounted, ref } from 'vue';

const progress = ref(0);
const show = ref(true);

onMounted(() => {
    const interval = setInterval(() => {
        if (progress.value < 100) {
            progress.value += 1;
        } else {
            clearInterval(interval);
            show.value = false; // cacher loader après 100%
        }
    }, 25); // vitesse du chargement (plus rapide pour effet puissant)
});
</script>

<template>
    <div v-if="show" class="banner fixed inset-0 z-[9999] flex flex-col items-center justify-center">
        <!-- Cercle rotatif dynamique -->
        <div
            class="animate-spin-scale mb-6 h-20 w-20 rounded-full border-4 border-t-transparent border-r-[var(--primary-blue)] border-b-[var(--highlight-gold)] border-l-[var(--primary-blue)]"
        ></div>

        <!-- Barre de progression flashy -->
        <div class="mb-3 h-5 w-72 max-w-[90vw] overflow-hidden rounded border border-[var(--text-secondary)]">
            <div
                :style="{ width: progress + '%' }"
                class="h-full bg-gradient-to-r from-yellow-400 via-red-500 to-pink-500 shadow-lg transition-all duration-300"
            ></div>
        </div>

        <!-- Texte animé -->
        <p class="animate-pulse text-lg font-bold tracking-wide text-[var(--text-secondary)] md:text-xl dark:text-[var(--dark-white)]">
            Loading... {{ progress }}%
        </p>
    </div>
</template>

<style scoped>
/* Cercle rotatif pulsé */
@keyframes spin-scale {
    0% {
        transform: rotate(0deg) scale(1);
    }

    50% {
        transform: rotate(180deg) scale(1.15);
    }

    100% {
        transform: rotate(360deg) scale(1);
    }
}

.animate-spin-scale {
    animation: spin-scale 1s linear infinite;
}

/* Optionnel : ajouter glow sur barre de progression */
div > div {
    box-shadow: 0 0 12px rgba(255, 200, 50, 0.6);
}
</style>
