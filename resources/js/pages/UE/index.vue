<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router, useForm } from "@inertiajs/vue3";
import {
  mdiAccountSchool,
  mdiPencil,
  mdiDelete,
  mdiPlus,
  mdiEye,
  mdiCloseCircle,
  mdiReceipt,
} from "@mdi/js";
export default {
  components: {
    mdiAccountSchool,
    mdiPencil,
    mdiDelete,
    mdiPlus,
    mdiEye,
    mdiCloseCircle,
    mdiReceipt,
  },
  layout: AuthenticatedLayout,
  props: ["ues"],
  data() {
    return {
      icon: {
        mdiAccountSchool,
        mdiPencil,
        mdiDelete,
        mdiPlus,
        mdiEye,
        mdiCloseCircle,
        mdiReceipt,
      },
      searchQuery: "",
      headers: [
        {
          title: "ID",
          align: "start",
          sortable: false,
          key: "id",
        },
        {
          title: "Nom",
          align: "center",
          key: "libelle",
        },
        {
          title: "Actions",
          align: "center",
          key: "actions",
        },
      ],
      form: useForm({}),
    };
  },
  methods: {
    goTo() {
      router.get(route("ues.create"));
    },
    editItem(item) {
      router.get(route("etablissements.edit", item.id));
    },
    deleteItem(item) {
      this.$swal({
        title: "Es-tu sûr?",
        text: "Vous ne pourrez pas revenir en arrière !",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "orange",
        cancelButtonColor: "#d33",
        confirmButtonText: "Oui, supprimez-le!",
        cancelButtonText: "Non, annulez !",
      }).then((result) => {
        if (result.isConfirmed) {
          router.delete(route("etablissements.destroy", item.id));
        }
      });
    },
    showItem(item) {
      this.target = item;
      this.show = true;
    },
  },
  created() {
    // console.log(this.$page.props.flash.message)
  },
};
</script>
<template>
  <v-card>
    <Toolbar
      :icon="icon.mdiAccountSchool"
      toolbarTitle="Gestion des Unité d'enseignements"
    ></Toolbar>
    <v-card-text>
      <table-component :headers="headers" :items="ues">
        <template v-slot:addBtn>
          <btn @click="goTo()">
            <v-icon>{{ icon.mdiPlus }}</v-icon> Ajouter
          </btn>
        </template>
        <template v-slot:item.actions="{ item }">
          <v-icon
            size="large"
            color="warning"
            title="Modifier"
            class="me-2"
            @click="editItem(item.raw)"
            :icon="icon.mdiPencil"
          >
          </v-icon>
          <v-icon
            size="large"
            color="red"
            @click="deleteItem(item.raw)"
            :icon="icon.mdiDelete"
          >
          </v-icon>
          <v-icon
            size="large"
            color="info"
            @click="showItem(item.raw)"
            :icon="icon.mdiEye"
          >
          </v-icon>
        </template>
        <template v-slot:item.telephone="{ item }">
          <v-chip-group column>
            <v-chip
              label
              color="orange"
              :key="i"
              v-for="(t, i) in item.columns.telephone"
              >{{ t }}</v-chip
            >
          </v-chip-group>
        </template>
      </table-component>
    </v-card-text>
  </v-card>
</template>

<style></style>
