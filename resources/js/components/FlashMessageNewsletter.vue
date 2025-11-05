<template>
    <transition name="slide-fade">
        <div v-if="visible && message"
            class="fixed top-6 right-6 w-80 bg-white/10 backdrop-blur-lg border border-white/20 text-white shadow-2xl rounded-xl overflow-hidden z-[9999] flex items-start justify-between">
            <div class="p-4 flex-1">
                <p class="font-medium">{{ message }}</p>
            </div>

            <!-- Bouton fermer -->
            <button @click="close" class="text-white/70 hover:text-white transition p-3">
                ✕
            </button>

            <!-- Barre de progression -->
            <div class="absolute bottom-0 left-0 h-[3px]" :class="type === 'success' ? 'bg-green-400' : 'bg-red-400'"
                :style="{ width: progressWidth + '%' }"></div>
        </div>
    </transition>
</template>

<script setup>
import { computed, ref, watch, onMounted } from 'vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()

const message = computed(() => page.props.flash?.message)
const type = computed(() => page.props.flash?.type || 'success')

const visible = ref(false)
const progressWidth = ref(100)

let timer = null
let interval = null

const duration = 4000 // durée totale en ms

const startTimer = () => {
    clearInterval(interval)
    progressWidth.value = 100

    let step = 100 / (duration / 50)
    interval = setInterval(() => {
        progressWidth.value -= step
        if (progressWidth.value <= 0) {
            clearInterval(interval)
            visible.value = false
        }
    }, 50)
}

watch(message, (newValue) => {
    if (newValue) {
        visible.value = true
        startTimer()
        clearTimeout(timer)
        timer = setTimeout(() => (visible.value = false), duration)
    }
})

const close = () => {
    visible.value = false
    clearInterval(interval)
    clearTimeout(timer)
}
</script>

<style scoped>
/* Animation d’apparition dynamique */
.slide-fade-enter-active {
    transition: all 0.5s cubic-bezier(0.25, 1, 0.5, 1);
}

.slide-fade-leave-active {
    transition: all 0.4s ease-in;
}

.slide-fade-enter-from {
    opacity: 0;
    transform: translateX(100%) scale(0.95);
}

.slide-fade-enter-to {
    opacity: 1;
    transform: translateX(0) scale(1);
}

.slide-fade-leave-from {
    opacity: 1;
    transform: translateX(0) scale(1);
}

.slide-fade-leave-to {
    opacity: 0;
    transform: translateX(120%) scale(0.9);
}
</style>
