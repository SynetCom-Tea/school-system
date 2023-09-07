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
        
        <v-window-item :value="2">
          <v-card-text>
            <v-text-field
              label="Password"
              type="password"
            ></v-text-field>
            <v-text-field
              label="Confirm Password"
              type="password"
            ></v-text-field>
            <span class="text-caption text-grey-darken-1">
              Please enter a password for your account
            </span>
          </v-card-text>
        </v-window-item>
  
        <v-window-item :value="3">
          <div class="pa-4 text-center">
            <v-img
              class="mb-4"
              contain
              height="128"
              src="https://cdn.vuetifyjs.com/images/logos/v.svg"
            ></v-img>
            <h3 class="text-h6 font-weight-light mb-2">
              Welcome to Vuetify
            </h3>
            <span class="text-caption text-grey">Thanks for signing up!</span>
          </div>
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
          v-if="step < 3"
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
    import { router,useForm} from '@inertiajs/vue3';
    import AuthenticatedLayout from "@/layouts/AuthenticatedLayout.vue";
    import Toolbar from "@/components/customizedComponents/Toolbar.vue";
    import Datatable from "@/components/customizedComponents/datatable.vue";
    import Loader from "@/components/customizedComponents/Loader.vue";
    import { mdiAccount, mdiSchool, mdiHomeOutline, mdiInformation, mdiCloseCircle, mdiPlusCircle, mdiCogOutline,  mdiPresentation, mdiGift } from "@mdi/js";
  export default {
    props:['type'],
    components: {
    MatiereForm,
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
        formMatiere: {},
        form: useForm({
            matieres: [],
        }),
    }),
    
    methods: {
        getMatiereForm(donnees) {
          this.formMatiere = donnees
          // Traitez les données du formulaire soumises par l'événement
          console.log('Données du formulaire soumises :', this.formMatiere);
        },
        goBack() {
            router.get(route('etablissements.index'))
            console.log()
        },
    },
    mounted() {
      // console.log('Admin etablissement',this.$page.props.admin_etablissement.etablissement_id)
    },
    computed: {
      Title () {
        switch (this.type) {
          case '1': return 'SECTION PRIMAIRE'
          case '2': return 'SECTION SECONDAIRE'
          default: return 'SECTION SUPERIEUR'
        }
      },
      currentTitle () {
        switch (this.step) {
          case 1: return 'MATIERES'
          case 2: return 'Create a password'
          default: return 'Account created'
        }
      },
    },
  }
</script>