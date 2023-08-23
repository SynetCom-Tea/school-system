<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import TextInput from "../components/customizedComponents/TextField.vue";
import { Vue3Marquee } from "vue3-marquee";
const test = "Abou";
const listGreetings = [
  { id: 1, text: "Wa fonda kayan!", color: "red" },
  { id: 2, text: "Barka da zouwa!", color: "blue" },
  { id: 3, text: "Bienvenue!", color: "gray" },
  { id: 1, text: "Welcome!", color: "green" },
  { id: 1, text: "Marhaba!", color: "red" },
];
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </template>
    <div class="mt-10">
      <Vue3Marquee :duration="25">
        <v-row>
          <v-col
            :cols="12 / listGreetings.length"
            v-for="item in listGreetings"
            :key="item.id"
            style="cursor:' pointer"
          >
            <v-hover v-slot="{ isHovering, props }" open-delay="200">
              <v-card
                :elevation="isHovering ? 4 : 2"
                :color="isHovering ? 'primary' : 'undefined'"
                :class="{ 'on-hover': isHovering }"
                height="70"
                max-width="300"
                v-bind="props"
              >
                <v-card-text class="defile"> </v-card-text>{{ item.text }}</v-card
              >
            </v-hover>
          </v-col>
          &nbsp;&nbsp;
        </v-row>
      </Vue3Marquee>
    </div>
  </AuthenticatedLayout>
</template>
<style scoped>
.defile {
  font-family: monospace;
  font-size: 3em;
  animation: color-change 1s infinite;
}

@keyframes color-change {
  0% {
    color: red;
  }
  50% {
    color: blue;
  }
  100% {
    color: red;
  }
}
</style>
