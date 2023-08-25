<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import FiltreAffichageNote from "@/Components/Gestion-note/FiltreAffichageNote.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps(['classes'])
 
</script>

<template>
  <Head title="Notes" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Attribution de notes</h2>
    </template>

    <v-card style="margin: 20px">
      <v-card-title>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">Affichage de notes</div>
          </div>
        </div>
      </v-card-title>
    </v-card>

    <v-card style="margin: 20px">
      <v-card-title>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">Choisissez les criteres</div>
          </div>
        </div>
      </v-card-title>
      <FiltreAffichageNote :classes="props.classes"></FiltreAffichageNote>
    </v-card>
  </AuthenticatedLayout>
</template>

