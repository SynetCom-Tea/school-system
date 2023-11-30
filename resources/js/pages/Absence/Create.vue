<script>
import AuthenticatedLayout from "@/layouts/AuthenticatedLayout.vue";
import { router, useForm } from "@inertiajs/vue3";
import {
  mdiTimetable,
  mdiCheckCircle,
  mdiCancel,
  mdiPlusCircle,
  mdiCloseCircle,
  mdiAlertCircle,
  mdiCheck,
  mdiPencil,
  mdiMinus,
  mdiMenuDown,
} from "@mdi/js";
export default {
  props: ["sectionEnquestion", "filieres", "props_cycles", "cycle_filieres", "filiere_niveau_matiere_ues", "apprenants", "seances_mapped", "niveauxSe"],
  layout: AuthenticatedLayout,
  data() {
    return {
      icon: {
        mdiTimetable,
        mdiCancel,
        mdiCheckCircle,
        mdiPlusCircle,
        mdiCloseCircle,
        mdiAlertCircle,
        mdiCheck,
        mdiPencil,
        mdiMinus,
        mdiMenuDown,
      },
      date: null,
      niveaux: [],
      classes: [],
      matieres: [],
      cycles: [],
      activeStep: 1,
      form: useForm({
        absences: [],
        section: null,
        niveau: null,
        classe: null,
        date: null,
      }),
    };
  },
  methods: {
    // goBack() {
    //   router.get(route("absences.index"));
    // },
    setClasse(niveau) {
      // console.log(this.$page.props.classes)
      this.classes = this.$page.props.classes.filter((classe) => classe.niveau_id == niveau);
    },
    setAprenants(classe) {
      this.$inertia.replace(this.$page.url, {
        data: {
          classe: classe,
        }
      })
      console.log('seances_mapped',typeof this.seances_mapped)
    },
    setCycle(filiere){
      this.cycles = this.$page.props.props_cycles.filter((cycle) => {
        let cf = this.$page.props.cycle_filieres.filter((c_f) => c_f.filiere_id == filiere);
        const cycleFiliereIds = cf.map((item) => item.id);
        let fnmu = this.$page.props.filiere_niveau_matiere_ues.filter((f_n_m_u) => cycleFiliereIds.includes(f_n_m_u.cycle_filiere_id));
        const cycleIds = cf.map((item) => item.cycle_id);
        const niveauIds = fnmu.map((item) => item.niveau_id);
        const matiereIds = fnmu.map((item) => item.matiere_id);
        // this.matieres = this.$page.props.matieres.filter((matiere) => matiereIds.includes(matiere.id))
        this.setNiveau(niveauIds);
        this.niveaux = this.$page.props.niveauxSe.filter((n) => niveauIds.includes(n.id));
        const classes = this.$page.props.classes.filter((classe) => cycleFiliereIds.includes(classe.cycle_filiere_id));
        this.classes = classes.filter((classe) => niveauIds.includes(classe.niveau_id));
        // console.log()
        return cycleIds.includes(cycle.id);
      });
      // console.log(this.niveaux)
    },
    setNiveau(niveauIds) {
      // Filtrer les niveaux en fonction des niveauIds
      this.niveaux = this.$page.props.niveauxSe.filter((n) => niveauIds.includes(n.id));
    },
    addRow() {
      this.form.absences.push({
        seance: null,
        ensalle: "Non",
      });
    },
    removeRow(p) {
      this.form.absences = this.form.absences.filter((seance) => seance !== p);
    },
    submit() {
      console.log(this.form);
      this.form.post(route("absences.store"), {
        // onFinish: () => this.form.reset(),
        onError: (error) => {
          // Logique à exécuter en cas d'erreur
          this.$swal(
            "Oops...",
            `<ul> <li v-for"${name} in ${error}"> ${name} </li> </ul>`,
            "error"
          );
          // console.log('Erreur de requête');
          console.log(error);
        },
      });
    },
    handleDate() {
      let vh = document.getElementById("heit");
      vh.style.height = "auto";
      return vh;
    },
    handleFocusDate() {
      let vh = document.getElementById("heit");
      return (vh.style.height = "700px");
    },
    // handleDateSeance (){
    //     let vh = document.getElementById('seanceId')
    //     vh.style.height = 'auto'
    //     return  vh
    // },
    // handleFocusDateSeance(){
    //     let vh = document.getElementById('seanceId')
    //     return vh.style.height = '500px'
    // }
  },
  mounted() {
    this.form.section = this.sectionEnquestion.id
    this.addRow();
  },
};
</script>
<template>
  <v-card>
    <Toolbar :icon="icon.mdiTimetable" toolbarTitle="Ajouter des absences"></Toolbar>
    <v-card-text>
      <v-form>
        <v-row>
          <v-card-text>
            <v-chip
              label
              variant="outlined"
              text-color="white"
              color="rgb(125, 0, 44, 0.75)"
              class="text-md-h6 green--text"
              >Classe concernée</v-chip
            >
            <v-card outlined>
              <v-card-text id="heit">
                <v-row dense>
                  <v-col v-if="sectionEnquestion.id == 3  || sectionEnquestion.id == 4" md="3">
                    <autocomplete
                      label="Filière"
                      v-model="form.filiere"
                      :items="$page.props.filieres"
                      @update:modelValue="setCycle(form.filiere)"
                      item-title="name"
                      item-value="id"
                    ></autocomplete>
                  </v-col>
                  <!-- <v-col v-if="sectionEnquestion.id == 3  || sectionEnquestion.id == 4" md="3">
                    <autocomplete
                      label="Cycle"
                      v-model="form.cycle"
                      :items="cycles"
                      :disabled="!form.filiere"
                      @update:modelValue="setCycle(form.filiere)"
                      item-title="name"
                      item-value="id"
                    ></autocomplete>
                  </v-col> -->
                  <v-col v-if="sectionEnquestion.id == 1 || sectionEnquestion.id == 2" md="4">
                    <autocomplete
                      label="Niveau"
                      v-model="form.niveau"
                      :items="$page.props.niveauxSe"
                      @update:modelValue="setClasse(form.niveau)"
                      item-title="libelle"
                      item-value="id"
                    ></autocomplete>
                  </v-col>
                  <!-- <v-col v-if="sectionEnquestion.id == 3  || sectionEnquestion.id == 4" md="3">
                    <autocomplete
                      label="Niveau"
                      v-model="form.niveau"
                      :items="niveaux"
                      :disabled="!form.cycle"
                      @update:modelValue="setClasse(form.niveau)"
                      item-title="libelle"
                      item-value="id"
                    ></autocomplete>
                  </v-col> -->
                  <v-col v-if="sectionEnquestion.id == 3 || sectionEnquestion.id == 4" md="3">
                    <autocomplete
                      label="Classe"
                      v-model="form.classe"
                      :items="classes"
                      :disabled="!form.filiere"
                      @update:modelValue="setAprenants(form.classe)"
                      item-title="libelle"
                      item-value="id"
                    ></autocomplete>
                  </v-col>
                  <v-col v-if="sectionEnquestion.id == 1 || sectionEnquestion.id == 2" md="3">
                    <autocomplete
                      label="Classe"
                      v-model="form.classe"
                      :items="classes"
                      :disabled="!form.niveau"
                      @update:modelValue="setAprenants(form.classe)"
                      item-title="libelle"
                      item-value="id"
                    ></autocomplete>
                  </v-col>
                </v-row>
                <v-row
                        v-for="(absence, absenceIndex) in form.absences"
                        :key="absenceIndex"
                        dense
                      >
                      <v-col md="53">
                        <autocomplete
                          label="Apprenant"
                          v-model="absence.apprenant"
                          :items="apprenants"
                          :disabled="!form.classe"
                          item-title="nom_prenom"
                          item-value="id"
                        ></autocomplete>
                      </v-col>
                      <v-col md="3">
                        <v-switch
                          v-model="absence.ensalle"
                          hide-details
                          :disabled="!absence.apprenant"
                          true-value="Oui"
                          false-value="Non"
                          :label="`Absent toute la journée ?: ${absence.ensalle}`"
                        ></v-switch>
                      </v-col>
                      <v-col md="4">
                        <autocomplete
                          dense
                          :disabled="!absence.apprenant"
                          v-if="absence.ensalle == 'Non'"
                          label="Matiere / Heure"
                          item-title="nom_matiere_heure_debut"
                          item-value="id"
                          :items="seances_mapped"
                          v-model="absence.seance"
                        >
                        </autocomplete>
                      </v-col>
                      <v-col offset-md="11" md="1">
                        <v-icon
                          color="error"
                          :disabled="!(form.absences.length > 1)"
                          @click="removeRow(absence)"
                          :icon="icon.mdiCloseCircle"
                        ></v-icon>
                      </v-col>
                      </v-row>
                      <v-row dense>
                        <v-col offset-md="11" md="1">
                          <v-icon
                            color="success"
                            @click="addRow()"
                            :icon="icon.mdiPlusCircle"
                          ></v-icon>
                        </v-col>
                      </v-row>
              </v-card-text>
              <v-card-actions class="justify-end">
                <v-spacer></v-spacer>
                <!-- <v-btn dark small type="button" color="red" @click="goBack">
                    <v-icon :icon="icon.mdiCancel" left></v-icon> Annuler
                </v-btn> -->
                <v-btn small color="primary" @click="submit">
                    <v-icon :icon="icon.mdiCheckCircle" left></v-icon> Enregistrer
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-card-text>
        </v-row>
        <br />
      </v-form>
    </v-card-text>
  </v-card>
</template>
