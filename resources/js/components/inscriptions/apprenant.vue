<template>
  
    <v-container fluid>
      <v-card variant="outlined" style="border: 2px solid #7d002c">
        <v-card-title style="color: white; background-color: #7d002c"
          >Informations sur l'éléve</v-card-title
        >
        <v-divider></v-divider>
        <br />
        <div style="margin: 10px">
          <v-alert
            v-model="alertFirst"
            border="start"
            variant="tonal"
            color="primary"
            type="info"
            title="Note"
          >
            <li>
              Le formulaire sera valide <strong>si et seulement si </strong>tous les
              champs obligatoires marqués par <span style="color: red">*</span> sont
              renseignés
            </li>
          </v-alert>

          
        </div>
        <v-form @submit.prevent="submitForm" noValidate>
        <v-card-text>
          <v-row style="margin-top: 3px;height: 80px;">
            <!-- <v-col md="2"></v-col> -->
            <v-col cols="4">
              <TextField
                label="Nom"
                isRequired
                placeholder="Nom"
                @update:modelValue="submitForm()"
                v-model="form.nom"
                :rules="[(v) => !!v || 'Ce champ est requis!',(v) => /^[a-zA-Z]+$/.test(v) || 'Ce champ doit contenir uniquement des lettres']"
              ></TextField>
            </v-col>
            <v-col cols="4">
              <TextField
                label="Prénom"
                isRequired
                @update:modelValue="submitForm()"
                placeholder="Prénom"
                v-model="form.prenom"
                :rules="[(v) => !!v || 'Ce champ est requis!',(v) => /^[a-zA-Z]+$/.test(v) || 'Ce champ doit contenir uniquement des lettres']"
              ></TextField>
            </v-col>
            <v-col cols="4">
              <Autocomplete
                label="Sexe"
                isRequired
                @update:modelValue="submitForm()"
                v-model="form.sexe"
                :items="['Masculin', 'Féminin']"
                :rules="[(v) => !!v || 'Ce champ est requis!']"
              ></Autocomplete>
              <!-- <TextField
                label="Sexe"
                :isRequired="true"
                @update:modelValue="submitForm(matiere)"
                placeholder="Libelle matiere"
                v-model="libelle"
              ></TextField> -->
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="4">
              <TextField
                label="Date de naissance"
                :isRequired="true"
                type="date"
                placeholder="Date de naissance"
                @update:modelValue="submitForm()"
                v-model="form.date_naissance"
                :rules="[(v) => !!v || 'Ce champ est requis!']"
              ></TextField>
            </v-col>
            <v-col cols="4">
              <TextField
                label="Lieu de naissance"
                :isRequired="true"
                @update:modelValue="submitForm()"
                placeholder="Lieu de naissance"
                v-model="form.lieu_naissance"
                :rules="[(v) => !!v || 'Ce champ est requis!']"
              ></TextField>
            </v-col>
            <v-col cols="4">
              <TextField
                label="Téléphone"
                @update:modelValue="submitForm()"
                placeholder="Téléphone"
                v-model="form.telephone"
                :rules="[(v) => /^[+][0-9]+$/.test(v) || 'Le numéro de téléphone doit être dans le format (00227 xx xx xx xx ou xx xx xx xx)' ]"
              ></TextField>
            </v-col>
          </v-row>
        </v-card-text>
      </v-form>
      </v-card>
    </v-container>
    <br />
  
</template>
<script>
// import XLSX from "xlsx/dist/xlsx.extendscript.js";
import * as XLSX from "xlsx/xlsx.mjs";
import { router, useForm } from "@inertiajs/vue3";
import { mdiCloseCircle, mdiPlusCircle, mdiInformation } from "@mdi/js";
import { useVuelidate } from '@vuelidate/core';
import { required, alpha, minLength, maxLength, numeric } from '@vuelidate/validators';
export default {
  props: ["type","apprenant"],
 
  components: {
    mdiPlusCircle,
    mdiCloseCircle,
    mdiInformation,
    XLSX,
  },
  data: () => ({
    v$: useVuelidate(),
    tooltipModel: false,
    alertFirst: true,
    alertSecond: true,
    icons: { mdiPlusCircle, mdiCloseCircle, mdiInformation },
    step: 1,
    file: null,
    headers: [],
    data: [],
    contentType: ["code", "nom"],
    importation: false,
    section: null,
    form: useForm({
      nom: '',
      prenom: '',
      sexe: null,
      date_naissance: null,
      lieu_naissance: '',
      telephone: '',
      matieres: [],
      etablissement_section_id: null,
    }),
  }),
  validations () {
    return {
      form: {
        nom: { required, alpha},
        prenom: { required, alpha},
        sexe: { required },
        date_naissance: { required },
        lieu_naissance: { required , alpha}
      }
    }
  },

  methods: {
    onclickAlertButton(type) {
      if (type == "second") {
        this.alertSecond = true;
      }
      if (type == "first") this.alertFirst = true;
    },
    getSection(type) {
      if (type == "1") {
        return "Primaire";
      } else if (type == "2") {
        return "Secondaire";
      } else if (type == "3") {
        return "Supérieur";
      } else {
        return "Université";
      }
    },
    resetForm(check) {
      if (check) {
        this.form.matieres = [];
        this.addRow();
      }
    },
    async submitForm() {
      const v = await this.isValid();
      this.form.etablissement_section_id = this.$page.props.sections[0].sections.find(
        (el) => el.libelle == this.section
      );
      this.$emit("formSubmitted", this.form);
      this.$emit("apprenantFormValid", v);
    },
    async isValid() {
      let valid = false;
      const result = await this.v$.$validate()
      console.log('result',result);
      if (result) {
        valid = true;
      }
      return valid;
    },
    // goBack() {
    //   router.get(route("etablissements.index"));
    // },
  },
  mounted() {
    this.section = this.getSection(this.type);
  },
};
</script>
