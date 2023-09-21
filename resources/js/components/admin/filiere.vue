
<template>
    <form @submit.prevent="submitForm" novalidate>
        <v-container fluid>
            <v-card variant="outlined" style="border: 2px solid #7d002c">
            <v-card-title style="color: white; background-color: #7d002c"
            >FILIERES</v-card-title
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
                    <li>Cette section vous permet de configurer les filieres enseignées dans cet établissement</li>
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

            <v-card >
                <v-card-text>

                   
                </v-card-text>
                <v-card-text v-if="!importation" >
                    <v-row>
                        <v-col offset-md="3" md="6">

                            <Autocomplete
                            label="Faculté"
                            class="mt-2"
                            :items="facultes"
                            v-model="form.faculte"
                            itemValue="id"
                            itemTitle="libelle"
                            chips
                            closable-chips
                            >
                        </Autocomplete>
                        </v-col>

                    </v-row>


                    <!-- <v-divider></v-divider> -->
                    <v-card class="mx-auto" >
                        <v-card-title flat style="color:#7d002c; background-color: white">Les départements</v-card-title>
                        <v-divider></v-divider>
                        <br />
                        <v-card-text disabled :key=" departement.id" v-for="( departement, i) in form.departements">

                            <v-row>
                                <v-col offset-md="3" md="6">

                                    <TextField  label="Departement" class="mt-2"  :isRequired="true" placeholder="Departement" v-model=" departement.departement" required></TextField>
                                </v-col>

                                <v-col  md="1">
                                    <br>
                                    <Button
                                        type="button"
                                        variant="outlined"
                                        :disabled="!(form.departements.length  > 1)"
                                        icon
                                        @click="removeRowUe( departement)"
                                        size="large"
                                        small
                                        color="error"
                                    >
                                        <v-icon :icon="icons.mdiCloseCircle"></v-icon>
                                    </Button>
                                </v-col>
                            </v-row>
                            <!-- <v-divider></v-divider> -->

                                <v-card-text>
                                    <v-card class="mx-auto" max-width="800">
                                        <v-card-title flat style="color:#7d002c; background-color: white">Les filières</v-card-title>
                                        <v-divider></v-divider>
                                        <br />
                                    <v-row disabled :key="filiere.id" v-for="(filiere, i) in  departement.filieres">
                                        <v-col offset-md="1" md="4">

                                            <TextField label="Code filiere" class="mt-2" :isRequired="true" placeholder="Code filiere"   v-model="filiere.code"></TextField>
                                        </v-col>
                                        <v-col md="4">

                                            <TextField label="Nom de la filiere" class="mt-2" :isRequired="true" placeholder="Nom de la filiere"   v-model="filiere.libelle"></TextField>
                                        </v-col>
                                        <v-col md="1">
                                            <br>
                                            <Button
                                                type="button"
                                                variant="outlined"
                                                :disabled="!(departement.filieres.length > 1)"
                                                icon
                                                @click="removeRow(departement,filiere)"
                                                size="large"
                                                small
                                                color="error"
                                            >
                                                <v-icon :icon="icons.mdiCloseCircle"></v-icon>
                                            </Button>

                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col offset-md="10" cols="4">
                                        <Button
                                            type="button"
                                            variant="outlined"
                                            @click="addRow(departement)"
                                            icon
                                            size="large"
                                            color="primary"
                                        >
                                            <v-icon :icon="icons.mdiPlusCircle" small></v-icon>
                                        </Button>
                                        </v-col>
                                    </v-row>
                                    <br>
                                </v-card>
                                </v-card-text>

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
                        <br>
                    </v-card>

                    <br>

                </v-card-text>
            </v-card>
            <br>
            <!-- <v-row class="text-center ml-3 mb-3"
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
        ></v-row> -->
        </v-card>
            <br>

        </v-container>
    </form>
</template>
<script>
    import { router,useForm} from '@inertiajs/vue3';
    import { mdiCloseCircle, mdiPlusCircle, mdiInformation } from "@mdi/js";
  export default {
    props:['type','niveaux','facultes'],
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
        form: useForm({
            faculte: null,
            fichier_filiere: null,
            departements: [],

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
                this.form.departements = []
                this.addRowUe()
                // this.addRow()


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
            this.form.departements.push({
                etablissement: this.$page.props.admin_etablissement.etablissement_id,
                departement: null,
                filieres: [],
                before: null,
                after: null
            });
            let  departements = this.form. departements[this.form. departements.length - 1]
            this.addRow(departements)
        },
        addRow(depart) {
             depart.filieres.push({
                code: null,
                libelle: null,
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








