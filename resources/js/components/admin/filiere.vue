
<template>
    <form @submit.prevent="submitForm" novalidate>
        <v-container fluid>
            <v-row>
                <v-alert type="info">
                    <li>Cette section vous permet de configurer les filieres enseignées dans cet établissement</li>
                    <li>Le formulaire sera valide si est seulement si tous les champs obligatoires marqués par <span style="color: red;">*</span> sont renseignés</li>
                </v-alert>
            </v-row>
            <br>
            <v-card >
                <v-card-text>

                    <v-row>
                        <v-col>
                            <v-switch label="Souhaiterez-vous importez le fichier des filieres ?" @update:modelValue="resetForm(importation)" v-model="importation" color="info" inset> </v-switch>
                        </v-col>
                        <v-col v-if="importation">
                              
                            <v-file-input
                                clearable
                                required
                                v-model="form.fichier_filiere"
                                label="Charger le fichier des filiére"
                                variant="solo-inverted"
                            ></v-file-input>
                        </v-col>
                        <v-col></v-col>
                    </v-row>
                </v-card-text>
            </v-card>
            <v-divider></v-divider>
            <v-card v-if="!importation">
                <v-card-text >
                    <v-row>
                        <v-col offset-md="3" md="4">
                              
                            <v-autocomplete label="Faculté" :items="['FAST','FASE']" v-model="form.faculte" chips></v-autocomplete>
                        </v-col>

                    </v-row>


                    <!-- <v-divider></v-divider> -->

                        <v-card-text disabled :key=" departement.id" v-for="( departement, i) in form. departements">
                            <v-card class="mx-auto" max-width="1000">
                            <v-row>
                                <v-col offset-md="3" md="4">
                                      
                                    <TextField  label="Departement"  isRequired="true" placeholder="Departement" v-model=" departement.departement" required></TextField>
                                </v-col>
                               
                                <v-col offset-md="4" md="1">
                                    <br>
                                    <v-btn variant="outlined" :disabled="!(form. departements.length > 1)" icon @click="removeRowUe( departement)" fab small color="error">
                                        <v-icon :icon="icons.mdiCloseCircle"></v-icon>
                                    </v-btn>
                                </v-col>
                            </v-row>
                            <!-- <v-divider></v-divider> -->
                                <v-card-text>
                                    <v-row disabled :key="filiere.id" v-for="(filiere, i) in  departement.filieres">
                                        <v-col md="3"></v-col>
                                        <v-col md="2">
                                              
                                            <TextField label="Code filiere"  isRequired="true" placeholder="Code filiere" required @change="verify(filiere)" v-model="filiere.code"></TextField>
                                        </v-col>
                                        <v-col md="4">
                                              
                                            <TextField label="Nom de la filiere"  isRequired="true" placeholder="Nom de la filiere" required v-model="filiere.libelle"></TextField>
                                        </v-col>
                                        <v-col md="1">
                                            <br>
                                            <v-btn variant="outlined" :disabled="!( departement.filieres.length > 1)" icon @click="removeRow( departement,filiere)" fab small color="error">
                                                <v-icon :icon="icons.mdiCloseCircle"></v-icon>
                                            </v-btn>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col offset-md="10" md="1">
                                            <v-btn variant="outlined" icon @click="addRow( departement)" fab small color="info">
                                                <v-icon :icon="icons.mdiPlusCircle"></v-icon>
                                            </v-btn>
                                        </v-col>
                                    </v-row>
                                </v-card-text>
                            </v-card>
                            <br>
                        </v-card-text>
                        <v-row>

                            <v-col offset-md="11" md="1">
                                <v-btn variant="outlined" icon @click="addRowUe" fab small color="info">
                                    <v-icon :icon="icons.mdiPlusCircle"></v-icon>
                                </v-btn>
                            </v-col>
                        </v-row>

                </v-card-text>
            </v-card>
            <br>
            <v-row>
                <v-col md="5"></v-col>
                <v-col md="4">
                    <v-btn type="submit" title="enregistrer" color="info">
                        Enregistrer
                    </v-btn>
                </v-col>
            </v-row>
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
        section: null,
        form: useForm({
            faculte: null,
            fichier_filiere: null,
            departements: [],
           
        }),
    }),

    methods: {
        formatNiveauLabel(item) {
            if(item){
                return `${item?.code} - ${item?.libelle}`;
            }
        },
        getSection(type){
            console.log('type',type)
            if(type == '1'){
                return 'Primaire'
            }else if(type == '2'){
                return 'Secondaire'
            }else if(type == '3'){
                return 'Supérieur'
            }else{
                return 'Universitaire'
            }
        },
        resetForm(check){
            if(check){
                this.form.filieres = []
                if (this.importation==false){
                    this.addRow()
                }
               
            }
        },
        submitForm() {
            // Empêche l'envoi du formulaire par défaut
            event.preventDefault();
            // Valide le formulaire avant de l'envoyer
            if (this.isValid()) {
                // this.form.etablissement_section_id = this.$page.props.sections.find(el => el.section.libelle == this.section)
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
            // let lmd = false
            // let fichier = false
            // let valid = false
            // if(this.form.lmd && this.form.type_lmd != null){
            //     lmd = true
            // }else if(!this.form.lmd && this.form.type_lmd == null){
            //     lmd = true
            // }
            // if(this.importation && this.form.fichier_filiere != null){
            //     fichier = true
            // }else if(!this.importation && !this.form.filieres.find(el => el.code == null || el.libelle == null || el.code == '' || el.libelle == '')){
            //     fichier = true
            // }
            // if(lmd && fichier){
            //     valid = true
            // }else{
            //     valid = false
            // }
            return true
        },
        goBack() {
            router.get(route('etablissements.index'))
            console.log()
        },
        addRowUe() {
            this.form. departements.push({
                departement: null,
                filieres: [],
                before: null,
                after: null
            });
            let  departement = this.form. departements[this.form. departements.length - 1]
            this.addRow( departement)
        },
        addRow( departement) {
             departement.filieres.push({
                code: null,
                libelle: null,
                etablissement: this.$page.props.admin_etablissement.etablissement_id,
                before: null,
                after: null
            })
        },
        // addRowInit(){
        //     this.form. departements[0].filieres.push({
        //         filiere_id: null,
        //         coefficient: null,
        //         volume_horaire: null,
        //         after: null
        //     })
        // },
        removeRowUe(id) {
            this.form. departements = this.form. departements.filter((el) => el !== id)
        },
        removeRow( departement,filiere) {
             departement.filieres =  departement.filieres.filter((el) => el !== filiere)
        },
        async verifyUe(element) {
            const array = this.form. departements.filter(el => el. departement_id !== null && el. departement_id == element.id)

            if (array.length > 1) {
                this.removeRow(element)
                this.$swal("L'élément existe déjà !")
                // this.$alert.error("L'élément existe déjà !");
            }
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
        this.addRowUe()
        // this.addRowInit()
        this.section = this.getSection(this.type)
    },
  }
</script>








