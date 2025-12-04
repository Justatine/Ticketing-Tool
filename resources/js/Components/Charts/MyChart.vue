<template>
  <apexchart type="bar" :options="options" :series="series" height="350" />
</template>

<script setup>
import { ref } from 'vue'

const options = ref({
  chart: { id: 'my-chart' },
  xaxis: { categories: ['Price Change', 'Printer', 'Portal'] },
  plotOptions: {
    bar: {
      borderRadius: 8,
      borderRadiusApplication: 'end',
      columnWidth: '50%',
      distributed: true,
      colors: {
        ranges: [
          { from: 0, to: 0, color: '#4ade80' }
        ],
        // backgroundBarColors: ['#4ade80', '#f87171', '#60a5fa'], // each bar color
      }
    }
  },
  dataLabels: { enabled: true },
  colors: ['#FFD6AA', '#FDA4AF', '#F87171'],
})

const series = ref([
  { name: 'Tickets', data: [10, 5, 2] }
])
</script>
