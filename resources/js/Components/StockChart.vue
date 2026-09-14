<template>
  <div class="h-full w-full min-h-[16rem] relative">
    <Line :data="computedChartData" :options="chartOptions" />
  </div>
</template>

<script setup>
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend,
  Filler
} from 'chart.js'
import { Line } from 'vue-chartjs'

ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend,
  Filler
)

const props = defineProps({
  chartData: {
    type: Object,
    default: () => null
  }
})

// Create computed property for chart data to react to prop changes
import { computed } from 'vue'

const computedChartData = computed(() => {
  if (!props.chartData || !props.chartData.labels) {
    // Fallback empty state
    return {
      labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
      datasets: [
        {
          label: 'Stok Masuk',
          backgroundColor: 'rgba(49, 46, 129, 0.1)',
          borderColor: '#312e81',
          data: [0, 0, 0, 0, 0, 0, 0],
          fill: true,
          tension: 0.4,
          pointBackgroundColor: '#312e81',
          pointBorderColor: '#fff',
          pointBorderWidth: 2,
          pointRadius: 4,
          pointHoverRadius: 6,
        },
        {
          label: 'Stok Keluar',
          backgroundColor: 'rgba(249, 115, 22, 0)',
          borderColor: '#f97316',
          data: [0, 0, 0, 0, 0, 0, 0],
          fill: false,
          borderDash: [5, 5],
          tension: 0.4,
          pointBackgroundColor: '#fff',
          pointBorderColor: '#f97316',
          pointBorderWidth: 2,
          pointRadius: 4,
          pointHoverRadius: 6,
        }
      ]
    }
  }

  return {
    labels: props.chartData.labels,
    datasets: [
      {
        label: 'Stok Masuk',
        backgroundColor: 'rgba(49, 46, 129, 0.1)',
        borderColor: '#312e81',
        data: props.chartData.dataIn,
        fill: true,
        tension: 0.4,
        pointBackgroundColor: '#312e81',
        pointBorderColor: '#fff',
        pointBorderWidth: 2,
        pointRadius: 4,
        pointHoverRadius: 6,
      },
      {
        label: 'Stok Keluar',
        backgroundColor: 'rgba(249, 115, 22, 0)',
        borderColor: '#f97316',
        data: props.chartData.dataOut,
        fill: false,
        borderDash: [5, 5],
        tension: 0.4,
        pointBackgroundColor: '#fff',
        pointBorderColor: '#f97316',
        pointBorderWidth: 2,
        pointRadius: 4,
        pointHoverRadius: 6,
      }
    ]
  }
})

const chartOptions = computed(() => ({
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      display: false, // We'll build custom legend in HTML
    },
    tooltip: {
      mode: 'index',
      intersect: false,
      backgroundColor: 'rgba(255, 255, 255, 0.9)',
      titleColor: '#1f2937',
      bodyColor: '#4b5563',
      borderColor: '#e5e7eb',
      borderWidth: 1,
      padding: 10,
      boxPadding: 4,
      usePointStyle: true,
    }
  },
  scales: {
    x: {
      grid: {
        display: false,
        drawBorder: false,
      },
      ticks: {
        color: '#9ca3af',
        font: { size: 12 }
      }
    },
    y: {
      min: 0,
      max: props.chartData && props.chartData.max ? props.chartData.max : 10,
      grid: {
        color: '#f3f4f6',
        drawBorder: false,
      },
      ticks: {
        color: '#9ca3af',
        font: { size: 12 },
        stepSize: Math.ceil((props.chartData && props.chartData.max ? props.chartData.max : 10) / 5),
      }
    }
  },
  interaction: {
    mode: 'nearest',
    axis: 'x',
    intersect: false
  }
}))
</script>
