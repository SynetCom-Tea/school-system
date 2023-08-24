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
  props: ["etudiants"],
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
      }),
      
    };
  },
  methods: {
    create() {
      router.get(route("etudiants.create"));
    },
    editItem(item) {
      //console.log('edit',item)
      this.dialog_title = "Modifier l'étudiant";
      this.form.id = item.id;
      this.form.nom = item.nom;
      this.form.matricule = item.matricule;
      this.form.tel = item.tel;
      this.form.mail = item.mail;
      this.dialog = true;
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
    async submit() {
      const { valid } = await this.$refs.form.validate();
      if (valid) {
        const { id, nom, prenom,matricule,tel, email } = this.form;

        this.form.put(route("etudiants.update", this.form.id), {
          onFinish: () => {
            this.close();
            this.$swal({
              icon: "success",
              title: "Modification",
              text: " Etudiant modifié avec succès!",
              toast: true,
              position: "top-end",
              showConfirmButton: false,
              timer: 5000,
              timerProgressBar: true,
            });
          },
        });
      }
    },
    
    close() {
      this.form.id = "";
      this.form.name = "";
      this.form.prenom = "";
      this.form.mail = "";
      this.dialog = false;
      this.form.tel = "";
      this.form.matricule = "";
    },
  },
};
</script>
<template>
  <v-card>
    <page-toolbar :icon="icon.mdiOfficeBuilding"
      >Gestion des étudiants</page-toolbar
    >
    <v-dialog
      v-model="dialog"
      transition="dialog-top-transition"
      persistent
      width="500px"
    >
      <template v-slot:default="{ isActive }">
        <v-card>
          <v-toolbar dense color="orange" dark>
            <v-toolbar-title>
              <v-icon left>{{
                form.id ? icon.mdiPencil : icon.mdiPlusCircle
              }}</v-icon>
              {{ dialog_title }}
            </v-toolbar-title>
            <v-spacer></v-spacer>
          </v-toolbar>
          <v-card-text>
            <v-form ref="form">
              <v-row>
                <v-col cols="12" md="12">
                  <text-field
                    label="Matricule"
                    placeholder="Matricule"
                    v-model="form.matricule"
                    isRequired
                    :rules="[(v) => !!v || 'Ce champ est requis!']"
                  ></text-field>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" md="12">
                  <text-field
                    label="Nom"
                    placeholder="Nom"
                    v-model="form.nom"
                    isRequired
                    :rules="[(v) => !!v || 'Ce champ est requis!']"
                  ></text-field>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" md="12">
                  <text-field
                    label="Prénom"
                    placeholder="Prénom"
                    v-model="form.prenom"
                    isRequired
                    :rules="[(v) => !!v || 'Ce champ est requis!']"
                  ></text-field>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" md="12">
                  <text-field
                    label="Téléphone"
                    placeholder="Téléphone"
                    v-model="form.tel"
                    isRequired
                    :rules="[(v) => !!v || 'Ce champ est requis!']"
                  ></text-field>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" md="12">
                  <text-field
                    label="Email"
                    placeholder="Email"
                    v-model="form.mail"
                    isRequired
                    :rules="[
                      (v) => !!v || 'Ce champ est requis!',
                      (v) =>
                        /^[a-z.-]+@[a-z.-]+\.[a-z]+$/i.test(v) ||
                        'Adresse Email invalide!',
                    ]"
                  ></text-field>
                </v-col>
              </v-row>
            </v-form>
          </v-card-text>
          <v-card-actions class="justify-end">
            <v-spacer></v-spacer>
            <v-btn dark small type="button" color="red" @click="close">
              <v-icon :icon="icon.mdiCancel" left></v-icon> Annuler
            </v-btn>
            <v-btn small color="success" @click="submit">
              <v-icon :icon="icon.mdiCheckCircle" left></v-icon> Enregistrer
            </v-btn>
          </v-card-actions>
        </v-card>
      </template>
    </v-dialog>
    <v-card-text>
      <table-component :headers="headers" :items="etudiants">
        <template v-slot:addBtn>
          <btn @click="create"
            ><v-icon>{{ icon.mdiPlus }}</v-icon> Ajouter</btn
          >
        </template>
        <template v-slot:item.actions="{ item }">
          <v-icon
            size="small"
            color="warning"
            title="Modifier"
            class="me-2"
            @click="editItem(item.raw)"
            :icon="icon.mdiPencil"
          >
          </v-icon>
          <v-icon
            size="small"
            color="error"
            @click="deleteItem(item.raw)"
            :icon="icon.mdiDelete"
            class="me-2"
          >
          </v-icon>
        </template>
      </table-component>
    </v-card-text>
  </v-card>
</template>