<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router } from "@inertiajs/vue3";
import { mdiPlus, mdiTimetable } from "@mdi/js";
export default {
  layout: AuthenticatedLayout,
  props: ["emplois"],
  data() {
    return {
      icon: {
        mdiPlus,
        mdiTimetable,
      },
    };
  },
  methods: {
    goTo() {
      router.get(route("emplois.create"));
    },
  },
};
</script>
<template>
  <v-card>
    <Toolbar :icon="icon.mdiTimetable" toolbarTitle="Gestion des Emplois"></Toolbar>
    <v-card-text>
      <v-card>
        <button @click="goTo()">
          <v-icon>{{ icon.mdiPlus }}</v-icon> Ajouter
        </button>
      </v-card>
    </v-card-text>
  </v-card>
</template>
