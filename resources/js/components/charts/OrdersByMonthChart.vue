<template>
    <div class="p-4  dark:bg-dark-background rounded-xl shadow">
        <h3 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-200">
            Évolution des clics sur "Commander" par mois
        </h3>

        <div class="h-72">
            <canvas ref="chartCanvas"></canvas>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref, watch } from 'vue'
import { Chart, registerables } from 'chart.js'
Chart.register(...registerables)

const props = defineProps({
    data: {
        type: Array,
        default: () => [],
    },
})

const chartCanvas = ref(null)
let chartInstance = null

// Fonction pour créer le graphique
function renderChart() {
    if (!chartCanvas.value) return

    // Détruire l'ancien graphique avant de recréer (évite doublons)
    if (chartInstance) {
        chartInstance.destroy()
    }

    chartInstance = new Chart(chartCanvas.value, {
        type: 'bar',
        data: {
            labels: props.data.map((item) => item.month),
            datasets: [
                {
                    label: 'Nombre de clics sur "Commander"',
                    data: props.data.map((item) => item.count),
                    backgroundColor: 'rgba(59, 130, 246, 0.7)', // bleu clair
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1.5,
                    borderRadius: 6,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: (context) => `${context.parsed.y} clic(s)`,
                    },
                },
            },
            scales: {
                x: {
                    ticks: { color: '#6b7280', maxRotation: 0, minRotation: 0 },
                    grid: { display: false },
                },
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, color: '#6b7280' },
                    grid: { color: 'rgba(0,0,0,0.05)' },
                },
            },
        },
    })
}

// Crée le graphique au montage
onMounted(renderChart)

// Regénère le graphique si les données changent
watch(
    () => props.data,
    () => {
        renderChart()
    },
    { deep: true }
)
</script>

<style scoped>
canvas {
    width: 100%;
    height: 100%;
}
</style>
