<template>
    <AuthenticatedLayout>
    <Toolbar
      styleToolbar="background-color: white;"
      :icon="icons.mdiAccount"
      :toolbarTitle="Title"
    ></Toolbar>
    <br>
    <v-card
    >
      <v-card-title class="text-h6 font-weight-regular justify-space-between">
        <span>{{ currentTitle }}</span>&nbsp;
        <v-avatar
          color="primary"
          size="24"
          v-text="step"
        ></v-avatar>
      </v-card-title>
  
      <v-window v-model="step">
        <v-window-item :value="1">
          <matiere-form @formSubmitted="handleFormSubmission" :type="type" />
        </v-window-item>
  
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
          variant="text"
          @click="step--"
        >
          Retour
        </v-btn>
        <v-spacer></v-spacer>
        <v-btn
          v-if="step < 3"
          color="primary"
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
    import { mdiAccount, mdiPurse, mdiHomeOutline, mdiCloseCircle, mdiPlusCircle, mdiCogOutline,  mdiPresentation, mdiGift } from "@mdi/js";
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
    mdiPurse,
    mdiHomeOutline,
    mdiPlusCircle,
    mdiPresentation,
    mdiCloseCircle,
    mdiGift,
  },
    data: () => ({
        icons: {mdiAccount,mdiPlusCircle,mdiCloseCircle,mdiPurse,mdiHomeOutline,mdiPresentation,mdiGift,mdiCogOutline},
        step: 1,
        form: useForm({
            matieres: [],
        }),
    }),
    
    methods: {
        handleFormSubmission(formData) {
          // Traitez les données du formulaire soumises par l'événement
          console.log('Données du formulaire soumises :', formData);
        },
        goBack() {
            router.get(route('etablissements.index'))
            console.log()
        },
        // addRow() {
        //     this.form.matieres.push({
        //         code: null,
        //         libelle: null,
        //         before: null,
        //         after: null
        //     })
        // },
        // removeRow(id) {
        //     this.form.matieres = this.form.matieres.filter((el) => el !== id)
        // },
        // async verify(element) {
        //     const array = this.form.matieres.filter(el => el.code !== null && el.code == element.code)

        //     if (array.length > 1) {
        //         this.removeRow(element)
        //         this.$alert.error("L'élément existe déjà !");
        //     }
        // },
    },
    // mounted() {
    //     this.addRow()
    // },
    computed: {
      Title () {
        switch (this.type) {
          case '1': return 'Section Primaire'
          case '2': return 'Section Sécondaire'
          default: return 'Section Supérieur'
        }
      },
      currentTitle () {
        switch (this.step) {
          case 1: return 'Sign-up'
          case 2: return 'Create a password'
          default: return 'Account created'
        }
      },
    },
  }
</script>