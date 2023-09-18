<template>
  <div>
    <v-row>
      <v-col cols="6" md="6">
        <v-card-text class="mt-8">
          <v-row align="center" justify="center">
            <v-col cols="12" sm="8" class="login">
              <h2 class="text-center">Page de connexion</h2>
              <v-form>
                <TextField
                  label="Identifiant"
                  outlined
                  :isRequired="true"
                  v-model="form.email"
                  dense
                  class="mt-5"
                  :errorMessageValue="form.errors.email"
                  hint="Respecter le format email"
                />
                <!-- <TextField
                  label="Mot de passe"
                  v-model="form.password"
                  outlined
                  dense
                  :isRequired="true"
                  autocomplete="false"
                  hint="Un mot de passe composé de 8 caractères au min dont une lettre majuscule, caractères spéciaux,un chiffre et minuscules"
                  :append-icon="showPassword ? icons.mdiEye : icons.mdiEyeOff"
                  :type="showPassword ? 'text' : 'password'"
                  :error-messages="form.errors.password && ' Mot de passe incorrect!'"
                  @click:append="showPassword = !showPassword"
                /> -->

                <TextField
                  v-model="form.password"
                  :type="showPassword ? 'text' : 'password'"
                  :isRequired="true"
                  outlined
                  dense
                  label="Message"
                  type="text"
                  @click:append="togglePassword()"
                >
                  <template v-slot:append>
                    <v-icon :icon="showPassword ? icons.mdiEye : icons.mdiEyeOff" />
                  </template>
                </TextField>
              </v-form>
              <Button
                title="Valider"
                variant="flat"
                nameButton="Connexion"
                @click="goToLogin"
                density="comfortable"
                class="text-center"
                block
                size="large"
                style="text-transform: none"
              >
              </Button>
              <v-row>
                <div class="mt-3" style="font-size: 2px">
                  <v-checkbox label="Se rappeler de moi" color="primary"> </v-checkbox>
                </div>
                <v-col cols="12" md="5">
                  <div
                    class="mt-3"
                    style="font-size: 10px; cursor: pointer; color: #7d002c"
                    color="primary"
                    @click="forgottenPassword()"
                  >
                    Mot de passe oublié
                  </div>
                </v-col>
              </v-row>

              <h6 class="text-center">
                <hr class="hr-text" data-content="Ou se connecter avec" />
              </h6>
              <div class="d-flex justify-space-between mx-1 mt-3">
                <div
                  v-for="item in listSocialNetworks"
                  class="d-flex justify-space-between mx-1 mt-3"
                >
                  <Button
                    :title="item.title"
                    color="white"
                    class="text-center"
                    @click="goToSocialNetworksUrl(item.link)"
                  >
                    <v-icon :color="item.color" :icon="item.icon"></v-icon
                  ></Button>
                </div>
              </div>
            </v-col>
          </v-row>
        </v-card-text>
      </v-col>

      <v-col cols="6" md="6" class="bg-primary rounded-xl rounded-be-0">
        <v-card-text style="text-align: center">
          <div><img src="team.png" class="team-img pt-1" /></div>
          <v-card-text class="white--text">
            <h3 class="text-center">Vous n'avez pas encore de compte?</h3>
            <h6 class="text-center">
              Tout y pour que vous puissiez commencer à créer votre <br />
              première expérience d'intégration
            </h6>
          </v-card-text>
          <div class="text-center">
            <Button
              title="Valider"
              style="text-transform: none"
              nameButton="S'enregistrer"
              density="comfortable"
              class="text-center"
              color="secondary"
              size="large"
              variant="flat"
              @click="goToNextWindow"
            >
            </Button>
          </div>
        </v-card-text>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import { router, useForm } from "@inertiajs/vue3";
import {
  mdiGoogle,
  mdiFacebook,
  mdiTwitter,
  mdiInstagram,
  mdiEye,
  mdiEyeOff,
} from "@mdi/js";

export default {
  components: { mdiGoogle, mdiFacebook, mdiTwitter, mdiInstagram, mdiEye, mdiEyeOff },
  props: {
    goToNextWindow: { type: Function },
    listSocialNetworks: { type: Array },
    // goToLogin: { type: Function },
  },
  data: () => ({
    getErrors: "",
    showPassword: false,
    icons: { mdiGoogle, mdiFacebook, mdiTwitter, mdiInstagram, mdiEye, mdiEyeOff },
    errors: {},
    form: useForm({
      email: "",
      password: "",
    }),
  }),

  computed: {},
  created() {
    console.log(this.$page.props.flash?.message?.text);
    if (this.$page.props.flash?.message?.type == "error") {
      this.$swal({
        icon: "error",
        title: "Authentification",
        text: this.$page.props.flash?.message?.text,
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
      });
    }
  },
  methods: {
    togglePassword() {
      console.log("show:", this.showPassword);
      this.showPassword = !this.showPassword;
    },
    goToSocialNetworksUrl(link) {
      if (link) return window.open(link);
    },

    forgottenPassword() {},
    goToLogin(e) {
      e.preventDefault();
      this.form.post(route("login"), {
        onError: (e) => {
          if (e.email == "These credentials do not match our records.") {
            this.errors.text = "Identifiant ou mot de passe incorrect";
          }
        },
      });
    },
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
  width: 70%;
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
