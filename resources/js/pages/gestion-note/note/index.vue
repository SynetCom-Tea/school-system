<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import FiltreAffichageNote from "@/Components/Gestion-note/FiltreAffichageNote.vue";
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
        FiltreAffichageNote,
        mdiPlus,
        mdiPencil,
        mdiDelete,
        mdiCloseCircle,
    },
    layout: AuthenticatedLayout,
    props: ['classes', 'evaluations', 'notes', 'type'],
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
                    title: 'Matricule',
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
                max: v => v <= 20 || "La note ne doit pas dépasser 20"
            },
            form: useForm({
                section_id: null,
                type_matiere: null,
                nom_prenom: null,
                id_note: null,
                note: null
            }),

        }
    },
    methods: {
        create() {
            this.form.section_id = this.type
            this.form.get(route('note.attribution'))
        },
        edit(item) {
            // console.log(item)
            this.dialogEdit = true
            this.form.id_note = item.id
            this.form.note = item.note
            if(item.evaluation.enseignement_annee.niveau_matiere){
            this.form.type_matiere = item.evaluation.type_evaluation.libelle + '-' + item.evaluation.enseignement_annee.niveau_matiere.matiere.nom
            }
            else{
            this.form.type_matiere = item.evaluation.type_evaluation.libelle + '-' + item.evaluation.enseignement_annee.filiere_niveau_matiere_ue.matiere.nom
            }
            this.form.nom_prenom = item.apprenant.nom + ' ' + item.apprenant.prenom
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
                this.dialogEdit = false;
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

        }
    }
}
</script>

<template>
    <Toolbar :icon="icon.mdiAccountPlusOutline" toolbarTitle="Gestion des notes"></Toolbar>
    <br>
    <div style="margin: 20px">
        <Button class="mb-2" style="height: 40px" nameButton="Ajouter" title="Valider et Fermer la modale" small color="primary" variant="outlined" :prependIcon="icon.mdiPlus" @click="create" v-permission:any="'note.create'">
        </Button>
    </div>

    <v-card variant="outlined" style="border: 2px solid rgb(0, 73, 128);margin: 20px">
        <v-card-title style="color: white; background-color: rgb(0, 73, 128)">Choisissez les criteres</v-card-title>
        <v-divider></v-divider>
        <br />
        <FiltreAffichageNote :classes="classes" :evaluations="evaluations" :type="type"></FiltreAffichageNote>
    </v-card>
    <v-dialog v-model="dialogEdit" transition="dialog-top-transition" persistent width="500px">
        <template v-slot:default="{ isActive }">
            <v-card>
                <v-toolbar dense style="background-color: rgb(0, 73, 128)">
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
                                <TextField label="Note" v-model="form.note" :rules="[rules.required, rules.validator, rules.max]">
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
    <v-card style="border: 2px solid rgb(0, 73, 128);margin: 20px">
        <v-card-title style="color: white; background-color: rgb(0, 73, 128)">Liste des notes</v-card-title>
        <v-divider></v-divider>
        <br />
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
</template>
