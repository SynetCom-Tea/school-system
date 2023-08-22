<template>
  <v-layout>
    <Sidebar />
    <v-main>
      <slot />
      <!-- <v-container fluid class="main-container">
        <v-card ripple color="rgb(125, 0, 44)">
          <v-card-title style="color: white">{{ page.title }}</v-card-title>
          <v-card-subtitle class="text-wrap" style="color: white">{{
            page.subtitle
          }}</v-card-subtitle>
        </v-card>
      </v-container> -->
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
