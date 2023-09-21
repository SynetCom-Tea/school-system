<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router, useForm } from "@inertiajs/vue3";
import {
  mdiAccountSchool,
  mdiPencil,
  mdiDelete,
  mdiEye,
  mdiPrinter,
  mdiCloseCircle,
  mdiReceipt,
} from "@mdi/js";
export default {
  components: {
    mdiAccountSchool,
    mdiPencil,
    mdiDelete,
    mdiEye,
    mdiPrinter,
    mdiCloseCircle,
    mdiReceipt,
  },
  layout: AuthenticatedLayout,
  props: ["cycles"],
  data() {
    return {
      edit: false,
      icon: {
        mdiAccountSchool,
        mdiPencil,
        mdiDelete,
        mdiEye,
        mdiPrinter,
        mdiCloseCircle,
        mdiReceipt,
      },
      form: useForm({
        id: null,
        nom: null,
      }),
      headers: [
        {
          title: "#",
          align: "start",
          sortable: false,
          key: "id",
        },
        {
          title: "Nom",
          align: "center",
          key: "name",
        },
        {
          title: "Actions",
          key: "actions",
          sortable: false,
        },
      ],
    };
  },
  methods: {
    editItem(item) {
      this.edit = true;
      this.form.id = item.id;
      this.form.nom = item.name;
    },
    update() {
      (this.edit = false),
        this.$swal({
          title: "Etes-vous sûr?",
          text: "Vous ne pourrez pas revenir en arrière !",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "orange",
          cancelButtonColor: "#d33",
          confirmButtonText: "Oui, Contunier!",
          cancelButtonText: "Non, annulez !",
        }).then((result) => {
          if (result.isConfirmed) {
            this.form.patch(route("cycles.update", this.form.id));
          }
        });
    },
    deleteItem(item) {
      this.$swal({
        title: "Etes-vous sûr?",
        text: "Vous ne pourrez pas revenir en arrière !",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "orange",
        cancelButtonColor: "#d33",
        confirmButtonText: "Oui, Contunier!",
        cancelButtonText: "Non, annulez !",
      }).then((result) => {
        if (result.isConfirmed) {
          router.delete(route("cycles.destroy", item.id));
        }
      });
    },
    close() {
      this.edit = false;
    },
  },
};
</script>
<template>
  <v-card>
    <Toolbar :icon="icon.mdiAccountSchool" toolbarTitle="Gestion des cycles"></Toolbar>
    <v-dialog v-model="edit" transition="dialog-top-transition" persistent width="500px">
      <v-card>
        <v-toolbar dense color="rgb(119, 109, 110)" dark>
          <v-toolbar-title>
            <v-icon left :icon="icon.mdiPencil"></v-icon> Modification
          </v-toolbar-title>
          <v-spacer></v-spacer>
        </v-toolbar>

        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <text-field v-model="form.nom" label="Nom" placeholder="Nom"></text-field>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="red" @click="close" variant="outlined">
            <v-icon :icon="icon.mdiCancel" left></v-icon>Annuler
          </v-btn>
          <v-btn color="success" @click="update" variant="outlined">
            <v-icon :icon="icon.mdiPencil" left></v-icon>Modifier
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-card-text>
      <table-component :headers="headers" :items="cycles">
        <template v-slot:addBtn>
          <btn @click="goTo()"> Ajouter</btn>
        </template>
        <template v-slot:item.actions="{ item }">
          <v-icon
            size="large"
            color="warning"
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
        </template>
      </table-component>
    </v-card-text>
  </v-card>
</template>

<style></style>
