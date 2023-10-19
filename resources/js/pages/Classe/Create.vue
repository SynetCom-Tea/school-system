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
    props: ["section_id", "niveaux"],
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
            router.get(route('classes.index', this.section_id))
        },
        addRow() {
            this.form.donnees.push({
                niveau_id: null,
                enfants: [],
                before: null,
                after: null
            });
            let data = this.form.donnees[this.form.donnees.length - 1];
            this.addChild(data);
        },
        addChild(donnee) {
            donnee.enfants.push({
                code: null,
                libelle: null,
                before: null,
                after: null
            })
        },
        removeRow(p) {
            this.form.donnees = this.form.donnees.filter((product) => product !== p)
        },
        removeChild(p,enfant) {
            p.enfants = p.enfants.filter((product) => product !== enfant)
        },
        async verify(p) {
            const array = this.form.donnees.filter((el) => el.niveau_id !== null && el.niveau_id == p.niveau_id)
            if (array.length > 1) {
               this.removeRow(p)
                this.$swal({
                                icon: 'error',
                                title: 'Erreur',
                                text: 'Ce niveau existe déjà!',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                            });
            } else {
                return true
            }
        },
        async verifyChild(p,enfant) {
            const array = p.enfants.filter((el) => el.libelle !== null && el.libelle == enfant.libelle || el.code == enfant.code)
            if (array.length > 1) {
               this.removeChild(p,enfant)
                this.$swal({
                                icon: 'error',
                                title: 'Erreur',
                                text: 'Cette classe existe déjà!',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                            });
            } else {
                return true
            }
        },
        async submit() {
            const {
                valid
            } = await this.$refs.form.validate()
            if (valid) {
                console.log(this.form)
                this.form.post(route('classes.store',this.section_id), {
                    onFinish: () => {
                        this.close()
                        this.$swal({
                            icon: 'success',
                                iconColor: '#004980',
                                color: '#004980',
                                title: 'Enregistrement',
                                text: 'Classes créées avec succès!',
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
    <Toolbar :icon="icon.mdiGoogleClassroom" toolbarTitle="Création Classes"></Toolbar>

    <v-card-text>
        <v-form ref="form">        
            <v-card-text>
                    <v-chip label variant="outlined" text-color="white" color="primary" class="text-md-h6 green--text">Ajout des classes</v-chip>
                    <v-card outlined class="mb-md-2">
                        <v-card-text>
                            <v-row  :key="donnee.id" v-for="(donnee, i) in form.donnees">
                                <v-card class="mx-auto" width="800" style="border-color: #004980; margin-bottom:6px;" rounded="lg" variant="outlined">
                                    <v-card-text>
                                <v-row>
                                <v-col md="5">
                                     <Select
                                        label="Niveau"
                                        :items="niveaux"
                                        variant="outlined"
                                        item-value="id"
                                        item-title="libelle"
                                        v-model="donnee.niveau_id"
                                        isRequired
                                        :rules="[(v) => !!v || 'Ce champ est requis!', verify(donnee)]"
                                        >
                                    ></Select>
                                </v-col>
                                
                                <v-col md="2">
                                    <v-btn title="supprimer le niveau et ses classes" variant="outlined" :disabled="!(form.donnees.length > 1)" icon @click="removeRow(donnee)" fab small color="error">
                                        <v-icon :icon="icon.mdiCloseCircle"></v-icon>
                                    </v-btn>
                                </v-col>
                                </v-row>
                                <v-row :key="enfant.id" v-for="(enfant, j) in donnee.enfants">
                                    <v-col md="5">
                                                <TextField
                                                    label="Code"
                                                    placeholder="Code"
                                                    v-model="enfant.code"
                                                    isRequired
                                                    :rules="[(v) => !!v || 'Ce champ est requis!', verifyChild(donnee,enfant)]"
                                                ></TextField>
                                            </v-col>
                                            <v-col md="5">
                                                <TextField
                                                    label="Libellé"
                                                    placeholder="Libellé"
                                                    v-model="enfant.libelle"
                                                    isRequired
                                                    :rules="[(v) => !!v || 'Ce champ est requis!', verifyChild(donnee,enfant)]"
                                                ></TextField>
                                            </v-col>
                                            <v-col md="2">
                                                <v-btn title="supprimer la classe" variant="outlined" :disabled="!(donnee.enfants.length > 1)" icon @click="removeChild(donnee,enfant)" fab small color="orange">
                                                    <v-icon :icon="icon.mdiCloseCircle"></v-icon>
                                                </v-btn>
                                            </v-col>
                                </v-row>
                                <v-row>
                                    <v-col md="10">
                                  </v-col> 
                                            <v-col md="2">
                                                <v-btn title="ajouter une classe" variant="outlined" icon @click="addChild(donnee)" fab small color="blue">
                                                    <v-icon :icon="icon.mdiPlusCircle"></v-icon>
                                                </v-btn>
                                            </v-col>
                                            </v-row>
                                </v-card-text>
                                </v-card>
                            </v-row>
                            <v-row>
                                <v-col md="10">
                                </v-col>
                                <v-col md="2">
                                    <v-btn title="ajouter un niveau" variant="outlined" icon @click="addRow()" fab small color="primary">
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
