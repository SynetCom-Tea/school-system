<template>
    <form @submit.prevent="submitForm" novalidate>
        <v-container fluid>
            <v-card variant="outlined" style="border: 2px solid #7d002c">
            <v-card-title style="color: white; background-color: #7d002c"
            >FRAIS</v-card-title
            >
            <v-divider></v-divider>
            <br />
            <div style="margin: 10px">
                <v-alert
                    v-model="alertFirst"
                    border="start"
                    variant="tonal"
                    closable
                    close-label="Close Alert"
                    color="primary"
                    type="info"
                    title="Note"
                >
                    <li>Cette section vous permet de configurer les frais de cet établissement</li>
                    <li>Le formulaire sera valide si est seulement si tous les champs obligatoires marqués par <span style="color: red;">*</span> sont renseignés</li>
                </v-alert>

                <div v-if="!alertFirst" style="margin: auto; width: 50%; padding: 10px">
                    <Button
                    style="height: 30px"
                    title="Plier la note"
                    @click="onclickAlertButton('first')"
                    variant="outlined"
                    color="primary"
                    nameButton="Relire la note"
                    >
                    </Button>
                </div>
            </div>


            <v-divider></v-divider>
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
                            <v-switch
                            :label="`${
                                !importation
                                    ? 'Renseignement des données par champs'
                                    : 'Importatation d\'un fichier pour alimenter les frais de scolarité et autres'
                                }`"
                             @update:modelValue="resetForm(importation)"
                              v-model="importation"
                              color="info" inset></v-switch>
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
                        <v-col v-if="importation"><v-btn 
                            class="ma-2" 
                            outlined 
                            type="button"
                            color="primary"
                            href="../models/echantillons/fiche_echantillonage.ods"
                            download>
                                Télécharger le Model
                        </v-btn></v-col>
                    </v-row>
                </v-card-text>
            </v-card>
            <v-divider></v-divider>
            <v-card v-if="!importation">
                 <v-card-text>
                    <v-row disabled :key="frais.id" v-for="(frais, i) in form.frais">
                        <v-col md="3" v-if="type == '3' || type == '4'" >

                            <Autocomplete
                                :items="tabsFilieres"
                                class="mt-2"
                                v-model="frais.filiere"
                                item-value="id"
                                item-title="code"
                                chips
                                closable-chips
                                color="blue-grey-lighten-2"
                                label="filiere"
                            ></Autocomplete>
                        </v-col>
                        <v-col md="3" >

                            <Autocomplete
                                :items="niveaux"
                                class="mt-2"
                                v-model="frais.niveau"
                                :item-title="formatNiveauLabel"
                                item-value="id"
                                chips
                                closable-chips
                                color="blue-grey-lighten-2"
                                label="Niveaux"
                            ></Autocomplete>
                        </v-col>
                        <!-- <v-col md="4">

                            <TextField label="Code frais" class="mt-2"  :isRequired="true" placeholder="Code frais" required @change="verify(frais)" v-model="frais.code"></TextField>
                        </v-col> -->
                        <v-col md="3">

                            <TextField label="Libelle frais" class="mt-2"  :isRequired="true" placeholder="Libelle frais" required v-model="frais.libelle"></TextField>
                        </v-col>
                        <v-col md="2">

                            <TextField label="Montant frais" class="mt-2"  :isRequired="true" placeholder="Montant frais" required v-model="frais.montant"></TextField>
                        </v-col>
                        <v-col md="1" >
                            <br>
                            <Button
                                type="button"
                                variant="outlined"
                                :disabled="!(form.frais.length > 1)"
                                icon
                                @click="removeRow(frais)"
                                size="large"
                                small
                                color="error"
                            >
                                <v-icon :icon="icons.mdiCloseCircle"></v-icon>
                            </Button>
                            <!-- <v-btn variant="outlined" :disabled="!(form.frais.length > 1)" icon @click="removeRow(frais)" fab small color="error">
                                <v-icon :icon="icons.mdiCloseCircle"></v-icon>
                            </v-btn> -->
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col offset-md="11" cols="4">
                            <Button
                                type="button"
                                variant="outlined"
                                @click="addRow"
                                icon
                                size="large"
                                color="primary"
                            >
                                <v-icon :icon="icons.mdiPlusCircle" small></v-icon>
                            </Button>
                            </v-col>
                        <!-- <v-col offset-md="11" md="1">
                            <v-btn variant="outlined" icon @click="addRow" fab small color="blue">
                                <v-icon :icon="icons.mdiPlusCircle"></v-icon>
                            </v-btn>
                        </v-col> -->
                    </v-row>
                </v-card-text>
            </v-card>
            <br>
            <v-row class="text-center ml-3 mb-3"
            ><v-col cols="auto">
                <Button
                type="submit"
                title="Enregistrer cette étape"
                nameButton="Enregistrer"
                variant="flat"
                @click="submitForm"
                density="comfortable"
                class="text-center"
                :isBlock="true"
                size="large"
                style="text-transform: none"
                >
                </Button> </v-col
            ></v-row>
    </v-card>
    </v-container>
    </form>
</template>
<script>
    import { router,useForm} from '@inertiajs/vue3';
    import { mdiCloseCircle, mdiPlusCircle, mdiInformation } from "@mdi/js";
  export default {
    props:['type','niveaux','filieres'],
    components: {
        mdiPlusCircle,
        mdiCloseCircle,
        mdiInformation
    },
    data: () => ({
        alertFirst: true,
        alertSecond: true,
        icons: {mdiPlusCircle,mdiCloseCircle,mdiInformation},
        step: 1,
        importation: false,
        tabsFilieres: [],
        form: useForm({
            fichier_frais: null,
            frais: [],
        }),
    }),

    methods: {
        onclickAlertButton(type) {
            if (type == "second") {
                this.alertSecond = true;
            }
            if (type == "first") this.alertFirst = true;
            },
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

                    return el.niveau == null || el.niveau == '' || el.libelle == null || el.libelle == '';


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
                etablissement:this.$page.props.admin_etablissement.etablissement_id,
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
    created(){
        if(this.type == '3'){
            this.tabsFilieres = this.filieres ? this.filieres.filieres : []
        }else if(this.type == '4'){
            if (this.filieres.departements && Array.isArray(this.filieres.departements)) {
                this.filieres.departements.forEach(element => {
                    this.tabsFilieres = this.tabsFilieres.concat(element.filieres)
                });
            }
        }
    },
    mounted() {
        //
        console.log('resultat',this.tabsFilieres)

        this.addRow()
    },
  }
</script>




