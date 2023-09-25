<script>
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import {
    useForm
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
    mdiContentSaveEditOutline

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
    props: ["periodes", "typeEvaluations","matieres", "enseigements", "sections", "nivau_matieres", "enseignant","cycle_filieres","ues"],
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

            form: useForm({
                date: '',
                pourcentage: null,
                type_evaluation_id: null,
                periode_id: null,
                enseignement_annee_id: null,
                cycle_filiere_id:null,
                ue_id : null
            }),
        }
    },

    methods: {
        editItem(item) {
            console.log('edit', item)
            this.dialog_title = 'Modifier Evaluation ' + item.id
            this.form.id = item.id
            this.form.date = item.date
            this.form.pourcentage = item.pourcentage
            this.form.periode_id = item.periode_id
            this.form.type_evaluation_id = item.type_evaluation_id
            this.form.enseignement_annee_id = item.enseignement_annee_id
            this.dialog = true
        },
        deleteItem(item) {
            this.$swal({
                title: 'Es-tu sûr?',
                text: "Vous ne pourrez pas revenir en arrière !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'orange',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimez-le!',
                cancelButtonText: 'Non, annulez !',
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
                // console.log(this.form)
                this.form.post(route('evaluation.store'), {
                    onFinish: () => {
                        this.close()
                        this.$swal({
                            icon: 'success',
                            title: 'Enregistrement',
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
        setPeriode(e) {
            // console.log(e)
            this.form.periode_id = null
            this.$inertia.replace(this.$page.url, {
                data: {
                    section_id: e,
                },

            })
        }
    }
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
                <v-form ref="form">
                    <v-container>
                        <v-row>
                            <v-col cols="6">
                                <TextField label="Date Evaluation" type="date" variant="outlined" placeholder="Date" v-model="form.date" :isRequired="true" :rules="[v => !!v || 'Ce champ est requis!']">
                                </TextField>
                            </v-col>
                            <v-col cols="6">
                                <Autocomplete label="Sections" variant="outlined" item-title="libelle" item-value="id" :items="sections" v-model="form.section_id" @update:modelValue="setPeriode(form.section_id)" :isRequired="true" :rules="[v => !!v || 'Ce champ est requis!']">
                                </Autocomplete>
                            </v-col>
                            <v-col cols="6">
                                <Autocomplete v-model="form.periode_id" label="Periodes" itemTitle="libelle" itemValue="id" :items="periodes" variant="outlined" :isRequired="true" :rules="[v => !!v || 'Ce champ est requis!'] " chips clearable>
                                </Autocomplete>
                            </v-col>
                            <v-col cols="6">
                                <Autocomplete label="Type Evaluation" variant="outlined" item-title="libelle" item-value="id" :items="typeEvaluations" v-model="form.type_evaluation_id" :isRequired="true" :rules="[v => !!v || 'Ce champ est requis!']">
                                </Autocomplete>
                            </v-col>
                            <v-col cols="6">
                                <Autocomplete label="Matieres" variant="outlined" itemTitle="nom" itemValue="id" :items="matieres" v-model="form.matiere_id" :isRequired="true">
                                </Autocomplete>
                            </v-col>
                            <v-col cols="6">
                                <Autocomplete label="Cycles/Filieres" variant="outlined" itemTitle="code" itemValue="id" :items="cycle_filieres" v-model="form.cycle_filiere_id" :isRequired="true">
                                </Autocomplete>
                            </v-col>
                            <v-col cols="6">
                                <Autocomplete label="Unités d'enseignement" variant="outlined" itemTitle="libelle" itemValue="id" :items="ues" v-model="form.ue_id" :isRequired="true">
                                </Autocomplete>
                            </v-col>
                            <v-col cols="6">
                                <TextField :prepend-inner-icon="icon.mdiPercentOutline" label="Pourcentage" variant="outlined" placeholder="pourcentage"  v-model="form.pourcentage" :isRequired="true" :rules="[v => !!v || 'Ce champ est requis!']">
                                </TextField>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-form>
            <v-card-actions class="justify-end">
                <v-spacer></v-spacer>
                <Button class="mb-2" style="height: 30px" nameButton="Enregistrer" title="Valider et Fermer la modale" small color="primary" variant="outlined" :prependIcon="icon.mdiContentSaveEditOutline" @click="submit">
                </Button>
            </v-card-actions>
        </v-card-text>
    </v-card>
</AuthenticatedLayout>
</template>
