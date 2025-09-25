<script setup>
defineProps({
    label: String,                // Label du select
    id: String,                   // ID et name du select
    modelValue: [String, Number], // Valeur sélectionnée
    options: {                     // Tableau d’options : [{ value: 'val', text: 'Texte' }]
        type: Array,
        required: true
    },
    placeholder: { type: String, default: "Sélectionnez..." },
    error: String
});

const emit = defineEmits(["update:modelValue"]);
</script>
<template>
    <div class="mb-4">
        <label :for="id" class="block mb-1 font-medium text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">{{ label
        }}</label>
        <select :name="id" :value="modelValue" @change="$emit('update:modelValue', $event.target.value)"
            class="p-2 border border-gray-300 rounded w-full focus:outline-none focus:ring-2 focus:ring-[var(--primary-blue)] dark:bg-[#2A2A2A] dark:border-gray-600 dark:focus:ring-[var(--dark-gold)]">
            <option value="" disabled selected>{{ placeholder }}</option>
            <option v-for="(option, i) in options" :key="i" :value="option.value">{{ option.text }}</option>
        </select>
        <p v-if="error" class="text-red-500 text-sm mt-1">{{ error }}</p>
    </div>
</template>