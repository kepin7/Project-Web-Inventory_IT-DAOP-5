<template>
  <div class="h-48 relative flex items-center justify-center">
    <Doughnut :data="chartData" :options="chartOptions" />
  </div>
</template>

<script setup>
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js'
import { Doughnut } from 'vue-chartjs'
import { computed } from 'vue'

ChartJS.register(ArcElement, Tooltip, Legend)

const props = defineProps({
  categoriesData: {
    type: Array,
    default: () => []
  }
})

const colors = ['#2e3192', '#5b5fc7', '#9499df', '#cfd2f1', '#e0e7ff', '#c7d2fe', '#818cf8', '#4f46e5'];

const chartData = computed(() => {
  if (!props.categoriesData || props.categoriesData.length === 0) {
    return {
      labels: ['Tidak ada data'],
      datasets: [{ backgroundColor: ['#f3f4f6'], data: [1], borderWidth: 0, hoverOffset: 0 }]
    }
  }

  return {
    labels: props.categoriesData.map(c => c.name),
    datasets: [
      {
        backgroundColor: props.categoriesData.map((_, i) => colors[i % colors.length]),
        data: props.categoriesData.map(c => c.percentage),
        borderWidth: 0,
        hoverOffset: 4
      }
    ]
  }
})

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  cutout: '75%', // makes it a thick ring
  plugins: {
    legend: {
      display: false // We will build custom legend
    },
    tooltip: {
      backgroundColor: 'rgba(255, 255, 255, 0.9)',
      titleColor: '#1f2937',
      bodyColor: '#4b5563',
      borderColor: '#e5e7eb',
      borderWidth: 1,
      padding: 10,
      callbacks: {
        label: function(context) {
          return ` ${context.label}: ${context.raw}%`
        }
      }
    }
  }
}
</script>
