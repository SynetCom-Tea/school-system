<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {
  mdiHumanCapacityIncrease,
  mdiMagnify,
  mdiLogout,
  mdiPencil,
  mdiDelete,
  mdiPlus,
} from "@mdi/js";
export default {
  components: {
    AuthenticatedLayout,
    mdiHumanCapacityIncrease,
    mdiMagnify,
    mdiLogout,
    mdiPencil,
    mdiDelete,
    mdiPlus,
  },
  props: ["children"],
  data() {
    return {
      icons: { mdiHumanCapacityIncrease, mdiMagnify, mdiLogout, mdiPencil, mdiDelete, mdiPlus },
      headers: [
        {
          title: "N°",
          align: "start",
          sortable: false,
          key: "count",
        },
        {
          title: "Nom&Prénom",
          align: "center",
          key: "fullName",
        },
        {
          title: "Année",
          align: "center",
          key: "year",
        },
        {
          title: "Section",
          align: "center",
          key: "section",
        },
        {
          title: "Niveau/Classe",
          align: "center",
          key: "level",
        },

        // {
        //   title: "Actions",
        //   align: "center",
        //   key: "actions",
        // },
      ],
    };
  },
  computed: {
    customizedUsers() {
      let list = this.children;
      let data = [];
      let niveau;
      if (list && list.length > 0) {
        list.forEach((element, index) => {
          if (element) {
            niveau = element.classe.niveau;

            data.push({
              count: index + 1,
              matricule: element.apprenant.matricule,
              fullName: element.apprenant.nom + " " + element.apprenant.prenom,
              level: element.classe.libelle,
              year: element.annee.libelle,
              section: niveau.section_id
                ? this.getSection(parseInt(niveau.section_id))
                : null,
            });
          }
        });
      }

      return data ?? [];
    },
  },
  mounted() {
    this.customizedUsers;
  },
  methods: {
    getSection(id) {
      let libelle;
      switch (id) {
        case 1:
          libelle = "Primaire";
          break;
        case 2:
          libelle = "Secondaire";
          break;
        case 3:
          libelle = "Supérieure";
          break;
        case 4:
          libelle = "Universitaire";
          break;

        default:
          break;
      }
      return libelle;
    },
  },
};
</script>
<template>
  <AuthenticatedLayout>
    <v-card>
      <Toolbar
        :icon="icons.mdiHumanCapacityIncrease"
        toolbarTitle="Liste de mes enfants"
      ></Toolbar>
      <v-card-text>
        <Datatable
          :displayAddButton="false"
          titleDatatable="Liste des enfants"
          :headers="headers"
          :items="customizedUsers"
        >
        </Datatable>
      </v-card-text>
    </v-card>
  </AuthenticatedLayout>
</template>
