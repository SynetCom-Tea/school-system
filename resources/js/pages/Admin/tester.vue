<template>
    <AuthenticatedLayout>
    <div>
      <h1>Utilisation du formulaire</h1>
      <my-form @formSubmitted="handleFormSubmission" />
    </div>
    </AuthenticatedLayout>
  </template>
  
  <script>
  import MyForm from '@/components/admin/test.vue';
  import AuthenticatedLayout from "@/layouts/AuthenticatedLayout.vue";
  export default {
    components: {
      MyForm,
      AuthenticatedLayout
    },
    methods: {
      handleFormSubmission(formData) {
        // Traitez les données du formulaire soumises par l'événement
        console.log('Données du formulaire soumises :', formData);
      },
    },
  };
  </script>
  