<!-- <script setup>
defineProps({
    label: String,
    required: Boolean,
    id: String,
    modelValue: [String, Number],
    type: { type: String, default: 'text' },
    placeholder: String,
    error: String,
});
const emit = defineEmits(['update:modelValue']);
</script>
<template>
    <div class="mb-4">
        <label :for="id" class="mb-1 block font-medium text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">{{ label }}</label>
        <input
            :id="id"
            :required="true"
            :name="id"
            :type="type"
            :placeholder="placeholder"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            class="w-full rounded border border-gray-300 p-2 focus:ring-2 focus:ring-[var(--primary-blue)] focus:outline-none dark:border-gray-600 dark:bg-[#2A2A2A] dark:focus:ring-[var(--dark-gold)]"
        />
        <p v-if="error" class="mt-1 text-sm text-red-500">{{ error }}</p>
    </div>
</template> -->

<!-- <script setup>
defineProps({
    label: String,
    required: Boolean,
    id: String,
    modelValue: [String, Number], // ← accepte string ET number
    type: { type: String, default: 'text' },
    placeholder: String,
    error: String,
});

const emit = defineEmits(['update:modelValue']);

// Émettre la valeur avec bon type
const handleInput = (event) => {
    const value = event.target.value;
    if (props.type === 'number') {
        // Convertir en nombre, ou null si vide
        emit('update:modelValue', value === '' ? null : parseFloat(value));
    } else {
        emit('update:modelValue', value);
    }
};
</script>

<template>
    <div class="mb-4">
        <label :for="id" class="mb-1 block font-medium text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">
            {{ label }}
            <span v-if="required" class="text-red-500">*</span>
        </label>
        <input
            :id="id"
            :name="id"
            :type="type"
            :placeholder="placeholder"
            :value="modelValue == null ? '' : modelValue"
            @input="handleInput"
            :class="{
                'border-red-500': error,
                'focus:ring-2 focus:ring-[var(--primary-blue)] dark:focus:ring-[var(--dark-gold)]': !error,
            }"
            class="w-full rounded border border-gray-300 p-2 focus:outline-none dark:border-gray-600 dark:bg-[#2A2A2A]"
        />
        <p v-if="error" class="mt-1 text-sm text-red-500">{{ error }}</p>
    </div>
</template> -->

<script setup>
const props = defineProps({
    label: String,
    required: Boolean,
    id: String,
    modelValue: [String, Number],
    type: { type: String, default: 'text' },
    placeholder: String,
    error: String,
});

const emit = defineEmits(['update:modelValue']);

const handleInput = (event) => {
    const value = event.target.value;

    if (props.type === 'number') {
        emit('update:modelValue', value === '' ? null : parseFloat(value));
    } else {
        emit('update:modelValue', value);
    }
};
</script>

<template>
    <div class="mb-4">
        <label :for="props.id" class="mb-1 block font-medium text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">
            {{ props.label }}
            <span v-if="props.required" class="text-red-500">*</span>
        </label>

        <input
            :id="props.id"
            :name="props.id"
            :type="props.type"
            :placeholder="props.placeholder"
            :value="props.modelValue == null ? '' : props.modelValue"
            @input="handleInput"
            :class="{
                'border-red-500': props.error,
                'focus:ring-2 focus:ring-[var(--primary-blue)] dark:focus:ring-[var(--dark-gold)]': !props.error,
            }"
            class="w-full rounded border border-gray-300 p-2 focus:outline-none dark:border-gray-600 dark:bg-[#2A2A2A]"
        />

        <p v-if="props.error" class="mt-1 text-sm text-red-500">{{ props.error }}</p>
    </div>
</template>
