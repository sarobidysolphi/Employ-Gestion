<template>
  <div v-if="message" class="toast" :class="ok ? 'ok' : 'error'">
    {{ message }}
  </div>
</template>

<script setup>
defineProps({
  message: { type: String, default: "" },
  ok: { type: Boolean, default: true },
});
</script>