<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router } from "@inertiajs/vue3";
import { mdiPlus, mdiTimetable } from "@mdi/js";
import { Qalendar } from "qalendar";
export default {
  layout: AuthenticatedLayout,
  components: {
    Qalendar,
  },
  props: ["emplois", "events"],
  data() {
    return {
      icon: {
        mdiPlus,
        mdiTimetable,
      },
      // events: [
      //   // ...
      //   {
      //     title: "Advanced algebra",
      //     with: "Chandler Bing",
      //     time: { start: "2023-09-29 12:05", end: "2023-09-29 13:35" },
      //     isEditable: true,
      //     id: "753944708f0f",
      //     colorScheme: 'meetings',
      //     description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores assumenda corporis doloremque et expedita molestias necessitatibus quam quas temporibus veritatis. Deserunt excepturi illum nobis perferendis praesentium repudiandae saepe sapiente voluptatem!"
      //   },
      //   {
      //     title: "Ralph on holiday",
      //     with: "Rachel Greene",
      //     time: { start: "2023-09-20", end: "2023-09-30" },
      //     colorScheme: 'sports',
      //     isEditable: true,
      //     id: "5602b6f589fc"
      //   }
      //   // ...
      // ],
      config: {
        // see configuration section
        dayBoundaries: {
          start: 7,
          end: 15,
        },
        defaultMode: "month",
        style: {
        colorSchemes: {
          meetings: {
            color: '#fff',
            backgroundColor: '#131313',
          },
          sports: {
            color: '#fff',
            backgroundColor: '#ff4081',
          }
        },
      },
      }
    };
  },
  methods: {
    goTo() {
      router.get(route("emplois.create"));
    },
  },
};
</script>
<template>
  <v-card>
    <Toolbar :icon="icon.mdiTimetable" toolbarTitle="Gestion des Emplois"></Toolbar>
    <v-card-text>
      <v-card>
        <button @click="goTo()">
          <v-icon>{{ icon.mdiPlus }}</v-icon> Ajouter
        </button>
      </v-card>
    </v-card-text>
    <Qalendar
      :selected-date="new Date()"
      :events="events"
      :config="config"
    >
      <template #weekDayEvent="eventProps">
        <div :style="{ backgroundColor: 'cornflowerblue', color: '#01579B', width: '100%', height: '100%', overflow: 'hidden' }">
          <span>{{ timeFormattingFunction(eventProps.eventData.time) }}</span>

          <span>{{ eventProps.eventData.title }}</span>
        </div>
      </template>

      <template #monthEvent="monthEventProps">
        <span>{{ monthEventProps.eventData.title }}</span>
      </template>
    </Qalendar>
  </v-card>
</template>

<style>
    @import "qalendar/dist/style.css";
</style>