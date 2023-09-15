<template>
    <form @submit.prevent="submitForm" novalidate>
        <v-container fluid>
        <v-card-text>
            <v-row>
                <v-alert type="info">
                    <li>Cette section vous permet de configurer les unités des enseignements de cet établissement</li>
                    <li>Le formulaire sera valide si est seulement si tous les champs obligatoires marqués par <span style="color: red;">*</span> sont renseignés</li>
                </v-alert>
            </v-row>
            <br><br>
            <v-card>
                <v-card-text>

                    <v-row>
                        <v-col>
                            <v-switch label="Souhaiterez-vous importez le fichier des unités des enseignements ?" @update:modelValue="resetForm(importation)" v-model="importation" color="info" inset></v-switch>
                        </v-col>
                        <v-col v-if="importation">
                            <span style="color: red; font-size: x-large;">*</span>
                            <v-file-input
                                clearable
                                required
                                v-model="form.fichier_ue"
                                label="Charger le fichier des UES"
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
                    <v-row disabled :key="ue.id" v-for="(ue, i) in form.ues">
                        <v-col md="2">

                            <TextField label="Code UE"  isRequired="true" placeholder="Code UE" required @change="verify(ue)" v-model="ue.code"></TextField>
                        </v-col>
                        <v-col md="3">
                        
                            <TextField label="Nom de l'UE"  :isRequired="true" placeholder="Nom de l'UE" required v-model="ue.libelle"></TextField>
                        </v-col>
                        <v-col md="1">
                            <br>
                            <v-btn variant="outlined" :disabled="!(form.ues.length > 1)" icon @click="removeRow(ue)" fab small color="error">
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
    </v-container>
        <v-row>
            <v-col md="5"></v-col>
            <v-col md="4">
                <v-btn type="submit" title="enregistrer" color="info">
                    Enregistrer
                </v-btn>
            </v-col>
        </v-row>
        <br>
    </form>
</template>
<script>
    import { router,useForm} from '@inertiajs/vue3';
    import { mdiCloseCircle, mdiPlusCircle, mdiInformation } from "@mdi/js";
  export default {
    props:['type'],
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
            fichier_ue: null,
            ues: [],
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
                this.form.ues = []
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

            if(this.importation && this.form.fichier_ue != null){
                fichier = true
            }else if(!this.importation && !this.form.ues.find((el) => {
                return el.code == null || el.libelle == null || el.code == '' || el.libelle == '';
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
            this.form.ues.push({
                code: null,
                libelle: null,
                etablissement: this.$page.props.admin_etablissement.etablissement_id,
                before: null,
                after: null
            })
        },
        removeRow(id) {
            this.form.ues = this.form.ues.filter((el) => el !== id)
        },
        async verify(element) {
            const array = this.form.ues.filter(el => el.code !== null && el.code == element.code)

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

