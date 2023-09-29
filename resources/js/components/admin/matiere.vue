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
                @update:modelValue="submitForm(null)"
                color="#004980"
                inset
                :label="'Importatation d\'un fichier pour alimenter les matières'"
              ></v-switch>
            </v-col>
            <v-col v-if="importation">
              <v-file-input
                @change="handleFileUpload"
                clearable
                required
                v-model="form.fichier_matiere"
                @update:modelValue="submitForm(null)"
                label="Charger le fichier des Matières"
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
                @update:modelValue="submitForm(matiere)"
                v-model="matiere.code"
              ></TextField>
            </v-col>
            <v-col cols="4">
              <TextField
                label="Libelle matière"
                :isRequired="true"
                @update:modelValue="submitForm(matiere)"
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
      </v-card>
    </v-container>
    <br />
  </form>
</template>
<script>
import XLSX from "xlsx/dist/xlsx.extendscript.js";
import { router, useForm } from "@inertiajs/vue3";
import { mdiCloseCircle, mdiPlusCircle, mdiInformation } from "@mdi/js";
export default {
  props: ["type"],
  components: {
    mdiPlusCircle,
    mdiCloseCircle,
    mdiInformation,
    XLSX,
  },
  data: () => ({
    tooltipModel: false,
    alertFirst: true,
    alertSecond: true,
    icons: { mdiPlusCircle, mdiCloseCircle, mdiInformation },
    step: 1,
    file: null,
    headers: [],
    data: [],
    contentType: ["code", "nom"],
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

  methods: {
    handleFileUpload(event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();

        reader.onload = (e) => {
          const data = e.target.result;

          // Utilisation de JavaScript natif pour lire le fichier Excel
          const workbook = XLSX.read(data, { type: "binary" });
          const sheet = workbook.Sheets[workbook.SheetNames[0]];

          // Convertir les données de la feuille en tableau
          const sheetData = XLSX.utils.sheet_to_json(sheet, { header: 1 });

          // La première ligne est généralement utilisée comme en-têtes de colonne
          if (sheetData.length > 0) {
            this.headers = sheetData[0];
            this.data = sheetData.slice(1);

            if (this.checkEntete(this.headers, this.contentType)) {
              const missingDataIndex = this.donneesManquantes(this.data);

              if (typeof missingDataIndex === "number") {
                this.$swal.fire({
                  title: "Valider",
                  text: "Votre fichier est valide!",
                  icon: "success",
                  confirmButtonText: "OK",
                });
              } else {
                this.form.fichier_matiere = null;
                this.submitForm(null);
                const ligne = missingDataIndex.rowIndex + 2;
                const colonne = missingDataIndex.columnIndex + 1;
                this.$swal.fire({
                  title: "Erreur",
                  text:
                    "Données manquantes à la ligne " +
                    ligne +
                    " et colonne " +
                    colonne +
                    " Veuillez corriger!",
                  icon: "warning",
                  confirmButtonText: "OK",
                });
              }
            } else {
              this.form.fichier_matiere = null;
              this.submitForm(null);
              this.$swal.fire({
                title: "Erreur",
                text:
                  "L'en-tête de ce fichier ne correspond pas à celui du fichier souhaite veuillez corriger !",
                icon: "warning",
                confirmButtonText: "OK",
              });
            }
          }
        };
        reader.readAsBinaryString(file);
      }
    },
    checkEntete(arr1, arr2) {
      if (arr1.length !== arr2.length) {
        return false;
      }
      for (let i = 0; i < arr1.length; i++) {
        if (arr1[i] !== arr2[i]) {
          return false;
        }
      }
      return true;
    },

    donneesManquantes(tableau) {
      for (let rowIndex = 0; rowIndex < tableau.length; rowIndex++) {
        const row = tableau[rowIndex];
        if (typeof row === "undefined") {
          return rowIndex; // Retourne l'indice de la ligne manquante
        }
        for (let columnIndex = 0; columnIndex < this.contentType.length; columnIndex++) {
          if (typeof row[columnIndex] === "undefined") {
            return {
              rowIndex,
              columnIndex,
            }; // Retourne l'indice de la ligne et de la colonne où les données manquent
          }
        }
      }
      return -1; // Retourne -1 si toutes les données sont présentes
    },
    onclickAlertButton(type) {
      if (type == "second") {
        this.alertSecond = true;
      }
      if (type == "first") this.alertFirst = true;
    },
    getSection(type) {
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
    async submitForm(element) {
      await this.verify(element);
      await this.isValid();
      this.form.etablissement_section_id = this.$page.props.sections[0].sections.find(
        (el) => el.libelle == this.section
      );
      this.$emit("formSubmitted", this.form);
      this.$emit("matiereFormValid", this.isValid());
    },
    async isValid() {
      let fichier = false;
      let valid = false;
      if (this.importation && this.form.fichier_matiere != null) {
        fichier = true;
      } else if (
        !this.importation &&
        !this.form.matieres.find(
          (el) =>
            el.code == null ||
            el.libelle == null ||
            el.code.trim() == "" ||
            el.libelle.trim() == ""
        )
      ) {
        fichier = true;
      }
      if (fichier) {
        valid = true;
      } else {
        valid = false;
      }
      return valid;
    },
    goBack() {
      router.get(route("etablissements.index"));
    },
    addRow() {
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
      if (element) {
        const array = this.form.matieres.filter(
          (el) =>
            (el.code !== null && el.code == element.code) ||
            (element.code == "" && element.libelle == "")
        );

        if (array.length > 1) {
          this.removeRow(element);
          this.$swal("L'élément existe déjà !");
          // this.$alert.error("L'élément existe déjà !");
        }
      }
    },
  },
  mounted() {
    this.addRow();
    this.section = this.getSection(this.type);
  },
};
</script>
