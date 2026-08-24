import { defineStore } from "pinia";
import api from "../services/api";

export const useAuthStore = defineStore("auth", {
  state: () => ({
    token: localStorage.getItem("token") || null,
    username: localStorage.getItem("username") || null,
  }),

  getters: {
    isAuthenticated: (state) => !!state.token,
  },

  actions: {
    async login(username, password) {
      const { data } = await api.post("/login.php", { username, password });
      this.token = data.token;
      this.username = data.user.username;
      localStorage.setItem("token", data.token);
      localStorage.setItem("username", data.user.username);
    },

    logout() {
      this.token = null;
      this.username = null;
      localStorage.removeItem("token");
      localStorage.removeItem("username");
    },
  },
});