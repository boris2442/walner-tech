<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import CategoryPieChart from '@/components/charts/CategoryPieChart.vue';
import MessagesSparkline from '@/components/charts/MessagesSparkline.vue';
import UsersLineChart from '@/components/charts/UsersLineChart.vue';
import { computed } from 'vue';
import OrdersByProductChart from '@/components/charts/OrdersByProductChart.vue';

// Props Inertia
const page = usePage();
const productsByCategory = computed(() => page.props.products_by_category || []);

//utilisateurs au fil du temps
const usersOverTime = computed(() => page.props.users_over_time || []);

// Messages sur les 7 derniers jours
const last7Days = computed(() => page.props.last7Days || []);
const totalMessages = computed(() => page.props.total_messages || 0);




// Données pour le graphique des commandes par produit
const ordersClicksData = computed(() => page.props.orders_by_product || []);



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
                    style="min-height: 320px;
                    /* max-width: 400px; */
                    /* max-height: 400px; */
                    ">
                    <CategoryPieChart :data="productsByCategory" />
                </div>
                <!-- Graphique répartition catégories -->
                <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-white dark:bg-[var(--dark-background)]"
                    style="min-height: 320px;
                    /* max-width: 400px; */
                    max-height: 400px;
                    ">
                    <UsersLineChart :data="usersOverTime" />

                </div>
                <!-- Graphique répartition catégories -->
                <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-white dark:bg-[var(--dark-background)]"
                    style="min-height: 320px;
                    /* max-width: 400px; */
                    max-height: 400px;
                    ">
                    <MessagesSparkline :data="last7Days" :totalMessages="totalMessages" />



                </div>


                <!-- Placeholders pour futurs graph -->
                <!-- <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <p class="text-center p-4 text-gray-500">Graphique à venir</p>
                </div> -->
                <!-- <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <p class="text-center p-4 text-gray-500">Graphique à venir</p>
                </div> -->
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

                <!-- Produits les plus commandés -->
                <div
                    class="relative rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-white dark:bg-[var(--dark-background)]">
                    <div class="w-full aspect-video">
                        <OrdersByProductChart :data="ordersClicksData" />
                    </div>
                </div>

                <!-- Graphique répartition catégories -->
                <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-white dark:bg-[var(--dark-background)]"
                    style="min-height: 320px;
                    /* max-width: 400px; */
                    max-height: 400px;
                    ">


                </div>
                <!-- Graphique répartition catégories -->
                <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-white dark:bg-[var(--dark-background)]"
                    style="min-height: 320px;
                    /* max-width: 400px; */
                    max-height: 400px;
                    ">




                </div>


                <!-- Placeholders pour futurs graph -->
                <!-- <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <p class="text-center p-4 text-gray-500">Graphique à venir</p>
                </div> -->
                <!-- <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <p class="text-center p-4 text-gray-500">Graphique à venir</p>
                </div> -->
            </div>

            <div
                class="relative min-h-[40vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <p class="text-center p-4 text-gray-500">Zone d'activité / autres graphiques</p>
            </div>
        </div>
    </AppLayout>
</template>
