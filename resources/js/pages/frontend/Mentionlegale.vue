<script setup lang="ts">
import NavbarFrontend from '@/components/frontend/NavbarFrontend.vue';
import FloatingAction from '@/components/frontend/FloatingAction.vue';
import Footer from '@/components/frontend/Footer.vue';
import { reactive } from 'vue';
import { Link } from '@inertiajs/vue3';
import BackButton from '@/components/frontend/BackButton.vue';
import LoginReminder from '@/components/frontend/flash/LoginReminder.vue';
import { Head } from '@inertiajs/inertia-vue3';

import { useHead } from '@vueuse/head';
import { computed } from 'vue';

interface Seo {
  seo:{

    title: string;
    description: string;
    image: string;
    url: string;
    robots?: string;
  }
}

const props = defineProps< Seo >();

useHead({
    title: computed(() => props.seo.title),
    meta: [
        { name: 'description', content: computed(() => props.seo.description) },
        { name: 'robots', content: props.seo.robots || 'index, follow' },
        { property: 'og:title', content: computed(() => props.seo.title) },
        { property: 'og:description', content: computed(() => props.seo.description) },
        { property: 'og:image', content: computed(() => props.seo.image) },
        { property: 'og:url', content: computed(() => props.seo.url) },
        { property: 'og:type', content: 'website' },
        { name: 'twitter:card', content: 'summary_large_image' },
        { name: 'twitter:title', content: computed(() => props.seo.title) },
        { name: 'twitter:description', content: computed(() => props.seo.description) },
        { name: 'twitter:image', content: computed(() => props.seo.image) },
    ],
});







// Sections dynamiques
const sections = reactive([
  {
    title: "1. Éditeur du site",
    text: "Le site Walner Tech est édité par Walner Tech, Bafoussam - Yaoundé, Cameroun."
  },
  {
    title: "2. Directeur de la publication",
    text: "Le directeur de la publication est Aubin Boris Simo Tsebo."
  },
  {
    title: "3. Hébergement",
    text: "Le site est hébergé sur Hostinger."
  },
  {
    title: "4. Propriété intellectuelle",
    text: "Tous les contenus (textes, images, vidéos, logos) présents sur ce site sont la propriété de Walner Tech ou de ses partenaires. Toute reproduction est interdite sans autorisation."
  },
  {
    title: "5. Données personnelles",
    text: "Pour plus d’informations sur vos données personnelles, consultez notre",
    link: { url: '/confidentialite', label: 'Politique de Confidentialité' }
  },
  {
    title: "6. Responsabilité",
    text: "Walner Tech ne peut être tenu responsable des dommages directs ou indirects résultant de l’utilisation du site."
  },
  {
    title: "7. Contact",
    text: "📧 Email :",
    link: { url: 'mailto:walnertech@gmail.com', label: 'WalnerTech@gmail.com' },
    extraText: "📍 Adresse : Walner Tech, Bafoussam - Yaoundé, Cameroun"
  }
]);
</script>

<template>
    <!-- Le composant Inertia Head assure aussi le rendu côté serveur -->

    <Head :title="props.seo.title" />
  <NavbarFrontend :auth="$page.props.auth"/>
   <FloatingAction/>
      <LoginReminder />
  <section
    class="px-6   antialiased bg-[var(--secondary-white)] text-[var(--text-dark)] dark:bg-[var(--dark-background)] dark:text-[var(--dark-white)]">
    <!-- 🔹 Bouton retour --> <br>
    <BackButton />


    <h1 class="text-3xl font-bold mb-8 text-center text-[var(--primary-blue)] dark:text-[var(--dark-accent)]">
      Mentions Légales Walner Tech
    </h1>

    <div v-for="(section, index) in sections" :key="index" class="mb-6">
      <h2 class="text-2xl  font-semibold text-[var(--primary-blue)] dark:text-[var(--primary-blue)] mb-2">
        {{ section.title }}
      </h2>

      <p class="text-[var(--text-secondary)] dark:text-[var(--dark-grey)] leading-relaxed">
        {{ section.text }}
        <template v-if="section.link">
          <Link :href="section.link.url" class="text-[var(--highlight-gold)] ml-1">
          {{ section.link.label }}
          </Link>
        </template>
        <span v-if="section.extraText"> <br />{{ section.extraText }}</span>
      </p>
    </div>
  </section>

  <Footer />
</template>

<style scoped>
/* Responsive typography */
@media (max-width: 640px) {
  h1 {
    font-size: 2rem;
  }

  h2 {
    font-size: 1.5rem;
  }
}
</style>
