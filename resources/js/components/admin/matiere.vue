<template>
  <form novalidate @submit.prevent="submitForm">
    <v-container fluid>
      <v-card variant="outlined" style="border: 2px solid #7d002c">
        <v-card-title style="color: white; background-color: #7d002c"
          >Matières</v-card-title
        >
        <v-divider></v-divider>
        <br />
        <div style="margin: 10px">
          <v-alert
            v-model="alertFirst"
            border="start"
            variant="tonal"
            closable
            close-label="Close Alert"
            color="primary"
            type="info"
            title="Note"
          >
            <li>
              Cette section vous permet de configurer les matieres enseignées dans cet
              établissement
            </li>
            <li>
              Le formulaire sera valide <strong>si et seulement si </strong>tous les
              champs obligatoires marqués par <span style="color: red">*</span> sont
              renseignés
            </li>
          </v-alert>

          <div v-if="!alertFirst" style="margin: auto; width: 50%; padding: 10px">
            <Button
              style="height: 30px"
              title="Plier la note"
              @click="onclickAlertButton('first')"
              variant="outlined"
              color="primary"
              nameButton="Relire la note"
            >
            </Button>
          </div>
        </div>

        <v-card-text style="margin: 10px">
          <v-row>
            <v-col>
              <v-switch
                v-model="importation"
                color="#004980"
                inset
                :label="'Importatation d\'un fichier pour alimenter les matières'"
              ></v-switch>
            </v-col>
            <v-col v-if="importation">
              <v-file-input
                clearable
                required
                v-model="form.fichier_matiere"
                label="File input"
                variant="solo-inverted"
              ></v-file-input>
            </v-col>
            <v-col v-if="importation"
              ><v-btn
                class="ma-2"
                outlined
                type="button"
                color="primary"
                href="../models/echantillons/fiche_echantillonage.ods"
                download
              >
                Télécharger le Model
              </v-btn></v-col
            >
          </v-row>
        </v-card-text>

        <v-card-text v-if="!importation">
          <v-row :key="matiere.id" v-for="(matiere, i) in form.matieres">
            <!-- <v-col md="2"></v-col> -->
            <v-col cols="4">
              <TextField
                label="Code matiere"
                :isRequired="true"
                placeholder="Code matiere"
                @change="verify(matiere)"
                v-model="matiere.code"
              ></TextField>
            </v-col>
            <v-col cols="4">
              <TextField
                label="Libelle matière"
                :isRequired="true"
                @update:modelValue="submitForm"
                placeholder="Libelle matiere"
                v-model="matiere.libelle"
              ></TextField>
            </v-col>
            <v-col cols="4">
              <br />

              <v-tooltip v-model="tooltipModel" v-if="form.matieres.length == 1" bottom>
                <template v-slot:activator="{ props }">
                  <Button
                    variant="outlined"
                    v-bind="props"
                    icon
                    size="large"
                    small
                    color="error"
                  >
                    <v-icon :icon="icons.mdiCloseCircle"></v-icon>
                  </Button>
                </template>
                <div style="width: 200px">
                  Ce bouton reste inactif.Vous ne pouvez supprimer que s'il y'a au moins 2
                  lignes.
                </div>
              </v-tooltip>
              <Button
                type="button"
                variant="outlined"
                v-if="form.matieres.length >= 2"
                icon
                @click="removeRow(matiere)"
                size="large"
                small
                title="Supprimer la ligne"
                color="error"
              >
                <v-icon :icon="icons.mdiCloseCircle"></v-icon>
              </Button>
            </v-col>
          </v-row>
          <v-row>
            <v-col offset-md="11" cols="4">
              <Button
                type="button"
                variant="outlined"
                @click="addRow"
                title="Ajouter une nouvelle ligne"
                icon
                size="large"
                color="primary"
              >
                <v-icon :icon="icons.mdiPlusCircle" small></v-icon>
              </Button>
            </v-col>
          </v-row>
        </v-card-text>
        <!-- <v-row class="text-center ml-3 mb-3"
          ><v-col cols="auto">
            <Button
              type="submit"
              title="Enregistrer cette étape"
              nameButton="Enregistrer"
              variant="flat"
              @click="submitForm"
              density="comfortable"
              class="text-center"
              block
              size="large"
              style="text-transform: none"
            >
            </Button> </v-col
        ></v-row> -->
      </v-card>
    </v-container>
    <br />
  </form>
