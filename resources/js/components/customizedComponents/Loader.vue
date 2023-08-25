<script>
import { VueSpinner, VueSpinnerHourglass } from "vue3-spinners";
export default {
  components: {
    VueSpinnerHourglass,
    VueSpinner,
  },
  props: { modelDialog: { type: Boolean, default: false, required: false } },
  data() {
    return {
      //   dialog: false,
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
  watch: {
    // dialog(val) {
    //   if (!val) return;
    //   setTimeout(() => (this.modelDialog = false), 4000);
    // },
  },
};
</script>

<template>
  <div v-if="modelDialog" class="text-center" style="width: 200px">
    <v-dialog v-model="dialog" :scrim="false" persistent width="200">
      <v-card color="primary">
        <v-card-text>
          <span
            style="
              font-size: 1em;
              width: 100px;
              word-wrap: break-word;
              white-space: pre-wrap;
              word-break: break-word;
            "
            >Chargement des données. Veuillez patienter!</span
          >
          <div class="text-center" v-show="dialog">
            <VueSpinnerHourglass size="50" color="white" />
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>
