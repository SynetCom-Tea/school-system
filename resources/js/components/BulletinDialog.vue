<template>
    <v-dialog v-model="dialog" max-width="600">
      <v-card v-if="apprenant">
        <v-card-title>
          Bulletin de {{ apprenant.nom_apprenant }} {{ apprenant.prenom_apprenant }}
        </v-card-title>
        <v-card-text>
          <div v-for="(note, matiere) in apprenant" :key="matiere">
            <p>{{ matiere }}: {{ note }}</p>
          </div>
        </v-card-text>
        <v-card-actions>
          <v-btn color="blue darken-1" text @click="closeDialog">Fermer</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </template>
  
  <script>
  export default {
    props: {
      apprenant: {
        type: Object,
        required: true
      }
    },
    data() {
      return {
        dialog: false
      };
    },
    methods: {
      closeDialog() {
        this.$emit('close');
      }
    }
  };
  </script>
  