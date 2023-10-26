<template>
    <Toolbar
      styleToolbar="background-color: white;"
      :icon="icons.mdiSchool"
      :toolbarTitle="Title"
    ></Toolbar>
    <br>
    <form @submit.prevent="submitForm" novalidate>
      <v-container fluid>
        <v-card variant="outlined" style="border: 2px solid #7d002c">
          <v-card-title style="color: white; background-color: #7d002c"
            >Affectation de matière aux niveaux</v-card-title
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


            <v-card-text >
              <v-row disabled :key="affectation.id" v-for="(affectation, i) in form.Affectations">
                <v-col md="3">
                  <Autocomplete
                    :items="matieres"
                    variant="outlined"
                    item-value="id"
                    item-title="nom"
                    v-model="affectation.matiere_id"
                    @update:modelValue="submitForm(affectation)"
                    placeholder="Matières"
                    isRequired
                    @change="verify(affectation)"
                    label="Matières"
                    class="mt-2"
                    :rules="[(v) => !!v || 'Ce champ est requis!']"
                  >
                  </Autocomplete>
                </v-col>
                <v-col md="3">
                  <Autocomplete
                    :items="niveaux"
                    variant="outlined"
                    item-value="id"
                    item-title="libelle"
                    v-model="affectation.niveau_id"
                    @update:modelValue="submitForm(affectation)"
                    placeholder="Niveaux"
                    isRequired
                    multiple
                    ships
                    @change="verify(affectation)"
                    label="Niveaux"
                    class="mt-2"
                    :rules="[(v) => !!v || 'Ce champ est requis!']"
                  >


                  </AutoComplete>
                </v-col>
                <v-col md="2">
                  <TextField
                    label="Volume Horaire"
                    class="mt-2"
                    :isRequired="true"
                    placeholder="Volume Horaire"
                    v-model="affectation.volume_horaire"
                    @change="verify(affectation)"
                    @update:modelValue="submitForm(affectation)"
                    :rules="[(v) => !!v || 'Ce champ est requis!']"
                  ></TextField>
                </v-col>
                <v-col md="2">
                  <TextField
                    label="Coefficient"
                    class="mt-2"
                    :isRequired="true"
                    placeholder="Coefficient"
                    v-model="affectation.coefficient"
                    @change="verify(affectation)"
                    @update:modelValue="submitForm(affectation)"
                    :rules="[(v) => !!v || 'Ce champ est requis!']"
                  ></TextField>
                </v-col>
                <v-col md="1">
                  <br />
                  <Button
                    type="button"
                    variant="outlined"
                    :disabled="!(form.Affectations.length > 1)"
                    icon
                    @click="removeRow(affectation)"
                    size="large"
                    small
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
                    icon
                    size="large"
                    color="primary"
                  >
                    <v-icon :icon="icons.mdiPlusCircle" small></v-icon>
                  </Button>
                </v-col>
              </v-row>
            </v-card-text>
            <v-card-actions class="justify-end">
                <v-spacer></v-spacer>
                <v-btn dark small type="button" color="red" @click="goBack">
                    <v-icon :icon="icons.mdiCancel" left></v-icon> Annuler
                </v-btn>
                <v-btn small color="primary" @click="submit">
                    <v-icon :icon="icons.mdiCheckCircle" left></v-icon> Enregistrer
                </v-btn>
            </v-card-actions>
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
      <!-- <v-row>
              <v-col md="5"></v-col>
              <v-col md="4">
                  <v-btn type="submit" title="enregistrer" color="info">
                      Enregistrer
                  </v-btn>
              </v-col>
          </v-row> -->
      <br />
    </form>
  </template>
  <script>
  // import XLSX from "xlsx/dist/xlsx.extendscript.js";
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
  import { router, useForm } from "@inertiajs/vue3";
  import { mdiCloseCircle, mdiPlusCircle, mdiInformation,mdiCheckCircle,mdiCancel,mdiSchool } from "@mdi/js";
  export default {
    layout: AuthenticatedLayout,
    props: ["section_id", "niveaux","matieres"],
    components: {
      mdiPlusCircle,
      mdiCloseCircle,
      mdiInformation,
      mdiCheckCircle,
      mdiCancel,
      mdiSchool
    },
    data: () => ({
      alertFirst: true,
      alertSecond: true,
      headers: [],
      data: [],
      contentType: ["code", "nom"],
      icons: { mdiPlusCircle, mdiCloseCircle, mdiInformation,mdiCancel,mdiCheckCircle,mdiSchool },
      step: 1,
      importation: false,
      form: useForm({
        Affectations: [],
      }),
    }),

    methods: {
      // handleFileUpload(event) {
      //   const file = event.target.files[0];
      //   if (file) {
      //     const reader = new FileReader();

      //     reader.onload = (e) => {
      //       const data = e.target.result;

      //       // Utilisation de JavaScript natif pour lire le fichier Excel
      //       const workbook = XLSX.read(data, { type: "binary" });
      //       const sheet = workbook.Sheets[workbook.SheetNames[0]];

      //       // Convertir les données de la feuille en tableau
      //       const sheetData = XLSX.utils.sheet_to_json(sheet, { header: 1 });

      //       // La première ligne est généralement utilisée comme en-têtes de colonne
      //       if (sheetData.length > 0) {
      //         this.headers = sheetData[0];
      //         this.data = sheetData.slice(1);

      //         console.log("headers", this.headers, "data", this.data);

      //         if (this.checkEntete(this.headers, this.contentType)) {
      //           //   console.log('bravo')
      //           const missingDataIndex = this.donneesManquantes(this.data);

      //           if (typeof missingDataIndex === "number") {
      //             this.$swal.fire({
      //               title: "Valider",
      //               text: "Votre fichier est valide!",
      //               icon: "success",
      //               confirmButtonText: "OK",
      //             });
      //             // console.log("L'indice de la ligne manquante est:", missingDataIndex);
      //           } else {
      //             this.form.fichier_ue = null;
      //             this.submitForm(null);
      //             const ligne = missingDataIndex.rowIndex + 2;
      //             const colonne = missingDataIndex.columnIndex + 1;
      //             this.$swal.fire({
      //               title: "Erreur",
      //               text:
      //                 "Données manquantes à la ligne " +
      //                 ligne +
      //                 " et colonne " +
      //                 colonne +
      //                 " Veuillez corriger!",
      //               icon: "warning",
      //               confirmButtonText: "OK",
      //             });
      //             console.log();
      //           }
      //         } else {
      //           this.form.fichier_ue = null;
      //           this.submitForm(null);
      //           this.$swal.fire({
      //             title: "Erreur",
      //             text:
      //               "L'en-tête de ce fichier ne correspond pas à celui du fichier souhaite veuillez corriger !",
      //             icon: "warning",
      //             confirmButtonText: "OK",
      //           });
      //           //   alert('drapppppppp')
      //         }

      //         // Exclure la première ligne (en-têtes)
      //       }
      //     };

      //     reader.readAsBinaryString(file);
      //   }
      // },

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
          this.form.Affectations = [];
          this.addRow();
        }
      },
      async submit() {

            if (await this.isValid()) {

                this.form.post(route('affectations.store',this.section_id), {
                    onFinish: () => {
                        // this.close()
                        // this.$swal({
                        //     icon: 'success',
                        //     iconColor: '#004980',
                        //     color: '#004980',
                        //     title: 'Enregistrement',
                        //     text: 'La matière a été affectée aux niveaux avec succès!',
                        //     toast: true,
                        //     position: 'top-end',
                        //     showConfirmButton: false,
                        //     timer: 5000,
                        //     timerProgressBar: true,
                        // });
                    },
                });
            }
        },
        close() {
            this.form.reset()
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
          !this.form.Affectations.find((el) => {
            return (
              el.matiere_id == null || el.matiere_id == null || el.niveau_id == "" || el.niveau_id == "" || el.volume_horaire == "" || el.volume_horaire == ""|| el.coefficient == "" || el.coefficient == ""
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
            router.get(route('affectations.index', this.section_id))
        },
      addRow() {
        this.form.Affectations.push({
            volume_horaire: '',
            coefficient: '',
            niveau_id: [],
            matiere_id: '',
            before: null,
            after: null
        });
      },
      removeRow(id) {
        this.form.Affectations = this.form.Affectations.filter((el) => el !== id);
      },
      async verify(element) {
        if (element) {
          const array = this.form.Affectations.filter(
            (el) => el.matiere_id !== null && el.matiere_id == element.matiere_id
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
    }
  };
  </script>
