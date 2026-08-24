<template>
  <div class="login-page">
    <form class="card login-card" @submit.prevent="handleSubmit">
      <h1>Gestion des Employes</h1>
      <p class="subtitle">Connexion</p>

      <label>Identifiant</label>
      <input v-model="username" type="text" placeholder="admin" />

      <label>Mot de passe</label>
      <input v-model="password" type="password" placeholder="********" />

      <p v-if="error" class="error-text">{{ error }}</p>

      <button class="btn btn-primary" type="submit" :disabled="loading">
        {{ loading ? "Connexion..." : "Se connecter" }}
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "../store/auth";

const username = ref("");
const password = ref("");
const error = ref("");
const loading = ref(false);

const auth = useAuthStore();
const router = useRouter();

async function handleSubmit() {
  error.value = "";
  loading.value = true;
  try {
    await auth.login(username.value, password.value);
    router.push("/liste");
  } catch (err) {
    error.value = err.response?.data?.message || "Connexion echouee";
  } finally {
    loading.value = false;
  }
}
</script>

<style scoped>
.login-page {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}

.login-card {
  width: 320px;
  padding: 32px;
  display: flex;
  flex-direction: column;
  gap: 6px;
}

h1 {
  font-size: 18px;
  margin: 0 0 2px;
  text-align: center;
}

.subtitle {
  text-align: center;
  color: #8a8570;
  font-size: 13px;
  margin: 0 0 16px;
}

label {
  font-size: 12px;
  color: #6b674f;
  margin-top: 10px;
}

input {
  padding: 9px 10px;
  border-radius: 6px;
  border: 1px solid #dfd8c6;
  margin-top: 4px;
}

.error-text {
  color: #b4502f;
  font-size: 12px;
  margin: 8px 0 0;
}

button {
  margin-top: 18px;
}
</style>