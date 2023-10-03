<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {
  mdiAccountSchoolOutline,
  mdiWeatherHurricane,
  mdiWeatherPouring,
  mdiWeatherWindy,
  mdiAlert,
} from "@mdi/js";
export default {
  components: { AuthenticatedLayout },
  data() {
    return {
      listTitles: [{ name: "Forida" }, { name: "Niamey" }],
      icons: {
        mdiAccountSchoolOutline,
        mdiWeatherHurricane,
        mdiWeatherPouring,
        mdiWeatherWindy,
        mdiAlert,
      },
      labels: { 0: "SU", 1: "MO", 2: "TU", 3: "WED", 4: "TH", 5: "FR", 6: "SA" },
      expand: false,
      time: 0,
      forecast: [
        { day: "Tuesday", icon: "mdi-white-balance-sunny", temp: "24\xB0/12\xB0" },
        { day: "Wednesday", icon: "mdi-white-balance-sunny", temp: "22\xB0/14\xB0" },
        { day: "Thursday", icon: "mdi-cloud", temp: "25\xB0/15\xB0" },
      ],
    };
  },
};
</script>

<template>
  <AuthenticatedLayout>
    <div style="margin: 10px">
      <Toolbar
        styleToolbar="background-color: white;"
        :icon="icons.mdiAccountSchoolOutline"
        toolbarTitle="Liste des menus Primaire"
      ></Toolbar>
      <div>
        <h1>Gestion Primaire</h1>
      </div>

      <br />
      <v-row>
        <v-col v-for="(item, i) in listTitles" :cols="12 / listTitles.length">
          <v-card class="mx-auto" max-width="250">
            <v-card-text class="py-0" :key="i">
              <v-row align="center" no-gutters>
                <v-col class="text-h6" cols="6"> Liste des utilisateurs</v-col>

                <v-col cols="6" class="text-right">
                  <v-icon
                    color="error"
                    :icon="icons.mdiWeatherHurricane"
                    size="50"
                  ></v-icon>
                </v-col>
              </v-row>
            </v-card-text>

            <div class="d-flex py-3 justify-space-between">
              <v-list-item density="compact" :prepend-icon="icons.mdiWeatherWindy">
                <v-list-item-subtitle>123 km/h</v-list-item-subtitle>
              </v-list-item>

              <v-list-item density="compact" :prepend-icon="icons.mdiWeatherPouring">
                <v-list-item-subtitle>48%</v-list-item-subtitle>
              </v-list-item>
            </div>

            <v-expand-transition>
              <div v-if="expand">
                <p>Ce menu permet d'accèder à la liste des inscrits</p>
              </div>
            </v-expand-transition>

            <v-divider color="secondary"></v-divider>

            <v-card-actions>
              <v-btn @click="expand = !expand">
                {{ !expand ? "Lire illustration" : "Fermer la note" }}
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </div>
  </AuthenticatedLayout>
</template>
