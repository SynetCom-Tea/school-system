<script>
import {
  mdiDelete,
  mdiPencil,
  mdiPlus,
  mdiCancel,
  mdiContentSaveEditOutline,
} from "@mdi/js";
export default {
  props: {
    // headers: {
    //   type: Array,
    //   required: true,
    // },
    // items: {
    //   type: Array,
    //   required: true,
    // },
    selectedItemForCRUD: {
      type: String,

      required: false,
    },
    titleDatatable: {
      type: String,
      default: "Titre du datatable",
      required: false,
    },
    editItem: { type: Function },
  },
  components: { mdiDelete, mdiPencil, mdiPlus, mdiCancel, mdiContentSaveEditOutline },
  data: () => ({
    dialog: false,
    // selectedItemForCRUD: null,
    dialogDelete: false,
    icons: { mdiDelete, mdiPencil, mdiPlus, mdiCancel, mdiContentSaveEditOutline },
    headers: [
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
    desserts: [],
    editedIndex: -1,
    editedItem: {
      name: "",
      calories: 0,
      fat: 0,
      carbs: 0,
      protein: 0,
    },
    defaultItem: {
      name: "",
      calories: 0,
      fat: 0,
      carbs: 0,
      protein: 0,
    },
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Ajouter une ligne" : "Modifier une ligne";
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
  },

  created() {
    this.initialize();
  },

  methods: {
    initialize() {
      this.desserts = [
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
      ];
    },

    // editItem(item) {
    //   this.editedIndex = this.desserts.indexOf(item);
    //   this.editedItem = Object.assign({}, item);
    //   this.dialog = true;
    //   // this.selectedItemForCRUD = item;
    // },

    // deleteItem(item) {
    //   this.editedIndex = this.desserts.indexOf(item);
    //   this.editedItem = Object.assign({}, item);
    //   this.dialogDelete = true;
    //   this.selectedItemForCRUD = item;
    // },

    deleteItemConfirm() {
      this.desserts.splice(this.editedIndex, 1);
      this.closeDelete();
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    save() {
      if (this.editedIndex > -1) {
        Object.assign(this.desserts[this.editedIndex], this.editedItem);
      } else {
        this.desserts.push(this.editedItem);
      }
      this.close();
    },
  },
};
</script>

<template>
  <v-data-table
    :headers="headers"
    :items="desserts"
    :sort-by="[{ key: 'calories', order: 'asc' }]"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>{{ titleDatatable }}</v-toolbar-title>
        <v-divider class="mx-4" inset vertical></v-divider>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog" max-width="500px">
          <template v-slot:activator="{ props }">
            <Button
              variant="flat"
              class="mb-2"
              nameButton="Ajouter"
              title="Icon de la page"
              style="height: 30px"
              :prependIcon="icons.mdiPlus"
              v-bind="props"
            >
            </Button>
          </template>
          <v-card>
            <v-card-title>
              <span class="text-h5">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="editedItem.name"
                      label="Dessert name"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="editedItem.calories"
                      label="Calories"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field v-model="editedItem.fat" label="Fat (g)"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="editedItem.carbs"
                      label="Carbs (g)"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="editedItem.protein"
                      label="Protein (g)"
                    ></v-text-field>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <Button
                variant="text"
                class="mb-2"
                color="red"
                nameButton="Annuler"
                title="Annuler et Fermer la modale"
                style="height: 30px"
                :prependIcon="icons.mdiCancel"
                :onClickButton="close"
              ></Button>

              <Button
                variant="text"
                class="mb-2"
                nameButton="Enregistrer"
                title="Valider et Fermer la modale"
                style="height: 30px"
                :prependIcon="icons.mdiContentSaveEditOutline"
                :onClickButton="save"
              ></Button>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <v-dialog v-model="dialogDelete" max-width="500px">
          <v-card flat>
            <v-card-title style="background-color: red" class="text-h5 text-white"
              >Confirmation de la suppression</v-card-title
            >
            <v-card-text
              >Etes-vous de vouloir supprimer la ligne :
              {{ selectedItemForCRUD ?? "Nom de la ligne à supprimer" }}</v-card-text
            >
            <v-card-actions>
              <v-spacer></v-spacer>
              <Button
                variant="text"
                class="mb-2"
                nameButton="Enregistrer"
                title="Valider et Fermer la modale"
                style="height: 30px"
                :prependIcon="icons.mdiContentSaveEditOutline"
                :onClickButton="closeDelete"
              ></Button>
              <v-btn color="blue-darken-1" variant="text" @click="closeDelete"
                >Cancel</v-btn
              >
              <v-btn color="blue-darken-1" variant="text" @click="deleteItemConfirm"
                >OK</v-btn
              >
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:item.actions="{ item }">
      <v-icon
        size="small"
        class="me-2"
        @click="editItem(item.raw)"
        :icon="icons.mdiPencil"
        color="orange"
      >
      </v-icon>
      <v-icon
        size="small"
        color="red"
        @click="deleteItem(item.raw)"
        :icon="icons.mdiDelete"
      >
      </v-icon>
    </template>
    <template v-slot:no-data>
      <v-btn color="primary" @click="initialize"> Reset </v-btn>
    </template>
  </v-data-table>
</template>
