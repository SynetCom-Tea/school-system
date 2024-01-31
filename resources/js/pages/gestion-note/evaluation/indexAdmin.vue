<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
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
    mdiEye,
} from '@mdi/js';
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
        mdiContentSaveEditOutline,
        mdiEye,
    },
    layout: AuthenticatedLayout,
    props: [ 'regime', 'matieres',  'niveaux', "evaluations", "types", "evaluation_id", "periodes", "type_evaluation", "enseignements", 'section', 'enseignants', 'section_id', 'annees', 'filieres'],
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
                mdiContentSaveEditOutline,
                mdiEye,
            },
            headers: [{
                    title: 'Matiere',
                    align: 'center',
                    key: 'matiere'
                },
                {
                    title: 'Classe',
                    align: 'center',
                    key: 'classe'
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
                    key: 'libelle'
                },
                {
                    title: 'Notation',
                    align: 'center',
                    key: 'notation'
                },
                {
                    title: 'Actions',
                    align: 'center',
                    key: 'actions'
                },
            ],
            notation: false,
            dialog_title: 'Nouvelle Evaluation',
            dialog: false,
            dialogEdit: false,
            dialogDetail: false,
            date: '',
            pourcentage: null,
            type: null,
            periode: null,
            enseignant: null,
            code: null,
            matiere: null,
            filtrer: [],
            libelle: null,
            form: useForm({
                session : null,
                notation: null,
                section_id: null,
                date: '',
                type_evaluation_id: null,
                periode_id: null,
                enseignement_annee_id: null,
                enseignant_id: null,
                annee_id: null,
                filiere: null,
                matieres: null,
                niveau: null,
            }),
        }
    },
    methods: {
        create() {
            this.dialog = true
            this.dialog_title = 'Nouvelle Evaluation'
        },
        editItem(item) {
            // console.log(item)
            this.form.id = item.id,
            this.form.date = item.date,
            this.form.periode_id = item.periode_id,
            this.form.type_evaluation_id = item.type_evaluation_id
            this.form.enseignement_annee_id = item.enseignement_annee_id
            this.form.enseignant_id = item.enseignant_id,
            this.form.annee_id = item.annee_id,
            this.form.filiere = item.filiere_id,
            this.form.matieres = item.matiere_id,
            this.form.session = item.session
            this.form.niveau = item.niveau_id,
            this.form.notation = item.notation
            this.libelle = this.type_evaluation.filter(el => el.id == item.type_evaluation_id)
            if (this.libelle[0].libelle == "Devoir" || this.libelle[0].libelle == "Interrogation" || this.libelle[0].libelle == "Contrôle") {
                this.notation = true
            } else {
                this.notation = false
            }
            this.dialogEdit = true,
                this.dialog_title = 'Modifier Evaluation',
                this.$inertia.replace(this.$page.url, {
                    data: {
                        enseignant_id: item.enseignant_id,
                        annee_id: item.annee_id,
                        // section_id : this.section_id,
                        niveau: item.niveau_id,
                        filiere: item.filiere_id,
                    }
                })
        },
        deleteItem(item) {
            this.$swal({
                title: 'Etes-vous sûr de vouloir supprimer cette evaluation',
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
        async submit() {
            const {
                valid
            } = await this.$refs.form.validate()
            if (!this.form.id && valid) {
                // console.log(this.form.session)
                this.form.section_id = this.section_id
                this.form.post(route('evaluation.store'), {
                    onFinish: () => {
                        this.close()
                        if (this.$page.props.flash ?.message ?.type == 'error') {
                            this.$swal({
                                icon: 'error',
                                title: 'Attention!!!',
                                text: this.$page.props.flash ?.message ?.text,
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 10000,
                                timerProgressBar: true,
                            });
                        } else if (this.$page.props.flash ?.message ?.type == 'success') {
                            this.$swal({
                                title: "Information!!!",
                                icon: "info",
                                text: this.$page.props.flash ?.message ?.text,
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 10000,
                                timerProgressBar: true,
                            })
                        }
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
                // console.log(this.form)
                this.form.section_id = this.section_id
                this.form.put(route('evaluation.update', this.form.id), {
                    onFinish: () => {
                        // this.close()
                        this.closeEdit()
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
            this.form.periode_id = null
            this.form.type_evaluation_id = null
            this.form.enseignement_annee_id = null
            this.form.enseignant_id = null,
            this.form.annee_id = null,
            this.form.filiere = null,
            this.form.matieres = null,
            this.form.niveau = null
            this.form.session = null
                this.form.notation = null
            this.dialog = false,
                this.notation = false
        },
        closeEdit() {
            this.form.id = null
            this.form.session = null
            this.form.matieres = null,
            this.form.date = null
            this.form.periode_id = null
            this.form.type_evaluation_id = null
            this.form.enseignement_annee_id = null
            this.form.enseignant_id = null,
                this.form.annee_id = null,
                this.form.filiere = null,
                this.form.matiere = null,
                this.form.niveau = null
            this.dialogEdit = false
        },
        setMatiere(a) {
            this.form.enseignement_annee_id = null
            this.$inertia.replace(this.$page.url, {
                data: {
                    enseignant_id: this.form.enseignant_id,
                    annee_id: a
                }
            })
        },
        setFiliere(a) {
            this.form.filiere = null,
                this.form.enseignement_annee_id = null
            this.$inertia.replace(this.$page.url, {
                data: {
                    enseignant_id: this.form.enseignant_id,
                    annee_id: a
                }
            })
        },
        setClasse(n) {
            // console.log(n)
            this.form.matiere = null,
                this.form.classe = null
            router.replace(this.$page.url, {
                data: {
                    niveau: n,
                    filiere: this.form.filiere,
                    annee_id: this.form.annee_id,
                }
            })
        },
        Notation(t) {
            this.form.session = null
            this.libelle = this.type_evaluation.filter(el => el.id == t)
            if (this.libelle[0].libelle == "Devoir" || this.libelle[0].libelle == "Interrogation" || this.libelle[0].libelle == "Contrôle"|| this.libelle[0].libelle == "Composition") {
                this.notation = true
            } else {
                this.notation = false
            }
        },
    },
    mounted() {
        if (this.section_id == 1) {
            this.filtrer = this.type_evaluation.filter(el => el.libelle == "Composition" || el.libelle == "Contrôle")
        }
        if (this.section_id == 2) {
            this.filtrer = this.type_evaluation.filter(el => el.libelle != "Contrôle")
        }
        if (this.section_id == 3 || this.section_id == 4) {
            this.filtrer = this.type_evaluation.filter(el => el.libelle == "Examen" || el.libelle == "TP" || el.libelle == "Devoir")
        }
        // console.log(this.evaluations)
    },
}
</script>

<template>
<!-- <Head title="Dashboard" /> -->

<!-- <AuthenticatedLayout> -->
<v-card>
    <Toolbar :icon="icon.mdiAccountPlusOutline" toolbarTitle="Gestion des evaluations"></Toolbar>
    <v-card-text>
        <br>
        <v-dialog v-model="dialog" transition="dialog-top-transition" persistent width="900px">
            <v-card>
                <v-toolbar dense color="secondary" dark>
                    <v-toolbar-title>
                        <v-icon left>{{ icon.mdiPlusCircle }}</v-icon> {{ dialog_title }}
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-icon :icon="icon.mdiCloseCircle" title="Annuler" size="large" style="margin:10px" color="white" @click="close()"></v-icon>
                </v-toolbar>
                <v-card-text>
                    <v-form ref="form">
                        <v-container>
                            <v-row>
                                <v-col cols="3">
                                    <TextField label="Date Evaluation" type="date" variant="outlined" placeholder="Date" v-model="form.date" :isRequired="true" :rules="[v => !!v || 'Ce champ est requis!']">
                                    </TextField>
                                </v-col>
                                <v-col cols="3">
                                    <Autocomplete label="Type Evaluation" variant="outlined" itemTitle="libelle" item-value="id" :items="filtrer" v-model="form.type_evaluation_id" @update:modelValue="Notation(form.type_evaluation_id)" :rules="[v => !!v || 'Ce champ est requis!'] " chips clearable :isRequired="true">
                                    </Autocomplete>
                                </v-col>
                                <v-col cols="3" >
                                    <Autocomplete label="Enseignants" v-model="form.enseignant_id" variant="outlined" itemTitle="nom_prenom" item-value="id" :items="enseignants" :rules="[v => !!v || 'Ce champ est requis!'] " chips clearable :isRequired="true">
                                    </Autocomplete>
                                </v-col>
                                <v-col cols="3">
                                    <Autocomplete label="Periodes" variant="outlined" itemTitle="libelle" item-value="id" :items="periodes" v-model="form.periode_id" :rules="[v => !!v || 'Ce champ est requis!'] " chips clearable :isRequired="true">
                                    </Autocomplete>
                                </v-col>
                                <v-col cols="3" v-if="section_id>=3">
                                    <Autocomplete label="Annees scolaire" v-model="form.annee_id" @update:modelValue="setFiliere(form.annee_id)" variant="outlined" itemTitle="libelle" item-value="id" :items="annees" :rules="[v => !!v || 'Ce champ est requis!'] " chips clearable :isRequired="true">
                                    </Autocomplete>
                                </v-col>
                                <v-col cols="3" v-if="section_id<=2">
                                    <Autocomplete label="Annees scolaire" v-model="form.annee_id" @update:modelValue="setMatiere(form.annee_id)" variant="outlined" itemTitle="libelle" item-value="id" :items="annees" :rules="[v => !!v || 'Ce champ est requis!'] " chips clearable :isRequired="true">
                                    </Autocomplete>
                                </v-col>
                                <v-col md="3" v-if="section_id>=3">
                                    <Autocomplete  v-model="form.filiere" :items="filieres" itemTitle="formatCode" item-value="id" outlined required dense chips small-chips label="Filieres"></Autocomplete>
                                </v-col>
                                <v-col md="3" v-if="section_id>=3 ">
                                    <Autocomplete v-model="form.niveau" @update:modelValue="setClasse(form.niveau)" :items="niveaux" itemTitle="code" item-value="id" outlined required dense chips small-chips label="Niveaux"></Autocomplete>
                                </v-col>
                                <v-col md="3" v-if="section_id>=3 ">
                                    <Autocomplete v-model="form.matieres" :items="matieres" itemTitle="nom" item-value="id" outlined required dense small-chips label="Matieres" chips clearable></Autocomplete>
                                </v-col>
                                <v-col cols="3" v-if="section_id <=2">
                                    <Autocomplete :disabled="!form.annee_id" label="Matiére/Classe" variant="outlined" itemTitle="code" item-value="id" :items="enseignements" v-model="form.enseignement_annee_id " :rules="[v => !!v || 'Ce champ est requis!'] " chips clearable multiple>
                                    </Autocomplete>
                                </v-col>
                                <v-col cols="4" v-if="section_id <=2 && notation">
                                    <TextField :prepend-inner-icon="icon.mdiPencil" hint="Sur combien vous voulez noter cette evaluation (Ex:/10,20,40...)" label="Notation" variant="outlined" placeholder="Notation" v-model="form.notation">
                                    </TextField>
                                </v-col>
                                <v-col cols="3" v-if="section_id>=3 && form.type_evaluation_id == 6" >
                                    <v-radio-group inline label="Sessions ?" v-model="form.session" :rules="[v => !!v || 'Ce champ est requis!'] ">
                                        <v-radio label="1ère" value="Session 1"></v-radio>
                                        <v-radio label="2ème" value="Session 2"></v-radio>
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
        <v-dialog v-model="dialogEdit" transition="dialog-top-transition" persistent width="900px">
            <v-card>
                <v-toolbar dense color="secondary" dark>
                    <v-toolbar-title>
                        <v-icon left>{{ icon.mdiPencil}}</v-icon> {{ dialog_title }}
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-icon :icon="icon.mdiCloseCircle" title="Annuler" size="large" style="margin:10px" color="white" @click="closeEdit()"></v-icon>
                </v-toolbar>
                <v-card-text>
                    <v-form ref="form">
                        <v-container>
                            <v-row>
                                <v-col cols="3">
                                    <TextField label="Date Evaluation" type="date" variant="outlined" placeholder="Date" v-model="form.date" :isRequired="true" :rules="[v => !!v || 'Ce champ est requis!']">
                                    </TextField>
                                </v-col>
                                <v-col cols="3">
                                    <Autocomplete label="Type Evaluation" variant="outlined" itemTitle="libelle" item-value="id" :items="type_evaluation" v-model="form.type_evaluation_id" @update:modelValue="Notation(form.type_evaluation_id)" :rules="[v => !!v || 'Ce champ est requis!'] " chips clearable :isRequired="true">
                                    </Autocomplete>
                                </v-col>
                                <v-col cols="3">
                                    <Autocomplete label="Enseignants" v-model="form.enseignant_id" @update:modelValue="setFiliere(form.enseignant_id)" variant="outlined" itemTitle="nom_prenom" item-value="id" :items="enseignants" :rules="[v => !!v || 'Ce champ est requis!'] " chips clearable :isRequired="true">
                                    </Autocomplete>
                                </v-col>
                                <v-col cols="3">
                                    <Autocomplete label="Periodes" variant="outlined" itemTitle="libelle" item-value="id" :items="periodes" v-model="form.periode_id" :rules="[v => !!v || 'Ce champ est requis!'] " chips clearable :isRequired="true">
                                    </Autocomplete>
                                </v-col>
                                <v-col cols="3" v-if="section_id>=3">
                                    <Autocomplete label="Annees scolaire" v-model="form.annee_id" variant="outlined" itemTitle="libelle" item-value="id" :items="annees" :rules="[v => !!v || 'Ce champ est requis!'] " chips clearable :isRequired="true">
                                    </Autocomplete>
                                </v-col>
                                <v-col cols="3" v-if="section_id<=2">
                                    <Autocomplete label="Annees scolaire" v-model="form.annee_id" @update:modelValue="setMatiere(form.annee_id)" variant="outlined" itemTitle="libelle" item-value="id" :items="annees" :rules="[v => !!v || 'Ce champ est requis!'] " chips clearable :isRequired="true">
                                    </Autocomplete>
                                </v-col>
                                <v-col md="3" v-if="section_id>=3">
                                    <Autocomplete v-model="form.filiere" :items="filieres" itemTitle="formatCode" item-value="id" outlined required dense chips small-chips label="Filieres" :rules="[v => !!v || 'Ce champ est requis!'] " :isRequired="true"></Autocomplete>
                                </v-col>
                                <v-col md="3" v-if="section_id>=3">
                                    <Autocomplete v-model="form.niveau" @update:modelValue="setClasse(form.niveau)" :items="niveaux" itemTitle="code" item-value="id" outlined required dense chips small-chips label="Niveaux" :rules="[v => !!v || 'Ce champ est requis!'] " :isRequired="true"></Autocomplete>
                                </v-col>
                                <v-col md="3" v-if="section_id>=3">
                                    <Autocomplete v-model="form.matieres" :items="matieres" itemTitle="nom" item-value="id" outlined required dense chips small-chips label="Matieres" :isRequired="true"></Autocomplete>
                                </v-col>
                                <v-col cols="3" v-if="section_id <=2">
                                    <Autocomplete :disabled="!form.annee_id" label="Matiére/Classe" variant="outlined" itemTitle="code" item-value="id" :items="enseignements" v-model="form.enseignement_annee_id " :rules="[v => !!v || 'Ce champ est requis!'] " chips clearable :isRequired="true">
                                    </Autocomplete>
                                </v-col>
                                <v-col cols="3" v-if="section_id <=2 && notation">
                                    <TextField :prepend-inner-icon="icon.mdiPencil" hint="Sur combien vous voulez noter cette evaluation (Ex:/10,20,40...)" label="Notation" variant="outlined" placeholder="Notation" v-model="form.notation" :rules="[v => !!v || 'Ce champ est requis!'] "  :isRequired="true">
                                    </TextField>
                                </v-col>
                                <v-col cols="3" v-if="section_id>=3 && form.type_evaluation_id == 6" >
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
                    <Button class="mb-2" style="height: 30px" nameButton="Modifier" title="Valider et Fermer la modale" small color="primary" variant="outlined" :prependIcon="icon.mdiPencil" @click="submit">
                    </Button>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <Datatable titleDatatable="Liste des evaluations " :headers="headers" :items="evaluations" :permission="'manage_school|inscription'" :functionOnClickAddButton="create">
            <template v-slot:[`item.actions`]="{ item }">
                <v-icon size="small" color="warning" title="Modifier" class="me-2" @click="editItem(item)" :icon="icon.mdiPencil">
                </v-icon>
                <v-icon size="small" color="error" @click="deleteItem(item)" :icon="icon.mdiDelete">
                </v-icon>
            </template>
        </Datatable>
    </v-card-text>
</v-card>
<!-- </AuthenticatedLayout> -->
</template>
