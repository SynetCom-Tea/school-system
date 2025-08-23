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
  props: ["users", "sectionID", "timestamp"], // AJOUTEZ timestamp
  data() {
    return {
      form: this.$inertia.form({
        nom: "",
        email: "",
        password: "",
        password_confirmation: "",
        section_id: null
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
          key: "user.type_user",
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
    getDatatableTitle() {
      let title1 =
        this.sectionID == 1
          ? "Utilisateurs du Primaire"
          : this.sectionID == 2
          ? "Utilisateurs du Secondaire"
          : null;
      let title = title1
        ? title1
        : this.sectionID == 3
        ? "Utilisateurs du Supérieur"
        : this.sectionID == 4
        ? "Utilisateurs de l'université"
        : "Liste des utilisateurs";
      return title;
    },
    formTitle() {
      return this.editedIndex === -1 ? "New Item" : "Edit Item";
    },
    customizedUsers() {
      let list = this.users;
      let vlist = [];
      
      if (list && list.length > 0) {
        list.forEach((element, index) => {
          let apprenant = element.apprenant ? element.apprenant : null;
          let tuteur = element.tuteur ? element.tuteur : null;
          let enseignant = element.enseignant ? element.enseignant : null;
          let superadmin = element.etablissement_id == null ? element : null;
          
          vlist.push({
            type_user: apprenant ? "Apprenant" :
                      tuteur ? "Tuteur" :
                      enseignant ? "Enseignant" :
                      superadmin ? "Super-Administrateur" : "Administrateur",
            count: index + 1,
            user: element.nom ? element :
                  apprenant ? apprenant :
                  tuteur ? tuteur :
                  enseignant,
            login: element.email,
          });
        });
      }
      
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
    // AJOUTEZ CE WATCHER
    users: {
      handler(newUsers) {
        console.log('Users updated, refreshing data');
        this.dataUsers = this.customizedUsers;
      },
      deep: true,
      immediate: true
    }
  },
  methods: {
    goTo() {
      this.form.get(route('users.create'))
    },
  },
  created() {
    this.form.section_id = this.sectionID
    if (this.$page.props.flash?.message?.type == "error") {
      this.$toast.error(this.$page.props.flash.message.text);
    }
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
    this.getDatatableTitle;
    this.dataUsers = this.customizedUsers;
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
        :key="timestamp"
        :titleDatatable="getDatatableTitle"
        :headers="headers"
        :items="dataUsers"
        :permission="'manage_school|user.create'"
        :functionOnClickAddButton="goTo"
      >
        <template v-slot:item.actions="{ item }"> </template>
      </Datatable>
    </v-card-text>
  </v-card>
</template>