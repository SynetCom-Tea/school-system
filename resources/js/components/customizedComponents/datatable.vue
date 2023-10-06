<script>
import {
  mdiAccount,
  mdiDelete,
  mdiPencil,
  mdiPlus,
  mdiCancel,
  mdiMagnify,
  mdiContentSaveEditOutline,
} from "@mdi/js";

import ModalDetailUpdate from "./ModalDetailUpdate.vue";
// import { provide, reactive, ref } from "vue";
export default {
  props: {
    headers: {
      type: Array,
      required: true,
    },
    items: {
      type: Array,
      required: true,
    },

    editedObject: {
      type: Object,
      required: false,
    },
    addDialog: {
      type: Boolean,
      default: false,
    },
    dialogDetailUpdate: {
      type: Boolean,
      default: false,
    },
    displayAddButton: {
      type: Boolean,
      required: false,
      default: true,
    },
    titleDatatable: {
      type: String,
      default: "Titre du datatable",
      required: false,
    },
    functionEditItem: {
      type: Function,
    },
    functionDeleteItem: {
      type: Function,
    },
    functionOnClickAddButton: {
      type: Function,
      required: false,
    },
    functionOnConfirmDeleting: {
      type: Function,
      required: false,
    },
    functionOnSaveAdding: {
      type: Function,
      required: false,
    },
    maxWidthAddDialog: { type: String, default: "700px", required: false },
  },
  components: {
    ModalDetailUpdate,
    mdiDelete,
    mdiAccount,
    mdiPencil,
    mdiPlus,
    mdiCancel,
    mdiContentSaveEditOutline,
  },

  data() {
    return {
      selected: [],
      pagination: null,
      dialog: false,
      status: false,
      alert: true,
      onDetailUpdate: false,
      searchQuery: null,
      dialogDelete: false,
      toolbarTitle: "Détail",
      icons: {
        mdiAccount,
        mdiMagnify,
        mdiDelete,
        mdiPencil,
        mdiPlus,
        mdiCancel,
        mdiContentSaveEditOutline,
      },

      detailEdit: -1,
      editedIndex: -1,
      isEditingModal: null,
    };
  },

  mounted() {},
  computed: {
    scopedSlots() {
      return this.$slots;
    },
    modelEditedObject: {
      get() {
        return this.editedObject;
      },
      set(newValue) {
        this.$emit("input", newValue);
      },
    },
    defaultItem() {
      return this.modelEditedObject;
    },

    formTitle() {
      return "Ajout d'une nouvelle ligne";
      // return this.editedIndex === -1 ? "Ajouter une ligne" : "Modifier une ligne";
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
    //Fonction en ecoute lorsqu'on clique sur le bouton 'Ajouter'
    onClickAddButton() {
      if (this.addDialog) {
        this.dialog = true;
      } else {
        return this.functionOnClickAddButton();
      }
    },
    initialize() {
      this.items;
    },
    //Fonction en ecoute lorsqu'on clique sur l'icon 'Modifier'
    onEditItem(item) {
      console.log("datatable:", item);
      this.functionEditItem(item);
    },
    onClickCancelButtonForEditing() {
      this.onDetailUpdate = false;
    },
    //Fonction en ecoute lorsqu'on clique sur l'icon 'Supprimer'
    onDeleteItem(item) {
      this.editedIndex = this.items.indexOf(item);
      this.modelEditedObject = Object.assign({}, item);

      this.dialogDelete = true;

      this.functionDeleteItem(item);
    },
    save() {
      this.dialog = false;
      this.functionOnSaveAdding();
    },

    deleteItemConfirm() {
      this.functionOnConfirmDeleting();
      this.closeDelete();
    },

    close() {
      this.dialog = false;
    },

    closeDelete() {
      console.log("delete");
      this.dialogDelete = false;
    },
  },
};
</script>

<template>
  <v-data-table
    :headers="headers"
    :items="items"
    :search="searchQuery"
    item-key="id"
    :pagination.sync="pagination"
    class="style-table"
  >
    <template v-slot:top>
      <v-toolbar flat color="white">
        <v-toolbar-title
          style="
            font-size: 1em;
            width: 250px;
            word-wrap: break-word;
            white-space: pre-wrap;
            word-break: break-word;
          "
        >
          <p class="text-wrap">
            {{ titleDatatable }}
          </p>
        </v-toolbar-title>

        <v-divider class="mx-4 color-secondary" inset vertical></v-divider>
        <div style="width: 250px">
          <TextField
            density="compact"
            variant="solo"
            label="Rechercher"
            v-model="searchQuery"
            placeholder="Rechercher..."
            class="search-field"
            :icon="icons.mdiMagnify"
            single-line
            hide-details
          ></TextField>
        </div>

        <v-spacer></v-spacer>

        <Button
          v-if="displayAddButton == true"
          variant="flat"
          style="height: 30px; text-transform: none; box-shadow: 10px 5px 5px #7d002c"
          class="add-button-style"
          nameButton="Ajouter"
          title="Ajouter une nouvelle ligne"
          :prependIcon="icons.mdiPlus"
          @click="onClickAddButton"
        >
        </Button>
        <!-- <ModalDetailUpdate
          :onClickCancelButton="onClickCancelButtonForEditing"
          :toolbarTitle="toolbarTitle"
          :dialogDetailUpdate="dialogDetailUpdate"
          :isEditing="isEditingModal"
          :iconValueDetail="icons.mdiPencil"
          :iconUpdate="icons.mdiAccount"
        ></ModalDetailUpdate> -->
        <v-dialog v-model="dialog" max-width="900px" persistent>
          <!-- <template v-slot:activator="{ props }">
            <Button
              variant="flat"
              class="mb-2"
              nameButton="Ajouter"
              title="Ajouter une nouvelle ligne"
              style="height: 30px; text-transform: none"
              :prependIcon="icons.mdiPlus"
              v-bind="props"
            >
            </Button>
          </template> -->
          <v-card>
            <v-card-title style="background-color: #7d002c">
              <span class="text-h5 text-white">{{ formTitle }}</span>
            </v-card-title>

            <slot name="addDialogContent" />
            <v-card-actions class="card-actions-style">
              <Button
                variant="text"
                class="mb-2"
                color="red"
                nameButton="Annuler"
                title="Annuler et Fermer la modale"
                style="height: 30px"
                :prependIcon="icons.mdiCancel"
                @click="close"
              ></Button>
              <Button
                variant="text"
                class="mb-2"
                nameButton="Enregistrer"
                title="Valider et Fermer la modale"
                style="height: 30px"
                :prependIcon="icons.mdiContentSaveEditOutline"
                @click="save"
              ></Button>
            </v-card-actions>
          </v-card>
          <slot />
        </v-dialog>
        <v-dialog v-model="dialogDelete" max-width="500px" persistent>
          <v-card>
            <v-card-title style="background-color: #7d002c" class="text-h5 text-white"
              >Confirmation de la suppression</v-card-title
            >
            <v-card-text>Etes-vous de vouloir supprimer la ligne : </v-card-text>
            <v-card-actions class="card-actions-style">
              <Button
                variant="text"
                class="mb-2"
                color="red"
                nameButton="Annuler"
                title="Annuler et Fermer la modale"
                style="height: 30px"
                @click="closeDelete"
              ></Button>

              <Button
                variant="flat"
                class="mb-1"
                nameButton="Oui"
                title="Confirmer et Fermer la modale"
                style="height: 30px"
                :onClickButton="deleteItemConfirm"
              ></Button>

              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
      <v-card outlined height="3px" color="secondary"></v-card>
    </template>

    <!-- <template v-slot:item="{ item }">
      {{ itemRowBackground(item) }}
      </slot>
    </template> -->
    <template v-slot:item.actions="{ item }">
      <!-- <div style="background-color: red"> -->
      <v-icon
        size="small"
        class="me-2"
        title="Modifier la ligne"
        @click="onEditItem(item.raw)"
        :icon="icons.mdiPencil"
        color="orange"
      >
      </v-icon>
      <v-icon
        size="small"
        color="red"
        title="Supprimer la ligne"
        @click="onDeleteItem(item.raw)"
        :icon="icons.mdiDelete"
      >
      </v-icon>
      <!-- </div> -->
    </template>
    <template v-slot:no-data>
      <div>
        <v-alert
          v-model="alert"
          border="start"
          variant="tonal"
          closable
          close-label="Close Alert"
          color="secondary"
          title="Note"
        >
          Aucune donnée disponible
        </v-alert>

        <div v-if="!alert" class="text-center">
          <v-btn
            color="primary"
            @click="alert = true"
            style="text-decoration: none; text-transform: none"
          >
            Réinitialiser</v-btn
          >
        </div>
      </div>
    </template>
    <template class="slot-style" v-for="(index, name) in $slots" v-slot:[name]>
      <div><slot :name="name"></slot></div>
    </template>
    <template
      class="slot-data-style"
      v-for="(index, name) of $slots"
      v-slot:[name]="data"
    >
      <div><slot :name="name" v-bind="data"></slot></div>
    </template>
  </v-data-table>
</template>

<style>
.v-table .v-table__wrapper > table > tbody > tr:nth-of-type(odd) > td,
.v-table .v-table__wrapper > table > tbody > tr:nth-of-type(odd) > th {
  /* background: #7d002c; */
  background: #808080;
  /* background: #bfdfff; */
}

.v-table .v-table__wrapper > table > tbody > tr:nth-of-type(even) > td,
.v-table .v-table__wrapper > table > tbody > tr:nth-of-type(even) > th {
  /* background: #004980; */
  background: #5a5a5a;
  /* background: #003f7d; */
}
tbody tr:nth-of-type(odd) {
  /* 'teal lighten-5' basides on material design color */
  color: white;
}

tbody tr:nth-of-type(even) {
  /* 'deep-orange lighten-5' basides on material design color */
  color: white;
}

.add-button-style:hover {
  background-color: #7d002c;
  box-shadow: 0px 0px 8px #7d002c;
  transform: scale(1.05);
  cursor: pointer;
}

/* .add-button-style {
  height: 30px;
  text-transform: none;
  box-shadow: 10px 5px 5px #7d002c;
} */

.search-field {
  border: 1px solid #7d002c;
  border-radius: 4px;
}

.style-table {
  border: 2px solid #7d002c;
  padding: 10px;
  border-radius: 25px;
  margin-left: 10px;
  width: 98%;
}

.card-actions-style {
  display: flex;
  justify-content: flex-end;
  margin-left: auto;
  flex: none;
  min-height: 52px;
  padding: 0.5rem;
}
</style>
