<template>
       <Toolbar
      styleToolbar="background-color: white;"
      :icon="icons.mdiSchool"
      :toolbarTitle="Title"
    ></Toolbar>
    <form @submit.prevent="submitForm" novalidate>
      <v-container fluid>
        <v-card variant="outlined" style="border: 2px solid #7d002c">
          <v-card-title style="color: white; background-color: #7d002c"
            >UNITE D'ENSEIGNEMENT</v-card-title
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
              title="Information"
            >
              <li>
                Cette section vous permet de configurer les unités des enseignements de cet
                établissement
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
                    label="Souhaiterez-vous importez le fichier des unités des enseignements ?"
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
                    v-model="form.fichier_ue"
                    @update:modelValue="submitForm(null)"
                    label="Charger le fichier des UES"
                    variant="solo-inverted"
                  ></v-file-input>
                </v-col>
                <v-col v-if="importation"
                  ><Button
                    class="ma-2"
                    outlined
                    type="button"
                    color="primary"
                    href="../models/echantillons/fiche_echantillonage.ods"
                    download
                  >
                    Télécharger le Model
                  </Button></v-col
                >
              </v-row>
            </v-card-text>

            <v-card-text v-if="!importation">
              <v-row disabled :key="ue.id" v-for="(ue, i) in form.ues">
                <v-col md="4">
                  <TextField
                    label="Code UE"
                    class="mt-2"
                    :isRequired="true"
                    placeholder="Code UE"
                    @change="verify(ue)"
                    v-model="ue.code"
                    @update:modelValue="submitForm(ue)"
                  ></TextField>
                </v-col>
                <v-col md="4">
                  <TextField
                    label="Nom de l'UE"
                    class="mt-2"
                    :isRequired="true"
                    placeholder="Nom de l'UE"
                    v-model="ue.libelle"
                    @update:modelValue="submitForm(ue)"
                  ></TextField>
                </v-col>
                <v-col md="1">
                  <br />
                  <Button
                    type="button"
                    variant="outlined"
                    :disabled="!(form.ues.length > 1)"
                    icon
                    @click="removeRow(ue)"
                    size="large"
                    small
                    color="error"
                  >
                    <v-icon :icon="icons.mdiCloseCircle"></v-icon>
                  </Button>
                </v-col>
              </v-row>
              <v-row>
                <v-col offset-md="8" cols="4">
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

          <v-card-actions class="justify-end">
        <v-spacer></v-spacer>
        <Button  variant="outlined" class="mb-2" style="height: 30px"  small type="button" color="red" @click="goBack">
            <v-icon :icon="icons.mdiCancel" left></v-icon> Annuler
        </Button>
        <Button  variant="outlined" class="mb-2" style="height: 30px"  small color="primary" @click="submit">
            <v-icon :icon="icons.mdiContentSave" left></v-icon> Enregistrer
        </Button>
    </v-card-actions>
        </v-card>
      </v-container>
      <!-- <v-row>
              <v-col md="5"></v-col>
              <v-col md="4">
                  <Button type="submit" title="enregistrer" color="info">
                      Enregistrer
                  </Button>
              </v-col>
          </v-row> -->
      <br />
    </form>
  </template>
  <script>
  // import XLSX from "xlsx/dist/xlsx.extendscript.js";
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import { router, useForm } from "@inertiajs/vue3";
  import { mdiCloseCircle, mdiPlusCircle, mdiInformation,mdiCancel,mdiCheckCircle, mdiContentSave} from "@mdi/js";
  import * as XLSX from "xlsx/xlsx.mjs";
  export default {
    props: ["section_id"],
    components: {
      mdiPlusCircle,
      mdiCheckCircle,
      mdiCloseCircle,
      mdiInformation,
      mdiContentSave
    },
    layout: AuthenticatedLayout,
    data: () => ({
      alertFirst: true,
      alertSecond: true,
      headers: [],
      data: [],
      contentType: ["code", "nom"],
      icons: { mdiPlusCircle, mdiCloseCircle, mdiInformation,mdiCancel,mdiContentSave },
      step: 1,
      importation: false,
      form: useForm({
        fichier_ue: null,
        ues: [],
      }),
    }),

    methods: {
        goBack() {
            router.get(route('ues.index', this.section_id))
        },
        async submit() {
            console.log('ues',this.form.ues,);
            // console.log('aaaaa',this.isValid());
            if (await this.isValid()) {

                this.form.post(route('ues.store', this.section_id), {
                    onFinish: () => {
                        this.$swal({
                            icon: 'success',
                            iconColor: '#004980',
                            color: '#004980',
                            title: 'Enregistrement',
                            text: 'Unités des enseignements est enregistré avec succès!',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                        });
                    },
                });
            }
        },
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

              console.log("headers", this.headers, "data", this.data);

              if (this.checkEntete(this.headers, this.contentType)) {
                //   console.log('bravo')
                const missingDataIndex = this.donneesManquantes(this.data);

                if (typeof missingDataIndex === "number") {
                  this.$swal.fire({
                    title: "Valider",
                    text: "Votre fichier est valide!",
                    icon: "success",
                    confirmButtonText: "OK",
                  });
                  // console.log("L'indice de la ligne manquante est:", missingDataIndex);
                } else {
                  this.form.fichier_ue = null;
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
                  console.log();
                }
              } else {
                this.form.fichier_ue = null;
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
          this.form.ues = [];
          this.addRow();
        }
      },
      async submitForm(element) {
        await this.verify(element);
        await this.isValid();
        console.log("isValid", this.isValid());
        this.form.etablissement_section_id = this.$page.props.sections.find(
          (el) => el.section == this.section
        );
        this.$emit("formSubmitted", this.form);
        this.$emit("ueFormValid", this.isValid());
      },
      isValid() {
        let fichier = false;
        let valid = false;
        if (this.importation && this.form.fichier_ue != null) {
          fichier = true;
        } else if (
          !this.importation &&
          !this.form.ues.find((el) => {
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
        console.log();
      },
      addRow() {
        this.form.ues.push({
          code: null,
          libelle: null,
          before: null,
          after: null,
        });
      },
      removeRow(id) {
        this.form.ues = this.form.ues.filter((el) => el !== id);
      },
      async verify(element) {
        if (element) {
          const array = this.form.ues.filter(
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

        computed: {

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
