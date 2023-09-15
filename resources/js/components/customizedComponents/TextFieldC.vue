<script setup>
import { watch, ref, onMounted, reactive, computed, inject, onUpdated } from "vue";
import { useVuelidate } from "@vuelidate/core";

import { minLength, email, required, numeric, alpha } from "@vuelidate/validators";
import { isNumber, isDateFormat } from "../../utils/commonFunctions.js";
import SaveCancelButtons from "./SaveCancelButtons.vue";
import {
  mdiMagnify,
  mdiDelete,
  mdiPencil,
  mdiPlus,
  mdiCancel,
  mdiContentSaveEditOutline,
} from "@mdi/js";
const props = defineProps({
  item: Object,
  isEditing: Boolean,
  onSubmittingEditedForm: Function,
});
const initialState = {
  ...props.item,
};
// const username=inject('username');

const state = reactive({
  ...initialState,
});
const icons = {
  mdiMagnify,
  mdiDelete,
  mdiPencil,
  mdiPlus,
  mdiCancel,
  mdiContentSaveEditOutline,
};
const rules = computed(() => ({
  name: { required, alpha, minLength: minLength(10) },
  calories: { required, numeric },
  fat: { required, numeric },
  carbs: { required, numeric },
  protein: { required, numeric },
}));

const v$ = useVuelidate(rules, state);
const submitHandler = async () => {
  try {
    const isFormCorrect = v$;
    if (isFormCorrect._value.$errors.length > 0) {
      console.log("Validation échouée");
    }
    if (isFormCorrect._value.$errors.length == 0) {
      console.log("Validation reussie");
    }
  } catch (error) {
    console.warn({ error });
  }
};

function clear() {
  // console.log("count:", count);
  // return count.value++;
  v$.value.$reset();
  for (const [key, value] of Object.entries(initialState)) {
    state[key] = null;
    // state[key] = value;
  }
}
const enableEditing = inject("editing");
const vmodelDialoDU = inject("vmodelDialoDU");

const onClickSaveButton = async (e) => {
  console.log(" onClickSaveButton:", e);
  e.preventDefault();
  await submitHandler();
};
const statusClose = ref(false);
watch(
  [enableEditing, vmodelDialoDU],
  // vmodelDialoDU,
  ([newConfig, newConfigvmodelDialoDU]) => {
    // console.log("config11:", vmodelDialoDU);
    // console.log(" statusClose11:", statusClose);
    if (statusClose) {
      newConfigvmodelDialoDU = false;
    }
    // console.log("newConfig11:", newConfigvmodelDialoDU);
    // console.log("config:", enableEditing);
    // console.log("newConfig:", newConfig);
  },

  { deep: true }
);
function onClickCancelButton(e) {
  console.log("onClickCancelButton12:", vmodelDialoDU);
  e.preventDefault();
  vmodelDialoDU.value = false;
  console.log(" statusClose:", vmodelDialoDU);

  // return (vmodelDialoDU.value = false);
}
</script>

<template>
  <div>
    <form @submit="v$.validate()">
      <v-row
        ><v-col cols="6">
          <TextField
            v-model="state.name"
            hint="Nom est obligatoire"
            :error-messages="
              v$.name.$errors.map((e) => {
                console.log('e from error:', e);
                if (e.$validator == 'required') return 'Le nom est requis';
                if (e.$validator == 'minLength') return 'Au min 10 caractères';
                if (e.$validator == 'alpha') return 'Seuls les lettres sont autorisés';
                return '';
              })
            "
            :isRequired="true"
            label="Nom"
            v-bind="field"
            classResponsive="py-2"
            :maxHeightResponsive="100"
            :onchangeModelValue="onChangeName"
            :maxWidthResponsive="250"
            :counter="10"
            @input="v$.name.$touch"
            @blur="v$.name.$touch"
          ></TextField>
        </v-col>
        <v-col cols="6">
          <TextField
            v-model="state.calories"
            hint="Seuls les chiffres sont autorisés"
            :error-messages="
              v$.calories.$errors.map((e) => {
                console.log('e from error:', e);
                if (e.$validator == 'required') return 'Calories est requis';
                if (e.$validator == 'numeric') return 'Il doit être de type numérique';
                return '';
              })
            "
            v-bind="field"
            classResponsive="py-2"
            :maxHeightResponsive="100"
            :onchangeModelValue="onChangeName"
            :maxWidthResponsive="250"
            v-on:keypress="isNumber($event)"
            label="calories"
            :isRequired="true"
            @input="v$.calories.$touch"
            @blur="v$.calories.$touch"
          ></TextField> </v-col
      ></v-row>
      <v-row>
        <v-col cols="4">
          <TextField
            v-model="state.fat"
            :error-messages="
              v$.fat.$errors.map((e) => {
                console.log('e from error:', e);
                if (e.$validator == 'required') return 'Fat est requis';
                if (e.$validator == 'numeric') return 'Il doit être de type numérique';
                return '';
              })
            "
            label="Fat"
            classResponsive="py-2"
            :maxHeightResponsive="100"
            :onchangeModelValue="onChangeName"
            :maxWidthResponsive="250"
            :isRequired="true"
            @change="v$.fat.$touch"
            @blur="v$.fat.$touch"
          ></TextField>
        </v-col>
        <v-col cols="4">
          <TextField
            v-model="state.carbs"
            :error-messages="
              v$.carbs.$errors.map((e) => {
                console.log('e from error:', e);
                if (e.$validator == 'required') return 'Carbs est requis';
                if (e.$validator == 'numeric') return 'Il doit être de type numérique';
                return '';
              })
            "
            label="Carbs"
            classResponsive="py-2"
            :maxHeightResponsive="100"
            :onchangeModelValue="onChangeName"
            :maxWidthResponsive="250"
            :isRequired="true"
            @change="v$.carbs.$touch"
            @blur="v$.carbs.$touch"
          ></TextField>
        </v-col>
        <v-col cols="4">
          <TextField
            v-model="state.protein"
            :error-messages="
              v$.protein.$errors.map((e) => {
                if (e.$validator == 'required') return 'protein est requis';
                if (e.$validator == 'numeric') return 'Il doit être de type numérique';
                return '';
              })
            "
            label="protein"
            :isRequired="true"
            classResponsive="py-2"
            :maxHeightResponsive="100"
            :onchangeModelValue="onChangeName"
            :maxWidthResponsive="250"
            @blur="v$.protein.$touch"
          ></TextField>
        </v-col>
      </v-row>

      <v-btn
        id="count"
        :disabled="!enableEditing"
        @click="clear()"
        color="primary"
        style="
          text-transform: none;
          float: left;
          margin-right: 0px;
          margin-left: auto;
          color: #004980;
        "
      >
        Réinitialiser</v-btn
      >
    </form>

    <br />
    <br />
    <v-divider></v-divider>
    <v-card-actions class="card-actions-style">
      <SaveCancelButtons
        :isEditing="enableEditing"
        :onClickCancelButton="onClickCancelButton"
        :onClickSaveButton="onClickSaveButton"
      />
    </v-card-actions>
  </div>
</template>
<style scoped>
.card-actions-style {
  display: flex;
  justify-content: flex-end;
  margin-left: auto;
  flex: none;
  min-height: 52px;
  padding: 0.5rem;
}
</style>
