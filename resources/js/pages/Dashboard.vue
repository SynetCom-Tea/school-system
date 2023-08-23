<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import TextInput from "../components/customizedComponents/TextField.vue";

const test = "Abou";
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </template>

    <v-card style="margin: 20px; height: 100%">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">You're logged in!</div>
        </div>
      </div>
      <v-card> <TextInput :modelValue="test" /></v-card>
    </v-card>
  </AuthenticatedLayout>
</template>
