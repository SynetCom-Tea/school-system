<script>
import { ref, computed } from "vue";

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
    colorValue: {
      type: String,
      default: "primary",
    },
    label: {
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
    search: {
      type: String,
      default: "",
    },
    rules: {
      type: [Object, String],
      required: false,
    },
    errorMessageValue: {
      type: [Object, String],
      required: false,
    },
    onchangeModelValue: { type: Function },
    customFilter: { type: Function },
    class: { type: String, required: false },
    style: { type: Object, required: false },
    isRequired: { type: Boolean, default: false },
  },
  setup(props, ctx) {
    const parentSlots = computed(() => Object.keys(ctx.slots));

    return { parentSlots };
  },
  updated() {},
  computed: {
    scopedSlots() {
      return this.$slots;
    },
    modelValue: {
      get() {
        return this.vModel;
      },
      set(newValue) {
        this.$emit("input", newValue);
      },
    },
    modelSearch: {
      get() {
        return this.search;
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
    <v-autocomplete
      :variant="variant"
      :hint="hint"
      :density="density"
      v-bind="$attrs"
      :custom-filter="customFilter"
      :style="style"
      :class="class"
      :placeholder="placeholder"
      :rules="rules"
      :prepend-inner-icon="icon"
      :base-color="baseColorValue"
      :color="colorValue"
    >
      <template #label v-if="isRequired">
        <span id="required-field">{{ label }}</span>
      </template>
      <template #label v-else>
        {{ label }}
      </template>
      <template v-for="slot in parentSlots" #[slot]>
        <slot :name="slot" />
      </template>
    </v-autocomplete>
  </v-responsive>
</template>
<style scoped>
#required-field::after {
  content: "*";
  color: red;
}
</style>
