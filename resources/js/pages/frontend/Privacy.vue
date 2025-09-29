<script setup>
import NavbarFrontend from '@/components/frontend/NavbarFrontend.vue';
import FloatingAction from '@/components/frontend/FloatingAction.vue';
import Footer from '@/components/frontend/Footer.vue';
import { reactive } from 'vue';
import BackButton from '@/components/frontend/BackButton.vue';

// Définition des sections pour v-for
const sections = reactive([
    {
        title: "1. Informations que nous collectons",
        content: [
            "Informations personnelles : nom, adresse e-mail, numéro de téléphone, etc.",
            "Données de navigation : adresse IP, type de navigateur, temps de connexion, pages visitées.",
            "Cookies : pour améliorer votre expérience utilisateur."
        ]
    },
    {
        title: "2. Utilisation des informations",
        content: [
            "Fournir, exploiter et améliorer nos services",
            "Personnaliser l’expérience utilisateur",
            "Répondre aux questions ou demandes de support",
            "Envoyer des communications importantes (newsletters, mises à jour)"
        ]
    },
    {
        title: "3. Partage des informations",
        content: "Nous ne vendons ni ne louons vos données personnelles. Elles peuvent être partagées avec nos partenaires de service ou les autorités judiciaires si nécessaire."
    },
    {
        title: "4. Sécurité des données",
        content: "Nous mettons en œuvre des mesures de sécurité strictes pour protéger vos données personnelles contre tout accès non autorisé ou utilisation abusive."
    },
    {
        title: "5. Vos droits",
        content: 'Vous pouvez accéder, corriger ou supprimer vos données personnelles. Vous avez également le droit de vous opposer à certains traitements. Contactez-nous à : <a href="mailto:WalnerTech99@gmail.com" class="text-blue-500">WalnerTech99@gmail.com</a>.'
    },
    {
        title: "6. Cookies",
        content: "Nous utilisons des cookies pour améliorer votre navigation. Vous pouvez les désactiver dans les paramètres de votre navigateur."
    },
    {
        title: "7. Modifications",
        content: "Cette politique peut être modifiée à tout moment. La date de mise à jour figurera toujours en haut de cette page."
    },
    {
        title: "8. Contact",
        content: '📧 Email : <a href="mailto:WalnerTech99@gmail.com" class="text-blue-500">WalnerTech99@gmail.com</a><br/>📍 Adresse : Walner Tech, Bafoussam - Yaoundé, Cameroun'
    }
]);
</script>

<template>
    <NavbarFrontend :auth="$page.props.auth" />
    <FloatingAction />
    <section class="px-6 pt-24
md:px-20 md:pt-32 antialiased bg-[var(--secondary-white)] text-[var(--text-dark)]
                    dark:bg-[var(--dark-background)] dark:text-[var(--dark-white)]">
        <!-- 🔹 Bouton retour -->
        <BackButton />
        <h1 class="text-3xl font-bold mb-8 text-color1">Politique de Confidentialité</h1>

        <p class="mb-6">
            Chez <strong>Walner Tech</strong>, la confidentialité de nos utilisateurs est une priorité absolue.
            Cette politique de confidentialité a pour but de vous informer sur la manière dont nous collectons,
            utilisons,
            protégeons et divulguons les informations que vous nous fournissez.
        </p>

        <div v-for="(section, index) in sections" :key="index" class="mb-8">
            <h2 class="text-2xl font-semibold mb-2  text-[var(--primary-blue)] dark:text-[var(--dark-blue)]"
                v-html="section.title"></h2>
            <div v-if="Array.isArray(section.content)">
                <ul class="list-disc list-inside space-y-2">
                    <li v-for="(item, i) in section.content" :key="i" v-html="item"></li>
                </ul>
            </div>
            <p v-else class="mb-2" v-html="section.content"></p>
        </div>
    </section>

    <Footer />
</template>

<style scoped>
/* Responsive et couleurs projet */
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
