<script setup>
defineProps({
    label: String,
    id: String,
    modelValue: [String, Number],
    type: { type: String, default: "text" },
    placeholder: String,
    error: String
});
const emit = defineEmits(["update:modelValue"]);
</script>
<template>
    <div class="mb-4">
        <label :for="id" class="block mb-1 font-medium text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">{{ label
            }}</label>
        <input
        :id="id"
        :name="id"
        :type="type" :placeholder="placeholder" :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            class="p-2 border border-gray-300 rounded w-full focus:outline-none focus:ring-2 focus:ring-[var(--primary-blue)] dark:bg-[#2A2A2A] dark:border-gray-600 dark:focus:ring-[var(--dark-gold)]" />
        <p v-if="error" class="text-red-500 text-sm mt-1">{{ error }}</p>
    </div>
</template>