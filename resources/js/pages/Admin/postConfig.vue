<template>
  <AuthenticatedLayout>
    <Toolbar
      styleToolbar="background-color: white;"
      :icon="icons.mdiSchool"
      :toolbarTitle="Title"
    ></Toolbar>

    <!-- <br> -->
    <v-container>
      <v-row>
        <v-alert
          v-model="alert"
          border="start"
          variant="tonal"
          color="primary"
          title="Mise à jour des données"
        >
        </v-alert>
      </v-row>
      <v-row v-if="type == '1'">
        <v-col cols="3">
          <v-card
            elevation="6"
            width="210"
            style="border-color: blue"
            variant="outlined"
            rounded="shaped"
            @click="getClasses"
          >
            <v-img
              style="object-fit: fill; width: 210px; height: 110px"
              :src="'/assets/classe.png'"
              class="text-white"
            >
            </v-img>
            <p class="text-h6" style="text-align: center">Gestion des classes</p>
          </v-card>
        </v-col>
        <v-col cols="3">
          <v-card
            elevation="6"
            width="210"
            style="border-color: blue"
            variant="outlined"
            rounded="shaped"
            @click="getMatieres"
          >
            <v-img
              style="object-fit: fill; width: 210px; height: 110px"
              :src="'/assets/books.png'"
              class="text-white"
            >
            </v-img>
            <p class="text-h6" style="text-align: center">Gestion des matières</p>
          </v-card>
        </v-col>

        <v-col cols="3">
          <v-card
            elevation="6"
            width="210"
            style="border-color: blue"
            variant="outlined"
            rounded="shaped"
            @click="getAffectations"
          >
            <v-img
              style="object-fit: fill; width: 210px; height: 80px"
              :src="'/assets/affectation.png'"
              class="text-white"
            >
            </v-img>
            <p class="text-h6" style="text-align: center">
              Affectation des matières aux niveaux
            </p>
          </v-card>
        </v-col>

        <v-col cols="3">
          <v-card
            elevation="6"
            width="210"
            style="border-color: blue"
            variant="outlined"
            rounded="shaped"
            @click="getFrais"
          >
            <v-img
              style="object-fit: fill; width: 210px; height: 110px"
              :src="'/assets/argent.jpg'"
              class="text-white"
            >
            </v-img>
            <p class="text-h6" style="text-align: center">Gestion des frais</p>
          </v-card>
        </v-col>
        <v-col cols="3">
          <v-card
            elevation="6"
            width="210"
            style="border-color: blue"
            variant="outlined"
            rounded="shaped"
            @click="getEnseignants"
          >
            <v-img
              style="object-fit: fill; width: 210px; height: 110px"
              :src="'/assets/filieres.jpg'"
              class="text-white"
            >
            </v-img>
            <p class="text-h6" style="text-align: center">Gestion des Enseignants</p>
          </v-card>
        </v-col>
        <v-col cols="3">
          <v-card
            elevation="6"
            width="210"
            style="border-color: blue"
            variant="outlined"
            rounded="shaped"
            @click="getAffectationEnseignants"
          >
            <v-img
              style="object-fit: fill; width: 210px; height: 110px"
              :src="'/assets/filieres.jpg'"
              class="text-white"
            >
            </v-img>
            <p class="text-h6" style="text-align: center">Affectations des enseignants aux classes</p>
          </v-card>
        </v-col>
      </v-row>
      <v-row v-if="type == '2'">
        <v-col cols="3">
          <v-card
            elevation="6"
            width="210"
            style="border-color: blue"
            variant="outlined"
            rounded="shaped"
            @click="getClasses"
          >
            <v-img
              style="object-fit: fill; width: 210px; height: 110px"
              :src="'/assets/classe.png'"
              class="text-white"
            >
            </v-img>
            <p class="text-h6" style="text-align: center">Gestion des classes</p>
          </v-card>
        </v-col>
        <v-col cols="3">
          <v-card
            elevation="6"
            width="210"
            style="border-color: blue"
            variant="outlined"
            rounded="shaped"
            @click="getMatieres"
          >
            <v-img
              style="object-fit: fill; width: 210px; height: 110px"
              :src="'/assets/books.png'"
              class="text-white"
            >
            </v-img>
            <p class="text-h6" style="text-align: center">Gestion des matières</p>
          </v-card>
        </v-col>
        <v-col cols="3">
          <v-card
            elevation="6"
            width="210"
            style="border-color: blue"
            variant="outlined"
            rounded="shaped"
            @click="getAffectations"
          >
            <v-img
              style="object-fit: fill; width: 210px; height: 80px"
              :src="'/assets/affectation.png'"
              class="text-white"
            >
            </v-img>
            <p class="text-h6" style="text-align: center">
              Affectation des matières aux niveaux
            </p>
          </v-card>
        </v-col>

        <v-col cols="3">
          <v-card
            elevation="6"
            width="210"
            style="border-color: blue"
            variant="outlined"
            rounded="shaped"
            @click="getFrais"
          >
            <v-img
              style="object-fit: fill; width: 210px; height: 110px"
              :src="'/assets/argent.jpg'"
              class="text-white"
            >
            </v-img>
            <p class="text-h6" style="text-align: center">Gestion des frais</p>
          </v-card>
        </v-col>
       
        <v-col cols="3">
          <v-card
            elevation="6"
            width="210"
            style="border-color: blue"
            variant="outlined"
            rounded="shaped"
            @click="getAffectationEnseignants"
          >
            <v-img
              style="object-fit: fill; width: 210px; height: 110px"
              :src="'/assets/filieres.jpg'"
              class="text-white"
            >
            </v-img>
            <p class="text-h6" style="text-align: center">Affectations des enseignants aux classes</p>
          </v-card>
        </v-col>
      </v-row>
      <v-row v-if="type == '3'">
        <v-col cols="3">
          <v-card
            elevation="6"
            width="210"
            style="border-color: blue"
            variant="outlined"
            rounded="shaped"
            @click="getFilieres"
          >
            <v-img
              style="object-fit: fill; width: 210px; height: 110px"
              :src="'/assets/filieres.jpg'"
              class="text-white"
            >
            </v-img>
            <p class="text-h6" style="text-align: center">Gestion des filières</p>
          </v-card>
        </v-col>
        <v-col cols="3">
          <v-card
            elevation="6"
            width="210"
            style="border-color: blue"
            variant="outlined"
            rounded="shaped"
            @click="getSalles"
          >
            <v-img
              style="object-fit: fill; width: 210px; height: 110px"
              :src="'/assets/classe.png'"
              class="text-white"
            >
            </v-img>
            <p class="text-h6" style="text-align: center">Gestion des salles</p>
          </v-card>
        </v-col>
        <v-col cols="3">
          <v-card
            elevation="6"
            width="210"
            style="border-color: blue"
            variant="outlined"
            rounded="shaped"
            @click="getMatieres"
          >
            <v-img
              style="object-fit: fill; width: 210px; height: 110px"
              :src="'/assets/books.png'"
              class="text-white"
            >
            </v-img>
            <p class="text-h6" style="text-align: center">Gestion des matières</p>
          </v-card>
        </v-col>

        <v-col cols="3">
          <v-card
            elevation="6"
            width="210"
            style="border-color: blue"
            variant="outlined"
            rounded="shaped"
            @click="getClasses"
          >
            <v-img
              style="object-fit: fill; width: 210px; height: 80px"
              :src="'/assets/affectation.png'"
              class="text-white"
            >
            </v-img>
            <p class="text-h6" style="text-align: center">
              Affectation des matières aux niveaux
            </p>
          </v-card>
        </v-col>
        <v-col cols="3">
          <v-card
            elevation="6"
            width="210"
            style="border-color: blue"
            variant="outlined"
            rounded="shaped"
            @click="getClasses"
          >
            <v-img
              style="object-fit: fill; width: 210px; height: 110px"
              :src="'/assets/argent.jpg'"
              class="text-white"
            >
            </v-img>
            <p class="text-h6" style="text-align: center">Gestion des frais</p>
          </v-card>
        </v-col>

        <v-col cols="3">
          <v-card
            elevation="6"
            width="210"
            style="border-color: blue"
            variant="outlined"
            rounded="shaped"
            @click="getAffectationEnseignants"
          >
            <v-img
              style="object-fit: fill; width: 210px; height: 110px"
              :src="'/assets/filieres.jpg'"
              class="text-white"
            >
            </v-img>
            <p class="text-h6" style="text-align: center">Affectations des enseignants aux classes</p>
          </v-card>
        </v-col>
      </v-row>
      <v-row v-if="type == '4'">
        <v-col cols="3">
          <v-card
            elevation="6"
            width="210"
            style="border-color: blue"
            variant="outlined"
            rounded="shaped"
            @click="getFacultes"
          >
            <v-img
              style="object-fit: fill; width: 210px; height: 110px"
              :src="'/assets/faculte.png'"
              class="text-white"
            >
            </v-img>
            <p class="text-h6" style="text-align: center">Gestion des facultés</p>
          </v-card>
        </v-col>
        <v-col cols="3">
          <v-card
            elevation="6"
            width="210"
            style="border-color: blue"
            variant="outlined"
            rounded="shaped"
            @click="getDepartements"
          >
            <v-img
              style="object-fit: fill; width: 210px; height: 110px"
              :src="'/assets/department.png'"
              class="text-white"
            >
            </v-img>
            <p class="text-h6" style="text-align: center">Gestion Départements</p>
          </v-card>
        </v-col>

        <v-col cols="3">
          <v-card
            elevation="6"
            width="210"
            style="border-color: blue"
            variant="outlined"
            rounded="shaped"
            @click="getFilieres"
          >
            <v-img
              style="object-fit: fill; width: 210px; height: 110px"
              :src="'/assets/filieres.jpg'"
              class="text-white"
            >
            </v-img>
            <p class="text-h6" style="text-align: center">Gestion des filières</p>
          </v-card>
        </v-col>
        <v-col cols="3">
          <v-card
            elevation="6"
            width="210"
            style="border-color: blue"
            variant="outlined"
            rounded="shaped"
            @click="getSalles"
          >
            <v-img
              style="object-fit: fill; width: 210px; height: 110px"
              :src="'/assets/classe.png'"
              class="text-white"
            >
            </v-img>
            <p class="text-h6" style="text-align: center">Gestion des salles</p>
          </v-card>
        </v-col>
      </v-row>
      <v-row v-if="type == '4'">
        <v-col cols="3">
          <v-card
            elevation="6"
            width="210"
            style="border-color: blue"
            variant="outlined"
            rounded="shaped"
            @click="getClasses"
          >
            <v-img
              style="object-fit: fill; width: 210px; height: 110px"
              :src="'/assets/ue.png'"
              class="text-white"
            >
            </v-img>
            <p class="text-h6" style="text-align: center">Gestion des Ues</p>
          </v-card>
        </v-col>
        <v-col cols="3">
          <v-card
            elevation="6"
            width="210"
            style="border-color: blue"
            variant="outlined"
            rounded="shaped"
            @click="getMatieres"
          >
            <v-img
              style="object-fit: fill; width: 210px; height: 110px"
              :src="'/assets/books.png'"
              class="text-white"
            >
            </v-img>
            <p class="text-h6" style="text-align: center">Gestion des matières</p>
          </v-card>
        </v-col>

        <v-col cols="3">
          <v-card
            elevation="6"
            width="210"
            style="border-color: blue"
            variant="outlined"
            rounded="shaped"
            @click="getClasses"
          >
            <v-img
              style="object-fit: fill; width: 210px; height: 80px"
              :src="'/assets/affectation.png'"
              class="text-white"
            >
            </v-img>
            <p class="text-h6" style="text-align: center">
              Affectation des matières aux niveaux
            </p>
          </v-card>
        </v-col>

        <v-col cols="3">
          <v-card
            elevation="6"
            width="210"
            style="border-color: blue"
            variant="outlined"
            rounded="shaped"
            @click="getClasses"
          >
            <v-img
              style="object-fit: fill; width: 210px; height: 110px"
              :src="'/assets/argent.jpg'"
              class="text-white"
            >
            </v-img>
            <p class="text-h6" style="text-align: center">Gestion des frais</p>
          </v-card>
        </v-col>

        <v-col cols="3">
          <v-card
            elevation="6"
            width="210"
            style="border-color: blue"
            variant="outlined"
            rounded="shaped"
            @click="getAffectationEnseignants"
          >
            <v-img
              style="object-fit: fill; width: 210px; height: 110px"
              :src="'/assets/filieres.jpg'"
              class="text-white"
            >
            </v-img>
            <p class="text-h6" style="text-align: center">Affectations des enseignants aux classes</p>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </AuthenticatedLayout>
