<template>
  <AuthenticatedLayout>
    <Toolbar
      styleToolbar="background-color: white;"
      :icon="icons.mdiAccountSchool"
      toolbarTitle="Inscriptions"
    ></Toolbar>
    <div class="mt-3">
      <v-container class="bg-surface-variant mb-6">
        <v-row align="center" no-gutters>
          <v-col cols="auto">
            <!-- <Autocomplete
                  :items="listSection"
                  class="mt-2"
                  v-model="section"
                  item-value="id"
                  item-title="code"
                  chips
                  closable-chips
                  color="blue-grey-lighten-2"
                  label="Section"
                ></Autocomplete> -->
          </v-col>
        </v-row>
      </v-container>
    </div>
    <div class="mt-3">
      <Datatable
        :dialogDetailUpdate="dialogDetailUpdate"
        titleDatatable="Liste des inscrits"
        :functionDeleteItem="deleteItem"
        :functionOnConfirmDeleting="onConfirmDeleting"
        :editedObject="editedObject"
        :functionEditItem="editItem"
        :headers="headers"
        :items="subscribers"
        :functionOnSaveAdding="submitNewLine"
        :functionOnClickAddButton="functionOnClickAddButton"
      >
        <template v-slot:contentDialogUpdateDetail>
          <v-dialog v-model="onDetailUpdate">
            <h1>Contenu</h1>
            <!-- <ModalDetailUpdate
            :dialogDetailUpdate="onDetailUpdate"
            :onClickCancelButton="onClickCancelButtonOfMDU"
            :onClickSaveButton="onClickSaveButtonOfMDU"
          >
            <template v-slot:contentForm>
              <h1>Contenu</h1>
            </template>
          </ModalDetailUpdate> -->
          </v-dialog>
        </template>
      </Datatable>
    </div>
  </AuthenticatedLayout>
</template>
<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router, useForm } from "@inertiajs/vue3";

import {
  mdiAccountCircle,
  mdiAccountSchool,
  mdiCurrencyUsd,
  mdiPlus,
  mdiClose,
} from "@mdi/js";
export default {
  components: {
    AuthenticatedLayout,
    mdiAccountCircle,
    mdiAccountSchool,
    mdiCurrencyUsd,
    mdiPlus,
    mdiClose,
  },
  //*403#
  // layout: AuthenticatedLayout,
  data() {
    return {
      headers: [
        {
          title: "N°",
          align: "start",
          key: "id",
          sortable: false,
        },
        { title: "Nom", align: "center", key: "nom" },
        { title: "Niveau", align: "center", key: "niveau_id" },

        {
          title: "Actions",
          key: "actions",
          sortable: false,
        },
      ],
      subscribers: [
        {
          matricule: "A209",
          nom: "Boureima",
          prenom: "Sara",
          tel: "96979797",
          mail: "sara-boureima@gmail.com",
          sexe: "F",
          dateNaiss: "12/10/2000",
          section_id: 1,
          niveau_id: 16,
          apExist: 0,
          tuteurs: [
            { lastname: "Bako", firstname: "Moussa" },
            { lastname: "Issa", firstname: "Fati" },
          ],
        },
      ],
      editedObject: {
        matricule: "",
        nom: "",
        prenom: "",
        tel: null,
        mail: "",
        sexe: "",
        dateNaiss: "",
        section_id: null,
        niveau_id: null,
        apExist: 0,
        tuteurs: [],
      },
      icons: {
        mdiAccountCircle,
        mdiAccountSchool,
        mdiCurrencyUsd,
        mdiPlus,
        mdiClose,
      },
      onDetailUpdate: false,
      dialogDetailUpdate: true,
      selectedItemForUpdate: "",
      form: useForm({
        matricule: "",
        nom: "",
        prenom: "",
        tel: "",
        mail: "",
        sexe: "",
        dateNaiss: "",
        section_id: "",
        niveau_id: "",
        apExist: "",
        tuteurs: [],
      }),
    };
  },
  async mounted() {
  console.log('page:', this.$page.props)
    await this.getListUsers();
  },
  methods: {
  async setFilters() {
      let axiosResult = [];
      let items = [];
      let vItems = [];

      // axiosResult = await axios
        .get(
          route("getUsersByCategory", {
            params: "organizationStudents",
          })
        )
        .then((res) => {
          console.log("res:", res);
          if (typeof res.data == "string" || typeof res.data == "undefined") {
            this.$toast.error("Données non valides!");
          } else {
            return res.data;
          }
        });
    },
    async getListUsers() {
      let axiosResult = [];
      let items = [];
      let vItems = [];

      axiosResult = await axios
        .get(
          route("getUsersByCategory", {
            params: "organizationStudents",
          })
        )
        .then((res) => {
          console.log("res:", res);
          if (typeof res.data == "string" || typeof res.data == "undefined") {
            this.$toast.error("Données non valides!");
          } else {
            return res.data;
          }
        });
    },

    functionOnClickAddButton() {
      router.get(route("inscriptions.create"));
    },
    submitNewLine() {
      console.log("submitNewLine");
    },
    editItem(item) {
      console.log("item from editItem:", item);
      this.editedObject = Object.assign({}, item);
      if (item) {
        this.selectedItemForUpdate = item;
      }
      if (this.dialogDetailUpdate) {
        console.log("here");
        this.onDetailUpdate = true;
      }
      // console.log("this.selectedItemForUpdate:", this.selectedItemForUpdate);
      // console.log("this.dialogDetailUpdate:", this.dialogDetailUpdate);
    },
    deleteItem(item) {
      // console.log("item from deleteItem:", item);
    },
    onConfirmDeleting() {
      console.log("confirm deleting");
    },
    onClickCancelButtonOfMDU() {
      this.onDetailUpdate = false;
    },
    onClickSaveButtonOfMDU() {
      // console.log("enregistrer la mise à jour:");
      this.onDetailUpdate = false;
    },

    addRow() {
      this.form.tuteurs.push({
        nom: null,
        prenom: null,
        tel: null,
        adresse: null,
        before: null,
        after: null,
      });
    },
    removeRow(p) {
      this.form.tuteurs = this.form.tuteurs.filter((product) => product !== p);
    },
  },
};
</script>
