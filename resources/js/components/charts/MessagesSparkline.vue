<template>
  <div
    class="p-4 bg-white dark:bg-[var(--dark-background)] rounded-xl border border-sidebar-border/70 flex flex-col items-center gap-2"
    style="min-height: 160px;"
  >
    <!-- Titre -->
    <div class="text-center mb-2">
      <p class="text-gray-500 dark:text-gray-400 text-sm">Messages reçus (7 derniers jours)</p>
      <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ totalMessages }}</h3>
    </div>

    <!-- Graphique -->
    <div class="w-full h-32 md:h-36">
      <canvas ref="chartRef"></canvas>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted, watch } from 'vue';
import {
  Chart as ChartJS,
  LineController,
  LineElement,
  PointElement,
  LinearScale,
  CategoryScale,
  Tooltip,
  Filler
} from 'chart.js';

// Enregistrement des composants Chart.js
ChartJS.register(LineController, LineElement, PointElement, LinearScale, CategoryScale, Tooltip, Filler);

const props = defineProps({
  data: { type: Array, required: true }, // [{ date, count }]
  totalMessages: { type: Number, required: true },
});

const chartRef = ref<HTMLCanvasElement | null>(null);
let chartInstance: ChartJS | null = null;

// Données du graphique
const chartData = ref({
  labels: [] as string[],
  datasets: [
    {
      data: [] as number[],
      borderColor: '#4D4D4D',
      backgroundColor: 'rgba(77,77,77,0.1)',
      fill: true,
      tension: 0.4,
      pointRadius: 2,
    },
  ],
});

// Options du graphique
const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: { display: false },
    tooltip: { enabled: true },
  },
  scales: {
    x: {
      display: true, // ✅ Affiche les dates
      ticks: {
        color: '#4D4D4D',
        font: { size: 12 },
      },
      grid: { display: false },
    },
    y: {
      display: false, // cacher l'axe Y pour le style sparkline
      beginAtZero: true,
    },
  },
};

// Fonction pour créer ou mettre à jour le chart
const renderChart = () => {
  if (!chartRef.value || !props.data?.length) return;

  if (chartInstance) {
    chartInstance.data = chartData.value;
    chartInstance.update();
  } else {
    chartInstance = new ChartJS(chartRef.value, {
      type: 'line',
      data: chartData.value,
      options: chartOptions,
    });
  }
};

// Watch pour mettre à jour les données
watch(
  () => props.data,
  (val) => {
    if (!val || !val.length) return;

    // Formater les dates pour affichage : "jour/mois"
    chartData.value.labels = val.map(d => {
      const date = new Date(d.date);
      return `${date.getDate()}/${date.getMonth() + 1}`;
    });

    chartData.value.datasets[0].data = val.map(d => d.count);
    renderChart();
  },
  { immediate: true }
);

// Détruire le chart au démontage pour éviter les fuites mémoire
onUnmounted(() => {
  if (chartInstance) {
    chartInstance.destroy();
    chartInstance = null;
  }
});

onMounted(() => renderChart());
</script>

<style scoped>
canvas {
  width: 100%;
  height: 100%;
}
</style>
