<template>
  <AuthenticatedLayout>
    <Toolbar
      styleToolbar="background-color: white;"
      :icon="icons.mdiAccountSchool"
      toolbarTitle="Nouvelle Inscription"
    ></Toolbar>
    <v-card>
      <!-- <v-stepper :items="['Apprenant', 'Documents', 'Tuteurs', 'Versements']">
      <template v-slot:item.1>
        <v-form>
          <v-row>
            <v-col>
              <v-alert type="info" text> Informations générales </v-alert>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="6" md="6">
              <v-select
                label="Section"
                :items="sections"
                variant="outlined"
                item-value="id"
                item-title="nom"
                v-model="form.section_id"
              ></v-select>
            </v-col>
            <v-col cols="6" md="6">
              <v-select
                label="Niveau"
                :items="niveaux"
                variant="outlined"
                item-value="id"
                item-title="nom"
                v-model="form.niveau_id"
              ></v-select>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="6" md="6">
              <v-radio-group
                label="L'apprenant, existe t-il déjà?"
                inline
                v-model="form.apExist"
              >
                <v-radio label="Oui" value="1"></v-radio>
                <v-radio label="Non" value="2"></v-radio>
              </v-radio-group>
            </v-col>
          </v-row>
          <div v-if="form.apExist == '2'">
            <v-row>
              <v-col>
                <v-alert color="info" :icon="icon.mdiAccountSchool" text>
                  Informations de l'apprenant
                </v-alert>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="4" md="4">
                <text-field
                  label="Matricule"
                  placeholder="Matricule"
                  v-model="form.matricule"
                  isRequired
                  :rules="[(v) => !!v || 'Ce champ est requis!']"
                ></text-field>
              </v-col>
              <v-col cols="4" md="4">
                <text-field
                  label="Nom"
                  placeholder="Nom"
                  v-model="form.nom"
                  isRequired
                  :rules="[(v) => !!v || 'Ce champ est requis!']"
                ></text-field>
              </v-col>
              <v-col cols="4" md="4">
                <text-field
                  label="Prénom"
                  placeholder="Prénom"
                  v-model="form.prenom"
                  isRequired
                  :rules="[(v) => !!v || 'Ce champ est requis!']"
                ></text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="4" md="4">
                <text-field
                  label="Email"
                  placeholder="Email"
                  v-model="form.mail"
                  isRequired
                  :rules="[
                    (v) => !!v || 'Ce champ est requis!',
                    (v) =>
                      /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
                      'Adresse Email invalide!',
                  ]"
                ></text-field>
              </v-col>
              <v-col cols="4" md="4">
                <text-field
                  label="Téléphone"
                  placeholder="Téléphone"
                  v-model="form.tel"
                  isRequired
                  :rules="[(v) => !!v || 'Ce champ est requis!']"
                ></text-field>
              </v-col>
              <v-col cols="4" md="4">
                <text-field
                  type="date"
                  label="DateNaissance"
                  placeholder="DateNaissance"
                  v-model="form.dateNaiss"
                  isRequired
                  :rules="[(v) => !!v || 'Ce champ est requis!']"
                ></text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="6" md="6">
                <v-radio-group label="Genre" inline v-model="form.sexe">
                  <v-radio label="Masculin" value="Masculin"></v-radio>
                  <v-radio label="Féminin" value="Féminin"></v-radio>
                </v-radio-group>
              </v-col>
            </v-row>
          </div>
        </v-form>
      </template>

      <template v-slot:item.2>
        <v-form>
          <v-row>
            <v-col>
              <v-alert color="info" :icon="icon.mdiCurrencyUsd" text> Documents </v-alert>
            </v-col>
          </v-row>
        </v-form>
      </template>

      <template v-slot:item.3>
        <v-form>
          <v-row>
            <v-col>
              <v-alert color="info" :icon="icon.mdiAccountCircle" text> Tuteurs </v-alert>
            </v-col>
          </v-row>
          <v-card-text :key="tuteur.id" v-for="(tuteur, i) in form.tuteurs">
            <v-chip
              label
              text-color="white"
              color="primary"
              class="text-md-h6 green--text"
              >Tuteur {{ i + 1 }}</v-chip
            >
            <v-card outlined class="mb-md-2">
              <v-card-text>
                <v-row>
                  <v-col md="5">
                    <text-field
                      label="Nom"
                      placeholder="Nom"
                      v-model="tuteur.nom"
                    ></text-field>
                  </v-col>
                  <v-col md="5">
                    <text-field
                      label="Prénom"
                      placeholder="Prénom"
                      v-model="tuteur.prenom"
                    ></text-field>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col md="5">
                    <text-field
                      label="Téléphone"
                      placeholder="Téléphone"
                      v-model="tuteur.tel"
                    ></text-field>
                  </v-col>
                  <v-col md="5">
                    <text-field
                      label="Adresse"
                      placeholder="Adresse"
                      v-model="tuteur.adresse"
                    ></text-field>
                  </v-col>
                  <v-col md="1">
                    <v-btn
                      variant="outlined"
                      :disabled="!(form.tuteurs.length > 1)"
                      icon
                      @click="removeRow(tuteur)"
                      fab
                      small
                      color="error"
                    >
                      <v-icon :icon="icon.mdiClose"></v-icon>
                    </v-btn>
                  </v-col>
                </v-row>
              </v-card-text>
            </v-card>
          </v-card-text>
          <v-row>
            <v-col md="10"> </v-col>
            <v-col offset-md="11" md="1">
              <v-btn
                variant="outlined"
                icon
                @click="addRow()"
                :disabled="!(form.tuteurs.length < 3)"
                fab
                small
                color="info"
              >
                <v-icon :icon="icon.mdiPlus"></v-icon>
              </v-btn>
            </v-col>
          </v-row>
        </v-form>
      </template>

      <template v-slot:item.4>
        <v-form>
          <v-row>
            <v-col>
              <v-alert color="info" :icon="icon.mdiCurrencyUsd" text>
                Versements
              </v-alert>
            </v-col>
          </v-row>
        </v-form>
      </template>
    </v-stepper> -->
    </v-card>
  </AuthenticatedLayout>
</template>
<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router, useForm } from "@inertiajs/vue3";

import {
  mdiAccountCircle,
  mdiAccountSchool,
  mdiCurrencyUsd,
  mdiPlus,
  mdiClose,
} from "@mdi/js";
export default {
  components: {
    AuthenticatedLayout,
    mdiAccountCircle,
    mdiAccountSchool,
    mdiCurrencyUsd,
    mdiPlus,
    mdiClose,
  },
  //*403#
  // layout: AuthenticatedLayout,
  data() {
    return {
      icons: {
        mdiAccountCircle,
        mdiAccountSchool,
        mdiCurrencyUsd,
        mdiPlus,
        mdiClose,
      },
      form: useForm({
        matricule: "",
        nom: "",
        prenom: "",
        tel: "",
        mail: "",
        sexe: "",
        dateNaiss: "",
        section_id: "",
        niveau_id: "",
        apExist: "",
        tuteurs: [],
      }),
    };
  },
  methods: {
    addRow() {
      this.form.tuteurs.push({
        nom: null,
        prenom: null,
        tel: null,
        adresse: null,
        before: null,
        after: null,
      });
    },
    removeRow(p) {
      this.form.tuteurs = this.form.tuteurs.filter((product) => product !== p);
    },
  },
  mounted() {
    this.addRow();
  },
};
</script>
