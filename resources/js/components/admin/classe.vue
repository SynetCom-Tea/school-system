<template>
    <form @submit.prevent="submitForm" novalidate>
        <v-container fluid>
        <v-card-text>
            <v-row>
                <v-alert type="info">
                    <li>Cette section vous permet de configurer les salles de cet établissement</li>
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
                            <v-switch label="Souhaiterez-vous importez le fichier des salles ?" @update:modelValue="resetForm(importation)" v-model="importation" color="info" inset></v-switch>
                        </v-col>
                        <v-col v-if="importation">
                              
                            <v-file-input
                                clearable
                                required
                                v-model="form.fichier_classe"
                                label="Charger le fichier de salles"
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
                    <v-row disabled :key="classe.id" v-for="(classe, i) in form.classes">
                        <v-col md="2" v-if="type == '3' || type == '4'">
                              
                            <v-autocomplete
                                :items="niveaux"
                                v-model="classe.niveau"
                                :item-title="formatNiveauLabel"
                                item-value="id"
                                chips
                                closable-chips
                                color="blue-grey-lighten-2"
                                label="Niveaux"
                            ></v-autocomplete>
                        </v-col>
                        <v-col md="2">
                              
                            <TextField label="Code salle"  isRequired="true" placeholder="Code salle" required @change="verify(classe)" v-model="classe.code"></TextField>
                        </v-col>
                        <v-col md="3">
                              
                            <TextField label="Libelle salle"  isRequired="true" placeholder="Libelle salle" required v-model="classe.libelle"></TextField>
                        </v-col>
                        <v-col md="1">
                            <br>
                            <v-btn variant="outlined" :disabled="!(form.classes.length > 1)" icon @click="removeRow(classe)" fab small color="error">
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
        </v-container>
        <br>
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
            fichier_classe: null,
            classes: [],
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
                this.form.classes = []
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

            if(this.importation && this.form.fichier_classe != null){
                fichier = true
            }else if(!this.importation && !this.form.classes.find((el) => {
                if(this.type == '3' || this.type == '4'){
                    return el.niveau == null || el.niveau == '' || el.code == null || el.libelle == null || el.code.trim() == '' || el.libelle.trim() == '';
                }else{
                    return el.code == null || el.libelle == null || el.code.trim() == '' || el.libelle.trim() == '';
                }}))
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
            this.form.classes.push({
                niveau: null,
                code: null,
                libelle: null,
                before: null,
                after: null
            })
        },
        removeRow(id) {
            this.form.classes = this.form.classes.filter((el) => el !== id)
        },
        async verify(element) {
            const array = this.form.classes.filter(el => el.code !== null && el.code == element.code)

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
