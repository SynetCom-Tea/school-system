<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {
    Head
} from "@inertiajs/vue3";
import {
    router,
    usePage,
    useForm
} from "@inertiajs/vue3";
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
    mdiSearchWeb
} from '@mdi/js'
export default {
    components: {
        mdiAccountSchool,
        mdiSearchWeb,
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
    props: ['enseignants', 'annees', 'classes', 'evaluations', 'eleves', 'type', 'filieres', 'niveaux'],
    layout: AuthenticatedLayout,
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
                mdiSearchWeb
            },
            tabs: [],
            valid: null,
            dialogConfirmation: false,
            searchQuery: null,
            headers: [{
                    title: '#',
                    align: 'start',
                    key: 'matricule',
                    sortable: false,
                },
                {
                    title: "Nom",
                    align: "center",
                    key: "nom_complete"
                },
                {
                    title: "Note",
                    align: "center",
                    key: "note"
                },
            ],
            rules: {
                required: v => !!v || "Veuillez renseigner la note",
                validator: v => !(Math.sign(v) == -1) || "La note doit être positif",
                max: v => {
                            if (this.evaluations[0].notation) {
                                 return v <= this.evaluations[0].notation || "La note ne doit pas dépasser " + this.evaluations[0].notation;
                        } else if (this.evaluations[0].enseignement_annee.niveau_matiere_id) {
                            return v <= this.evaluations[0].enseignement_annee.niveau_matiere.notation || "La note ne doit pas dépasser " + this.evaluations[0].enseignement_annee.niveau_matiere.notation;
                        } else {
                            return v <= 20 || "La note ne doit pas dépasser 20";
                        }
                    }
                },
            form: this.$inertia.form({
                notes: [],
                evaluation: null,
                classe: null,
                annee: null,
                enseignant: null,
                filiere: null,
                niveau: null
            }),
            format: this.$inertia.form({
                section_id: null,
                
            }),
            info: ''
        }
    },
    created() {
        // console.log(this.eleves)
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
    methods: {
        formatEvaluationLabel(item) {
            // console.log(item.enseignement_annee.niveau_matiere)
            if (item.enseignement_annee.niveau_matiere) {
                // Concatenate the relevant properties for the label
                // console.log(item.type_evaluation.libelle)
                return `${item ? item?.type_evaluation?.libelle : 'Pas de données'} - ${item ? item?.enseignement_annee?.niveau_matiere?.matiere?.nom : ''}`;
            } else {
                return `${item ? item?.type_evaluation?.libelle : 'Pas de données'} - ${item ? item?.enseignement_annee?.filiere_niveau_matiere_ue?.matiere?.nom : ''}`;
            }
        },
        formatCode(item) {
            return `${item ? item?.filiere.code : 'Pas de données'} - ${item ? item.cycle.name : 'Pas de données'} `
        },
        formatEnseignant(item) {
            return `${item.matricule } - ${item.nom }  ${item.prenom}`
        },
        rechercher(e) {
            // console.log(this.eleves)
            router.replace(this.$page.url, {
                data: {
                    evaluation: e
                }
            });
        },
        SetFiliere(a) {
            // console.log(this.form)
            router.replace(this.$page.url, {
                data: {
                    annee: a,
                    enseignant: this.form.enseignant,
                }
            });
        },
        setEvaluation(c) {
            router.replace(this.$page.url, {
                data: {
                    classe: this.form.classe
                }
            })
        },
        setNote(item) {
            // console.log('item',item.key)
            this.form.notes[item.key] = item.note;
        },
        setClasse(n) {
            // console.log(n)
            router.replace(this.$page.url, {
                data: {
                    niveau: n,
                    filiere: this.form.filiere,
                    annee: this.form.annee
                }
            })
        },
        submit() {
            this.form.post(route("note.save"), {
                preverseScroll: true,
                onFailed: () => {

                },
                onSuccess: () => {
                    this.isLoading = false;
                    this.dialogConfirmation = false;
                    this.form.reset();
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
                            title: "Information!!!?",
                            text: this.$page.props.flash ?.message ?.text + ' ' + 'voulez-vous être rédiriger vers la liste?',
                            icon: "info",
                            showCancelButton: true,
                            confirmButtonColor: "orange",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Oui!",
                            cancelButtonText: "Non !",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.format.section_id = this.type
                                this.format.get(route("note.index_admin"));
                            }
                        });
                    }

                },

            });
        },
        dialog() {
            // console.log(this.form.notes)
            // this.info = this.evaluations.filter(el => el.id = this.selectedEvaluation)
            this.$swal({
                title: "Êtes-vous sûr?",
                text: "Êtes-vous sûr de vouloir sauvegarder ces notes",
                icon: "info",
                showCancelButton: true,
                confirmButtonColor: "orange",
                cancelButtonColor: "#d33",
                confirmButtonText: "Oui, sauvegarde-le!",
                cancelButtonText: "Non, annulez !",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        },
    },
}
</script>

