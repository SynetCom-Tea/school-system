<!-- AppreantChart.vue -->
<template>
    <div>
      <line-chart :data="chartData" :options="chartOptions" />
    </div>
  </template>
  
  <script>
  import { Line, mixins } from 'vue-chart-3';
  
  export default {
    extends: Line,
    mixins: [mixins.reactiveData],
  
    props: {
      graphData: { type: Object, required: true },
    },
  
    data() {
      return {
        chartData: null,
        chartOptions: {
          // Ajoutez les options de configuration du graphe Chart.js ici
        },
      };
    },
  
    watch: {
      graphData: {
        handler: 'updateChartData',
        immediate: true,
      },
    },
  
    methods: {
      updateChartData() {
        const datasets = [];
  
        for (const matiereId in this.graphData) {
          const matiereData = this.graphData[matiereId];
  
          for (const periode in matiereData) {
            const periodeData = matiereData[periode];
  
            const dataset = {
              label: `${matiereData[periode][0].matiere} - ${periode}`,
              data: periodeData.map(item => ({
                x: item.date,
                y: item.note,
              })),
            };
  
            datasets.push(dataset);
          }
        }
  
        this.chartData = {
          datasets,
        };
      },
    },
  };
  </script>
  