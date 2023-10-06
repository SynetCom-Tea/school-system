<script>
import AuthenticatedLayout from "@/layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

import ExampleApplicationDatatable from "../components/customizedComponents/ExampleApplicationDatatable.vue";
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
    ExampleApplicationDatatable,
    Loader,
    Datatable,
    Toolbar,
    ModalDetailUpdate,
    VueSpinnerHourglass,
    AuthenticatedLayout,
    VueSpinner,
    Head,
    Dialog,
    Vue3Marquee,
    mdiAccount,
    mdiPurse,
    mdiHomeOutline,
    mdiPresentation,
    mdiGift,
  },
  data() {
    return {
      headersH: [
        {
          title: "Dessert (100g serving)",
          align: "start",
          sortable: false,
          key: "name",
        },
        { title: "Calories", key: "calories" },
        { title: "Fat (g)", key: "fat" },
        { title: "Carbs (g)", key: "carbs" },
        { title: "Protein (g)", key: "protein" },
        { title: "Actions", key: "actions", sortable: false },
      ],
      headers: [
        {
          title: "N°",
          align: "start",
          key: "id",
          sortable: false,
        },
        { title: "Titre", align: "center", key: "title" },

        {
          title: "Actions",
          key: "actions",
          sortable: false,
        },
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
      desserts: [
        {
          name: "Frozen Yogurt",
          calories: 159,
          fat: 6.0,
          carbs: 24,
          protein: 4.0,
        },
        {
          name: "Ice cream sandwich",
          calories: 237,
          fat: 9.0,
          carbs: 37,
          protein: 4.3,
        },
        {
          name: "Eclair",
          calories: 262,
          fat: 16.0,
          carbs: 23,
          protein: 6.0,
        },
        {
          name: "Cupcake",
          calories: 305,
          fat: 3.7,
          carbs: 67,
          protein: 4.3,
        },
        {
          name: "Gingerbread",
          calories: 356,
          fat: 16.0,
          carbs: 49,
          protein: 3.9,
        },
        {
          name: "Jelly bean",
          calories: 375,
          fat: 0.0,
          carbs: 94,
          protein: 0.0,
        },
        {
          name: "Lollipop",
          calories: 392,
          fat: 0.2,
          carbs: 98,
          protein: 0,
        },
        {
          name: "Honeycomb",
          calories: 408,
          fat: 3.2,
          carbs: 87,
          protein: 6.5,
        },
        {
          name: "Donut",
          calories: 452,
          fat: 25.0,
          carbs: 51,
          protein: 4.9,
        },
        {
          name: "KitKat",
          calories: 518,
          fat: 26.0,
          carbs: 65,
          protein: 7,
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
      editedObject: {
        name: "",
        calories: 0,
        fat: 0,
        carbs: 0,
        protein: 0,
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

    editItem(item) {},
    deleteItem(item) {},
  },
};
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <Toolbar
      styleToolbar="background-color: white;"
      :icon="icons.mdiHome"
      toolbarTitle="Acceuil"
    ></Toolbar>
    <div class="mt-10">
      <Vue3Marquee :duration="25">
        <v-row>
          <v-col
            :cols="12 / listGreetings.length"
            v-for="item in listGreetings"
            :key="item.id"
            style="cursor:' pointer; background-color:#7d002c; color:white"
          >
            <v-hover v-slot="{ isHovering, props }" open-delay="200">
              <v-card-text
                :elevation="isHovering ? 4 : 2"
                :color="isHovering ? 'primary' : 'undefined'"
                :class="{ 'on-hover': isHovering }"
                v-bind="props"
                >{{ item.text }}
              </v-card-text>
            </v-hover>
          </v-col>
          &nbsp;&nbsp;
        </v-row>
      </Vue3Marquee>
    </div>
    <br /><br /><br /><br /><br /><br />

    <div>
      <ExampleApplicationDatatable />
    </div>

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
  </AuthenticatedLayout>
</template>
