<template>
    <form @submit.prevent="submitForm" novalidate>
        <v-container fluid>
            <v-card variant="outlined" style="border: 2px solid #7d002c">
            <v-card-title style="color: white; background-color: #7d002c"
            >AFFECTATION DE MATIERES AUX NIVEAUX</v-card-title
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
                    <li>Cette section vous permet d'attribuer les matieres aux <span v-if="type == '3' || type == '4'">filieres</span><span v-else>niveaux</span></li>
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
                <v-card-text>
                    <v-row>
                        <v-col md="4"></v-col>
                        <v-col md="4">

                            <Autocomplete
                            label="Niveaux"
                            class="mt-2"
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
                        <v-card-text>

                            <!-- <v-divider></v-divider> -->

                            <v-row disabled :key="matiere.id" v-for="(matiere, i) in form.matieres">
                                <v-col md="1"></v-col>
                                <v-col md="4">
                                    <Autocomplete
                                    label="Matieres"
                                    class="mt-2"
                                    item-title="libelle"
                                    item-value="id"
                                    :items="['maths','pc']"
                                    chips
                                    v-model="matiere.matiere"
                                    @update:modelValue="verify(matiere,i, $event)">
                                    </Autocomplete>
                                </v-col>
                                <v-col md="2">

                                    <TextField label="Coeff" class="mt-2" :isRequired="true" placeholder="Coeff" required v-model="matiere.coefficient"></TextField>
                                </v-col>
                                <v-col md="2">

                                    <TextField label="VH" class="mt-2" :isRequired="true" placeholder="VH" required v-model="matiere.volume_horaire"></TextField>
                                </v-col>
                                <v-col md="1">
                                    <br>
                                    <Button
                                        type="button"
                                        variant="outlined"
                                        :disabled="!(form.matieres.length > 1)"
                                        icon
                                        @click="removeRow(matiere)"
                                        size="large"
                                        small
                                        color="error"
                                    >
                                        <v-icon :icon="icons.mdiCloseCircle"></v-icon>
                                    </Button>
                                    <!-- <v-btn variant="outlined" :disabled="!(form.matieres.length > 1)" icon @click="removeRow(matiere)" fab small color="error">
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
                </v-card-text>
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
    props:['type','niveaux'],
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
        form: useForm({
            niveau: null,
            matieres: [],
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
        addRow() {
            this.form.matieres.push({
                etablissement_section_id: this.$page.props.admin_etablissement.etablissement_id,
                coefficient: 0,
                volume_horaire: 0,
                after: null
            })
        },
        removeRow(matiere) {
            this.form.matieres = this.form.matieres.filter((el) => el !== matiere)
        },
        async verify(matiere) {
            // console.log('ue',ue,'index',index,'matiere',matiere)
            const array = this.form.matieres.filter(el => el.matiere !== null && el.matiere == matiere.matiere)
            if (array.length > 1) {
                this.removeRow(matiere)
                this.$swal("L'élément existe déjà !")
                // this.$alert.error("L'élément existe déjà !");
            }
        },
    },
    created(){},
    mounted() {
        // this.addRowInit()
        this.addRow()
        this.section = this.getSection(this.type)
    },
  }
</script>
