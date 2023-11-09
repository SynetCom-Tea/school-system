<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { listMenusBySection } from "../../utils/ListNavAppBar.js";
import { router, usePage, useForm } from "@inertiajs/vue3";
import {
  mdiTimerStarOutline,
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
      authPage: this.$page.props,
      listTitles: [{ name: "Forida" }, { name: "Niamey" }],
      icons: {
        mdiTimerStarOutline,
        mdiAccountSchoolOutline,
        mdiWeatherHurricane,
        mdiWeatherPouring,
        mdiWeatherWindy,
        mdiAlert,
      },
      form: this.$inertia.form({
        section_id: 4,
      }),
      expand: {},
      time: 0,
    };
  },
  mounted() {
    this.getMenus;
  },
  computed: {
    getMenus() {
      let list = this.listMenusBySection(this.authPage, 1);
      return list[0] ?? [];
    },
  },
  methods: {
    listMenusBySection,
    goToPage(item) {
      if (item.link == "/users") {
        this.form.get(route("users.index"));
      }
      if (item.link == "/subscribers") {
        this.form.get(route("inscriptions.index"));
      }
      if (item.link == "emplois") {
        this.form.get(route("emplois.index"));
      }
      if (item.link == "emploisCreate") {
        this.form.get(route("calendar.index"));
      }
      if (item.link == "evaluation") {
        this.form.get(route("evaluation.index_admin"));
      }
      if (item.link == "note") {
        this.form.get(route("note.index_admin"));
      }
    },
    onClickExpland(item) {
      let vExpand = item.expand;
      // console.log(" vExpand:", vExpand);
      this.expand[item.expand] = !vExpand;
      // item.expand = this.expand[item.expand];
      // console.log("expand:", this.expand[item.expand]);
    },
  },
};
</script>

<template>
  <AuthenticatedLayout>
    <div style="margin: 10px">
      <Toolbar
        styleToolbar="background-color: white;"
        :icon="icons.mdiTimerStarOutline"
        toolbarTitle="Liste des menus Universitaire"
      ></Toolbar>
      <div style="margin: 10px">
        <h2 class="text-color-secondary">Gestion Universitaire</h2>
      </div>

      <v-row>
        <v-col v-for="(item, i) in getMenus" cols="2">
          <v-card
              class="mx-auto"
              max-width="200"
              style="cursor: pointer"
              gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
              @click="goToPage(item)"
          >
              <v-img
                  class="align-end text-white"
                  height="150"
                  :src="item.image"
                  cover
              ></v-img>
              <v-card-subtitle>
                  <div class="d-flex py-2">
                      <v-list-item :prepend-icon="item.icon">
                          <v-list-item-subtitle dense >{{ item.title }}</v-list-item-subtitle>
                      </v-list-item>
                  </div>
              </v-card-subtitle>
          </v-card>
          <!-- <v-card
            :prepend-icon="item.icon"
            class="mx-auto"
            max-width="250"
            :color="item.color"
            style="cursor: pointer"
            @click="goToPage(item)"
          >
            <v-card-text class="py-0" :key="i">
              <v-card-title style="color: primary">{{ item.title }}</v-card-title>

              <div class="d-flex py-3 justify-space-between">
                <v-list-item density="compact" :prepend-icon="icons.mdiWeatherWindy">
                  <v-list-item-subtitle>Section Universitaire</v-list-item-subtitle>
                </v-list-item>
              </div>
            </v-card-text>
          </v-card> -->
        </v-col>
      </v-row>
    </div>
</AuthenticatedLayout>
</template>