</template>

<script>
import { router, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Toolbar from "@/components/customizedComponents/Toolbar.vue";
import {
  mdiGoogleClassroom,
  mdiBookOpenVariant,
  mdiAccount,
  mdiCheckCircle,
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
  props: ["type", "niveaux", "lmd"],
  components: {
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
    mdiCheckCircle,
    mdiBookOpenVariant,
    mdiGoogleClassroom,
  },
  data: () => ({
    alert: true,
    icons: {
      mdiGoogleClassroom,
      mdiBookOpenVariant,
      mdiAccount,
      mdiPlusCircle,
      mdiCheckCircle,
      mdiCloseCircle,
      mdiSchool,
      mdiInformation,
      mdiHomeOutline,
      mdiPresentation,
      mdiGift,
      mdiCogOutline,
    },

    form: useForm({
      matieres: [],
    }),
  }),

  methods: {
    goBack() {
      router.get(route("etablissements.index"));
      console.log();
    },
    getMatieres() {
      router.get(route("matieres.index", this.type));
    },
    getAffectations() {
      router.get(route("affectations.index", this.type));
    },
    getClasses() {
      router.get(route("classes.index", this.type));
    },
    getSalles() {
      router.get(route("salles.index"));
    },
    getFrais() {
      router.get(route("frais.index", this.type));
    },
    getFacultes() {
      router.get(route("facultes.index"));
    },
    getDepartements() {
      router.get(route("departements.index"));
    },
    getFilieres() {
      router.get(route("filieres.index", this.type));
    },
    getEnseignants() {
      router.get(route("enseignants.index", this.type));
    },

    getAffectationEnseignants() {
      router.get(route("AffectationEnseignants.index", this.type));
    },

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
  },
};
</script>

<style scoped></style>
