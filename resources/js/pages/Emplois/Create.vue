<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router, useForm } from "@inertiajs/vue3";
import {
    mdiTimetable,
    mdiCheckCircle,
    mdiCancel,
    mdiPlusCircle,
    mdiCloseCircle
} from '@mdi/js'
export default {
    layout: AuthenticatedLayout,
    props: ["emplois"],
    data() {
        return {
            icon: {
                mdiTimetable,
                mdiCancel,
                mdiCheckCircle,
                mdiPlusCircle,
                mdiCloseCircle
            },
            date: null,
            activeStep: 0,
            daysOfWeek: ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
            steps: ['Step 1', 'Step 2', 'Step 3'],
            form: useForm({
                seances: {},
                section: null,
                niveau: null,
                classe: null
            }),
            items: Array.from({ length: 10 }).map((_, i) => ({
                title: `Step ${i + 1}`,
                subtitle: `Step ${i + 1} subtitle`,
                value: i + 1,
            })),
        }
    },
    methods: {
        goBack() {
            router.get(route('emplois.index'))
        },
        addRow(day) {
            this.form.seances[day].push({
                horaire: null,
                name: null,
                before: null,
                after: null,
            });
        },
        removeRow(day, p) {
            this.form.seances[day] = this.form.seances[day].filter((seance) => seance !== p);
        },
        submit(){
            console.log(this.form)
        }
    },
    mounted() {
        this.daysOfWeek.forEach((day) => {
            this.form.seances[day] = [];
            this.addRow(day);
        });
    },
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
                        <v-card outlined class="mb-md-2 auto-height-card">
                            <v-card-text>
                                <v-row dennse>
                                    <v-col md="4">
                                        <autocomplete
                                            label="Section"
                                            v-model="form.section"
                                            :items="['Primiere', 'College', 'Lycee', 'Superieur', 'Universite']"
                                        ></autocomplete>
                                    </v-col>
                                    <v-col md="4">
                                        <autocomplete
                                            label="Niveau"
                                            v-model="form.niveau"
                                            :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
                                        ></autocomplete>
                                    </v-col>
                                    <v-col md="4">
                                        <autocomplete
                                            label="Classe"
                                            v-model="form.classe"
                                            :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
                                        ></autocomplete>
                                    </v-col>
                                    <v-col md="ei12">
                                        <VueDatePicker 
                                            v-model="date"
                                            flow="calendar"
                                            date-picker
                                            range
                                            placeholder="Start Typing ..." />
                                    </v-col>
                                </v-row>
                                <br>
                                <!-- <v-stepper :items="['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi']">
                                    <template v-for="(day, i) in daysOfWeek" :key="i" >
                                        <v-card :title="`Emploi du ${day}`" flat>
                                            <v-card-text>
                                                <v-row :key="seance.id" v-for="(seance, i) in form.seances[day]" dense>
                                                    <v-col md="3">
                                                        <VueDatePicker v-model="seance.horaire" time-picker range />
                                                    </v-col>
                                                    <v-col md="3">
                                                        <text-field label="Matiere" placeholder="Matiere" v-model="seance.name"></text-field>
                                                    </v-col>
                                                    <v-col md="5">
                                                        <autocomplete label="Salle" item-title="name" item-value="id" :items="fillieres" multiple chips v-model="seance.filliere">
                                                        </autocomplete>
                                                    </v-col>
                                                    <v-col md="1">
                                                        <v-btn variant="outlined" :disabled="!(form.seances.length > 1)" icon @click="removeRow(seance)" fab small color="error">
                                                            <v-icon :icon="icon.mdiCloseCircle"></v-icon>
                                                        </v-btn>
                                                    </v-col>
                                                </v-row>
                                                <v-row dense>
                                                    <v-col offset-md="11" md="1">
                                                        <v-btn variant="outlined" icon @click="addRow(day)" fab small color="green">
                                                            <v-icon :icon="icon.mdiPlusCircle"></v-icon>
                                                        </v-btn>
                                                    </v-col>
                                                </v-row>
                                            </v-card-text>
                                        </v-card>
                                    </template>
                                </v-stepper> -->
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

<style scoped>
.auto-height-card {
  height: auto; /* Cela permet à la carte d'ajuster automatiquement sa hauteur en fonction de son contenu */
}
</style>