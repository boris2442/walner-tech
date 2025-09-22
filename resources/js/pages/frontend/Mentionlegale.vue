<script setup>
import NavbarFrontend from '@/components/frontend/NavbarFrontend.vue';
import Footer from '@/components/frontend/Footer.vue';
import { reactive } from 'vue';

// Sections pour v-for
const sections = reactive([
    {
        title: "1. Éditeur du site",
        content: "Le site Walner Tech est édité par Walner Tech , Bafoussam - Yaoundé, Cameroun."
    },
    {
        title: "2. Directeur de la publication",
        content: "Le directeur de la publication est Aubin Boris Simo Tsebo."
    },
    {
        title: "3. Hébergement",
        content: "Le site est hébergé sur Hostinger."
    },
    {
        title: "4. Propriété intellectuelle",
        content: "Tous les contenus (textes, images, vidéos, logos) présents sur ce site sont la propriété de Walner Tech ou de ses partenaires. Toute reproduction est interdite sans autorisation."
    },
    {
        title: "5. Données personnelles",
        content: 'Pour plus d’informations sur vos données personnelles, consultez notre <a href="/privacy-policy" class="text-blue-500">Politique de Confidentialité</a>.'
    },
    {
        title: "6. Responsabilité",
        content: "Walner Tech ne peut être tenu responsable des dommages directs ou indirects résultant de l’utilisation du site."
    },
    {
        title: "7. Contact",
        content: '📧 Email : <a href="mailto:walnertech@gmail.com" class="text-blue-500">WalnerTech@gmail.com</a><br/>📍 Adresse : Walner Tech, Bafoussam - Yaoundé, Cameroun'
    }
]);
</script>

<template>
    <NavbarFrontend />

    <section class="px-6 pt-24
md:px-20 md:pt-32 antialiased bg-[var(--secondary-white)] text-[var(--text-dark)]
                    dark:bg-[var(--dark-background)] dark:text-[var(--dark-white)]">
        <h1 class="text-3xl font-bold mb-2 text-color1">Mentions Légales</h1>

        <div v-for="(section, index) in sections" :key="index" class="mb-2">
            <h2 class="text-2xl font-semibold   text-[var(--primary-blue)] dark:text-[var(--dark-blue)]"
                v-html="section.title"></h2>
            <p v-html="section.content"></p>
        </div>
    </section>

    <Footer />
</template>

<style scoped>
.bg-color2 {
    background-color: #F5F5F5;
}

/* gris clair pour fond secondaire */
.text-color3 {
    color: #0A1B9E;
}

/* bleu foncé pour texte */
.text-color1 {
    color: #FFE600;
}

/* jaune vif pour titres principaux */
.text-color4 {
    color: #000000;
}

/* noir pour sous-titres */
@media (max-width: 640px) {
    h1 {
        font-size: 2rem;
    }

    h2 {
        font-size: 1.5rem;
    }
}
</style>
