<script>
import { Link } from '@inertiajs/vue3'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { library } from '@fortawesome/fontawesome-svg-core'

// Brand icons
import { faFacebook, faTwitter, faInstagram, faLinkedin } from '@fortawesome/free-brands-svg-icons'
// Solid icons
import { faPhone, faEnvelope, faMapMarkerAlt, faGlobe } from '@fortawesome/free-solid-svg-icons'

// Ajouter les icônes
library.add(faFacebook, faTwitter, faInstagram, faLinkedin, faPhone, faEnvelope, faMapMarkerAlt, faGlobe)

export default {
  components: { Link, FontAwesomeIcon },
  data() {
    return {
      openIndex: null,
      currentYear: new Date().getFullYear(),
      faqs: [
        { question: "Comment passer une commande ?", answer: "Pour passer une commande, rendez-vous sur la page produits et cliquez sur 'Ajouter au panier'..." },
        { question: "Quels moyens de paiement acceptez-vous ?", answer: "Nous acceptons Orange Money." },
        { question: "Comment contacter le support ?", answer: "Vous pouvez nous écrire à walnertech@gmail.com ou appeler au 656 89 47 73." },
        { question: "Livrez-vous à l’international ?", answer: "Actuellement nous livrons uniquement au Cameroun." }
      ]
    }
  },
  methods: {
    toggle(index) {
      this.openIndex = this.openIndex === index ? null : index
    }
  }
}
</script>

<template>
  <section>
    <footer
      class="bg-[var(--primary-blue)] text-[var(--secondary-white)] dark:bg-[var(--dark-background)] dark:text-[var(--dark-white)] py-8">
      <div class="flex justify-between flex-wrap items-start gap-6 px-6">

        <!-- Contact -->
        <div>
          <h3 class="font-bold text-lg md:text-xl mb-2">Nous contacter</h3>

          <div class="flex items-center gap-2 mb-2">
            <FontAwesomeIcon :icon="['fas', 'map-marker-alt']" />
            <span>Bafoussam: Immeuble le pelicant Ancien bureau des transports;<br /> Yaoundé Terminus mimboman face sapeur
              pompier</span>
          </div>

          <div class="flex items-center gap-2 mb-2">
            <FontAwesomeIcon :icon="['fas', 'phone']" />
            <span>656 89 47 73 / 651 70 97 52</span>
          </div>

          <!-- <div class="flex items-center gap-2 mb-2">
            <FontAwesomeIcon :icon="['fas', 'globe']" />
            <a href="https://walcom.com" target="_blank" class="underline text-[var(--dark-gold)] dark:text-[var(--dark-accent)] hover:text-[var(--text-secondary)]
">https://walcom.com</a>
          </div> -->

          <div class="flex items-center gap-2">
            <FontAwesomeIcon :icon="['fas', 'envelope']" />
            <a href="mailto:walnertech@gmail.com" class="underline text-[var(--dark-gold)] dark:text-[var(--dark-accent)] hover:text-[var(--text-secondary)]
">walnertech@gmail.com</a>
          </div>
        </div>

        <!-- Ressources -->
        <div>
          <h3 class="font-bold text-lg md:text-xl mb-2">Ressources</h3>
          <div class="mb-2">
            <Link href="/legales" class="hover:text-[var(--dark-gold)] dark:hover:text-[var(--dark-accent)]">Mentions
            Légales</Link>
          </div>
          <div class="mb-2">
            <Link href="/confidentialite"
              class="hover:text-[var(--dark-gold)]  transition dark:hover:text-[var(--dark-accent)]">
            Politique de confidentialité</Link>
          </div>
          <div class="mb-2">
            <Link href="/cgu" class="hover:text-[var(--dark-gold)] dark:hover:text-[var(--dark-accent)]">Conditions
            générales d'utilisation</Link>
          </div>
          <div class="mb-2">
            <Link href="/refundpolicy" class="hover:text-[var(--dark-gold)] dark:hover:text-[var(--dark-accent)]">
            Politique de Non-Remboursement</Link>
          </div>
        </div>

        <!-- FAQ -->
        <div>
          <h3 class="font-bold text-lg md:text-xl">F.A.Q</h3>
          <div class="faq space-y-4">
            <div v-for="(item, index) in faqs" :key="index" class="border-b border-gray-300 dark:border-gray-600 pb-2">
              <button @click="toggle(index)" class="w-full flex justify-between items-center text-left">
                <span class="font-semibold">{{ item.question }}</span>
                <span>{{ openIndex === index ? '-' : '+' }}</span>
              </button>
              <p v-if="openIndex === index" class="mt-1 text-sm text-[var(--dark-gold)] dark:text-gray-300">{{
                item.answer }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Ligne de séparation -->
      <div class="border border-gray-300 dark:border-gray-600 mx-auto w-[90%] my-6"></div>

      <!-- Bas du footer -->
      <div class="flex justify-between flex-wrap items-center gap-4 px-4">
        <div class="text-center">
          <p class="text-xs md:text-sm">&copy; {{ currentYear }} Walner Tech. Tous droits réservés.</p>
          <p class="text-xs md:text-sm">Propulsé avec ❤️ par Aubin Boris Simo</p>
        </div>

        <!-- Réseaux sociaux -->
        <div>
          <!-- <h3 class="font-bold mb-2">Suivez-nous</h3> -->
          <div class="flex justify-center gap-6 text-2xl">
            <a target="_blank" href="https://www.facebook.com/walnertech"
              class="hover:text-[var(--dark-gold)] dark:hover:text-[var(--dark-accent)]">
              <FontAwesomeIcon :icon="['fab', 'facebook']" />
            </a>
            <a href="" class="hover:text-[var(--dark-gold)] dark:hover:text-[var(--dark-accent)]">
              <FontAwesomeIcon :icon="['fab', 'instagram']" />
            </a>
            <a href="" class="hover:text-[var(--dark-gold)] dark:hover:text-[var(--dark-accent)]">
              <FontAwesomeIcon :icon="['fab', 'twitter']" />
            </a>
            <a href="" class="hover:text-[var(--dark-gold)] dark:hover:text-[var(--dark-accent)]">
              <FontAwesomeIcon :icon="['fab', 'linkedin']" />
            </a>
          </div>
        </div>
      </div>
    </footer>
  </section>
</template>
