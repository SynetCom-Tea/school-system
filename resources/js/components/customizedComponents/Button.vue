<script>
import { ref } from "vue";

export default {
  props: {
    type: {
      type: String,
      default: "text",
    },
    variantValue: {
      type: String,
      default: "outlined",
    },
    nameButton: {
      type: String,
      default: "Button",
    },
    hintValue: {
      type: String,
      default: "",
    },
    densityValue: {
      type: String,
      default: "compact",
    },
    title: {
      type: String,
      required: false,
    },
    color: {
      type: String,
      default: "primary",
    },
    conditionDisabled: {
      type: String,
      required: false,
    },
    prependIcon: {
      type: String,
      default: "",
    },
    appendIcon: {
      type: String,
      default: "",
    },
    sizeButton: {
      type: String,
      default: "small",
    },
    placeholder: {
      type: String,
      default: "",
    },
    rules: {
      type: [Object, String],
      default: "",
    },

    onClickButton: { type: Function },
    class: { type: String, default: "" },
    isRequired: { type: Boolean, default: false },
    isBlock: { type: Boolean, default: false },
    isLoading: { type: Boolean, default: false },
  },
  setup() {},
  updated() {},
  computed: {},
};
</script>
<template>
  <v-btn
    :type="type"
    :class="class"
    :loading="isLoading"
    :disabled="conditionDisabled"
    :variant="variantValue"
    :density="densityValue"
    v-bind="$attrs"
    :title="title"
    :prepend-icon="prependIcon"
    :append-icon="appendIcon"
    :color="color"
    :size="sizeButton"
    @click="onClickButton"
    :block="isBlock"
  >
    {{ nameButton }}
  </v-btn>
</template>
<style scoped>
#required-field::after {
  content: "*";
  color: red;
}

#app
  > div
  > main
  > div.v-responsive.py-4
  > div.v-responsive__content
  > div
  > div.v-input__control
  > div.v-text-field
  .v-field {
  cursor: text;
  height: 30px;
}
.v-text-field .v-input__control {
  height: 30px;
  min-height: auto !important;
  display: flex !important;
  align-items: center !important;
}
</style>
