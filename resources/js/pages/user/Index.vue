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
      dataUsers: [],
      icon: {
        mdiAccountGroup,
        mdiPlus,
      },
      search: "",
      dialog: false,
      dialogDelete: false,
      headers: [
        {
          title: "N°",
          align: "start",
          sortable: false,
          key: "count",
        },
        {
          title: "Nom",
          align: "center",
          key: "user.nom",
        },
        {
          title: "Prénom",
          align: "center",
          key: "user.prenom",
        },
        {
          title: "Type",
          align: "center",
          key: "type_user",
        },
        {
          title: "Téléphone",
          align: "center",
          key: "user.telephone",
        },
        {
          title: "Login",
          align: "center",
          key: "login",
        },
        {
          title: "Actions",
          align: "center",
          key: "actions",
        },
      ],
      searchQuery: "",
      isLoading: false,
    };
  },

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New Item" : "Edit Item";
    },
    customizedUsers() {
      let list = this.users;
      let vlist = [],
        apprenant,
        tuteur;

      if (list && list.length > 0) {
        list.forEach((element, index) => {
          if (element) {
            apprenant = element.apprenant ? element.apprenant : null;
            tuteur = element.tuteur ? element.tuteur : null;
          }
          vlist.push({
            type_user: apprenant ? "Apprenant" : tuteur ? "Tutueur" : "Administrateur",
            count: index + 1,
            user: element.nom ? element : apprenant ? apprenant : tuteur,
            login: element.email,
          });
        });
      }

      this.dataUsers = vlist ?? [];
      return vlist;
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
  },
  methods: {
    goTo() {
      router.get(route("users.create"));
    },
  },
  created() {
    if (this.$page.props.flash.message) {
      this.$swal({
        icon: "success",
        title: "Creation",
        text: this.$page.props.flash.message,
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
      });
    }
  },
  mounted() {
    this.customizedUsers;
  },
};
</script>

<template>
  <v-card>
    <Toolbar
      :icon="icon.mdiAccountGroup"
      toolbarTitle="Gestion des utilisateurs"
    ></Toolbar>

    <v-card-text>
      <Datatable
        titleDatatable="Utilisateurs du Primaire"
        :headers="headers"
        :items="dataUsers"
        :functionOnClickAddButton="goTo"
      >
        <template v-slot:item.actions="{ item }"> </template>
      </Datatable>
    </v-card-text>
  </v-card>
</template>
