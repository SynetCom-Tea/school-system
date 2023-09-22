<template>
    <AuthenticatedLayout>
    <Toolbar
      styleToolbar="background-color: white;"
      :icon="icons.mdiSchool"
      :toolbarTitle="Title"
    ></Toolbar>
    <!-- <br> -->

    <div>
    <!-- Application de stepper -->
    <form-wizard
      color="#004980"
      back-button-text="Retour"
      next-button-text="Suivant"
      finish-button-text="Enregistrer"
      @on-complete="sendForm" @on-loading="handleLoading" @on-error="handleError" @on-change="handleChange" @on-validate="validateTabSwitch"
    >
      <!-- Tabs 1 -->
      <tab-content title="MATIERES" :before-change="beforeChange">
        <v-card  flat v-show="!loadingWizard">
                <matiere-form @formSubmitted="getMatiereForm" :type="type" @matiereFormValid="matiereFormValid" />
            </v-card>
      </tab-content>
      <!-- Tabs 2 -->
      <tab-content title="SALLES" :before-change="beforeChange">
        <v-card  flat v-show="!loadingWizard">
                <classe-form @formSubmitted="getClasseForm" :type="type" :niveaux="niveaux" @classeFormValid="classeFormValid" />
            </v-card>
      </tab-content>
      <!-- Tabs 3 -->
      <tab-content :title="tabTitle3" :before-change="beforeChange">
        <v-card  flat>
                <!-- Tabs de la Filiere pour toute les sections -->
                <v-card-text v-show="type == '3' && !loadingWizard">
                    <filieresup-form @formSubmitted="getFiliereForm" :type="type" @filiereSupFormValid="filiereSupFormValid" />
                </v-card-text>
                <!-- Tabs de la Filiere pour toute les sections -->

                <!-- Tabs de la Faculté pour toute les sections -->
                <v-card-text v-show ="type == '4' && !loadingWizard">
                    <faculte-form @formSubmitted="getFaculteForm" :type="type"  />
                </v-card-text>
                <!-- Tabs de la Faculté pour toute les sections -->

                <!-- Tabs de la Frais pour toute les sections -->
                <v-card-text v-show="type != '3' && type != '4' && !loadingWizard">
                    <frais-form @formSubmitted="getFraisForm" :type="type" :niveaux="niveaux" :filieres="formFiliere" @fraisFormValid="fraisFormValid"/>
                </v-card-text>
                <!-- Tabs de la Frais pour toute les sections -->
            </v-card>
      </tab-content>
      <!-- Tabs 4 -->
      <tab-content :title="tabTitle4" :before-change="beforeChange">
        <v-card  flat>
                <v-card-text v-show="type == '3' && !loadingWizard">
                    <frais-form @formSubmitted="getFraisForm" :type="type" :niveaux="niveaux" :filieres="formFiliere"  />
                </v-card-text>
                <v-card-text v-show ="type == '4' && !loadingWizard">
                    <filiere-form @formSubmitted="getFiliereForm" :type="type" :facultes="formFaculte.facultes" />
                </v-card-text>
                <v-card-text v-show="type != '3' && type != '4' && !loadingWizard">
                    <niveau-matiere-form @formSubmitted="getNiveauMatiereForm" :type="type" :niveaux="niveaux" :matieres="formMatiere.matieres" @niveauMatiereFormValid="niveauMatiereFormValid"/>
                </v-card-text>
            </v-card>
      </tab-content>
      <!-- Tabs 5 -->
      <tab-content :title="tabTitle5"  v-if="type=='3' || type=='4'" :before-change="beforeChange">
        <v-card  flat>
                <v-card-text v-show="type=='4' && !loadingWizard">
                    <frais-form @formSubmitted="getFraisForm" :type="type" :niveaux="niveaux" :filieres="formFiliere" />
                </v-card-text>
                <v-card-text v-show="type=='3' && lmd != null && !loadingWizard">
                    <ue-form @formSubmitted="getUEForm" :type="type" :niveaux="niveaux" />
                </v-card-text>
                <v-card-text v-show="type=='3'&& lmd == null && !loadingWizard">
                    <niveau-matiere-sans-ue-form @formSubmitted="getNiveauMatiereSansUeForm" :type="type" :niveaux="niveaux" :matieres="formMatiere.matieres" :filieres="formFiliere"/>
                </v-card-text>
            </v-card>
      </tab-content>
      <!-- Tabs 6 -->
      <tab-content :title="tabTitle6" v-if="(type=='3' || type=='4') && lmd != null" :before-change="beforeChange">
        <v-card >
                <v-card-text v-show="type=='4' && !loadingWizard">
                    <ue-form @formSubmitted="getUEForm" :type="type" :niveaux="niveaux" />
                </v-card-text>
                <v-card-text v-show="type=='3' && !loadingWizard">
                    <niveau-matiere-sup-form @formSubmitted="getNiveauMatiereSupForm " :type="type" :niveaux="niveaux" :matieres="formMatiere.matieres" :filieres="formFiliere" :ues="formUE.ues"/>
                </v-card-text>
            </v-card>
      </tab-content>
      <!-- Tabs 7 -->
      <tab-content title="AFFECTATION DE MATIERES AUX NIVEAUX" v-if="type=='4'" :before-change="beforeChange">
        <v-card  flat>
                <v-card-text v-show="lmd == null && !loadingWizard">
                    <niveau-matiere-sans-ue-form @formSubmitted="getNiveauMatiereSansUeForm" :type="type" :niveaux="niveaux" :matieres="formMatiere.matieres" :filieres="formFiliere"/>
                </v-card-text>
                <v-card-text v-show="lmd != null && !loadingWizard" >
                    <niveau-matiere-sup-form @formSubmitted="getNiveauMatiereSupForm" :type="type" :niveaux="niveaux" :matieres="formMatiere.matieres" :filieres="formFiliere" :ues="formUE.ues"/>
                </v-card-text>
            </v-card>
      </tab-content>
      <div class="loader" v-if="loadingWizard"></div>
    </form-wizard>
    <!-- Application de stepper -->
  </div>
    </AuthenticatedLayout>
  </template>
  <script>
    import {FormWizard, TabContent} from 'vue3-form-wizard'
    import 'vue3-form-wizard/dist/style.css'
    import MatiereForm from '@/components/admin/matiere.vue';
    import NiveauMatiereSansUeForm from '@/components/admin/niveau-matiere-sans-ue.vue';
    import NiveauMatiereSupForm from '@/components/admin/niveau-matiere-sup.vue';
    import NiveauMatiereForm from '@/components/admin/niveau-matiere.vue';
    import ClasseForm from '@/components/admin/classe.vue';
    import filiereForm from '@/components/admin/filiere.vue';
    import filieresupForm from '@/components/admin/filieresup.vue';
    import faculteForm from '@/components/admin/faculte.vue';
    import ueForm from '@/components/admin/ue.vue';
    import fraisForm from '@/components/admin/frais.vue';
    import { router,useForm} from '@inertiajs/vue3';
    import AuthenticatedLayout from "@/layouts/AuthenticatedLayout.vue";
    import Toolbar from "@/components/customizedComponents/Toolbar.vue";
    // import Datatable from "@/components/customizedComponents/datatable.vue";
    import Loader from "@/components/customizedComponents/Loader.vue";
    import { mdiAccount, mdiSchool, mdiHomeOutline, mdiInformation, mdiCloseCircle, mdiPlusCircle, mdiCogOutline,  mdiPresentation, mdiGift } from "@mdi/js";
  export default {
    props:['type','niveaux','lmd'],
    components: {
      FormWizard,
    TabContent,
    MatiereForm,
    ClasseForm,
    faculteForm,
    filieresupForm,
    filiereForm,
    ueForm,
    fraisForm,
    NiveauMatiereSansUeForm,
    NiveauMatiereSupForm ,
    NiveauMatiereForm,
    Loader,
    // Datatable,
    Toolbar,
    AuthenticatedLayout,
    mdiAccount,
    mdiCogOutline,
    mdiInformation,
    mdiSchool,
    mdiHomeOutline,
    mdiPlusCircle,
    mdiPresentation,
    mdiCloseCircle,
    mdiGift,
  },
    data: () => ({
        icons: {mdiAccount,mdiPlusCircle,mdiCloseCircle,mdiSchool,mdiInformation,mdiHomeOutline,mdiPresentation,mdiGift,mdiCogOutline},
        step: 1,
        tabTitle3: null,
        tabTitle4: null,
        tabTitle5: null,
        tabTitle6: null,
        formValid: false,
        currentTabIndex: 0,
        loadingWizard: false,
        items: [],
        suivant : false,
        pause: null,
        formMatiere: {},
        formClasse: {},
        formNiveauMatiereSansUe: {},
        NiveauMatiereSupForm :{},
        formNiveauMatiere: {},
        formFaculte: {},
        formFiliere:{},
        formFrais:{},
        formUE:{},
        form: useForm({
        matieres: [],
        }),
    }),
    created(){
      this.onChange()
    },
    methods: {
      // Envoi formulaire vers le backend

      sendForm() {
        // 1er cas
          if(type == '1' || type == '2'){

          }else if(type == '3' && lmd == null){

          }else if(type == '3' && lmd != null){

          }else if(type == '4' && lmd == null){

          }else if(type == '4' && lmd != null){

          }
        // 2e cas

          if(type == '1' || type == '2'){

          }else if(type == '3'){
            if(lmd == null){

            }else{

            }
          }else if(type == '4'){
            if(lmd == null){

            }else{

            }
          }
        },

        // fin envoi
      matiereFormValid(v){
        this.formValid = v
      },
      classeFormValid(v){
        this.formValid = v
      },
      fraisFormValid(v){
        this.formValid = v
      },
      niveauMatiereFormValid(v){
        this.formValid = v
      },
      filiereSupFormValid(v){
        this.formValid = v
      },
      async beforeChange() 
      {
        const isValid = await this.validateTabSwitch(); // Utilisation d'async/await
        if (isValid) {
          return true; // La validation réussit, permet le passage à l'onglet suivant
        } else {
          this.$swal.fire({
            title: "Echec de passage à l'étape suivante",
            text: "Merci de vérifier votre formulaire!",
            icon: "warning",
            confirmButtonText: "OK",
          });
          return false; 
        }
      },
      async validateTabSwitch(validationResult,activeTabIndex) {
        return new Promise((resolve) => {
          setTimeout(() => {
            const isValid = this.formValid; // Remplacez par votre propre logique de validation
            resolve(isValid);
          }, 500); // Délai de 2 secondes pour simuler une opération asynchrone
        });
      },
        handleLoading(loading) {
          this.loadingWizard = loading
        },
        handleValidate(validationResult,activeTabIndex) {
        },
        handleChange(prevIndex, nextIndex) {
        },
        getMatiereForm(donnees) {
          this.formMatiere = donnees
          console.log('Données du formulaire de la matiere :', this.formMatiere);
        },
        getClasseForm(donnees) {
          this.formClasse = donnees
          console.log('Données du formulaire de la classe :', this.formClasse);
        },
        getNiveauMatiereSansUeForm(donnees){
          this.formNiveauMatiereSansUe = donnees
          console.log('Données du formulaire niveau matiere sup :', this.formNiveauMatiereSansUe);

        },
        getNiveauMatiereSupForm (donnees){
          this.formNiveauMatiereSup = donnees
          console.log('Données du formulaire niveau matiere sup :', this.formNiveauMatiereSup);

        },

        getNiveauMatiereForm(donnees){
          this.formNiveauMatiere = donnees
          console.log('Données du formulaire niveau matiere :', this.formNiveauMatiere);

        },
        getFiliereForm(donnees) {
          this.formFiliere = donnees
          console.log('Données du formulaire de la filiere :', this.formFiliere);
        },

        getUEForm(donnees) {
          this.formUE = donnees
          console.log('Données du formulaire de l\'unité d\'enseignement :', this.formUE);
        },
        getFraisForm(donnees) {
          this.formFrais = donnees
          console.log('Données du formulaire de frais :', this.formFrais);
        },
        getFaculteForm(donnees) {
          this.formFaculte = donnees
          console.log('Données du formulaire de faculté :', this.formFaculte);
        },

        onChange(){
          if(this.type == '1' || this.type == '2'){
            this.tabTitle3 = 'FRAIS'
            this.tabTitle4 = 'AFFECTATION DE MATIERES AUX NIVEAUX'
          }else if(this.type == '3' && this.lmd == null){
            this.tabTitle3 = 'FILIERES'
            this.tabTitle4 = 'FRAIS'
            this.tabTitle5 = 'AFFECTATION DE MATIERES AUX NIVEAUX'
          }else if(this.type == '3' && this.lmd != null){
            this.tabTitle3 = 'FILIERES'
            this.tabTitle4 = 'FRAIS'
            this.tabTitle5 = 'UNITES D\'ENSEIGNEMENT'
            this.tabTitle6 = 'AFFECTATION DE MATIERES AUX NIVEAUX'
          }else if(this.type == '4' && this.lmd == null){
            this.tabTitle3 = 'FACULTES'
            this.tabTitle4 = 'FILIERES'
            this.tabTitle5 = 'FRAIS'
            this.tabTitle6 = 'AFFECTATION DE MATIERES AUX NIVEAUX'
            }else if(this.type == '4' && this.lmd != null){
              this.tabTitle3 = 'FACULTES'
              this.tabTitle4 = 'FILIERES'
              this.tabTitle5 = 'FRAIS'
              this.tabTitle6 = 'UNITES D\'ENSEIGNEMENT'
            }
      },
    },
    computed: {
        doneButtonOptions() {
        return this.currentTabIndex>=1
          ? {
              text: 'Enregistrer',
              icon: 'check',
              hideIcon: true, // default false but selected for sample
              hideText: false, // default false but selected for sample
              disabled: false,
            }
          : { disabled:true  };
      },
        backButtonOptions() {
        return this.currentTabIndex>=1
          ? {
              text: 'Retour',
              hideIcon: true, // default false but selected for sample
              hideText: false, // default false but selected for sample
              disabled: false,
            }
          : { disabled:true  };
      },
      nextButtonOptions() {
        return this.currentTabIndex>=0
          ? {
              text: 'Suivant',
              hideIcon: true, // default false but selected for sample
              hideText: false, // default false but selected for sample
              disabled: false,
            }
          : { disabled:true  };
      },
      Title () {
        switch (this.type) {
          case '1': return 'SECTION PRIMAIRE'
          case '2': return 'SECTION SECONDAIRE'
          case '3': return 'SECTION SUPERIEUR'
          default: return 'SECTION UNIVERSITAIRE'
        }
      },
    },
  }
</script>
<style scoped>
.form-wizard-vue .fw-body-list .fw-list-progress-active {
    background: #004980;
}

#fw-1695140104041 > ul > li:nth-child(1) > div.fw-list-progress.fw-list-progress-active{
    background: red;
}

/* This is a css loader. It's not related to vue-form-wizard */
.loader,
.loader:after {
  border-radius: 50%;
  width: 10em;
  height: 10em;
}
.loader {
  margin: 60px auto;
  font-size: 10px;
  position: relative;
  text-indent: -9999em;
  border-top: 1.1em solid rgba(255, 255, 255, 0.2);
  border-right: 1.1em solid rgba(255, 255, 255, 0.2);
  border-bottom: 1.1em solid rgba(255, 255, 255, 0.2);
  border-left: 1.1em solid #3c80e7;
  -webkit-transform: translateZ(0);
  -ms-transform: translateZ(0);
  transform: translateZ(0);
  -webkit-animation: load8 1.1s infinite linear;
  animation: load8 1.1s infinite linear;
}
@-webkit-keyframes load8 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes load8 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

</style>
