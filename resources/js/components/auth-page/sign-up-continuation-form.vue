<template>
  <div class="form-container sign-up-container">
    <v-form action="#" class="px-2">
      <h1 class="pb-4 pt-10 sm-title">Quelques détails</h1>
      <v-text-field
        placeholder="First Name"
        filled
        v-model="formData.firstName"
        prepend-inner-icon="mdi-account"
      ></v-text-field>
      <v-text-field
        placeholder="Last Name"
        prepend-inner-icon="mdi-account"
        filled
        v-model="formData.lastName"
      ></v-text-field>
      <v-text-field
        placeholder="Email"
        prepend-inner-icon="mdi-email"
        filled
        v-model="formData.email"
      ></v-text-field>
      <v-text-field
        placeholder="Adress"
        prepend-inner-icon="mdi-map-marker"
        filled
        v-model="formData.address"
      ></v-text-field>
      <v-text-field
        placeholder="Phone Number"
        filled
        prepend-inner-icon="mdi-phone"
        v-model="formData.phoneNumber"
      ></v-text-field>

      <v-row>
        <v-col cols="12" md="6">
          <v-btn
            color="secondary"
            outlined
            tile
            block
            class="pa-6 font-weight-bold"
            elevation="0"
            @click="currentSignUpStep = 1"
            >Retour</v-btn
          >
        </v-col>
        <v-col cols="12" md="6"
          ><v-btn
            color="primary"
            dark
            tile
            block
            class="pa-6 font-weight-bold"
            elevation="0"
            @click="saveFormData()"
            >S'enregistrer</v-btn
          ></v-col
        >
      </v-row>
    </v-form>
  </div>
</template>
<script>
export default {
  data: () => {
    return {};
  },
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
    saveFormData() {
      this.$store.commit("authPageModule/setFormData", this.formData);
      router.get(route("profile"));
    },
  },
};
</script>
<style scoped>
.sign-up-container {
  left: 0;
  width: 50%;
  min-height: 480px;
  height: 70vh;
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
