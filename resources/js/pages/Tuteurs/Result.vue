<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {
  mdiViewDashboardOutline,
  mdiMagnify,
  mdiLogout,
  mdiPencil,
  mdiDelete,
  mdiPlus,
} from "@mdi/js";
export default {
  components: {
    AuthenticatedLayout,
    mdiViewDashboardOutline,
    mdiMagnify,
    mdiLogout,
    mdiPencil,
    mdiDelete,
    mdiPlus,
  },
  data() {
    return {
      icons: { mdiViewDashboardOutline, mdiMagnify, mdiLogout, mdiPencil, mdiDelete, mdiPlus },
    };
  },
};
</script>
<template>
  <AuthenticatedLayout>
    <v-card>
      <Toolbar :icon="icons.mdiViewDashboardOutline" toolbarTitle="Notes et résultats"></Toolbar>
    </v-card>
  </AuthenticatedLayout>
</template>
