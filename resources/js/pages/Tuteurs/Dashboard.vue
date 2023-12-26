<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {
  mdiMonitorDashboard,
  mdiMagnify,
  mdiLogout,
  mdiPencil,
  mdiDelete,
  mdiPlus,
} from "@mdi/js";
export default {
  components: {
    AuthenticatedLayout,
    mdiMonitorDashboard,
    mdiMagnify,
    mdiLogout,
    mdiPencil,
    mdiDelete,
    mdiPlus,
  },
  data() {
    return {
      icons: { mdiMonitorDashboard, mdiMagnify, mdiLogout, mdiPencil, mdiDelete, mdiPlus },
    };
  },
};
</script>
<template>
  <AuthenticatedLayout>
    <v-card>
      <Toolbar :icon="icons.mdiMonitorDashboard" toolbarTitle="Tableau de bord personnalisé"></Toolbar>
    </v-card>
  </AuthenticatedLayout>
</template>
