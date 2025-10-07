<template>
    <div
        class="p-4 bg-white dark:bg-[var(--dark-background)] rounded-xl shadow-md border border-sidebar-border/70 flex flex-col">
        <h3 class="text-lg font-semibold mb-3 text-gray-800 dark:text-gray-200 text-center">
            Produits les plus commandés
        </h3>

        <!-- Message si aucune donnée -->
        <div v-if="!data.length" class="flex-1 flex items-center justify-center text-gray-400 text-sm">
            Aucune donnée à afficher pour le moment.
        </div>

        <!-- Graphique -->
        <div v-else class="flex-1 relative min-h-[260px]">
            <canvas ref="chartCanvas" class="absolute inset-0 w-full h-full"></canvas>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref, watch, onBeforeUnmount } from 'vue';
import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

const props = defineProps({
    data: {
        type: Array,
        default: () => [],
    },
});

const chartCanvas = ref(null);
let chartInstance = null;

// Fonction pour (re)dessiner le graphique
function renderChart() {
    if (!chartCanvas.value || !props.data.length) return;

    // Détruire l'ancien graphique avant d'en créer un nouveau (évite les doublons)
    if (chartInstance) {
        chartInstance.destroy();
    }

    chartInstance = new Chart(chartCanvas.value, {
        type: 'bar',
        data: {
            labels: props.data.map((p) => p.name),
            datasets: [
                {
                    label: 'Clics sur "Commander"',
                    data: props.data.map((p) => p.count),
                    backgroundColor: 'rgba(59, 130, 246, 0.7)', // bleu clair
                    borderColor: 'rgba(37, 99, 235, 1)', // bleu foncé
                    borderWidth: 1,
                    borderRadius: 8,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 },
                },
            },
            scales: {
                x: {
                    ticks: {
                        color: '#6B7280',
                        font: { size: 12 },
                        maxRotation: 40,
                        minRotation: 20,
                    },
                    grid: { display: false },
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#6B7280',
                        font: { size: 12 },
                        stepSize: 1,
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.05)',
                    },
                },
            },
        },
    });
}

// Charger le graphique
onMounted(() => renderChart());

// Mettre à jour automatiquement quand les données changent
watch(
    () => props.data,
    () => {
        renderChart();
    },
    { deep: true }
);

// Nettoyer avant de détruire le composant
onBeforeUnmount(() => {
    if (chartInstance) chartInstance.destroy();
});
</script>
