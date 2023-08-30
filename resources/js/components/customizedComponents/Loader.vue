<script>
import { VueSpinner, VueSpinnerHourglass } from "vue3-spinners";
export default {
 components: {
    VueSpinnerHourglass,
    VueSpinner,
    },
  data() {
    return {
      dialog: false,
    };
  },

  watch: {
    dialog(val) {
      if (!val) return;
      setTimeout(() => (this.dialog = false), 4000);
    },
  },
};
</script>

<template>
  <div class="text-center">
    <v-btn
      :disabled="dialog"
      :loading="dialog"
      color="purple-darken-2"
      @click="dialog = true"
    >
      Start loading
    </v-btn>
    <v-dialog v-model="dialog" :scrim="false" persistent width="auto">
      <v-card color="primary">
        <v-card-text>
          Please stand by
        <VueSpinnerHourglass size="80" color="primary" />
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>
