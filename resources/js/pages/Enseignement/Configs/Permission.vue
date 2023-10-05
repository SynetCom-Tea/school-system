<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { mdiSecurity } from "@mdi/js";
export default {
  components: {
    mdiSecurity,
  },
  layout: AuthenticatedLayout,
  props: ["permissions"],
  data() {
    return {
      icon: {
        mdiSecurity,
      },
      headers: [
        {
          title: "ID",
          align: "start",
          sortable: false,
          key: "id",
        },
        { title: "Permission", align: "center", key: "name" },
        { title: "Description", align: "center", key: "description" },
      ],
    };
  },
};
</script>
<template>
  <v-card>
    <Toolbar :icon="icon.mdiSecurity" toolbarTitle="Liste des permissions"></Toolbar>
    <v-card-text>
      <v-data-table :headers="headers" :items="permissions"> </v-data-table>
    </v-card-text>
  </v-card>
</template>
