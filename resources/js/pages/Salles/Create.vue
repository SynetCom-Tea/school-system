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
    mdiGoogleClassroom,
    mdiPlusCircle,
    mdiCloseCircle
} from '@mdi/js'
export default {
    layout: AuthenticatedLayout,
    props: [],
    data() {
        return {
            icon: {
                mdiPlus,
                mdiSchool,
                mdiAccountSchool,
                mdiCheckCircle,
                mdiCancel,
                mdiGoogleClassroom,
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
            router.get(route('salles.index'))
        },
        addRow() {
            this.form.donnees.push({
                code: null,
                libelle: null,
                before: null,
                after: null
            });

        },

        removeRow(p) {
            this.form.donnees = this.form.donnees.filter((product) => product !== p)
        },

        async verify(p) {
            const array = this.form.donnees.filter((el) => el.code !== null && el.libelle == p.libelle)
            if (array.length > 1) {
                this.removeRow(p)
                this.$swal({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Cet élément existe déjà!',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
                //return 'Cette ligne est déjà sélectionnée!'
            }
        },
        async submit() {
            const {
                valid
            } = await this.$refs.form.validate()
            if (valid) {

                this.form.post(route('salles.store'), {
                    onFinish: () => {
                        this.close()
                        this.$swal({
                            icon: 'success',
                            iconColor: '#004980',
                            color: '#004980',
                            title: 'Enregistrement',
                            text: 'Salles créées avec succès!',
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
    <Toolbar :icon="icon.mdiGoogleClassroom" toolbarTitle="Création Salles"></Toolbar>

    <v-card-text>
        <v-form ref="form">
            <v-card-text>
                <v-chip label variant="outlined" text-color="white" color="primary" class="text-md-h6 green--text">Ajout des salles</v-chip>
                <v-card outlined class="mb-md-2">
                    <v-card-text>
                        <v-row :key="donnee.id" v-for="(donnee, i) in form.donnees">
                            
                                    <v-row>
                                        <v-col md="5">
                                            <TextField label="Code" placeholder="Code" v-model="donnee.code" isRequired :rules="[(v) => !!v || 'Ce champ est requis!']"></TextField>
                                        </v-col>
                                        <v-col md="5">
                                            <TextField label="Libellé" placeholder="Libellé" v-model="donnee.libelle" isRequired :rules="[(v) => !!v || 'Ce champ est requis!']"></TextField>
                                        </v-col>

                                        <v-col md="2">
                                            <v-btn title="supprimer la salle" variant="outlined" :disabled="!(form.donnees.length > 1)" icon @click="removeRow(donnee)" fab small color="error">
                                                <v-icon :icon="icon.mdiCloseCircle"></v-icon>
                                            </v-btn>
                                        </v-col>
                                    </v-row>

                                    
                        </v-row>
                        <v-row>
                                        <v-col md="10">
                                        </v-col>
                                        <v-col md="2">
                                            <v-btn title="ajouter une salle" variant="outlined" icon @click="addRow()" fab small color="primary">
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
