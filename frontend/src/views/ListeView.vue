<template>
  <div>
    <h2>Liste des employes</h2>
    <p class="hint">nom, salaire, obs</p>

    <div class="card table-wrap">
      <table>
        <thead>
          <tr>
            <th>Nom</th>
            <th>Salaire</th>
            <th>Obs</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="emp in store.liste" :key="emp.numEmp">
            <template v-if="editing === emp.numEmp">
              <td><input v-model="draft.nom" /></td>
              <td><input v-model.number="draft.salaire" type="number" /></td>
              <td><ObsBadge :statut="obsFor(draft.salaire)" /></td>
              <td class="actions">
                <button class="link" @click="saveEdit(emp.numEmp)">Valider</button>
                <button class="link muted" @click="editing = null">Annuler</button>
              </td>
            </template>
            <template v-else>
              <td>{{ emp.nom }}</td>
              <td>{{ emp.salaire.toLocaleString() }}</td>
              <td><ObsBadge :statut="emp.obs" /></td>
              <td class="actions">
                <button class="link" @click="startEdit(emp)">Modifier</button>
                <button class="link danger" @click="handleDelete(emp.numEmp)">Supprimer</button>
              </td>
            </template>
          </tr>
          <tr v-if="store.liste.length === 0">
            <td colspan="4" class="empty">Aucun employe</td>
          </tr>
        </tbody>
      </table>
    </div>

    <ToastMessage :message="toast.message" :ok="toast.ok" />
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from "vue";
import { useEmployesStore } from "../store/employes";
import ObsBadge from "../components/ObsBadge.vue";
import ToastMessage from "../components/ToastMessage.vue";

const store = useEmployesStore();
const editing = ref(null);
const draft = reactive({ nom: "", salaire: 0 });
const toast = reactive({ message: "", ok: true });

function obsFor(salaire) {
  if (salaire < 1000) return "mediocre";
  if (salaire <= 5000) return "moyen";
  return "grand";
}

function showToast(message, ok) {
  toast.message = message;
  toast.ok = ok;
  setTimeout(() => (toast.message = ""), 2500);
}

function startEdit(emp) {
  editing.value = emp.numEmp;
  draft.nom = emp.nom;
  draft.salaire = emp.salaire;
}

async function saveEdit(numEmp) {
  const result = await store.modifier({
    numEmp,
    nom: draft.nom,
    salaire: draft.salaire,
  });
  showToast(result.message, result.ok);
  if (result.ok) editing.value = null;
}

async function handleDelete(numEmp) {
  const result = await store.supprimer(numEmp);
  showToast(result.message, result.ok);
}

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

.table-wrap {
  overflow: hidden;
}

table {
  width: 100%;
  border-collapse: collapse;
  font-size: 14px;
}

thead tr {
  background: #efeada;
  color: #6b674f;
  text-align: left;
}

th, td {
  padding: 12px 16px;
}

tbody tr {
  border-top: 1px solid #dfd8c6;
}

input {
  padding: 6px 8px;
  border-radius: 4px;
  border: 1px solid #dfd8c6;
  width: 100%;
}

.actions {
  display: flex;
  gap: 12px;
}

.link {
  background: none;
  border: none;
  cursor: pointer;
  font-size: 13px;
  color: #232c3d;
  padding: 0;
}

.link.danger {
  color: #b4502f;
}

.link.muted {
  color: #8a8570;
}

.empty {
  text-align: center;
  color: #a6a188;
  padding: 32px;
}
</style>