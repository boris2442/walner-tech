<template>
    <transition name="fade">
        <div v-if="visible" class="fixed top-5 right-5 z-50000 shadow-lg rounded-lg p-4 flex items-start w-80 bg-blue-800"
            :class="typeClass">
            <div class="flex-1">
                <p class=" dark:text-gray-100 font-medium text-gray-300">
                    {{ message }}
                    <span v-if="link">
                        <Link :href="link.href" class="underline text-white hover:text-[#f4f4f4]">
                        {{ link.text }}
                        </Link>
                    </span>
                </p>
            </div>
            <button @click="close" class="ml-3 text-red-500 hover:text-red-700 transition">
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
    duration: { type: Number, default: 10000 },
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
        case 'success': return 'bg-green-50 dark:bg-green-800 border-l-4 border-green-500'
        case 'error': return 'bg-red-50 dark:bg-red-800 border-l-4 border-red-500'
        default: return 'bg-blue-50 dark:bg-gray-800 border-l-4 border-blue-500'
    }
})
</script>
