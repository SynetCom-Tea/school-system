<script setup>
import { onMounted, ref } from "vue";
import { useField, useForm } from "vee-validate";

// import { ValidationProvider, extend } from "vee-validate";
defineProps({
  modelValue: {
    type: String,
    required: true,
  },
});

defineEmits(["update:modelValue"]);

const input = ref(null);

onMounted(() => {
  if (input.value.hasAttribute("autofocus")) {
    input.value.focus();
    console.log("input1:", input);
  }
  console.log("input:", input);
});

defineExpose({ focus: () => input.value.focus() });

const onChangeText = (e) => {
  console.log("e from onChangeText:", e);
};
</script>

<template>
  <v-text-field
    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
    v-model="test"
    @change="onChangeText"
    ref="input"
  />
  <span>{{ modelValue }}</span>
</template>
