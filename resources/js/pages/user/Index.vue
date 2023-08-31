<script>
import {
  mdiAccountGroup,
  mdiMagnify,
  mdiLogout,
  mdiPencil,
  mdiDelete,
  mdiPlus,
} from "@mdi/js";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

import { router, usePage, useForm } from "@inertiajs/vue3";
export default {
  components: {
    mdiAccountGroup,
    mdiPlus,
  },
  layout: AuthenticatedLayout,
  props: ["users"],
  // Properties returned from data() become reactive state
  // and will be exposed on `this`.
  data() {
    return {
      form: this.$inertia.form({
        nom: "",
        email: "",
        password: "",
        password_confirmation: "",
      }),
      icons: {
        mdiAccountGroup,
        mdiPlus,
      },
      search: "",
      dialog: false,
      dialogDelete: false,
      headers: [
        {
          title: "Id",
          align: "start",
          key: "id",
          sortable: false,
          key: "id",
        },
        { title: "Nom", align: "center", key: "nom" },
        { title: "Prénom", align: "center", key: "prenom" },
        { title: "Sexe", align: "center", key: "sex" },
        { title: "Téléphone", align: "center", key: "telephone" },
        { title: "Email", align: "center", key: "email" },
        { title: "Actions", align: "center", key: "actions" },
      ],
      searchQuery: "",
      isLoading: false,
    };
  },

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New Item" : "Edit Item";
    },
  },

  mounted() {
    // console.log(this.headers)
    // console.log(this.users);
  },

  methods: {
    initialize() {
      this.users;
    },
    goTo() {
      router.get(route("users.create"));
    },
  },
};
</script>

<template>
  <Toolbar :icon="icons.mdiAccountGroup" toolbarTitle="Liste des utilisateurs"></Toolbar>
</template>
