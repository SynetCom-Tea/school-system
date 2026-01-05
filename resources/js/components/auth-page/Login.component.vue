<template>
  <v-row align="center" justify="center">
    <v-col cols="12" sm="9" style="
        display: flex;
        justify-content: center;
        align-items: center;
        position: absolute;
        bottom: 0;
        top: 0;
        margin: auto;
        height: 530px;
      ">
      <v-card class="elevation-5 mt-4">
        <v-window v-model="step">
          <v-window-item :value="1">
            <div>
              <v-btn color="secondary" title="Visiter le site web de l'application" @click="goToWelcome()"
                style="text-transform: none; font-size: 12px" :prepend-icon="icons.mdiKeyboardBackspace">
                Visiter le site web</v-btn>
            </div>
            <SectionLogin :goToNextWindow="goToNextWindow" :listSocialNetworks="listSocialNetworks" />
          </v-window-item>
          <v-window-item :value="2">
            <SectionRegister :goToPreviousWindow="goToPreviousWindow" :listSocialNetworks="listSocialNetworks" />
          </v-window-item>
        </v-window>
      </v-card>
    </v-col>
  </v-row>
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

import SectionLogin from "./SectionLogin.vue";
import SectionRegister from "./SectionRegister.vue";
export default {
  components: {
    SectionRegister,
    SectionLogin,
    mdiGoogle,
    mdiFacebook,
    mdiTwitter,
    mdiInstagram,
    mdiKeyboardBackspace,
  },
  data: () => ({
    step: 1,
    getErrors: "",
    icons: { mdiKeyboardBackspace, mdiGoogle, mdiFacebook, mdiTwitter, mdiInstagram },
    errors: {},
    form: useForm({
      email: "",
      password: "",
    }),
  }),

  props: {
    source: String,
  },
  computed: {
    listSocialNetworks() {
      let list = [
        {
          id: 1,
          title: "Visiter Google",
          icon: this.icons.mdiGoogle,
          color: "red",
          link: "https://www.google.com/",
        },
        {
          id: 2,
          title: "Visiter Facebook",
          icon: this.icons.mdiFacebook,
          color: "blue",
          link: "https://www.facebook.com/",
        },
        {
          id: 3,
          title: "Visiter Twitter",
          icon: this.icons.mdiTwitter,
          color: "blue",
          link: "https://twitter.com/",
        },
        // {
        //   id: 4,
        //   title: "Visiter Instagram",
        //   icon: this.icons.mdiInstagram,
        //   color: "red",
        //   link: "https://www.instagram.com/",
        // },
      ];
      return list ?? [];
    },
  },
  methods: {
    goToWelcome() {
      return router.get("/");
    },
    goToNextWindow() {
      return this.step++;
    },
    goToPreviousWindow() {
      return this.step--;
    },
    goToLogin() {
      router.post(route("login"), {
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
.team-img {
  width: 50%;
  object-fit: cover;
}

.login {
  display: flex;
  justify-content: center;
  align-items: center;
}

.v-application .rounded-bl-xl {
  border-bottom-left-radius: 300px !important;
}

.v-application .rounded-br-xl {
  border-bottom-right-radius: 300px !important;
}
</style>
