<template>
  <GuestLayout>
    <div class="welcome-screen">
    <v-app-bar color="primary" :clipped-left="false" fixed dark app>
      <v-toolbar-title> Gestion Système scolaire </v-toolbar-title>
      <v-spacer />
      <!-- <Link  :href="route('home')">
        <v-btn text>Page d'accueil</v-btn>
      </Link> -->
      <div><v-btn color="white" @click="goToLogin()">Connexion</v-btn></div>
    </v-app-bar>
    <div class="welcome-content">
      <BodyIndex />

    <!-- <v-card style="margin-top: 100px">
      <h1>Wa barka!!</h1>
    </v-card> -->

    <v-divider></v-divider>

    <FooterIndex />
    </div>
    </div>
  </GuestLayout>
</template>

<script>
import { router } from "@inertiajs/vue3";
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

<style scoped>
.welcome-screen {
  display: flex;
  flex-direction: column;
  width: 100%;
  height: 100dvh;
  overflow: hidden;
}

:global(.v-card-text:has(.welcome-screen)) {
  box-sizing: border-box;
  height: 100dvh;
  overflow: hidden;
  padding: 0;
}

.welcome-content {
  display: flex;
  flex: 1;
  flex-direction: column;
  min-height: 0;
  margin-top: 64px;
  overflow: hidden;
}

.welcome-content :deep(.welcome-page) {
  flex: 1;
  min-height: 0;
}

.welcome-content :deep(footer) {
  flex: 0 0 auto;
}

@media (max-width: 600px) {
  .welcome-content {
    margin-top: 56px;
  }

  .welcome-screen :deep(.v-app-bar) {
    height: 56px !important;
  }

  .welcome-screen :deep(.v-toolbar-title) {
    overflow: hidden;
    font-size: 15px;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  .welcome-screen :deep(.v-app-bar .v-btn) {
    min-width: auto;
    padding-inline: 10px;
    font-size: 12px;
  }
}

</style>
