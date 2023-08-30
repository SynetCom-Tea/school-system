<script>
import { ref } from "vue";
import { useField, useForm } from "vee-validate";
import * as yup from "yup";
import fr from "@vee-validate/i18n/dist/locale/fr.json";
import { defineRule, Form, Field, ErrorMessage, configure } from "vee-validate";
import { required, between, confirmed } from "@vee-validate/rules";
import { localize, loadLocaleFromURL, setLocale } from "@vee-validate/i18n";

configure({
  generateMessage: localize({
    fr,
  }),
});

// Load locale from URL
loadLocaleFromURL("https://unpkg.com/@vee-validate/i18n@4.1.0/dist/locale/fr.json");

export default {
  props: {
    value: [String, Number],
    type: {
      type: String,
      default: "text",
    },
    name: {
      type: String,
      required: false,
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
    onchangeField: { type: Function },
    classLabel: { type: String, default: "defaultClassLabel" },
    isRequired: { type: Boolean, default: false },
  },
  setup() {
    const validationSchema = yup.object().shape({
      email: yup.string().email().required("champ requis"),
      password: yup
        .string()
        .min(8, "Le mot de passe ne doit pas exceder 8 caractères")
        .required("La mot de passe est requis"),
    });

    const { handleSubmit, handleReset } = useForm({
      validationSchema,
    });

    const email = useField("email", validationSchema);
    const password = useField("password", validationSchema);

    const onSubmit = handleSubmit(async (values) => {
      console.log("validationSchema:", validationSchema);
      alert(JSON.stringify(values, null, 2));
    });

    return { email, password, onSubmit, handleReset };
  },
  updated() {
    console.log("validationSchema:", this.validationSchema);
  },
};
</script>
<template>
  <form @submit.prevent="onSubmit">
    <v-text-field
      label="Identifiant"
      v-model="email.value.value"
      :error-messages="email.errorMessage.value"
    ></v-text-field>
    <br />
    <v-text-field
      type="password"
      v-model="password.value.value"
      :error-messages="password.errorMessage.value"
    >
      <template #label v-if="isRequired">
        <span id="required-field">{{ label }}</span>
      </template>
    </v-text-field>
    <v-btn color="primary" type="submit">Submit</v-btn>
  </form>
</template>
<style scoped>
#required-field::after {
  content: "*";
  color: red;
}
</style>
