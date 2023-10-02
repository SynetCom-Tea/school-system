<template>
  <form @submit.prevent="submitForm" novalidate>
    <v-container fluid>
      <v-card variant="outlined" style="border: 2px solid #7d002c">
        <v-card-title style="color: white; background-color: #7d002c"
          >FACULTES</v-card-title
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
              Cette section vous permet de configurer les facultes de cet établissement
            </li>
            <li>
              Le formulaire sera valide si est seulement si tous les champs obligatoires
              marqués par <span style="color: red">*</span> sont renseignés
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
        <v-divider></v-divider>
        <v-card>
          <v-card-text>
            <v-row>
              <v-col>
                <v-switch
                  label="Souhaiterez-vous importez le fichier des facultés ?"
                  v-model="importation"
                  @update:modelValue="submitForm(null)"
                  color="info"
                  inset
                ></v-switch>
              </v-col>
              <v-col v-if="importation">
                <v-file-input
                  @change="handleFileUpload"
                  clearable
                  required
                  v-model="form.fichier_faculte"
                  @update:modelValue="submitForm(null)"
                  label="Charger le fichier des facultés"
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
            <v-row disabled :key="faculte.id" v-for="(faculte, i) in form.facultes">
              <v-col md="4">
                <TextField
                  label="Code faculte"
                  class="mt-2"
                  :isRequired="true"
                  placeholder="Code faculte"
                  required
                  @change="verify(faculte)"
                  v-model="faculte.code"
                  @update:modelValue="submitForm(faculte)"
                ></TextField>
              </v-col>
              <v-col md="4">
                <TextField
                  label="Nom de la faculte"
                  class="mt-2"
                  :isRequired="true"
                  placeholder="Nom de la faculte"
                  v-model="faculte.libelle"
                  @update:modelValue="submitForm(faculte)"
                ></TextField>
              </v-col>
              <v-col md="2">
                <br />
                <Button
                  type="button"
                  variant="outlined"
                  :disabled="!(form.facultes.length > 1)"
                  icon
                  @click="removeRow(faculte)"
                  size="large"
                  small
                  color="error"
                >
                  <v-icon :icon="icons.mdiCloseCircle"></v-icon>
                </Button>
                <!-- <v-btn variant="outlined" :disabled="!(form.frais.length > 1)" icon @click="removeRow(frais)" fab small color="error">
                                <v-icon :icon="icons.mdiCloseCircle"></v-icon>
                            </v-btn> -->
              </v-col>
            </v-row>
            <v-row>
              <v-col offset-md="11" cols="4">
                <Button
                  type="button"
                  variant="outlined"
                  @click="addRow"
                  icon
                  size="large"
                  color="primary"
                >
                  <v-icon :icon="icons.mdiPlusCircle" small></v-icon>
                </Button>
              </v-col>
              <!-- <v-col offset-md="11" md="1">
                            <v-btn variant="outlined" icon @click="addRow" fab small color="blue">
                                <v-icon :icon="icons.mdiPlusCircle"></v-icon>
                            </v-btn>
                        </v-col> -->
            </v-row>
          </v-card-text>
        </v-card>
        <br />
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
                :isBlock="true"
                size="large"
                style="text-transform: none"
                >
                </Button> </v-col
            ></v-row> -->
      </v-card>
    </v-container>
  </form>
</template>
<script>
// import XLSX from "xlsx/dist/xlsx.extendscript.js";
import * as XLSX from "xlsx/xlsx.mjs";
import { router, useForm } from "@inertiajs/vue3";
import { mdiCloseCircle, mdiPlusCircle, mdiInformation } from "@mdi/js";
export default {
  props: ["type"],
  components: {
    mdiPlusCircle,
    mdiCloseCircle,
    mdiInformation,
  },
  data: () => ({
    alertFirst: true,
    alertSecond: true,
    headers: [],
    data: [],
    contentType: ["code", "nom"],
    icons: { mdiPlusCircle, mdiCloseCircle, mdiInformation },
    step: 1,
    importation: false,
    form: useForm({
      fichier_faculte: null,
      facultes: [],
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
                this.form.fichier_faculte = null;
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
              this.form.fichier_faculte = null;
              this.submitForm(null);
              this.$swal.fire({
                title: "Erreur",
                text:
                  "L'en-tête de ce fichier ne correspond pas à celui du fichier souhaite veuillez corriger !",
                icon: "warning",
                confirmButtonText: "OK",
              });
              //   alert('drapppppppp')
            }

            // Exclure la première ligne (en-têtes)
          }
        };

        reader.readAsBinaryString(file);
      }
    },

    checkEntete(arr1, arr2) {
      // Vérifie si les tableaux ont la même longueur
      if (arr1.length !== arr2.length) {
        return false;
      }

      // Compare chaque élément des tableaux
      for (let i = 0; i < arr1.length; i++) {
        if (arr1[i] !== arr2[i]) {
          return false;
        }
      }

      // Si toutes les comparaisons ont réussi, les tableaux sont égaux
      return true;
    },

    donneesManquantes(tableau) {
      for (let rowIndex = 0; rowIndex < tableau.length; rowIndex++) {
        const row = tableau[rowIndex];

        // Vérifie si la ligne n'existe pas (est undefined)
        if (typeof row === "undefined") {
          return rowIndex; // Retourne l'indice de la ligne manquante
        }

        // Parcours les éléments de la ligne
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
    formatNiveauLabel(item) {
      if (item) {
        return `${item?.code} - ${item?.libelle}`;
      }
    },
    resetForm(check) {
      if (check) {
        this.form.facultes = [];
        this.addRow();
      }
    },
    async submitForm(element) {
      await this.verify(element);
      await this.isValid();

      this.form.etablissement_section_id = this.$page.props.sections.find(
        (el) => el.section == this.section
      );
      this.$emit("formSubmitted", this.form);
      this.$emit("faculteFormValid", this.isValid());
    },
    isValid() {
      let fichier = false;
      let valid = false;

      if (this.importation && this.form.fichier_faculte != null) {
        fichier = true;
      } else if (
        !this.importation &&
        !this.form.facultes.find((el) => {
          return (
            el.code == null || el.libelle == null || el.code == "" || el.libelle == ""
          );
        })
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
      this.form.facultes.push({
        code: null,
        libelle: null,
        etablissement: this.$page.props.admin_etablissement.etablissement_id,
        before: null,
        after: null,
      });
    },
    removeRow(id) {
      this.form.facultes = this.form.facultes.filter((el) => el !== id);
    },
    async verify(element) {
      if (element) {
        const array = this.form.facultes.filter(
          (el) => el.code !== null && el.code == element.code
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
  },
};
</script>
