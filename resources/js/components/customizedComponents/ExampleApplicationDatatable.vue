<script>
import Datatable from "./Datatable.vue";
import { router, useForm } from "@inertiajs/vue3";
import TextFieldC from "./TextFieldC.vue";
import { mdiAccount, mdiPurse, mdiHomeOutline, mdiPresentation, mdiGift } from "@mdi/js";
import { inject } from "vue";
export default {
  components: {
    Datatable,
    TextFieldC,
    mdiAccount,
    mdiPurse,
    mdiHomeOutline,
    mdiPresentation,
    mdiGift,
  },
  data() {
    console.log("Test:", this.my_data);
    return {
      onDetailUpdate: false,
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
  inject: ["my_data"],
  mounted() {
    console.log("loggedIn:", this.my_data);
  },
  computed: {
    location() {
      return ref("North Pole");
    },
  },

  methods: {
    updateLocation() {
      location.value = "South Pole";
    },
    functionOnClickAddButton() {
      console.log("herer");
      router.get(route("users.index"));
    },
    editItem(item) {
      console.log("item from editItem:", item);
    },
    deleteItem(item) {
      console.log("item from deleteItem:", item);
    },
  },
};
</script>

<template>
  <div>
    <!-- :headers="headers" :items="dataH" -->
    <Datatable
      :addDialog="true"
      :dialogDetailUpdate="true"
      titleDatatable="Liste des items"
      :functionDeleteItem="deleteItem"
      :editedObject="editedObject"
      :functionEditItem="editItem"
      :headers="headersH"
      :items="desserts"
    >
      <template v-slot:contentDialogUpdateDetail>
        <ModalDetailUpdate :dialogDetailUpdate="onDetailUpdate">
          <template v-slot:contentForm>
            <TextFieldC />
          </template>
        </ModalDetailUpdate>
      </template>
    </Datatable>
  </div>
</template>
<style scoped></style>
