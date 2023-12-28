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
    props: ['notes', 'entetes'],
    data() {
        return {
            icon: {
                mdiCircleSlice1,
                mdiCircleSlice2
            },
            mat: 'US-GI-010',
            tab: null
        }
    },
    mounted() {
        // console.log(this.entetes)
    },
    computed: {
        formattedData() {
            const apprenants = {};
            this.notes.forEach(note => {
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

            // Calcul de la moyenne pour chaque type d'évaluation
            Object.values(apprenants).forEach(apprenant => {
                if (apprenant.count > 0) {
                    apprenant.moyenne = (apprenant.totalNotes / apprenant.count).toFixed(2);
                }
            });

            console.log(apprenants);
            return Object.values(apprenants);
            //   console.log(apprenants)
        },
    }
}
</script>
<template>
<!-- <Head title="Notes" />
    <AuthenticatedLayout> -->
<Toolbar :icon="icon.mdiAccountPlusOutline" :toolbarTitle="`Notes du matricule ${mat}`"></Toolbar>
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
        <Datatable titleDatatable="Notes du semestre 1" :headers="entetes" :items="formattedData" :displayAddButton="false">
            <template v-for="header in headers" v-slot:[`item.${header.key}`]="{ item }">
                <template>
                    <!-- <v-chip :color="getColor(item[header.key])"> -->
                    {{ item[header.key] }}
                    <!-- </v-chip> -->
                </template>
            </template>
        </Datatable>
    </v-window-item>
    <v-window-item value="semestre2">
        <Datatable titleDatatable="Notes du semestre 2" :headers="headersSup" :items="donnees" :displayAddButton="false">
        </Datatable>
    </v-window-item>
</v-window>
</template>
