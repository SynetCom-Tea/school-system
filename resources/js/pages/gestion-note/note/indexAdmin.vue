<template>
<AuthenticatedLayout>
    <Toolbar :icon="icon.mdiAccountPlusOutline" toolbarTitle="Gestion des notes"></Toolbar>
    <br>
    <div style="margin: 20px">
        <Button class="mb-2" style="height: 40px" nameButton="Ajouter" title="Valider et Fermer la modale" small color="primary" variant="outlined" :prependIcon="icon.mdiPlus" @click="create">
        </Button>
    </div>
    <v-card variant="outlined" style="border: 2px solid #7d002c;margin: 20px">
        <v-card-title style="color: white; background-color: #7d002c">Choisissez les criteres</v-card-title>
        <v-divider></v-divider>
        <br />
        <v-row>
            <v-col md="1"></v-col>
            <v-col md="2" >
                    <Autocomplete  v-model="form.annee" :items="annees" item-title="libelle" item-value="id"  outlined required dense chips small-chips label="Années academiques" @update:modelValue="setClasse(form.annee)"></Autocomplete>
                </v-col>
            <v-col md="3">
                <Autocomplete v-model="form.classe" :items="classes" :item-title="formatClasseLabel" item-value="id" @update:modelValue="requete(form.classe)" outlined required dense chips small-chips label="Classes"></Autocomplete>
            </v-col>
            <v-col md="3">
                <Autocomplete v-model="form.evaluation" :disabled="!form.classe" :items="evaluations " :item-title="formatEvaluationLabel" item-value="id" outlined required dense chips small-chips label="Evaluations"></Autocomplete>
            </v-col>
            <v-col md="3">
                <Button color="secondary" variant="outlined" class="mb-3" @click="rechercher()" nameButton="Recherche.." title="Rechercher..." style="height: 40px" :prependIcon="icon.mdiSearchWeb" :loading="form.processing" :disabled="!form.classe || !form.evaluation"></Button>
            </v-col>
            <v-col md="2"></v-col>
        </v-row>
    </v-card>
    <v-dialog v-model="dialogEdit" transition="dialog-top-transition" persistent width="500px">
        <template v-slot:default="{ isActive }">
            <v-card>
                <v-toolbar dense style="background-color: #7d002c">
                    <v-toolbar-title style="color: white">
                        <v-icon left :icon="icon.mdiPencil"></v-icon> Modification
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-icon :icon="icon.mdiCloseCircle" title="Annuler" size="large" style="margin: 10px" color="white" @click="closeEdit()"></v-icon>
                </v-toolbar>
                <v-card-text>
                    <v-form>
                        <v-row>
                            <v-col md="12">
                                <TextField label="Evaluation" class="mt-1" disabled v-model="form.type_matiere">
                                </TextField>
                            </v-col>
                            <v-col md="12">
                                <TextField v-model="form.nom_prenom" disabled label="Nom et prenom">
                                </TextField>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col md="12">
                                <TextField label="Note" v-model="form.note" :rules="[rules.required, rules.validator,rules.max]">
                                </TextField>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-card-text>
                <v-card-actions class="justify-end">
                    <v-spacer></v-spacer>
                    <Button variant="outlined" :loading="form.processing" class="mb-2" nameButton="Modifier" title="Valider et Fermer la modale" style="height: 30px" :prependIcon="icon.mdiPencil" @click="update"></Button>
                </v-card-actions>
            </v-card>
        </template>
    </v-dialog>
    <v-card style="border: 2px solid #7d002c;margin: 20px">
        <v-card-title style="color: white; background-color: #7d002c">Liste des notes</v-card-title>
        <v-divider></v-divider>
        <br/>
        <Datatable titleDatatable="Listes des notes"  :displayAddButton="false" :items="notes" :headers="headers">
            <template v-slot:item.apprenant="{ item}">
                {{ item.apprenant.nom }} {{ item.apprenant.prenom }}
            </template>
            <template v-slot:item.action="{ item}">
                <v-icon color="warning" :icon="icon.mdiPencil" @click="edit(item)"></v-icon>
                <v-icon color="red" :icon="icon.mdiDelete" @click="deleteItem(item)"></v-icon>
            </template>
        </Datatable>
    </v-card>
</AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {
    Head,
    router,
    useForm
} from "@inertiajs/vue3";
import {
    mdiPlus,
    mdiPencil,
    mdiDelete,
    mdiCloseCircle,
} from '@mdi/js'
export default {
    components: {
        mdiPlus,
        mdiPencil,
        mdiDelete,
        mdiCloseCircle,
    },
    layout: AuthenticatedLayout,
    props: ['classes', 'evaluations', 'notes','annees', 'type'],
    data() {
        return {
            icon: {
                mdiPlus,
                mdiPencil,
                mdiDelete,
                mdiCloseCircle,
            },
            dialogEdit: false,
            headers: [{
                    title: '#',
                    align: 'start',
                    key: 'apprenant.matricule',
                    sortable: false,
                },
                {
                    title: "Nom",
                    align: "center",
                    key: "apprenant"
                },
                {
                    title: "Note",
                    align: "center",
                    key: "note"
                },
                {
                    title: "Action",
                    align: "center",
                    key: "action"
                },
            ],
            rules: {
                required: v => !!v || "Veuillez renseigner la note",
                validator: v => !(Math.sign(v) == -1) || "La note doit être positif",
                max: v => (this.evaluations[0].notation || this.evaluations[0].enseignement_annee.niveau_matiere.notation) >= v || "La note ne doit pas dépasser " + (this.evaluations[0].notation || this.evaluations[0].enseignement_annee.niveau_matiere.notation)
            },
            format: useForm({
                section_id: null,
            }),
            form: useForm({
                section_id: null,
                type_matiere: null,
                nom_prenom: null,
                id_note: null,
                note: null,
                annee : null,
                classe : null,
                evaluation : null
            }),

        }
    },
    methods: {
        create() {
            this.format.section_id = this.type,
            this.format.get(route('note.attribution_admin'))
        },
        formatEvaluationLabel(item) {
            if (item.enseignement_annee.niveau_matiere) {
                return `${item ? item?.type_evaluation?.libelle : 'Pas de données'} - ${item ? item?.enseignement_annee?.niveau_matiere?.matiere?.nom : ''}`;
            } else {
                return `${item ? item?.type_evaluation?.libelle : 'Pas de données'} - ${item ? item?.enseignement_annee?.filiere_niveau_matiere_ue?.matiere?.nom : ''}`;
            }
        },
        formatClasseLabel(item){
            if (this.type >= 3) {
                return `${item ? item?.cycle_filiere.filiere.code : 'Pas de données'} - ${item ? item.niveau.code : 'Pas de données'} - ${item ? item.libelle : 'Pas de données'}`
            }
            else{
                return `${item ? item?.libelle : 'Pas de données'}`;
            }
        },
        rechercher() {
            router.replace(this.$page.url, {
                data: {
                    evaluation: this.form.evaluation,
                }
            });
            // console.log('je suis la',this.selectedClasse,this.selectedEvaluation)
        },
        setClasse(a) {
            // console.log(this.form)
            this.form.classe = null,
            router.replace(this.$page.url, {
                data: {
                    annee: a,
                }
            });
        },
        requete(id) {
            // console.log(this.type)
            this.form.evaluation = null,
            router.replace(this.$page.url, {
                data: {
                    classe: id,
                }
            });
            // console.log('id',id)   
        },
        edit(item) {
            // console.log(item)
            this.dialogEdit = true,
            this.form.id_note = item.id,
            this.form.note = item.note,
            this.form.nom_prenom = item.apprenant.nom + ' ' + item.apprenant.prenom
            if(item.evaluation.enseignement_annee.niveau_matiere){
            this.form.type_matiere = item.evaluation.type_evaluation.libelle + '-' + item.evaluation.enseignement_annee.niveau_matiere.matiere.nom
            }
            else{
            this.form.type_matiere = item.evaluation.type_evaluation.libelle + '-' + item.evaluation.enseignement_annee.filiere_niveau_matiere_ue.matiere.nom
            }
        },
        closeEdit() {
            this.dialogEdit = false
        },
        deleteItem(item){
            this.$swal({
                title: 'Etes-vous sûr de vouloir supprimer cette note',
                text: "Vous ne pourrez pas revenir en arrière!!!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'orange',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimez-le!',
                cancelButtonText: 'Non, annulez!',
            }).then((result) => {
                if (result.isConfirmed) {
                    this.form.delete(route('note.destroy', item.id), {
                        onFinish: () => {
                        if (this.$page.props.flash ?.message ?.type == 'success') {
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
        update() {
            if (this.form.note <= 20) {
                this.form.put(route("note.update", this.form.id_note), {
                    onSuccess: () => {
                        this.isLoading = false;
                        this.dialogEdit = false;
                        if (this.$page.props.flash ?.message ?.type == 'success') {
                            this.$swal({
                                icon: 'success',
                                title: 'Modification',
                                text: this.$page.props.flash ?.message ?.text,
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 10000,
                                timerProgressBar: true,
                            });
                        }

                    },
                })
            } else {
                this.dialogEdit = false
                this.$swal({
                    icon: 'warning',
                    title: 'Attention',
                    text: 'La note ne doit pas dépasser 20',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 10000,
                    timerProgressBar: true,
                });
            }
        },
    },
}
</script>
