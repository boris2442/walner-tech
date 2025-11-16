<script setup lang="ts">
import FlashMessageNewsletter from '@/components/FlashMessageNewsletter.vue';
import BackButton from '@/components/frontend/BackButton.vue';
import LoginReminder from '@/components/frontend/flash/LoginReminder.vue';
import FloatingAction from '@/components/frontend/FloatingAction.vue';
import Footer from '@/components/frontend/Footer.vue';
import NavbarFrontend from '@/components/frontend/NavbarFrontend.vue';
import CartWidget from '@/components/frontend/panier/CartWidget.vue';
import TopBanner from '@/components/frontend/TopBanner.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/vue3';
import { reactive } from 'vue';

// Sections dynamiques
const sections = reactive([
    {
        title: '1. Éditeur du site',
        text: 'Le site Walner Tech est édité par Walner Tech, Bafoussam - Yaoundé, Cameroun.',
    },
    {
        title: '2. Directeur de la publication',
        text: 'Le directeur de la publication est Aubin Boris Simo Tsebo.',
    },
    {
        title: '3. Hébergement',
        text: 'Le site est hébergé sur Hostinger.',
    },
    {
        title: '4. Propriété intellectuelle',
        text: 'Tous les contenus (textes, images, vidéos, logos) présents sur ce site sont la propriété de Walner Tech ou de ses partenaires. Toute reproduction est interdite sans autorisation.',
    },
    {
        title: '5. Données personnelles',
        text: 'Pour plus d’informations sur vos données personnelles, consultez notre',
        link: { url: '/ressources/confidentialite', label: 'Politique de Confidentialité' },
    },
    {
        title: '6. Responsabilité',
        text: 'Walner Tech ne peut être tenu responsable des dommages directs ou indirects résultant de l’utilisation du site.',
    },
    {
        title: '7. Contact',
        text: '📧 Email :',
        link: { url: 'mailto:walnertech@gmail.com', label: 'WalnerTech@gmail.com' },
        extraText: '📍 Adresse : Walner Tech, Bafoussam - Yaoundé, Cameroun',
    },
]);
</script>

<template>
    <CartWidget />
    <!-- Le composant Inertia Head assure aussi le rendu côté serveur -->
    <FlashMessageNewsletter />

    <Head title="Mention legales " />
    <TopBanner />
    <NavbarFrontend :auth="$page.props.auth as Record<string, any> | undefined" class="mt-10 md:mt-12" />
    <FloatingAction />
    <LoginReminder />
    <section
        class="bg-[var(--secondary-white)] px-6 text-[var(--text-dark)] antialiased dark:bg-[var(--dark-background)] dark:text-[var(--dark-white)]"
    >
        <!-- 🔹 Bouton retour -->
        <br />
        <BackButton />

        <h1 class="mb-8 text-3xl font-bold text-[var(--primary-blue)] dark:text-[var(--dark-accent)]">Mentions Légales</h1>

        <div v-for="(section, index) in sections" :key="index" class="mb-6">
            <h2 class="mb-2 text-2xl font-semibold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">
                {{ section.title }}
            </h2>

            <p class="leading-relaxed text-[var(--text-secondary)] dark:text-[var(--dark-grey)]">
                {{ section.text }}
                <template v-if="section.link">
                    <Link :href="section.link.url" class="ml-1 text-[var(--highlight-gold)] dark:text-[var(--dark-gold)]">
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
