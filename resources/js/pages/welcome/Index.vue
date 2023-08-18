<template>
  <GuestLayout>
    <v-app-bar color="primary" :clipped-left="false" fixed dark app>
      <v-toolbar-title> Gestion Système scolaire </v-toolbar-title>
      <v-spacer />
      <!-- <Link  :href="route('home')">
        <v-btn text>Page d'accueil</v-btn>
      </Link> -->
      <div><v-btn color="white" @click="testURL">Connexion</v-btn></div>
    </v-app-bar>
    <BodyIndex />
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
    testURL() {
      console.log("here");
      return this.$inertia.get("/");
    },
  },
};
</script>

<style scoped></style>