</template>
<script>
import { router, useForm } from "@inertiajs/vue3";
import { mdiCloseCircle, mdiPlusCircle, mdiInformation } from "@mdi/js";
import { XlsxRead, XlsxJson } from "vue3-xlsx/dist/vue3-xlsx.cjs.prod.js";
export default {
  props: ["type"],
  components: {
    mdiPlusCircle,
    mdiCloseCircle,
    mdiInformation,
    XlsxRead,
    XlsxJson,
  },
  data: () => ({
    tooltipModel: false,
    alertFirst: true,
    alertSecond: true,
    icons: { mdiPlusCircle, mdiCloseCircle, mdiInformation },
    step: 1,
    file: null,
    importation: false,
    section: null,
    form: useForm({
      lmd: false,
      regime_evaluation: false,
      fichier_matiere: null,
      type_lmd: null,
      matieres: [],
      etablissement_section_id: null,
    }),
  }),
  // watch: {
  //   formData: {
  //     deep: true,
  //     handler(newValue) {
  //       // Émettre un événement pour mettre à jour les données du formulaire dans le composant parent
  //       this.$emit('updateFormData', newValue);
  //     },
  //   },
  // },

  // watch: {
  //   form: {
  //     deep: true,
  //     handler() {
  //       if (this.isValid()) {
  //       this.form.etablissement_section_id = this.$page.props.sections[0].sections.find(
  //         (el) => el.libelle == this.section
  //       );
  //       this.$emit("formSubmitted", this.form);
  //       // this.$swal.fire({
  //       //   title: "Réussi",
  //       //   text: "Mise à jour réussie avec succès!",
  //       //   icon: "success",
  //       //   confirmButtonText: "OK",
  //       // });
  //       // this.$swal("Enregistrement réussi avec succes!")
  //     } else {
  //       // this.$swal.fire("Le formulaire n\'est pas valide. Merci de renseigner correctement et de reessayer!")
  //       this.$swal.fire({
  //         title: "Erreur",
  //         text:
  //           "Le formulaire n'est pas valide. Merci de renseigner correctement et de reessayer!",
  //         icon: "warning",
  //         confirmButtonText: "OK",
  //       });
  //     }
  //     },
  //   },
  // },
  methods: {
    onChange(event) {
      this.file = event.target.files ? event.target.files[0] : null;
      let workbook = XLSX.readFile(this.file);
      console.log("workbook1");
      console.log(workbook);
      console.log("SheetNames");
      console.log(workbook.SheetNames);
    },
    onclickAlertButton(type) {
      if (type == "second") {
        this.alertSecond = true;
      }
      if (type == "first") this.alertFirst = true;
    },
    getSection(type) {
      console.log("type", type);
      if (type == "1") {
        return "Primaire";
      } else if (type == "2") {
        return "Secondaire";
      } else if (type == "3") {
        return "Supérieur";
      } else {
        return "Université";
      }
    },
    resetForm(check) {
      if (check) {
        this.form.matieres = [];
        this.addRow();
      }
    },
    submitForm() {
      // if (this.isValid()) {
        this.form.etablissement_section_id = this.$page.props.sections[0].sections.find(
          (el) => el.libelle == this.section
        );
        this.$emit("formSubmitted", this.form);
        // this.$swal.fire({
        //   title: "Réussi",
        //   text: "Mise à jour réussie avec succès!",
        //   icon: "success",
        //   confirmButtonText: "OK",
        // });
        // this.$swal("Enregistrement réussi avec succes!")
      // } else {
      //   // this.$swal.fire("Le formulaire n\'est pas valide. Merci de renseigner correctement et de reessayer!")
      //   this.$swal.fire({
      //     title: "Erreur",
      //     text:
      //       "Le formulaire n'est pas valide. Merci de renseigner correctement et de reessayer!",
      //     icon: "warning",
      //     confirmButtonText: "OK",
      //   });
      // }
    
    },
    // isValid() {
    //   let lmd = false;
    //   let fichier = false;
    //   let valid = false;
    //   if (this.form.lmd && this.form.type_lmd != null) {
    //     lmd = true;
    //   } else if (!this.form.lmd && this.form.type_lmd == null) {
    //     lmd = true;
    //   }
    //   if (this.importation && this.form.fichier_matiere != null) {
    //     fichier = true;
    //   } else if (
    //     !this.importation &&
    //     !this.form.matieres.find(
    //       (el) =>
    //         el.code == null ||
    //         el.libelle == null ||
    //         el.code.trim() == "" ||
    //         el.libelle.trim() == ""
    //     )
    //   ) {
    //     fichier = true;
    //   }
    //   if (lmd && fichier) {
    //     valid = true;
    //   } else {
    //     valid = false;
    //   }
    //   return valid;
    // },
    goBack() {
      router.get(route("etablissements.index"));
      console.log();
    },
    addRow() {
      // console.log("e from addrom:", e);
      // e.preventDefault();
      this.form.matieres.push({
        code: null,
        libelle: null,
        before: null,
        after: null,
      });
    },
    removeRow(id) {
      this.form.matieres = this.form.matieres.filter((el) => el !== id);
    },
    async verify(element) {
      const array = this.form.matieres.filter(
        (el) => (el.code !== null && el.code == element.code) || (element.code == '' && element.libelle =='')
      );

      if (array.length > 1) {
        this.removeRow(element);
        this.$swal("L'élément existe déjà !");
        // this.$alert.error("L'élément existe déjà !");
      }
    },
  },
  mounted() {
    this.addRow();
    this.section = this.getSection(this.type);
  },
};
</script>
