<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import * as XLSX from "xlsx/xlsx.mjs";
import {
    router,
    useForm
} from "@inertiajs/vue3";
import {
    mdiPlus,
    mdiSchool,
    mdiAccountSchool,
    mdiCheckCircle,
    mdiCancel,
    mdiBookOpenVariant,
    mdiPlusCircle,
    mdiCloseCircle
} from '@mdi/js'
export default {
    layout: AuthenticatedLayout,
    props: ["section_id"],
    components: {
    XLSX,
  },
    data() {
        return {
            icon: {
                mdiPlus,
                mdiSchool,
                mdiAccountSchool,
                mdiCheckCircle,
                mdiCancel,
                mdiBookOpenVariant,
                mdiPlusCircle,
                mdiCloseCircle
            },

            file: null,
            headers: [],
            data: [],
            contentType: ["nom"],
            importation: false,

            form: useForm({
                donnees: [],
                fichier_matiere: null,
            }),
        }
    },
    mounted() {
        this.addRow()
    },
    methods: {

        goBack() {
            router.get(route('matieres.index', this.section_id))
        },
        addRow() {
            this.form.donnees.push({
                nom: null,
                before: null,
                after: null
            });

        },

        removeRow(p) {
            this.form.donnees = this.form.donnees.filter((product) => product !== p)
        },

        async verify(p) {
            const array = this.form.donnees.filter(el => el.nom !== null && el.nom == p.nom)
            if (array.length > 1) {
               this.removeRow(p)
                
                this.$swal({
                                icon: 'error',
                                title: 'Erreur',
                                text: 'Cette matière existe déjà!',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                            });
            } else {
                return true
            }
        },
        async submit() {
            const {
                valid
            } = await this.$refs.form.validate()
            if (valid) {

                this.form.post(route('matieres.store', this.section_id), {
                    onFinish: () => {
                        this.close()
                        this.$swal({
                            icon: 'success',
                            iconColor: '#004980',
                            color: '#004980',
                            title: 'Enregistrement',
                            text: 'Matières créées avec succès!',
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
        close() {
            this.form.reset()
        },
        // Méthodes de l'importation du fichier
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
                  title: "Validé",
                  text: "Votre fichier est valide!",
                  icon: "success",
                  confirmButtonText: "OK",
                });
              } else {
                this.form.fichier_matiere = null;
                //this.submitForm(null);
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
              //this.submitForm(null);
              this.$swal.fire({
                title: "Erreur",
                text:
                  "L'en-tête de ce fichier ne correspond pas à celui du fichier souhaité veuillez corriger !",
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
    async isValid() {
      let fichier = false;
      let valid = false;
      if (this.importation && this.form.fichier_matiere != null) {
        fichier = true;
      } else if (
        !this.importation &&
        !this.form.matieres.find(
          (el) =>
            el.nom == null ||
            el.nom.trim() == ""
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
    }
}
</script>
<template>
<v-card>
    <Toolbar :icon="icon.mdiBookOpenVariant" toolbarTitle="Création Matières"></Toolbar>
<v-alert
            border="start"
            variant="tonal"
            color="primary"
            type="info"
            title="Note"
          >
            <li>
              Cette section vous permet de renseigner les matières enseignées dans cet
              établissement
            </li>
            <li>
              Vous pouvez utiliser le formulaire ou bien importer un fichier prérempli
            </li>
          </v-alert>
    <v-card-text>
        <v-form ref="form">
            <!-- Chargement des données par importation de fichier -->
            <v-card-text>
          <v-row>
            <v-col>
              <v-switch
                v-model="importation"
                color="#004980"
                inset
                :label="'Importation d\'un fichier pour alimenter les matières'"
              ></v-switch>
            </v-col>
            <v-col v-if="importation">
              <v-file-input
                clearable
                required
                @change="handleFileUpload"
                v-model="form.fichier_matiere"
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
                Télécharger le Modèle
              </v-btn></v-col
            >
          </v-row>
        </v-card-text>
            <!-- Fin chargement -->
            <v-card-text class="mx-auto" v-if="!importation">
                <v-chip label variant="outlined" text-color="white" color="primary" class="text-md-h6 green--text">Ajout des matières</v-chip>
                <v-card outlined class="mb-md-2">
                    <v-card-text>
                        <v-row :key="donnee.id" v-for="(donnee, i) in form.donnees">
                            
                                    <v-row>
                                        <v-col md="6">
                                            <TextField label="Libellé" placeholder="Libellé" v-model="donnee.nom" isRequired :rules="[(v) => !!v || 'Ce champ est requis!', verify(donnee)]"></TextField>
                                        </v-col>

                                        <v-col md="2">
                                            <v-btn title="supprimer la matière" variant="outlined" :disabled="!(form.donnees.length > 1)" icon @click="removeRow(donnee)" fab small color="error">
                                                <v-icon :icon="icon.mdiCloseCircle"></v-icon>
                                            </v-btn>
                                        </v-col>
                                    </v-row>

                                    
                        </v-row>
                        <v-row>
                                        <v-col md="6">
                                        </v-col>
                                        <v-col md="2">
                                            <v-btn title="ajouter une matière" variant="outlined" icon @click="addRow()" fab small color="primary">
                                                <v-icon :icon="icon.mdiPlusCircle"></v-icon>
                                            </v-btn>
                                        </v-col>
                                    </v-row>
                    </v-card-text>
                </v-card>

            </v-card-text>
        </v-form>
    </v-card-text>
    <v-card-actions class="justify-end">
        <v-spacer></v-spacer>
        <v-btn dark small type="button" color="red" @click="goBack">
            <v-icon :icon="icon.mdiCancel" left></v-icon> Annuler
        </v-btn>
        <v-btn small color="primary" @click="submit">
            <v-icon :icon="icon.mdiCheckCircle" left></v-icon> Enregistrer
        </v-btn>
    </v-card-actions>
</v-card>
</template>
