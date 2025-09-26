<template>
  <div
    class="flex flex-col items-center justify-center min-h-screen text-center p-4"
    style="background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue))">

    <!-- Gros 404 responsive -->
    <h1 class="font-bold text-white relative animate-glow text-[15vw] md:text-[10rem] leading-none">
      404
    </h1>

    <!-- Message clair -->
    <p class="text-[4vw] md:text-xl text-white mt-4 mb-6">
      Oups… La page que vous cherchez n’existe pas !
    </p>

    <!-- Illustration simple (SVG) -->
    <div class="mb-6 w-1/4 md:w-40 h-auto">
      <svg viewBox="0 0 64 64" class="w-full h-full animate-bounce-slow">
        <circle cx="32" cy="32" r="30" fill="rgba(255,255,255,0.1)" />
        <circle cx="32" cy="32" r="15" fill="rgba(255,255,255,0.2)" />
      </svg>
    </div>

    <!-- Bouton unique vers l'accueil -->
    <Link href="/" 
      class="px-6 py-3 bg-var(--highlight-gold) text-var(--text-dark) font-semibold rounded shadow-lg hover:brightness-110 transition">
      Accueil
    </Link>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<style scoped>
/* Animation glow pour le 404 */
@keyframes glow {
  0%, 100% { text-shadow: 0 0 8px #fff, 0 0 16px var(--dark-gold); }
  50% { text-shadow: 0 0 16px #fff, 0 0 32px var(--dark-gold); }
}
.animate-glow {
  animation: glow 2s infinite alternate;
}

/* Animation bounce lente pour le SVG */
@keyframes bounce-slow {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-15px); }
}
.animate-bounce-slow {
  animation: bounce-slow 3s infinite ease-in-out;
}

/* Assurer le texte reste lisible sur mobile */
@media (max-width: 640px) {
  h1 { text-align: center; }
  p { text-align: center; }
}
</style>
