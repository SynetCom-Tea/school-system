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
            //console.log(this.form)
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
    <page-toolbar :icon="icon.mdiOfficeBuilding"
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
              v-model="form.name"
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
              v-model="form.email"
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