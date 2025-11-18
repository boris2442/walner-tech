<script setup>
import ContactNav from '@/components/frontend/ContactNav.vue';
import SocialMedia from '@/components/frontend/SocialMedia.vue';
import ThemeToggle from '@/components/frontend/ThemeToggle .vue';
import { about, contact, home } from '@/routes';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faSignOutAlt, faTachometerAlt, faUserCircle } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
const logoUrl = '/walner.jpg';
library.add(faUserCircle, faSignOutAlt, faTachometerAlt);

const props = defineProps({ auth: Object });
const isAuthenticated = computed(() => !!props.auth?.user);

const openMenu = ref(false);
const openAccountMenu = ref(false);

function toggleAccountMenu() {
    openAccountMenu.value = !openAccountMenu.value;
}
</script>

<template>
    <header>
        <nav class="z-50 bg-[var(--primary-blue)] shadow-md dark:bg-[var(--dark-background)]">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <!-- Logo -->
                    <div class="flex-shrink-0">
                        <Link prefetch :href="home()" preserve-scroll preserve-state>
                            <img
                                src="/assets/walner.png"
                                loading="lazy"
                                alt="Walner Tech"
                                class="h-12 rounded border-2 border-solid border-gray-400 object-contain"
                            />
                        </Link>
                    </div>

                    <!-- Menu desktop -->
                    <div class="hidden flex-1 justify-center space-x-6 md:flex">
                        <Link prefetch :href="about()" class="nav-link">À propos</Link>
                        <Link prefetch :href="contact()" class="nav-link">Contact</Link>
                        <!-- <ThemeToggle /> -->
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center space-x-4">
                        <!-- Toggle Dark/Light -->
                        <ThemeToggle />

                        <!-- Compte utilisateur -->
                        <div class="relative flex items-center">
                            <button @click="toggleAccountMenu" class="relative z-10 flex items-center space-x-1 text-white">
                                <FontAwesomeIcon icon="user-circle" class="text-3xl" />
                                <span class="hidden font-medium md:inline">Mon compte</span>
                            </button>

                            <div
                                v-if="openAccountMenu"
                                class="absolute top-full right-0 z-20 mt-2 flex w-44 flex-col rounded-xl border border-gray-200 bg-white py-2 shadow-xl dark:border-gray-700 dark:bg-[var(--dark-background)]"
                            >
                                <template v-if="isAuthenticated">
                                    <Link prefetch href="/dashboard" class="px-4 py-2 transition hover:bg-gray-100 dark:hover:bg-gray-800">
                                        Dashboard
                                    </Link>
                                    <Link prefetch href="/logout" method="post" class="px-4 py-2 transition hover:bg-gray-100 dark:hover:bg-gray-800">
                                        Déconnexion
                                    </Link>
                                </template>
                                <template v-else>
                                    <Link prefetch href="/login" class="px-4 py-2 transition hover:bg-gray-100 dark:hover:bg-gray-800">
                                        Se connecter
                                    </Link>
                                    <Link prefetch href="/register" class="px-4 py-2 transition hover:bg-gray-100 dark:hover:bg-gray-800">
                                        S’inscrire</Link
                                    >
                                </template>
                            </div>
                        </div>

                        <!-- Burger menu mobile -->
                        <!-- <div class="flex items-center md:hidden">
                            <button @click="openMenu = !openMenu"
                             class="flex items-center space-x-1 text-white">
                                <svg
                                    v-if="!openMenu"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                                <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <span class="font-medium">Menu</span>
                            </button>
                        </div> -->

                        <div class="flex items-center md:hidden">
                            <button
                                @click="openMenu = !openMenu"
                                class="flex items-center space-x-2 rounded-lg border border-white/50 bg-white/10 px-3 py-2 font-medium text-white shadow-sm transition-all duration-200 hover:scale-105 hover:bg-white/20"
                            >
                                <!-- Icône hamburger / close -->
                                <svg
                                    v-if="!openMenu"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                                <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>

                                <!-- Texte Menu -->
                                <span>Menu</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menu mobile -->
            <div v-if="openMenu" class="flex flex-col space-y-2 bg-[var(--primary-blue)] px-4 pt-2 pb-4 md:hidden dark:bg-[var(--dark-background)]">
                <!-- <Link prefetch :href="products()" class="block nav-link">Produits</Link> -->
                <Link prefetch :href="about()" class="nav-link block">À propos</Link>
                <Link prefetch :href="contact()" class="nav-link block">Contact</Link>
            </div>

            <ContactNav />
        </nav>
        <!-- Icônes réseaux sociaux -->
        <div class="mt-4 flex justify-center px-6">
            <SocialMedia />
        </div>
    </header>
</template>

<style scoped>
.nav-link {
    color: var(--dark-white);
    transition: color 0.3s;
    cursor: pointer;
    display: inline-block;
    padding: 4px 0;
}

.nav-link:hover {
    color: var(--dark-gold);
}

button svg {
    transition: transform 0.2s ease;
}
</style>
