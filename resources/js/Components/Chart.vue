<script setup>
import { Chart, registerables } from "chart.js";
import { BarChart } from "vue-chart-3";
import { ref, computed } from "vue"
Chart.register(...registerables);

const props = defineProps({ data: Object });

const labels = computed(() => props.data.labels);
const totals = computed(() => props.data.totals);
const barData = ref({
  labels: labels,
  datasets: [
    {
      label: '売上',
      data: totals,
      backgroundColor: "rgb(75, 192, 192)",
      tension: 0.1,
    }
  ]
})
</script>

<template>
  <BarChart :chartData="barData" :height="200"/>
</template>
