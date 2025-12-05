<template>
  <div>
    <apexchart
      width="100%"
      height="350"
      type="pie"
      :options="chartOptions"
      :series="series"
    />
  </div>
</template>

<script setup>
import ApexChart from "vue3-apexcharts";

// Sample data
const series = [44, 25, 31];

const chartOptions = {
  labels: ["Jeffrey Mahinay", "Richard Lumbab", "John Aldrin Franco"],
  legend: {
    position: "bottom",
    horizontalAlign: "center",
  },
  colors: ['#FFD6AA', '#FDA4AF', '#F87171'],
  dataLabels: {
    enabled: false,
    formatter: function (val, opts) {
      return opts.w.config.labels[opts.seriesIndex] + ": " + val;
    },
  },
  tooltip: {
    enabled: true,
    y: {
      formatter: function (val) {
        return val + " tickets closed";
      },
    },
  },
};
</script>
