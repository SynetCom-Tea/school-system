<script>
import { ref } from "vue";

export default {
  props: {
    vModel: [String, Number],
    items: {
      type: Array,
      default: [],
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
    },
    heightResponsive: {
      type: Number,
      required: false,
    },
    classResponsive: {
      type: String,
      default: "py-1",
    },
    maxWidthResponsive: {
      type: Number,
      required: false,
    },
    itemTitle: {
      type: String,
      required: false,
    },
    itemValue: {
      type: String,
      required: false,
    },
    baseColorValue: {
      type: String,
      default: "primary",
    },
    color: {
      type: String,
      default: "primary",
    },
    label: {
      type: String,
      required: true,
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
      required: false,
    },
    // errorMessageValue: {
    //   type: [Object, String],
    //   required: false,
    // },
    onchangeModelValue: { type: Function },
    customFilter: { type: Function },
    classLabel: { type: String, required: false },
    style: { type: String },
    isRequired: { type: Boolean, default: false },
    isMultiple: { type: Boolean, default: false },
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
//  @update:modelValue="onchangeModelValue"
</script>
<template>
  <v-responsive
    :class="classResponsive"
    :height="heightResponsive"
    :max-height="maxHeightResponsive"
    :max-width="maxWidthResponsive"
  >
    <v-select
      :items="items"
      :item-title="itemTitle"
      :item-value="itemValue"
      :variant="variant"
      :hint="hint"
      :density="density"
      v-bind="$attrs"
      :custom-filter="customFilter"
      :style="style"
      :placeholder="placeholder"
      :rules="rules"
      :prepend-inner-icon="icon"
      :base-color="baseColorValue"
      :color="color"
    >
      <template #label v-if="isRequired">
        <span id="required-field">{{ label }}</span>
      </template>
      <template #label v-else>
        {{ label }}
      </template>
      <slot />
    </v-select>
  </v-responsive>
</template>
<style scoped>
#required-field::after {
  content: "*";
  color: red;
}
</style>
