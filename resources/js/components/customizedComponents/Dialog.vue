<script>
import {
  mdiAccount,
  mdiClose,
  mdiPurse,
  mdiHomeOutline,
  mdiPresentation,
  mdiGift,
} from "@mdi/js";

export default {
  components: {
    mdiAccount,
    mdiPurse,
    mdiClose,
    mdiHomeOutline,
    mdiPresentation,
    mdiGift,
  },
  props: {
    modelDialog: { type: Boolean, default: false },
    isfullscreen: { type: Boolean, default: false, required: false },
    toolbarTitle: {
      type: String,
      default: "Titre de la modale",
    },
    onCloseModale: { type: Function },
    heightDialog: {
      type: Number,
      default: 300,
    },
    widthDialog: {
      type: Number,
      default: 300,
    },
    iconHeaderModal: {
      type: String,
      required: false,
      default: "",
    },
    transitionType: {
      type: String,
      required: false,
      default: "",
    },
  },
  data() {
    return {
      icons: { mdiClose, mdiAccount },
      //dialog: false,
      notifications: false,
      sound: true,
      widgets: false,
    };
  },
  computed: {
    dialog: {
      get() {
        return this.modelDialog;
      },
      set(newValue) {
        this.$emit("input", newValue);
      },
    },
  },
};
</script>

<template>
  <v-card v-if="modelDialog" :width="widthDialog">
    <v-dialog
      v-model="dialog"
      :fullscreen="isfullscreen"
      scrollable
      :scrim="false"
      :width="widthDialog"
      :height="heightDialog"
    >
      <v-card>
        <v-toolbar dark color="primary">
          <Button
            title="Icon de la modale"
            variant="flat"
            :prependIcon="iconHeaderModal"
            size="x-large"
          ></Button>

          <v-toolbar-title
            style="
              font-size: 1em;
              width: 100px;
              word-wrap: break-word;
              white-space: pre-wrap;
              word-break: break-word;
            "
          >
            {{ toolbarTitle }}
          </v-toolbar-title>

          <v-toolbar-items>
            <Button
              title="Fermer la modale"
              fab
              variant="flat"
              :prependIcon="icons.mdiClose"
              @click="onCloseModale"
            ></Button>
          </v-toolbar-items>
        </v-toolbar>
        <!-- content -->
        <v-card-text>
          <!-- Modal content with form -->
          <slot name="content"></slot>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <div
            class="mt-4"
            style="
              position: absolute;
              bottom: 0;
              left: 0;
              width: 100%;
              background-size: cover;
            "
          >
            <slot name="otherButtons"></slot>

            <Button
              title="Fermer la modale"
              variant="text"
              color="red"
              nameButton="Quitter"
              @click="onCloseModale"
              style="float: right; margin: 10px; height: 30px"
            ></Button>
          </div>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-card>
</template>
