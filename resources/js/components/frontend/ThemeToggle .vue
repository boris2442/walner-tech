<script setup>
import { onMounted, ref } from 'vue';

const isDark = ref(false);

onMounted(() => {
    const saved = localStorage.getItem('theme');
    isDark.value = saved === 'dark';

    if (isDark.value) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
});

function toggleTheme() {
    isDark.value = !isDark.value;

    if (isDark.value) {
        document.documentElement.classList.add('dark');
        localStorage.setItem('theme', 'dark');
    } else {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    }
}
</script>

<template>
    <button
        @click="toggleTheme"
        class="relative flex h-10 w-10 items-center justify-center rounded-full bg-white/10 shadow backdrop-blur-md transition-all duration-300 hover:bg-white/20 dark:bg-black/20 dark:hover:bg-black/30"
        aria-label="Changer de thème"
    >
        <!-- Soleil -->
        <svg
            v-if="!isDark"
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6 rotate-0 text-yellow-400 transition-transform duration-300 hover:rotate-90"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364-6.364l-1.414 1.414M7.05 16.95l-1.414 1.414m12.728 0l-1.414-1.414M7.05 7.05L5.636 5.636M12 8a4 4 0 110 8 4 4 0 010-8z"
            />
        </svg>

        <!-- Lune -->
        <svg
            v-else
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6 scale-110 text-blue-300 transition-all duration-300"
            fill="currentColor"
            viewBox="0 0 24 24"
        >
            <path d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z" />
        </svg>
    </button>
</template>

<style scoped>
button {
    border: 1px solid rgba(255, 255, 255, 0.15);
}
</style>
