<template>
    <div class="h-full p-4 flex flex-col">
        <h3 class="text-lg font-semibold mb-3">Évolution du nombre d’utilisateurs</h3>

        <div class="flex-1 min-h-[260px]">
            <canvas v-if="chartData.labels.length" ref="chartRef" class="w-full h-full"></canvas>
            <div v-else class="h-72 flex items-center justify-center text-gray-500 dark:text-gray-400">
                Aucune donnée disponible
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, watch, onMounted } from 'vue';
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    LineElement,
    PointElement,
    LineController,  // <-- ajouter
    CategoryScale,   // <-- ajouter
    LinearScale
} from 'chart.js';
import ChartDataLabels from 'chartjs-plugin-datalabels';

// Enregistrement
ChartJS.register(
    Title, Tooltip, Legend,
    LineElement, PointElement, LineController, CategoryScale, LinearScale,
    ChartDataLabels
);


// Props
const props = defineProps({
    data: { type: Array, required: true }, // attend [{date, count}, ...]
});

const chartRef = ref<HTMLCanvasElement | null>(null);
let chartInstance: ChartJS | null = null;

const chartData = ref({
    labels: [] as string[],
    datasets: [
        {
            label: 'Utilisateurs',
            data: [] as number[],
            borderColor: '#6997ee',
            backgroundColor: 'rgba(105, 151, 238, 0.2)',
            fill: true,
            tension: 0.3,
            pointRadius: 4,
            pointBackgroundColor: '#6997ee',
        },
    ],
});

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: { position: 'bottom', labels: { font: { size: 14 } } },
        tooltip: {
            callbacks: {
                label: (context: any) => `${context.parsed.y} utilisateurs`,
            },
        },
        datalabels: {
            display: false,
        },
    },
    scales: {
        x: { title: { display: true, text: 'Date' } },
        y: { title: { display: true, text: 'Nombre d’utilisateurs' }, beginAtZero: true },
    },
};

const renderChart = () => {
    if (!chartRef.value) return;

    if (chartInstance) {
        chartInstance.data = chartData.value;
        chartInstance.update();
    } else {
        chartInstance = new ChartJS(chartRef.value, {
            type: 'line',
            data: chartData.value,
            options: chartOptions,
            plugins: [ChartDataLabels],
        });
    }
};

watch(
    () => props.data,
    (val: Array<any>) => {
        if (!val.length) {
            chartData.value.labels = [];
            chartData.value.datasets[0].data = [];
            renderChart();
            return;
        }

        chartData.value.labels = val.map(d => d.date);
        chartData.value.datasets[0].data = val.map(d => Number(d.count));
        renderChart();
    },
    { immediate: true }
);

onMounted(() => renderChart());
</script>

<style scoped>
canvas {
    width: 100% !important;
    height: 100% !important;
}
</style>
