<template>
    <form @submit.prevent="submitForm" novalidate>
        <v-container fluid>
        <v-card-text>
            <v-row>
                <v-alert type="info">
                    <li>Cette section vous permet de configurer les frais de cet établissement</li>
                    <li>Le formulaire sera valide si est seulement si tous les champs obligatoires marqués par <span style="color: red;">*</span> sont renseignés</li>
                </v-alert>
            </v-row>
            <br><br>
            <v-card>
                <v-card-text>
                    <!-- <v-row  v-if="type == '3'">
                        <v-col>
                            <v-switch label="Souhaiterez-vous appliquez le système LMD ?" v-model="form.lmd" color="primary" inset></v-switch>
                        </v-col>
                        <v-col v-if="form.lmd">

                            <v-autocomplete
                                :items="['Type 1', 'Type 2']"
                                chips
                                closable-chips
                                :required="form.lmd"
                                color="blue-grey-lighten-2"
                                v-model="form.type_lmd"
                                label="Select"
                            ></v-autocomplete>
                        </v-col>
                        <v-col>
                            <v-switch label="Souhaiterez-vous appliquez le régime d'évaluation ?" v-model="form.regime_evaluation" color="indigo" inset></v-switch>
                        </v-col>
                    </v-row> -->
                    <v-row>
                        <v-col>
                            <v-switch label="Souhaiterez-vous importez le fichier des frais ?" @update:modelValue="resetForm(importation)" v-model="importation" color="info" inset></v-switch>
                        </v-col>
                        <v-col v-if="importation">

                            <v-file-input
                                clearable
                                required
                                v-model="form.fichier_frais"
                                label="Charger le fichier de frais"
                                variant="solo-inverted"
                            ></v-file-input>
                        </v-col>
                        <v-col></v-col>
                    </v-row>
                </v-card-text>
            </v-card>
            <v-divider></v-divider>
            <v-card v-if="!importation">
                <v-alert type="info"><li>Tous les champs de chaque ligne inserer sont obligatoires</li></v-alert>
                <v-card-text>
                    <v-row disabled :key="frais.id" v-for="(frais, i) in form.frais">
                        <v-col md="4" v-if="type == '3' || type == '4'" >

                            <v-autocomplete
                                :items="['IG','MIEL']"
                                v-model="frais.filiere"
                                item-value="id"
                                chips
                                closable-chips
                                color="blue-grey-lighten-2"
                                label="filiere"
                            ></v-autocomplete>
                        </v-col>
                        <v-col md="4" >

                            <v-autocomplete
                                :items="niveaux"
                                v-model="frais.niveau"
                                :item-title="formatNiveauLabel"
                                item-value="id"
                                chips
                                closable-chips
                                color="blue-grey-lighten-2"
                                label="Niveaux"
                            ></v-autocomplete>
                        </v-col>
                        <v-col md="4">

                            <TextField label="Code frais"  :isRequired="true" placeholder="Code frais" required @change="verify(frais)" v-model="frais.code"></TextField>
                        </v-col>
                        <v-col md="4">

                            <TextField label="Libelle frais"  :isRequired="true" placeholder="Libelle frais" required v-model="frais.libelle"></TextField>
                        </v-col>
                        <v-col md="4">

                            <TextField label="Montant frais"  :isRequired="true" placeholder="Montant frais" required v-model="frais.montant"></TextField>
                        </v-col>
                        <v-col md="4" v-if="type == '1' || type == '2'"></v-col>
                        <v-col md="1" offset-md="3">
                            <br>
                            <v-btn variant="outlined" :disabled="!(form.frais.length > 1)" icon @click="removeRow(frais)" fab small color="error">
                                <v-icon :icon="icons.mdiCloseCircle"></v-icon>
                            </v-btn>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col offset-md="11" md="1">
                            <v-btn variant="outlined" icon @click="addRow" fab small color="blue">
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
                <v-btn type="submit" title="enregistrer" color="info">
                    Enregistrer
                </v-btn>
            </v-col>
        </v-row>
        <br>
    </v-container>
    </form>
