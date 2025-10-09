<script setup>
import { Link } from '@inertiajs/vue3'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { library } from '@fortawesome/fontawesome-svg-core'
import ressources from '@/routes/ressources'
import { about, contact, home, products } from '@/routes';
// Brand icons
import { faFacebook, faTwitter, faInstagram, faLinkedin } from '@fortawesome/free-brands-svg-icons'
// Solid icons
import { faPhone, faEnvelope, faMapMarkerAlt } from '@fortawesome/free-solid-svg-icons'

// Ajouter les icônes
library.add(faFacebook, faTwitter, faInstagram, faLinkedin, faPhone, faEnvelope, faMapMarkerAlt)

const currentYear = new Date().getFullYear()
</script>

<template>

  <footer
    class="bg-[var(--primary-blue)] text-[var(--secondary-white)] dark:bg-[var(--dark-background)] dark:text-[var(--dark-white)] py-8">
    <div class="flex justify-between flex-wrap items-start gap-6 px-6">

      <!-- Contact -->
      <div>
        <h3 class="font-bold text-lg md:text-xl mb-2">Nous contacter</h3>
        <div class="flex items-start gap-2 mb-2">
          <FontAwesomeIcon :icon="['fas', 'map-marker-alt']" class="mt-1" />
          <span>
            Bafoussam: Immeuble le Pelicant Ancien bureau des transports;<br />
            Yaoundé Terminus mimboman face sapeur pompier
          </span>
        </div>
        <div class="flex items-center gap-2 mb-2">
          <FontAwesomeIcon :icon="['fas', 'phone']" />
          <span>656 89 47 73 / 651 70 97 52</span>
        </div>
        <div class="flex items-center gap-2">
          <FontAwesomeIcon :icon="['fas', 'envelope']" />
          <a href="mailto:walnertech@gmail.com"
            class="underline text-[var(--dark-gold)] dark:text-[var(--dark-accent)] hover:text-[var(--text-secondary)]">
            walnertech@gmail.com
          </a>
        </div>
      </div>
      <div>
        <h3 class="font-bold text-lg md:text-xl mb-2">Liens Utiles</h3>
        <ul class="space-y-2">

          <li>
            <Link :href="products()" prefetch
              class="block text-[var(--background-light)] hover:text-[var(--dark-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)] nav-link">
            Produits
            </Link>
          </li>
          <li>
            <Link href="/about" prefetch
              class="block text-[var(--background-light)] hover:text-[var(--dark-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)] nav-link">
            À propos
            </Link>
          </li>
          <li>
            <Link :href="contact()" prefetch
              class="block text-[var(--background-light)] hover:text-[var(--dark-gold)] dark:text-[var(--dark-accent)] dark:hover:text-[var(--dark-gold)] nav-link">
            Contact
            </Link>
          </li>
        </ul>
      </div>
      <!-- Ressources / Lien légaux -->
      <div>
        <h3 class="font-bold text-lg md:text-xl mb-2">Ressources</h3>
        <ul class="space-y-2">
          <li>
            <Link prefetch :href="ressources.notice().url"
              class="hover:text-[var(--dark-gold)] dark:hover:text-[var(--dark-accent)]">
            Mentions Légales
            </Link>
          </li>
          <li>
            <Link prefetch :href="ressources.policy().url"
              class="hover:text-[var(--dark-gold)] dark:hover:text-[var(--dark-accent)]">
            Politique de confidentialité
            </Link>
          </li>
          <li>
            <Link prefetch :href="ressources.cgu().url"
              class="hover:text-[var(--dark-gold)] dark:hover:text-[var(--dark-accent)]">
            Conditions générales d'utilisation
            </Link>
          </li>
          <li>
            <Link prefetch :href="ressources.noRemboursement().url"
              class="hover:text-[var(--dark-gold)] dark:hover:text-[var(--dark-accent)]">
            Politique de Non-Remboursement
            </Link>
          </li>
          <li>
            <Link prefetch :href="ressources.faq().url"
              class="hover:text-[var(--dark-gold)] dark:hover:text-[var(--dark-accent)] font-semibold">
            F.A.Q
            </Link>
          </li>
        </ul>
      </div>



    </div>

    <!-- Ligne de séparation -->
    <div class="border border-gray-300 dark:border-gray-600 mx-auto w-[90%] my-6"></div>

    <!-- Bas du footer -->
    <div class="flex justify-between  items-center gap-4 px-4">
      <div class=" w-full md:w-auto">
        <p class="text-xs md:text-sm">&copy; {{ currentYear }} Walner Tech. Tous droits réservés.</p>
        <p class="text-xs md:text-sm">Propulsé avec ❤️ par Aubin Boris Simo</p>
      </div>
      <!-- Réseaux sociaux -->
      <div>
        <!-- <h3 class="font-bold text-lg md:text-xl mb-2">Suivez-nous</h3> -->
        <div class="flex justify-start gap-6 text-2xl">
          <a target="_blank" href="https://www.facebook.com/walnertech"
            class="hover:text-[var(--dark-gold)] dark:hover:text-[var(--dark-accent)]">
            <FontAwesomeIcon :icon="['fab', 'facebook']" />
          </a>
          <a target="_blank" href="https://www.instagram.com/"
            class="hover:text-[var(--dark-gold)] dark:hover:text-[var(--dark-accent)]">
            <FontAwesomeIcon :icon="['fab', 'instagram']" />
          </a>
          <a target="_blank" href="https://twitter.com/"
            class="hover:text-[var(--dark-gold)] dark:hover:text-[var(--dark-accent)]">
            <FontAwesomeIcon :icon="['fab', 'twitter']" />
          </a>
          <a target="_blank" href="https://www.linkedin.com/"
            class="hover:text-[var(--dark-gold)] dark:hover:text-[var(--dark-accent)]">
            <FontAwesomeIcon :icon="['fab', 'linkedin']" />
          </a>
        </div>
      </div>
    </div>
  </footer>
</template>
