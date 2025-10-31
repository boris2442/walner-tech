<template>
    <div class="relative">
        <!-- Icône de cloche -->
        <button type="button" title="Ouvrir les notifications" aria-label="Bouton ouvrir les notifications"
            @click="toggleDropdown" class="relative">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-gray-700 dark:text-white" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14V11a6 6 0 10-12 0v3c0 .386-.146.758-.405 1.059L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>

            <!-- Badge dynamique -->
            <span v-if="notifications.length > 0"
                class="absolute -top-1 right-0 bg-red-600 text-white text-xs font-bold rounded-full px-1.5 py-0.5">
                {{ notifications.length }}
            </span>
        </button>

        <!-- Dropdown notifications -->
        <div v-if="open"
            class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50">

            <div class="p-3 border-b border-gray-200 dark:border-gray-700 font-semibold text-gray-800 dark:text-white">
                Notifications
            </div>

            <ul class="max-h-80 overflow-y-auto ">
                <li v-for="(notification, index) in notifications" :key="index"
                    class="flex justify-between items-start p-3 hover:bg-gray-100 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-200">

                    <div>
                        <p class="font-medium">{{ notification.data.title || notification.data.message }}</p>
                        <p class="text-xs text-gray-500">{{ (notification.created_at) }}</p>
                    </div>

                    <!-- Croix pour supprimer -->
                    <button type="button" title="Supprimer la notification"
                        aria-label="Bouton supprimer la notification" @click="dismiss(index)"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-white">
                        ✕
                    </button>
                </li>

                <li v-if="notifications.length === 0" class="p-3 text-center text-gray-500 dark:text-gray-400">
                    Aucune notification pour le moment
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    notifications: {
        type: Array,
        default: () => [],
    },
})

const open = ref(false)
const toggleDropdown = () => (open.value = !open.value)

// Notifications locales réactives
const notifications = ref([])

// Met à jour la liste dès que les props changent (Inertia)
watch(
    () => props.notifications,
    (newVal) => {
        notifications.value = [...newVal]
    },
    { immediate: true }
)

// Supprime une notification du DOM et met à jour le badge
const dismiss = (index) => {
    notifications.value.splice(index, 1)
}

// Affichage "il y a X minutes / heures / jours"
const timeAgo = (dateString) => {
    const date = new Date(dateString)
    const diff = (Date.now() - date.getTime()) / 1000
    if (diff < 60) return "à l'instant"
    if (diff < 3600) return `${Math.floor(diff / 60)} min`
    if (diff < 86400) return `${Math.floor(diff / 3600)} h`
    return `${Math.floor(diff / 86400)} j`
}
</script>
