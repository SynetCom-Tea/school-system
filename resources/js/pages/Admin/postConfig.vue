<template>
  <v-card>
    <Toolbar
      styleToolbar="background-color: white;"
      :icon="icons.mdiSchool"
      :toolbarTitle="Title"
    ></Toolbar>

    <!-- <br> -->
    <v-card-text class="mx-auto">
        <v-row>
           
            
          <v-alert
            v-model="alertFirst"
            border="start"
            variant="tonal"
            color="primary"
            type="info"
            title="Mise à jour de données"
          >
            <li>
              Les menus sont classés par ordre de priorité et sont liés entre eux
            </li>
            <li>
              Vous trouverez des menus qui seront inactifs à cause de certains menus qui sont vides, alors on doit les renseignés pour qu'ils soient actifs
            </li>
          </v-alert>
        </v-row>
        <v-row>
          <v-col cols="auto" style="margin-left:18px;">
                <v-card :disabled="paramCheck" elevation="6" width="210" style="border-color: blue;" variant="outlined" rounded="shaped" @click="goto('param.index',type)">

                    <v-img style="object-fit: fill; width:210px; height:110px;" :src="'/assets/param.png'" class="text-white">

                    </v-img>
                    <p class="text-h6" style="text-align: center;">Parametres</p>

                </v-card>
            </v-col>

            <v-col cols="auto" style="margin-left:18px;">
                <v-card :disabled="salleCheck" elevation="6" width="210" style="border-color: blue;" variant="outlined" rounded="shaped" @click="go('salles.index')">

                    <v-img style="object-fit: fill; width:210px; height:110px;" :src="'/assets/salle.jpg'" class="text-white">

                    </v-img>
                    <p class="text-h6" style="text-align: center;">Gestion des salles</p>

                </v-card>

            </v-col>


            <v-col cols="auto" style="margin-left:18px;">
                <v-card :disabled="matiereCheck" elevation="6" width="210" style="border-color: blue;" variant="outlined" rounded="shaped" @click="goto('matieres.index',type)">

                    <v-img style="object-fit: fill; width:210px; height:110px;" :src="'/assets/books.png'" class="text-white">

                    </v-img>
                    <p class="text-h6" style="text-align: center;">Gestion des matières</p>

                </v-card>
            </v-col>



            <v-col cols="auto" v-if="type == '1' || type == '2'" style="margin-left:18px;">
                <v-card :disabled="classeCheck" elevation="6" width="210" style="border-color: blue;" variant="outlined" rounded="shaped" @click="goto('classes.index',type)">

                    <v-img style="object-fit: fill; width:210px; height:110px;" :src="'/assets/classe.png'" class="text-white">

                    </v-img>
                    <p class="text-h6" style="text-align: center;">Gestion des classes</p>

                </v-card>

            </v-col>

            <v-col cols="auto" style="margin-left:18px;">
                <v-card :disabled="fraisCheck" elevation="6" width="210" style="border-color: blue;" variant="outlined" rounded="shaped" @click="goto('frais.index', type)">

                    <v-img style="object-fit: fill; width:210px; height:110px;" :src="'/assets/argent.jpg'" class="text-white">

                    </v-img>
                    <p class="text-h6" style="text-align: center;">Gestion des frais</p>

                </v-card>

            </v-col>

            <v-col cols="auto" style="margin-left:18px;">
                <v-card :disabled="affecMatNivCheck" elevation="6" width="210" style="border-color: blue;" variant="outlined" rounded="shaped" @click="goto('affectations.index',type)">

                    <v-img style="object-fit: fill; width:210px; height:80px;" :src="'/assets/affectation.png'" class="text-white">

                    </v-img>
                    <p class="text-h6" style="text-align: center;">Affectation des matières aux niveaux</p>

                </v-card>

            </v-col>

            <v-col cols="auto" style="margin-left:18px;">
              <v-card :disabled="ensCheck"
                elevation="6"
                width="210"
                style="border-color: blue"
                variant="outlined"
                rounded="shaped"
                @click="goto('enseignants.index',type)"
              >
                <v-img
                  style="object-fit: fill; width: 210px; height: 80px"
                  :src="'/assets/enseignant.png'"
                  class="text-white"
                >
                </v-img>
                <p class="text-h6" style="text-align: center">Gestion des enseignants</p>
              </v-card>
            </v-col>


            <v-col cols="auto" style="margin-left:18px;">
          <v-card :disabled="affecEnsClaCheck"
            elevation="6"
            width="210"

            style="height: 100%; border-color: blue "
            variant="outlined"
            rounded="shaped"
            @click="goto('AffectationEnseignants.index',type)"
          >
            <v-img
              style="object-fit: fill; width: 210px; height: 60px"
              :src="'/assets/affectation.png'"
              class="text-white"
            >
            </v-img>
            <p class="text-h6" style="text-align: center">Affectation des enseignants aux classes</p>
          </v-card>
        </v-col>


        <!-- <v-col cols="auto" style="margin-left:18px;">
            <v-card elevation="6" width="210" style="border-color: blue;" variant="outlined" rounded="shaped" @click="goto('affectations.index',type)">

                <v-img style="object-fit: fill; width:210px; height:80px;" :src="'/assets/affectation.png'" class="text-white">

                </v-img>
                <p class="text-h6" style="text-align: center;">Affectation des matières aux niveaux</p>

            </v-card>

        </v-col> -->
        
          <v-col cols="auto" v-if="type == '4'" style="margin-left:18px;">
                <v-card elevation="6" width="210" style="border-color: blue;" variant="outlined" rounded="shaped" @click="go('facultes.index')">

                    <v-img style="object-fit: fill; width:210px; height:110px;" :src="'/assets/faculte.png'" class="text-white">

                    </v-img>
                    <p class="text-h6" style="text-align: center;">Gestion des facultés</p>

                </v-card>

            </v-col>
            <v-col cols="auto" v-if="type == '4'" style="margin-left:18px;">
                <v-card elevation="6" width="210" style="border-color: blue;" variant="outlined" rounded="shaped" @click="go('departements.index')">

                    <v-img style="object-fit: fill; width:210px; height:110px;" :src="'/assets/department.png'" class="text-white">

                    </v-img>
                    <p class="text-h6" style="text-align: center;">Gestion Départements</p>

                </v-card>

            </v-col>
            <v-col cols="auto" v-if="type == '4' || type == '3'" style="margin-left:18px;">
                <v-card elevation="6" width="210" style="border-color: blue;" variant="outlined" rounded="shaped" @click="goto('filieres.index',type)">

                    <v-img style="object-fit: fill; width:210px; height:110px;" :src="'/assets/filieres.jpg'" class="text-white">

                    </v-img>
                    <p class="text-h6" style="text-align: center;">Gestion des filières</p>

                </v-card>
            </v-col>
            <v-col cols="auto" v-if="type == '4' || type == '3'" style="margin-left:18px;">
                <v-card :disabled="affecMatNivCheck" elevation="6" width="210" style="border-color: blue;" variant="outlined" rounded="shaped" @click="goto('ues.index',type)">

                    <v-img style="object-fit: fill; width:210px; height:110px;" :src="'/assets/ue.png'" class="text-white">

                    </v-img>
                    <p class="text-h6" style="text-align: center;">Gestion des Ues</p>

                </v-card>

            </v-col>

            
          </v-row>

    </v-card-text>
  </v-card>
</template>

<script>
import { router, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
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
  layout: AuthenticatedLayout,
  props: ["type", "niveaux", "lmd","nbre_matieres","nbre_salles","nbre_classes","nbre_type_frais","nbre_enseignant","nbre_niveau_matiere"],
  components: {
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
    salleCheck: false,
    classeCheck: false,
    matiereCheck: false,
    paramCheck: false,
    fraisCheck: true,
    affecEnsClaCheck: true,
    affecMatNivCheck: true,
    ensCheck: true,
    
    ensCheck: true,
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

  created(){
    if(this.nbre_matieres != 0 && this.nbre_classes != 0){
      this.affecMatNivCheck = false
    }
    if(this.nbre_matieres != 0 && this.nbre_classes != 0 && this.nbre_enseignant != 0){
      this.affecEnsClaCheck = false
    }
    if(this.nbre_type_frais != 0){
      this.fraisCheck = false
    }
    if(this.nbre_niveau_matiere != 0 && this.nbre_classes != 0){
      this.ensCheck = false
    }
  },
  methods: {
    goBack() {
      router.get(route("etablissements.index"));
      console.log();
    },
    go(chemin){
      router.get(route(chemin));
    },
    goto(chemin,param){
      router.get(route(chemin,param));
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
