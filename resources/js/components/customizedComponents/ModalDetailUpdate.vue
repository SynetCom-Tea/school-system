<script>
import {
  mdiDelete,
  mdiPencil,
  mdiPlus,
  mdiCancel,
  mdiMagnify,
  mdiAccount,
  mdiContentSaveEditOutline,
} from "@mdi/js";
import { computed, provide, onUpdated } from "vue";
export default {
  components: { mdiPencil, mdiAccount, mdiCancel, mdiContentSaveEditOutline },
  props: {
    dialogDetailUpdate: {
      type: Boolean,
      default: false,
    },
    iconUpdate: {
      type: String,
      default: mdiPencil,
    },
    iconValueDetail: {
      type: String,
      default: mdiAccount,
    },
    titleSubmittingButton: {
      type: String,
      default: "Enregistrer",
    },

    onClickCloseDialog: { type: Function },
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
  // provide('isEditing', modelValueIsEditing ),

  updated() {},
  watch: {},
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
        this.$emit("value", newValue);
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
  },
  //  provide('vmodelDialoDU', this.modelValue)
  provide() {
    return {
      editing: computed(() => this.modelValueIsEditing),
      vmodelDialoDU: computed(() => this.modelValue),
    };
  },
};
</script>
<template>
  <v-dialog v-model="modelValue" max-width="700" persistent>
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
        <template v-slot:prepend>
          <v-btn
            outlined
            icon="$close"
            fab
            color="white"
            title="Fermer la modale"
            @click="onClickCloseDialog"
          ></v-btn>
        </template>
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

      <slot />
    </v-card>
  </v-dialog>
</template>
<style scoped>
.card-actions-style {
  float: right;
  margin-right: 0px;
  margin-left: auto;
  height: 52px;
}
</style>