<template>
<Head title="Notes" />

<AuthenticatedLayout>
    <Toolbar :icon="icon.mdiAccountPlusOutline" toolbarTitle="Gestion de notes (Attribution de notes)"></Toolbar>

    <v-card style="margin: 20px">
        <v-card-title>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <v-chip class="primary">Attribution de notes</v-chip>
                </div>
            </div>
        </v-card-title>
    </v-card>
    <v-form v-model="valid">

        <v-card style="border: 2px solid #7d002c;margin: 20px">
            <v-card-title style="color: white; background-color: #7d002c">Choisissez les criteres</v-card-title>
            <v-divider></v-divider>
            <br />
            <v-row style="margin: 20px">
                <v-col md="2" v-if="type<=2"></v-col>
                <v-col md="2">
                    <Autocomplete v-model="form.enseignant" :items="enseignants" :item-title="formatEnseignant" item-value="id" outlined required dense chips small-chips label="Enseignants"></Autocomplete>
                </v-col>
                <v-col md="2">
                    <Autocomplete :disabled="!form.enseignant" v-model="form.annee" :items="annees" item-title="libelle" item-value="id" outlined required dense chips small-chips label="Années academiques" @update:modelValue="SetFiliere(form.annee)"></Autocomplete>
                </v-col>
                <v-col md="2" v-if="type>=3">
                    <Autocomplete :disabled="!form.annee" v-model="form.filiere" :items="filieres" :item-title="formatCode" item-value="id" outlined required dense chips small-chips label="Filieres"></Autocomplete>
                </v-col>
                <v-col md="2" v-if="type>=3">
                    <Autocomplete :disabled="!form.filiere" v-model="form.niveau" :items="niveaux" item-title="libelle" item-value="id" outlined required dense chips small-chips label="Niveaux" @update:modelValue="setClasse(form.niveau)"></Autocomplete>
                </v-col>
                <v-col md="2">
                    <Autocomplete v-model="form.classe" :items="classes" item-title="libelle" item-value="id" outlined required dense chips small-chips label="Classes" @update:modelValue="setEvaluation(form.classe)"></Autocomplete>
                </v-col>
                <v-col md="2">
                    <Autocomplete v-model="form.evaluation" :disabled="!form.classe" :items="evaluations " :item-title="formatEvaluationLabel" item-value="id" outlined required dense chips small-chips label="Evaluations" @update:modelValue="rechercher(form.evaluation)"></Autocomplete>
                </v-col>
            </v-row>
        </v-card>

        <v-card style="border: 2px solid #7d002c;margin: 20px">
            <v-card-title style="color: white; background-color: #7d002c">Saisissez les notes</v-card-title>
            <v-divider></v-divider>
            <br />
            <Datatable titleDatatable="Listes des apprenant " :items="eleves" :headers="headers" :displayAddButton="false">
                <template v-slot:item.note="{ item, index }">
                    <TextField label="" v-model="form.notes[item.id]" outlined dense :rules="[rules.required, rules.validator,rules.max]" style="max-width: 300px"></TextField>
                </template>
            </Datatable>
            <v-card-actions>
                <v-spacer />
                <v-btn :loading="form.processing" variant="outlined" :disabled="!valid" color="green" @click="dialog">
                    <v-icon :icon="icon.mdiCheckCircle"></v-icon> Valider
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-form>
</AuthenticatedLayout>
</template>
