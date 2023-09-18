<template>
    <form @submit.prevent="submitForm" novalidate>
        <v-container fluid>
            <v-card  variant="outlined" style="border: 2px solid #7d002c">
        <v-card-title style="color: white; background-color: #7d002c"
          >AFFECTATION DE MATIERES AUX NIVEAUX</v-card-title>
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
            <li>Cette section vous permet d'attribuer les matieres aux <span v-if="type == '3' || type == '4'">filieres</span><span v-else>niveaux</span></li>
            <li v-if="type=='3'">Configurer également si l'établissement prend en charge le systeme LMD(Licence Master Doctorat) et le régime d'évaluation </li>
            <li>Le formulaire sera valide si est seulement si tous les champs obligatoires marqués par <span style="color: red;">*</span> sont renseignés</li>

          </v-alert>

          <div v-if="!alertFirst" style="margin: auto; width: 50%; padding: 10px">
            <Button
              style="height: 30px"
              type="button"
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
                    <v-row>
                        <v-col md="2"></v-col>
                        <v-col md="4">
                            <Autocomplete
                            label="Filieres"
                            item-title="libelle"
                            item-value="id"
                            :items="tabsFilieres"
                            v-model="form.filiere"
                            chips>
                        </Autocomplete>
                        </v-col>
                        <v-col md="4">
                            <Autocomplete
                            label="Niveaux"
                            :item-title="formatNiveauLabel"
                            item-value="id"
                            :items="niveaux"
                            v-model="form.niveau"
                            chips>
                        </Autocomplete>
                        </v-col>
                    </v-row>
                    <!-- <v-divider></v-divider> -->
                    <v-card class="mx-auto" max-width="1200">
                        <v-card-title flat style="color:#7d002c; background-color: white">Unité d'enseingment</v-card-title>
                        <v-card-text disabled :key="ue.id" v-for="(ue, i) in form.ues">
                            <v-row>
                                <v-col md="1"></v-col>
                                <v-col md="3">

                                    <Autocomplete
                                    label="Unité d'enseignement"
                                    class="mt-2"
                                    item-title="libelle"
                                    item-value="id"
                                    :items="uetabs"
                                    v-model="ue.ue"
                                    @update:modelValue="verifyUe(form.ues[i])"
                                    chips>
                                </Autocomplete>
                                </v-col>
                                <v-col md="2">

                                    <TextField label="credit" class="mt-2" :isRequired="true" placeholder="credit" v-model="form.ues[i].credit" required></TextField>
                                </v-col>
                                <v-col md="2">

                                    <TextField label="Volume horaire"  class="mt-2" :isRequired="true" placeholder="Volume horaire" v-model="form.ues[i].volume_horaire" required></TextField>
                                </v-col>
                                <v-col md="1">
                                    <br>
                                    <Button
                                        type="button"
                                        variant="outlined"
                                        :disabled="form.ues ? !(form.ues.length > 1) : true"
                                        icon
                                        @click="removeRowUe(form.ues[i])"
                                        size="large"
                                        small
                                        color="error"
                                    >
                                        <v-icon :icon="icons.mdiCloseCircle"></v-icon>
                                    </Button>
                                    <!-- <v-btn variant="outlined" :disabled="form.ues ? !(form.ues.length > 1) : true" icon @click="removeRowUe(form.ues[i])" fab small color="error">
                                        <v-icon :icon="icons.mdiCloseCircle"></v-icon>
                                    </v-btn> -->
                                </v-col>
                            </v-row>
                            <!-- <v-divider></v-divider> -->
                            <v-card class="mx-auto" max-width="800">
                                <v-card-title flat style="color:#7d002c; background-color: white">les Matières</v-card-title>
                                <v-card-text>
                                    <v-row disabled :key="matiere.id" v-for="(matiere, i) in ue.matieres">
                                        <v-col md="1"></v-col>
                                        <v-col md="4">
                                            <Autocomplete
                                            label="Matieres"
                                            class="mt-2"
                                            item-title="libelle"
                                            item-value="id"
                                            :items="matieres"
                                            chips v-model="ue.matieres[i].matiere"
                                            @update:modelValue="verify(ue,i, $event)">
                                            </Autocomplete>
                                        </v-col>
                                        <v-col md="2">

                                            <TextField label="Coeff" class="mt-2" placeholder="Coeff" :isRequired="true" v-model="ue.matieres[i].coefficient"></TextField>
                                        </v-col>
                                        <v-col md="2">

                                            <TextField label="VH"  class="mt-2" :isRequired="true" placeholder="VH"  v-model="ue.matieres[i].volume_horaire" @blur="verifySomme(ue,i)"></TextField>
                                        </v-col>
                                        <v-col md="1">
                                            <br>
                                            <Button
                                                type="button"
                                                variant="outlined"
                                                :disabled="ue.matieres ? !(ue.matieres.length > 1) : true"
                                                icon
                                                @click="removeRow(ue,ue.matieres[i])"
                                                size="large"
                                                small
                                                color="error"
                                            >
                                                <v-icon :icon="icons.mdiCloseCircle"></v-icon>
                                            </Button>
                                            <!-- <v-btn variant="outlined" :disabled="ue.matieres ? !(ue.matieres.length > 1) : true" icon @click="removeRow(ue,ue.matieres[i])" fab small color="error">
                                                <v-icon :icon="icons.mdiCloseCircle"></v-icon>
                                            </v-btn> -->
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col offset-md="11" cols="4">
                                            <Button
                                                type="button"
                                                variant="outlined"
                                                @click="addRow(ue)"
                                                icon
                                                size="large"
                                                color="primary"
                                            >
                                                <v-icon :icon="icons.mdiPlusCircle" small></v-icon>
                                            </Button>
                                        </v-col>

                                    </v-row>
                                    <!-- <v-row>

                                        <v-col offset-md="11" md="1">
                                            <v-btn variant="outlined" icon @click="addRow(ue)" fab small color="info">
                                                <v-icon :icon="icons.mdiPlusCircle"></v-icon>
                                            </v-btn>
                                        </v-col>
                                    </v-row> -->
                                </v-card-text>
                            </v-card>
                        </v-card-text>
                        <v-row>
                            <v-col offset-md="11" cols="4">
                                <Button
                                    type="button"
                                    variant="outlined"
                                    @click="addRowUe"
                                    icon
                                    size="large"
                                    color="primary"
                                >
                                    <v-icon :icon="icons.mdiPlusCircle" small></v-icon>
                                </Button>
                            </v-col>

                        </v-row>
                        <!-- <v-row>
                            <v-col offset-md="11" md="1">
                                <v-btn variant="outlined" :disabled="uetabs ? (uetabs.length == 0) : true" icon @click="addRowUe" fab small color="info">
                                    <v-icon :icon="icons.mdiPlusCircle"></v-icon>
                                </v-btn>
                            </v-col>
                        </v-row> -->
                    </v-card>
                </v-card-text>
                <br>
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
    props:['type','niveaux','matieres','filieres','ues'],
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
        section: null,
        uetabs: [],
        tabsFilieres: [],
        form: useForm({
            filiere: null,
            niveau: null,
            ues: [],
            etablissement_section_id: null
        }),
    }),
    methods: {
        onclickAlertButton(type) {
        if (type == "second") {
            this.alertSecond = true;
        }
        if (type == "first") this.alertFirst = true;
        },
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
            const array = this.form.ues.filter(el => el.ue !== null && el.ue == element.ue)
            if (array.length > 1) {
                this.removeRowUe(element)
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


        console.log('resultat',this.tabsFilieres)
        console.log('ues',this.ues)
        this.uetabs = this.ues
        this.addRowUe()
        // this.addRowInit()
        this.section = this.getSection(this.type)
    },
  }
</script>
