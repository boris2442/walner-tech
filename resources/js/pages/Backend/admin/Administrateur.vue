<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import CategoryPieChart from '@/components/charts/CategoryPieChart.vue';
import { computed } from 'vue';

// Props Inertia
const page = usePage();
const productsByCategory = computed(() => page.props.products_by_category || []);
console.log(productsByCategory.value);


console.log(productsByCategory.value); // Vérifie les données

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard Administrateur', href: dashboard().url },
];
</script>

<template>

    <Head title="Dashboard Administrateur" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">

            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

                <!-- Graphique répartition catégories -->
                <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-white dark:bg-[var(--dark-background)]"
                    style="min-height: 320px;">
                    <CategoryPieChart :data="productsByCategory" />
                </div>


                <!-- Placeholders pour futurs graph -->
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <p class="text-center p-4 text-gray-500">Graphique à venir</p>
                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <p class="text-center p-4 text-gray-500">Graphique à venir</p>
                </div>
            </div>

            <div
                class="relative min-h-[40vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <p class="text-center p-4 text-gray-500">Zone d'activité / autres graphiques</p>
            </div>
        </div>
    </AppLayout>
</template>
