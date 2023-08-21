<template>
  <div class="form-container sign-in-container mt-2">
    <img src="team.png" class="team-img pt-1" />
    <h1 class="pb-2 font-weight-bold">Page de connexion</h1>
    <v-form action="login" class="px-2">
      <v-text-field
        :prepend-inner-icon="mdiAccountSchool"
        v-model="form.email"
        placeholder="Username"
        filled
      ></v-text-field>
      <v-text-field
        placeholder="Password"
        v-model="form.password"
        type="password"
        filled
      ></v-text-field>
      <v-btn
        color="primary"
        block
        dark
        tile
        class="pa-3 font-weight-bold"
        elevation="0"
        @click="login()"
        >Connexion</v-btn
      >
      <v-row class="justify-center py-5">
        <span class="text-secondary forgot-password-sm">Mot de passe oublié?</span>
      </v-row>
    </v-form>
  </div>
</template>
<script>
import {
  mdiWalletMembership,
  mdiHomeOutline,
  mdiDownload,
  mdiDelete,
  mdiAccountSchool,
  mdiPencil,
  mdiPlus,
  mdiEye,
  mdiCameraLockOpenOutline,
  mdiPrinter,
  mdiCloseCircle,
  mdiReceipt,
  mdiPaperclip,
} from "@mdi/js";
import { Icon } from "@iconify/vue";
import { Head, Link, useForm, router } from "@inertiajs/vue3";
export default {
  components: {
    Icon,
    mdiDownload,
    mdiWalletMembership,
    mdiHomeOutline,
    mdiPencil,
    mdiAccountSchool,
    mdiDelete,
    mdiCameraLockOpenOutline,
    mdiEye,
    mdiPlus,
    mdiPrinter,
    mdiCloseCircle,
    mdiReceipt,
    mdiPaperclip,
  },
  data: () => {
    return {
      form: useForm({
        email: "",
        password: "",
      }),
    };
  },
  methods: {
    login() {
      this.$store.dispatch("authPageModule/loginAndSaveToken", {
        username: this.form.email,
        password: this.form.password,
      });

      this.form.post(route("login"), {
        onError: (e) => {
          console.log("error from login:", e);
        },
      });
    },
  },
};
</script>
<style scoped>
.sign-in-container {
  left: 0;
  width: 50%;
  z-index: 2;
}
.team-img {
  width: 30%;
  object-fit: cover;
}

.container.right-panel-active .sign-in-container {
  transform: translateX(100%);
}

.container.right-panel-active .overlay-container {
  transform: translateX(-100%);
}
.forgot-password-sm {
  font-size: 12px;
}
.forgot-password-md {
  font-size: 15px;
}
</style>
