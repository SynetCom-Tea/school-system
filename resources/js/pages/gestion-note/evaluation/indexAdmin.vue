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
    mdiEye,
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
        mdiContentSaveEditOutline,
        mdiEye,
    },
    layout: AuthenticatedLayout,
    props: ["evaluations", "types", "evaluation_id", "details", "periodes", "type_evaluation", "enseignements",'section','enseignants'],
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
                    title: 'Enseignant',
                    align: 'center',
                    key: 'nom'
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
                    title: 'Sections',
                    align: 'center',
                    key: 'section'
                },
                {
                    title: 'Actions',
                    align: 'center',
                    key: 'actions'
                },
            ],
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
            matiere :null,
            form: useForm({
                date: '',
                pourcentage: null,
                type_evaluation_id: null,
                periode_id: null,
                enseignement_annee_id: null,
                section_id : null,
                enseignant_id : null
            }),
        }
    },

    methods: {
        create() {
            this.dialog = true
            this.dialog_title = 'Nouvelle Evaluation'
        },
        editItem(item) {
            this.form.id = item.id
            this.form.date = item.date
            this.form.pourcentage = item.pourcentage
            this.form.periode_id = item.periode_id
            this.form.type_evaluation_id = item.type_evaluation_id
            this.form.enseignement_annee_id = item.enseignement_annee_id
            this.form.section_id = item.section_id
            this.form.enseignant_id = item.enseignant_id
            this.dialogEdit = true
            this.dialog_title = 'Modifier Evaluation' + ' ' + item.code
            this.$inertia.replace(this.$page.url,{
                data : {
                    section_id : item.section_id,
                    enseignant_id : item.enseignant_id
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
                // console.log(this.form)
                this.form.put(route('evaluation.update', this.form.id), {
                    onFinish: () => {
                        this.close()
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
            this.form.pourcentage = null
            this.form.periode_id = null
            this.form.type_evaluation_id = null
            this.form.enseignement_annee_id = null
            this.dialog = false
        },
        closeEdit() {
            this.form.id = null
            this.form.date = null
            this.form.pourcentage = null
            this.form.periode_id = null
            this.form.type_evaluation_id = null
            this.form.enseignement_annee_id = null
            this.dialogEdit = false
        },
        detail(item) {
            this.$inertia.replace(this.$page.url, {
                data: {
                    evaluation_id: item.id,
                },
                
            })
            console.log(this.details[0].nom)
            
            // if (this.evaluation_id ){
            //     this.dialogDetail = true
            //     this.date = item.date
            //     this.pourcentage = item.pourcentage
            //     this.periode = item.libelle
            //     this.type = item.type
            //     this.enseignant = item.nom
            //     this.code = item.code
            //     this.matiere = this.details[0].nom
            // }
        },
        setPeriode(s){
            this.form.periode_id = null,
            this.form.enseignement_annee_id = null
            this.$inertia.replace(this.$page.url,{
                data : {
                    section_id : s
                }
            })
        },
        setMatiere(e){
            this.$inertia.replace(this.$page.url,{
                data : {
                    enseignant_id : e
                }
            })
        }
    },
}
</script>

<template>
<Head title="Dashboard" />

<AuthenticatedLayout>
    <v-card>
        <Toolbar :icon="icon.mdiAccountPlusOutline" toolbarTitle="Gestion des evaluations"></Toolbar>
        <v-card-text>
            <br>
            <v-dialog v-model="dialogDetail" max-width="700">
                <v-card>
                    <v-toolbar dark color="secondary">
                        <v-toolbar-title>
                            Détail de l'evaluation <v-icon size="large"> </v-icon>
                        </v-toolbar-title>
                    </v-toolbar>
                    <v-card-text>
                        <v-card flat class="mt-3 mb-6">
                            <v-card>
                                <v-table dense>
                                    <tbody>
                                        <tr>
                                            <td class="font-weight-black">Type Evaluation:</td>
                                            <td>{{ type }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-black">Nom Enseignant:</td>
                                            <td>{{ enseignant }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-black">Date Evaluation</td>
                                            <td>{{ date }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-black">Periode :</td>
                                            <td>{{ periode }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-black">Matiere :</td>
                                            <td>{{ matiere }}</td>
                                        </tr>
                                    </tbody>
                                </v-table>
                            </v-card>
                        </v-card>
                    </v-card-text>
                    <v-card-actions class="justify-end" id="actions">
                        <v-btn color="danger" variant="text" @click="dialogDetail = false"> Fermer </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <v-dialog v-model="dialog" transition="dialog-top-transition" persistent width="900px">
                <v-card>
                    <v-toolbar dense color="secondary" dark>
                        <v-toolbar-title>
                            <v-icon left>{{  icon.mdiPlusCircle }}</v-icon> {{ dialog_title }}
                        </v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-icon :icon="icon.mdiCloseCircle" title="Annuler" size="large" style="margin:10px" color="white" @click="close()"></v-icon>
                    </v-toolbar>
                    <v-card-text>
                        <v-form ref="form">
                            <v-container>
                                <v-row>
                                    <v-col cols="6">
                                        <TextField label="Date Evaluation" type="date" variant="outlined" placeholder="Date" v-model="form.date" :isRequired="true" :rules="[v => !!v || 'Ce champ est requis!']">
                                        </TextField>
                                    </v-col>
                                    <v-col cols="6">
                                        <Autocomplete v-model="form.section_id" label="Sections" @update:modelValue="setPeriode(form.section_id)" itemTitle="libelle" itemValue="id" :items="section" variant="outlined" :isRequired="true" :rules="[v => !!v || 'Ce champ est requis!'] " chips clearable>
                                        </Autocomplete>
                                    </v-col>
                                    <v-col cols="6">
                                        <Autocomplete label="Type Evaluation" variant="outlined" item-title="libelle" item-value="id" :items="type_evaluation" v-model="form.type_evaluation_id" :rules="[v => !!v || 'Ce champ est requis!'] " chips clearable :isRequired="true">
                                        </Autocomplete> 
                                    </v-col>
                                    <v-col cols="6">
                                        <Autocomplete label="Enseignants" v-model="form.enseignant_id" @update:modelValue="setMatiere(form.enseignant_id)"   variant="outlined" item-title="matricule" item-value="id" :items="enseignants"  :rules="[v => !!v || 'Ce champ est requis!'] " chips clearable :isRequired="true">
                                        </Autocomplete>
                                    </v-col>
                                    <v-col cols="6">
                                        <Autocomplete v-if="form.section_id" label="Periodes" variant="outlined" item-title="libelle" item-value="id" :items="periodes" v-model="form.periode_id" :rules="[v => !!v || 'Ce champ est requis!'] " chips clearable :isRequired="true">
                                        </Autocomplete>
                                    </v-col>
                                    <v-col cols="6">
                                        <Autocomplete v-if="form.section_id && form.enseignant_id" label="Matiére/Classe" variant="outlined" item-title="code" item-value="id" :items="enseignements" v-model="form.enseignement_annee_id " :rules="[v => !!v || 'Ce champ est requis!'] " chips clearable>
                                        </Autocomplete> 
                                    </v-col>
                                    <v-col cols="6">
                                        <TextField v-if="form.section_id >= 3" :prepend-inner-icon="icon.mdiPercentOutline" label="Pourcentage" variant="outlined" placeholder="pourcentage" v-model="form.pourcentage" :isRequired="true" :rules="[v => !!v || 'Ce champ est requis!']">
                                        </TextField>
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
                            <v-icon left>{{  icon.mdiPencil}}</v-icon> {{ dialog_title }}
                        </v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-icon :icon="icon.mdiCloseCircle" title="Annuler" size="large" style="margin:10px" color="white" @click="closeEdit()"></v-icon>
                    </v-toolbar>
                    <v-card-text>
                        <v-form ref="form">
                            <v-container>
                                <v-row>
                                    <v-col cols="6">
                                        <TextField label="Date Evaluation" type="date" variant="outlined" placeholder="Date" v-model="form.date" :isRequired="true" :rules="[v => !!v || 'Ce champ est requis!']">
                                        </TextField>
                                    </v-col>
                                    <v-col cols="6">
                                        <Autocomplete v-model="form.section_id"  @update:modelValue="setPeriode(form.section_id)" label="Sections" itemTitle="libelle" itemValue="id" :items="section" variant="outlined" :isRequired="true" :rules="[v => !!v || 'Ce champ est requis!'] " chips clearable>
                                        </Autocomplete>
                                    </v-col>
                                    <v-col cols="6">
                                        <Autocomplete label="Type Evaluation" variant="outlined" item-title="libelle" item-value="id" :items="type_evaluation" v-model="form.type_evaluation_id" :rules="[v => !!v || 'Ce champ est requis!'] " chips clearable :isRequired="true">
                                        </Autocomplete> 
                                    </v-col>
                                    <v-col cols="6">
                                        <Autocomplete label="Enseignants" v-model="form.enseignant_id" @update:modelValue="setMatiere(form.enseignant_id)"   variant="outlined" item-title="matricule" item-value="id" :items="enseignants"  :rules="[v => !!v || 'Ce champ est requis!'] " chips clearable :isRequired="true">
                                        </Autocomplete>
                                    </v-col>
                                    <v-col cols="6">
                                        <Autocomplete v-if="form.section_id" label="Periodes" variant="outlined" item-title="libelle" item-value="id" :items="periodes" v-model="form.periode_id" :rules="[v => !!v || 'Ce champ est requis!'] " chips clearable :isRequired="true">
                                        </Autocomplete>
                                    </v-col>
                                    <v-col cols="6">
                                        <Autocomplete label="Matiére/Classe" variant="outlined" item-title="code" item-value="id" :items="enseignements" v-model="form.enseignement_annee_id " :rules="[v => !!v || 'Ce champ est requis!'] " chips clearable>
                                        </Autocomplete> 
                                    </v-col>
                                    <v-col cols="6">
                                        <TextField v-if="form.section_id >= 3" :prepend-inner-icon="icon.mdiPercentOutline" label="Pourcentage" variant="outlined" placeholder="pourcentage" v-model="form.pourcentage" :isRequired="true" :rules="[v => !!v || 'Ce champ est requis!']">
                                        </TextField>
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
            <Datatable titleDatatable="Listes des evaluations " :headers="headers" :items="evaluations" :functionOnClickAddButton="create">
                <template v-slot:[`item.actions`]="{ item }">
                    <v-icon size="small" color="info" title="details" class="me-2" @click="detail(item.raw)" :icon="icon.mdiEye">
                    </v-icon>
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
