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
} from '@mdi/js'
export default {
  components: {
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
    props: ['classes', 'evaluations', 'eleves'],
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
                mdiContentSaveEditOutline
            },
            tabs: [],
            valid: null,
            dialogConfirmation: false,
            searchQuery: null,
            selectedClasse: null,
            selectedEvaluation: null,
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
                max: v => v <= 20 || "La note ne doit pas dépasser 20"
            },
            form: this.$inertia.form({
                notes: [],
                evaluation: null,
                classe: null,
            }),
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
            if (item) {
                // Concatenate the relevant properties for the label
                return `${item ? item?.type_evaluation?.libelle : 'Pas de données'} - ${item ? item?.enseignement_annee?.niveau_matiere?.matiere?.nom : ''}`;
            }
        },
        rechercher() {
      // console.log(this.eleves)
            router.replace(this.$page.url, {
                data: {
                    classe: this.selectedClasse,
                    evaluation: this.selectedEvaluation
                }
            });
        },
        requete(id) {
            this.selectedEvaluation = null
            router.replace(this.$page.url, {
                data: {
                    classe: id
                }
            });
        },
        setNote(item) {
            // console.log('item',item.key)
            this.form.notes[item.key] = item.note;
        },
        submit() {
            // this.form.notes = this.tabs.filter(el => el != null)
            this.form.classe = this.selectedClasse
            this.form.evaluation = this.selectedEvaluation
            // console.log(this.form)
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
                            title: 'Sauvegarde',
                            text: this.$page.props.flash ?.message ?.text,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 10000,
                            timerProgressBar: true,
                        });
                    } else if (this.$page.props.flash ?.message ?.type == 'success') {
                        this.$swal({
                            icon: 'success',
                            title: 'Sauvegarde',
                            text: this.$page.props.flash ?.message ?.text,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 10000,
                            timerProgressBar: true,
                        });
                    }

                },

            });
        },
    },
}
</script>

<template>
<Head title="Notes" />

<AuthenticatedLayout>
  <Toolbar :icon="icon.mdiAccountPlusOutline" toolbarTitle="Gestion de notes"></Toolbar>

    <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight"></h2>
    </template>

    <v-card style="margin: 20px">
        <v-card-title>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">Attribution de notes</div>
                </div>
            </div>
        </v-card-title>
    </v-card>
    <v-form v-model="valid">

        <v-card style="margin: 20px">
            <v-card-title>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <v-chip class="primary">Choisissez les criteres</v-chip>
                    </div>
                </div>
            </v-card-title>
            <v-row>
                <v-col md="2"></v-col>
                <v-col md="3">
                    <Autocomplete v-model="selectedClasse" :items="classes" item-title="classe_annee.classe.libelle" item-value="classe_annee.classe.id" @update:modelValue="requete(selectedClasse)" outlined required dense chips small-chips label="Classes"></Autocomplete>
                </v-col>
                <v-col md="3" >
                    <Autocomplete v-model="selectedEvaluation" :items="evaluations " :item-title="formatEvaluationLabel" item-value="id" outlined required dense chips small-chips label="Evaluations"></Autocomplete>
                </v-col>
                <v-col md="2">
                    <v-btn color="primary" @click="rechercher()" :loading="form.processing" :disabled="!selectedClasse || !selectedEvaluation">
                        Rechercher
                    </v-btn>
                </v-col>
                <v-col md="2"></v-col>
            </v-row>
        </v-card>

        <v-card style="margin: 20px" v-if="eleves">
            <v-card-title>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">Saisissez les notes</div>
                    </div>
                </div>
            </v-card-title>
            <Datatable titleDatatable="Listes des apprenant " :items="eleves" :headers="headers" :displayAddButton="false" >
                <template v-slot:item.note="{ item, index }">
                    <TextField  label="" v-model="item.note" @update:modelValue="setNote(item)"  outlined  dense :rules="[rules.required, rules.validator, rules.max]" style="max-width: 300px"></TextField>
                </template>
            </Datatable>
            <v-card-actions>
                <v-spacer />
                <v-btn :disabled="form.processing" color="error" @click="dialogConfirmation = false">
                    Annuler
                </v-btn>
                <v-btn :loading="form.processing"  :disabled="!valid" color="green" @click="dialogConfirmation = true">
                    Valider
                </v-btn>
            </v-card-actions>
            <v-dialog v-model="dialogConfirmation" max-width="500px" height="700px">
                <v-card>
                    <v-card-title class="text-h6">Confirmation</v-card-title>
                    <v-card-text class="text-h6">Êtes-vous sûr de vouloir sauvegarder ces notes de:<strong> test </strong> ?</v-card-text>
                    <v-card-actions>
                        <v-spacer />
                        <v-btn :disabled="form.processing" text color="error" @click="dialogConfirmation = false">
                            Non
                        </v-btn>
                        <v-btn :loading="form.processing" text color="#8D6E63" @click="submit">
                            Oui
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-card>
    </v-form>
</AuthenticatedLayout>
</template>
