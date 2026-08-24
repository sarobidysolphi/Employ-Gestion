import { defineStore } from "pinia";
import api from "../services/api";

function getObs(salaire) {
  if (salaire < 1000) return "mediocre";
  if (salaire <= 5000) return "moyen";
  return "grand";
}

export const useEmployesStore = defineStore("employes", {
  state: () => ({
    liste: [],
  }),

  getters: {
    total: (state) => state.liste.reduce((sum, e) => sum + e.salaire, 0),
    minimum: (state) =>
      state.liste.length ? Math.min(...state.liste.map((e) => e.salaire)) : 0,
    maximum: (state) =>
      state.liste.length ? Math.max(...state.liste.map((e) => e.salaire)) : 0,
    repartition: (state) => {
      const counts = { mediocre: 0, moyen: 0, grand: 0 };
      state.liste.forEach((e) => (counts[getObs(e.salaire)] += 1));
      return counts;
    },
  },

  actions: {
    async fetchAll() {
      const { data } = await api.get("/employes.php");
      this.liste = data;
    },

    // renvoie { ok, message } pour que la vue affiche le bon message
    async ajouter(employe) {
      try {
        const { data } = await api.post("/employes.php", employe);
        await this.fetchAll();
        return { ok: true, message: data.message };
      } catch (err) {
        return {
          ok: false,
          message: err.response?.data?.message || "Insertion echouee",
        };
      }
    },

    async modifier(employe) {
      try {
        const { data } = await api.put("/employes.php", employe);
        await this.fetchAll();
        return { ok: true, message: data.message };
      } catch (err) {
        return {
          ok: false,
          message: err.response?.data?.message || "Modification echouee",
        };
      }
    },

    async supprimer(numEmp) {
      try {
        const { data } = await api.delete("/employes.php", {
          params: { numEmp },
        });
        await this.fetchAll();
        return { ok: true, message: data.message };
      } catch (err) {
        return {
          ok: false,
          message: err.response?.data?.message || "Suppression echouee",
        };
      }
    },
  },
});