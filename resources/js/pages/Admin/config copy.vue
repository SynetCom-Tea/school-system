<template>
    <AuthenticatedLayout>
    <Toolbar
      styleToolbar="background-color: white;"
      :icon="icons.mdiSchool"
      :toolbarTitle="Title"
    ></Toolbar>
    <br>

    <!-- Application de stepper -->

    <v-stepper
        prev-text="Retour"
        next-text="Suivant"
        v-model="step"
        editable
        :items="getItems"
        alt-labels
    >
        <template v-slot:item.1>
            <v-card  flat>
                <matiere-form @formSubmitted="getMatiereForm" :type="type" />
            </v-card>
        </template>

        <template v-slot:item.2>

            <v-card  flat>
                <classe-form @formSubmitted="getClasseForm" :type="type" :niveaux="niveaux" />
            </v-card>
        </template>

        <template v-slot:item.3>
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
        </template>

        <template v-slot:item.4>
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
        </template>

        <template v-slot:item.5>
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
        </template>

        <template v-slot:item.6>
            <v-card >
                <v-card-text v-if="type=='4' && lmd != null">
                    <ue-form @formSubmitted="getUEForm" :type="type" :niveaux="niveaux" />
                </v-card-text>
                <v-card-text v-if="type=='4' && lmd == null">
                    <niveau-matiere-sans-ue-form @formSubmitted="getNiveauMatiereSansUeForm" :type="type" :niveaux="niveaux" :matieres="formMatiere.matieres" :filieres="formFiliere"/>
                </v-card-text>
                <v-card-text v-if="type=='3'">
                    <niveau-matiere-sup-form @formSubmitted="getNiveauMatiereSupForm " :type="type" :niveaux="niveaux" :matieres="formMatiere.matieres" :filieres="formFiliere" :ues="formUE.ues"/>
                </v-card-text>
            </v-card>
        </template>

        <template v-slot:item.7>
            <v-card  flat>
                <v-card-text>
                    <niveau-matiere-sup-form @formSubmitted="getNiveauMatiereSupForm" :type="type" :niveaux="niveaux" :matieres="formMatiere.matieres" :filieres="formFiliere" :ues="formUE.ues"/>
                </v-card-text>
            </v-card>
        </template>

    </v-stepper>

    <!-- Application de stepper -->

    </AuthenticatedLayout>
  </template>
  <script>
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

    methods: {
        // test(i){
        //     console.log('step',i)
        // },
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


        goBack() {
            router.get(route('etablissements.index'))
            console.log()
        },
    },

    mounted() {
      if(this.type == '3'){
        this.pause = 6
      }else if(this.type == '4'){
        this.pause = 7
      }else{
        this.pause = 4
      }
      // console.log('Admin etablissement',this.$page.props.admin_etablissement.etablissement_id)
    },
    computed: {
        getItems(){
            if(this.type == '1' || this.type == '2'){
                this.items = ['MATIERES','SALLES','FRAIS','AFFECTATION DE MATIERES AUX NIVEAUX']
            }else if(this.type == '3'){
                if(this.lmd!=null){
                    this.items = ['MATIERES','SALLES','FILIERES','FRAIS','UNITE D\'ENSEIGNEMENT','AFFECTATION DE MATIERES AUX NIVEAUX']
                }else{
                    this.items = ['MATIERES','SALLES','FILIERES','FRAIS','AFFECTATION DE MATIERES AUX NIVEAUX']
                }

            }else if(this.type == '4'){
                if(this.lmd!=null){
                    this.items = ['MATIERES','SALLES','FACULTES','FILIERES','FRAIS','UNITE D\'ENSEIGNEMENT','AFFECTATION DE MATIERES AUX NIVEAUX']
                }else{
                    this.items = ['MATIERES','SALLES','FACULTES','FILIERES','FRAIS','AFFECTATION DE MATIERES AUX NIVEAUX']
                }

            }
            return this.items
        },
      Title () {
        switch (this.type) {
          case '1': return 'SECTION PRIMAIRE'
          case '2': return 'SECTION SECONDAIRE'
          case '3': return 'SECTION SUPERIEUR'
          default: return 'SECTION UNIVERSITAIRE'
        }
      },
      currentTitle () {
        switch (this.step) {
          case 1: return 'MATIERES'
          case 2: return 'SALLES'
          case 3:if (this.type === '3') {
                    return 'FILIERES';
                }else if (this.type === '4') {
                    return 'FACULTES';
                }else{return 'FRAIS';}
          case 4:if (this.type === '3') {
                    return 'FRAIS';
                }else if (this.type === '4') {
                            return 'FILIERES';
                }else{return 'AFFECTATION DE MATIERES AUX NIVEAUX';}
          case 5:if (this.type === '4') {
                    return 'FRAIS';
                }else{
                    if(this.lmd!=null){
                        return 'UNITE D\'ENSEIGNEMENT';

                    }else{
                        return 'AFFECTATION DE MATIERES AUX NIVEAUX'
                    }


                    }
          case 6:if (this.type === '4') {
                    if(this.lmd!=null){
                        return 'UNITE D\'ENSEIGNEMENT';

                    }else{
                        return 'AFFECTATION DE MATIERES AUX NIVEAUX'
                    }

                }else{ return 'AFFECTATION DE MATIERES AUX NIVEAUX'}
          case 7: return 'AFFECTATION DE MATIERES AUX NIVEAUX'
        }
      },
    },
  }
</script>
