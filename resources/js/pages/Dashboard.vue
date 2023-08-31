<script>
import AuthenticatedLayout from "@/layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import TextInput from "../components/customizedComponents/TextField.vue";
import TextInputC from "../components/customizedComponents/TextFieldC.vue";
import Button from "../components/customizedComponents/Button.vue";
import Dialog from "../components/customizedComponents/Dialog.vue";
import Loader from "../components/customizedComponents/Loader.vue";
import ModalDetailUpdate from "../components/customizedComponents/ModalDetailUpdate.vue";
import { mdiAccount, mdiPurse, mdiHomeOutline, mdiPresentation, mdiGift } from "@mdi/js";
import { Vue3Marquee } from "vue3-marquee";
import { VueSpinner, VueSpinnerHourglass } from "vue3-spinners";
import Datatable from "../components/customizedComponents/datatable.vue";
import Toolbar from "../components/customizedComponents/Toolbar.vue";
export default {
  components: {
    Loader,
    Datatable,
    Toolbar,
    ModalDetailUpdate,
    VueSpinnerHourglass,
    AuthenticatedLayout,
    VueSpinner,
    Head,
    Dialog,
    Button,
    TextInput,
    Vue3Marquee,
    TextInputC,
    mdiAccount,
    mdiPurse,
    mdiHomeOutline,
    mdiPresentation,
    mdiGift,
  },
  data() {
    return {
      headers: [
        {
          title: "N°",
          align: "start",
          key: "id",
          sortable: false,
        },
        { title: "Titre", align: "center", key: "title" },

        { title: "Actions", key: "actions", sortable: false },
      ],
      dataH: [
        {
          id: 1,
          title: "Ali",
        },
        {
          id: 2,
          title: "Sara",
        },
        {
          id: 3,
          title: "Sani",
        },
      ],
      test: "Abou",
      isDialog: false,
      rules: {
        required: (value) => !!value || "Required.",
        counter: (value) => value.length <= 20 || "Max 20 characters",
        email: (value) => {
          const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          return pattern.test(value) || "Invalid e-mail.";
        },
      },
      icons: { mdiGift, mdiAccount },
      listGreetings: [
        { id: 1, text: "Wa fonda kayan!", color: "red" },
        { id: 2, text: "Barka da zouwa!", color: "blue" },
        { id: 3, text: "Bienvenue!", color: "gray" },
        { id: 1, text: "Welcome!", color: "green" },
        { id: 1, text: "Marhaba!", color: "red" },
      ],
    };
  },
  mounted() {},

  methods: {
    onClickBt() {
      this.isDialog = !this.isDialog;
    },
    onCloseModale() {
      this.isDialog = false;
    },
    onChangeTitle(e) {},
  },
};
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <Toolbar
      styleToolbar="background-color: white;"
      :icon="icons.mdiAccount"
      toolbarTitle="Acceuil"
    ></Toolbar>
    <div class="mt-10">
      <Vue3Marquee :duration="25">
        <v-row>
          <v-col
            :cols="12 / listGreetings.length"
            v-for="item in listGreetings"
            :key="item.id"
            style="cursor:' pointer"
          >
            <v-hover v-slot="{ isHovering, props }" open-delay="200">
              <v-card
                :elevation="isHovering ? 4 : 2"
                :color="isHovering ? 'primary' : 'undefined'"
                :class="{ 'on-hover': isHovering }"
                v-bind="props"
              >
                <v-card-text class="defile"> </v-card-text>{{ item.text }}</v-card
              >
            </v-hover>
          </v-col>
          &nbsp;&nbsp;
        </v-row>
      </Vue3Marquee>
    </div>
    <br /><br /><br /><br /><br /><br />
    <Loader :modelDialog="isDialog">
      <template v-slot:spinnertype>
        <VueSpinner size="50" color="white"></VueSpinner
      ></template>
    </Loader>
    <br /><br />
    <!-- <Toolbar
      styleToolbar="background-color:#004980"
      :icon="icons.mdiAccount"
      toolbarTitle="Toolbar title"
    ></Toolbar> -->
    <br /><br />
    <div>
      <Datatable titleDatatable="Liste des items " :headers="headers" :items="dataH" />
    </div>
    <br /><br />

    <Button
      variant="flat"
      density="comfortable"
      title="title"
      class="m-4"
      color="red"
      nameButton="Test Loader"
      :prependIcon="icons.mdiAccount"
      :appendIcon="icons.mdiGift"
      :onClickButton="onClickBt"
    ></Button>
    <!-- <Dialog
      :modelDialog="isDialog"
      :onCloseModale="onCloseModale"
      :iconHeaderModal="icons.mdiAccount"
      :widthDialog="300"
    >
      <template v-slot:content>
        <h1>TEST CONTENU</h1>
      </template>
      <template #otherButtons>
        <Button
          title="Fermer la modale"
          variant="text"
          color="primary"
          nameButton="Enregistrer"
          :onClickButton="onCloseModale"
          style="float: right; margin: 10px; height: 30px"
        ></Button
      ></template>
    </Dialog> -->
     <TextInput
      type="text"
      v-model="test"
      label="Mot de passe"
      :isRequired="true"
      classResponsive="py-4"
      :maxHeightResponsive="100"
      :maxWidthResponsive="150"
      :onchangeField="onChangeTitle"
      :rules="[rules.required, rules.counter]"
    />
    <div>{{ test }}</div>
    <br /><br /><br /><br /><br /><br />

    <div>
      <ModalDetailUpdate
        toolbarTitle="Modale"
        :iconValueDetail="icons.mdiAccount"
        :iconUpdate="icons.mdiGift"
      />
    </div>
  </AuthenticatedLayout>
</template>
<style scoped>
.classTest {
  width: 200px;
  background-color: red;
}
.defile {
  font-family: monospace;
  font-size: 3em;
  animation: color-change 1s infinite;
}

@keyframes color-change {
  0% {
    color: red;
  }
  50% {
    color: blue;
  }
  100% {
    color: red;
  }
}
</style>
