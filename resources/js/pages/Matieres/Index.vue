<script>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { useForm, router } from '@inertiajs/vue3';
    import * as XLSX from "xlsx/xlsx.mjs";

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
       mdiContentSave
    } from '@mdi/js'
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
            mdiContentSave
        },
        layout: AuthenticatedLayout,
        props: ["matieres","section_id"],
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
                    mdiContentSave
                },
                headers: [
                    {
                        title: 'Code',
                        align: 'start',
                        sortable: false,
                        key: 'code',
                    },
                    { title: 'Libellé', align: 'center', key: 'nom' },
                    {title: 'Actions', align: 'center', key: 'actions'},
                ],
                dialog_title: 'Modifier la matière',
                dialog: false,

                form: useForm({
                    id : null,
                    code: '',
                    nom: '',
                }),
                file: null,
            headers1: [],
            data: [],
            contentType: ["nom"],
            importation: false,
                rules: [
                        value => {
                            if (value) return true
                            return 'Ce champ est requis!'
                        },
                ],
            }
        },
        methods:{
            create() {
                this.dialog = true;
                this.dialog_title = 'Ajouter la matière'
                // router.get(route('matieres.create', this.section_id))
            },
            editItem(item){
                console.log('edit',item)
                this.dialog_title = 'Modifier la matière '+ item.nom
                this.form.id = item.id
                this.form.code = item.code
                this.form.nom = item.nom
                this.dialog = true
            },
            deleteItem(item){
                this.$swal({
                    title: 'Es-tu sûr?',
                    text: "Vous ne pourrez pas revenir en arrière !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#004980',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, supprimez-le!',
                    cancelButtonText: 'Non, annulez !',
                    }).then((result) => {
                    if (result.isConfirmed) {

                       this.form.delete(route('matieres.destroy', item.id), {
                        onFinish: () => {
                            if(this.$page.props.flash?.message?.type == 'error'){
                                this.$swal({
                                icon: 'error',
                                title: 'Suppression',
                                text: this.$page.props.flash?.message?.text,
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                            });
                            }else if(this.$page.props.flash?.message?.type == 'success'){
                                this.$swal({
                                icon: 'success',
                                iconColor: '#004980',
                                color: '#004980',
                                title: 'Suppression',
                                text: this.$page.props.flash?.message?.text,
                                toast: true,
                                position: 'top-end',
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
            this.headers1 = sheetData[0];
            this.data = sheetData.slice(1);

            if (this.checkEntete(this.headers1, this.contentType)) {
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

            async submit() {
                const { valid } = await this.$refs.form.validate()
                if(!this.form.id && valid) {
                    this.form.post(route('matieres.store', this.section_id), {
                        onFinish: () => {
                            //console.log(this.form)
                            this.close()

                            this.$swal({
                                icon: 'success',
                                iconColor: '#004980',
                                color: '#004980',
                                title: 'Enregistrement',
                                text: 'Matière créée avec succès!',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                            });
                        },
                    });

                }else if(this.form.id && valid) {

                     const {id,code,nom} = this.form

                    this.form.put(route('matieres.update', this.form.id), {
                        onFinish: () => {
                           this.close()
                            this.$swal({
                                icon: 'success',
                                iconColor: '#004980',
                                color: '#004980',
                                title: 'Modification',
                                text: 'Matière modifiée avec succès!',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                            });
                        },
                    })
                }

            },
            close() {
                this.form.id = null
                this.form.code = ""
                this.form.nom = ""
                this.dialog = false
            }
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
    }
</script>
<template>
    <Toolbar
      styleToolbar="background-color: white;"
      :icon="icons.mdiSchool"
      :toolbarTitle="Title"
    ></Toolbar>
    <br>
    <v-card variant="outlined" style="border: 2px solid #7d002c">
        <v-card-title style="color: white; background-color: #7d002c"
            >GESTION DES MATIERES</v-card-title
          >
          <v-divider></v-divider>
        <v-dialog v-model="dialog" transition="dialog-top-transition" persistent width="700px">
                        <template v-slot:default="{ isActive }">
                <v-card>
                    <v-toolbar dense style="background-color: #7d002c">
                        <v-toolbar-title style="color:white">
                        <v-icon left :icon="icons.mdiPencil"></v-icon> {{ dialog_title }}
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-icon :icon="icons.mdiCloseCircle" title="Annuler" size="large" style="margin:10px" color="white" @click="close"></v-icon>
                    </v-toolbar>
                    <v-card-text>
                                    <v-form ref="form">
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
                                        <v-row >
                                            <v-col cols="12" md="12" v-if="form.id!=null">
                                                <text-field label="Code" placeholder="Code" v-model="form.code" isRequired :rules="rules"></text-field>

                                            </v-col>
                                        </v-row>
                                        <v-row v-if="!importation">
                                            <v-col cols="12" md="12">
                                                <text-field label="Libellé" placeholder="Libellé" v-model="form.nom" isRequired :rules="rules"></text-field>

                                            </v-col>
                                        </v-row>
                                    </v-form>
                                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-spacer></v-spacer>
                        <Button color="red" variant="outlined" class="mb-2" nameButton="Annuler" title="Annuler" style="height: 30px" :prependIcon="icons.mdiCancel" @click="close"></Button>
                        <Button variant="outlined" class="mb-2" nameButton="Enregistrer" title="Valider et Fermer la modale" style="height: 30px" :prependIcon="icons.mdiContentSave" @click="submit"></Button>
                    </v-card-actions>
                </v-card>
            </template>

                    </v-dialog>
        <v-card-text>
            <Datatable titleDatatable="Liste des matières" :headers="headers" :items="matieres" :functionOnClickAddButton="create" >

            <template v-slot:item.actions="{item}">
                <v-icon size="small" class="me-2" title="Modifier" @click="editItem(item)" :icon="icons.mdiPencil" color="orange">
                </v-icon>
                <v-icon size="small" class="me-2" title="Supprimer" @click="deleteItem(item)" :icon="icons.mdiDelete" color="red">
                </v-icon>
            </template>
        </Datatable>
        </v-card-text>
    </v-card>
</template>
<style>

</style>
