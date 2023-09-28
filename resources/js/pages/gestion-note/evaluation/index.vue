<script>
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import {
    useForm,
    router
} from '@inertiajs/vue3';
// import Datatable from "@/components/customizedComponents/datatable.vue";

import {
    mdiAccountSchool,
    mdiPlus,
    mdiPencil,
    mdiDelete,
    mdiPlusCircle,
    mdiClipboardEditOutline,
    mdiTools,
    mdiCloseCircle,
    mdiCheckCircle,
    mdiPercentOutline,
    mdiTimelineAlert,
    mdiContentSaveEditOutline,
} from '@mdi/js'
export default {
    components: {
        // Datatable,
        mdiAccountSchool,
        mdiPlus,
        mdiPencil,
        mdiDelete,
        mdiPlusCircle,
        mdiClipboardEditOutline,
        mdiTools,
        mdiCloseCircle,
        mdiCheckCircle,
        mdiPercentOutline,
        mdiTimelineAlert,
        mdiContentSaveEditOutline
    },
    layout: AuthenticatedLayout,
    props: ["evaluation_primaires","evaluation_secondaires","evaluation_superieures","evaluation_universites","types","periodes","type_evaluation","regime","enseignements"],
    data() {
        return {
            icon: {
                mdiAccountSchool,
                mdiPlus,
                mdiPencil,
                mdiDelete,
                mdiPlusCircle,
                mdiClipboardEditOutline,
                mdiTools,
                mdiCloseCircle,
                mdiCheckCircle,
                mdiPercentOutline,
                mdiTimelineAlert,
                mdiContentSaveEditOutline
            },

            headers: [
                {
                    title: 'Matière',
                    align: 'center',
                    key: 'matiere',
                },
                {
                    title: 'Niveau/Classe',
                    align: 'center',
                    key: 'code'
                },
                {
                    title: 'Enseignant',
                    align: 'center',
                    key: 'enseignant'
                },
                {
                    title: 'Date Evaluation',
                    align: 'center',
                    key: 'date'
                },
                {
                    title: 'Type Evaluation',
                    align: 'center',
                    key: 'type'
                },
                {
                    title: 'periodes',
                    align: 'center',
                    key: 'periode'
                },
                {
                    title: 'Pourcentage',
                    align: 'center',
                    key: 'pourcentage'
                },
                {
                    title: 'Actions',
                    align: 'center',
                    key: 'actions'
                },
            ],

            dialog_title: 'Nouvelle Evaluation',
            dialog: false,

            form: useForm({
                date: '',
                pourcentage: null,
                type_evaluation_id: null,
                periode_id: null,
                enseignement_annee_id: null,
            }),
        }
    },

    methods: {
        create() {
            this.dialog = true
        },
        editItem(item) {
            // console.log('code', item.enseignement_annee_id)
            this.form.id = item.id
            this.form.date = item.date
            this.form.pourcentage = item.pourcentage
            this.form.periode_id = item.periode_id
            this.form.type_evaluation_id = item.type_evaluation_id
            this.form.enseignement_annee_id = item.enseignement_annee_id
            this.dialog = true
            this.dialog_title = 'Modifier Evaluation ' 
        },
        deleteItem(item) {
            this.$swal({
                title: 'Es-tu sûr?',
                text: "Vous ne pourrez pas revenir en arrière!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'orange',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimez-le!',
                cancelButtonText: 'Non, annulez!',
            }).then((result) => {
                if (result.isConfirmed) {

                    this.form.delete(route('evaluation.destroy', item.id), {

                        onFinish: () => {
                            if (this.$page.props.flash ?.message ?.type == 'error') {
                                this.$swal({
                                    icon: 'error',
                                    title: 'Suppression',
                                    text: this.$page.props.flash ?.message ?.text,
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 5000,
                                    timerProgressBar: true,
                                });
                            } else if (this.$page.props.flash ?.message ?.type == 'success') {
                                this.$swal({
                                    icon: 'success',
                                    title: 'Suppression',
                                    text: this.$page.props.flash ?.message ?.text,
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 5000,
                                    timerProgressBar: true,
                                });
                            }
                        },

                    });
                }
            });
        },
        async submit() {
            const {
                valid
            } = await this.$refs.form.validate()
            if (!this.form.id && valid) {
                this.form.post(route('evaluation.store'), {
                    onFinish: () => {
                        this.close()
                        this.$swal({
                            icon: 'success',
                            title: 'Enrégistrement',
                            text: 'Evaluation créée avec succès!',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                        });
                    },
                });
            } else if (this.form.id && valid) {
                const {
                    date,
                    pourcentage,
                    periode_id,
                    type_evaluation_id,
                    enseignement_annee_id
                } = this.form

                this.form.put(route('evaluation.update', this.form.id), {
                    onFinish: () => {
                        this.close()
                        this.$swal({
                            icon: 'success',
                            title: 'Enregistrement',
                            text: 'Evaluation modifié avec succès!',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                        });
                    },
                })
            }

        },
        close() {
            this.form.id = null
            this.form.date = null
            this.form.pourcentage = null
            this.form.periode_id = null
            this.form.type_evaluation_id = null
            this.form.enseignement_annee_id = null
            this.dialog = false
        },
    },
}
</script>

<template>
<Head title="Dashboard" />

