<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {
  mdiAccountGroup,
  mdiMagnify,
  mdiLogout,
  mdiPencil,
  mdiDelete,
  mdiPlus,
} from "@mdi/js";
export default {
  components: {
    AuthenticatedLayout,
    mdiAccountGroup,
    mdiMagnify,
    mdiLogout,
    mdiPencil,
    mdiDelete,
    mdiPlus,
  },
  data() {
    return {
      icons: { mdiAccountGroup, mdiMagnify, mdiLogout, mdiPencil, mdiDelete, mdiPlus },
    };
  },
};
</script>
<template>
  <AuthenticatedLayout>
    <v-card>
      <Toolbar
        :icon="icons.mdiAccountGroup"
        toolbarTitle="Alertes/Avertissements"
      ></Toolbar>
    </v-card>
  </AuthenticatedLayout>
</template>
