
<script setup>
import { ref, onMounted, computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { about, contact } from '@/routes';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import {
  faUserCircle,
  faSignOutAlt,
  faTachometerAlt,
  faMoon,
  faSun,
} from '@fortawesome/free-solid-svg-icons';
import {
  faFacebook,
  faInstagram,
  faTwitter,
  faLinkedin
} from '@fortawesome/free-brands-svg-icons';

library.add(
  faUserCircle,
  faSignOutAlt,
  faTachometerAlt,
  faMoon,
  faSun,
  faFacebook,
  faInstagram,
  faTwitter,
  faLinkedin
);



// Props auth venant de Laravel/Inertia
const props = defineProps({
  auth: {
    type: Object,
    required: true
  }
});


const open = ref(false);
const openAccountMenu = ref(false);
const isDark = ref(false);

// Computed pour savoir si utilisateur connecté
// const isAuthenticated = computed(() => !!props.auth?.user);


// Computed pour savoir si l’utilisateur est connecté
const isAuthenticated = computed(() => !!props.auth.user);

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
</script>

<template>
  <nav class="z-50 w-full bg-[var(--primary-blue)] shadow-[0_4px_6px_rgba(0,0,0,0.3)] dark:bg-[var(--dark-background)]">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex h-16 items-center justify-between">

        <!-- 1. Logo -->
        <div class="flex-shrink-0">
          <Link href="/" prefetch >
          <img src="assets/walner.png" alt="Walner Tech" class="max-h-14 object-cover" />
          </Link>
        </div>

        <!-- 2. Liens principaux (centre) -->
        <div class="hidden md:flex space-x-6 justify-center flex-1">
          <Link href="/products" prefetch 
            class=" text-[var(--background-light)] hover:text-[var(--dark-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)] nav-link">
          Produits</Link>
          <!-- <Link href="/blog" prefetch 
            class=" text-[var(--background-light)] hover:text-[var(--dark-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)] nav-link">
          Blog</Link> -->
          <Link :href="about()" prefetch 
            class=" text-[var(--background-light)] hover:text-[var(--dark-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)] nav-link">
          À propos</Link>
          <Link :href="contact()" prefetch 
            class=" text-[var(--background-light)] hover:text-[var(--dark-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)] nav-link">
          Contact</Link>
        </div>


        <!-- Auth / Utilisateur -->
        <div class="hidden md:flex items-center space-x-4">
          <div v-if="isAuthenticated" class="relative">
            <button @click="toggleAccountMenu" class="flex items-center space-x-2 nav-link">
              <FontAwesomeIcon icon="user-circle" class="text-lg" />
              <span
                class=" text-[var(--background-light)] hover:text-[var(--dark-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)] ">{{
                  props.auth.user.name }}</span>
            </button>
            <div v-if="openAccountMenu"
              class="absolute right-0 mt-2 w-48 bg-white dark:bg-[var(--dark-background)] rounded-md shadow-lg py-1 z-50">
              <Link href="/dashboard" prefetch prefetch-on="hover" class="block px-4 py-2 nav-link">Dashboard</Link>
              <Link href="/logout" method="post" class="block px-4 py-2 nav-link">Déconnexion</Link>
            </div>
          </div>
          <div v-else class="flex space-x-2">
            <Link href="/login" class="nav-link" prefetch prefetch-on="hover">Se connecter</Link>
            <Link href="/register" class="nav-link" prefetch prefetch-on="hover">S’inscrire</Link>
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
      <Link href="/admin/products" prefetch 
        class="block text-[var(--background-light)] hover:text-[var(--dark-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)] nav-link">
      Produits
      </Link>
      <!-- <Link href="/blog" prefetch 
        class="block text-[var(--background-light)] hover:text-[var(--dark-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)] nav-link">
      Blog
      </Link> -->
      <Link href="/about" prefetch 
        class="block text-[var(--background-light)] hover:text-[var(--dark-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)] nav-link">
      À propos
      </Link>
      <Link :href="contact()" prefetch 
        class="block text-[var(--background-light)] hover:text-[var(--dark-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)] nav-link">
      Contact
      </Link>

      <!-- Mobile Auth -->
      <div v-if="isAuthenticated" class="mt-2 space-y-1">
        <Link href="/dashboard"
          class="block px-4 py-2 text-[var(--background-light)] hover:text-[var(--dark-gold)] nav-link">
        Dashboard
        </Link>
        <Link href="/logout" method="post"
          class="block px-4 py-2 text-[var(--background-light)] hover:text-[var(--dark-gold)] nav-link">
        Déconnexion
        </Link>
      </div>
      <div v-else class="flex flex-col space-y-1 mt-2">
        <Link href="/login"
          class="block px-4 py-2 text-[var(--background-light)] hover:text-[var(--dark-gold)] nav-link">
        Se connecter
        </Link>
        <Link href="/register"
          class="block px-4 py-2 text-[var(--background-light)] hover:text-[var(--dark-gold)] nav-link">
        S’inscrire
        </Link>
      </div>
    </div>
  </nav>
</template>

<style scoped>
button svg {
  transition: transform 0.2s ease;
}

.nav-link {
  position: relative;
  display: inline-block;
  padding-bottom: 4px;
  transition: color 0.3s ease;
  cursor: pointer;
}

.nav-link::after {
  content: "";
  position: absolute;
  left: 50%;
  bottom: 0;
  width: 0;
  height: 2px;
  background-color: var(--dark-gold);
  border-radius: 2px;
  transform: translateX(-50%);
  transition: width 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
}

.nav-link:hover::after {
  width: 100%;
}

.nav-link:hover {
  color: var(--dark-gold);
}

@media (max-width: 768px) {
  .nav-link {
    display: block;
    padding-bottom: 6px;
  }

  .nav-link::after {
    left: 50%;
    transform: translateX(-50%);
  }
}
</style>
