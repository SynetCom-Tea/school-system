<template>
  <div class="form-container sign-up-container">
    <img src="team.png" class="team-img pt-10" />
    <h1 class="pb-12 font-weight-bold">Créer un compte</h1>
    <v-form action="#" class="px-2 mt-12">
      <v-text-field
        placeholder="Username"
        filled
        v-model="formData.username"
      ></v-text-field>
      <v-text-field
        placeholder="Password"
        filled
        v-model="formData.password"
        type="password"
      ></v-text-field>
      <v-btn
        color="primary"
        block
        dark
        tile
        class="pa-6 font-weight-bold"
        elevation="0"
        @click="saveformData()"
        >S'enregistrer</v-btn
      >
    </v-form>
  </div>
</template>
<script>
export default {
  computed: {
    currentSignUpStep: {
      get: function () {
        return this.$store.getters["authPageModule/getCurrentSignUpStep"];
      },
      set: function (newVal) {
        this.$store.commit("authPageModule/setCurrentSignUpStep", newVal);
      },
    },
    formData: {
      get: function () {
        return this.$store.getters["authPageModule/getFormData"];
      },
      set: function () {
        this.$store.commit("authPageModule/setFormData", this.formData);
      },
    },
  },
  methods: {
    saveformData() {
      this.$store.commit("authPageModule/setFormData", this.formData);
      this.currentSignUpStep = 2;
    },
  },
};
</script>
<style scoped>
.sign-up-container {
  min-height: 480px;
  height: 70vh;
  left: 0;
  width: 50%;
  opacity: 0;
  z-index: 1;
}
.team-img {
  width: 30%;
  object-fit: cover;
}

.container.right-panel-active .sign-up-container {
  transform: translateX(100%);
  opacity: 1;
  z-index: 5;
  animation: show 0s;
}

@keyframes show {
  0%,
  49.99% {
    opacity: 0;
    z-index: 1;
  }

  50%,
  100% {
    opacity: 1;
    z-index: 5;
  }
}
</style>
