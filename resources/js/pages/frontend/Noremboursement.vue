<script setup>
import Footer from '@/components/frontend/Footer.vue';
import NavbarFrontend from '@/components/frontend/NavbarFrontend.vue';
import FloatingAction from '@/components/frontend/FloatingAction.vue';
import BackButton from '@/components/frontend/BackButton.vue';
</script>
<template>
  <NavbarFrontend />
    <FloatingAction/>
  <section>

    <div
      class="px-6 pt-24
md:px-20 md:pt-32 antialiased bg-[var(--secondary-white)] text-[var(--text-dark)] dark:bg-[var(--dark-background)] dark:text-[var(--dark-white)]">
      <!-- 🔹 Bouton retour -->
      <BackButton />
      <!-- Titre principal -->
      <h1 class="text-3xl font-bold text-[var(--primary-blue)] dark:text-[var(--dark-gold)] mb-6">
        Politique de Non-Remboursement
      </h1>

      <!-- Introduction -->
      <p class="mb-6 text-lg text-[var(--text-secondary)] dark:text-[var(--dark-grey)]">
        Chez <strong>Walner Tech</strong>, nous accordons une grande importance à la satisfaction de nos clients.
        Cependant, afin de garantir la qualité et la transparence de nos services, nous appliquons une politique stricte
        de non-remboursement.
      </p>

      <!-- div 1 -->
      <div class="mb-8">
        <h2 class="text-2xl font-semibold text-[var(--primary-blue)] dark:text-[var(--dark-gold)] mb-3">
          1. Aucun remboursement après paiement
        </h2>
        <p>
          Une fois le paiement effectué et validé, <strong>aucun remboursement ne sera possible</strong>,
          quel que soit le mode de paiement utilisé (Orange Money, PayPal, carte bancaire, etc.).
        </p>
      </div>

      <!-- div 2 -->
      <div class="mb-8">
        <h2 class="text-2xl font-semibold text-[var(--primary-blue)] dark:text-[var(--dark-gold)] mb-3">
          2. Cas d’exception
        </h2>
        <p>
          Des exceptions peuvent être accordées uniquement en cas de :
        </p>
        <ul class="list-disc list-inside mt-3 space-y-2">
          <li>Erreur de facturation imputable à Walner Tech.</li>
          <li>Produit non conforme à la description fournie sur le site.</li>
        </ul>
        <p class="mt-3">
          Dans ces cas exceptionnels, une solution appropriée (avoir, remplacement ou remboursement partiel) pourra être
          envisagée
          après étude de la demande par notre service client.
        </p>
      </div>

      <!-- div 3 -->
      <div class="mb-8">
        <h2 class="text-2xl font-semibold text-[var(--primary-blue)] dark:text-[var(--dark-gold)] mb-3">
          3. Contact
        </h2>
        <p>
          Pour toute réclamation, veuillez nous écrire à
          <a href="mailto:support@walnertech.com"
            class="text-[var(--accent-cyan)] hover:underline">support@walnertech.com</a>.
        </p>
      </div>


    </div>
  </section>
  <Footer />
</template>
