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
    return {
      onDetailUpdate: false,
      headersH: [
        {
          title: "Dessert (100g serving)",
          align: "start",
          sortable: false,
          key: "name",
          class: "blue lighten-5",
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
          color: "red-line",
        },
        {
          name: "Ice cream sandwich",
          calories: 237,
          fat: 9.0,
          carbs: 37,
          protein: 4.3,
          color: "blue-line",
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

      dialogDetailUpdate: true,
      selectedItemForUpdate: "",
    };
  },

  mounted() {},
  computed: {},

  methods: {
    functionOnClickAddButton() {
      router.get(route("users.index"));
    },
    submitNewLine() {},
    editItem(item) {
      this.editedObject = Object.assign({}, item);
      if (item) {
        this.selectedItemForUpdate = item;
      }
      if (this.dialogDetailUpdate) {
        this.onDetailUpdate = true;
      }
    },
    deleteItem(item) {},
    onConfirmDeleting() {},
    onClickCancelButtonOfMDU() {
      this.onDetailUpdate = false;
    },
    onClickSaveButtonOfMDU() {
      this.onDetailUpdate = false;
    },
  },
};
</script>

<template>
  <!-- Pour afficher une modal d'ajout de nouvelle ligne, il suffit
 d'ajouter le props " :addDialog='true' " >> pour l'activer  et definir le contenu de la modale en utilisant le slot "addDialogContent".
 Pour faire une redirection vers une nouvelle page (Ajout de nouvelle ligne), il suffit d'ajouter le props "functionOnClickAddButton"
 -->

  <div>
    <Datatable
      fixed-header
      height="420"
      :addDialog="true"
      :displayAddButton="false"
      :dialogDetailUpdate="dialogDetailUpdate"
      titleDatatable="Liste des items"
      :functionDeleteItem="deleteItem"
      :functionOnConfirmDeleting="onConfirmDeleting"
      :editedObject="editedObject"
      :functionEditItem="editItem"
      :headers="headersH"
      :items="desserts"
      :functionOnSaveAdding="submitNewLine"
      :functionOnClickAddButton="functionOnClickAddButton"
    >
      <template v-slot:addDialogContent
        ><div>Ici le contenu de la modal ajout d'une nouvelle ligne</div></template
      >

      <template v-slot:contentDialogUpdateDetail>
        <ModalDetailUpdate
          :dialogDetailUpdate="onDetailUpdate"
          :onClickCancelButton="onClickCancelButtonOfMDU"
          :onClickSaveButton="onClickSaveButtonOfMDU"
        >
          <template v-slot:contentForm>
            <TextFieldC :item="editedObject" />
          </template>
        </ModalDetailUpdate>
      </template>
    </Datatable>
  </div>
</template>
<style>
.blue-line td {
  color: green;
}

.red-line td {
  color: red;
}
</style>
