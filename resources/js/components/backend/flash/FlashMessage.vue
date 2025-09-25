<script setup>
import { ref, watch, onMounted } from "vue";

// Définition des props
const props = defineProps({
    message: String,
    type: { type: String, default: "success" },
    duration: { type: Number, default: 4000 },
});

const visible = ref(false);

// Fonction pour cacher le flash
const hide = () => {
    visible.value = false;
};

// Affichage automatique du flash au montage
onMounted(() => {
    if (props.message) {
        visible.value = true;
        setTimeout(hide, props.duration);
    }
});

// Réagir aux changements de message
watch(
    () => props.message,
    (newVal) => {
        if (newVal) {
            visible.value = true;
            setTimeout(hide, props.duration);
        }
    }
);
</script>

<template>
    <transition name="slide-left" appear>
        <div v-if="visible && props.message" :class="[
            'fixed top-4 left-4 z-50 flex items-center justify-between max-w-sm w-full p-4 rounded shadow-lg text-white',
            props.type === 'success'
                ? 'bg-[var(--success-green)]'
                : props.type === 'error'
                    ? 'bg-[var(--error-red)]'
                    : 'bg-[var(--accent-cyan)]'
        ]">
            <span>{{ props.message }}</span>
            <button @click="hide" class="ml-4 hover:opacity-75 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </transition>
</template>

<style scoped>
.slide-left-enter-active,
.slide-left-leave-active {
    transition: all 0.5s ease;
}

.slide-left-enter-from {
    transform: translateX(-100%);
    opacity: 0;
}

.slide-left-enter-to {
    transform: translateX(0);
    opacity: 1;
}

.slide-left-leave-from {
    transform: translateX(0);
    opacity: 1;
}

.slide-left-leave-to {
    transform: translateX(-100%);
    opacity: 0;
}
</style>
