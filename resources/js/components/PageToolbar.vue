<script lang="ts">
import { mdiHome } from "@mdi/js";
import { Icon } from "@iconify/vue";
export default {
  components: { Icon },
  props: {
    icon: { default: mdiHome },
    subtitle: { type: String, default: "" },
    typeIcon: { type: String, default: "vicon" },
    dialogModel: { type: Boolean, default: true },
    addCloseButton: { type: Boolean, default: false },
    oncloseDialog: { type: Function },
  },
  data() {
    return {
      closeCard: true,
    };
  },
};
</script>

<template>
  <div v-if="dialogModel">
    <div class="d-flex elevation-1 green lighten-5 rounded align-center px-3">
      <v-card flat append-icon="$close" tile class="flex-grow-1 green lighten-5">
        <template v-slot:append>
          <v-btn
            v-if="addCloseButton"
            outlined
            icon="$close"
            fab
            color="warning"
            title="Fermer la modale"
            @click="oncloseDialog"
          ></v-btn>
        </template>
        <template v-slot:prepend>
          <v-icon v-if="typeIcon == 'vicon'" :icon="icon" color="gray"></v-icon>
          <Icon
            v-if="typeIcon == 'icon'"
            :icon="icon"
            color="green"
            width="30"
            height="30"
          ></Icon>
        </template>
        <template v-slot:title>
          {{ subtitle }}
          <slot></slot>
        </template>
      </v-card>
    </div>
    <v-card outlined width="100%" height="3px" color="rgb(125, 0, 44, 0.75)"></v-card>
  </div>
</template>
<style scoped>
.v-card .v-card-title {
  line-height: 2rem;
  text-wrap: wrap;
}
</style>
