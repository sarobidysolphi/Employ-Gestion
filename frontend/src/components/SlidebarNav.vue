<template>
  <aside class="sidebar">
    <div class="brand">Employe SPA</div>
    <nav>
      <RouterLink to="/ajout" class="nav-item">Ajout</RouterLink>
      <RouterLink to="/liste" class="nav-item">Liste / Mise a jour</RouterLink>
      <RouterLink to="/bilan" class="nav-item">Bilan & Graphe</RouterLink>
    </nav>
    <button class="logout" @click="handleLogout">Deconnexion</button>
  </aside>
</template>

<script setup>
import { useRouter } from "vue-router";
import { useAuthStore } from "../store/auth";

const router = useRouter();
const auth = useAuthStore();

function handleLogout() {
  auth.logout();
  router.push("/login");
}
</script>

<style scoped>
.sidebar {
  width: 220px;
  flex-shrink: 0;
  background: #232c3d;
  padding: 24px 16px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  min-height: 100vh;
}

.brand {
  color: #efe9d8;
  font-size: 15px;
  margin-bottom: 32px;
  font-weight: 500;
}

nav {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.nav-item {
  color: #b7bcc7;
  text-decoration: none;
  padding: 10px 12px;
  border-radius: 6px;
  font-size: 14px;
}

.nav-item.router-link-active {
  background: #334059;
  color: #f5efe0;
}

.logout {
  background: none;
  border: none;
  color: #b7bcc7;
  text-align: left;
  padding: 10px 12px;
  cursor: pointer;
  font-size: 14px;
}
</style>