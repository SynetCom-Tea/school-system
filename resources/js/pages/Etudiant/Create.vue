<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router, useForm } from "@inertiajs/vue3";
import {
  mdiAccountSchool,
  mdiEmailOutline,
  mdiCancel,
  mdiCheckCircle,
  mdiPlusCircle,
  mdiCloseCircle,
  mdiOfficeBuilding,
} from "@mdi/js";
export default {
  components: {
    mdiAccountSchool,
    mdiEmailOutline,
    mdiCancel,
    mdiCheckCircle,
    mdiPlusCircle,
    mdiCloseCircle,
    mdiOfficeBuilding,
  },
  props: ["tuteurs"],
  layout: AuthenticatedLayout,
  data() {
    return {
      icon: {
        mdiAccountSchool,
        mdiEmailOutline,
        mdiCancel,
        mdiCheckCircle,
        mdiPlusCircle,
        mdiCloseCircle,
        mdiOfficeBuilding,
      },
      form: useForm({
        matricule: "",
        nom: "",
        prenom: "",
        tel: "",
        mail: "",
        sexe: "",
        dateNaiss: "",
        tuteur_id: "",
      }),
     
    };
  },
  methods: {
    goBack() {
      router.get(route("etudiants.index"));
      console.log();
    },
    async submit() {
      const { valid } = await this.$refs.form.validate();
      if (valid) {
         this.form.post(route("etudiants.store"), {
          onFinish: () => {
            this.close();

            this.$swal({
              icon: "success",
              title: "Enregistrement",
              text: "Etudiant créé avec succès!",
              toast: true,
              position: "top-end",
              showConfirmButton: false,
              timer: 5000,
              timerProgressBar: true,
            });
          },
        });  
      }
    },
    close() {
      this.form.id = "";
      this.form.nom = "";
      this.form.prenom = "";
      this.form.mail = "";
      this.form.tel = "";
      this.form.matricule = "";
      this.form.sexe = "";
      this.form.dateNaiss = "";
      this.form.tuteur_id = "";
    },
  },
  mounted() {
    
  },
  created() {
    
  },
};
</script>
<template>
  <v-card>
    <page-toolbar :icon="icon.mdiAccountSchool"
      >Nouvel Etudiant</page-toolbar
    >
    <v-card-text>
      <v-form ref="form">
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
                  /^[a-z.-]+@[a-z.-]+\.[a-z]+$/i.test(v) ||
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
          <v-select
            label="Tuteur"
            :items="tuteurs"
            variant="outlined"
            item-value="id"
            item-title="nom1"
            v-model="form.tuteur_id"
          ></v-select>
        </v-col>
        <v-col cols="6" md="6">
          <v-radio-group label="Genre" inline v-model="form.sexe">
            <v-radio label="Masculin" value="Masculin"></v-radio>
            <v-radio label="Féminin" value="Féminin"></v-radio>
          </v-radio-group>
        </v-col>
        </v-row>
      </v-form>
    </v-card-text>
    <v-card-actions class="justify-end">
      <v-spacer></v-spacer>
      <v-btn dark small type="button" color="red" @click="goBack">
        <v-icon :icon="icon.mdiCancel" left></v-icon> Annuler
      </v-btn>
      <v-btn small color="success" @click="submit">
        <v-icon :icon="icon.mdiCheckCircle" left></v-icon> Enregistrer
      </v-btn>
    </v-card-actions>
  </v-card>
</template>