<script>
export default {
  props: {
    permissions: {
        type: Object,
        required: true
      }
    },
  data() {
    return {
      headers: [
        {
          title: "ID",
          align: "start",
          sortable: false,
          key: "id",
        },
        { title: "Permission", align: "center", key: "name" },
        { title: "Description", align: "center", key: "description" },
      ],
    };
  },
};
</script>
<template>
  <v-card-text>
    <Datatable titleDatatable="Liste des permissions" :headers="headers" :items="permissions" :displayAddButton="false"/>
  </v-card-text>
</template>
