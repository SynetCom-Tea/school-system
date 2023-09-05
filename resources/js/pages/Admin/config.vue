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
          <v-card-text>
            <v-row>
              <v-alert text="Cette section vous permet de configurer" type="info"></v-alert>
            </v-row>
            <v-row>
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
          </v-card-text>
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
          Back
        </v-btn>
        <v-spacer></v-spacer>
        <v-btn
          v-if="step < 3"
          color="primary"
          variant="flat"
          @click="step++"
        >
          Next
        </v-btn>
      </v-card-actions>
    </v-card>
    </AuthenticatedLayout>
  </template>
  <script>
    import AuthenticatedLayout from "@/layouts/AuthenticatedLayout.vue";
    import Toolbar from "@/components/customizedComponents/Toolbar.vue";
    import Datatable from "@/components/customizedComponents/datatable.vue";
    import Loader from "@/components/customizedComponents/Loader.vue";
    import { mdiAccount, mdiPurse, mdiHomeOutline, mdiCogOutline,  mdiPresentation, mdiGift } from "@mdi/js";
  export default {
    props:['type'],
    components: {
    Loader,
    Datatable,
    Toolbar,
    AuthenticatedLayout,
    mdiAccount,
    mdiCogOutline,
    mdiPurse,
    mdiHomeOutline,
    mdiPresentation,
    mdiGift,
  },
    data: () => ({
        icons: [mdiAccount,mdiPurse,mdiHomeOutline,mdiPresentation,mdiGift,mdiCogOutline],
        step: 1,
    }),

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