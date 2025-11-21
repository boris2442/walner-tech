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
                <div class="mb-2 flex items-start gap-2 text-sm md:text-base">
                    <FontAwesomeIcon :icon="['fas', 'map-marker-alt']" class="mt-1" />
                    <span class="text-[var(--background-light)] dark:text-gray-300">
                        Bafoussam: Immeuble le Pelicant Ancien bureau des transports;<br />
                        Yaoundé Terminus mimboman face sapeur pompier
                    </span>
                </div>
                <div class="mb-2 flex items-center gap-2 text-sm md:text-base">
                    <FontAwesomeIcon :icon="['fas', 'phone']" />
                    <span class="text-[var(--background-light)] dark:text-gray-300">656 89 47 73 / 651 70 97 52</span>
                </div>
                <div class="flex items-center gap-2 text-sm md:text-base">
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
                <ul class="space-y-2 text-sm md:text-base">
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
                <!-- <h3 class="mb-2 text-lg font-bold md:text-xl">Ressources</h3> -->
                <ul class="flex flex-wrap gap-4 text-sm md:text-base">
                    <li>
                        <Link
                            prefetch
                            preserve-scroll
                            preserve-state
                            :href="ressources.notice().url"
                            class="nav-link text-[var(--dark-gold)] hover:text-[#E0BB38] dark:text-gray-300 dark:hover:text-[var(--dark-gold)]"
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
                            class="nav-link text-[var(--dark-gold)] hover:text-[#E0BB38] dark:text-gray-300 dark:hover:text-[var(--dark-gold)]"
                        >
                            Politique de Confidentialité
                        </Link>
                    </li>
                    <li>
                        <Link
                            prefetch
                            preserve-scroll
                            preserve-state
                            :href="ressources.cgu().url"
                            class="nav-link text-[var(--dark-gold)] hover:text-[#E0BB38] dark:text-gray-300 dark:hover:text-[var(--dark-gold)]"
                        >
                            Conditions Générales
                        </Link>
                    </li>
                    <li>
                        <Link
                            prefetch
                            preserve-scroll
                            preserve-state
                            :href="ressources.noRemboursement().url"
                            class="nav-link text-[var(--dark-gold)] hover:text-[#E0BB38] dark:text-gray-300 dark:hover:text-[var(--dark-gold)]"
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
                            class="nav-link font-semibold text-[var(--dark-gold)] hover:text-[#E0BB38] dark:text-gray-300 dark:hover:text-[var(--dark-gold)]"
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
        <div class="flex flex-wrap-reverse items-center justify-between gap-4 px-4 text-sm md:text-base">
            <div class="w-full md:w-auto">
                <p class="">&copy; {{ currentYear }} Walner Tech. Tous droits réservés.</p>
                <p class="text-sm md:text-base">
                    Propulsé avec <span class="heart-anim"> ❤️ </span> par
                    <span> <a href="https://borisaubin.vercel.app/" target="_blank" class="name-ultra"> Aubin Boris Simo</a></span>
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
                    <a
                        target="_blank"
                        href="https://www.linkedin.com/in/walner-tech-ab5284267/"
                        class="hover:text-[var(--dark-gold)] dark:hover:text-[var(--dark-accent)]"
                    >
                        <FontAwesomeIcon :icon="['fab', 'linkedin']" />
                    </a>
                </div>
            </div>
        </div>
    </footer>
</template>
<style scoped>
.heart-anim {
    display: inline-block;
    animation: heartbeat 1.5s ease-in-out infinite;
    transform-origin: center;
}

@keyframes heartbeat {
    0% {
        transform: scale(1);
    }
    10% {
        transform: scale(1.25);
    }
    20% {
        transform: scale(1);
    }
    30% {
        transform: scale(1.25);
    }
    40% {
        transform: scale(1);
    }
    100% {
        transform: scale(1);
    }
}

/* Animation du nom */
.name-anim {
    position: relative;
    display: inline-block;
    font-weight: 600;
    cursor: pointer;
    animation: textGlow 2.5s ease-in-out infinite;
    transition: transform 0.3s ease;
}

/* Glow subtil */
@keyframes textGlow {
    0% {
        text-shadow: 0 0 0px rgba(59, 130, 246, 0);
    }
    50% {
        text-shadow: 0 0 8px rgba(59, 130, 246, 0.45);
    }
    100% {
        text-shadow: 0 0 0px rgba(59, 130, 246, 0);
    }
}

/* Effet hover ultra propre */
.name-anim:hover {
    transform: translateY(-2px) scale(1.05);
}

/* Soulignement animé */
.name-anim::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: -2px;
    width: 0%;
    height: 2px;
    background: #3b82f6; /* bleu professionnel */
    transition: width 0.3s ease;
}

.name-anim:hover::after {
    width: 100%;
}

/* Coeur (on garde) */
.heart-anim {
    display: inline-block;
    animation: heartbeat 1.5s ease-in-out infinite;
    transform-origin: center;
}

@keyframes heartbeat {
    0% {
        transform: scale(1);
    }
    10% {
        transform: scale(1.25);
    }
    20% {
        transform: scale(1);
    }
    30% {
        transform: scale(1.25);
    }
    40% {
        transform: scale(1);
    }
    100% {
        transform: scale(1);
    }
}

/* NOM ULTRA ANIMÉ */
.name-ultra {
    position: relative;
    display: inline-block;
    font-weight: 700;
    background: linear-gradient(90deg, #3b82f6, #60a5fa, #2563eb);
    background-size: 200%;
    -webkit-background-clip: text;
    color: transparent;
    animation:
        gradientFlow 3s ease-in-out infinite,
        softShake 4s ease-in-out infinite;
    cursor: pointer;
    transition: transform 0.3s ease;
}

/* Déplacement du gradient */
@keyframes gradientFlow {
    0% {
        background-position: 0%;
    }
    50% {
        background-position: 100%;
    }
    100% {
        background-position: 0%;
    }
}

/* Légère vibration lente + élégante (professionnelle) */
@keyframes softShake {
    0% {
        transform: translateX(0);
    }
    50% {
        transform: translateX(2px);
    }
    100% {
        transform: translateX(0);
    }
}

/* Shimmer (reflet qui passe) */
.name-ultra::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    height: 100%;
    width: 100%;
    background: linear-gradient(120deg, transparent 0%, rgba(255, 255, 255, 0.4) 50%, transparent 100%);
    animation: shimmer 2.5s infinite;
}

@keyframes shimmer {
    0% {
        left: -100%;
    }
    50% {
        left: 120%;
    }
    100% {
        left: 120%;
    }
}

/* Effet hover encore plus attirant */
.name-ultra:hover {
    transform: scale(1.07) translateY(-2px);
    text-shadow: 0 0 15px rgba(59, 130, 246, 0.6);
}
</style>
