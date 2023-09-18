<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

import { mdiPencil, mdiContentSave, mdiPlus, mdiLock } from "@mdi/js";
import { useToast } from "vue-toastification";
const toast = useToast();
import TextField from "@/Components/TextField.vue";
import { router, useForm } from "@inertiajs/vue3";
export default {
  components: {
    mdiPencil,
    TextField,

    mdiPlus,
    mdiLock,
  },
  layout: AuthenticatedLayout,
  props: ["etudiant"],
  data() {
    return {
      icons: {
        mdiPencil,
        mdiContentSave,
        mdiPlus,
        mdiLock,
      },
      form: this.$inertia.form({
        nom: this.$page.props.user.nom,
        prenom: this.$page.props.user.prenom,
        telephone: this.$page.props.user.telephone,
        sex: this.$page.props.user.sex,
        email: this.$page.props.user.email,
        date_naiss: this.etudiant.date_naiss,
        lieu_naiss: this.etudiant.lieu_naiss,
        nationalite: this.etudiant.nationalite,
        localite: this.etudiant.localite,
        profession_pere: this.etudiant.profession_pere,
        profession_mere: this.etudiant.profession_mere,
        adress1: this.etudiant.adress1,
        adress2: this.etudiant.adress2,
        photo: this.etudiant.photo,
      }),
      editBio: false,
    };
  },
  methods: {
    saveBio() {
      this.editBio = true;
    },
    onChange(image) {
      console.log("New picture selected!");
      if (image) {
        console.log("Picture loaded.");
        this.image = image;
      } else {
        console.log("FileReader API not supported: use the <form>, Luke!");
      }
    },
    ajouter() {
      router.get(route("profile.create"));
    },
    save() {
      this.editBio = false;
      this.form.patch(route("profile.update"), {
        preverseScroll: true,
        onSuccess: () => {
          toast.success("Votre compte a été mis à jour avec succes");
        },
      });
    },
    change() {
      router.get(route("password"));
    },
  },
};
</script>
<template>
  <div id="app" class="d-flex justify-center">
    <v-app>
      <v-main>
        <v-container fluid>
          <v-card max-width="1500px" class="mx-auto" elevation="2">
            <v-img
              class=""
              height="200px"
              src="/logo.png"
              gradient="150deg, rgb(185 224 255 / 58%) 0%, rgb(243 220 246 / 52%) 35%, rgb(223 255 242 / 74%) 74%"
            >
            </v-img>
            <v-row justify="center">
              <v-col
                align-self="start"
                class="d-flex justify-center align-center pa-0"
                cols="12"
              >
                <v-avatar
                  class="profile avatar-center-heigth avatar-shadow"
                  color="grey"
                  size="164"
                >
                  <v-btn class="upload-btn" x-large icon> </v-btn>
                  <v-img v-if="form.photo" :src="'/images/' + form.photo"></v-img>
                  <v-img v-if="!form.photo" src="/avatar6.png"></v-img>
                </v-avatar>
              </v-col>
              <div class="hello">
                <!-- <picture-input  width="100" height="100"  accept="image/jpeg,image/png" @change="onChange">
                            </picture-input> -->
              </div>
            </v-row>

            <v-card-subtitle
              v-if="!editBio"
              color="#0000"
              class="profile-text-name ma-4 pt-16 mt-10"
            >
              <div class="container">
                <div class="separator"></div>
                <v-btn
                  class="my-button"
                  style="border-top-left-radius: 100%"
                  @click="saveBio"
                >
                  Modifié <v-icon :icon="icons.mdiPencil"></v-icon>
                </v-btn>
                &nbsp;
                <v-btn class="my-button" @click="ajouter">
                  <v-icon :icon="icons.mdiPlus"></v-icon> Ajouter
                </v-btn>
                &nbsp;
                <v-btn @click="change" class="my-button" color="orange">
                  <v-icon :icon="icons.mdiLock"></v-icon>Changer mon mot de passe
                </v-btn>
              </div>
            </v-card-subtitle>
            <v-card-subtitle
              v-if="editBio"
              color="#0000"
              class="profile-text-name ma-4 pt-16 mt-10"
            >
              <div class="container">
                <div class="separator"></div>
                <v-btn
                  class="my-button"
                  style="border-top-left-radius: 100%"
                  @click="save"
                >
                  Enregistrer <v-icon :icon="icons.mdiContentSave"></v-icon>
                </v-btn>
              </div>
            </v-card-subtitle>
            <v-row>
              <v-col cols="12" md="6">
                <v-text-field
                  :disabled="!editBio"
                  rows="2"
                  variant="outlined"
                  label="Nom "
                  v-model="form.nom"
                  class="profile-text-name ma-4"
                ></v-text-field>
                <v-text-field
                  :disabled="!editBio"
                  rows="2"
                  variant="outlined"
                  label="Prénom"
                  v-model="form.prenom"
                  class="profile-text-name ma-4"
                ></v-text-field>
                <v-text-field
                  :disabled="!editBio"
                  rows="2"
                  variant="outlined"
                  label="Date de naissance"
                  v-model="form.date_naiss"
                  class="profile-text-name ma-4"
                ></v-text-field>
                <v-text-field
                  :disabled="!editBio"
                  rows="2"
                  variant="outlined"
                  label="Nationalité"
                  v-model="form.nationalite"
                  class="profile-text-name ma-4"
                ></v-text-field>
                <v-text-field
                  :disabled="!editBio"
                  rows="2"
                  variant="outlined"
                  label="Profession de pére"
                  v-model="form.profession_pere"
                  class="profile-text-name ma-4"
                ></v-text-field>
                <v-text-field
                  :disabled="!editBio"
                  rows="2"
                  variant="outlined"
                  label="Adresse 1"
                  v-model="form.adress1"
                  class="profile-text-name ma-4"
                ></v-text-field>
                <v-text-field
                  :disabled="!editBio"
                  rows="2"
                  variant="outlined"
                  label="Localité"
                  v-model="form.localite"
                  class="profile-text-name ma-4"
                ></v-text-field>
              </v-col>
              <v-col>
                <v-text-field
                  :disabled="!editBio"
                  rows="2"
                  variant="outlined"
                  label="telephone"
                  v-model="form.telephone"
                  class="profile-text-name ma-4"
                ></v-text-field>
                <v-text-field
                  :disabled="!editBio"
                  rows="2"
                  variant="outlined"
                  label="Email"
                  v-model="form.email"
                  class="profile-text-name ma-4"
                ></v-text-field>
                <v-text-field
                  :disabled="!editBio"
                  rows="2"
                  variant="outlined"
                  label="sexe"
                  v-model="form.sex"
                  class="profile-text-name ma-4"
                ></v-text-field>
                <v-text-field
                  :disabled="!editBio"
                  rows="2"
                  variant="outlined"
                  label="Lieu de naissance"
                  v-model="form.lieu_naiss"
                  class="profile-text-name ma-4"
                ></v-text-field>
                <v-text-field
                  :disabled="!editBio"
                  rows="2"
                  variant="outlined"
                  label="Profession de la mére"
                  v-model="form.profession_mere"
                  class="profile-text-name ma-4"
                ></v-text-field>
                <v-text-field
                  :disabled="!editBio"
                  rows="2"
                  variant="outlined"
                  label="Adresse 2"
                  v-model="form.adress2"
                  class="profile-text-name ma-4"
                ></v-text-field>
                <!-- <text-field name="mail" label="Email address" placeholder="Entrer votre Numero attestation" ></text-field> -->
              </v-col>
            </v-row>
          </v-card>
        </v-container>
      </v-main>
    </v-app>
  </div>
