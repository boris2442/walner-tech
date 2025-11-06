<template>
  <transition name="fade-slide">
    <div v-if="visible"
      class="fixed top-6 right-6 z-[9999] shadow-xl rounded-xl px-5 py-4 flex flex-col w-80 border-l-4 backdrop-blur-md overflow-hidden"
      :class="typeClass">
      <!-- Texte -->
      <div class="flex items-start justify-between gap-3">
        <p class="text-sm font-medium text-gray-100 leading-relaxed flex-1">
          {{ message }}
          <br />
          <span v-if="link">
            <Link :href="link.href" class="underline text-gray-200 hover:text-white transition">
            {{ link.text }}
            </Link>
          </span>
        </p>

        <!-- Bouton fermeture -->
        <button @click="close" class="text-gray-300 hover:text-white transition-transform hover:rotate-90 duration-300">
          ✕
        </button>
      </div>

      <!-- Barre de progression -->
      <div class="h-1 w-full bg-white/20 mt-3 rounded-full overflow-hidden">
        <div class="h-full bg-white/70 transition-[width] duration-[linear]" :style="{ width: progressWidth + '%' }">
        </div>
      </div>
    </div>
  </transition>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  message: { type: String, default: '' },
  link: { type: Object, default: null }, // { text: string, href: string }
  duration: { type: Number, default: 6000 },
  type: { type: String, default: 'info' } // 'success', 'error', 'info'
})

const visible = ref(false)
const progressWidth = ref(100)
let interval: ReturnType<typeof setInterval> | null = null

onMounted(() => {
  if (props.message) {
    visible.value = true

    const start = Date.now()
    const end = start + props.duration

    interval = setInterval(() => {
      const now = Date.now()
      const percent = ((end - now) / props.duration) * 100
      progressWidth.value = Math.max(percent, 0)
      if (percent <= 0) {
        close()
      }
    }, 30)
  }
})

const close = () => {
  visible.value = false
  if (interval) clearInterval(interval)
}

const typeClass = computed(() => {
  switch (props.type) {
    case 'success':
      return 'bg-green-600/90 border-green-400'
    case 'error':
      return 'bg-red-600/90 border-red-400'
    default:
      return 'bg-blue-600/90 border-blue-400'
  }
})
</script>

<style scoped>
/* Transition fluide (fade + slide) */
.fade-slide-enter-active,
.fade-slide-leave-active {
  transition: all 0.4s ease;
}

.fade-slide-enter-from {
  opacity: 0;
  transform: translateY(-15px) translateX(15px) scale(0.95);
}

.fade-slide-enter-to {
  opacity: 1;
  transform: translateY(0) translateX(0) scale(1);
}

.fade-slide-leave-from {
  opacity: 1;
  transform: translateY(0) translateX(0) scale(1);
}

.fade-slide-leave-to {
  opacity: 0;
  transform: translateY(-15px) translateX(15px) scale(0.95);
}
</style>
