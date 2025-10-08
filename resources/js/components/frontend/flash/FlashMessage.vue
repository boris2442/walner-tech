<template>
  <transition enter-active-class="transform transition duration-500" enter-from-class="-translate-x-full opacity-0"
    enter-to-class="translate-x-0 opacity-100" leave-active-class="transform transition duration-500"
    leave-from-class="translate-x-0 opacity-100" leave-to-class="-translate-x-full opacity-0">
    <div v-if="visible" :class="[
      'fixed top-4 left-4 px-4 py-3 rounded shadow-lg flex items-center justify-between w-96',
      type === 'success' ? 'bg-green-100 text-green-800' : '',
      type === 'error' ? 'bg-red-100 text-red-800' : '',
      type === 'warning' ? 'bg-yellow-100 text-yellow-800' : '',
      type === 'info' ? 'bg-blue-100 text-blue-800' : ''
    ]">
      <span class="font-medium">{{ message }}</span>
      <button @click="close" class="ml-4 font-bold">✖</button>
    </div>
  </transition>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const props = defineProps({
  message: { type: String, required: true },
  type: { type: String, default: 'success' }, // success, error, warning, info
  duration: { type: Number, default: 4000 } // auto-hide après 4s
})

const visible = ref(true)

const close = () => {
  visible.value = false
}

onMounted(() => {
  if (props.duration > 0) {
    setTimeout(close, props.duration)
  }
})
</script>
