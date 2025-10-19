<script setup lang="ts">
import { ref } from 'vue';
import NavbarFrontend from '@/components/frontend/NavbarFrontend.vue';
import TopBanner from '@/components/frontend/TopBanner.vue';
import FloatingAction from '@/components/frontend/FloatingAction.vue';
import Footer from '@/components/frontend/Footer.vue';
import { Head } from '@inertiajs/inertia-vue3';
import LoginReminder from '@/components/frontend/flash/LoginReminder.vue';

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

const props = defineProps<  Seo >();

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




const faqs = [
    { question: "Comment passer une commande ?", answer: "Pour passer une commande, rendez-vous sur la page produits et cliquez sur 'Ajouter au panier'..." },
    { question: "Quels moyens de paiement acceptez-vous ?", answer: "Nous acceptons Orange Money, Mobile Money, PayPal et les cartes bancaires." },
    { question: "Comment contacter le support ?", answer: "Vous pouvez nous écrire à walnertech@gmail.com ou appeler au 656 89 47 73 / 651 70 97 52." },
    { question: "Livrez-vous à l’international ?", answer: "Actuellement nous livrons uniquement au Cameroun. Nous prévoyons d'étendre la livraison bientôt." },
    { question: "Puis-je annuler ma commande ?", answer: "Oui, vous pouvez annuler votre commande tant qu'elle n'a pas été expédiée. Contactez notre support rapidement." },
    { question: "Comment suivre ma commande ?", answer: "Après expédition, nous vous enverrons un numéro de suivi par email ou SMS." },
    { question: "Que faire si je reçois un produit défectueux ?", answer: "Contactez notre support dans les 7 jours suivant la livraison pour un échange ou remboursement." },
    { question: "Proposez-vous des promotions ?", answer: "Oui, nous proposons régulièrement des promotions. Abonnez-vous à notre newsletter pour être informé." },
    { question: "Puis-je modifier mon adresse de livraison ?", answer: "Oui, avant que la commande ne soit expédiée. Contactez le support avec votre numéro de commande." }
];

const openIndex = ref(null);
function toggle(index) {
    openIndex.value = openIndex.value === index ? null : index;
}
</script>

<template>
       <Head :title="props.seo.title" />
    <TopBanner />
    <NavbarFrontend :auth="$page.props.auth" class="mt-10 md:mt-12" />
    <FloatingAction />
    <LoginReminder />
    <section class="faq-container max-w-3xl mx-auto px-4 py-12">
        <h1 class="text-3xl font-bold mb-8 text-center text-[var(--primary-blue)] dark:text-[var(--dark-accent)]">
            Foire Aux Questions (F.A.Q) Walner Tech
        </h1>
        <div class="space-y-4">
            <div v-for="(item, index) in faqs" :key="index" class="border-b border-gray-300 dark:border-gray-600 pb-2">
                <button @click="toggle(index)" class="w-full flex justify-between items-center text-left font-semibold">
                    <span>{{ item.question }}</span>
                    <span>{{ openIndex === index ? '-' : '+' }}</span>
                </button>
                <p v-if="openIndex === index" class="mt-1 text-sm text-[var(--dark-gold)] dark:text-gray-300">{{
                    item.answer }}</p>
            </div>
        </div>
    </section>
    <Footer/>
</template>
