<script setup>
import { reactive, computed,inject } from "vue";
import { useVuelidate } from "@vuelidate/core";
import { minLength, email, required, numeric, alpha } from "@vuelidate/validators";
import { isNumber,isDateFormat } from "../../utils/commonFunctions.js";
 import  {
      mdiMagnify,
      mdiDelete,
      mdiPencil,
      mdiPlus,
      mdiCancel,
      mdiContentSaveEditOutline,
    } from "@mdi/js";
const props = defineProps({
  item: Object,
  onSubmittingEditedForm: Function,
});
const initialState = {
  ...props.item,
};
// const username=inject('username');

const state = reactive({
  ...initialState,
});
const  icons= {
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
  fat: { required, numeric},
  carbs: { required, numeric },
  protein: { required, numeric },
}));
const v$ = useVuelidate(rules, state);
const submitHandler = async () => {
  try {

    const isFormCorrect = v$
     if(isFormCorrect._value.$errors.length>0)
    {console.log('Validation échouée')}
      if(isFormCorrect._value.$errors.length==0)
    {console.log('Validation reussie')}
  } catch (error) {
    console.warn({error})
  }
}


function clear() {
  v$.value.$reset();
  for (const [key, value] of Object.entries(initialState)) {
    state[key] = null;
    // state[key] = value;
  }
}
</script>

<template>
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
      style="float: left; margin-right: 0px; margin-left: auto; color: #004980"
      @click="clear"
    >
      Réinitialiser</v-btn
    >

  </form>


     <!-- <v-row>
    <div class="card-actions-style">
    <br>
        <Button
          variant="text"
          class="mb-2"
          color="red"
          nameButton="Annuler"
          title="Annuler et Fermer la modale"
          style="height: 30px"
          :prependIcon="icons.mdiCancel"

        ></Button>

        <Button
          variant="text"
          class="mb-2"
          nameButton="Enregistrer"
          title="Valider et Fermer la modale"
          style="height: 30px"
          :disabled="!isEditing"
          :prependIcon="icons.mdiContentSaveEditOutline"

        ></Button>
      </div>
      </v-row> -->
</template>
<style scoped>
.card-actions-style {
  float: right;
  margin-right: 0px;
  margin-left: auto;
  height: 52px;
}
</style>
