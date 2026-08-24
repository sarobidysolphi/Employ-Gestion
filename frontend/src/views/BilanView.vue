<template>
  <div>
    <h2>Bilan des employes</h2>
    <p class="hint">Salaire total, minimal et maximal</p>

    <div class="stats">
      <div class="card stat">
        <p class="label">Salaire total</p>
        <p class="value">{{ store.total.toLocaleString() }}</p>
      </div>
      <div class="card stat">
        <p class="label">Salaire minimal</p>
        <p class="value">{{ store.minimum.toLocaleString() }}</p>
      </div>
      <div class="card stat">
        <p class="label">Salaire maximal</p>
        <p class="value">{{ store.maximum.toLocaleString() }}</p>
      </div>
    </div>

    <div class="card chart-card">
      <div class="chart-header">
        <p>Repartition par observation</p>
        <div class="toggle">
          <button
            :class="{ active: view === 'histogramme' }"
            @click="view = 'histogramme'"
          >
            Histogramme
          </button>
          <button
            :class="{ active: view === 'camembert' }"
            @click="view = 'camembert'"
          >
            Camembert
          </button>
        </div>
      </div>

      <div class="chart-box">
        <Bar v-if="view === 'histogramme'" :data="chartData" :options="chartOptions" />
        <Pie v-else :data="chartData" :options="chartOptions" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { Bar, Pie } from "vue-chartjs";
import {
  Chart as ChartJS,
  Title, Tooltip, Legend, BarElement,
  CategoryScale, LinearScale, ArcElement,
} from "chart.js";
import { useEmployesStore } from "../store/employes";

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement);

const store = useEmployesStore();
const view = ref("histogramme");

const colors = {
  mediocre: "#B4502F",
  moyen: "#8C6A22",
  grand: "#33613F",
};

const chartData = computed(() => {
  const r = store.repartition;
  return {
    labels: ["mediocre", "moyen", "grand"],
    datasets: [
      {
        label: "Nombre d'employes",
        data: [r.mediocre, r.moyen, r.grand],
        backgroundColor: [colors.mediocre, colors.moyen, colors.grand],
        borderRadius: 4,
      },
    ],
  };
});

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: { legend: { display: view.value === "camembert" } },
};

onMounted(() => store.fetchAll());
</script>

<style scoped>
h2 {
  margin: 0 0 2px;
}

.hint {
  color: #8a8570;
  font-size: 13px;
  margin: 0 0 20px;
}

.stats {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 16px;
  margin-bottom: 24px;
}

.stat {
  padding: 16px;
}

.label {
  font-size: 12px;
  color: #8a8570;
  margin: 0 0 4px;
}

.value {
  font-size: 24px;
  margin: 0;
}

.chart-card {
  padding: 24px;
}

.chart-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 16px;
  font-size: 14px;
}

.toggle {
  border: 1px solid #dfd8c6;
  border-radius: 6px;
  overflow: hidden;
  display: flex;
}

.toggle button {
  border: none;
  background: transparent;
  padding: 6px 12px;
  font-size: 12px;
  cursor: pointer;
  color: #6b674f;
}

.toggle button.active {
  background: #232c3d;
  color: #f5efe0;
}

.chart-box {
  height: 280px;
}
</style>