<AuthenticatedLayout>
    <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Evaluation</h2>
    </template>

    <v-card>
        <page-toolbar :icon="icon.mdiTools">Gestion des Evaluations</page-toolbar>
        <v-card-text>

            <br>
            <v-dialog v-model="dialog" transition="dialog-top-transition" persistent width="900px">

<v-card>
    <!-- <v-card-title dense color="orange" dark> -->
    <v-toolbar dense color="secondary" dark >
        <v-toolbar-title >
            <v-icon left>{{ form.id ? icon.mdiPencil : icon.mdiPlusCircle }}</v-icon> {{ dialog_title }}
        </v-toolbar-title>
        <v-spacer></v-spacer>
        <v-icon :icon="icon.mdiCloseCircle" title="Annuler" size="large" style="margin:10px" color="white" @click="close()"></v-icon>
    </v-toolbar>
    <!-- </v-card-title> -->
    <v-card-text>
        <v-form ref="form">
            <v-container>
                <v-row>
                    <v-col cols="6" >
                        <TextField  label="Date Evaluation" type="date" variant="outlined" placeholder="Date" v-model="form.date" :isRequired="true" :rules="[v => !!v || 'Ce champ est requis!']">
                        </TextField>
                    </v-col>
                    <v-col cols="6">
                        <Autocomplete v-model="form.periode_id" label="Periodes" itemTitle="libelle" itemValue="id" :items="periodes" variant="outlined" :isRequired="true" :rules="[v => !!v || 'Ce champ est requis!'] "  chips clearable>
                        </Autocomplete>
                    </v-col>
                    <v-col cols="6">
                        <Autocomplete label="Type Evaluation" variant="outlined" item-title="libelle" item-value="id" :items="type_evaluation" v-model="form.type_evaluation_id" :rules="[v => !!v || 'Ce champ est requis!'] "  chips clearable :isRequired="true">
                        </Autocomplete>
                    </v-col>
                    <v-col cols="6">
                        <Autocomplete label="Matiére/Classe" variant="outlined" item-title="code" item-value="id" :items="enseignements" v-model="form.enseignement_annee_id " :rules="[v => !!v || 'Ce champ est requis!'] "  chips clearable>
                        </Autocomplete>
                    </v-col>
                    <v-col cols="6">
                    <TextField v-if="regime[0].regime_evaluation"  :prepend-inner-icon="icon.mdiPercentOutline" label="Pourcentage" variant="outlined" placeholder="pourcentage" v-model="form.pourcentage" :isRequired="true" :rules="[v => !!v || 'Ce champ est requis!']">
                        </TextField>
                    </v-col>
                </v-row>
            </v-container>
        </v-form>
    </v-card-text>
    <v-card-actions class="justify-end">
        <v-spacer></v-spacer>
        <Button  class="mb-2" style="height: 30px"  nameButton="Enregistrer" title="Valider et Fermer la modale" small color="primary" variant="outlined" :prependIcon="icon.mdiContentSaveEditOutline" @click="submit">    
        </Button>
    </v-card-actions>
</v-card>
</v-dialog>
            <Datatable v-if="types == 1" titleDatatable="Listes des evaluations (section primaire)" :headers="headers" :items="evaluation_primaires" :functionOnClickAddButton="create">
                <template v-slot:[`item.actions`]="{ item }">
                    <v-icon size="small" color="warning" title="Modifier" class="me-2" @click="editItem(item.raw)" :icon="icon.mdiPencil">
                    </v-icon>
                    <v-icon size="small" color="error" @click="deleteItem(item.raw)" :icon="icon.mdiDelete">
                    </v-icon>
                </template>
            </Datatable>
            <Datatable v-if="types == 2" titleDatatable="Listes des evaluations section secondaire " :headers="headers" :items="evaluation_secondaires" :functionOnClickAddButton="create">
                <template v-slot:[`item.actions`]="{ item }">
                    <v-icon size="small" color="warning" title="Modifier" class="me-2" @click="editItem(item.raw)" :icon="icon.mdiPencil">
                    </v-icon>
                    <v-icon size="small" color="error" @click="deleteItem(item.raw)" :icon="icon.mdiDelete">
                    </v-icon>
                </template>
            </Datatable>
            <Datatable v-if="types == 3" titleDatatable="Listes des evaluations (section superieure) " :headers="headers" :items="evaluation_superieures" :functionOnClickAddButton="create">
                <template v-slot:[`item.actions`]="{ item }">
                    <v-icon size="small" color="warning" title="Modifier" class="me-2" @click="editItem(item.raw)" :icon="icon.mdiPencil">
                    </v-icon>
                    <v-icon size="small" color="error" @click="deleteItem(item.raw)" :icon="icon.mdiDelete">
                    </v-icon>
                </template>
            </Datatable>
            <Datatable v-if="types == 4" titleDatatable="Listes des evaluations (section université)" :headers="headers" :items="evaluation_universites" :functionOnClickAddButton="create">
                <template v-slot:[`item.actions`]="{ item }">
                    <v-icon size="small" color="warning" title="Modifier" class="me-2" @click="editItem(item.raw)" :icon="icon.mdiPencil">
                    </v-icon>
                    <v-icon size="small" color="error" @click="deleteItem(item.raw)" :icon="icon.mdiDelete">
                    </v-icon>
                </template>
            </Datatable>
        </v-card-text>
    </v-card>
</AuthenticatedLayout>
</template>
