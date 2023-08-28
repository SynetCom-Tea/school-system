<template>
  <div class="login">
    <v-row align="center" justify="center">
      <v-col cols="12" sm="10">
        <v-card class="elevation-5 mt-4">
          <v-window v-model="step">
            <v-window-item :value="1">
              <v-row>
                <v-col cols="12" md="6" style="height: 530px">
                  <v-card-text class="mt-8">
                    <h2 class="text-center">Page de connexion</h2>
                    <h6 class="text-center grey--text">
                      Connectez vous à votre compte pour continuer à explorer <br />et
                      découvrir l'innovation
                    </h6>
                    <v-row align="center" justify="center">
                      <v-col cols="12" sm="8">
                        <v-form action="goToLogin">
                          <TextField
                            label="Identifiant"
                            outlined
                            :isRequired="true"
                            v-model="form.email"
                            dense
                            class="mt-5"
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
                        </v-form>
                        <v-row>
                          <v-col cols="12" sm="7">
                            <v-checkbox
                              label="Se rappeler de moi"
                              class="mt-n1"
                              color="primary"
                            >
                            </v-checkbox>
                          </v-col>
                          <v-col cols="12" sm="5">
                            <span style="font-size: 13px; color: #004980; cursor: pointer"
                              >Mot de passe oublié</span
                            >
                          </v-col>
                        </v-row>
                        <v-btn color="primary" dark block tile @click="goToLogin()"
                          >Connexion</v-btn
                        >

                        <h5 class="text-center grey--text mt-1 mb-2">
                          Ou se connecter avec
                        </h5>
                        <div class="d-flex justify-space-between align-center mx-2 mb-1">
                          <v-btn depressed outlined color="grey">
                            <v-icon color="red" :icon="icons.mdiGoogle"></v-icon>
                          </v-btn>
                          <v-btn depressed outlined color="grey">
                            <v-icon color="blue" :icon="icons.mdiFacebook"></v-icon>
                          </v-btn>
                          <v-btn depressed outlined color="grey">
                            <v-icon
                              color="light-blue lighten-3"
                              :icon="icons.mdiTwitter"
                            ></v-icon>
                          </v-btn>
                        </div>
                      </v-col>
                    </v-row>
                  </v-card-text>
                </v-col>
                <v-col
                  cols="12"
                  md="6"
                  style="height: 530px"
                  class="bg-primary rounded-bl-xl"
                >
                  <div style="text-align: center; padding: 180px 0">
                    <v-card-text class="white--text">
                      <h3 class="text-center">Vous n'avez pas encore de compte?</h3>
                      <h6 class="text-center">
                        Let's get you all set up so you can start creating your your
                        first<br />
                        onboarding experience
                      </h6>
                    </v-card-text>
                    <div class="text-center">
                      <v-btn color="secondary" tile outlined dark @click="step++"
                        >S'enregistrer</v-btn
                      >
                    </div>
                  </div>
                </v-col>
              </v-row>
            </v-window-item>
            <v-window-item :value="2">
              <v-row>
                <v-col cols="12" md="6" class="blue rounded-br-xl" style="height: 530px">
                  <div style="text-align: center; padding: 180px 0">
                    <v-card-text class="white--text">
                      <h3 class="text-center">Déjà enregistré(e)?</h3>
                      <h6 class="text-center">
                        Log in to your account so you can continue building and<br />
                        editing your onboarding flows
                      </h6>
                    </v-card-text>
                    <div class="text-center">
                      <v-btn color="primary" tile outlined dark @click="step--"
                        >Se Connecter</v-btn
                      >
                    </div>
                  </div>
                </v-col>

                <v-col cols="12" md="6" style="height: 530px">
                  <v-card-text class="mt-5">
                    <h3 class="text-center">Créer un compte</h3>
                    <h6 class="text-center grey--text">
                      Let's get you all set up so you can start creatin your <br />
                      first onboarding experiance
                    </h6>
                    <v-row align="center" justify="center">
                      <v-col cols="12" sm="8">
                        <v-row>
                          <v-col cols="12" sm="6">
                            <v-text-field
                              label="First Name"
                              outlined
                              dense
                              color="blue"
                              autocomplete="false"
                              class="mt-2"
                            />
                          </v-col>
                          <v-col cols="12" sm="6">
                            <v-text-field
                              label="Last Name"
                              outlined
                              dense
                              color="blue"
                              autocomplete="false"
                              class="mt-2"
                            />
                          </v-col>
                        </v-row>
                        <v-text-field
                          label="Email"
                          outlined
                          dense
                          color="blue"
                          autocomplete="false"
                        />
                        <v-text-field
                          label="Password"
                          outlined
                          dense
                          color="blue"
                          autocomplete="false"
                          type="password"
                        />
                        <v-row>
                          <v-col cols="12" sm="7">
                            <v-checkbox
                              label="J'accepte les conditions"
                              class="mt-n1"
                              color="primary"
                            >
                            </v-checkbox>
                          </v-col>
                          <v-col cols="12" sm="5">
                            <span>Terms &Conditions</span>
                          </v-col>
                        </v-row>
                        <v-btn color="primary" dark block tile>S'enregistrer</v-btn>

                        <h5 class="text-center grey--text mt-2 mb-3">
                          Ou S'enregistrer avec
                        </h5>
                        <div class="d-flex justify-space-between align-center mx-5 mb-4">
                          <v-btn depressed outlined color="grey">
                            <v-icon color="red" :icon="icons.mdiInstagram"></v-icon>
                          </v-btn>
                          <v-btn depressed outlined color="grey">
                            <v-icon color="blue" :icon="icons.mdiFacebook"></v-icon>
                          </v-btn>
                          <v-btn depressed outlined color="grey">
                            <v-icon
                              color="light-blue lighten-3"
                              :icon="icons.mdiTwitter"
                            ></v-icon>
                          </v-btn>
                        </div>
                      </v-col>
                    </v-row>
                  </v-card-text>
                </v-col>
              </v-row>
            </v-window-item>
          </v-window>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import { router, useForm } from "@inertiajs/vue3";
import { mdiGoogle, mdiFacebook, mdiTwitter, mdiInstagram } from "@mdi/js";
import TextField from "../customizedComponents/TextField.vue";
export default {
  components: { TextField, mdiGoogle, mdiFacebook, mdiTwitter, mdiInstagram },
  data: () => ({
    step: 1,
    getErrors: "",
    icons: { mdiGoogle, mdiFacebook, mdiTwitter, mdiInstagram },
    errors: {},
    form: useForm({
      email: "",
      password: "",
    }),
  }),

  props: {
    source: String,
  },
  methods: {
    goToLogin() {
      this.form.post(route("login"), {
        onError: (e) => {
          console.log("error from login:", e);
          console.log("error :", this.getErrors);
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
.login {
  height: 50vh;
  min-height: 480px;
}
.v-application .rounded-bl-xl {
  border-bottom-left-radius: 300px !important;
}
.v-application .rounded-br-xl {
  border-bottom-right-radius: 300px !important;
}
</style>
