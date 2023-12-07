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
    mdiCloseCircle,
    mdiContentSave

} from '@mdi/js'
export default {
    layout: AuthenticatedLayout,
    props: ["typefrais","section_id", "niveaux","annees","filieres"],
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
                mdiCloseCircle,
                mdiContentSave

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
                filiere: null,
                montant: null,
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
                this.$swal({
                        title: 'Etês-vous sûr de vouloir enregistrer?',
                        text: "Vous ne pourrez pas revenir en arrière !",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#004980',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Oui, Enregistrer !',
                        cancelButtonText: 'Non, annulez !',
                        }).then((result) => {
                        if (result.isConfirmed) {
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
                    })
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
    },
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
            >AJOUT DES FRAIS</v-card-title
          >
          <v-divider></v-divider>


    <v-card-text>
        <v-form ref="form">
            <v-row style="height: 90px">
                <v-col cols="4" md="4">
                </v-col>
                <v-col cols="4" md="4">
                    <autocomplete
                        label="Année Scolaire"
                        :items="annees"
                        variant="outlined"
                        placeholder="Année Scolaire"
                        item-value="id"
                        item-title="libelle"
                        v-model="form.annee_id"
                        isRequired
                        :rules="[(v) => !!v || 'Ce champ est requis!']"
                        >
                    </autocomplete>
                    </v-col>
            </v-row>

            <v-card-text>
                    <!-- <v-chip label variant="outlined" text-color="white" color="primary" class="text-md-h6 green--text">Ajout des frais</v-chip> -->
                    <v-card>
                        <v-card-text>
                            <v-row  :key="donnee.id" v-for="(donnee, i) in form.donnees" style="height: 90px">
                                <v-col cols="3" v-if="section_id==3 || section_id==4">
                                    <autocomplete
                                        label="filières"
                                        :items="filieres"
                                        variant="outlined"
                                        placeholder="filières"
                                        class="mb-2"
                                        item-value="id"
                                        item-title="code"
                                        v-model="donnee.filiere"
                                        isRequired
                                        :rules="[(v) => !!v || 'Ce champ est requis!']"
                                        >
                                    </autocomplete>
                                </v-col>
                                    <v-col cols="1" v-else></v-col>
                                <v-col cols="3">
                                    <autocomplete
                                        label="TypeFrais"
                                        :items="typefrais"
                                        variant="outlined"
                                        placeholder="TypeFrais"
                                        class="mb-2"
                                        item-value="id"
                                        item-title="type_frais.libelle"
                                        v-model="donnee.type_frais_id"
                                        isRequired
                                        :rules="[(v) => !!v || 'Ce champ est requis!']"
                                        >
                                    </autocomplete>
                                </v-col>
                                <v-col cols="3">
                                     <autocomplete
                                    label="Niveaux"
                                    :items="niveaux"
                                    variant="outlined"
                                    placeholder="Niveaux"
                                    item-value="id"
                                    item-title="code"
                                    v-model="donnee.niveau_id"
                                    multiple
                                    chips
                                    isRequired
                                    class="mb-2"
                                    :rules="[(v) => !!v || 'Ce champ est requis!']"
                                    ></autocomplete>
                                </v-col>
                                <v-col cols="2" v-if="section_id==3 || section_id==4">
                                    <TextField
                                        type="number"
                                        label="Montant"
                                        placeholder="Montant"
                                        v-model="donnee.montant"
                                        isRequired
                                        class="mb-2"
                                        :rules="[(v) => !!v || 'Ce champ est requis!']"
                                    ></TextField>
                                </v-col>
                                <v-col cols="3" v-else>
                                    <TextField
                                        type="number"
                                        label="Montant"
                                        placeholder="Montant"
                                        v-model="donnee.montant"
                                        isRequired
                                        class="mb-2"
                                        :rules="[(v) => !!v || 'Ce champ est requis!']"
                                    ></TextField>
                                </v-col>
                                <v-col cols="1">
                                    <Button size="large"  variant="outlined" :disabled="!(form.donnees.length > 1)" icon @click="removeRow(donnee)" fab small color="error">
                                        <v-icon :icon="icon.mdiCloseCircle"></v-icon>
                                    </Button >
                                </v-col>
                            </v-row>
                            <v-row v-if="section_id==2 || section_id==1">
                                <v-col md="10">
                                </v-col>
                                <v-col  md="2">
                                    <Button size="large" variant="outlined" icon @click="addRow()" fab small color="primary">
                                        <v-icon :icon="icon.mdiPlusCircle"></v-icon>
                                    </Button >
                                </v-col>
                            </v-row>
                            <v-row v-if="section_id==3 || section_id==4">
                                <v-col md="11">
                                </v-col>
                                <v-col offset-md="11" md="1">
                                    <Button size="large" variant="outlined" icon @click="addRow()" fab small color="primary">
                                        <v-icon :icon="icon.mdiPlusCircle"></v-icon>
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
      <Button  variant="outlined"  class="mb-2" small type="button" style="height: 30px" color="red" @click="goBack">
        <v-icon :icon="icon.mdiCancel" left></v-icon> Annuler
      </Button >
      <Button variant="outlined" class="mb-2" small color="primary" style="height: 30px" @click="submit">
        <v-icon :icon="icon.mdiContentSave" left></v-icon> Enregistrer
      </Button >
    </v-card-actions>
</v-card>
</template>
