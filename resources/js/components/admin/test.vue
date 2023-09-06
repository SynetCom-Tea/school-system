<template>
    <form @submit.prevent="submitForm">
      <div>
        <label for="nom">Nom :</label>
        <input type="text" id="nom" v-model="form.nom" />
      </div>
      <div>
        <label for="email">Email :</label>
        <input type="email" id="email" v-model="form.email" />
      </div>
      <button type="submit">Soumettre</button>
    </form>
  </template>
  
  <script>
   import { router,useForm} from '@inertiajs/vue3';
  export default {
    data() {
      return {
        form: useForm({
            nom: '',
            email: '',
        }),
       
      };
    },
    methods: {
      submitForm() {
        this.$emit('formSubmitted', this.form);
      },
    },
  };
  </script>
  