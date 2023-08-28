<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router } from "@inertiajs/vue3";
import {
    mdiTimetable,
    mdiCheckCircle,
    mdiCancel
} from '@mdi/js'
export default {
    layout: AuthenticatedLayout,
    props: ["emplois"],
    data() {
        return {
            icon: {
                mdiTimetable,
                mdiCancel,
                mdiCheckCircle
            },
            date: null
        }
    },
    methods: {
        goBack() {
            router.get(route('emplois.index'))
        },
    }
}
</script>
<template>
    <v-card>
        <page-toolbar :icon="icon.mdiTimetable">Nouveau emploi</page-toolbar>
        <v-card-text>
            <v-form>
                <v-row>
                    <v-card-text>
                        <v-chip label variant="outlined" text-color="white" color="rgb(125, 0, 44, 0.75)" class="text-md-h6 green--text">Classe concerner</v-chip>
                        <v-card outlined class="mb-md-2" height="600">
                            <v-card-text>
                                <v-row>
                                    <v-col md="4">
                                        <v-select
                                            label="Section"
                                            :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
                                        ></v-select>
                                    </v-col>
                                    <v-col md="4">
                                        <v-select
                                            label="Niveau"
                                            :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
                                        ></v-select>
                                    </v-col>
                                    <v-col md="4">
                                        <v-select
                                            label="Classe"
                                            :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
                                        ></v-select>
                                    </v-col>
                                    <v-col md="12">
                                        <VueDatePicker 
                                            v-model="date"
                                            locale="fr"
                                            flow="calendar"
                                            date-picker
                                            range
                                            placeholder="Start Typing ..." />
                                    </v-col>
                                </v-row>
                                <v-stepper :items="['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi']">
                                    <template v-slot:item.1>
                                        <v-card title="Step Lundi" flat>...</v-card>
                                    </template>

                                    <template v-slot:item.2>
                                        <v-card title="Step Mardi" flat>...</v-card>
                                    </template>

                                    <template v-slot:item.3>
                                        <v-card title="Step Mercredi" flat>...</v-card>
                                    </template>

                                    <template v-slot:item.4>
                                        <v-card title="Step Jeudi" flat>...</v-card>
                                    </template>

                                    <template v-slot:item.5>
                                        <v-card title="Step Vendredi" flat>...</v-card>
                                    </template>

                                    <template v-slot:item.6>
                                        <v-card title="Step Samsedi" flat>...</v-card>
                                    </template>
                                </v-stepper>
                            </v-card-text>
                        </v-card>
                    </v-card-text>
                </v-row>
                <br>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn dark small type="button" color="red" @click="goBack">
                        <v-icon :icon="icon.mdiCancel" left></v-icon> Annuler
                    </v-btn>
                    <v-btn small color="success" @click="submit">
                        <v-icon :icon="icon.mdiCheckCircle" left></v-icon> Enregistrer
                    </v-btn>
                </v-card-actions>
            </v-form>
        </v-card-text>
    </v-card>
</template>