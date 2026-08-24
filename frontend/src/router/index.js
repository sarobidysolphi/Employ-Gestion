import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "../store/auth";

import LoginView from "../views/LoginView.vue";
import DashboardLayout from "../views/DashboardLayout.vue";
import AjoutView from "../views/AjoutView.vue";
import ListeView from "../views/ListeView.vue";
import BilanView from "../views/BilanView.vue";

const routes = [
  { path: "/", redirect: "/liste" },
  { path: "/login", name: "login", component: LoginView },
  {
    path: "/",
    component: DashboardLayout,
    meta: { requiresAuth: true },
    children: [
      { path: "ajout", name: "ajout", component: AjoutView },
      { path: "liste", name: "liste", component: ListeView },
      { path: "bilan", name: "bilan", component: BilanView },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to) => {
  const auth = useAuthStore();
  if (to.meta.requiresAuth && !auth.isAuthenticated) {
    return { name: "login" };
  }
  if (to.name === "login" && auth.isAuthenticated) {
    return { name: "liste" };
  }
  return true;
});

export default router;