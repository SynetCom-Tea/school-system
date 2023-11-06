<template>
    <Toolbar
      styleToolbar="background-color: white;"
      :icon="icons.mdiSchool"
      :toolbarTitle="Title"
    ></Toolbar>
    <v-card variant="outlined" style="border: 2px solid #7d002c">
        <v-card-title style="color: white; background-color: #7d002c">Parametrage</v-card-title>
        <v-divider></v-divider>
        <div style="margin: 10px">
            <v-alert v-model="alertFirst" border="start" variant="tonal" closable close-label="Close Alert" color="primary" type="info" title="Note">
                <li>
                    Cette section vous permet de configurer les matieres enseignées dans cet
                    établissement
                </li>
                <li>
                    Le formulaire sera valide <strong>si et seulement si </strong>tous les
                    champs obligatoires marqués par <span style="color: red">*</span> sont
                    renseignés
                </li>
            </v-alert>

            <div v-if="!alertFirst" style="margin: auto; width: 50%; padding: 10px">
                <Button style="height: 30px" title="Plier la note" @click="onclickAlertButton('first')" variant="outlined" color="primary" nameButton="Relire la note">
                </Button>
            </div>
        </div>
        <v-expansion-panels>
            <v-expansion-panel>
                <v-expansion-panel-title>
                    <template v-slot:default="{ expanded }">
                        <v-row no-gutters>
                            <v-col cols="4" class="d-flex justify-start">
                                Cocher les&nbsp;<span style="font-size: 15px; color: blue;">TYPES DE FRAIS</span>&nbsp;que vous utilisiez
                            </v-col>
                            <v-col
                                cols="8"
                                class="text-grey"
                            >
                                <v-fade-transition leave-absolute>
                                    <span
                                        v-if="expanded"
                                        key="0"
                                    >
                                        Cocher les types de frais
                                    </span>
                                    <span
                                        v-else
                                        key="1"
                                    >
                                        {{ trip.name }}
                                    </span>
                                </v-fade-transition>
                            </v-col>
                        </v-row>
                    </template>
                </v-expansion-panel-title>
                <v-expansion-panel-text>
                    <v-text-field
                        v-model="trip.name"
                        hide-details
                        placeholder="Caribbean Cruise"
                    ></v-text-field>
                </v-expansion-panel-text>
            </v-expansion-panel>

        <!-- **************************** fin type frais ************************** -->

            <v-expansion-panel>
                <v-expansion-panel-title v-slot="{ open }">
                    <v-row no-gutters>
                        <v-col cols="4" class="d-flex justify-start">
                            Cocher les&nbsp;<span style="font-size: 15px; color: blue;">TYPES DE DOCUMENTS</span>&nbsp;que vous utilisiez
                        </v-col>
                        <v-col
                        cols="8"
                        class="text--secondary"
                        >
                            <v-fade-transition leave-absolute>
                                <span
                                v-if="open"
                                key="0"
                                >
                                Cocher les types de documents
                                </span>
                                <span
                                v-else
                                key="1"
                                >
                                {{ trip.location }}
                                </span>
                            </v-fade-transition>
                        </v-col>
                    </v-row>
                </v-expansion-panel-title>
                <v-expansion-panel-text>
                <v-row no-gutters>
                    <v-spacer></v-spacer>
                    <v-col cols="5">
                    <v-select
                        v-model="trip.location"
                        :items="locations"
                        chips
                        flat
                        variant="solo"
                    ></v-select>
                    </v-col>
        
                    <v-divider
                    vertical
                    class="mx-4"
                    ></v-divider>
        
                    <v-col cols="3">
                    Select your destination of choice
                    <br>
                    <a href="#">Learn more</a>
                    </v-col>
                </v-row>
        
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                    variant="text"
                    color="secondary"
                    >
                    Cancel
                    </v-btn>
                    <v-btn
                    variant="text"
                    color="primary"
                    >
                    Save
                    </v-btn>
                </v-card-actions>
                </v-expansion-panel-text>
            </v-expansion-panel>
        
            <v-expansion-panel>
                <v-expansion-panel-title v-slot="{ open }">
                <v-row no-gutters>
                    <v-col cols="4" class="d-flex justify-start">
                        Définissez le&nbsp;<span style="font-size: 15px; color: blue;">NOMBRE LIMITE</span>&nbsp;des élèves dans une classe
                    </v-col>
                    <v-col
                    cols="8"
                    class="text--secondary"
                    >
                    <v-fade-transition leave-absolute>
                        <span v-if="open">When do you want to travel?</span>
                        <v-row
                        v-else
                        no-gutters
                        style="width: 100%"
                        >
                        <v-col cols="6" class="d-flex justify-start">
                            Start date: {{ trip.start || 'Not set' }}
                        </v-col>
                        <v-col cols="6" class="d-flex justify-start">
                            End date: {{ trip.end || 'Not set' }}
                        </v-col>
                        </v-row>
                    </v-fade-transition>
                    </v-col>
                </v-row>
                </v-expansion-panel-title>
                <v-expansion-panel-text>
                <v-row
                    justify="space-around"
                    no-gutters
                >
                    <v-col cols="3">
                    <v-text-field
                        v-model="trip.start"
                        label="Start date"
                        type="date"
                    ></v-text-field>
                    </v-col>
        
                    <v-col cols="3">
                    <v-text-field
                        v-model="trip.end"
                        label="End date"
                        type="date"
                    ></v-text-field>
                    </v-col>
                </v-row>
                </v-expansion-panel-text>
            </v-expansion-panel>
        </v-expansion-panels>
    </v-card>
          
    
  </template>
  <script>
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
  import {
        mdiAccountSchool,
        mdiPlus,
        mdiPencil,
        mdiDelete,
        mdiPlusCircle,
       mdiClipboardEditOutline,
       mdiOfficeBuilding,
       mdiMail,
       mdiGoogleClassroom,
       mdiSchool,
       mdiCancel,
       mdiCloseCircle,
       mdiContentSave,
       mdiCurrencyUsd,
    } from '@mdi/js'
  export default {
    components: {
            mdiAccountSchool,
            mdiPlus,
            mdiPencil,
            mdiDelete,
            mdiPlusCircle,
            mdiClipboardEditOutline,
            mdiOfficeBuilding,
            mdiMail,
            mdiGoogleClassroom,
            mdiSchool,
            mdiCancel,
            mdiCloseCircle,
            mdiContentSave,
            mdiCurrencyUsd
        },
    layout: AuthenticatedLayout,
    props: ["type"],
    data: () => ({
        icons: {
            mdiAccountSchool,
            mdiPlus,
            mdiPencil,
            mdiDelete,
            mdiPlusCircle,
            mdiClipboardEditOutline,
            mdiOfficeBuilding,
            mdiMail,
            mdiGoogleClassroom,
            mdiSchool,
            mdiCancel,
            mdiCloseCircle,
            mdiContentSave,
            mdiCurrencyUsd,
        },
      trip: {
        name: '',
        location: null,
        start: null,
        end: null,
      },
      locations: ['Australia', 'Barbados', 'Chile', 'Denmark', 'Ecuador', 'France'],
    }),
    computed: {
        Title() {

        switch (this.type) {
            case "1":
            return "SECTION PRIMAIRE";
            case "2":
            return "SECTION SECONDAIRE";
            case "3":
            return "SECTION SUPERIEUR";
            default:
            return "SECTION UNIVERSITAIRE";
        }
        },
    }
  }
</script>