<template>
<v-card>
        <page-toolbar>Nouvelle Inscription</page-toolbar>
    <v-stepper :items="['Apprenant', 'Tuteurs', 'Versement']">
  <template v-slot:item.1>
    <v-form>
    <v-row>
     <v-col>
        <v-alert
            type="info"      
            text
            >
            Informations sur le Niveau d'études
        </v-alert>
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
     <v-col>
        <v-alert
            type="info"      
            text
            >
            Informations sur l'apprenant
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
          <v-radio-group label="Genre" inline v-model="form.sexe">
            <v-radio label="Masculin" value="Masculin"></v-radio>
            <v-radio label="Féminin" value="Féminin"></v-radio>
          </v-radio-group>
        </v-col>
        </v-row>
    </v-form>
  </template>

  <template v-slot:item.2>
    <v-form>
    <v-row>
     <v-col>
        <v-alert
            type="info"       
            text
            >
            Tuteurs
        </v-alert>
    </v-col>
    </v-row>
    </v-form> 
  </template>

  <template v-slot:item.3>
    <v-form>
    <v-row>
     <v-col>
        <v-alert
            type="info"       
            text
            >
            Versements
        </v-alert>
    </v-col>
    </v-row>
    </v-form>
  </template>
</v-stepper>
</v-card>
</template>
<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, useForm } from "@inertiajs/vue3";
import { VStepper } from 'vuetify/labs/VStepper';
import {
        mdiAccountCircle,
    } from '@mdi/js'
export default {
        components: {
            VStepper,
            mdiAccountCircle,
        },
  layout: AuthenticatedLayout,
 data() {
    return {
      icon: {
        mdiAccountCircle,
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
      }),
     
    };
  },
}
</script>