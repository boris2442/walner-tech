<script setup>
import { ref, onMounted } from 'vue';

const progress = ref(0);
const show = ref(true);

onMounted(() => {
    // Simule le chargement
    const interval = setInterval(() => {
        if (progress.value < 100) {
            progress.value += 1;
        } else {
            clearInterval(interval);
            show.value = false; // cacher loader après 100%
        }
    }, 30); // vitesse du chargement
});
</script>

<template>
    <div v-if="show"
        class="fixed inset-0 flex flex-col justify-center items-center bg-[var(--background-light)] dark:bg-[var(--dark-background)] z-10000">
        <!-- Cercle rotatif -->
        <div
            class="w-16 h-16 border-4 border-[var(--primary-blue)] border-t-[var(--highlight-gold)] rounded-full animate-spin mb-6">
        </div>

        <!-- Barre de progression -->
        <div class="w-64 h-4 border border-[var(--text-secondary)] rounded overflow-hidden mb-2">
            <div class="h-full bg-[var(--primary-blue)] transition-all duration-300" :style="{ width: progress + '%' }">
            </div>
        </div>

        <p class="text-[var(--text-secondary)] dark:text-[var(--dark-white)] font-semibold tracking-wide">
            Loading... {{ progress }}%
        </p>
    </div>
</template>

<style scoped>

</style>
