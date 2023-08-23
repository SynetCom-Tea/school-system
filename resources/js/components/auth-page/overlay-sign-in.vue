<template>
  <div class="overlay-panel overlay-right">
    <h1 class="px-2 my-2 sm-title font-weight-bold">
      Wa-fonda-kayan Barka-da-zouwa Bienvenue Welcome Marhaba !
    </h1>
    <div class="sm-description">Vous n'avez pas encore de compte ?</div>
    <div class="sm-description">Veuillez vous enregistrer ici</div>
    <v-btn
      color="secondary"
      dark
      rounded
      class="pa-1 my-1 font-weight-bold"
      elevation="0"
      @click="isSignInPanelActive = true"
    >
      S'enregistrer
    </v-btn>
  </div>
</template>

<script>
export default {
  computed: {
    isSignInPanelActive: {
      get: function () {
        return this.$store.getters["authPageModule/getIsSignInPanelActive"];
      },
      set: function (newVal) {
        this.$store.commit("authPageModule/setIsSignInPanelActive", newVal);
      },
    },
  },
};
</script>

<style scoped>
.overlay-right {
  min-height: 480px;
  height: 70vh;
  right: 0;
  transform: translateX(0);
}
</style>
