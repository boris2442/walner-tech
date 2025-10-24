<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import CartWidget from '@/components/frontend/panier/CartWidget.vue';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <CartWidget /> <!-- ✅ Panier global -->
        <slot />
    </AppLayout>
</template>
