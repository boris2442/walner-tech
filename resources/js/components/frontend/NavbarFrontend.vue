<script setup>
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faUser, faUserCircle, faSignOutAlt, faTachometerAlt, faSignInAlt, faMoon, faSun } from '@fortawesome/free-solid-svg-icons';
import { faFacebook, faInstagram, faTwitter, faLinkedin } from '@fortawesome/free-brands-svg-icons';

library.add(faUser, faUserCircle, faSignOutAlt, faTachometerAlt, faSignInAlt, faMoon, faSun, faFacebook, faInstagram, faTwitter, faLinkedin);

const open = ref(false);
const openAccountMenu = ref(false);
const cartCount = ref(3);
const isDark = ref(false);
const isAuthenticated = ref(true); // Remplace par ton vrai state auth

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

function toggleAccountMenu() {
  openAccountMenu.value = !openAccountMenu.value;
}
// import 
</script>

<template>
  <nav
    class="fixed top-0 left-0 z-50 w-full bg-[var(--primary-blue)] shadow-[0_4px_6px_rgba(0,0,0,0.3)] dark:bg-[var(--dark-background)]">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex h-16 items-center justify-between">

        <!-- Logo -->
        <div class="flex-shrink-0">
          <Link href="/home">
          <img src="assets/walner.png" alt="Walner Tech" class="max-h-14 w-auto object-cover rounded-full" />
          </Link>
        </div>

        <!-- Menu Desktop -->
        <div class="hidden md:flex space-x-6 items-center justify-between">
          <Link href="/products"
            class="font-medium text-[var(--background-light)] hover:text-[var(--highlight-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)]">
          Produits</Link>
          <!-- <Link href="#services" class="font-medium text-[var(--background-light)] hover:text-[var(--highlight-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)]">Services</Link> -->
          <Link href="/blog"
            class="font-medium text-[var(--background-light)] hover:text-[var(--highlight-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)]">
          Blog</Link>
          <Link href="/about"
            class="font-medium text-[var(--background-light)] hover:text-[var(--highlight-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)]">
          À propos</Link>
          <Link href="/contact"
            class="font-medium text-[var(--background-light)] hover:text-[var(--highlight-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)]">
          Contact</Link>
        </div>

        <!-- Icons -->
        <div class="flex items-center space-x-8 ">
          <!-- Dark Mode Toggle -->
          <button @click="toggleDark" class="focus:outline-none">
            <FontAwesomeIcon :icon="isDark ? 'sun' : 'moon'"
              class="h-6 w-6 text-[var(--background-light)] dark:text-[var(--dark-accent)]" />
          </button>

          <!-- Cart -->
          <Link href="/cart"
            class="relative text-[var(--background-light)] hover:text-[var(--highlight-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)]">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9h14l-2-9M5 21h14" />
          </svg>
          <span v-if="cartCount > 0"
            class="absolute -top-2 -right-2 flex h-5 w-5 items-center justify-center rounded-full bg-[#FFD700] text-xs text-black">{{
              cartCount }}</span>
          </Link>

          <!-- Account -->
          <div class="relative">
            <button @click="toggleAccountMenu" class="focus:outline-none">
              <FontAwesomeIcon :icon="isAuthenticated ? 'user-circle' : 'user'"
                class="h-6 w-6 text-[var(--background-light)] dark:text-[var(--dark-accent)]" />
            </button>

            <div v-if="openAccountMenu"
              class="absolute right-0 mt-2 w-48 bg-[var(--secondary-white)] dark:bg-[var(--dark-background)] shadow-lg rounded-lg z-50 py-2">
              <!-- Non connecté -->
              <template v-if="!isAuthenticated">
                <Link href="/login"
                  class="flex items-center px-4 py-2 gap-2 hover:bg-[var(--highlight-gold)] dark:hover:bg-[var(--dark-gold)]">
                <FontAwesomeIcon icon="sign-in-alt" /> Sign In
                </Link>
                <Link href="/register"
                  class="flex items-center px-4 py-2 gap-2 hover:bg-[var(--highlight-gold)] dark:hover:bg-[var(--dark-gold)]">
                <FontAwesomeIcon icon="user" /> Register
                </Link>
              </template>

              <!-- Connecté -->
              <template v-else>
                <Link href="/dashboard"
                  class="flex items-center px-4 py-2 gap-2 hover:bg-[var(--highlight-gold)] dark:hover:bg-[var(--dark-gold)]">
                <FontAwesomeIcon icon="tachometer-alt" /> Dashboard
                </Link>
                <Link href="/logout"
                  class="flex items-center px-4 py-2 gap-2 hover:bg-[var(--highlight-gold)] dark:hover:bg-[var(--dark-gold)]">
                <FontAwesomeIcon icon="sign-out-alt" /> Sign Out
                </Link>
              </template>
            </div>
          </div>
        </div>

        <!-- Mobile Toggle -->
        <div class="md:hidden">
          <button @click="open = !open"
            class="focus:outline-none text-[var(--background-light)] dark:text-[var(--dark-accent)]">
            <svg v-if="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

      </div>
    </div>

    <!-- Mobile Menu -->
    <div v-if="open"
      class="md:hidden px-4 pt-2 pb-4 space-y-2 bg-[var(--primary-blue)] dark:bg-[var(--dark-background)]">
      <Link href="/products"
        class="block text-[var(--background-light)] hover:text-[var(--highlight-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)]">
      Produits</Link>
      <!-- <Link href="#services" class="block text-[var(--background-light)] hover:text-[var(--highlight-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)]">Services</Link> -->
      <Link href="/blog"
        class="block text-[var(--background-light)] hover:text-[var(--highlight-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)]">
      Blog</Link>
      <Link href="/about"
        class="block text-[var(--background-light)] hover:text-[var(--highlight-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)]">
      À propos</Link>
      <Link href="/contact"
        class="block text-[var(--background-light)] hover:text-[var(--highlight-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)]">
      Contact</Link>
    </div>
  </nav>
</template>

<style scoped>
button svg {
  transition: transform 0.2s ease;
}

nav {
  z-index: 1000 !important;
}
</style>
