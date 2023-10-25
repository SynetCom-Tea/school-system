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
    mdiClipboardEditOutline,
    mdiPlusCircle,
    mdiCloseCircle,
} from '@mdi/js'
export default {
    layout: AuthenticatedLayout,
    props: ["section_id", "niveaux","matieres"],
    data() {
        return {
            icon: {
                mdiPlus,
                mdiSchool,
                mdiAccountSchool,
                mdiCheckCircle,
                mdiCancel,
                mdiClipboardEditOutline,
                mdiPlusCircle,
                mdiCloseCircle,
            },

            form: useForm({
                donnees:[],
            }),
        }
    },
    created() {

    },
    methods: {

        goBack() {
            router.get(route('affectations.index', this.section_id))
        },
        addRow() {
            this.form.donnees.push({
                volume_horaire: '',
                coefficient: '',
                niveau_id: [],
                matiere_id: '',
                before: null,
                after: null
            })
        },
        removeRow(p) {
            this.form.donnees = this.form.donnees.filter((product) => product !== p)
        },
        async verify(p) {
            const array = this.form.donnees.filter(el => el !== p)
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
            }
        },
        async submit() {
            const {
                valid
            } = await this.$refs.form.validate()
            if (valid) {
                console.log(this.form)
                this.form.post(route('affectations.store',this.section_id), {
                    onFinish: () => {
                        this.close()
                        this.$swal({
                            icon: 'success',
                                iconColor: '#004980',
                                color: '#004980',
                                title: 'Enregistrement',
                                text: 'Niveau_Matière créé avec succès!',
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
    },
    computed: {
        Title() {

        switch (this.section_id) {
            case "1":
            return "SECTION PRIMAIRE";
            case "2":
            return "SECTION SECONDAIRE";
            case "3":
            return "SECTION SUPERIEUR";
            default:
            return "SECTION UNIVERSITAIRE";
        }
        },
    }
}
</script>
<template>
        <Toolbar
      styleToolbar="background-color: white;"
      :icon="icon.mdiSchool"
      :toolbarTitle="Title"
    ></Toolbar>
    <br>
<v-card variant="outlined" style="border: 2px solid #7d002c">
    <v-card-title style="color: white; background-color: #7d002c"
            >Affectation de matière aux niveaux</v-card-title
          >
          <v-divider></v-divider>

    <v-card-text>
        <v-form ref="form">
                <v-row  :key="donnee.id" v-for="(donnee, i) in form.donnees">
                    <v-col cols="3" md="3">
                    <Select
                        label="Matière"
                        :items="matieres"
                        variant="outlined"
                        item-value="id"
                        item-title="nom"
                        v-model="donnee.matiere_id"
                        isRequired
                        :rules="[(v) => !!v || 'Ce champ est requis!']"
                        >
                    </Select>
                    </v-col>
                    <v-col cols="3" md="3">
                    <Select
                        label="Niveaux"
                        :items="niveaux"
                        variant="outlined"
                        item-value="id"
                        item-title="libelle"
                        v-model="donnee.niveau_id"
                        multiple
                        ships
                        isRequired
                        :rules="[(v) => !!v || 'Ce champ est requis!']"
                        >
                    ></Select>
                    </v-col>
                    <v-col cols="2" md="2">
                            <TextField
                            type="number"
                            label="Volume_Horaire"
                            placeholder="Volume_Horaire"
                            v-model="donnee.volume_horaire"
                            isRequired
                            :rules="[(v) => !!v || 'Ce champ est requis!']"
                            ></TextField>
                        </v-col>
                        <v-col cols="2" md="2">
                            <TextField
                            type="number"
                            label="Coefficient"
                            placeholder="Coefficient"
                            v-model="donnee.coefficient"
                            isRequired
                            :rules="[(v) => !!v || 'Ce champ est requis!']"
                            ></TextField>
                        </v-col>
                        <v-col md="2">
                            <v-btn variant="outlined" :disabled="!(form.donnees.length > 1)" icon @click="removeRow(donnee)" fab small color="error">
                                <v-icon :icon="icon.mdiCloseCircle"></v-icon>
                            </v-btn>
                        </v-col>

                    </v-row>
                    <v-row>
                                <v-col md="10">
                                </v-col>
                                <v-col offset-md="11" md="2">
                                    <v-btn variant="outlined" icon @click="addRow()" fab small color="primary">
                                        <v-icon :icon="icon.mdiPlusCircle"></v-icon>
                                    </v-btn>
                                </v-col>
                            </v-row>

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
