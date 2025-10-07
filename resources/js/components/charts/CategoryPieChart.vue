<template>
  <div class="h-full p-4 flex flex-col">
    <h3 class="text-lg font-semibold mb-3">Répartition des produits par catégorie</h3>

    <div class="flex-1 min-h-[260px]">
      <canvas v-if="chartData.labels.length" ref="chartRef"></canvas>
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
  ArcElement,
  PieController, // <-- ajouté
} from 'chart.js';

// Enregistrement obligatoire
ChartJS.register(Title, Tooltip, Legend, ArcElement, PieController);


// Props
const props = defineProps({
  data: { type: Array, required: true }
});

// Référence du canvas
const chartRef = ref<HTMLCanvasElement | null>(null);
let chartInstance: ChartJS | null = null;

// Données du chart
const chartData = ref({
  labels: [] as string[],
  datasets: [
    {
      data: [] as number[],
      backgroundColor: [
        '#3b82f6', '#1e293b', '#e0e7ff', '#0f172a',
        '#38bdf8', '#facc15', '#f87171', '#34d399'
      ],
    },
  ],
});

// Options
const chartOptions = {
  responsive: true,
  plugins: {
    legend: { position: 'bottom' as const },
    tooltip: {
      callbacks: {
        label: (context: any) => `${context.label}: ${context.parsed}`,
      },
    },
  },
};

// Créer / mettre à jour le chart
const renderChart = () => {
  if (!chartRef.value) return;

  if (chartInstance) {
    chartInstance.data = chartData.value;
    chartInstance.update();
  } else {
    chartInstance = new ChartJS(chartRef.value, {
      type: 'pie',
      data: chartData.value,
      options: chartOptions,
    });
  }
};

// Watch pour mettre à jour les données
watch(
  () => props.data,
  (val: Array<any>) => {
    chartData.value.labels = val.map(d => d.name);
    chartData.value.datasets[0].data = val.map(d => Number(d.count || 0));
    renderChart();
  },
  { immediate: true }
);

// Initial render
onMounted(() => renderChart());
</script>
