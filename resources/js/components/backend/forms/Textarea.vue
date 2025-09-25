<script setup>
defineProps({
    label: String,
    modelValue: String,
    placeholder: String,
    rows: { type: Number, default: 4 },
    error: String
});
const emit = defineEmits(["update:modelValue"]);
</script>
<template>
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ label }}</label>
        <textarea :placeholder="placeholder" :rows="rows" :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            class="p-2 border border-gray-300 rounded w-full focus:outline-none focus:ring-2 focus:ring-[var(--primary-blue)] dark:bg-[#2A2A2A] dark:border-gray-600 dark:focus:ring-[var(--dark-gold)]"></textarea>
        <p v-if="error" class="text-red-500 text-sm mt-1">{{ error }}</p>
    </div>
</template>