<template>
  <div>
    <h2>Ajouter un employe</h2>
    <p class="hint">Insertion dans la table Employe (numEmp, nom, salaire)</p>

    <form class="card form" @submit.prevent="handleSubmit">
      <label>Numero employe</label>
      <input v-model="numEmp" placeholder="E006" />

      <label>Nom</label>
      <input v-model="nom" placeholder="Nom et prenom" />

      <label>Salaire</label>
      <input v-model.number="salaire" type="number" placeholder="0" />

      <button class="btn btn-primary" type="submit">Enregistrer</button>
    </form>

    <ToastMessage :message="toast.message" :ok="toast.ok" />
  </div>
</template>

<script setup>
import { ref, reactive } from "vue";
import { useEmployesStore } from "../store/employes";
import ToastMessage from "../components/ToastMessage.vue";

const numEmp = ref("");
const nom = ref("");
const salaire = ref(null);

const store = useEmployesStore();
const toast = reactive({ message: "", ok: true });

function showToast(message, ok) {
  toast.message = message;
  toast.ok = ok;
  setTimeout(() => (toast.message = ""), 2500);
}

async function handleSubmit() {
  if (!numEmp.value || !nom.value || salaire.value === null) return;

  const result = await store.ajouter({
    numEmp: numEmp.value,
    nom: nom.value,
    salaire: salaire.value,
  });

  showToast(result.message, result.ok);

  if (result.ok) {
    numEmp.value = "";
    nom.value = "";
    salaire.value = null;
  }
}
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

.form {
  max-width: 420px;
  padding: 24px;
  display: flex;
  flex-direction: column;
  gap: 4px;
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

button {
  margin-top: 18px;
}
</style>