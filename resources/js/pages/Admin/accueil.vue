<template>
    <AuthenticatedLayout>
    <Toolbar
      styleToolbar="background-color: white;"
      :icon="mdiAccount"
      toolbarTitle="Acceuil"
    ></Toolbar>
    
    </AuthenticatedLayout>
  </template>
  <script>
    import AuthenticatedLayout from "@/layouts/AuthenticatedLayout.vue";
    import Toolbar from "@/components/customizedComponents/Toolbar.vue";
    import Datatable from "@/components/customizedComponents/datatable.vue";
    import Loader from "@/components/customizedComponents/Loader.vue";
    import { mdiAccount, mdiPurse, mdiHomeOutline, mdiPresentation, mdiGift } from "@mdi/js";
  export default {
    components: {
    Loader,
    Datatable,
    Toolbar,
    AuthenticatedLayout,
    mdiAccount,
  },
  }
</script>