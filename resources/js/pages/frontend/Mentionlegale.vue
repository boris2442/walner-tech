<script setup>
import NavbarFrontend from '@/components/frontend/NavbarFrontend.vue';
import FloatingAction from '@/components/frontend/FloatingAction.vue';
import Footer from '@/components/frontend/Footer.vue';
import { reactive } from 'vue';
import { Link } from '@inertiajs/vue3';
import BackButton from '@/components/frontend/BackButton.vue';
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
  <NavbarFrontend :auth="$page.props.auth"/>
   <FloatingAction/>
  <section
    class="px-6 pt-24 md:px-20 md:pt-32 antialiased bg-[var(--secondary-white)] text-[var(--text-dark)] dark:bg-[var(--dark-background)] dark:text-[var(--dark-white)]">
    <!-- 🔹 Bouton retour -->
    <BackButton />


    <h1 class="text-3xl md:text-4xl font-bold mb-8 text-[var(--dark-gold)]">
      Mentions Légales
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
