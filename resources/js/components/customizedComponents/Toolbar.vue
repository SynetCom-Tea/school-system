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
    leftButtonName: { type: String, default: "Retour" },
    searchQuery: { type: String, default: "" },
    toolbarTitle: { type: String, default: "Titre du toolbar" },
    typeIcon: { type: String, default: "vicon" },
    styleToolbar: { type: String, default: "" },
    dialogModel: { type: Boolean, default: true },
    addCloseButton: { type: Boolean, default: false },
    onClickLeftButton: {
      type: Function,
      default: () => {
        let previousRoute = window.history.state?.url;
        let previousRouteName;

        previousRouteName = previousRoute?.includes("/")
          ? previousRoute?.split("/").pop()
          : null;

        return window.history.back();
      },
    },
  },
  data() {
    return {
      modelItem: "",
      closeCard: true,
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
    onChangeSearch(e) {},
    onClickSearch() {},
    goBack() {
      return router.get(route("dashboard"));
    },
  },
};
</script>
<template>
  <div>
    <v-card
      style="background-color: white; box-shadow: 0px 0px 5px #004980; margin-top: 5px"
      height="70px"
      rounded="0"
    >
      <v-toolbar color="white" :style="styleToolbar" extended extension-height="50">
        <v-icon
          style="margin: 10px"
          color="secondary"
          :icon="icon"
          size="x-large"
        ></v-icon>

        <v-toolbar-title
          style="
            font-size: 1em;
            width: 250px;
            word-wrap: break-word;
            white-space: pre-wrap;
            word-break: break-word;
          "
          ><p class="text-wrap">
            {{ toolbarTitle }}
          </p></v-toolbar-title
        >
        <v-spacer></v-spacer>
        <div style="width: 200px">
          <Autocomplete
            auto-select-first
            style="margin-top: 20px"
            density="comfortable"
            placeholder="Rechercher"
            :icon="icons.mdiMagnify"
            rounded
            theme="light"
            variant="solo"
          ></Autocomplete>
        </div>
        <div style="display: absolute; bottom: 0; top: 0; height: 40px">
          <Button class="ma-2" color="bold" @click="onClickLeftButton">
            <v-icon start :icon="icons.mdiReply"></v-icon>
            {{ leftButtonName }}
          </Button>
        </div>
      </v-toolbar>
    </v-card>
    <v-card outlined height="3px" color="primary"></v-card>
    <!-- <v-card class="mx-3"
    outlined height="3px" color="primary"></v-card> -->
    <slot />
  </div>
</template>

<style scoped>
.v-card .v-card-title {
  line-height: 2rem;
  text-wrap: wrap;
}
</style>
