<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { mdiTimerStarOutline } from "@mdi/js";
export default {
  components: { AuthenticatedLayout },
  data() {
    return {
      icons: { mdiTimerStarOutline },
    };
  },
};
</script>

<template>
  <AuthenticatedLayout>
    <Toolbar
      styleToolbar="background-color: white;"
      :icon="icons.mdiTimerStarOutline"
      toolbarTitle="Liste des menus Secondaire"
    ></Toolbar>
    <div>
      <h1>Gestion Secondaire</h1>
    </div>
  </AuthenticatedLayout>
</template>
