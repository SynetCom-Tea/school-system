<template>
    <form @submit.prevent="submitForm">
        <v-container fluid>
        <v-card-text>

            <v-row>
                <v-alert text="Cette section vous permet de configurer" type="info"></v-alert>
            </v-row>

            <v-row >

                <v-col cols="5">
                    <v-switch  label="Souhaiterez-vous importez le fichier des filieres ?" v-model="importation" color="info" ></v-switch>
                </v-col>
                <v-col>

                    <v-file-input v-if="importation"
                        clearable
                        label="File input"
                        variant="solo-inverted"
                        v-model="form.fichier_filiere"
                    ></v-file-input>
                </v-col>
                <v-col></v-col>
            </v-row>
            <v-card v-if="!importation">
                <v-card-title class="text-h6 font-weight-regular justify-space-between">
                    <span style="color:blue">Renseigner les filieres</span>&nbsp;
                </v-card-title>
                <v-card-text>
                    <v-row disabled :key="filieres.id" v-for="(filieres, i) in form.filieres">
                        <v-col md="2"></v-col>
                        <v-col md="2">
                            <text-field label="Code filiere" placeholder="Code filiere" @change="verify(filieres)" v-model="filieres.code"></text-field>
                        </v-col>
                        <v-col md="3">
                            <text-field label="Nom de la filiere" placeholder="Nom de la filiere" v-model="filieres.name"></text-field>
                        </v-col>
                        <v-col md="1">
                            <v-btn variant="outlined" :disabled="!(form.filieres.length > 1)" icon @click="removeRow(filieres)" fab small color="error">
                                <v-icon :icon="icons.mdiCloseCircle"></v-icon>
                            </v-btn>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col offset-md="11" md="1">
                            <v-btn variant="outlined" icon @click="addRow" fab small color="green">
                                <v-icon :icon="icons.mdiPlusCircle"></v-icon>
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-card-text>
        <v-row>
            <v-col md="5"></v-col>
            <v-col md="4">
                <v-btn type="submit" title="enregistrer" color="green">
                    Enregistrer
                </v-btn>
            </v-col>
        </v-row>
    </v-container>
    </form>
</template>
<script>
    import { router,useForm} from '@inertiajs/vue3';
    import { mdiCloseCircle, mdiPlusCircle } from "@mdi/js";
  export default {
    props:['type'],
    components: {
    mdiPlusCircle,
    mdiCloseCircle,

  },
    data: () => ({
        icons: {mdiPlusCircle,mdiCloseCircle},
        step: 1,
        importation: false,
        form: useForm({
            fichier_filiere: null,
            filieres: [],
        }),
    }),

    methods: {
        submitForm() {
            this.$emit('formSubmitted', this.form);
        },
        goBack() {
            router.get(route('etablissements.index'))
            console.log()
        },
        addRow() {
            this.form.filieres.push({
                code: null,
                name: null,
                etablissement: this.$page.props.admin_etablissement.etablissement_id,
                before: null,
                after: null
            })
        },
        removeRow(id) {
            this.form.filieres = this.form.filieres.filter((el) => el !== id)
        },
        async verify(element) {
            const array = this.form.filieres.filter(el => el.code !== null && el.code == element.code)

            if (array.length > 1) {
                this.removeRow(element)
                this.$swal("L'élément existe déjà !")
                // this.$alert.error("L'élément existe déjà !");
            }
        },
    },
    mounted() {
        this.addRow()
    },
  }
</script>
