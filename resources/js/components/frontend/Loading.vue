<script setup>
import { ref, onMounted } from 'vue';

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
    <div v-if="show"
        class="fixed inset-0 flex flex-col justify-center items-center  z-[9999] banner">

        <!-- Cercle rotatif dynamique -->
        <div
            class="w-20 h-20 rounded-full border-4 border-t-transparent border-b-[var(--highlight-gold)] border-l-[var(--primary-blue)] border-r-[var(--primary-blue)] animate-spin-scale mb-6">
        </div>

        <!-- Barre de progression flashy -->
        <div class="w-72 max-w-[90vw] h-5 rounded overflow-hidden mb-3 border border-[var(--text-secondary)]">
            <div :style="{ width: progress + '%' }"
                class="h-full bg-gradient-to-r from-yellow-400 via-red-500 to-pink-500 shadow-lg transition-all duration-300">
            </div>
        </div>

        <!-- Texte animé -->
        <p
            class="text-[var(--text-secondary)] dark:text-[var(--dark-white)] font-bold tracking-wide text-lg md:text-xl animate-pulse">
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
div>div {
    box-shadow: 0 0 12px rgba(255, 200, 50, 0.6);
}
</style>
