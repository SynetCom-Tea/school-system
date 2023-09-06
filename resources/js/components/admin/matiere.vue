<template>
    <form @submit.prevent="submitForm">
        <v-card-text>
            <v-row>
                <v-alert text="Cette section vous permet de configurer" type="info"></v-alert>
            </v-row>
            <v-row  v-if="type == '3'">
                <v-col>
                    <v-switch label="Souhaiterez-vous appliquez le système LMD ?" v-model="form.lmd" color="primary" inset></v-switch>
                </v-col>
                <v-col>
                    <v-autocomplete v-if="form.lmd"
                        :items="['Type 1', 'Type 2']"
                        chips
                        closable-chips
                        color="blue-grey-lighten-2"
                        v-model="form.type_lmd"
                        label="Select"
                        
                    ></v-autocomplete>
                </v-col>
                <v-col>
                    <v-switch label="Souhaiterez-vous appliquez le régime d'évaluation ?" v-model="form.regime_evaluation" color="indigo" inset></v-switch>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <v-switch label="Souhaiterez-vous importez le fichier des matieres ?" v-model="importation" color="info" inset></v-switch>
                </v-col>
                <v-col>
                    <v-file-input v-if="importation"
                        clearable
                        label="File input"
                        variant="solo-inverted"
                    ></v-file-input>
                </v-col>
                <v-col></v-col>
            </v-row>
            <v-card v-if="!importation">
                <v-card-title class="text-h6 font-weight-regular justify-space-between">
                    <span style="color:blue">Renseigner les matieres</span>&nbsp;
                </v-card-title>
                <v-card-text>
                    <v-row disabled :key="matiere.id" v-for="(matiere, i) in form.matieres">
                        <v-col md="2"></v-col>
                        <v-col md="2">
                            <text-field label="Code matiere" placeholder="Code matiere" @change="verify(matiere)" v-model="matiere.code"></text-field>
                        </v-col>
                        <v-col md="3">
                            <text-field label="Libelle matiere" placeholder="Libelle matiere" v-model="matiere.libelle"></text-field>
                        </v-col>
                        <v-col md="1">
                            <v-btn variant="outlined" :disabled="!(form.matieres.length > 1)" icon @click="removeRow(matiere)" fab small color="error">
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
            lmd: false,
            regime_evaluation: false,
            fichier_matiere: null,
            type_lmd: null,
            matieres: [],
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
            this.form.matieres.push({
                code: null,
                libelle: null,
                before: null,
                after: null
            })
        },
        removeRow(id) {
            this.form.matieres = this.form.matieres.filter((el) => el !== id)
        },
        async verify(element) {
            const array = this.form.matieres.filter(el => el.code !== null && el.code == element.code)

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