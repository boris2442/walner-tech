<!-- <script setup>
import { ref, onMounted, computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { about, contact, home, products } from '@/routes';
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




const props = defineProps({
  auth: {
    type: Object,
    required: true
  }
});


const open = ref(false);
const openAccountMenu = ref(false);
const isDark = ref(false);




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


        <div class="flex-shrink-0">
          <Link :href="home()" prefetch>
          <img src="assets/walner.png" alt="Walner Tech" class="max-h-14 object-cover" />
          </Link>
        </div>


        <div class="hidden md:flex space-x-6 justify-center flex-1">
          <Link :href="products()" prefetch
            class=" text-[var(--background-light)] hover:text-[var(--dark-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)] nav-link">
          Produits</Link>

          <Link :href="about()" prefetch
            class=" text-[var(--background-light)] hover:text-[var(--dark-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)] nav-link">
          À propos</Link>
          <Link :href="contact()" prefetch
            class=" text-[var(--background-light)] hover:text-[var(--dark-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)] nav-link">
          Contact</Link>
        </div>



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

        <div class="md:hidden">
          <button @click="open = !open"
            class="focus:outline-none text-[var(--background-light)] dark:text-[var(--dark-accent)] flex">
            <svg v-if="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span>MENU</span>
          </button>
        </div>
      </div>

    </div>


    <div v-if="open"
      class="md:hidden px-4 pt-2 pb-4 space-y-2 bg-[var(--primary-blue)] dark:bg-[var(--dark-background)]">
      <Link :href="products()" prefetch
        class="block text-[var(--background-light)] hover:text-[var(--dark-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)] nav-link">
      Produits
      </Link>

      <Link href="/about" prefetch
        class="block text-[var(--background-light)] hover:text-[var(--dark-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)] nav-link">
      À propos
      </Link>
      <Link :href="contact()" prefetch
        class="block text-[var(--background-light)] hover:text-[var(--dark-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)] nav-link">
      Contact
      </Link>


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
</style> -->



<script setup>
import { ref, onMounted, computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { home, products, about, contact } from '@/routes';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import {
  faUserCircle,
  faSignOutAlt,
  faTachometerAlt
} from '@fortawesome/free-solid-svg-icons';

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
  <nav class="bg-[var(--primary-blue)] dark:bg-[var(--dark-background)] shadow-md z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">

        <!-- Logo -->
        <div class="flex-shrink-0">
          <Link :href="home()">
          <img src="assets/walner.png" alt="Walner Tech" class="h-12 object-contain" />
          </Link>
        </div>

        <!-- Menu desktop -->
        <div class="hidden md:flex space-x-6 flex-1 justify-center">
          <Link :href="products()" class="nav-link">Produits</Link>
          <Link :href="about()" class="nav-link">À propos</Link>
          <Link :href="contact()" class="nav-link">Contact</Link>
        </div>

        <!-- Actions (toujours visibles) -->
        <div class="flex items-center space-x-4">

          <!-- Compte toujours visible -->
          <div class="relative">
            <button @click="toggleAccountMenu" class="text-white text-2xl">
              <FontAwesomeIcon icon="user-circle" />
            </button>
            <div v-if="openAccountMenu"
              class="absolute right-0 mt-2 w-44 bg-white dark:bg-[var(--dark-background)] rounded-md shadow-lg py-1 z-50">
              <template v-if="isAuthenticated">
                <Link href="/dashboard" class="block px-4 py-2 nav-link">Dashboard</Link>
                <Link href="/logout" method="post" class="block px-4 py-2 nav-link">Déconnexion</Link>
              </template>
              <template v-else>
                <Link href="/login" class="block px-4 py-2 nav-link">Se connecter</Link>
                <Link href="/register" class="block px-4 py-2 nav-link">S’inscrire</Link>
              </template>
            </div>
          </div>

          <!-- Burger menu mobile -->
          <div class="md:hidden">
            <button @click="openMenu = !openMenu" class="text-white">
              <svg v-if="!openMenu" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
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
    </div>

    <!-- Menu mobile -->
    <div v-if="openMenu"
      class="md:hidden px-4 pt-2 pb-4 space-y-2 bg-[var(--primary-blue)] dark:bg-[var(--dark-background)] flex flex-col">
      <Link :href="products()" class="block nav-link">Produits</Link>
      <Link :href="about()" class="block nav-link">À propos</Link>
      <Link :href="contact()" class="block nav-link">Contact</Link>
    </div>
  </nav>
</template>

<style scoped>
.nav-link {
  color: rgb(38, 25, 25);
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
