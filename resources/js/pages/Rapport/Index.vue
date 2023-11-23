<script>
import { processNotesData } from '../../utils/noteProcessing.js';
import BulletinDialog from '@/components/BulletinDialog.vue';
import NoteTypeEvaluation from '@/components/Rapports/NoteTypeEvaluation.vue';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router, useForm } from "@inertiajs/vue3";
import { mdiPlus, mdiTimetable, mdiDelete, mdiPencil } from "@mdi/js";
export default {
  layout: AuthenticatedLayout,
  components: {
    BulletinDialog,
    NoteTypeEvaluation
  },
  props: ["AllClasses", "niveaux", "sectionID", "notes", "headers", "note_compositions", "note_interrogations", "note_devoir_surveilles", "note_devoirs", "note_examens"],
  data() {
    return {
      icons: {
        mdiPlus,
        mdiTimetable,
        mdiPencil,
        mdiDelete
      },
      classes: [],
      dialog: false,
      selectedApprenant: null,
      form: useForm({
        niveau: null,
        classe: null,
        date: null,
        emploi: null,
        section_id: null
      }),
    };
  },
  computed: {
    // formattedData() {
    //     if (this.sectionID === 1) {
    //         return processNotesData(this.notes);
    //     }
    //     return [];
    // },
    // formattedCompositionData() {
    //     if (this.sectionID === 2 || this.sectionID === 1) {
    //         return processNotesData(this.note_compositions);
    //     }
    //     return [];
    // },
    // formattedInterogationrData() {
    //     if (this.sectionID === 2) {
    //         return processNotesData(this.note_interrogations);
    //     }
    //     return [];
    // },
    // formattedDevoirSurveilleData() {
    //     if (this.sectionID === 2) {
    //         return processNotesData(this.note_devoir_surveilles);
    //     }
    //     return [];
    // }
    formattedData() {
        if(this.sectionID == 1){
            const apprenants = {};
            this.notes.forEach(note => {
            if (!apprenants[note.id_apprenant]) {
                apprenants[note.id_apprenant] = {
                nom_apprenant: note.nom_apprenant,
                prenom_apprenant: note.prenom_apprenant,
                moyenne: 0,
                count: 0,
                totalNotes: 0,
                };
            }

            if (!isNaN(note.note)) {
                apprenants[note.id_apprenant].totalNotes += note.note;
                apprenants[note.id_apprenant].count++;
            }

            apprenants[note.id_apprenant][note.nom_matiere] = note.note;
            });

            // Calcul de la moyenne pour chaque apprenant
            Object.values(apprenants).forEach(apprenant => {
            if (apprenant.count > 0) {
                apprenant.moyenne = (apprenant.totalNotes / apprenant.count).toFixed(2);
            }
            });

            return Object.values(apprenants);
        }
    },
    formattedCompositionData() {
        if(this.sectionID == 2 || this.sectionID == 1){

            const apprenants = {};
            this.note_compositions.forEach(note => {
            if (!apprenants[note.id_apprenant]) {
                apprenants[note.id_apprenant] = {
                nom_apprenant: note.nom_apprenant,
                prenom_apprenant: note.prenom_apprenant,
                moyenne: 0,
                count: 0,
                totalNotes: 0,
                };
            }

            if (!isNaN(note.note)) {
                apprenants[note.id_apprenant].totalNotes += note.note;
                apprenants[note.id_apprenant].count++;
            }

            apprenants[note.id_apprenant][note.nom_matiere] = note.note;
            });

            // Calcul de la moyenne pour chaque apprenant
            Object.values(apprenants).forEach(apprenant => {
            if (apprenant.count > 0) {
                apprenant.moyenne = (apprenant.totalNotes / apprenant.count).toFixed(2);
            }
            });

            return Object.values(apprenants);
        }
    },
    formattedDevoirData() {
      if(this.sectionID == 2){
        const apprenants = {};
        this.note_devoirs.forEach(note => {
        if (!apprenants[note.id_apprenant]) {
            apprenants[note.id_apprenant] = {
            nom_apprenant: note.nom_apprenant,
            prenom_apprenant: note.prenom_apprenant,
            moyenne: 0,
            count: 0,
            totalNotes: 0,
            };
        }

        if (!isNaN(note.note)) {
            apprenants[note.id_apprenant].totalNotes += note.note;
            apprenants[note.id_apprenant].count++;
        }

        apprenants[note.id_apprenant][note.nom_matiere] = note.note;
        });

        // Calcul de la moyenne pour chaque apprenant
        Object.values(apprenants).forEach(apprenant => {
        if (apprenant.count > 0) {
            apprenant.moyenne = (apprenant.totalNotes / apprenant.count).toFixed(2);
        }
        });

        return Object.values(apprenants);
      }
    },
    formattedExamenData() {
      if(this.sectionID == 2){
        const apprenants = {};
        this.note_examens.forEach(note => {
        if (!apprenants[note.id_apprenant]) {
            apprenants[note.id_apprenant] = {
            nom_apprenant: note.nom_apprenant,
            prenom_apprenant: note.prenom_apprenant,
            moyenne: 0,
            count: 0,
            totalNotes: 0,
            };
        }

        if (!isNaN(note.note)) {
            apprenants[note.id_apprenant].totalNotes += note.note;
            apprenants[note.id_apprenant].count++;
        }

        apprenants[note.id_apprenant][note.nom_matiere] = note.note;
        });

        // Calcul de la moyenne pour chaque apprenant
        Object.values(apprenants).forEach(apprenant => {
        if (apprenant.count > 0) {
            apprenant.moyenne = (apprenant.totalNotes / apprenant.count).toFixed(2);
        }
        });
        console.log('Data',apprenants);
        return Object.values(apprenants);
      }
    },
    formattedInterogationrData() {
      if(this.sectionID == 2){
          const apprenants = {};
          this.note_interrogations.forEach(note => {
          if (!apprenants[note.id_apprenant]) {
              apprenants[note.id_apprenant] = {
              nom_apprenant: note.nom_apprenant,
              prenom_apprenant: note.prenom_apprenant,
              moyenne: 0,
              count: 0,
              totalNotes: 0,
              };
          }

          if (!isNaN(note.note)) {
              apprenants[note.id_apprenant].totalNotes += note.note;
              apprenants[note.id_apprenant].count++;
          }

          apprenants[note.id_apprenant][note.nom_matiere] = note.note;
          });

          // Calcul de la moyenne pour chaque apprenant
          Object.values(apprenants).forEach(apprenant => {
          if (apprenant.count > 0) {
              apprenant.moyenne = (apprenant.totalNotes / apprenant.count).toFixed(2);
          }
          });

          return Object.values(apprenants);
      }
    },
    formattedDevoirSurveilleData() {
        if(this.sectionID == 2){
            const apprenants = {};
            this.note_devoir_surveilles.forEach(note => {
            if (!apprenants[note.id_apprenant]) {
                apprenants[note.id_apprenant] = {
                nom_apprenant: note.nom_apprenant,
                prenom_apprenant: note.prenom_apprenant,
                moyenne: 0,
                count: 0,
                totalNotes: 0,
                };
            }

            if (!isNaN(note.note)) {
                apprenants[note.id_apprenant].totalNotes += note.note;
                apprenants[note.id_apprenant].count++;
            }

            apprenants[note.id_apprenant][note.nom_matiere] = note.note;
            });

            // Calcul de la moyenne pour chaque apprenant
            Object.values(apprenants).forEach(apprenant => {
            if (apprenant.count > 0) {
                apprenant.moyenne = (apprenant.totalNotes / apprenant.count).toFixed(2);
            }
            });

            return Object.values(apprenants);
        }
    }
  },
  methods: {
    calculateAverageForApprenant(apprenant) {
      return apprenant.moyenne;
    },
    openBulletinDialog(item) {
      this.selectedApprenant = item;
      console.log(item)
      this.dialog = true;
    },
    closeBulletinDialog() {
      this.dialog = false;
      this.selectedApprenant = null;
    },
    goTo() {
      
    },
    setClasse(niveau) {
      this.form.classe = null
      this.form.emploi = null
      this.classes = this.AllClasses.filter((classe) => {
        return classe.niveau_id == niveau;
      });
    },
    setData(classe) {
      this.$inertia.replace(this.$page.url, {
        data: {
          classe: classe,
        }
      })
    },
    editItem(){

    },
    deleteItem(){

    }
  },
  mounted(){
    this.form.section_id = this.sectionID
  }
};
</script>
<template>
  <v-card>
    <Toolbar :icon="icons.mdiTimetable" toolbarTitle="Rapports des notes"></Toolbar>
    <v-card-text>
      <v-toolbar flat color="white">
        <v-toolbar-title
          style="
            font-size: 1em;
            width: 250px;
            word-wrap: break-word;
            white-space: pre-wrap;
            word-break: break-word;
          "
        >
        <v-row>
          <v-col md="4">
          <autocomplete
            label="Niveau"
            v-model="form.niveau"
            :items="niveaux"
            isRequired
            class="mt-4"
            @update:modelValue="setClasse(form.niveau)"
            item-title="libelle"
            item-value="id"
          ></autocomplete>
        </v-col>
        <v-col md="4">
          <autocomplete
            label="Classe"
            v-model="form.classe"
            :items="classes"
            :disabled="!form.niveau"
            @update:modelValue="setData(form.classe)"
            class="mt-4"
            isRequired
            item-title="libelle"
            item-value="id"
          ></autocomplete>
        </v-col>
        </v-row>
        </v-toolbar-title>
      </v-toolbar>
      <v-card >
        <v-card v-if="sectionID == 2">
          <NoteTypeEvaluation
              :data="formattedInterogationrData"
              :headers="headers"
              typeEvaluation="Notes d'interrogation des élèves par matière"
              @open="openBulletinDialog"
          />
          <NoteTypeEvaluation
              :data="formattedDevoirSurveilleData"
              :headers="headers"
              typeEvaluation="Notes de Devoir Surveillé des élèves par matière"
              @open="openBulletinDialog"
          />
        </v-card>
        <v-card v-if="sectionID == 1 || sectionID == 2">
          <NoteTypeEvaluation
              :data="formattedCompositionData"
              :headers="headers"
              typeEvaluation="Notes de composition des élèves par matière"
              @open="openBulletinDialog"
          />
        </v-card>
        <v-card v-if="sectionID == 3">
          <NoteTypeEvaluation
              :data="formattedDevoirData"
              :headers="headers"
              typeEvaluation="Notes de devoir des etudiants par matières"
              @open="openBulletinDialog"
          />
          <NoteTypeEvaluation
              :data="formattedExamenData"
              :headers="headers"
              typeEvaluation="Notes d'examen des etudiants par matière"
              @open="openBulletinDialog"
          />
        </v-card>
      </v-card>
      <BulletinDialog
            v-if="selectedApprenant !== null"
            v-model="dialog"
            :apprenant="selectedApprenant"
            @close="closeBulletinDialog"
        />
    </v-card-text>
  </v-card>
</template>