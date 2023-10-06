<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { mdiOfficeBuilding } from "@mdi/js";
export default {
  components: { AuthenticatedLayout },
  data() {
    return {
      icons: { mdiOfficeBuilding },
    };
  },
};
</script>

<template>
  <AuthenticatedLayout>
    <Toolbar
      styleToolbar="background-color: white;"
      :icon="icons.mdiOfficeBuilding"
      toolbarTitle="Liste des menus Secondaire"
    ></Toolbar>
    <div>
      <h1>Gestion Universitaire</h1>
    </div>
  </AuthenticatedLayout>
</template>
