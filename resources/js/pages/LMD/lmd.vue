<template>
  <AuthenticatedLayout>
    <Toolbar
      styleToolbar="background-color: white;"
      :icon="icons.mdiSchool"
      :toolbarTitle="Title"
    ></Toolbar>
    <br />
    <v-card class="mx-auto" variant="outlined" style="border: 2px solid #7d002c">
      <v-card-title style="color: white; background-color: #7d002c"
        >Configuration du système LMD</v-card-title
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
          title="Information"
        >
          <li>
            Cette section vous permet de configurer si votre établissement utilise le
            système LMD ou pas, si OUI choisir le type du système
          </li>
          <!-- <li>Le formulaire sera valide si est seulement si tous les champs obligatoires marqués par <span style="color: red;">*</span> sont renseignés</li> -->
        </v-alert>

        <div v-if="!alertFirst" style="margin: auto; width: 50%; padding: 10px">
          <Button
            style="height: 30px"
            type="button"
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
      <!-- <v-card class="mx-auto" max-width="1000"> -->
      <v-form v-model="valid">
        <v-card-text>
          <v-row>
            <v-col>
              <v-switch
                label="Souhaiterez-vous appliquez le système LMD ?"
                v-model="form.lmd"
                @change="test()"
                color="primary"
                inset
              ></v-switch>
            </v-col>
            <v-row v-if="form.lmd">
            <v-col cols="4" md="4">
              <Autocomplete
              class="mt-1"
                :items="lmds"
                item-title="libelle"
                item-value="id"
                v-model="form.type_lmd"
                @update:modelValue="test()"
                chips
                closable-chips
                isRequired
                color="blue-grey-lighten-2"
                label="Select"
              ></Autocomplete>
            </v-col>
            <v-col cols="4" md="4">
              <Autocomplete
              class="mt-1"
                :items="regime_val"
                item-title="libelle"
                item-value="id"
                label="Modalité de passage"
                placeholder="Modalité de passage"
                v-model="form.regime_validation"
                @update:modelValue="test()"
                chips
                closable-chips
                isRequired
                color="blue-grey-lighten-2"
              ></Autocomplete>
            </v-col>

            <v-col cols="3" md="3" v-if="form.regime_validation==2">
                <TextField
              class="mt-1"
              label="Nombre de crédit"
              placeholder="Nombre de crédit"
              v-model="form.nbre_credit"
              @update:modelValue="test()"
              isRequired
              :rules="[(v) => !!v || 'Ce champ est requis!']"
            ></TextField>

            </v-col>
            </v-row>
            <v-col v-if="!form.lmd">
              <v-switch
                label="Le systeme de devoir continu"
                v-model="form.devoir_continu"
                color="indigo"
                inset
              ></v-switch>
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-actions>
          <Button
            title="retourner à la page precédante"
            nameButton="Retour"
            variant="flat"
            @click="goBack"
            density="comfortable"
            class="text-center"
            :isBlock="true"
            size="large"
            style="text-transform: none"
          >
          </Button>
          <v-spacer></v-spacer>
          <Button
            v-if="form.lmd"
            :disabled="check"
            title="retourner à la page precédante"
            nameButton="Approuver"
            variant="flat"
            @click="submit"
            density="comfortable"
            class="text-center"
            :isBlock="true"
            size="large"
            style="text-transform: none"
          >
          </Button>
          <Button
            v-else
            title="Ignorer"
            nameButton="Ignorer"
            variant="flat"
            @click="submit"
            density="comfortable"
            class="text-center"
            :isBlock="true"
            size="large"
            style="text-transform: none"
          >
          </Button>
        </v-card-actions>
      </v-form>
    </v-card>
  </AuthenticatedLayout>
</template>
<script>
import { router, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
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
  props: ["type", "lmds","regime_val"],
  components: {
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
    alertFirst: true,
    alertSecond: true,
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
    valid: false,
    check: false,
    form: useForm({
      lmd: false,
      type_lmd: null,
      devoir_continu: false,
      regime_validation:null,
      nbre_credit:null,
      type: null,
    }),
  }),
  methods: {
    onclickAlertButton(type) {
      if (type == "second") {
        this.alertSecond = true;
      }
      if (type == "first") {
        this.alertFirst = true;
      }
    },
    test() {

        // console.log(this.regime_val);
      if (this.form.lmd == true && this.form.type_lmd !== null) {
        this.check = false;
      } else if (this.form.lmd == false) {
        this.check = false;
      } else {
        this.check = true;
        this.form.devoir_continu=false;
      }
    },
    //  submit(){
    //     this.form.type = this.type
    //     this.form.post(route('lmd.store'))

    // },
    submit() {
      this.form.type = this.type;
      this.form.post(route("systemelmd.store"), {});
    },

    goBack() {
      router.get(route("dashboard"));
    },
  },

  mounted() {
    // console.log('Admin etablissement',this.$page.props.admin_etablissement.etablissement_id)
  },
  computed: {
    Title() {
      switch (this.type) {
        case "1":
          return "SECTION PRIMAIRE";
        case "2":
          return "SECTION SECONDAIRE";
        case "3":
          return "SECTION SUPERIEUR";
        default:
          return "SECTION UNIVERSITAIRE";
      }
    },
    //   currentTitle () {
    //     switch (this.step) {
    //       case 1: return 'MATIERES'
    //       case 2: return 'SALLES'
    //       case 3:if (this.type === '3') {
    //                 return 'FILIERES';
    //             }else if (this.type === '4') {
    //                 return 'FACULTES';
    //             }else{return 'FRAIS';}
    //       case 4:if (this.type === '3') {
    //                 return 'FRAIS';
    //             }else if (this.type === '4') {
    //                         return 'FILIERES';
    //             }else{return 'AFFECTATION DE MATIERES AUX NIVEAUX';}
    //       case 5:if (this.type === '4') {
    //                 return 'FRAIS';
    //             }else{ return 'UNITE D\'ENSEIGNEMENT'}
    //       case 6:if (this.type === '4') {
    //                 return 'UNITE D\'ENSEIGNEMENT';
    //             }else{ return 'AFFECTATION DE MATIERES AUX NIVEAUX'}
    //       case 7: return 'AFFECTATION DE MATIERES AUX NIVEAUX'
    //     }
    //   },
  },
}
</script>
