<!-- BackButton.vue -->
<script setup>
import { faArrowLeft } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { router } from '@inertiajs/vue3';

function goBack() {
    if (window.history.length > 1) {
        window.history.back();
    } else {
        router.visit('/'); // redirection si pas d’historique
    }
}
</script>

<template>
    <span>
        <button
            type="button"
            title="retour"
            aria-label="Bouton retour à la page précédente"
            @click="goBack"
            class="mb-4 flex items-center gap-2 text-blue-600 hover:text-blue-800 dark:text-[var(--dark-gold)] dark:hover:text-[var(--dark-button-back)]"
        >
            <FontAwesomeIcon :icon="faArrowLeft" size="lg" />
        </button>
    </span>
</template>
