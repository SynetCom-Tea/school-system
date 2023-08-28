<template>
  <v-layout>
    <Sidebar />
    <v-main>
      <slot />
    </v-main>
  </v-layout>
</template>

<script>
import Sidebar from "../components/auth-page/SideBar.vue";
import { router } from "@inertiajs/vue3";
export default {
  name: "App",

  components: {
    Sidebar,
  },

  data: () => ({
    page: {
      title: "Bienvenue sur la plateforme de gestion de Système Scoloaire",
      subtitle:
        "Vous pouvez administrez et gérer vos données en toute simplicité et en sécurité. Une plateforme qui intègre la gestion de votre établissement de l'inscription à l'évaluation jusqu'à l'analyse et le traitement de vos données.!",
    },
  }),
};
</script>
