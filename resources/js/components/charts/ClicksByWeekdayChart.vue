<template>
  <div class="p-4 bg-white dark:bg-dark-background rounded shadow">
    <h3 class="text-lg font-semibold mb-3 text-text-dark dark:text-dark-white">
      Jour le plus actif (clics “Commander”)
    </h3>
    <canvas ref="chartCanvas" class="w-full h-64"></canvas>
  </div>
</template>

<script setup lang="ts">
import { onMounted, ref, watch } from 'vue';
import { Chart, registerables } from 'chart.js';
import dayjs from 'dayjs';
Chart.register(...registerables);

const props = defineProps({
  data: {
    type: Array,
    default: () => [],
    // Structure attendue : [{ date: '2025-10-01', count: 5 }, ...]
  },
});

const chartCanvas = ref<HTMLCanvasElement | null>(null);
let chartInstance: Chart | null = null;

// Générer les 7 derniers jours (labels)
const getLast7DaysLabels = () => {
  const labels = [];
  for (let i = 6; i >= 0; i--) {
    labels.push(dayjs().subtract(i, 'day').format('DD/MM')); // format jour/mois
  }
  return labels;
};

// Normaliser les données
const getCounts = (rawData: Array<{ date: string; count: number }>) => {
  const dataArray = Array.isArray(rawData) ? rawData : Object.values(rawData);
  const labels = getLast7DaysLabels();

  return labels.map(label => {
    const item = dataArray.find(d => dayjs(d.date).format('DD/MM') === label);
    return item ? item.count : 0;
  });
};

function renderChart() {
  if (!chartCanvas.value) return;

  const labels = getLast7DaysLabels();
  const counts = getCounts(props.data);

  chartInstance = new Chart(chartCanvas.value, {
    type: 'bar',
    data: {
      labels,
      datasets: [
        {
          label: 'Clics "Commander"',
          data: counts,
          backgroundColor: 'rgba(59, 130, 246, 0.7)',
          borderColor: 'rgba(59, 130, 246, 1)',
          borderWidth: 1,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: { mode: 'index', intersect: false },
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: { stepSize: 1 },
        },
        x: {
          ticks: { autoSkip: false },
        },
      },
    },
  });
}

// Initialisation
onMounted(renderChart);

// Mettre à jour si les données changent
watch(
  () => props.data,
  newData => {
    if (chartInstance) {
      chartInstance.data.datasets[0].data = getCounts(newData);
      chartInstance.update();
    }
  },
  { deep: true }
);
</script>

<style scoped></style>