</template>

<style>
.avatar-center-heigth {
  position: absolute;
}

.profile-text-name {
  margin-top: 70px;
}

.sutitles {
  margin: 5px;
  padding: 16px;
}

.upload-btn {
  position: absolute !important;
  z-index: 999;
  top: 121px;
  color: cadetblue;
  background: blueviolet;
  background: rgb(125, 198, 163);
  background: linear-gradient(
    50deg,
    rgba(125, 198, 163, 1) 0%,
    rgba(35, 216, 227, 1) 72%
  );
}

.avatar-shadow {
  box-shadow: 0px 0px 10px 0px rgba(50, 12, 112, 0.75);
  -webkit-box-shadow: 0px 0px 10px 0px rgba(50, 12, 112, 0.75);
  -moz-box-shadow: 0px 0px 10px 0px rgba(50, 12, 112, 0.75);
}

.container {
  position: relative;
  /* Permet de positionner la ligne par rapport au conteneur */
}

.separator {
  position: absolute;
  /* Position absolue pour superposer la ligne sur le bouton */
  top: 50%;
  /* Positionne la ligne verticalement au milieu */
  right: 100%;
  left: 0;
  /* Positionne la ligne à gauche du conteneur */
  width: 100%;
  /* La ligne s'étend sur toute la largeur */
  height: 1px;
  /* Hauteur de la ligne */
  background-color: #4dc770;
  /* Couleur de la ligne de séparation */
  transform: translateY(-50%);
  /* Centre la ligne verticalement */
  z-index: 1;
  /* Place la ligne au-dessus du bouton */
}

.my-button {
  /* Styles pour le bouton */
  /* Vous pouvez personnaliser les styles du bouton selon vos besoins */
  padding: 8px 16px;
  background-color: #4dc770;
  color: #000;
  border: none;
  z-index: 2;
  /* Place le bouton au-dessus de la ligne */
}
</style>
