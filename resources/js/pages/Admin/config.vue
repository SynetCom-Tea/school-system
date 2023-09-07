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
          <!-- <v-card-text>
            <v-row>
              <v-alert text="Cette section vous permet de configurer" type="info"></v-alert>
            </v-row>
            <v-row  v-if="type == '3'">
              <v-col>
                <v-switch label="Souhaiterez-vous appliquez le système LMD ?" color="primary" inset></v-switch>
              </v-col>
              <v-col>
                <v-autocomplete
                  :items="['Type 1', 'Type 2']"
                  chips
                  closable-chips
                  color="blue-grey-lighten-2"

                  label="Select"

                ></v-autocomplete>
              </v-col>
              <v-col>
                <v-switch label="Souhaiterez-vous appliquez le régime d'évaluation ?" color="indigo" inset></v-switch>
              </v-col>
              <v-col>
                <v-text-field
                  label="Pourcentage"
                  type="number"
                  placeholder="%"
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col>
                <v-switch label="Souhaiterez-vous importez le fichier des matieres ?" color="info" inset></v-switch>
              </v-col>
            </v-row>
          </v-card-text> -->
          <matiere-form @formSubmitted="handleFormSubmission" :type="type" />
        </v-window-item>

        <v-window-item :value="2">

          <v-card-text v-if="type == '3'">
            <filiere-form @formSubmitted="handleFormSubmission" :type="type" />
          </v-card-text>
          <v-card-text v-if="type !== '3'">
            <frais-form @formSubmitted="handleFormSubmission" :type="type" />
          </v-card-text>
        </v-window-item>



        <v-window-item :value="3">
          <v-card-text v-if="type == '3'">
            <frais-form @formSubmitted="handleFormSubmission" :type="type" />
          </v-card-text>
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
          v-if="step < 4"
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
    import filiereForm from '@/components/admin/filiere.vue';
    import fraisForm from '@/components/admin/frais.vue';
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
    filiereForm,
    fraisForm,
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
    //     console.log('admin_etablissement',this.$page.props.admin_etablissement.admin_etablissement);
    //     // this.addRow()
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
          case 2:if (this.type === '3') {
                    return 'Filiere';
                }else{return 'Frais';}
          default: return 'Account created'
        }
      },
    },
  }
</script>
