<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {
    mdiCircleSlice1,
    mdiCircleSlice2
} from '@mdi/js'
export default {
    components: {
        mdiCircleSlice1,
        mdiCircleSlice2
    },
    layout: AuthenticatedLayout,
    props: ['notes_s1', 'entetes', 'notes_s2','matricule'],
    data() {
        return {
            icon: {
                mdiCircleSlice1,
                mdiCircleSlice2
            },
            tab: null
        }
    },
    computed: {
        formattedDataS1() {
            const apprenants = {};
            this.notes_s1.forEach(note => {
                if (!apprenants[note.type_evaluation]) {
                    apprenants[note.type_evaluation] = {
                        type_evaluation: note.type_evaluation,
                        count: 0,
                        totalNotes: 0,
                        moyenne: 0,
                        c: 0
                    };
                }
                if (!isNaN(note.note)) {
                    apprenants[note.type_evaluation].totalNotes += note.note;
                    apprenants[note.type_evaluation].count++;
                }
                if (!apprenants[note.type_evaluation][note.nom_matiere]) {
                    apprenants[note.type_evaluation][note.nom_matiere] = 0;
                }
                apprenants[note.type_evaluation][note.nom_matiere] += note.note;
            });
            Object.values(apprenants).forEach(apprenant => {
                if (apprenant.count > 0) {
                    apprenant.moyenne = (apprenant.totalNotes / apprenant.count).toFixed(2);
                }
            });
            return Object.values(apprenants);
        },
        formattedDataS2() {
            const apprenants = {};
            this.notes_s2.forEach(note => {
                if (!apprenants[note.type_evaluation]) {
                    apprenants[note.type_evaluation] = {
                        type_evaluation: note.type_evaluation,
                        count: 0,
                        totalNotes: 0,
                        moyenne: 0,
                    };
                }
                if (!isNaN(note.note)) {
                    apprenants[note.type_evaluation].totalNotes += note.note;
                    apprenants[note.type_evaluation].count++;
                }
                if (!apprenants[note.type_evaluation][note.nom_matiere]) {
                    apprenants[note.type_evaluation][note.nom_matiere] = 0;
                }
                apprenants[note.type_evaluation][note.nom_matiere] += note.note;
            });
            Object.values(apprenants).forEach(apprenant => {
                if (apprenant.count > 0) {
                    apprenant.moyenne = (apprenant.totalNotes / apprenant.count).toFixed(2);
                }
            });
            return Object.values(apprenants);
        },
    }
}
</script>
<template>
<Toolbar :icon="icon.mdiAccountPlusOutline" :toolbarTitle="`Notes du matricule ${matricule}`"></Toolbar>
<br>
<v-tabs v-model="tab" color="primary" align-tabs="center">
    <v-tab value="semestre1">
        <v-icon start>
            {{ icon.mdiCircleSlice1 }}
        </v-icon>
        Semestre I
    </v-tab>
    <v-tab value="semestre2">
        <v-icon start>
            {{ icon.mdiCircleSlice2 }}
        </v-icon>
        Semestre II
    </v-tab>
</v-tabs>
<v-window v-model="tab">
    <v-window-item value="semestre1">
        <Datatable titleDatatable="Notes du semestre 1" :headers="entetes" :items="formattedDataS1" :displayAddButton="false">
        </Datatable>
    </v-window-item>
    <v-window-item value="semestre2">
        <Datatable titleDatatable="Notes du semestre 1" :headers="entetes" :items="formattedDataS2" :displayAddButton="false">
        </Datatable>
    </v-window-item>
</v-window>
</template>
