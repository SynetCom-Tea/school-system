<script>
export default {
  props: {
    headers: {
      type: Array,
      required: true,
    },
    items: {
      type: Array,
      required: true,
    },
    titleDatatable: {
      type: String,
      default: "Titre du datatable",
      required: false,
    },
  },

  data() {
    return {
      searchQuery: "",
    };
  },
  methods: {},
  computed: {
    scopedSlots() {
      return this.$slots;
    },
  },
};
</script>

<template>
  <v-card style="width: 98%; margin: 10px">
    <v-card-title style="color: white; background-color: #7d002c">{{
      titleDatatable
    }}</v-card-title>
    <v-row>
      <v-col md="6">
        <TextField
          label="Recherche"
          placeholder="Recherche"
          v-model="searchQuery"
          class="mt-2 ml-4"
        ></TextField>
      </v-col>
      <v-spacer></v-spacer>
      <v-col md="3">
        <slot name="addBtn"></slot>
      </v-col>
    </v-row>
    <v-data-table
      :headers="headers"
      :items="items"
      :search="searchQuery"
      class="style-table pt-3"
    >
      <template v-for="(index, name) in $slots" v-slot:[name]>
        <slot :name="name"></slot>
      </template>
      <template v-for="(index, name) of $slots" v-slot:[name]="data">
        <slot :name="name" v-bind="data"></slot>
      </template>
    </v-data-table>
  </v-card>
</template>

<style scoped>
.style-table {
  border: 1px solid #004980;
  border-radius: 4px;
  margin-left: 10px;
  width: 98%;
}
</style>
