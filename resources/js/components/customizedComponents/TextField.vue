<script>
import { ref } from "vue";

export default {
  props: {
    vModel: [String, Number],
    type: {
      type: String,
      default: "text",
    },
    variant: {
      type: String,
      default: "outlined",
    },
    hint: {
      type: String,
      default: "",
    },
    density: {
      type: String,
      default: "compact",
    },
    maxHeightResponsive: {
      type: Number,
      required: false,
      // default: 100,
    },
    heightResponsive: {
      type: Number,
      required: false,
    },
    classResponsive: {
      type: String,
      default: "py-2",
    },
    maxWidthResponsive: {
      type: Number,
      required: false,
      // default: 250,
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
      default: "Label",
    },
    conditionDisabled: {
      type: String,
      required: false,
    },

    icon: {
      type: String,
      required: false,
    },
    appendIcon: {
      type: String,
      required: false,
    },
    successMessage: {
      type: String,
      required: false,
    },
    placeholder: {
      type: String,
      default: "",
    },
    rules: {
      type: [Object, String],
      required: false,
    },
    // errorMessageValue: {
    //   type: [Object, String],
    //   required: false,
    // },
    onchangeModelValue: { type: Function },
    onchangeField: { type: Function },
    class: { type: String, required: false },
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
      v-model="modelValue"
      :variant="variant"
      :hint="hint"
      :density="density"
      v-bind="$attrs"
      :name="name"
      :placeholder="placeholder"
      :rules="rules"
      :base-color="baseColorValue"
      :color="colorValue"
      @change="onchangeField"
      :class="class"
      :append-icon="appendIcon"
      :type="type"
    >
      <template #label v-if="isRequired">
        <span id="required-field">{{ label }} <slot /></span>
      </template>
      <template #label v-else>
        {{ label }}
      </template>
      <slot />
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
