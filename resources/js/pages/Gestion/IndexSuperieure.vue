<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { mdiTimerSyncOutline } from "@mdi/js";
export default {
  components: { AuthenticatedLayout },
  data() {
    return {
      icons: { mdiTimerSyncOutline },
    };
  },
};
</script>

<template>
  <AuthenticatedLayout>
    <Toolbar
      styleToolbar="background-color: white;"
      :icon="icons.mdiTimerSyncOutline"
      toolbarTitle="Liste des menus Supérieure"
    ></Toolbar>
    <div>
      <h1>Gestion Supérieure</h1>
    </div>
  </AuthenticatedLayout>
</template>
