import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

const router = new VueRouter({
  // Vos configurations de route ici...
});

let loading = false;

router.beforeEach((to, from, next) => {
  loading = true; // Activer l'indicateur de chargement
  next();
});

router.afterEach(() => {
  loading = false; // Désactiver l'indicateur de chargement
});

export { router, loading };
