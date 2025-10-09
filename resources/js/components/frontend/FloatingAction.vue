<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faArrowUp } from '@fortawesome/free-solid-svg-icons';

// Etat pour afficher/masquer les boutons
const showButtons = ref(false);

// Fonction pour remonter en haut
function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Détecter le scroll
function handleScroll() {
    showButtons.value = window.scrollY > 300;
}

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});
</script>

<template>
    <transition name="fade">
        <div v-if="showButtons" class="fixed bottom-6 w-full flex justify-between px-6 z-50 pointer-events-none">
            <!-- WhatsApp à gauche -->
            <a href="https://wa.me/656894773" target="_blank"
                class="pointer-events-auto bg-[var(--flash)] hover:bg-green-600 text-white p-4 rounded-full shadow-lg transition transform hover:scale-110"
                title="Contactez-nous sur WhatsApp">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M20.52 3.48A11.88 11.88 0 0012 0C5.37 0 0 5.37 0 12a11.88 11.88 0 001.64 6.11L0 24l5.92-1.64A11.88 11.88 0 0012 24c6.63 0 12-5.37 12-12a11.88 11.88 0 00-3.48-8.52zM12 22c-5.52 0-10-4.48-10-10S6.48 2 12 2s10 4.48 10 10-4.48 10-10 10z" />
                    <path
                        d="M17.25 14.1c-.25-.12-1.49-.73-1.72-.81s-.4-.12-.57.12-.65.81-.8.98-.29.18-.54.06c-.25-.12-1.06-.39-2.02-1.25-.75-.66-1.26-1.48-1.41-1.73s-.02-.41.11-.53c.12-.12.25-.29.37-.44.12-.15.16-.25.25-.41.08-.16.04-.3-.02-.41-.06-.12-.57-1.37-.78-1.87-.21-.5-.43-.43-.57-.44-.15-.01-.32-.01-.49-.01s-.41.06-.63.3c-.21.25-.81.79-.81 1.92s.83 2.22.95 2.37c.12.15 1.64 2.52 3.97 3.53.55.24.98.38 1.31.49.55.18 1.05.16 1.44.1.44-.07 1.49-.61 1.7-1.2.21-.59.21-1.09.15-1.2-.06-.12-.21-.18-.46-.3z" />
                </svg>
            </a>

            <!-- Back to top à droite -->
            <button @click="scrollToTop"
                class="pointer-events-auto bg-[var(--primary-blue)] hover:bg-[var(--highlight-gold)] text-white p-4 rounded-full shadow-lg transition transform hover:scale-110"
                title="Remonter en haut">
                <FontAwesomeIcon :icon="faArrowUp" class="h-6 w-6" />
            </button>
        </div>
    </transition>
</template>

<style scoped>
/* Transition fade */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
