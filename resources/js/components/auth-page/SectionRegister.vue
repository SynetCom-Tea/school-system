<template>
  <div>
    <v-row>
      <v-col cols="6" md="6">
        <div style="text-align: center; padding: 80px 0">
          <div><img src="team.png" class="team-img pt-1" /></div>
          <v-card-text class="white--text">
            <h3 class="text-center">Déjà enregistré(e)?</h3>
            <br />
            <h6 class="text-center">
              Connectez-vous à votre compte pour pouvoir continuer à créer et modifier
              votre flux d'intégration
            </h6>
          </v-card-text>
          <div class="text-center">
            <Button
              title="Clicquer pour retourner à la page login"
              nameButton="Se Connecter"
              density="comfortable"
              class="text-center"
              variant="flat"
              size="large"
              :onClickButton="goToPreviousWindow"
              style="text-transform: none"
            >
            </Button>
            <br />
            <br />
            <v-divider></v-divider>
            <br />
            <Button
              title="Clicquer pour retourner à la page welcome"
              nameButton="Visiter le site web"
              variant="flat"
              density="comfortable"
              class="text-center"
              color="secondary"
              size="large"
              :prependIcon="icons.mdiKeyboardBackspace"
              :onClickButton="goToWelcome"
              style="text-transform: none"
            >
            </Button>
          </div>
        </div>
      </v-col>

      <v-col cols="6" md="6">
        <v-card-text class="mt-2">
          <v-row align="center" justify="center">
            <v-col cols="12" sm="8" class="login">
              <h2 class="text-center">Créer un compte</h2>
              <v-form>
                <TextField
                  label="Nom"
                  outlined
                  :isRequired="true"
                  v-model="form.lastname"
                  class="mt-5"
                  :errorMessageValue="form.errors.lastname"
                />
                <TextField
                  label="Prénom"
                  v-model="form.firstname"
                  outlined
                  :isRequired="true"
                />
                <TextField
                  label="Identifiant"
                  outlined
                  :isRequired="true"
                  v-model="form.email"
                  dense
                  :errorMessageValue="form.errors.email"
                />
                <TextField
                  label="Mot de passe"
                  v-model="form.password"
                  outlined
                  dense
                  :isRequired="true"
                  autocomplete="false"
                  type="password"
                />
                 <!-- :onClickButton="goToRegister()" -->
                <Button
                  title="Valider"
                  variant="flat"
                  nameButton="S'enregistrer"

                  density="comfortable"
                  class="text-center"
                  :isBlock="true"
                  size="large"
                  style="text-transform: none"
                >
                </Button>
              </v-form>

              <v-row>
                <v-col cols="12" sm="7">
                  <v-checkbox
                    label="J'accepte les conditions"
                    class="mt-2"
                    color="primary"
                  >
                  </v-checkbox>
                </v-col>
              </v-row>
              <h6 class="text-center">
                <hr class="hr-text" data-content="Ou S'enregistrer avec" />
              </h6>

              <div class="d-flex justify-space-between align-center mx-2 mt-2">
                <div v-for="item in listSocialNetworks">
                  <Button
                    @click="goToSocialNetworksUrl(item.link)"
                    :title="item.title"
                    color="grey"
                    class="text-center"
                  >
                    <v-icon :color="item.color" :icon="item.icon"></v-icon
                  ></Button>
                </div>
              </div>
            </v-col>
          </v-row>
        </v-card-text>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import { router, useForm } from "@inertiajs/vue3";
import {
  mdiKeyboardBackspace,
  mdiGoogle,
  mdiFacebook,
  mdiTwitter,
  mdiInstagram,
} from "@mdi/js";

export default {
  components: {
    mdiGoogle,
    mdiFacebook,
    mdiTwitter,
    mdiInstagram,
    mdiKeyboardBackspace,
  },
  props: {
    goToPreviousWindow: { type: Function },
    listSocialNetworks: { type: Array },
  },
  data: () => ({
    getErrors: "",
    icons: { mdiKeyboardBackspace, mdiGoogle, mdiFacebook, mdiTwitter, mdiInstagram },
    errors: {},
    form: useForm({
      firstname: "",
      lastname: "",
      email: "",
      password: "",
    }),
  }),

  computed: {},
  methods: {
    goToWelcome() {
      return router.get("/");
    },
    goToSocialNetworksUrl(link) {
      if (link) return window.open(link);
    },
    goToRegister() {},
    forgottenPassword() {},
  },
};
</script>
<style scoped>
.hr-text {
  line-height: 1em;
  position: relative;
  outline: 0;
  border: 0;
  color: black;
  text-align: center;
  height: 1.75em;
  opacity: 0.5;
}
.hr-text::before {
  content: "";
  background: linear-gradient(to right, transparent, #004980, transparent);
  position: absolute;
  left: 0;
  top: 50%;
  width: 100%;
  height: 2px;
}
.hr-text::after {
  content: attr(data-content);
  position: relative;
  display: inline-block;
  color: black;
  padding: 0 0.5em;
  line-height: 1.5em;
  color: #004980;
  background-color: #fcfcfa;
}
.team-img {
  width: 50%;
  object-fit: cover;
}
.login {
  position: relative;
  /* margin: 100px auto; */
  /* width: 370px;
  height: 315px; */
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(10px);
  border-top: 1px solid rgba(255, 255, 255, 0.2);
  border-left: 1px solid rgba(255, 255, 255, 0.2);
  box-shadow: 5px 5px 30px #004980;
  /* box-shadow: 5px 5px 30px rgba(0, 0, 0, 0.2); */
  border-radius: 3px;
}
.login h2 {
  line-height: 55px;
  font-size: 24px;
  font-weight: bold;
  font-family: "Open Sans", sans-serif;
  text-align: center;
  color: "#004980";
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(10px);
  border-top: 1px solid rgba(255, 255, 255, 0.2);
  border-left: 1px solid rgba(255, 255, 255, 0.2);
  box-shadow: 5px 5px 30px rgba(0, 0, 0, 0.2);
  margin-top: 0px;
  border-top-left-radius: 3px;
  border-top-right-radius: 3px;
}
.v-application .rounded-bl-xl {
  border-bottom-left-radius: 300px !important;
}
.v-application .rounded-br-xl {
  border-bottom-right-radius: 300px !important;
}
</style>
