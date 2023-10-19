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
                mdiContentSaveEditOutline,
                mdiSearchWeb
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
            info : ''
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
            }else{
                 return `${item ? item?.type_evaluation?.libelle : 'Pas de données'} - ${item ? item?.enseignement_annee?.filiere_niveau_matiere_ue?.matiere?.nom : ''}`;
            }
        },
        rechercher(e) {
            // console.log(this.eleves)
            router.replace(this.$page.url, {
                data: {
                    classe: this.selectedClasse,
                    evaluation: e
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
        dialog(){
            // this.info = this.evaluations.filter(el => el.id = this.selectedEvaluation)
            this.$swal({
                title: "Êtes-vous sûr?",
                text: "Êtes-vous sûr de vouloir sauvegarder ces notes" ,
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

    <v-card style="margin: 20px" >
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
            <v-row>
                <v-col md="1"></v-col>
                <v-col md="4">
                    <Autocomplete v-model="selectedClasse" :items="classes" item-title="libelle" item-value="id" @update:modelValue="requete(selectedClasse)" outlined required dense chips small-chips label="Classes"></Autocomplete>
                </v-col>
                <v-col md="4">
                    <Autocomplete v-model="selectedEvaluation" :items="evaluations " :item-title="formatEvaluationLabel" item-value="id" outlined required dense chips small-chips label="Evaluations" @update:modelValue="rechercher(selectedEvaluation)"></Autocomplete>
                </v-col>
                <!-- <v-col md="3" >
                    <br>
                    <Button  color="secondary" variant="outlined" class="mb-3" @click="rechercher()"  nameButton="Recherche.." title="Rechercher..." style="height: 40px" :prependIcon="icon.mdiSearchWeb" :loading="form.processing" :disabled="!selectedClasse || !selectedEvaluation"></Button>
                </v-col> -->
                <!-- <v-col md="2"></v-col> -->
            </v-row>
        </v-card>

        <v-card style="border: 2px solid #7d002c;margin: 20px" v-if="eleves">
            <v-card-title style="color: white; background-color: #7d002c">Saisissez les notes</v-card-title>
            <v-divider></v-divider>
            <br />
            <Datatable titleDatatable="Listes des apprenant " :items="eleves" :headers="headers" :displayAddButton="false">
                <template v-slot:item.note="{ item, index }">
                    <TextField label="" v-model="item.note" @update:modelValue="setNote(item)" outlined dense :rules="[rules.required, rules.validator, rules.max]" style="max-width: 300px"></TextField>
                </template>
            </Datatable>
            <v-card-actions>
                <v-spacer />
                <v-btn :loading="form.processing" variant="outlined" :disabled="!valid" color="green" @click="dialog">
                    <v-icon :icon="icon.mdiCheckCircle" ></v-icon> Valider
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-form>
</AuthenticatedLayout>
</template>
