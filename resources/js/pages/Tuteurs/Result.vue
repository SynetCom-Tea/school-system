<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ApprenantChart from "@/components/EspaceTureurs/ApprenatChart.vue"
import {
  mdiViewDashboardOutline,
  mdiMagnify,
  mdiLogout,
  mdiPencil,
  mdiDelete,
  mdiPlus,
} from "@mdi/js";
export default {
  components: {
    AuthenticatedLayout,
    ApprenantChart,
    mdiViewDashboardOutline,
    mdiMagnify,
    mdiLogout,
    mdiPencil,
    mdiDelete,
    mdiPlus,
  },
  props: ["children", "typeEvaluations", "resultatsFinauxQuery", "bulletinsChild"],
  data() {
    return {
      icons: { mdiViewDashboardOutline, mdiMagnify, mdiLogout, mdiPencil, mdiDelete, mdiPlus },
      apprenant: null,
      type_evaluation: null,
      fullname: '',
      headersBulletin: [
            {
                title: 'Période',
                align: 'start',
                sortable: false,
                key: 'periode',
            },
            { title: 'Classe', align: 'center', key: 'nom_classe' },
            { title: 'Moyenne', align: 'center', key: 'moyenne_details_notes' },
            {title: 'Actions', align: 'center', key: 'actions'},
        ],
      headers: [
        {
          title: "Période",
          align: "start",
          sortable: false,
          key: "periode_evaluation",
        },
        {
          title: "Date Evalution",
          align: "center",
          key: "date_evaluation",
        },
        {
          title: "Notation/Coefficient",
          align: "center",
          key: "notation",
        },
        {
          title: "Matiere",
          align: "center",
          key: "matiere.nom_matiere",
        },
        {
          title: "Note Obtenue",
          align: "center",
          key: "note_obtenue",
        },

        // {
        //   title: "Actions",
        //   align: "center",
        //   key: "actions",
        // },
      ],
    };
  },
  methods: {
    getResult(){
        this.$inertia.replace(this.$page.url, {
            data: { apprenant: this.apprenant, type_evaluation: this.type_evaluation }
        });
        let child = this.children.filter((child) => child.id == this.apprenant)[0]
        console.log(this.fullname, child)
        this.fullname = child.nom + ' ' + child.prenom
    }
  }
};
</script>
<template>
  <AuthenticatedLayout>
    <v-card>
      <Toolbar :icon="icons.mdiViewDashboardOutline" toolbarTitle="Notes et résultats"></Toolbar>
      <v-card-text>
        <v-row>
            <v-col md="6">
            <autocomplete
                label="Enfants"
                v-model="apprenant"
                :items="children"
                class="mt-4"
                isRequired
                item-title="full_name"
                item-value="id"
            >
            </autocomplete>
        </v-col>
        <v-col md="6">
            <autocomplete
                label="Type Evaluation"
                v-model="type_evaluation"
                :items="typeEvaluations"
                @update:modelValue="getResult()"
                class="mt-4"
                isRequired
                item-title="libelle"
                item-value="id"
            >
            </autocomplete>
        </v-col>

        </v-row>
            <Datatable
                v-if="type_evaluation != null"
                :displayAddButton="false"
                :titleDatatable="`Les notes de ${fullname}`"
                :headers="headers"
                :items="resultatsFinauxQuery"
                >
                <template v-slot:item.notation="{ item }">
                    {{ item.matiere.notation_matiere !== null ? item.matiere.notation_matiere : item.matiere.coefficient_matiere }}
                </template>
            </Datatable>
            <Datatable
                v-if="type_evaluation != null"
                :displayAddButton="false"
                :titleDatatable="`Les bulletin ${fullname}`"
                :headers="headersBulletin"
                :items="bulletinsChild"
                >
            </Datatable>
      </v-card-text>
    </v-card>
  </AuthenticatedLayout>
</template>
