<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { onMounted, ref } from 'vue';
// import { route } from 'ziggy-js';
const open = ref(false);
const cartCount = ref(3);
const isDark = ref(false);

// Lecture de la préférence stockée
onMounted(() => {
    const saved = localStorage.getItem('darkMode');
    if (saved === 'true') {
        isDark.value = true;
        document.documentElement.classList.add('dark');
    }
});

function toggleDark() {
    isDark.value = !isDark.value;
    if (isDark.value) {
        document.documentElement.classList.add('dark');
        localStorage.setItem('darkMode', 'true');
    } else {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('darkMode', 'false');
    }
}
</script>

<template>
    <nav class="fixed top-0 left-0 z-50 w-full bg-[var(--primary-blue)] shadow-[0_4px_6px_rgba(0,0,0,0.3)] dark:bg-[var(--dark-background)]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <Link href="/home">
                        <img src="assets/walner.png" alt="Walner Tech" class="max-h-14 w-auto object-cover rounded-full" />
                    </Link>
                </div>

                <!-- Menu principal Desktop -->
                <div class="hidden space-x-6 md:flex">
                    <Link
                        href="/products"
                        class="font-medium text-[var(--background-light)] hover:text-[var(--highlight-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)]"
                        >Produits</Link
                    >
                    <!-- <Link
                        href="#services"
                        class="font-medium text-[var(--background-light)] hover:text-[var(--highlight-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)]"
                        >Services</Link
                    > -->
                    <a
                        href="#services"
                        class="block font-medium text-[var(--background-light)] hover:text-[var(--highlight-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)]"
                    >
                        Services
                    </a>

                    <Link
                        href="/blog"
                        class="font-medium text-[var(--background-light)] hover:text-[var(--highlight-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)]"
                        >Blog</Link
                    >
                    <Link
                        href="/about"
                        class="font-medium text-[var(--background-light)] hover:text-[var(--highlight-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)]"
                    >
                        À propos
                    </Link>
                    <Link
                        href="/contact"
                        class="font-medium text-[var(--background-light)] hover:text-[var(--highlight-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)]"
                        >Contact</Link
                    >
                </div>

                <!-- Icons + Toggle -->
                <div class="flex items-center space-x-4">
                    <button @click="toggleDark" class="text-[#F5F5F5] hover:text-[#FFD700] focus:outline-none dark:text-[#0096FF]">
                        <svg v-if="isDark" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 3v1m0 16v1m8.485-8.485h1M3.515 12.515h1M18.364 5.636l.707.707M4.929 19.071l.707.707M18.364 18.364l.707-.707M4.929 4.929l.707-.707M12 5a7 7 0 100 14 7 7 0 000-14z"
                            />
                        </svg>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z" />
                        </svg>
                    </button>

                    <Link
                        href="/cart"
                        class="relative text-[var(--background-light)] hover:text-[var(--highlight-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)]"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9h14l-2-9M5 21h14"
                            />
                        </svg>
                        <span
                            v-if="cartCount > 0"
                            class="absolute -top-2 -right-2 flex h-5 w-5 items-center justify-center rounded-full bg-[#FFD700] text-xs text-black"
                            >{{ cartCount }}</span
                        >
                    </Link>

                    <Link
                        href="/account"
                        class="text-[var(--background-light)] hover:text-[var(--highlight-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)]"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5.121 17.804A12.004 12.004 0 0112 15c2.66 0 5.08.88 7.121 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                            />
                        </svg>
                    </Link>
                </div>

                <div class="flex items-center md:hidden">
                    <button @click="open = !open" class="text-[#F5F5F5] hover:text-[#FFD700] focus:outline-none dark:text-[#0096FF]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path v-if="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div v-if="open" class="space-y-2 px-4 pt-2 pb-4 md:hidden">
            <Link
                href="/products"
                class="block font-medium text-[var(--background-light)] hover:text-[var(--highlight-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)]"
                >Produits</Link
            >
            <!-- <Link
                href="#services"
                class="block font-medium text-[var(--background-light)] hover:text-[var(--highlight-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)]"
                >S
                ervices</Link
            > -->
            <a
                href="#services"
                class="block font-medium text-[var(--background-light)] hover:text-[var(--highlight-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)]"
            >
                Services
            </a>

            <Link
                href="/blog"
                class="block font-medium text-[var(--background-light)] hover:text-[var(--highlight-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)]"
                >Blog</Link
            >
            <Link
                href="/about"
                class="block font-medium text-[var(--background-light)] hover:text-[var(--highlight-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)]"
                >À propos</Link
            >
            <Link
                href="/contact"
                class="block font-medium text-[var(--accent-cyan)] hover:text-[var(--highlight-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)]"
                >Contact</Link
            >
        </div>
    </nav>
</template>


<style scoped>
/* Transitions douces pour le toggle */
button svg {
    transition: transform 0.2s ease;
}
</style>
