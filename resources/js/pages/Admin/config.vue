<template>
    <AuthenticatedLayout>
    <Toolbar
      styleToolbar="background-color: white;"
      :icon="icons.mdiSchool"
      :toolbarTitle="Title"
    ></Toolbar>
    <br>
    <v-card
    >
      <v-card-title class="text-h6 font-weight-regular justify-space-between">
        <v-icon
          color="primary"
          size="35"
          :icon="icons.mdiSchool"
        ></v-icon>
        &nbsp;
        <span>{{ currentTitle }}</span>&nbsp;
      </v-card-title>

      <v-window v-model="step">
        <!-- Tabs de la Matieres pour toute les sections -->
        <v-window-item :value="1">
          <matiere-form @formSubmitted="getMatiereForm" :type="type" />
        </v-window-item>
        <!-- Tabs de la Matieres pour toute les sections -->

        <!-- Tabs de la Classes pour toute les sections -->
        <v-window-item :value="2">
          <classe-form @formSubmitted="getClasseForm" :type="type" :niveaux="niveaux" />
        </v-window-item>
        <!-- Tabs de la Classes pour toute les sections -->


        <v-window-item :value="3">
          <!-- Tabs de la Filiere pour toute les sections -->
          <v-card-text v-if="type == '3'">
            <filiere-form @formSubmitted="getFiliereForm" :type="type"  />
          </v-card-text>
          <!-- Tabs de la Filiere pour toute les sections -->

           <!-- Tabs de la Faculté pour toute les sections -->
           <v-card-text v-else-if ="type == '4'">
            <faculte-form @formSubmitted="getFaculteForm" :type="type"  />
          </v-card-text>
          <!-- Tabs de la Faculté pour toute les sections -->

          <!-- Tabs de la Frais pour toute les sections -->
          <v-card-text v-else>
            <frais-form @formSubmitted="getFraisForm" :type="type" :niveaux="niveaux" />
          </v-card-text>
          <!-- Tabs de la Frais pour toute les sections -->
        </v-window-item>



        <v-window-item :value="4">
          <v-card-text v-if="type == '3'">
            <frais-form @formSubmitted="getFraisForm" :type="type" :niveaux="niveaux"  />
          </v-card-text>
          <v-card-text v-else-if ="type == '4'">
            <filiere-form @formSubmitted="getFiliereForm" :type="type"  />
          </v-card-text>
          <v-card-text v-else>
            <niveau-matiere-form @formSubmitted="getNiveauMatiereForm" :type="type" :niveaux="niveaux" :matieres="matieres"/>
          </v-card-text>
        </v-window-item>

        <v-window-item :value="5" >
          <v-card-text>
            <frais-form @formSubmitted="getFraisForm" :type="type" />
          </v-card-text>
        </v-window-item>

        <v-window-item :value="6" >
          <v-card-text v-if="type=='4'">
            <frais-form @formSubmitted="getFraisForm" :type="type" />
          </v-card-text>
          <v-card-text v-if="type=='3'">
            <niveau-matiere-form @formSubmitted="getNiveauMatiereForm" :type="type" :niveaux="niveaux" :matieres="matieres"/>
          </v-card-text>
        </v-window-item>

        <v-window-item :value="7">
          <v-card-text>
            <niveau-matiere-form @formSubmitted="getNiveauMatiereForm" :type="type" :niveaux="niveaux" :matieres="matieres"/>
          </v-card-text>
        </v-window-item>
      </v-window>

      <v-divider></v-divider>

      <v-card-actions>
        <v-btn
          v-if="step > 1"
          variant="flat"
          color="info"
          @click="step--"
        >
        Retour
          <!-- <v-icon :icon="icons.mdiCloseCircle"></v-icon> -->
        </v-btn>
        <v-spacer></v-spacer>
        <v-btn
          v-if="step < pause"
          color="info"
          variant="flat"
          @click="step++"
        >
          Suivant
        </v-btn>
      </v-card-actions>
    </v-card>
    </AuthenticatedLayout>
  </template>
  <script>
    import MatiereForm from '@/components/admin/matiere.vue';
    import NiveauMatiereForm from '@/components/admin/niveau-matiere.vue';
    import ClasseForm from '@/components/admin/classe.vue';
    import filiereForm from '@/components/admin/filiere.vue';
    import faculteForm from '@/components/admin/faculte.vue';
    import fraisForm from '@/components/admin/frais.vue';
    import { router,useForm} from '@inertiajs/vue3';
    import AuthenticatedLayout from "@/layouts/AuthenticatedLayout.vue";
    import Toolbar from "@/components/customizedComponents/Toolbar.vue";
    import Datatable from "@/components/customizedComponents/datatable.vue";
    import Loader from "@/components/customizedComponents/Loader.vue";
    import { mdiAccount, mdiSchool, mdiHomeOutline, mdiInformation, mdiCloseCircle, mdiPlusCircle, mdiCogOutline,  mdiPresentation, mdiGift } from "@mdi/js";
  export default {
    props:['type','niveaux','matieres'],
    components: {
    MatiereForm,
    ClasseForm,
    faculteForm,
    filiereForm,
    fraisForm,
    NiveauMatiereForm,
    Loader,
    Datatable,
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
        pause: null,
        formMatiere: {},
        formClasse: {},
        formNiveauMatiere: {},
        formFaculte: {},
        formFiliere:{},
        formFrais:{},
        form: useForm({
        matieres: [],
        }),
    }),

    methods: {
        getMatiereForm(donnees) {
          this.formMatiere = donnees
          // Traitez les données du formulaire soumises par l'événement
          console.log('Données du formulaire de la matiere :', this.formMatiere);
        },
        getClasseForm(donnees) {
          this.formClasse = donnees
          // Traitez les données du formulaire soumises par l'événement
          console.log('Données du formulaire de la classe :', this.formClasse);
        },
        getNiveauMatiereForm(donnees){
          this.formNiveauMatiere = donnees
          console.log('Données du formulaire de la classe :', this.formNiveauMatiere);

        },
        getFiliereForm(donnees) {
          this.formFiliere = donnees
          // Traitez les données du formulaire soumises par l'événement
          console.log('Données du formulaire de la filiere :', this.formFiliere);
        },
        getFraisForm(donnees) {
          this.formFrais = donnees
          // Traitez les données du formulaire soumises par l'événement
          console.log('Données du formulaire de frais :', this.formFrais);
        },
        getFaculteForm(donnees) {
          this.formFaculte = donnees
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
                    return 'Filiere';
                }else if (this.type === '4') {
                    return 'Faculté';
                }else{return 'Frais';}
          case 4:if (this.type === '3') {
                    return 'Frais';
                }else if (this.type === '4') {
                            return 'Filiere';
                }else{return 'Affectation de la matiere par niveau';}
          case 5:if (this.type === '4') {
                    return 'Frais';
                }else{ return 'Unités d\enseignements'}
          case 6:if (this.type === '4') {
                    return 'Unités d\enseignements';
                }else{ return 'Affectation de la matiere par niveau'}
          case 7: return 'Affectation de la matiere par niveau'
        }
      },
    },
  }
</script>
