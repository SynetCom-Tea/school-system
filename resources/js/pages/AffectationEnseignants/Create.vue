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
   mdiCurrencyUsd,
    mdiPlusCircle,
    mdiCloseCircle
} from '@mdi/js'
export default {
    layout: AuthenticatedLayout,
    props: ["typefrais","section_id", "niveaux","annees"],
    data() {
        return {
            icon: {
                mdiPlus,
                mdiSchool,
                mdiAccountSchool,
                mdiCheckCircle,
                mdiCancel,
                mdiCurrencyUsd,
                mdiPlusCircle,
                mdiCloseCircle
            },

            form: useForm({
                annee_id: '',
                donnees: []
            }),
        }
    },
    mounted() {
        this.addRow()
    },
    methods: {

        goBack() {
            router.get(route('frais.index', this.section_id))
        },
        addRow() {
            this.form.donnees.push({
                niveau_id: [],
                type_frais_id: null,
                montant: null,
                before: null,
                after: null
            })
        },
        removeRow(p) {
            this.form.donnees = this.form.donnees.filter((product) => product !== p)
        },
        async verify(p) {
            const array = this.form.donnees.filter(el => el.niveau_id !== null && el.niveau_id == p.niveau_id && el.type_frais_id == p.type_frais_id )
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
                console.log(this.form)
                this.form.post(route('frais.store',this.section_id), {
                    onFinish: () => {
                        this.close()
                        this.$swal({
                            icon: 'success',
                                iconColor: '#004980',
                                color: '#004980',
                                title: 'Enregistrement',
                                text: 'Frais créé avec succès!',
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
    <Toolbar :icon="icon.mdiCurrencyUsd" toolbarTitle="Affectations des matières et classes aux enseignant"></Toolbar>

    <v-card-text>
        <v-form ref="form">
            <v-row>
                <v-col cols="4" md="4">
                </v-col>
                <v-col cols="4" md="4">
                    <Select
                        label="Eseignant"
                        :items="annees"
                        variant="outlined"
                        item-value="id"
                        item-title="libelle"
                        v-model="form.annee_id"
                        isRequired
                        :rules="[(v) => !!v || 'Ce champ est requis!']"
                        >
                    </Select>
                    </v-col>
            </v-row>

            <v-card-text>
                    <v-chip label variant="outlined" text-color="white" color="primary" class="text-md-h6 green--text">Ajout des matières et classes</v-chip>
                    <v-card outlined class="mb-md-4" offset-md="2" max-width="600">
                        <v-card-text>
                            <v-row  :key="donnee.id" v-for="(donnee, i) in form.donnees">
                                <v-col md="4">
                                    <Select
                                        label="Matières"
                                        :items="Matières"
                                        variant="outlined"
                                        item-value="id"
                                        item-title="libelle"
                                        v-model="donnee.type_frais_id"
                                        isRequired
                                        :rules="[(v) => !!v || 'Ce champ est requis!']"
                                        >
                                    </Select>
                                </v-col>
                                <v-col md="4">
                                     <Select
                                        label="Classes"
                                        :items="niveaux"
                                        variant="outlined"
                                        item-value="id"
                                        item-title="code"
                                        v-model="donnee.niveau_id"
                                        multiple
                                        isRequired
                                        :rules="[(v) => !!v || 'Ce champ est requis!']"
                                        >
                                    ></Select>
                                </v-col>


                                <v-col md="1">
                                    <v-btn variant="outlined" :disabled="!(form.donnees.length > 1)" icon @click="removeRow(donnee)" fab small color="error">
                                        <v-icon :icon="icon.mdiCloseCircle"></v-icon>
                                    </v-btn>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col md="11">
                                </v-col>
                                <v-col offset-md="11" md="1">
                                    <v-btn variant="outlined" icon @click="addRow()" fab small color="primary">
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
