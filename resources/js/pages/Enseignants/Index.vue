<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router, useForm } from "@inertiajs/vue3";

import {
  mdiAccountSchool,
  mdiPlus,
  mdiPencil,
  mdiDelete,
  mdiPlusCircle,
  mdiClipboardEditOutline,
  mdiOfficeBuilding,
  mdiMail,
  mdiGoogleClassroom,
  mdiSchool,
  mdiCancel,
  mdiCloseCircle,
  mdiBookOpenVariant,
  mdiContentSave,
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
    mdiMail,
    mdiGoogleClassroom,
    mdiSchool,
    mdiCancel,
    mdiCloseCircle,
    mdiBookOpenVariant,
    mdiContentSave,
  },
  layout: AuthenticatedLayout,
  props: ["enseignants","matieres"],
  data() {
    return {
      icons: {
        mdiAccountSchool,
        mdiPlus,
        mdiPencil,
        mdiDelete,
        mdiPlusCircle,
        mdiClipboardEditOutline,
        mdiOfficeBuilding,
        mdiMail,
        mdiGoogleClassroom,
        mdiSchool,
        mdiCancel,
        mdiCloseCircle,
        mdiBookOpenVariant,
        mdiContentSave,
      },
      headers: [
        {
          title: "Matricule",
          align: "start",
          sortable: false,
          key: "matricule",
        },
        { title: "Nom et Prenom", align: "center", key: "NomComplet" },
        { title: "Genre", align: "center", key: "sex" },
        { title: "Date et Lieu de naissance", align: "center", key: "date_lieu_nais" },
        { title: "Téléphone", align: "center", key: "telephone" },
        { title: "Actions", align: "center", key: "actions" },
      ],
      dialog_title: "Création d'enseignant",
      dialog: false,

      form: useForm({
        id: "",
        matricule: "",
        matieres: [],
        nom: "",
        prenom: "",
        sex: "",
        date_naissance: "",
        lieu_naissance: "",
        telephone: "",
        compte: "",
        email: "",
      }),
      rules: [
        (value) => {
          if (value) return true;
          return "Ce champ est requis!";
        },
      ],
    };
  },
  methods: {
    create() {
        router.get(route('enseignants.create'))
    //   this.dialog = true;
    //   this.dialog_title = "Ajouter un enseignant";
    },
    editItem(item) {
      //   console.log("edit", item);
      this.dialog_title = "Mise à jour de l'enseignant" + " " + item.NomComplet;
      this.form.id = item.id;
      this.form.matricule = item.matricule;
      this.form.matieres=[];
      this.form.nom = item.nom;
      this.form.prenom = item.prenom;
      this.form.sex = item.sex;
      this.form.date_naissance = item.date_naissance;
      this.form.lieu_naissance = item.lieu_naissance;
      this.form.telephone = item.telephone;
      this.dialog = true;
    },
    deleteItem(item) {
      this.$swal({
        title: "Es-tu sûr?",
        text: "Vous ne pourrez pas revenir en arrière !",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#004980",
        cancelButtonColor: "#d33",
        confirmButtonText: "Oui, supprimez-le!",
        cancelButtonText: "Non, annulez !",
      }).then((result) => {
        if (result.isConfirmed) {
          this.form.delete(route("enseignants.destroy", item.id), {
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
                  iconColor: "#004980",
                  color: "#004980",
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
      if (!this.form.id && valid) {
        this.form.post(route("enseignants.store"), {
          onFinish: () => {
            //console.log(this.form)
            this.close();

            this.$swal({
              icon: "success",
              iconColor: "#004980",
              color: "#004980",
              title: "Enregistrement",
              text: "Enseignant enregistrer avec succès!",
              toast: true,
              position: "top-end",
              showConfirmButton: false,
              timer: 5000,
              timerProgressBar: true,
            });
          },
        });
      } else if (this.form.id && valid) {
        const { id, code, nom } = this.form;

        this.form.put(route("enseignants.update", this.form.id), {
          onFinish: () => {
            this.close();
            this.$swal({
              icon: "success",
              iconColor: "#004980",
              color: "#004980",
              title: "Modification",
              text: "Mise à jour effectuer avec succès!",
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
      this.form.matricule = "";
      this.form.matieres=[];
      this.form.nom = "";
      this.form.prenom = "";
      this.form.sex = "";
      this.form.date_naissance = "";
      this.form.lieu_naissance = "";
      this.form.telephone = "";
      this.form.compte = "";
      this.form.email = "";
      this.dialog = false;
    },
  },

  computed: {
        itemsmatieres() {

      let list = [];

      if (this.matieres) {
        this.matieres.forEach((element) => {
          if (element) {
            element.forEach((element2) => {
                if(element2){
                    // console.log('element',element2);
                    list.push({
                    ...element2,
                        matiere: element2.code,
                    });
                }
            })

          }
        });
      }
      return list ?? [];
    },
        Title() {
        switch (this.section_id) {
            case "1":
            return "SECTION PRIMAIRE";
            case "2":
            return "SECTION SECONDAIRE";
            case "3":
            return "SECTION SUPERIEUR";
            default:
            return "SECTION UNIVERSITAIRE";
        }
        },
    },
};
</script>
<template>
  <v-card>
    <Toolbar
      styleToolbar="background-color: white;"
      :icon="icons.mdiBookOpenVariant"
      toolbarTitle="Gestion des Enseignants"
    ></Toolbar>
    <v-dialog
      v-model="dialog"
      transition="dialog-top-transition"
      persistent
      width="900px"
    >
      <template v-slot:default="{ isActive }">
        <v-card>
          <v-toolbar dense style="background-color: #7d002c">
            <v-toolbar-title
              style="
                font-size: 1em;
                width: auto;
                word-wrap: break-word;
                white-space: pre-wrap;
                word-break: break-word;
                color: white;
              "
              ><p class="text-wrap">
                <v-icon left :icon="icons.mdiPencil"  style=" font-size: 1.5em;"></v-icon>{{ dialog_title }}
              </p>
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-icon
              :icon="icons.mdiCloseCircle"
              title="Annuler"
              size="large"
              style="margin: 10px"
              color="white"
              @click="close"
            ></v-icon>
          </v-toolbar>
          <v-card-text>
            <v-form ref="form">
              <v-row style="margin-top: 5px">
                <v-col cols="6" md="6" style="height: 80px">
                  <text-field
                    label="Matricule"
                    placeholder="Matricule"
                    v-model="form.matricule"
                    isRequired
                    class="mt-2"
                    :rules="rules"
                  ></text-field>
                </v-col>
                <v-col cols="6" md="6" style="height: 80px">
                  <text-field
                    label="Nom"
                    placeholder="Nom"
                    v-model="form.nom"
                    isRequired
                    class="mt-2"
                    :rules="rules"
                  ></text-field>
                </v-col>
                <v-col cols="6" md="6" style="height: 80px">
                  <text-field
                    label="Prénom"
                    placeholder="Prénom"
                    v-model="form.prenom"
                    isRequired
                    class="mt-2"
                    :rules="rules"
                  ></text-field>
                </v-col>
                <v-col cols="6" md="6" style="height: 90px">
                  <text-field
                    type="date"
                    class="mt-2"
                    label="Date de Naissance"
                    placeholder="Date de Naissance"
                    v-model="form.date_naissance"
                    isRequired
                    :rules="rules"
                  ></text-field>
                </v-col>
                <v-col cols="6" md="6" style="height: 80px">
                  <text-field
                    label="lieu de Naissance"
                    class="mt-2"
                    placeholder="lieu de Naissance"
                    v-model="form.lieu_naissance"
                    isRequired
                    :rules="rules"
                  ></text-field>
                </v-col>
                <v-col cols="6" md="6" style="height: 80px">
                  <Autocomplete
                    v-model="form.sex"
                    :isRequired="true"
                    itemTitle="Genre"
                    class="mt-2"
                    placeholder="Genre"
                    label="Genre"
                    :items="['Masculin', 'Féminin']"
                  >
                  </Autocomplete>
                  <!-- <text-field label="Genre" placeholder="Genre" v-model="form.sex" isRequired :rules="rules"></text-field> -->
                </v-col>
                <v-col cols="6" md="6" style="height: 80px">
                  <text-field
                    label="Téléphone"
                    placeholder="Téléphone"
                    v-model="form.telephone"
                    class="mt-2"
                    isRequired
                    :rules="rules"
                  ></text-field>
                </v-col>
                <v-col cols="6" md="6"  style="height: 80px">
                    <Autocomplete
                        v-model="form.matieres"
                        isRequired
                        itemValue="id"
                        itemTitle="matiere"
                        placeholder="Matières"
                        label="Matières"
                        multiple
                        chips
                        :items="itemsmatieres"
                        :rules="[(v) => !!v || 'Ce champ est requis!']"
                        >
                    </Autocomplete>

                </v-col>
                <v-col cols="6" md="6" v-if="form.id == ''" style="height: 80px">
                  <v-switch
                    label="Voulez vous créer un compte pour pour cet enseignant ? "
                    v-model="form.compte"
                    color="info"
                    inset
                  ></v-switch>
                  <!-- <text-field label="compte" placeholder="compte" v-model="form.compte" isRequired :rules="rules"></text-field> -->
                </v-col>
                <v-col
                  cols="6"
                  md="6"
                  v-if="form.id == '' && form.compte == true"
                  style="height: 80px"
                >
                  <text-field
                    label="email"
                    placeholder="email"
                    v-model="form.email"
                    class="mt-2"
                    isRequired
                    :rules="rules"
                  ></text-field>
                </v-col>
              </v-row>
            </v-form>
          </v-card-text>
          <v-card-actions class="justify-end">
            <v-spacer></v-spacer>
            <Button
              color="red"
              variant="outlined"
              class="mb-2"
              nameButton="Annuler"
              title="Annuler"
              style="height: 30px"
              :prependIcon="icons.mdiCancel"
              @click="close"
            ></Button>
            <Button
              variant="outlined"
              class="mb-2"
              nameButton="Enregistrer"
              title="Valider et Fermer la modale"
              style="height: 30px"
              :prependIcon="icons.mdiContentSave"
              @click="submit"
            ></Button>
          </v-card-actions>
        </v-card>
      </template>
    </v-dialog>
    <v-card-text>
      <Datatable
        titleDatatable="Liste des enseignants"
        :headers="headers"
        :items="enseignants"
        :functionOnClickAddButton="create"
      >
        <template v-slot:item.actions="{ item }">
          <v-icon
            size="small"
            class="me-2"
            title="Modifier"
            @click="editItem(item.raw)"
            :icon="icons.mdiPencil"
            color="orange"
          >
          </v-icon>
          <v-icon
            size="small"
            class="me-2"
            title="Supprimer"
            @click="deleteItem(item.raw)"
            :icon="icons.mdiDelete"
            color="red"
          >
          </v-icon>
        </template>
      </Datatable>
    </v-card-text>
  </v-card>
</template>
<style></style>
