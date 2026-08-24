<template>
  <span
    class="badge"
    :style="{ color: colors[statut].fg, background: colors[statut].bg }"
  >
    {{ statut }}
  </span>
</template>

<script setup>
defineProps({
  statut: { type: String, required: true },
});

const colors = {
  mediocre: { fg: "#B4502F", bg: "#F5E4DA" },
  moyen: { fg: "#8C6A22", bg: "#F3E8CC" },
  grand: { fg: "#33613F", bg: "#DEEBDF" },
};
</script>

<style scoped>
.badge {
  padding: 4px 10px;
  border-radius: 4px;
  font-size: 12px;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 0.02em;
}
</style>