<template>
    <AuthenticatedLayout>
    <Toolbar
      styleToolbar="background-color: white;"
      :icon="icons.mdiSchool"
      :toolbarTitle="Title"
    ></Toolbar>
    <!-- <br> -->

    <!-- Application de stepper -->
    <form-wizard 
      color="#094899" 
      back-button-text="Retour"
      next-button-text="Suivant"
      finish-button-text="Enregistrer"
      @on-complete="submit"
      @on-loading="onLoading"
    >
      <!-- Tabs 1 -->
      <tab-content title="MATIERES" :before-change="beforeChange">
        <v-card  flat>
                <matiere-form @formSubmitted="getMatiereForm" :type="type" />
            </v-card>
      </tab-content>
      <!-- Tabs 2 -->
      <tab-content title="SALLES" :before-change="beforeChange">
        <v-card  flat>
                <classe-form @formSubmitted="getClasseForm" :type="type" :niveaux="niveaux" />
            </v-card>
      </tab-content>
      <!-- Tabs 3 -->
      <tab-content :title="tabTitle3" :before-change="beforeChange">
        <v-card  flat>
                <!-- Tabs de la Filiere pour toute les sections -->
                <v-card-text v-if="type == '3'">
                    <filieresup-form @formSubmitted="getFiliereForm" :type="type"  />
                </v-card-text>
                <!-- Tabs de la Filiere pour toute les sections -->

                <!-- Tabs de la Faculté pour toute les sections -->
                <v-card-text v-else-if ="type == '4'">
                    <faculte-form @formSubmitted="getFaculteForm" :type="type"  />
                </v-card-text>
                <!-- Tabs de la Faculté pour toute les sections -->

                <!-- Tabs de la Frais pour toute les sections -->
                <v-card-text v-else>
                    <frais-form @formSubmitted="getFraisForm" :type="type" :niveaux="niveaux" :filieres="formFiliere"/>
                </v-card-text>
                <!-- Tabs de la Frais pour toute les sections -->
            </v-card>
      </tab-content>
      <!-- Tabs 4 -->
      <tab-content :title="tabTitle4" :before-change="beforeChange">
        <v-card  flat>
                <v-card-text v-if="type == '3'">
                    <frais-form @formSubmitted="getFraisForm" :type="type" :niveaux="niveaux" :filieres="formFiliere"  />
                </v-card-text>
                <v-card-text v-else-if ="type == '4'">
                    <filiere-form @formSubmitted="getFiliereForm" :type="type" :facultes="formFaculte.facultes"  />
                </v-card-text>
                <v-card-text v-else>
                    <niveau-matiere-form @formSubmitted="getNiveauMatiereForm" :type="type" :niveaux="niveaux" :matieres="formMatiere.matieres"/>
                </v-card-text>
            </v-card>
      </tab-content>
      <!-- Tabs 5 -->
      <tab-content :title="tabTitle5"  v-if="type=='3' || type=='4'" :before-change="beforeChange">
        <v-card  flat>
                <v-card-text v-if="type=='4'">
                    <frais-form @formSubmitted="getFraisForm" :type="type" :niveaux="niveaux" :filieres="formFiliere" />
                </v-card-text>
                <v-card-text v-if="type=='3' && lmd != null">
                    <ue-form @formSubmitted="getUEForm" :type="type" :niveaux="niveaux" />
                </v-card-text>
                <v-card-text v-if="type=='3'&& lmd == null">
                    <niveau-matiere-sans-ue-form @formSubmitted="getNiveauMatiereSansUeForm" :type="type" :niveaux="niveaux" :matieres="formMatiere.matieres" :filieres="formFiliere"/>
                </v-card-text>
            </v-card>
      </tab-content>
      <!-- Tabs 6 -->
      <tab-content :title="tabTitle6 ? tabTitle6 : ''" v-if="(type=='3' || type=='4') && lmd != null" :before-change="beforeChange">
        <v-card >
                <v-card-text v-if="type=='4'">
                    <ue-form @formSubmitted="getUEForm" :type="type" :niveaux="niveaux" />
                </v-card-text>
                <v-card-text v-if="type=='3'">
                    <niveau-matiere-sup-form @formSubmitted="getNiveauMatiereSupForm " :type="type" :niveaux="niveaux" :matieres="formMatiere.matieres" :filieres="formFiliere" :ues="formUE.ues"/>
                </v-card-text>
            </v-card>
      </tab-content>
      <!-- Tabs 7 -->
      <tab-content title="AFFECTATION DE MATIERES AUX NIVEAUX" v-if="type=='4'">
        <v-card  flat>
                <v-card-text v-if="lmd == null">
                    <niveau-matiere-sans-ue-form @formSubmitted="getNiveauMatiereSansUeForm" :type="type" :niveaux="niveaux" :matieres="formMatiere.matieres" :filieres="formFiliere"/>
                </v-card-text>
                <v-card-text v-if="lmd != null" >
                    <niveau-matiere-sup-form @formSubmitted="getNiveauMatiereSupForm" :type="type" :niveaux="niveaux" :matieres="formMatiere.matieres" :filieres="formFiliere" :ues="formUE.ues"/>
                </v-card-text>
            </v-card>
      </tab-content>
    </form-wizard>
    <!-- Application de stepper -->

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
    name: "CallFunctionBeforeTabSwitch",
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
        currentTabIndex: 0,
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
      onLoading(){

      },
      async beforeChange(){
        const v = 1
        if(v == 0){
          this.onLoading(true)
          return false
        }else{
          this.onLoading(false)
          return true
        }
      
      },
      submit() {
        console.log('submitted',this.formMatiere ? this.formMatiere.matieres.length : 0);

      },
        btnsuivant(){
          this.suivant = false
        },
        getMatiereForm(donnees) {
          this.formMatiere = donnees
          this.suivant = true
          // Traitez les données du formulaire soumises par l'événement
          console.log('Données du formulaire de la matiere :', this.formMatiere);
        },
        getClasseForm(donnees) {
          this.formClasse = donnees
          this.suivant = true
          // Traitez les données du formulaire soumises par l'événement
          console.log('Données du formulaire de la classe :', this.formClasse);
        },
        getNiveauMatiereSansUeForm(donnees){
          this.formNiveauMatiereSansUe = donnees
          this.suivant = true
          console.log('Données du formulaire niveau matiere sup :', this.formNiveauMatiereSansUe);

        },
        getNiveauMatiereSupForm (donnees){
          this.formNiveauMatiereSup = donnees
          this.suivant = true
          console.log('Données du formulaire niveau matiere sup :', this.formNiveauMatiereSup);

        },

        getNiveauMatiereForm(donnees){
          this.formNiveauMatiere = donnees
          this.suivant = true
          console.log('Données du formulaire niveau matiere :', this.formNiveauMatiere);

        },
        getFiliereForm(donnees) {
          this.formFiliere = donnees
          this.suivant = true
          // Traitez les données du formulaire soumises par l'événement
          console.log('Données du formulaire de la filiere :', this.formFiliere);
        },

        getUEForm(donnees) {
          this.formUE = donnees
          this.suivant = true
          // Traitez les données du formulaire soumises par l'événement
          console.log('Données du formulaire de l\'unité d\'enseignement :', this.formUE);
        },
        getFraisForm(donnees) {
          this.formFrais = donnees
          this.suivant = true
          // Traitez les données du formulaire soumises par l'événement
          console.log('Données du formulaire de frais :', this.formFrais);
        },
        getFaculteForm(donnees) {
          this.formFaculte = donnees
          this.suivant = true
          // Traitez les données du formulaire soumises par l'événement
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
</style>
