<template>
    <form @submit.prevent="submitForm" novalidate>
        <v-container fluid>
            <v-row>
                <v-alert type="info">
                    <li>Cette section vous permet d'attribuer les matieres aux <span v-if="type == '3' || type == '4'">filieres</span><span v-else>niveaux</span></li>
                    <li v-if="type=='3'">Configurer également si l'établissement prend en charge le systeme LMD(Licence Master Doctorat) et le régime d'évaluation </li>
                    <li>Le formulaire sera valide si est seulement si tous les champs obligatoires marqués par <span style="color: red;">*</span> sont renseignés</li>
                </v-alert>
            </v-row>
            <br>
            <v-card>
                <v-card-text>
                    <v-row>
                        <v-col md="2"></v-col>
                        <v-col md="4">

                            <v-autocomplete label="Filieres" :items="['IG','MIEL']" v-model="form.filiere" chips></v-autocomplete>
                        </v-col>
                        <v-col md="4">

                            <v-autocomplete label="Niveaux" :item-title="formatNiveauLabel" item-value="id" :items="niveaux" v-model="form.niveau" chips></v-autocomplete>
                        </v-col>
                    </v-row>
                    <!-- <v-divider></v-divider> -->
                    <v-card class="mx-auto" max-width="1200">
                        <v-card-text disabled :key="ue.id" v-for="(ue, i) in form.ues">
                            <v-row>
                                <v-col md="1"></v-col>
                                <v-col md="3">

                                    <v-autocomplete label="Unité d'enseignement" :items="uetabs" v-model="ue.ue" @update:modelValue="onSelectChange(form.ues[i].ue)" chips></v-autocomplete>
                                </v-col>
                                <v-col md="2">

                                    <TextField label="credit" :isRequired="true" placeholder="credit" v-model="form.ues[i].credit" required></TextField>
                                </v-col>
                                <v-col md="2">

                                    <TextField label="Volume horaire" :isRequired="true" placeholder="Volume horaire" v-model="form.ues[i].volume_horaire" required></TextField>
                                </v-col>
                                <v-col md="1">
                                    <br>
                                    <v-btn variant="outlined" :disabled="!(form.ues.length > 1)" icon @click="removeRowUe(form.ues[i])" fab small color="error">
                                        <v-icon :icon="icons.mdiCloseCircle"></v-icon>
                                    </v-btn>
                                </v-col>
                            </v-row>
                            <!-- <v-divider></v-divider> -->
                            <v-card class="mx-auto" max-width="800">
                                <v-card-text>
                                    <v-row disabled :key="matiere.id" v-for="(matiere, i) in ue.matieres">
                                        <v-col md="1"></v-col>
                                        <v-col md="4">

                                            <v-autocomplete label="Matieres" item-title="libelle" item-value="id" :items="['Algo','Merise']" chips v-model="ue.matieres[i].matiere" @update:modelValue="verify(ue,i, $event)">
                                            </v-autocomplete>
                                        </v-col>
                                        <v-col md="2">

                                            <TextField label="Coeff" placeholder="Coeff" required v-model="ue.matieres[i].coefficient"></TextField>
                                        </v-col>
                                        <v-col md="2">

                                            <TextField label="VH" :isRequired="true" placeholder="VH" required v-model="ue.matieres[i].volume_horaire" @blur="verifySomme(ue,i)"></TextField>
                                        </v-col>
                                        <v-col md="1">
                                            <br>
                                            <v-btn variant="outlined" :disabled="!(ue.matieres.length > 1)" icon @click="removeRow(ue,ue.matieres[i])" fab small color="error">
                                                <v-icon :icon="icons.mdiCloseCircle"></v-icon>
                                            </v-btn>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col offset-md="11" md="1">
                                            <v-btn variant="outlined" icon @click="addRow(ue)" fab small color="info">
                                                <v-icon :icon="icons.mdiPlusCircle"></v-icon>
                                            </v-btn>
                                        </v-col>
                                    </v-row>
                                </v-card-text>
                            </v-card>
                        </v-card-text>
                        <v-row>
                            <v-col offset-md="11" md="1">
                                <v-btn variant="outlined" :disabled="(uetabs.length == 0)" icon @click="addRowUe" fab small color="info">
                                    <v-icon :icon="icons.mdiPlusCircle"></v-icon>
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-card>
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
        uetabs: [],
        form: useForm({
            filiere: null,
            niveau: null,
            ues: [],
            etablissement_section_id: null
        }),
    }),

    methods: {
        verifySomme(ue,i){
            const somme = ue.matieres.reduce((accumulator, currentItem) => {
                return accumulator + parseFloat(currentItem.volume_horaire);
            }, 0);
            if(somme > ue.volume_horaire){
                this.removeRow(ue,ue.matieres[i])
                this.$swal("La somme des volumes horaires ne doivent pas dépasser "+ue.volume_horaire+"!")
            }      // this.somme =  this.somme + parseFloat(nbre || 0);
            console.log('somme',somme,'ue',ue.volume_horaire)
        },
        onSelectChange(itemToRemove){
            const indexToRemove = this.uetabs.indexOf(itemToRemove);
            if (indexToRemove !== -1) {
                // Si l'élément existe dans le tableau, supprimez-le
                this.uetabs.splice(indexToRemove, 1);
            }
        },
        formatNiveauLabel(item) {
            if(item){
                return `${item?.code} - ${item?.libelle}`;
            }
        },
        getSection(type){
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
            // if(this.importation && this.form.fichier_matiere != null){
            //     fichier = true
            // }else if(!this.importation && !this.form.matieres.find(el => el.code == null || el.libelle == null || el.code == '' || el.libelle == '')){
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
        },
        addRowUe() {
            this.form.ues.push({
                ue_id: null,
                credit: 0,
                volume_horaire: 0,
                matieres: [],
                before: null,
                after: null
            });
            let ue = this.form.ues[this.form.ues.length - 1]
            this.addRow(ue)
        },
        addRow(ue) {
            ue.matieres.push({
                matiere_id: null,
                coefficient: 0,
                volume_horaire: 0,
                after: null
            })
        },
        removeRowUe(id) {
            this.form.ues = this.form.ues.filter((el) => el !== id)
        },
        removeRow(ue,matiere) {
            ue.matieres = ue.matieres.filter((el) => el !== matiere)
        },
        async verifyUe(element) {
            const array = this.form.ues.filter(el => el.ue_id !== null && el.ue_id == element.id)

            if (array.length > 1) {
                this.removeRow(element)
                this.$swal("L'élément existe déjà !")
                // this.$alert.error("L'élément existe déjà !");
            }
        },
        async verify(ue,index,matiere) {
            // console.log('ue',ue,'index',index,'matiere',matiere)
            const array = ue.matieres.filter(el => el.matiere !== null && el.matiere == matiere)
            if (array.length > 1) {
                this.removeRow(ue,ue.matieres[index])
                this.$swal("L'élément existe déjà !")
                // this.$alert.error("L'élément existe déjà !");
            }
        },
    },
    created(){},
    mounted() {
        this.uetabs = ['UE101','UE102']
        this.addRowUe()
        // this.addRowInit()
        this.section = this.getSection(this.type)
    },
  }
</script>
