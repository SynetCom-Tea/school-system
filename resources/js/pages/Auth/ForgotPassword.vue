<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, useForm, router } from "@inertiajs/vue3";
import { mdiSend, mdiLockReset, mdiKeyboardBackspace } from "@mdi/js";
defineProps({
  status: {
    type: String,
  },
});

const form = useForm({
  email: "",
});

const submit = () => {
  form.post(route("password.email"));
};
const icons = { mdiSend, mdiLockReset, mdiKeyboardBackspace };

function goLogin() {
  return router.get(route("login"));
}
</script>

<template>
  <GuestLayout>
    <Toolbar :icon="icons.mdiLockReset" toolbarTitle="Mot de passe oublié"></Toolbar>
    <v-row>
      <v-col cols="6">
        <v-card-text class="mt-8">
          <div class="mb-4 text-sm text-gray-600">
            Mot de passe oublié, Aucun problème. Faites-nous simplement savoir votre
            adresse e-mail et nous le ferons vous envoyer par e-mail un lien de
            réinitialisation de mot de passe qui vous permettra d'en choisir un nouveau.
          </div>

          <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
          </div>
          <v-row align="center" justify="center">
            <v-col cols="12" sm="8" class="login" style="border: 1 solid">
              <h2 class="text-center">
                <v-icon
                  :icon="icons.mdiKeyboardBackspace"
                  @click="goLogin"
                  title="Clicquer pour retourner à la page login"
                ></v-icon>
                &nbsp;Page de Changement de mot de passe
              </h2>
              <br />

              <form @submit.prevent="submit">
                <TextField
                  label="Email"
                  type="email"
                  class="mt-1 block w-full"
                  :error-messages="form.errors.email && 'Email invalide!!'"
                  v-model="form.email"
                  :isRequired="true"
                  autofocus
                  autocomplete="username"
                  :maxWidthResponsive="350"
                />

                <Button
                  :class="{ 'opacity-25': form.processing }"
                  :disabled="form.processing"
                  size="large"
                  @click="submit"
                  nameButton="Envoyer"
                  :prependIcon="icons.mdiSend"
                >
                </Button>
              </form>
            </v-col>
          </v-row>
        </v-card-text>
      </v-col>
    </v-row>
  </GuestLayout>
</template>
<style scoped>
.login {
  position: relative;
  /* margin: 100px auto; */
  /* width: 370px;
  height: 315px; */
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(10px);
  border-top: 1px solid rgba(255, 255, 255, 0.2);
  border-left: 1px solid rgba(255, 255, 255, 0.2);
  box-shadow: 5px 5px 30px #004980;
  /* box-shadow: 5px 5px 30px rgba(0, 0, 0, 0.2); */
  border-radius: 3px;
}
.login h2 {
  line-height: 35px;
  font-size: 20px;
  font-weight: bold;
  font-family: "Open Sans", sans-serif;
  text-align: center;
  color: "#004980";
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(10px);
  border-top: 1px solid rgba(255, 255, 255, 0.2);
  border-left: 1px solid rgba(255, 255, 255, 0.2);
  box-shadow: 5px 5px 30px rgba(0, 0, 0, 0.2);
  margin-bottom: 5px;
  margin-top: 0px;
  border-top-left-radius: 3px;
  border-top-right-radius: 3px;
}
</style>
