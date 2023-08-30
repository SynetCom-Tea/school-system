<script lang="ts">
import {
  mdiMicrophone,
  mdiHome,
  mdiArrowLeft,
  mdiMagnify,
  mdiReply,
  mdiDotsVertical,
} from "@mdi/js";
import { Icon } from "@iconify/vue";
import { router } from "@inertiajs/vue3";
export default {
  components: {
    mdiMicrophone,
    mdiArrowLeft,
    Icon,
    mdiMagnify,
    mdiReply,
    mdiDotsVertical,
  },
  props: {
    icon: { default: mdiHome },
    toolbarTitle: { type: String, default: "Titre du toolbar" },
    typeIcon: { type: String, default: "vicon" },
    dialogModel: { type: Boolean, default: true },
    addCloseButton: { type: Boolean, default: false },
    oncloseDialog: { type: Function },
  },
  data() {
    return {
      closeCard: true,
      searchQuery: "",
      items: [
        { name: "Florida", abbr: "FL", id: 1 },
        { name: "Georgia", abbr: "GA", id: 2 },
        { name: "Nebraska", abbr: "NE", id: 3 },
        { name: "California", abbr: "CA", id: 4 },
        { name: "New York", abbr: "NY", id: 5 },
      ],
      icons: {
        mdiMicrophone,
        mdiHome,
        mdiArrowLeft,
        mdiMagnify,
        mdiReply,
        mdiDotsVertical,
      },
    };
  },
  methods: {
    onChangeSearch(e) {
      console.log("e search:", e);
    },
    onClickSearch() {
      console.log("search");
    },
    goBack() {
      return router.get(route("dashboard"));
    },
  },
};
</script>
<template>
  <v-card color="primary" height="70px" rounded="0" class="mx-3">
    <v-toolbar color="primary" extended extension-height="50">
      <Button variant="flat" title="Icon de la page" style="width: 40px; height: 50px">
        <v-icon :icon="icon" size="x-large"></v-icon>
      </Button>

      <v-toolbar-title>{{ toolbarTitle }}</v-toolbar-title>
      <v-spacer></v-spacer>
      <Autocomplete
        style="display: absolute; bottom: 0; top: 0"
        :items="items"
        heightResponsive="70"
        widthResponsive="50"
        :append-inner-icon="icons.mdiMicrophone"
        auto-select-first
        class="flex-full-width"
        density="comfortable"
        item-title="name"
        item-value="abbr"
        menu-icon=""
        placeholder="Rechercher"
        :prepend-inner-icon="icons.mdiMagnify"
        rounded
        theme="light"
        variant="solo"
      ></Autocomplete>

      <div style="display: absolute; bottom: 0; top: 0;height=40px">
        <Button class="ma-2" color="white" :onClickButton="goBack">
          <v-icon start :icon="icons.mdiReply"></v-icon>
          Retour
        </Button>
      </div>
    </v-toolbar>
  </v-card>
</template>

<style scoped>
.v-card .v-card-title {
  line-height: 2rem;
  text-wrap: wrap;
}
</style>
