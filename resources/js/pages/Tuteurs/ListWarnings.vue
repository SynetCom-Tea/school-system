<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {
  mdiAccountGroup,
  mdiMagnify,
  mdiLogout,
  mdiPencil,
  mdiDelete,
  mdiPlus,
} from "@mdi/js";
export default {
  components: {
    AuthenticatedLayout,
    mdiAccountGroup,
    mdiMagnify,
    mdiLogout,
    mdiPencil,
    mdiDelete,
    mdiPlus,
  },
  props: ["absencesAll"],
  data() {
    return {
      icons: { mdiAccountGroup, mdiMagnify, mdiLogout, mdiPencil, mdiDelete, mdiPlus },
      headers: [
        {
          title: "Date d'absence",
          align: "start",
          sortable: false,
          key: "date",
        },
        {
          title: "Mat-Nom&Prénom",
          align: "center",
          key: "nom_complet",
        },
        {
          title: "Absence journée entière",
          align: "center",
          key: "journee",
        },
        {
          title: "Cours",
          align: "center",
          key: "nom_matiere_heure_debut",
        },
        {
          title: "Enseignant",
          align: "center",
          key: "nom_prenom_enseignant",
        },
      ],
      tab: null,
    };
  },
};
</script>
<template>
  <AuthenticatedLayout>
    <v-card>
      <Toolbar
        :icon="icons.mdiAccountGroup"
        toolbarTitle="Avertissements/Alertes"
      ></Toolbar>
      <v-card>
        <v-tabs
          v-model="tab"
          color="deep-purple-accent-4"
          align-tabs="center"
        >
          <v-tab :value="1">Avertissements</v-tab>
          <v-tab :value="2">Alertes(Absence)</v-tab>
        </v-tabs>
        <v-window v-model="tab">
          <v-window-item
            :value="1"
          >
            <v-container fluid>
              <v-row>
                
              </v-row>
            </v-container>
          </v-window-item>
          <v-window-item
            :value="2"
          >
            <v-container fluid>
              <Datatable
                :displayAddButton="false"
                titleDatatable="Absence des enfants"
                :headers="headers"
                :items="absencesAll"
              >
              </Datatable>
            </v-container>
          </v-window-item>
        </v-window>
      </v-card>
    </v-card>
  </AuthenticatedLayout>
</template>
