<script setup>
defineProps({
    label: {
        type: String,
        default: "Enregistrer",
    },
    processing: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <button
     type="submit"
    
        class="flex items-center justify-center gap-2 bg-[var(--primary-blue)] text-[var(--dark-white)] px-4 py-2 rounded hover:opacity-90 transition disabled:opacity-50"
        :disabled="processing">
        <!-- Loader qui tourne -->
        <svg v-if="processing" class="animate-spin h-5 w-5 text-[var(--dark-white)] dark:text-black"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>

        <span>{{ processing ? "Chargement..." : label }}</span>
    </button>
</template>
