<template>
  <div class="layout">
    <SidebarNav />
    <main class="content">
      <router-view />
    </main>
  </div>
</template>

<script setup>
import SidebarNav from "../components/SidebarNav.vue";
</script>

<style scoped>
.layout {
  display: flex;
  min-height: 100vh;
}

.content {
  flex: 1;
  padding: 32px;
}
</style>