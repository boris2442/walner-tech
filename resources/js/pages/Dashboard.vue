<script setup lang="ts">
import BackButton from '@/components/frontend/BackButton.vue';
import FlashMessageFrontend from '@/components/frontend/flash/FlashMessageFrontend.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

// const pageProps = usePage<{
//     totalOrders: number;
//     totalProducts: number;
//     totalSpent: number;
//     lastOrder: any;
//     ordersByMonth: Array;
// }>().props;

// 🟢 1. Déclaration des props venant du backend
const pageProps = defineProps({
    totalOrders: Number,
    totalProducts: Number,
    totalSpent: Number,
    lastOrder: Object,
    ordersByMonth: Array,
    orders: Array,
});

const totalOrders = pageProps.totalOrders || 0;
const totalProducts = pageProps.totalProducts || 0;
const totalSpent = pageProps.totalSpent || 0;
const lastOrder = pageProps.lastOrder || null;

// Préparation du graphique
import { BarElement, CategoryScale, Chart as ChartJS, Legend, LinearScale, Title, Tooltip } from 'chart.js';

import { Bar } from 'vue-chartjs';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

const chartData = ref({
    labels: pageProps.ordersByMonth.map((o) => `Mois ${o.month}`),
    datasets: [
        {
            label: 'Commandes par mois',
            data: pageProps.ordersByMonth.map((o) => o.total),
        },
    ],
});

const chartOptions = ref({
    responsive: true,
    maintainAspectRatio: false,
});
</script>

<template>
    <Head title="Dashboard" />
    <!-- <Head title="Dashboard" /> -->

    <AppLayout :breadcrumbs="breadcrumbs">
        <FlashMessageFrontend v-if="$page.props.flash?.message" :message="$page.props.flash.message" :link="$page.props.flash.link" />

        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <BackButton class="m-4" />

            <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4">
                <div class="kpi-card">
                    <div class="kpi-icon">🆕</div>
                    <div class="kpi-text">
                        <h3 class="text-2xl">Total commandes</h3>
                        <p>{{ totalOrders }}</p>
                    </div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-icon">🆕</div>
                    <div class="kpi-text">
                        <h3 class="text-2xl">Produits commandés</h3>
                        <p>{{ totalProducts }}</p>
                    </div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-icon">🆕</div>
                    <div class="kpi-text">
                        <h3 class="text-2xl">Montant dépensé (estimation)</h3>
                        <p>{{ totalSpent }} F</p>
                    </div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-icon">🆕</div>
                    <div class="kpi-text">
                        <h3 class="text-2xl">Dernière commande</h3>
                        <!-- <p class="text-xs">
                            <i>
                                {{
                                    lastOrder
                                        ? `${lastOrder.quantity} produits le ${new Date(lastOrder.created_at).toLocaleDateString()}`
                                        : 'Aucune commande'
                                }}
                            </i>
                        </p> -->

                        <p class="text-xs">
                            <i>
                                <template v-if="lastOrder">
                                    <span class="text-xs">
                                        {{ lastOrder.quantity }} produits le
                                        {{ new Date(lastOrder.created_at).toLocaleDateString() }}
                                    </span>
                                </template>
                                <template v-else> Aucune commande </template>
                            </i>
                        </p>
                    </div>
                </div>
            </div>

            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <!-- <PlaceholderPattern /> -->

                <!-- GRAPH -->
                <div class="h-72 rounded-xl bg-white p-6 shadow-lg dark:bg-[#090909]">
                    <h2 class="mb-3 text-xl font-bold">Activité des commandes</h2>

                    <Bar :data="chartData" :options="chartOptions" class="dark:bg-[#1e1e1e]"/>
                </div>

                <!-- LAST ORDERS -->
                <div class="rounded-xl bg-white p-6 shadow-lg dark:bg-[#090909]">
                    <h2 class="mb-4 text-xl font-bold">Dernières commandes</h2>

                    <table class="w-full text-left text-sm">
                        <thead class="border-b text-gray-500">
                            <tr>
                                <th class="pb-2">Produit</th>
                                <th class="pb-2">Quantité</th>
                                <th class="pb-2">Prix</th>
                                <th class="pb-2">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="order in orders" :key="order.id" class="border-b hover:bg-gray-100 dark:hover:bg-gray-700 text-sm" >
                                <td class="py-2">{{ order.product?.title ?? 'Produit inconnu' }}</td>
                                <td>{{ order.quantity }}</td>
                                <td class="font-semibold text-green-600">{{ order.prix }} FCFA</td>
                                <td>{{ new Date(order.created_at).toLocaleDateString() }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- No orders -->
                    <p v-if="orders.length === 0" class="text-sm text-gray-400 italic">Aucune commande pour le moment.</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
