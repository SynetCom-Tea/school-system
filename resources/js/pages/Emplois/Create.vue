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
      daysOfWeek: ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"],
      form: useForm({
        seances: {},
        section: null,
        niveau: null,
        classe: null,
        date: null,
      }),
    };
  },
  methods: {
    goBack() {
      router.get(route("emplois.index"));
    },

     // AJOUTEZ CETTE MÉTHODE
    close() {
      this.$router.back(); // ou window.history.back()
    },

    setClasse(niveau) {
      this.classes = this.$page.props.classes.filter((classe) => classe.niveau_id == niveau);
      if(this.sectionEnquestion.id == 1 || this.sectionEnquestion.id == 2){
        this.matieres = this.$page.props.matieres.filter((matiere) => {
          let nm = this.$page.props.niveauMatiere.filter((nm) => nm.niveau_id == niveau);
          const matiereIds = nm.map((item) => item.matiere_id);
          return matiereIds.includes(matiere.id);
        });
      }
      if(this.sectionEnquestion.id == 3){
        console.log(this.$page.props.classes[0].niveau_id, niveau)
      }
    },
    setCycle(filiere){
      this.cycles = this.$page.props.props_cycles.filter((cycle) => {
        let cf = this.$page.props.cycle_filieres.filter((c_f) => c_f.filiere_id == filiere);
        const cycleFiliereIds = cf.map((item) => item.id);
        let fnmu = this.$page.props.filiere_niveau_matiere_ues.filter((f_n_m_u) => cycleFiliereIds.includes(f_n_m_u.cycle_filiere_id));
        const cycleIds = cf.map((item) => item.cycle_id);
        const niveauIds = fnmu.map((item) => item.niveau_id);
        const matiereIds = fnmu.map((item) => item.matiere_id);
        this.matieres = this.$page.props.matieres.filter((matiere) => matiereIds.includes(matiere.id))
        this.setNiveau(niveauIds);
        this.niveaux = this.$page.props.niveaux.filter((n) => niveauIds.includes(n.id));
        const classes = this.$page.props.classes.filter((classe) => cycleFiliereIds.includes(classe.cycle_filiere_id));
        this.classes = classes.filter((classe) => niveauIds.includes(classe.niveau_id));
        console.log()
        return cycleIds.includes(cycle.id);
      });
    },
    setNiveau(niveauIds) {
      // Filtrer les niveaux en fonction des niveauIds
      this.niveaux = this.$page.props.niveaux.filter((n) => niveauIds.includes(n.id));
    },
    addRow(day) {
      this.form.seances[day].push({
        matiere: null,
        jour: day,
        before: null,
        after: null,
        ensalle: "Non",
      });
    },
    removeRow(day, p) {
      this.form.seances[day] = this.form.seances[day].filter((seance) => seance !== p);
    },
    submit() {
      this.form.post(route("emplois.store", this.sectionEnquestion.id), {
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
        onFinish: () => {
          this.close()
          this.$swal({
            icon: 'success',
            iconColor: '#004980',
            color: '#004980',
            title: 'Enregistrement',
            text: 'Emploi crées avec succès!',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
          });
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
    this.daysOfWeek.forEach((day) => {
      this.form.seances[day] = [];
      this.addRow(day);
    });
  },
};
</script>
<template>
  <v-card>
    <Toolbar :icon="icon.mdiTimetable" toolbarTitle="Nouveau emploi"></Toolbar>
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
                  <v-col v-if="sectionEnquestion.id == 3  || sectionEnquestion.id == 4" md="5">
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
                      :items="$page.props.niveaux"
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
                  <v-col v-if="sectionEnquestion.id == 1 || sectionEnquestion.id == 2" md="3">
                    <autocomplete
                      label="Classe"
                      v-model="form.classe"
                      :items="classes"
                      :disabled="!form.niveau"
                      item-title="libelle"
                      item-value="id"
                    ></autocomplete>
                  </v-col>
                  <v-col v-if="sectionEnquestion.id == 3  || sectionEnquestion.id == 4" md="7">
                    <autocomplete
                      label="Classe"
                      v-model="form.classe"
                      :items="classes"
                      :disabled="!form.filiere"
                      item-title="libelle"
                      item-value="id"
                    ></autocomplete>
                  </v-col>
                  <v-col>
                    <date-range-picker
                      v-model="form.date"
                      @focus="handleFocusDate"
                      @update:model-value="handleDate"
                      locale="fr"
                      cancelText="Annuler"
                      selectText="Confirme"
                      :only-date="true"
                      date-picker
                      :disabled="!form.classe"
                      range
                      placeholder="Emploi du ..."
                    >
                    </date-range-picker>
                  </v-col>
                  <!-- <v-col>
                    <VueDatePicker
                      v-model="date"
                      @focus="handleFocusDate"
                      @update:model-value="handleDate"
                      locale="fr"
                      cancelText="Annuler"
                      selectText="Confirme"
                      flow="calendar"
                      date-picker
                      range
                      placeholder="Start Typing ..."
                    />
                  </v-col> -->
                </v-row>
                <br />
                <v-expansion-panels>
                  <v-expansion-panel
                    id="seanceId"
                    v-for="(day, index) in daysOfWeek"
                    :key="index"
                  >
                    <v-expansion-panel-title>
                      {{ `Les seances du ${day}` }}
                      <v-btn v-if="day !== 'Lundi'" @click="repeatHierarchically(day)">{{ `Reconduire ${day}` }}</v-btn>
                    </v-expansion-panel-title>
                    <v-expansion-panel-text>
                      <v-row
                        v-for="(seance, seanceIndex) in form.seances[day]"
                        :key="seanceIndex"
                        dense
                      >
                        <v-col md="3">
                          <VueDatePicker
                            :disabled="!form.date"
                            v-model="seance.horaire"
                            time-picker
                            range
                          />
                        </v-col>
                        <v-col md="3">
                          <autocomplete
                            dense
                            :disabled="!seance.horaire"
                            label="Matiere"
                            item-title="nom"
                            item-value="id"
                            :items="matieres"
                            v-model="seance.matiere"
                          >
                          </autocomplete>
                        </v-col>
                        <v-col md="3">
                          <v-switch
                            v-model="seance.ensalle"
                            hide-details
                            :disabled="!seance.matiere"
                            true-value="Oui"
                            false-value="Non"
                            :label="`Dans une autre salle?: ${seance.ensalle}`"
                          ></v-switch>
                        </v-col>
                        <v-col md="2">
                          <autocomplete
                            dense
                            :disabled="!seance.ensalle"
                            v-if="seance.ensalle == 'Oui'"
                            label="Salle"
                            item-title="libelle"
                            item-value="id"
                            :items="$page.props.salles"
                            chips
                            v-model="seance.salle"
                          >
                          </autocomplete>
                        </v-col>
                        <v-col md="1">
                          <v-icon
                            color="error"
                            :disabled="!(form.seances[day].length > 1)"
                            @click="removeRow(day, seance)"
                            :icon="icon.mdiCloseCircle"
                          ></v-icon>
                        </v-col>
                      </v-row>
                      <v-row dense>
                        <v-col offset-md="11" md="1">
                          <v-icon
                            color="success"
                            @click="addRow(day)"
                            :icon="icon.mdiPlusCircle"
                          ></v-icon>
                        </v-col>
                      </v-row>
                    </v-expansion-panel-text>
                  </v-expansion-panel>
                </v-expansion-panels>
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
