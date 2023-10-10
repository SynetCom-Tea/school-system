<template>
  <form novalidate @submit.prevent="submitForm">
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

        <v-card-text>
          <v-row style="margin-top: 3px;height: 80px;">
            <!-- <v-col md="2"></v-col> -->
            <v-col cols="4">
              <TextField
                label="Nom"
                isRequired
                placeholder="Code matiere"
                @update:modelValue="submitForm()"
                v-model="form.nom"
              ></TextField>
            </v-col>
            <v-col cols="4">
              <TextField
                label="Prénom"
                isRequired
                @update:modelValue="submitForm()"
                placeholder="Libelle matiere"
                v-model="form.prenom"
              ></TextField>
            </v-col>
            <v-col cols="4">
              <Autocomplete
                label="Sexe"
                isRequired
                @update:modelValue="submitForm()"
                v-model="form.sexe"
                :items="['Sélectionner', 'Masculin', 'Féminin']"
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
                placeholder="Code matiere"
                @update:modelValue="submitForm()"
                v-model="form.date_naissance"
              ></TextField>
            </v-col>
            <v-col cols="4">
              <TextField
                label="Lieu de naissance"
                :isRequired="true"
                @update:modelValue="submitForm()"
                placeholder="Libelle matiere"
                v-model="form.lieu_naissance"
              ></TextField>
            </v-col>
            <v-col cols="4">
              <TextField
                label="Téléphone"
                :isRequired="true"
                @update:modelValue="submitForm()"
                placeholder="Libelle matiere"
                v-model="form.telephone"
              ></TextField>
            </v-col>
        
            
          </v-row>
        </v-card-text>
      </v-card>
    </v-container>
    <br />
  </form>
</template>
<script>
// import XLSX from "xlsx/dist/xlsx.extendscript.js";
import * as XLSX from "xlsx/xlsx.mjs";
import { router, useForm } from "@inertiajs/vue3";
import { mdiCloseCircle, mdiPlusCircle, mdiInformation } from "@mdi/js";
export default {
  props: ["type","apprenant"],
  components: {
    mdiPlusCircle,
    mdiCloseCircle,
    mdiInformation,
    XLSX,
  },
  data: () => ({
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
      // await this.verify();
      await this.isValid();
      this.form.etablissement_section_id = this.$page.props.sections[0].sections.find(
        (el) => el.libelle == this.section
      );
      this.$emit("formSubmitted", this.form);
      this.$emit("apprenantFormValid", this.isValid());
    },
    async isValid() {
      let valid = false;
      if ( this.form.nom.trim() != '' &&  this.form.prenom.trim() != '' &&   this.form.lieu_naissance.trim() != '' && (this.form.sexe != null && this.form.sexe != 'Sélectionner') && (this.form.date_naissance != null && this.form.date_naissance != '')){
        valid = true;
      }
      return valid;
    },
    goBack() {
      router.get(route("etablissements.index"));
    },

    async verify() {
     
    },
  },
  mounted() {
    console.log(typeof this.apprenant, this.apprenant)
    this.section = this.getSection(this.type);
  },
};
</script>
