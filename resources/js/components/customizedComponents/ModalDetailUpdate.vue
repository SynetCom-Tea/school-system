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
    // toolbarTitle: {
    //   type: String,
    //   default: "text",
    // },
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
    toolbarTitle: "Détail",
    icons: {
      mdiMagnify,
      mdiDelete,
      mdiPencil,
      mdiPlus,
      mdiCancel,
      mdiContentSaveEditOutline,
    },
    detailUpdateTitle: "",
  }),
  updated() {},
  watch: {
    modelValue(val) {
      console.log("Test:", this.isEditing);
      console.log("verif:", val);
    },
  },
  computed: {
    modelValueIsEditing: {
      get() {
        return this.isEditing;
      },
      set(newValue) {
        this.$emit("input", newValue);
      },
    },

    modelValue: {
      get() {
        return this.dialogDetailUpdate;
      },
      set(newValue) {
        console.log("newValue:", newValue);
        this.$emit("input", newValue);
      },
    },
  },
  methods: {
    onClickTransition() {
      if (this.modelValue) {
        this.isEditing = !this.isEditing;
        this.toolbarTitle = this.isEditing ? "Mise à jour" : "Détail";
      }
    },
    save() {
      this.modelValue = false;
      // this.hasSaved = true;
      if (this.onClickSaveButton) {
        return this.onClickSaveButton();
      }
    },
  },
};
</script>
<template>
  <v-dialog v-model="modelValue" min-width="500" persistent>
    <v-card
      class="mx-auto"
      min-width="500"
      min-height="200"
      max-height="1000"
      max-width="900"
    >
      <v-toolbar flat color="primary">
        <v-toolbar-title class="font-weight-light">
          {{ toolbarTitle }}
        </v-toolbar-title>

        <v-spacer></v-spacer>

        <v-btn icon @click="onClickTransition()">
          <v-fade-transition leave-absolute>
            <v-icon
              v-if="isEditing"
              :icon="iconValueDetail"
              title="Voir le détail"
            ></v-icon>

            <v-icon v-else :icon="iconUpdate" title="Faire une mise à jour"></v-icon>
          </v-fade-transition>
        </v-btn>
      </v-toolbar>

      <v-card-text>
        <v-form :disabled="!isEditing">
          <slot name="contentForm" />
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
  display: absolute;
  bottom: 0;
  top: 0;
  height: 52px;
  /* display: flex;
  justify-content: flex-end;
  margin-left: auto;
  flex: none;
  min-height: 52px;
  padding: 0.5rem; */
}
</style>
