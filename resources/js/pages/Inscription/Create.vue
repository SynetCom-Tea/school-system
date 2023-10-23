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
        step-size="sm"
        back-button-text="Retour"
        next-button-text="Suivant"
        finish-button-text="Enregistrer"
        @on-complete="sendForm"
        @on-loading="handleLoading"
        @on-error="handleError"
        @on-change="handleChange"
        @on-validate="validateTabSwitch"
      >
        <!-- Tabs 1 -->

        <tab-content :title="tabTitle1" :before-change="beforeChange">
          <v-card flat v-show="apprenant == null && !loadingWizard">
            <apprenant-form
              @formSubmitted="getApprenantForm"
              :type="type"
              :apprenant="apprenant"
              @apprenantFormValid="apprenantFormValid"
            />
          </v-card>
          <v-card flat v-show="apprenant != null && !loadingWizard">
            <annee-form
              @formSubmitted="getAnneeForm"
              :type="type"
              :cycles="cycles"
              :cycleFilieres="cycleFilieres"
              :niveaux="niveaux"
              :apprenant="apprenant"
              :annees="annees"
              @anneeFormValid="anneeFormValid"
            />
          </v-card>
        </tab-content>
        <!-- Tabs 2 -->
        <tab-content :title="tabTitle2" :before-change="beforeChange">
          <v-card flat v-show="apprenant == null && !loadingWizard">
            <annee-form
              @formSubmitted="getAnneeForm"
              :type="type"
              :cycles="cycles"
              :cycleFilieres="cycleFilieres"
              :niveaux="niveaux"
              :formapprenant="formApprenant"
              :annees="annees"
              @anneeFormValid="anneeFormValid"
            />
          </v-card>
          <v-card flat v-show="apprenant != null && !loadingWizard">
            <tuteur-form
              @formSubmitted="getTuteurForm"
              :type="type"
              :tuteurShow="0"
              :niveaux="niveaux"
              :tuteurs="tuteurs"
              @tuteurFormValid="tuteurFormValid"
            />
          </v-card>
        </tab-content>

        <!-- Tabs 3 -->
        <tab-content :title="tabTitle3" :before-change="beforeChange" v-if="apprenant == null">
          <v-card flat v-show="!loadingWizard">
            <tuteur-form
              @formSubmitted="getTuteurForm"
              :type="type"
              :tuteurShow="1"
              :niveaux="niveaux"
              :tuteurs="tuteurs"
              @tuteurFormValid="tuteurFormValid"
            />
          </v-card>
          <!-- <v-card flat v-show="apprenant != null && !loadingWizard">
            <document-form
              @formSubmitted="getDocumentForm"
              :type="type"
              :niveaux="niveaux"
              :typeDocuments="typeDocuments"
              @documentFormValid="documentFormValid"
            />
          </v-card> -->
        </tab-content>

         <!-- Tabs 4 -->
         <tab-content :title="tabTitle4" v-if="apprenant == null" :before-change="beforeChange">
          <v-card flat v-show="!loadingWizard">
            <document-form
              @formSubmitted="getDocumentForm"
              :type="type"
              :niveaux="niveaux"
              :typeDocuments="typeDocuments"
              @documentFormValid="documentFormValid"
            />
          </v-card>
        </tab-content>

        <!-- Tabs 3 -->
        <!-- <tab-content :title="tabTitle3" :before-change="beforeChange">
          <v-card flat> -->
            <!-- Tabs de la Filiere pour toute les sections -->
            <!-- <v-card-text v-show="type == '3' && !loadingWizard">
              <filieresup-form
                @formSubmitted="getFiliereForm"
                :type="type"
                @filiereSupFormValid="filiereSupFormValid"
              />
            </v-card-text> -->
            <!-- Tabs de la Filiere pour toute les sections -->

            <!-- Tabs de la Faculté pour toute les sections -->
            <!-- <v-card-text v-show="type == '4' && !loadingWizard">
              <faculte-form
                @formSubmitted="getFaculteForm"
                :type="type"
                @faculteFormValid="faculteFormValid"
              />
            </v-card-text> -->
            <!-- Tabs de la Faculté pour toute les sections -->

            <!-- Tabs de la Frais pour toute les sections -->

            <!-- <v-card-text v-show="type != '3' && type != '4' && !loadingWizard">
              <frais-form
                @formSubmitted="getFraisForm"
                :type="type"
                :niveaux="niveaux"
                :filieres="formFiliere"
                :typeFrais="typeFrais"
                @fraisFormValid="fraisFormValid"
              />
            </v-card-text> -->

            <!-- Tabs de la Frais pour toute les sections -->
          <!-- </v-card>
        </tab-content> -->
        <div class="loader" v-if="loadingWizard"></div>
      </form-wizard>
      <!-- Application de stepper -->
    </div>
  </AuthenticatedLayout>
