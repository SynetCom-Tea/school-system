<script>
import Autocomplete from "./Autocomplete.vue";
import TextField from "./TextField.vue";

export default {
  components: { Autocomplete, TextField },
  props: {
    toolbarTitle: {
      type: String,
      default: "text",
    },
    iconUpdate: {
      type: String,
      required: false,
    },
    iconValueDetail: {
      type: String,
      required: false,
    },
    titleSubmittingButton: {
      type: String,
      default: "Enregistrer",
    },
    messageSnackbar: {
      type: String,
      default: "Modification réussie",
    },
  },

  data: () => ({
    hasSaved: false,
    vItem: "",
    isEditing: null,
    states: [
      { name: "Florida", abbr: "FL", id: 1 },
      { name: "Georgia", abbr: "GA", id: 2 },
      { name: "Nebraska", abbr: "NE", id: 3 },
      { name: "California", abbr: "CA", id: 4 },
      { name: "New York", abbr: "NY", id: 5 },
    ],
  }),
  updated() {},
  methods: {
    onchangeField(e) {
      // console.log("EEEE:", e);
    },
    customFilter(itemTitle, queryText, item) {
      const textOne = item.raw.name.toLowerCase();
      const textTwo = item.raw.abbr.toLowerCase();
      const searchText = queryText.toLowerCase();

      return textOne.indexOf(searchText) > -1 || textTwo.indexOf(searchText) > -1;
    },
    save() {
      this.isEditing = !this.isEditing;
      this.hasSaved = true;
    },
  },
};
</script>
<template>
  <v-card class="mx-auto" max-width="500">
    <v-toolbar flat color="primary">
      <v-btn> <v-icon :icon="iconValueDetail"></v-icon></v-btn>

      <v-toolbar-title class="font-weight-light">
        {{ toolbarTitle }}
      </v-toolbar-title>

      <v-spacer></v-spacer>

      <v-btn icon @click="isEditing = !isEditing">
        <v-fade-transition leave-absolute>
          <v-icon v-if="isEditing" :icon="iconValueDetail"></v-icon>

          <v-icon v-else :icon="iconUpdate"></v-icon>
        </v-fade-transition>
      </v-btn>
    </v-toolbar>

    <v-card-text>
      <TextField
        :disabled="!isEditing"
        label="Name"
        classResponsive="py-2"
        :isRequired="true"
      ></TextField>
      <Autocomplete
        v-model="vItem"
        :conditionDisabled="!isEditing"
        classResponsive="py-2"
        :itemsValue="states"
        :isRequired="true"
        :customFilter="customFilter"
        item-title="name"
        item-value="abbr"
        label="State"
        :onchangeField="onchangeField(vItem)"
      ></Autocomplete>
    </v-card-text>

    <v-divider></v-divider>

    <v-card-actions>
      <v-spacer></v-spacer>
      <PrimaryButton />
      <v-btn :disabled="!isEditing" @click="save"> {{ titleSubmittingButton }} </v-btn>
    </v-card-actions>

    <v-snackbar
      v-model="hasSaved"
      :timeout="2000"
      attach
      position="absolute"
      location="bottom left"
    >
      {{ messageSnackbar }}
    </v-snackbar>
  </v-card>
</template>
