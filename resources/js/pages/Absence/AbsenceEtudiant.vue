<script>
import AuthenticatedLayout from "@/layouts/AuthenticatedLayout.vue";
import {
    mdiTimetable,
    mdiCheckCircle,
    mdiCancel,
    mdiPlusCircle,
    mdiCloseCircle,
    mdiAlertCircle,
    mdiCheck,
    mdiPencil,
    mdiMinus,
    mdiMenuDown,
} from "@mdi/js";
import {
    useForm,
    router
} from '@inertiajs/vue3';
export default {
    props: ['absences'],
    layout: AuthenticatedLayout,
    data() {
        return {
            icon: {
                mdiTimetable,
                mdiCancel,
                mdiCheckCircle,
                mdiPlusCircle,
                mdiCloseCircle,
                mdiAlertCircle,
                mdiCheck,
                mdiPencil,
                mdiMinus,
                mdiMenuDown,
            },
            form: useForm({
                date: null,
                date1: null,
                date2: null,
            }),
            question: null,
            // absences:[],
            header: [{
                    title: 'Matiere',
                    align: 'center',
                    key: 'nom_matiere'
                },
                {
                    title: 'Jour',
                    align: 'center',
                    key: 'jour'
                },
                {
                    title: 'Heure',
                    align: 'center',
                    key: 'heure'
                },
                {
                    title: 'Toute la journée',
                    align: 'center',
                    key: 'toute_journnee'
                },
                {
                    title: 'Date',
                    align: 'center',
                    key: 'date'
                },
            ],
        }
    },
    methods: {
        SetAbsences(date) {
            this.form.date1 = null
            this.form.date12 = null
            this.$inertia.replace(this.$page.url, {
                data: {
                    date: date
                }
            });
        },
        handleDate() {
            let vh = document.getElementById("heit");
            vh.style.height = "auto";
            return vh;
        },
        handleFocusDate() {
            let vh = document.getElementById("heit");
            return (vh.style.height = "700px");
        },
        formatDate(dateString) {
            if (!dateString) {
                return '';
            }
            const dateObject = new Date(dateString);
            if (isNaN(dateObject.getTime())) {
                return 'Date invalide';
            }
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            return dateObject.toLocaleDateString('fr-FR', options);
        },
        voir() {
            this.form.date = null
            this.$inertia.replace(this.$page.url, {
                data: {
                    date1: this.form.date1,
                    date2: this.form.date2
                }
            });
        }
    }
    // mounted(){
    //     console.log(this.absences)
    // }
}
</script>
<template>
<v-card>
    <Toolbar :icon="icon.mdiTimetable" toolbarTitle="Mes absences"></Toolbar>
    <br>
    <v-card-text>
        <v-form ref="form">
            <!-- <v-container> -->
            <v-row>
                <v-col cols="3">
                    <TextField :disabled="question" label="Date" type="date" variant="outlined" placeholder="Date" v-model="form.date" @update:modelValue="SetAbsences(form.date)" :isRequired="true" :rules="[v => !!v || 'Ce champ est requis!']">
                    </TextField>
                </v-col>
                <v-col md="2">
                    <v-switch v-model="question" label="Voir par tranche date" color="primary" inset></v-switch>
                </v-col>
                <v-col cols="3">
                    <TextField :disabled="!question" type="date" variant="outlined" label="Date Debut" v-model="form.date1" :isRequired="true" :rules="[v => !!v || 'Ce champ est requis!']">
                    </TextField>
                </v-col>
                <v-col cols="3">
                    <TextField :disabled="!question" label="Date Fin" type="date" variant="outlined" v-model="form.date2" :isRequired="true" :rules="[v => !!v || 'Ce champ est requis!']">
                    </TextField>
                </v-col>
                <v-col cols="1">
                    <v-btn :disabled="!question" class="mt-4" color="deep-purple-accent-4" @click="voir">
                        voir
                    </v-btn>
                </v-col>
            </v-row>
            <!-- </v-container> -->
        </v-form>
    </v-card-text>

    <Datatable :titleDatatable="form.date ? `Liste de mes absences  ${ formatDate(form.date)}`: (form.date1 && form.date2) ? `Liste de mes absences  ${ formatDate(form.date1)} au ${ formatDate(form.date2)}` : 'Liste de mes absences d\'aujourd\'hui'" :headers="header" :items="absences" :displayAddButton="false">
    </Datatable>
</v-card>
</template>