</template>
<script>
import { FormWizard, TabContent } from "vue3-form-wizard"; 
import "vue3-form-wizard/dist/style.css";
import ApprenantForm from "@/components/inscriptions/apprenant.vue";
import AnneeForm from "@/components/inscriptions/annee.vue";
import TuteurForm from "@/components/inscriptions/tuteur.vue";
import DocumentForm from "@/components/inscriptions/document.vue";
import { router, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/layouts/AuthenticatedLayout.vue";
import Toolbar from "@/components/customizedComponents/Toolbar.vue";
// import Datatable from "@/components/customizedComponents/datatable.vue";
import Loader from "@/components/customizedComponents/Loader.vue";
import {
  mdiAccount,
  mdiSchool,
  mdiHomeOutline,
  mdiInformation,
  mdiCloseCircle,
  mdiPlusCircle,
  mdiCogOutline,
  mdiPresentation,
  mdiGift,
} from "@mdi/js";
export default {
  props: ["type", "niveaux", "typeFrais","apprenant","annees","typeDocuments","tuteurs","cycleFilieres","cycles"],
  components: {
    FormWizard,
    TabContent,
    ApprenantForm,
    AnneeForm,
    TuteurForm,
    DocumentForm,
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
    previousIndex: 0,
    nextIndex: 0,
    icons: {
      mdiAccount,
      mdiPlusCircle,
      mdiCloseCircle,
      mdiSchool,
      mdiInformation,
      mdiHomeOutline,
      mdiPresentation,
      mdiGift,
      mdiCogOutline,
    },
    step: 1,
    tabTitle1: null,
    tabTitle3: null,
    tabTitle4: null,
    tabTitle5: null,
    tabTitle6: null,
    formValid: false,
    currentTabIndex: 0,
    loadingWizard: false,
    items: [],
    suivant: false,
    pause: null,
    formApprenant: {},
    formAnnee: {},
    formTuteur: {},
    formDocument: {},
    form: useForm({
      apprenants: [],
      annees: [],
      tuteurs: [],
      documents: [],
      section: null,
      
    }),
  }),
  created() {
    this.onChange();
  },
  mounted() {},
  methods: {
    // Envoi formulaire vers le backend

    sendForm() {
      this.form.apprenants = this.formApprenant;
      this.form.annees = this.formAnnee;
      this.form.tuteurs = this.formTuteur;
      this.form.documents = this.formDocument;
      this.form.section = this.type;
      this.$swal({
        icon: "warning",
        title: "Confirmation",
        text: "Êtes-vous sûr de bien vouloir sauvegarder?",
        confirmButtonText:'Oui, sauvegarder!',
        cancelButtonText:'Annuler',
        showCancelButton: true,
        showConfirmButton: true
      }).then((result) => {
        if(result.isConfirmed){
          this.form.post(route("inscriptions.store"), {
          onFinish: () => {
            if(this.$page.props.flash?.message?.type == 'error'){
            this.$swal({
              icon: "error",
              title: "Echec de sauvegarde",
              text: this.$page.props.flash?.message?.text,
              toast: true,
              position: "top-end",
              showConfirmButton: false,
              timer: 10000,
              timerProgressBar: true,
            })
          }else if(this.$page.props.flash?.message?.type == 'success'){
            this.$swal({
              text: "La sauvegarde à été effectuée avec succès! voulez-vous être rédiriger vers la liste?",
              confirmButtonText:'Oui, allons-y!',
              cancelButtonText:'Non, restons!',
              showCancelButton: true,
              showConfirmButton: true,
              icon: "success",
              title: "Réussie",
            }).then((result) => {
              if(result.isConfirmed){
                router.get(route('inscriptions.index',{section_id: JSON.stringify(this.type)}))
              }
            })
          }
          },
        });
        }
      })
        
      },

    // fin envoi

    // Validation des formulaires
    apprenantFormValid(v) {
      this.formValid = v;
    },
    anneeFormValid(v) {
      this.formValid = v;
    },
    tuteurFormValid(v) {
      this.formValid = v;
    },
    documentFormValid(v) {
      this.formValid = v;
    },
    // Validation des formulaires

    // Recuperation de données des formulaires
    getApprenantForm(donnees) {
      this.formApprenant = donnees;
    },
    getAnneeForm(donnees) {
      this.formAnnee = donnees;
    },
    getTuteurForm(donnees) {
      this.formTuteur = donnees;
    },
    getDocumentForm(donnees) {
      this.formDocument = donnees;
    },
    
    // Fin recuperation des formulaires

    // fUNCTION DE FORM WIZARD
    async beforeChange() {
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
    async validateTabSwitch(validationResult, activeTabIndex) {
      return new Promise((resolve) => {
        setTimeout(() => {
          const isValid = this.formValid; // Remplacez par votre propre logique de validation
          resolve(isValid);
        }, 500); // Délai de 2 secondes pour simuler une opération asynchrone
      });
    },
    handleLoading(loading) {
      this.loadingWizard = loading;
    },
    handleValidate(validationResult, activeTabIndex) {},
    handleChange(prevIndex, nextIndex) {
      this.previousIndex = prevIndex;
      this.nextIndex = nextIndex;
    },
    // FIN fUNCTION DE FORM WIZARD
    handleError() {},
    // Function pour le titre du stepper
    onChange() {
      if (this.apprenant == null) {
        this.tabTitle1 = "INFORMATIONS SUR L'ELEVE";
        this.tabTitle2 = "ANNEE ACADEMIQUE";
        this.tabTitle3 = "TUTEURS";
        this.tabTitle4 = "DOCUMENTS";
      } else {
        this.tabTitle1 = "ANNEE ACADEMIQUE";
        this.tabTitle2 = "TUTEURS";
      }
    },
    // Fin function pour le titre du stepper
  },
  computed: {
    doneButtonOptions() {
      return this.currentTabIndex >= 1
        ? {
            text: "Enregistrer",
            icon: "check",
            hideIcon: true, // default false but selected for sample
            hideText: false, // default false but selected for sample
            disabled: false,
          }
        : { disabled: true };
    },
    backButtonOptions() {
      return this.currentTabIndex >= 1
        ? {
            text: "Retour",
            hideIcon: true, // default false but selected for sample
            hideText: false, // default false but selected for sample
            disabled: false,
          }
        : { disabled: true };
    },
    nextButtonOptions() {
      return this.currentTabIndex >= 0
        ? {
            text: "Suivant",
            hideIcon: true, // default false but selected for sample
            hideText: false, // default false but selected for sample
            disabled: false,
          }
        : { disabled: true };
    },
    Title() {
      console.log(this.type);
      switch (this.type) {
        case 1:
          return "SECTION PRIMAIRE";
        case 2:
          return "SECTION SECONDAIRE";
        case 3:
          return "SECTION SUPERIEURE";
        case 4:
          return "SECTION UNIVERSITAIRE";
      }
    },
  },
};
</script>
<style scoped>
.form-wizard-vue .fw-body-list .fw-list-progress-active {
  background: #004980;
}

#fw-1695140104041 > ul > li:nth-child(1) > div.fw-list-progress.fw-list-progress-active {
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
