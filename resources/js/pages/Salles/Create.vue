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
    mdiCloseCircle,
    mdiContentSave
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
                mdiCloseCircle,
                mdiContentSave
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
                    text: 'Cette salle existe déjà!',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                });

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
     <Toolbar
      styleToolbar="background-color: white;"
      :icon="icon.mdiSchool"
      toolbarTitle="GESTION DES SALLES"
    ></Toolbar>
    <br>
<v-card variant="outlined" style="border: 2px solid #7d002c">
    <!-- <Toolbar :icon="icon.mdiGoogleClassroom" toolbarTitle="Création Salles"></Toolbar> -->
    <v-card-title style="color: white; background-color: #7d002c"
            >AJOUT DES SALLES</v-card-title
          >
          <v-divider></v-divider>

    <v-card-text>
        <v-form ref="form">
            <v-card-text>
                <!-- <v-chip label variant="outlined" text-color="white" color="primary" class="text-md-h6 green--text">Ajout des salles</v-chip> -->
                <v-card outlined class="mb-md-2">
                    <v-card-text>
                        <v-row :key="donnee.id" v-for="(donnee, i) in form.donnees">

                                    <v-row>
                                        <v-col cols="1"></v-col>
                                        <v-col cols="4">
                                            <TextField   class="mt-2" label="Code" placeholder="Code" v-model="donnee.code" isRequired :rules="[(v) => !!v || 'Ce champ est requis!']"></TextField>
                                        </v-col>
                                        <v-col cols="4">
                                            <TextField  class="mt-2" label="Libellé" placeholder="Libellé" v-model="donnee.libelle" isRequired :rules="[(v) => !!v || 'Ce champ est requis!', verify(donnee)]"></TextField>
                                        </v-col>

                                        <v-col offset-md="10" cols="2">
                                            <br>
                                            <Button size="large"  title="supprimer la salle" variant="outlined" :disabled="!(form.donnees.length > 1)" icon @click="removeRow(donnee)" color="error">
                                                <v-icon :icon="icon.mdiCloseCircle" small></v-icon>
                                            </Button >
                                        </v-col>
                                    </v-row>


                        </v-row>
                        <v-row>
                                        <v-col cols="9">
                                        </v-col>
                                        <v-col  offset-md="10" cols="2">
                                            <Button size="large"  class="mb-2" title="ajouter une salle" variant="outlined" icon @click="addRow()"  color="primary">
                                                <v-icon :icon="icon.mdiPlusCircle" small></v-icon>
                                            </Button >
                                        </v-col>
                                    </v-row>
                    </v-card-text>
                </v-card>

            </v-card-text>
        </v-form>
    </v-card-text>
    <v-card-actions class="justify-end">
        <v-spacer></v-spacer>
        <Button variant="outlined" class="mb-2" style="height: 30px"  color="red" @click="goBack">
            <v-icon :icon="icon.mdiCancel" left></v-icon> Annuler
        </Button >
        <Button  variant="outlined" class="mb-2" style="height: 30px" color="primary" @click="submit">
            <v-icon :icon="icon.mdiContentSave" left></v-icon> Enregistrer
        </Button >
    </v-card-actions>
</v-card>
</template>
