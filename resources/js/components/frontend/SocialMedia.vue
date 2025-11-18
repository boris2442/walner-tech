<template>
    <div class="flex space-x-4">
        <a
            v-for="social in socialLinks"
            :key="social.name"
            :href="social.url"
            target="_blank"
            class="relative flex h-10 w-10 items-center justify-center rounded-full bg-[var(--primary-blue)] text-white shadow-md transition-transform duration-200 hover:scale-110 hover:text-black"
            :title="`Suivez-nous sur ${social.name}`"
        >
            <font-awesome-icon :icon="social.icon" class="h-5 w-5" />

            <!-- Badge rouge pour WhatsApp -->
            <span
                v-if="social.name === 'WhatsApp'"
                class="animate-ping-badge absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-600 text-[0.65rem] font-bold text-white"
            >
                1
            </span>
        </a>
    </div>
</template>

<script setup>
import { faFacebookF, faInstagram, faLinkedinIn, faTwitter, faWhatsapp } from '@fortawesome/free-brands-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

const socialLinks = [
    { name: 'Facebook', url: 'https://www.facebook.com/walnertech', icon: faFacebookF },
    { name: 'WhatsApp', url: 'https://wa.me/656894773', icon: faWhatsapp },
    { name: 'Instagram', url: 'https://instagram.com/walnertech', icon: faInstagram },
    { name: 'Twitter', url: 'https://twitter.com/walnertech', icon: faTwitter },
    {
        name: 'LinkedIn',
        url: 'https://www.linkedin.com/in/walner-tech-ab5284267/',
        icon: faLinkedinIn,
    },
];
</script>

<style scoped>
@keyframes ping-badge {
    0%,
    100% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.4);
        opacity: 0.8;
    }
}
.animate-ping-badge {
    animation: ping-badge 1s infinite;
}
</style>
