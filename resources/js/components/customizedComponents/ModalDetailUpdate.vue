<script>
import {
  mdiDelete,
  mdiPencil,
  mdiPlus,
  mdiCancel,
  mdiMagnify,
  mdiContentSaveEditOutline,
} from "@mdi/js";
export default {
  components: { mdiCancel, mdiContentSaveEditOutline },
  props: {
    toolbarTitle: {
      type: String,
      default: "text",
    },
    dialogDetailUpdate: {
      type: Boolean,
      default: false,
    },
    iconUpdate: {
      type: String,
      required: false,
    },
    iconValueDetail: {
      type: String,
      required: false,
    },
    titleSubmittingButton: {
      type: String,
      default: "Enregistrer",
    },
    messageSnackbar: {
      type: String,
      default: "Modification réussie",
    },
    onClickSaveButton: { type: Function },
    onClickCancelButton: { type: Function },
  },

  data: () => ({
    hasSaved: false,
    isEditing: null,
    icons: {
      mdiMagnify,
      mdiDelete,
      mdiPencil,
      mdiPlus,
      mdiCancel,
      mdiContentSaveEditOutline,
    },
  }),
  updated() {},
  computed: {
    modelValue: {
      get() {
        return this.dialogDetailUpdate;
      },
      set(newValue) {
        this.$emit("input", newValue);
      },
    },
  },
  methods: {
    onchangeModelField(e) {
      console.log("EEEE:", e);
    },
    customFilter(itemTitle, queryText, item) {
      const textOne = item.raw.name.toLowerCase();
      const textTwo = item.raw.abbr.toLowerCase();
      const searchText = queryText.toLowerCase();

      return textOne.indexOf(searchText) > -1 || textTwo.indexOf(searchText) > -1;
    },
    testChange(e) {
      console.log("e from testChange:", e);
    },
    save() {
      this.isEditing = !this.isEditing;
      this.hasSaved = true;
      this.onClickSaveButton();
    },
  },
};
</script>
<template>
  <v-dialog v-model="modelValue" max-width="500px" persistent>
    <v-card class="mx-auto" max-width="500">
      <v-toolbar flat color="primary">
        <v-toolbar-title class="font-weight-light">
          {{ toolbarTitle }}
        </v-toolbar-title>

        <v-spacer></v-spacer>

        <v-btn icon @click="isEditing = !isEditing">
          <v-fade-transition leave-absolute>
            <v-icon v-if="isEditing" :icon="iconValueDetail"></v-icon>

            <v-icon v-else :icon="iconUpdate"></v-icon>
          </v-fade-transition>
        </v-btn>
      </v-toolbar>

      <v-card-text>
        <v-form :disabled="!isEditing">
          <slot name="contentForm" />
          <slot />
        </v-form>
      </v-card-text>

      <v-divider></v-divider>

      <v-card-actions class="card-actions-style">
        <Button
          variant="text"
          class="mb-2"
          color="red"
          nameButton="Annuler"
          title="Annuler et Fermer la modale"
          style="height: 30px"
          :prependIcon="icons.mdiCancel"
          :onClickButton="onClickCancelButton"
        ></Button>

        <Button
          variant="text"
          class="mb-2"
          nameButton="Enregistrer"
          title="Valider et Fermer la modale"
          style="height: 30px"
          :disabled="!isEditing"
          :prependIcon="icons.mdiContentSaveEditOutline"
          :onClickButton="save"
        ></Button>
      </v-card-actions>

      <v-snackbar
        v-model="hasSaved"
        :timeout="2000"
        attach
        position="absolute"
        location="bottom left"
      >
        {{ messageSnackbar }}
      </v-snackbar>
      <slot />
    </v-card>
  </v-dialog>
</template>
<style scoped>
.card-actions-style {
  display: flex;
  justify-content: flex-end;
  margin-left: auto;
  flex: none;
  min-height: 52px;
  padding: 0.5rem;
}
</style>
