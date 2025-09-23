<template>
  <div class="relative w-full h-full">
    <!-- Skeleton loader -->
    <div v-if="!loaded" class="animate-pulse bg-gray-300 dark:bg-gray-700 w-full h-full rounded-xl"></div>

    <!-- Image -->
    <img
      :src="src"
      :alt="alt"
      @load="onLoad"
      class="absolute top-0 left-0 w-full h-full object-cover rounded-xl"
      :class="{ 'opacity-0': !loaded, 'opacity-100 transition-opacity duration-500': loaded }"
    />
  </div>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
  src: { type: String, required: true },
  alt: { type: String, default: '' },
})

const loaded = ref(false)

function onLoad() {
  loaded.value = true
}
</script>
