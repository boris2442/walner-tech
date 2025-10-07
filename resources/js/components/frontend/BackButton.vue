<!-- BackButton.vue -->
<script setup>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faArrowLeft } from '@fortawesome/free-solid-svg-icons'
import { router } from '@inertiajs/vue3'

function goBack() {
    if (window.history.length > 1) {
        window.history.back()
    } else {
        router.visit('/') // redirection si pas d’historique
    }
}
</script>

<template>
    <button @click="goBack"
        class="text-blue-600 hover:text-blue-800 dark:text-[var(--dark-gold)] dark:hover:text-[var(--highlight-gold)] flex items-center gap-2 mb-4">
        <FontAwesomeIcon :icon="faArrowLeft" size="lg" />
    </button>
</template>
