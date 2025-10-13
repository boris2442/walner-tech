
<template>
    <img src="/walner.jpg" :class="className" v-bind="$attrs" alt="Walner Logo" class="text-white" />
</template>

<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({ inheritAttrs: false });

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>
