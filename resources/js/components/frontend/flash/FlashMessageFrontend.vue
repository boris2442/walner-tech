<template>
  <transition name="fade-slide">
    <div
      v-if="visible"
      class="fixed top-6 right-6 z-[9999] shadow-xl rounded-xl px-5 py-4 flex items-start w-80 border-l-4 backdrop-blur-md"
      :class="typeClass"
    >
      <!-- Texte -->
      <div class="flex-1">
        <p class="text-sm font-medium text-gray-100 leading-relaxed">
          {{ message }}
          <br />
          <span v-if="link">
            <Link
              :href="link.href"
              class="underline text-gray-200 hover:text-white transition"
            >
              {{ link.text }}
            </Link>
          </span>
        </p>
      </div>

      <!-- Bouton fermeture -->
      <button
        @click="close"
        class="ml-3 text-gray-300 hover:text-white transition-transform hover:rotate-90 duration-300"
      >
        ✕
      </button>
    </div>
  </transition>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  message: { type: String, default: '' },
  link: { type: Object, default: null }, // { text: string, href: string }
  duration: { type: Number, default: 9000 },
  type: { type: String, default: 'info' } // 'success', 'error', 'info'
})

const visible = ref(false)

onMounted(() => {
  if (props.message) {
    visible.value = true
    setTimeout(() => (visible.value = false), props.duration)
  }
})

const close = () => (visible.value = false)

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
