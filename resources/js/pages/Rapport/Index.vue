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
  props: ["check", "AllClasses", "types", "niveaux", "sectionID", "notes", "headers", "note_compositions", "note_interrogations", "note_devoir_surveilles", "note_devoirs", "note_examens", "periodes","filieres", "cycle_filieres"],
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
        type_evaluation: null,
        filiere: null,
        periode: null,
        section_id: null
      }),
    };
  },
  computed: {
    formattedData() {
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
    },
  },
  methods: {
    openBulletinDialog(item) {
      this.selectedApprenant = item;
      console.log(item)
      this.dialog = true;
    },
    closeBulletinDialog() {
      this.dialog = false;
      this.selectedApprenant = null;
    },
    setClasse(niveau) {
      if(this.sectionID == 1 || this.sectionID == 2){
          this.classes = this.AllClasses.filter((classe) => {
          return classe.niveau_id == niveau;
        });
      }else if(this.sectionID == 3){
        let cf = this.$page.props.cycle_filieres.filter((c_f) => c_f.filiere_id == niveau);
        console.log(cf)
        const cycleFiliereIds = cf.map((item) => item.id);
        this.classes = this.$page.props.AllClasses.filter((classe) => cycleFiliereIds.includes(classe.cycle_filiere_id));
      }
    },
    setData(classe) {
      this.$inertia.replace(this.$page.url, {
        data: {
          classe: classe,
        }
      })
    },
    async show(){
      this.$inertia.replace(this.$page.url, {
        data: {
          section_id: this.sectionID,
          classe: this.form.classe,
          periode: this.form.periode, 
          type_evaluation: this.form.type_evaluation,
        }
      })
    },
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
        <v-row v-if="sectionID == 1 || sectionID == 2">
          <v-col md="3">
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
        <v-col md="3">
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
        <v-col cols="2">
            <autocomplete 
                class="mt-4" 
                v-model="form.periode" 
                label="Periodes" 
                itemTitle="libelle" 
                itemValue="id"
                :items="periodes" variant="outlined" :isRequired="true" :disabled="!form.classe" chips clearable>
            </autocomplete>
          </v-col>
        <v-col cols="3">
          <autocomplete chips class="mt-4" label="Type Evaluation" variant="outlined" item-title="libelle" item-value="libelle" :items="types" v-model="form.type_evaluation" clearable :isRequired="true">
          </autocomplete>
        </v-col>
        <v-col md="1">
            <v-btn
            class="mt-4"
            :append-icon="icons.mdiTimerSync"
            color="deep-purple-accent-4"
            @click="show()"
            :disabled="!form.type_evaluation"
            >
            Voir
            </v-btn>
        </v-col>
        </v-row>
        <v-row v-if="sectionID == 3">
          <v-col md="3">
            <autocomplete
                label="Filière"
                v-model="form.filiere"
                class="mt-4"
                :items="$page.props.filieres"
                @update:modelValue="setClasse(form.filiere)"
                item-title="code"
                item-value="id"
            ></autocomplete>
        </v-col>
        <v-col md="4" v-if="form.filiere">
            <autocomplete
            label="Classe"
            v-model="form.classe"
            :items="classes"
            class="mt-4"
            @update:modelValue="setData(form.classe)"
            isRequired
            item-title="libelle"
            item-value="id"
            ></autocomplete>
        </v-col>
        <v-col cols="2">
            <autocomplete 
                class="mt-4" 
                v-model="form.periode" 
                label="Periodes" 
                itemTitle="libelle" 
                itemValue="id" 
                :items="periodes" variant="outlined" :isRequired="true" :disabled="!form.classe" chips clearable>
            </autocomplete>
        </v-col>
          <v-col cols="2">
            <autocomplete chips class="mt-4" label="Type Evaluation" variant="outlined" item-title="libelle" item-value="libelle" :items="types" v-model="form.type_evaluation" clearable :isRequired="true">
            </autocomplete>
          </v-col>
          <v-col md="1">
              <v-btn
              class="mt-4"
              :append-icon="icons.mdiTimerSync"
              color="deep-purple-accent-4"
              @click="show()"
              :disabled="!form.type_evaluation"
              >
              Voir
              </v-btn>
          </v-col>
        </v-row>
        </v-toolbar-title>
      </v-toolbar>
      <v-card>
        <NoteTypeEvaluation
          v-if="form.type_evaluation != null"
          :data="formattedData"
          :headers="headers"
          :typeEvaluation="`Notes de ${ form.type_evaluation } des élèves par matière`"
          @open="openBulletinDialog"
        />
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