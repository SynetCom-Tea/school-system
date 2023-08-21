<template>
  <div class="overlay-panel overlay-left">
    <h1 class="px-2 my-4 sm-title font-weight-bold">Wa-fonda-kayan!</h1>
    <p class="pa-4 sm-description">
      Si vous n'avez pas encore de compte, veuillez vous enregistrer ici !
    </p>

    <v-btn
      color="secondary"
      dark
      rounded
      class="pa-1 my-1 font-weight-bold"
      elevation="0"
      @click="isSignInPanelActive = false"
    >
      Se connecter
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
.overlay-left {
  min-height: 480px;
  height: 70vh;
  transform: translateX(-20%);
}
</style>
