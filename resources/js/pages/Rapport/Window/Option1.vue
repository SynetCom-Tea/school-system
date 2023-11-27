<script>
import DetailBulletin from '@/components/Rapports/DetailBulletin.vue';
import { mdiDatabaseSync, mdiTimerSync, mdiPrinter, mdiAccountFileTextOutline, mdiCloseCircle, mdiEye, mdiRepeat, mdiChartDonut, mdiRepeatVariant } from "@mdi/js";
  export default {
    props: ["sectionID", "resultats", "periodes", "filieres", "cycle_filieres"],
    components: {
        DetailBulletin
    },
    data: () => ({
      // Your existing data properties go here
    }),
    methods: {
      // Your existing methods go here
    },
  };
  </script>
  
<template>
    <v-card class="d-flex justify-center align-center">
      <v-card-text>
        <v-row v-if="sectionID == 3 || sectionID == 4">
          <v-col md="5">
            <autocomplete
              label="Filière"
              v-model="filiere"
              class="mt-4"
              :items="$page.props.filieres"
              @update:modelValue="setClasse(filiere)"
              item-title="code"
              item-value="id"
            ></autocomplete>
          </v-col>
          <v-col md="3" v-if="filiere">
            <autocomplete
              label="Classe"
              v-model="classe"
              :items="classes"
              class="mt-4"
              isRequired
              item-title="libelle"
              item-value="id"
            ></autocomplete>
          </v-col>
          <v-col cols="2">
            <autocomplete 
              class="mt-4" 
              v-model="periode" 
              label="Periodes" 
              itemTitle="libelle" 
              itemValue="id" 
              :items="periodes" 
              variant="outlined" 
              :isRequired="true" 
              :disabled="!classe" 
              chips 
              clearable
            ></autocomplete>
          </v-col>
          <v-col md="2">
            <v-btn
              class="mt-4"
              :append-icon="icons.mdiTimerSync"
              color="deep-purple-accent-4"
              @click="generate()"
              :disabled="!periode"
            >
              Générer
            </v-btn>
          </v-col>
        </v-row>
        <v-row v-if="sectionID == 1 || sectionID == 2">
          <v-col cols="4">
            <autocomplete 
              class="mt-4" 
              v-model="periode" 
              label="Periodes"
              itemTitle="libelle" 
              itemValue="id" 
              :items="periodes" 
              variant="outlined" 
              :isRequired="true" 
              chips 
              clearable
            ></autocomplete>
          </v-col>
          <v-col md="4">
            <autocomplete
              label="Classe"
              v-model="classe"
              :items="classes"
              :disabled="!periode"
              class="mt-4"
              isRequired
              item-title="libelle"
              item-value="id"
            ></autocomplete>
          </v-col>
          <v-col md="4">
            <v-btn
              class="mt-4"
              :append-icon="icons.mdiTimerSync"
              color="deep-purple-accent-4"
              @click="generate"
              :disabled="!periode"
            >
              Générer
            </v-btn>
          </v-col>
        </v-row>
        <Datatable v-if="classes.length !== 0 && (sectionID == 1)" titleDatatable="Liste des élèves" :headers="headers" :items="data" :displayAddButton="false" >
            <template v-slot:item.actions="{item}">
                <a :href="route('bulletin', { type: 0, id: item.id, section: sectionID })" target="__blank">
                    <v-icon size="small" class="me-2" title="Imprimer" :icon="icons.mdiPrinter" color="info"></v-icon>
                </a>
                <v-icon size="small" class="me-2" title="Detail" @click="openBulletinDialog(item)" :icon="icons.mdiEye" color="info">
                </v-icon>
            </template>
        </Datatable>
        <Datatable v-if="classes.length !== 0 && (sectionID == 2)" titleDatatable="Liste des élèves" :headers="headersSecondaire" :items="data" :displayAddButton="false" >
            <template v-slot:item.actions="{item}">
                <a :href="route('bulletin', { type: 0, id: item.id, section: sectionID })" target="__blank">
                    <v-icon size="small" class="me-2" title="Imprimer" :icon="icons.mdiPrinter" color="info"></v-icon>
                </a>
                <v-icon size="small" class="me-2" title="Detail" @click="openBulletinDialog(item)" :icon="icons.mdiEye" color="info">
                </v-icon>
            </template>
        </Datatable>
        <Datatable v-if="classes.length !== 0 && (sectionID == 3)" titleDatatable="Liste des etudiants" :headers="headersSup" :items="data" :displayAddButton="false" >
            <template v-slot:item.actions="{item}">
                <a :href="route('bulletin', { type: 0, id: item.id, section: sectionID })" target="__blank">
                    <v-icon size="small" class="me-2" title="Imprimer" :icon="icons.mdiPrinter" color="info"></v-icon>
                </a>
                <v-icon size="small" class="me-2" title="Detail" @click="openBulletinDialog(item)" :icon="icons.mdiEye" color="info">
                </v-icon>
            </template>
        </Datatable>
      </v-card-text>
    </v-card>
  </template>

