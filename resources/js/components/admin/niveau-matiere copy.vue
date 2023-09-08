<template>
    <form @submit.prevent="submitForm" novalidate>
        <v-container fluid>
        <v-card-text>
            <v-row>
                <v-alert type="info">
                    <li>Cette section vous permet de configurer les matieres enseignées dans cet établissement</li>
                    <li v-if="type=='3'">Configurer également si l'établissement prend en charge le systeme LMD(Licence Master Doctorat) et le régime d'évaluation </li>
                    <li>Le formulaire sera valide si est seulement si tous les champs obligatoires marqués par <span style="color: red;">*</span> sont renseignés</li>
                </v-alert>
            </v-row>
            <br><br>
           
            <v-divider></v-divider>
            <v-card>
                <v-alert type="info"><li>Tous les champs de chaque ligne inserer sont obligatoires</li></v-alert>
                <v-row>
                <v-col md="2"></v-col>
                <v-col md="4">
                    <span style="color: red; font-size: x-large;">*</span>
                    <v-autocomplete label="Filieres" :items="['IG','MIEL']" chips></v-autocomplete>
                </v-col>
                <v-col md="4">
                    <span style="color: red; font-size: x-large;">*</span>
                    <v-autocomplete label="Niveaux" :items="['1ere année','2e année']" chips></v-autocomplete>
                </v-col>
                </v-row>
                <v-card>
                    <v-card-text>
                        
                    </v-card-text>
                <v-card-text>
                    <v-row disabled :key="matiere.id" v-for="(matiere, i) in form.matieres">
                        <!-- <v-col md="2"></v-col> -->
                        <v-col md="5">
                            <span style="color: red; font-size: x-large;">*</span>
                            <v-autocomplete label="Matieres" item-title="libelle" item-value="id" :items="matieres" chips v-model="matiere.matiere">
                            </v-autocomplete>
                        </v-col>
                        <v-col md="3">
                            <span style="color: red; font-size: x-large;">*</span>
                            <text-field label="Coefficient" placeholder="Coefficient" required v-model="matiere.coefficient"></text-field>
                        </v-col>
                        <v-col md="3">
                            <span style="color: red; font-size: x-large;">*</span>
                            <text-field label="Volume horaire" placeholder="Volume horaire" required v-model="matiere.coefficient"></text-field>
                        </v-col>
                        <v-col md="1">
                            <br>
                            <v-btn variant="outlined" :disabled="!(form.matieres.length > 1)" icon @click="removeRow(matiere)" fab small color="error">
                                <v-icon :icon="icons.mdiCloseCircle"></v-icon>
                            </v-btn>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col offset-md="11" md="1">
                            <v-btn variant="outlined" icon @click="addRow" fab small color="info">
                                <v-icon :icon="icons.mdiPlusCircle"></v-icon>
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-text>
                </v-card>
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
        section: null,
        form: useForm({
            lmd: false,
            regime_evaluation: false,
            fichier_matiere: null,
            type_lmd: null,
            matieres: [],
            etablissement_section_id: null
        }),
    }),
    
    methods: {
        getSection(type){
            console.log('type',type)
            if(type == '1'){
                return 'Primaire'
            }else if(type == '2'){
                return 'Secondaire'
            }else{
                return 'Supérieur'
            }
        },
        resetForm(check){
            if(check){
                this.form.matieres = []
                this.addRow()
            }
        },
        submitForm() {
            // Empêche l'envoi du formulaire par défaut
            event.preventDefault();
            // Valide le formulaire avant de l'envoyer
            if (this.isValid()) {
                this.form.etablissement_section_id = this.$page.props.sections.find(el => el.section.libelle == this.section)
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
            let lmd = false
            let fichier = false
            let valid = false
            if(this.form.lmd && this.form.type_lmd != null){
                lmd = true
            }else if(!this.form.lmd && this.form.type_lmd == null){
                lmd = true
            }
            if(this.importation && this.form.fichier_matiere != null){
                fichier = true
            }else if(!this.importation && !this.form.matieres.find(el => el.code == null || el.libelle == null || el.code == '' || el.libelle == '')){
                fichier = true
            }
            if(lmd && fichier){
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
        this.section = this.getSection(this.type)
    },
  }
</script>