<!-- LineChart.vue -->
<template>
<div class="chart">
    <canvas ref="myChartCanvas"></canvas>
</div>
</template>

  
  
<script>
import {
    ref,
    watchEffect,
    onMounted
} from 'vue';
import {
    Chart
} from 'chart.js/auto';

onMounted(() => {
    // Données de test (remplacez cela par vos propres données)
    const graph = {
        labels: ['Octobre', 'Novembre', 'Décembre'],
        datasets: [{
                label: 'Matière 1',
                data: [8, 7, 9]
            },
            {
                label: 'Matière 2',
                data: [6, 5, 7]
            }
            // Ajoutez d'autres matières selon vos besoins
        ]
    };

    watchEffect(() => {
        updateChartData(graph);
    });
});

const updateChartData = (data) => {
    const canvasRef = ref(null);

    const setCanvasRef = (el) => {
        // if (el) {
            canvasRef.value = el;
            const ctx = el.getContext('2d');

            if (ctx) {
                new Chart(ctx, {
                    type: 'line',
                    data: data,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        // Autres options Chart.js ici
                    }
                });
            }
        // }
    };

    return {
        setCanvasRef
    };
};
</script>
  
  
<style scoped>
.chart {
    height: 400px;
}
</style>
