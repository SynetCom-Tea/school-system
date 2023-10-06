<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {
    router,
    useForm
} from "@inertiajs/vue3";
import {
    mdiPlus,
    mdiSchool,
    mdiAccountSchool,
    mdiCheckCircle,
    mdiCancel,
    mdiBookOpenVariant,
    mdiPlusCircle,
    mdiCloseCircle
} from '@mdi/js'
export default {
    layout: AuthenticatedLayout,
    props: ["section_id"],
    data() {
        return {
            icon: {
                mdiPlus,
                mdiSchool,
                mdiAccountSchool,
                mdiCheckCircle,
                mdiCancel,
                mdiBookOpenVariant,
                mdiPlusCircle,
                mdiCloseCircle
            },

            form: useForm({
                donnees: []
            }),
        }
    },
    mounted() {
        this.addRow()
    },
    methods: {

        goBack() {
            router.get(route('matieres.index', this.section_id))
        },
        addRow() {
            this.form.donnees.push({
                nom: null,
                before: null,
                after: null
            });

        },

        removeRow(p) {
            this.form.donnees = this.form.donnees.filter((product) => product !== p)
        },

        async verify(p) {
            const array = this.form.donnees.filter((el) => el.nom !== null && el.nom == p.nom)
            if (array.length > 1) {
                this.removeRow(p)
                this.$swal({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Cette matière existe déjà!',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            }
        },
        async submit() {
            const {
                valid
            } = await this.$refs.form.validate()
            if (valid) {

                this.form.post(route('matieres.store', this.section_id), {
                    onFinish: () => {
                        this.close()
                        this.$swal({
                            icon: 'success',
                            iconColor: '#004980',
                            color: '#004980',
                            title: 'Enregistrement',
                            text: 'Matières créées avec succès!',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                        });
                    },
                });
            }
        },
        close() {
            this.form.reset()
        }
    }
}
</script>
<template>
<v-card>
    <Toolbar :icon="icon.mdiBookOpenVariant" toolbarTitle="Création Matières"></Toolbar>

    <v-card-text>
        <v-form ref="form">
            <v-card-text class="mx-auto">
                <v-chip label variant="outlined" text-color="white" color="primary" class="text-md-h6 green--text">Ajout des matières</v-chip>
                <v-card outlined class="mb-md-2">
                    <v-card-text>
                        <v-row :key="donnee.id" v-for="(donnee, i) in form.donnees">
                            
                                    <v-row>
                                        <v-col md="6">
                                            <TextField label="Libellé" placeholder="Libellé" v-model="donnee.nom" isRequired :rules="[(v) => !!v || 'Ce champ est requis!']"></TextField>
                                        </v-col>

                                        <v-col md="2">
                                            <v-btn title="supprimer la matière" variant="outlined" :disabled="!(form.donnees.length > 1)" icon @click="removeRow(donnee)" fab small color="error">
                                                <v-icon :icon="icon.mdiCloseCircle"></v-icon>
                                            </v-btn>
                                        </v-col>
                                    </v-row>

                                    
                        </v-row>
                        <v-row>
                                        <v-col md="6">
                                        </v-col>
                                        <v-col md="2">
                                            <v-btn title="ajouter une matière" variant="outlined" icon @click="addRow()" fab small color="primary">
                                                <v-icon :icon="icon.mdiPlusCircle"></v-icon>
                                            </v-btn>
                                        </v-col>
                                    </v-row>
                    </v-card-text>
                </v-card>

            </v-card-text>
        </v-form>
    </v-card-text>
    <v-card-actions class="justify-end">
        <v-spacer></v-spacer>
        <v-btn dark small type="button" color="red" @click="goBack">
            <v-icon :icon="icon.mdiCancel" left></v-icon> Annuler
        </v-btn>
        <v-btn small color="primary" @click="submit">
            <v-icon :icon="icon.mdiCheckCircle" left></v-icon> Enregistrer
        </v-btn>
    </v-card-actions>
</v-card>
</template>
