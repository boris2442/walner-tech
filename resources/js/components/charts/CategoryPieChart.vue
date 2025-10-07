<template>
  <div class="h-full p-4 flex flex-col">
    <h3 class="text-lg font-semibold mb-3">Répartition des produits par catégorie</h3>

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
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement, PieController } from 'chart.js';
import ChartDataLabels from 'chartjs-plugin-datalabels';

// Enregistrement des controllers et plugins
ChartJS.register(Title, Tooltip, Legend, ArcElement, PieController, ChartDataLabels);

// Props
const props = defineProps({
  data: { type: Array, required: true },
});

// Référence du canvas
const chartRef = ref<HTMLCanvasElement | null>(null);
let chartInstance: ChartJS | null = null;

// Couleurs fixes à utiliser
const colors = ['#6997ee', '#9bb4e1', '#090909', '#4D4D4D', '#003366', '#FFE600', '#CCCCCC'];

// Données du chart
const chartData = ref({
  labels: [] as string[],
  datasets: [
    {
      data: [] as number[],
      backgroundColor: [] as string[],
    },
  ],
});

// Options du chart
const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  animation: { animateRotate: true, animateScale: true },
  plugins: {
    legend: { position: 'bottom', labels: { font: { size: 14 } } },
    tooltip: {
      callbacks: {
        label: (context: any) => {
          const total = context.chart.data.datasets[0].data.reduce((a: number, b: number) => a + b, 0);
          const percent = ((context.parsed / total) * 100).toFixed(1);
          return `${context.label}: ${context.parsed} (${percent}%)`;
        },
      },
    },
    datalabels: {
      color: '#fff',
      formatter: (value: number, context: any) => {
        const total = context.chart.data.datasets[0].data.reduce((a: number, b: number) => a + b, 0);
        return ((value / total) * 100).toFixed(1) + '%';
      },
      font: { weight: 'bold', size: 12 },
    },
  },
};

// Fonction pour créer ou mettre à jour le chart
const renderChart = () => {
  if (!chartRef.value) return;

  if (chartInstance) {
    chartInstance.data = chartData.value;
    chartInstance.update();
  } else {
    chartInstance = new ChartJS(chartRef.value, {
      type: 'pie',
      data: chartData.value,
      // options: chartOptions,
      plugins: [ChartDataLabels],
    });
  }
};

// Watch pour mettre à jour les données dynamiquement
watch(
  () => props.data,
  (val: Array<any>) => {
    if (!val.length) {
      chartData.value.labels = [];
      chartData.value.datasets[0].data = [];
      chartData.value.datasets[0].backgroundColor = [];
      renderChart();
      return;
    }

    chartData.value.labels = val.map(d => d.name);
    chartData.value.datasets[0].data = val.map(d => Number(d.count || 0));

    // Utiliser les couleurs fixes, et si plus de catégories que de couleurs, on boucle
    chartData.value.datasets[0].backgroundColor = val.map((_, i) => colors[i % colors.length]);

    renderChart();
  },
  { immediate: true }
);

// Initial render
onMounted(() => renderChart());
</script>

<style scoped>
canvas {
  width: 100% !important;
  height: 100% !important;
}
</style>