</template>
<script>
    import { router,useForm} from '@inertiajs/vue3';
    import { mdiCloseCircle, mdiPlusCircle, mdiInformation } from "@mdi/js";
  export default {
    props:['type','niveaux'],
    components: {
        mdiPlusCircle,
        mdiCloseCircle,
        mdiInformation
    },
    data: () => ({
        icons: {mdiPlusCircle,mdiCloseCircle,mdiInformation},
        step: 1,
        importation: false,
        form: useForm({
            fichier_frais: null,
            frais: [],
        }),
    }),

    methods: {
        formatNiveauLabel(item) {
            if(item){
                return `${item?.code} - ${item?.libelle}`;
            }
        },
        resetForm(check){
            if(check){
                this.form.frais = []
                this.addRow()
            }
        },
        submitForm() {
            // Empêche l'envoi du formulaire par défaut
            event.preventDefault();
            // Valide le formulaire avant de l'envoyer
            if (this.isValid()) {
                this.$emit('formSubmitted', this.form);
                this.$swal.fire({
                    title: 'Réussi',
                    text: "Mise à jour réussi avec succes!",
                    icon: 'success',
                    confirmButtonText: 'OK',
                });
                // this.$swal("Enregistrement réussi avec succes!")
            }else{
                // this.$swal.fire("Le formulaire n\'est pas valide. Merci de renseigner correctement et de reessayer!")
                this.$swal.fire({
                    title: 'Erreur',
                    text: "Le formulaire n\'est pas valide. Merci de renseigner correctement et de reessayer!",
                    icon: 'warning',
                    confirmButtonText: 'OK',
                });

            }
        },
        isValid() {
            let fichier = false
            let valid = false

            if(this.importation && this.form.fichier_frais != null){
                fichier = true
            }else if(!this.importation && !this.form.frais.find((el) => {

                    return el.niveau == null || el.niveau == '' || el.code == null || el.libelle == null || el.code == '' || el.libelle == '';


                }))
            {
                fichier = true
            }

            if(fichier){
                valid = true
            }else{
                valid = false
            }
            return valid
        },
        goBack() {
            router.get(route('etablissements.index'))
            console.log()
        },
        addRow() {
            this.form.frais.push({
                filiere: null,
                niveau: null,
                code: null,
                libelle: null,
                montant: null,
                before: null,
                after: null
            })
        },
        removeRow(id) {
            this.form.frais = this.form.frais.filter((el) => el !== id)
        },
        async verify(element) {
            const array = this.form.frais.filter(el => el.code !== null && el.code == element.code)

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




<!-- <template>
    <form @submit.prevent="submitForm">
        <v-container fluid>
        <v-card-text>

            <v-row>
                <v-alert text="Cette section vous permet de configurer" type="info"></v-alert>
            </v-row>

            <v-row >

                <v-col cols="5">
                    <v-switch  label="Souhaiterez-vous importez le fichier des frais ?" v-model="importation" color="info" ></v-switch>
                </v-col>
                <v-col>

                    <v-file-input v-if="importation"
                        clearable
                        label="File input"
                        variant="solo-inverted"
                        v-model="form.fichier_frais"
                    ></v-file-input>
                </v-col>
                <v-col></v-col>
            </v-row>
            <v-card v-if="!importation">
                <v-card-title class="text-h6 font-weight-regular justify-space-between">
                    <span style="color:blue">Renseigner les frais</span>&nbsp;
                </v-card-title>
                <v-card-text>
                    <v-row disabled :key="frais.id" v-for="(frais, i) in form.frais">
                        <v-col md="2"></v-col>
                        <v-col md="2">
                            <TextField label="Code filiere" placeholder="Code filiere" @change="verify(frais)" v-model="frais.code"></TextField>
                        </v-col>
                        <v-col md="3">
                            <TextField label="Nom de la filiere" placeholder="Nom de la filiere" v-model="frais.name"></TextField>
                        </v-col>
                        <v-col md="1">
                            <v-btn variant="outlined" :disabled="!(form.frais.length > 1)" icon @click="removeRow(frais)" fab small color="error">
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
            fichier_frais: null,
            frais: [],
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
            this.form.frais.push({
                code: null,
                name: null,
                etablissement: this.$page.props.admin_etablissement.etablissement_id,
                before: null,
                after: null
            })
        },
        removeRow(id) {
            this.form.frais = this.form.frais.filter((el) => el !== id)
        },
        async verify(element) {
            const array = this.form.frais.filter(el => el.code !== null && el.code == element.code)

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
</script> -->
