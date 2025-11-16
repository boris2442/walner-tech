<script setup>
import { contact, products } from '@/routes';
import ressources from '@/routes/ressources';
import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Link } from '@inertiajs/vue3';
// Brand icons
import { faFacebook, faInstagram, faLinkedin, faTwitter } from '@fortawesome/free-brands-svg-icons';
// Solid icons
import { faEnvelope, faMapMarkerAlt, faPhone } from '@fortawesome/free-solid-svg-icons';
import Newsletter from './Newsletter.vue';

// Ajouter les icônes
library.add(faFacebook, faTwitter, faInstagram, faLinkedin, faPhone, faEnvelope, faMapMarkerAlt);

const currentYear = new Date().getFullYear();
</script>

<template>
    <Newsletter />
    <footer class="bg-[var(--primary-blue)] py-8 text-[var(--secondary-white)] dark:bg-[var(--dark-black)] dark:text-[var(--dark-white)]">
        <div class="flex flex-wrap items-start justify-between gap-6 px-6">
            <!-- Contact -->
            <div>
                <h3 class="mb-2 text-lg font-bold md:text-xl">Nous contacter</h3>
                <div class="mb-2 flex items-start gap-2">
                    <FontAwesomeIcon :icon="['fas', 'map-marker-alt']" class="mt-1" />
                    <span class="text-[var(--background-light)] dark:text-gray-300">
                        Bafoussam: Immeuble le Pelicant Ancien bureau des transports;<br />
                        Yaoundé Terminus mimboman face sapeur pompier
                    </span>
                </div>
                <div class="mb-2 flex items-center gap-2">
                    <FontAwesomeIcon :icon="['fas', 'phone']" />
                    <span class="text-[var(--background-light)] dark:text-gray-300">656 89 47 73 / 651 70 97 52</span>
                </div>
                <div class="flex items-center gap-2">
                    <FontAwesomeIcon :icon="['fas', 'envelope']" />
                    <a
                        href="mailto:walnertech@gmail.com"
                        class="text-[var(--dark-gold)] underline hover:text-[var(--text-secondary)] dark:text-gray-300"
                    >
                        walnertech@gmail.com
                    </a>
                </div>
            </div>
            <div>
                <h3 class="mb-2 text-lg font-bold md:text-xl">Liens Utiles</h3>
                <ul class="space-y-2">
                    <li>
                        <Link
                            :href="products()"
                            prefetch
                            preserve-scroll
                            preserve-state
                            class="nav-link block text-[var(--background-light)] hover:text-[var(--dark-gold)] dark:text-gray-300 dark:hover:text-[var(--dark-gold)]"
                        >
                            Produits
                        </Link>
                    </li>
                    <li>
                        <Link
                            href="/about"
                            prefetch
                            preserve-scroll
                            preserve-state
                            class="nav-link block text-[var(--background-light)] hover:text-[var(--dark-gold)] dark:text-gray-300 dark:hover:text-[var(--dark-gold)]"
                        >
                            À propos
                        </Link>
                    </li>
                    <li>
                        <Link
                            :href="contact()"
                            prefetch
                            preserve-scroll
                            preserve-state
                            class="nav-link block text-[var(--background-light)] hover:text-[var(--dark-gold)] dark:text-gray-300 dark:hover:text-[var(--dark-gold)]"
                        >
                            Contact
                        </Link>
                    </li>
                </ul>
            </div>
            <!-- Ressources / Lien légaux -->
            <div>
                <h3 class="mb-2 text-lg font-bold md:text-xl">Ressources</h3>
                <ul class="space-y-2">
                    <li>
                        <Link
                            prefetch
                            preserve-scroll
                            preserve-state
                            :href="ressources.notice().url"
                            class="nav-link block text-[var(--background-light)] hover:text-[var(--dark-gold)] dark:text-gray-300 dark:hover:text-[var(--dark-gold)]"
                        >
                            Mentions Légales
                        </Link>
                    </li>
                    <li>
                        <Link
                            prefetch
                            preserve-scroll
                            preserve-state
                            :href="ressources.policy().url"
                            class="nav-link block text-[var(--background-light)] hover:text-[var(--dark-gold)] dark:text-gray-300 dark:hover:text-[var(--dark-gold)]"
                        >
                            Politique de confidentialité
                        </Link>
                    </li>
                    <li>
                        <Link
                            prefetch
                            preserve-scroll
                            preserve-state
                            :href="ressources.cgu().url"
                            class="nav-link block text-[var(--background-light)] hover:text-[var(--dark-gold)] dark:text-gray-300 dark:hover:text-[var(--dark-gold)]"
                        >
                            Conditions générales d'utilisation
                        </Link>
                    </li>
                    <li>
                        <Link
                            prefetch
                            preserve-scroll
                            preserve-state
                            :href="ressources.noRemboursement().url"
                            class="nav-link block text-[var(--background-light)] hover:text-[var(--dark-gold)] dark:text-gray-300 dark:hover:text-[var(--dark-gold)]"
                        >
                            Politique de Non-Remboursement
                        </Link>
                    </li>
                    <li>
                        <Link
                            prefetch
                            preserve-scroll
                            preserve-state
                            :href="ressources.faq().url"
                            class="nav-link block font-semibold text-[var(--background-light)] hover:text-[var(--dark-gold)] dark:text-gray-300 dark:hover:text-[var(--dark-gold)]"
                        >
                            F.A.Q
                        </Link>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Ligne de séparation -->
        <div class="mx-auto my-6 w-[90%] border border-gray-300 dark:border-gray-600"></div>

        <!-- Bas du footer -->
        <div class="flex flex-wrap-reverse items-center justify-between gap-4 px-4">
            <div class="w-full md:w-auto">
                <p class="md:text-sm">&copy; {{ currentYear }} Walner Tech. Tous droits réservés.</p>
                <p class="md:text-sm">
                    Propulsé avec ❤️ par<span> <a href="https://borisaubin.vercel.app/" target="_blank" class="underline"> Aubin Boris Simo</a></span>
                </p>
            </div>
            <!-- Réseaux sociaux -->
            <div>
                <!-- <h3 class="font-bold text-lg md:text-xl mb-2">Suivez-nous</h3> -->
                <div class="flex justify-start gap-6 text-2xl">
                    <a
                        target="_blank"
                        href="https://www.facebook.com/walnertech"
                        class="hover:text-[var(--dark-gold)] dark:hover:text-[var(--dark-accent)]"
                    >
                        <FontAwesomeIcon :icon="['fab', 'facebook']" />
                    </a>
                    <a target="_blank" href="https://www.instagram.com/" class="hover:text-[var(--dark-gold)] dark:hover:text-[var(--dark-accent)]">
                        <FontAwesomeIcon :icon="['fab', 'instagram']" />
                    </a>
                    <a target="_blank" href="https://twitter.com/" class="hover:text-[var(--dark-gold)] dark:hover:text-[var(--dark-accent)]">
                        <FontAwesomeIcon :icon="['fab', 'twitter']" />
                    </a>
                    <a target="_blank" href="https://www.linkedin.com/" class="hover:text-[var(--dark-gold)] dark:hover:text-[var(--dark-accent)]">
                        <FontAwesomeIcon :icon="['fab', 'linkedin']" />
                    </a>
                </div>
            </div>
        </div>
    </footer>
</template>
