<script>
import { ref } from "vue";

export default {
  props: {
    vModel: [String, Number],
    type: {
      type: String,
      default: "text",
    },
    variantValue: {
      type: String,
      default: "outlined",
    },
    hintValue: {
      type: String,
      default: "",
    },
    densityValue: {
      type: String,
      default: "compact",
    },
    maxHeightResponsive: {
      type: Number,
      default: "",
    },
    heightResponsive: {
      type: Number,
      default: "",
    },
    classResponsive: {
      type: String,
      default: "py-4",
    },
    maxWidthResponsive: {
      type: Number,
      default: "",
    },
    name: {
      type: String,
      required: false,
    },
    baseColorValue: {
      type: String,
      default: "primary",
    },
    colorValue: {
      type: String,
      default: "primary",
    },
    label: {
      type: String,
      required: true,
    },
    conditionDisabled: {
      type: String,
      required: false,
    },

    icon: {
      type: String,
      default: "",
    },
    successMessage: {
      type: String,
      default: "",
    },
    placeholder: {
      type: String,
      default: "",
    },
    rules: {
      type: [Object, String],
      default: "",
    },
    errorMessageValue: {
      type: [Object, String],
      default: "",
    },
    onchangeField: { type: Function },
    classLabel: { type: String, default: "defaultClassLabel" },
    isRequired: { type: Boolean, default: false },
  },
  setup() {},
  updated() {},
  computed: {
    modelValue: {
      get() {
        return this.vModel;
      },
      set(newValue) {
        this.$emit("input", newValue);
      },
    },
  },
};
</script>
<template>
  <v-responsive
    :class="classResponsive"
    :height="heightResponsive"
    :max-height="maxHeightResponsive"
    :max-width="maxWidthResponsive"
  >
    <v-text-field
      :type="type"
      v-model="modelValue"
      :variant="variantValue"
      :hint="hintValue"
      :density="densityValue"
      v-bind="$attrs"
      :name="name"
      :placeholder="placeholder"
      :rules="rules"
      :prepend-inner-icon="icon"
      :base-color="baseColorValue"
      :color="colorValue"
      @change="onchangeField"
      :error-messages="errorMessageValue"
    >
      <template #label v-if="isRequired">
        <span id="required-field">{{ label }}</span>
      </template>
      <template #label v-else>
        {{ label }}
      </template>
    </v-text-field>
  </v-responsive>
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
