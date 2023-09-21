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
      activeStep: 1,
      daysOfWeek: ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"],
      form: useForm({
        seances: {},
        section: null,
        niveau: null,
        classe: null,
      }),
    };
  },
  methods: {
    goBack() {
      router.get(route("emplois.index"));
    },
    setNiveau() {
      this.$inertia.replace(this.$page.url, {
        data: {
          section: this.form.section,
        },
      });
    },
    setClasse() {
      this.$inertia.replace(this.$page.url, {
        data: {
          niveau: this.form.niveau,
        },
      });
    },
    addRow(day) {
      this.form.seances[day].push({
        horaire: null,
        name: null,
        before: null,
        after: null,
      });
    },
    removeRow(day, p) {
      this.form.seances[day] = this.form.seances[day].filter((seance) => seance !== p);
    },
    submit() {
      console.log(this.form);
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
    // console.log(this.sections)
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
              >Classe concerner</v-chip
            >
            <v-card outlined>
              <v-card-text id="heit">
                <v-row dennse>
                  <v-col md="4">
                    <autocomplete
                      label="Section"
                      v-model="form.section"
                      :items="$page.props.sections"
                      :onchangeModelValue="setNiveau"
                      item-title="libelle"
                      item-value="id"
                    ></autocomplete>
                  </v-col>
                  <v-col md="4">
                    <autocomplete
                      label="Niveau"
                      v-model="form.niveau"
                      :items="$page.props.niveaux"
                      :onchangeModelValue="setClasse"
                      item-title="libelle"
                      item-value="id"
                    ></autocomplete>
                  </v-col>
                  <v-col md="4">
                    <autocomplete
                      label="Classe"
                      v-model="form.classe"
                      :items="[
                        'California',
                        'Colorado',
                        'Florida',
                        'Georgia',
                        'Texas',
                        'Wyoming',
                      ]"
                    ></autocomplete>
                  </v-col>
                  <v-col>
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
                  </v-col>
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
                    </v-expansion-panel-title>
                    <v-expansion-panel-text>
                      <v-row
                        v-for="(seance, seanceIndex) in form.seances[day]"
                        :key="seanceIndex"
                        dense
                      >
                        <v-col md="3">
                          <VueDatePicker v-model="seance.horaire" time-picker range />
                        </v-col>
                        <v-col md="3">
                          <text-field
                            density="medium"
                            dense
                            label="Matiere"
                            placeholder="Matiere"
                            v-model="seance.name"
                          ></text-field>
                        </v-col>
                        <v-col md="5">
                          <autocomplete
                            dense
                            label="Salle"
                            item-title="name"
                            item-value="id"
                            :items="fillieres"
                            multiple
                            chips
                            v-model="seance.filliere"
                          >
                          </autocomplete>
                        </v-col>
                        <v-col md="1">
                          <v-icon
                            color="error"
                            :disabled="!(form.seances[day].length > 1)"
                            @click="removeRow(seance)"
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
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn dark small type="button" color="red" @click="goBack">
                  <v-icon :icon="icon.mdiCancel" left></v-icon> Annuler
                </v-btn>
                <v-btn small color="success" @click="submit">
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
