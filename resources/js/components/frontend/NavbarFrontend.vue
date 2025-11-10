<script setup>
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { home, products, about, contact } from '@/routes';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import ContactNav from '@/components/frontend/ContactNav.vue';
import { faUserCircle, faSignOutAlt, faTachometerAlt } from '@fortawesome/free-solid-svg-icons';

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
  <nav class="bg-[var(--primary-blue)] dark:bg-[var(--dark-background)] shadow-md z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">

        <!-- Logo -->
        <div class="flex-shrink-0">
          <Link prefetch :href="home()">
          <img src="/assets/walner.png" loading="lazy" alt="Walner Tech" class="h-12 object-contain rounded border-2 border-solid border-gray-400" />
          </Link>
        </div>

        <!-- Menu desktop -->
        <div class="hidden md:flex space-x-6 flex-1 justify-center">

          <Link prefetch :href="about()" class="nav-link">À propos</Link>
          <Link prefetch :href="contact()" class="nav-link">Contact</Link>
        </div>

        <!-- Actions -->
        <div class="flex items-center space-x-4">

          <!-- Compte utilisateur -->
          <div class="relative flex items-center">
            <button @click="toggleAccountMenu" class="text-white flex items-center space-x-1 z-10 relative">
              <FontAwesomeIcon icon="user-circle" class="text-3xl" />
              <span class="hidden md:inline font-medium">Mon compte</span>
            </button>

            <div v-if="openAccountMenu"
              class="absolute top-full right-0 mt-2 w-44 bg-white dark:bg-[var(--dark-background)] rounded-xl shadow-xl py-2 z-20 flex flex-col border border-gray-200 dark:border-gray-700">
              <template v-if="isAuthenticated">
                <Link prefetch href="/dashboard" class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                Dashboard
                </Link>
                <Link prefetch href="/logout" method="post"
                  class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                Déconnexion
                </Link>
              </template>
              <template v-else>
                <Link prefetch href="/login" class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                Se connecter
                </Link>
                <Link prefetch href="/register" class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                S’inscrire</Link>
              </template>
            </div>
          </div>

          <!-- Burger menu mobile -->
          <div class="md:hidden flex items-center">
            <button @click="openMenu = !openMenu" class="text-white flex items-center space-x-1">
              <svg v-if="!openMenu" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
              <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
              <span class="font-medium">Menu</span>
            </button>
          </div>

        </div>
      </div>
    </div>

    <!-- Menu mobile -->
    <div v-if="openMenu"
      class="md:hidden px-4 pt-2 pb-4 space-y-2 bg-[var(--primary-blue)] dark:bg-[var(--dark-background)] flex flex-col">
      <!-- <Link prefetch :href="products()" class="block nav-link">Produits</Link> -->
      <Link prefetch :href="about()" class="block nav-link">À propos</Link>
      <Link prefetch :href="contact()" class="block nav-link">Contact</Link>
    </div>

    <ContactNav />
  </nav>
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
