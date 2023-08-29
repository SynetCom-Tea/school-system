<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, router } from "@inertiajs/vue3";

import {
  mdiAccountSchool,
  mdiPlus,
  mdiPencil,
  mdiDelete,
  mdiPlusCircle,
  mdiClipboardEditOutline,
  mdiOfficeBuilding,
  mdiLockReset,
} from "@mdi/js";
export default {
  components: {
    mdiAccountSchool,
    mdiPlus,
    mdiPencil,
    mdiDelete,
    mdiPlusCircle,
    mdiClipboardEditOutline,
    mdiOfficeBuilding,
    mdiLockReset,
  },
  layout: AuthenticatedLayout,
  props: ["etudiants","tuteurs"],
  data() {
    return {
      icon: {
        mdiAccountSchool,
        mdiPlus,
        mdiPencil,
        mdiDelete,
        mdiPlusCircle,
        mdiClipboardEditOutline,
        mdiOfficeBuilding,
        mdiLockReset,
      },
      headers: [
        { title: "Matricule", align: "center", key: "matricule" },
        { title: "Nom", align: "center", key: "nom" },
        { title: "Prénom", align: "center", key: "prenom" },
        { title: "Téléphone", align: "center", key: "tel" },
        { title: "Email", align: "center", key: "mail" },
        { title: "Genre", align: "center", key: "sexe" },
        { title: "Date_Naissance", align: "center", key: "dateNaiss" },
        { title: "Actions", align: "center", key: "actions" },
      ],

      dialog: false,
      target: "",
      form: useForm({
        matricule: "",
        nom: "",
        prenom: "",
        tel: "",
        mail: "",
        sexe: "",
        dateNaiss: "",
        tuteur_id: "",
      }),
      
    };
  },
  methods: {
    create() {
      router.get(route("etudiants.create"));
    },
    editItem(item) {
      router.get(route('etudiants.edit', item.id))
    },
    deleteItem(item) {
      this.$swal({
        title: "Es-tu sûr?",
        text: "Vous ne pourrez pas revenir en arrière !",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "orange",
        cancelButtonColor: "#d33",
        confirmButtonText: "Oui, supprimez-le!",
        cancelButtonText: "Non, annulez !",
      }).then((result) => {
        if (result.isConfirmed) {
          this.form.delete(route("etudiants.destroy", item.id), {
            onFinish: () => {
              if (this.$page.props.flash?.message?.type == "error") {
                this.$swal({
                  icon: "error",
                  title: "Suppression",
                  text: this.$page.props.flash?.message?.text,
                  toast: true,
                  position: "top-end",
                  showConfirmButton: false,
                  timer: 5000,
                  timerProgressBar: true,
                });
              } else if (this.$page.props.flash?.message?.type == "success") {
                this.$swal({
                  icon: "success",
                  title: "Suppression",
                  text: this.$page.props.flash?.message?.text,
                  toast: true,
                  position: "top-end",
                  showConfirmButton: false,
                  timer: 5000,
                  timerProgressBar: true,
                });
              }
            },
          });
        }
      });
    },
  },
};
</script>
<template>
    <v-card>
        <page-toolbar :icon="icon.mdiAccountSchool">Gestion des étudiants</page-toolbar>
        <v-card-text>
            <table-component 
                :headers="headers"
                :items="etudiants">
                <template v-slot:addBtn>
                    <btn @click="goTo()"><v-icon>{{ icon.mdiPlus }}</v-icon> Ajouter</btn>
                </template>
                <template v-slot:[`item.actions`]="{ item }">
                    <v-icon size="large" color="warning" title="Modifier" class="me-2" @click="editItem(item.raw)" :icon="icon.mdiPencil">
                    </v-icon>
                    <v-icon size="large" color="red" title="Supprimer" class="me-2" @click="deleteItem(item.raw)" :icon="icon.mdiDelete">
                    </v-icon>
                </template>
            </table-component>
        </v-card-text>
    </v-card>
</template>
