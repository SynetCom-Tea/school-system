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
    props: ["evaluation_primaires", "evaluation_secondaires", "evaluation_superieures", "evaluation_universites", 'types', "periodes", "type_evaluation", "regime", "enseignements", "matieres", "filieres", "niveaux"],
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

            dialog_title: 'Nouvelle Evaluation',
            dialog: false,
            filtrer: [],
            form: useForm({
                id: null,
                date: '',
                pourcentage: null,
                type_evaluation_id: null,
                periode_id: null,
                enseignement_annee_id: [],
                section_id: null,
                filiere: null,
                niveau: null,
                matiere: null,
                session: null
            }),
        }
    },

    methods: {
        create() {
            // console.log(this.$page.props.permissions[0])
            this.dialog = true
            this.dialog_title = 'Nouvelle Evaluation'
        },
        formatCode(item) {
            return `${item.filiere.code } - ${item.cycle.name } `
        },
        editItem(item) {
            // console.log('item', item)
            this.form.id = item.id
            this.form.date = item.date
            this.form.pourcentage = item.pourcentage
            this.form.periode_id = item.periode_id,
                this.form.filiere = item.filiere,
                this.form.matiere = item.matiere_id,
                this.form.niveau = item.niveau
            this.form.type_evaluation_id = item.type_evaluation_id
            this.form.enseignement_annee_id = item.enseignement_annee_id,
                this.form.session = item.session
            this.dialog = true
            this.dialog_title = 'Modifier Evaluation' + ' ' + item.code
            router.replace(this.$page.url, {
                data: {
                    niveau: item.niveau,
                    filiere: item.filiere,
                }
            })

        },
        deleteItem(item) {
            this.$swal({
                title: 'Etes-vous sûr de vouloir supprimer evaluation de' + ' ' + item.code + '?',
                text: "Vous ne pourrez pas revenir en arrière!!!",
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
        setClasse(n) {
            // console.log(n)
            this.form.matiere = null,
                router.replace(this.$page.url, {
                    data: {
                        niveau: n,
                        filiere: this.form.filiere,
                    }
                })
        },
        async submit() {
            const {
                valid
            } = await this.$refs.form.validate()
            if (!this.form.id && valid) {
                this.form.section_id = this.types
                this.form.post(route('evaluation.save'), {
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
                this.form.put(route('evaluation.modifie', this.form.id), {
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
        }
    },
    mounted() {
        if (this.types == 1) {
            this.filtrer = this.type_evaluation.filter(el => el.libelle == "Composition" || el.libelle == "Contrôle")
        }
        if (this.types == 2) {
            this.filtrer = this.type_evaluation.filter(el => el.libelle != "Contrôle")
        }
        if (this.types == 3 || this.types == 4) {
            this.filtrer = this.type_evaluation.filter(el => el.libelle == "Examen" || el.libelle == "TP" || el.libelle == "Devoir")
        }
        // console.log(this.evaluations)
    },
    computed: {
        getHeaders() {
            const headers = [{
                    title: 'Matière',
                    align: 'center',
                    key: 'matiere',
                },
                {
                    title: 'Classe',
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
            ];
            if (this.types >=3) {
                headers.push({
                    title: 'Session',
                    align: 'center',
                    key: 'session'
                })
            }
            headers.push({
                    title: 'Actions',
                    align: 'center',
                    key: 'actions'
                })
            return headers;
        }
    }
}
</script>

<template>
<Toolbar :icon="icon.mdiAccountPlusOutline" toolbarTitle="Gestion des evaluations"></Toolbar>
<br>
<v-dialog v-model="dialog" transition="dialog-top-transition" persistent width="900px">

    <v-card>
        <v-toolbar dense color="primary" dark>
            <v-toolbar-title>
                <v-icon left>{{ form.id ? icon.mdiPencil : icon.mdiPlusCircle }}</v-icon> {{ dialog_title }}
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-icon :icon="icon.mdiCloseCircle" title="Annuler" size="large" style="margin:10px" color="white" @click="close()"></v-icon>
        </v-toolbar>
        <v-card-text>
            <v-form ref="form">
                <v-container>
                    <v-row>
                        <v-col cols="4">
                            <TextField label="Date Evaluation" type="date" variant="outlined" placeholder="Date" v-model="form.date" :isRequired="true" :rules="[v => !!v || 'Ce champ est requis!']">
                            </TextField>
                        </v-col>

                        <v-col cols="4">
                            <Autocomplete label="Type Evaluation" variant="outlined" item-title="libelle" item-value="id" :items="filtrer" v-model="form.type_evaluation_id" :rules="[v => !!v || 'Ce champ est requis!'] " chips clearable :isRequired="true">
                            </Autocomplete>
                        </v-col>
                        <v-col cols="4">
                            <Autocomplete v-model="form.periode_id" label="Periodes" itemTitle="libelle" itemValue="id" :items="periodes" variant="outlined" :isRequired="true" :rules="[v => !!v || 'Ce champ est requis!'] " chips clearable>
                            </Autocomplete>
                        </v-col>
                        <v-col md="4" v-if="types>=3">
                            <Autocomplete v-model="form.filiere" :items="filieres" :itemTitle="formatCode" item-value="id" outlined required dense chips small-chips label="Filieres"></Autocomplete>
                        </v-col>
                        <v-col md="4" v-if="types>=3">
                            <Autocomplete v-model="form.niveau" @update:modelValue="setClasse(form.niveau)" :items="niveaux" itemTitle="code" item-value="id" outlined required dense chips small-chips label="Niveaux" :isRequired="true"></Autocomplete>
                        </v-col>
                        <v-col md="4" v-if="types>=3">
                            <Autocomplete v-model="form.matiere" :items="matieres" itemTitle="nom" item-value="id" outlined required dense chips small-chips label="Matieres" :isRequired="true"></Autocomplete>
                        </v-col>
                        <v-col cols="6" v-if="types<=2">
                            <Autocomplete label="Matiére/Classe" variant="outlined" item-title="code" item-value="id" :items="enseignements" v-model="form.enseignement_annee_id " :rules="[v => !!v || 'Ce champ est requis!'] " chips clearable multiple :isRequired="true">
                            </Autocomplete>
                        </v-col>
                        <v-col cols="6">
                            <TextField v-if="regime[0].regime_evaluation" :prepend-inner-icon="icon.mdiPercentOutline" label="Pourcentage" variant="outlined" placeholder="pourcentage" v-model="form.pourcentage" :isRequired="true" :rules="[v => !!v || 'Ce champ est requis!']">
                            </TextField>
                        </v-col>
                        <v-col cols="3" v-if="types>=3">
                            <v-radio-group inline label="Sessions ?" v-model="form.session" :rules="[v => !!v || 'Ce champ est requis!'] ">
                                <v-radio label="1ère" value="Prémiere session"></v-radio>
                                <v-radio label="2ème" value="deuxiéme session"></v-radio>
                            </v-radio-group>
                        </v-col>
                    </v-row>
                </v-container>
            </v-form>
        </v-card-text>
        <v-card-actions class="justify-end">
            <v-spacer></v-spacer>
            <Button class="mb-2" style="height: 30px" nameButton="Enregistrer" title="Valider et Fermer la modale" small color="primary" variant="outlined" :prependIcon="icon.mdiContentSaveEditOutline" @click="submit">
            </Button>
        </v-card-actions>
    </v-card>
</v-dialog>
<Datatable v-if="types == 1" titleDatatable="Listes des evaluations (section primaire)" :headers="getHeaders" :items="evaluation_primaires" :functionOnClickAddButton="create">
    <template v-slot:[`item.actions`]="{ item }">
        <v-icon size="small" color="warning" title="Modifier" class="me-2" @click="editItem(item)" :icon="icon.mdiPencil">
        </v-icon>
        <v-icon size="small" color="error" @click="deleteItem(item)" :icon="icon.mdiDelete">
        </v-icon>
    </template>
</Datatable>
<Datatable v-if="types == 2" titleDatatable="Listes des evaluations section secondaire " :headers="getHeaders" :items="evaluation_secondaires" :functionOnClickAddButton="create">
    <template v-slot:[`item.actions`]="{ item }">
        <v-icon size="small" color="warning" title="Modifier" class="me-2" @click="editItem(item)" :icon="icon.mdiPencil">
        </v-icon>
        <v-icon size="small" color="error" @click="deleteItem(item)" :icon="icon.mdiDelete">
        </v-icon>
    </template>
</Datatable>
<Datatable v-if="types == 3" titleDatatable="Listes des evaluations (section superieure) " :headers="getHeaders" :items="evaluation_superieures" :functionOnClickAddButton="create">
    <template v-slot:[`item.actions`]="{ item }">
        <v-icon size="small" color="warning" title="Modifier" class="me-2" @click="editItem(item)" :icon="icon.mdiPencil">
        </v-icon>
        <v-icon size="small" color="error" @click="deleteItem(item)" :icon="icon.mdiDelete">
        </v-icon>
    </template>
</Datatable>
<Datatable v-if="types == 4" titleDatatable="Listes des evaluations (section université)" :headers="getHeaders" :items="evaluation_universites" :functionOnClickAddButton="create">
    <template v-slot:[`item.actions`]="{ item }">
        <v-icon size="small" color="warning" title="Modifier" class="me-2" @click="editItem(item)" :icon="icon.mdiPencil">
        </v-icon>
        <v-icon size="small" color="error" @click="deleteItem(item)" :icon="icon.mdiDelete">
        </v-icon>
    </template>
</Datatable>
</template>
