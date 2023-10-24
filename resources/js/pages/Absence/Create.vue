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
  props: ["sectionEnquestion", "filieres", "props_cycles", "cycle_filieres", "filiere_niveau_matiere_ues"],
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
        section: null,
        niveau: null,
        classe: null,
        date: null,
      }),
    };
  },
  methods: {
    // goBack() {
    //   router.get(route("emplois.index"));
    // },
    setClasse(niveau) {
        console.log(this.$page.props.classes)
      this.classes = this.$page.props.classes.filter((classe) => classe.niveau_id == niveau);
      if(this.sectionEnquestion.id == 1 || this.sectionEnquestion.id == 2){
        
      }
      if(this.sectionEnquestion.id == 3  || sectionEnquestion.id == 4){
        console.log(this.$page.props.classes[0].niveau_id, niveau)
      }
    },
    setCycle(filiere){
      this.cycles = this.$page.props.props_cycles.filter((cycle) => {
        let cf = this.$page.props.cycle_filieres.filter((c_f) => c_f.filiere_id == filiere);
        const cycleIds = cf.map((item) => item.cycle_id);
        let fnmu = this.$page.props.filiere_niveau_matiere_ues.filter((f_n_m_u) => cycleIds.includes(f_n_m_u.cycle_filiere_id));
        const niveauIds = fnmu.map((item) => item.niveau_id);
        const matiereIds = fnmu.map((item) => item.matiere_id);
        this.matieres = this.$page.props.matieres.filter((matiere) => matiereIds.includes(matiere.id))
        this.setNiveau(niveauIds);
        this.niveaux = this.$page.props.niveaux.filter((n) => niveauIds.includes(n.id));
        return cycleIds.includes(cycle.id);
      });
      console.log(this.niveaux)
    },
    setNiveau(niveauIds) {
      // Filtrer les niveaux en fonction des niveauIds
      this.niveaux = this.$page.props.niveaux.filter((n) => niveauIds.includes(n.id));
    },
    submit() {
      console.log(this.form);
      this.form.post(route("emplois.store"), {
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
                  <v-col v-if="sectionEnquestion.id == 3  || sectionEnquestion.id == 4" md="3">
                    <autocomplete
                      label="Cycle"
                      v-model="form.cycle"
                      :items="cycles"
                      :disabled="!form.filiere"
                      @update:modelValue="setCycle(form.filiere)"
                      item-title="name"
                      item-value="id"
                    ></autocomplete>
                  </v-col>
                  <v-col v-if="sectionEnquestion.id == 1 || sectionEnquestion.id == 2" md="4">
                    <autocomplete
                      label="Niveau"
                      v-model="form.niveau"
                      :items="$page.props.niveaux"
                      @update:modelValue="setClasse(form.niveau)"
                      item-title="libelle"
                      item-value="id"
                    ></autocomplete>
                  </v-col>
                  <v-col v-if="sectionEnquestion.id == 3  || sectionEnquestion.id == 4" md="3">
                    <autocomplete
                      label="Niveau"
                      v-model="form.niveau"
                      :items="niveaux"
                      :disabled="!form.cycle"
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
                      item-title="libelle"
                      item-value="id"
                    ></autocomplete>
                  </v-col>
                  <v-col>
                    
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
