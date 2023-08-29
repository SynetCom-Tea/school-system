<template>
  <GuestLayout>
    <v-app-bar color="primary" :clipped-left="false" fixed dark app>
      <v-toolbar-title> Gestion Système scolaire </v-toolbar-title>
      <v-spacer />
      <!-- <Link  :href="route('home')">
        <v-btn text>Page d'accueil</v-btn>
      </Link> -->
      <div><v-btn color="white" @click="goToLogin()">Connexion</v-btn></div>
    </v-app-bar>
    <main>
      <BodyIndex />
    </main>

    <!-- <v-card style="margin-top: 100px">
      <h1>Wa barka!!</h1>
    </v-card> -->

    <v-divider></v-divider>

    <FooterIndex />
  </GuestLayout>
</template>

<script>
import { router, useForm } from "@inertiajs/vue3";
import FooterIndex from "../../components/welcome/Footer.index.vue";
import BodyIndex from "../../components/welcome/Body.index.vue";
import GuestLayout from "../../layouts/GuestLayout.vue";
export default {
  components: { GuestLayout, FooterIndex, BodyIndex },
  props: [],
  data() {
    return {};
  },
  computed: {},
  mounted() {},
  methods: {
    goToLogin() {
      // this.$router.push("/login");
      // this.$router.push("/login");
      return router.get(route("login"));
    },
  },
};
</script>

<style scoped></style>
