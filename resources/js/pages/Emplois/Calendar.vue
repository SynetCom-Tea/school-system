<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import "qalendar/dist/style.css";
import { router, useForm } from "@inertiajs/vue3";
import { mdiPlus, mdiTimetable } from "@mdi/js";
import { Qalendar } from "qalendar";
import { AgGridVue } from "@ag-grid-community/vue3";
export default {
  layout: AuthenticatedLayout,
  components: {
    Qalendar,
    AgGridVue,
  },
  props: ["emplois", "events", "AllClasses", "niveaux", "emplois", "sectionID"],
  data() {
    return {
      columnDefs: [
        { headerName: "Make", field: "make" },
        { headerName: "Model", field: "model" },
        { headerName: "Price", field: "price" },
      ],
      rowData: [
        { make: "Toyota", model: "Celica", price: 35000 },
        { make: "Ford", model: "Mondeo", price: 32000 },
        { make: "Porsche", model: "Boxster", price: 72000 },
      ],
      icon: {
        mdiPlus,
        mdiTimetable,
      },
      classes: [],
      form: useForm({
        niveau: null,
        classe: null,
        date: null,
        emploi: null,
        section_id: null
      }),
      config: {
        // see configuration section
       
      }
    };
  },
  methods: {
    goTo() {
      this.form.get(route("emplois.create"))
      // router.get(route("emplois.create"));
    },
    setClasse(niveau) {
      this.form.classe = null
      this.form.emploi = null
      this.classes = this.AllClasses.filter((classe) => {
        return classe.niveau_id == niveau;
      });
    },
    setEmploi(classe) {
      this.$inertia.replace(this.$page.url, {
        data: {
          classe: classe,
        }
      })
    },
    setCalandar(emploi){
      this.$inertia.replace(this.$page.url, {
        data: {
          emploi: emploi,
        }
      })
    }
  },
  mounted(){
    console.log(this.events)
    this.form.section_id = this.sectionID
  }
};
</script>
<template>
  <v-card>
    <Toolbar :icon="icon.mdiTimetable" toolbarTitle="Calendrier"></Toolbar>
    <v-card-text>
      <v-toolbar flat color="white">
        <v-toolbar-title
          style="
            font-size: 1em;
            width: 250px;
            word-wrap: break-word;
            white-space: pre-wrap;
            word-break: break-word;
          "
        >
        <v-row>
          <v-col md="4">
          <autocomplete
            label="Niveau"
            v-model="form.niveau"
            :items="niveaux"
            isRequired
            class="mt-4"
            @update:modelValue="setClasse(form.niveau)"
            item-title="libelle"
            item-value="id"
          ></autocomplete>
        </v-col>
        <v-col md="4">
          <autocomplete
            label="Classe"
            v-model="form.classe"
            :items="classes"
            :disabled="!form.niveau"
            @update:modelValue="setEmploi(form.classe)"
            class="mt-4"
            isRequired
            item-title="libelle"
            item-value="id"
          ></autocomplete>
        </v-col>
        <v-col md="4">
          <autocomplete
            label="Emploi"
            v-model="form.emploi"
            :items="emplois"
            :disabled="!form.classe"
            @update:modelValue="setCalandar(form.emploi)"
            class="mt-4"
            item-title="tranche_date"
            item-value="id"
          ></autocomplete>
        </v-col>
        </v-row>
        </v-toolbar-title>
      </v-toolbar>
      <v-card>
        <Qalendar
          :selected-date="new Date()"
          :events="events"
          :config="config"
        >
          <template #weekDayEvent="eventProps">
            <div :style="{ backgroundColor: 'cornflowerblue', color: '#01579B', width: '100%', height: '100%', overflow: 'hidden' }">
              <span>{{ timeFormattingFunction(eventProps.eventData.time) }}</span>

              <span>{{ eventProps.eventData.title }}</span>
            </div>
          </template>

          <template #monthEvent="monthEventProps">
            <span>{{ monthEventProps.eventData.title }}</span>
          </template>
        </Qalendar>
      </v-card>
    </v-card-text>
    <div>
      <ag-grid-vue
        class="ag-theme-alpine"
        style="height: 500px"
        :columnDefs="columnDefs.value"
        :rowData="rowData.value"
        :defaultColDef="defaultColDef"
        rowSelection="multiple"
        animateRows="true"
        @cell-clicked="cellWasClicked"
        @grid-ready="onGridReady"
      >
      </ag-grid-vue>
    </div>
  </v-card>
</template>


<style scoped>
.add-button-style:hover {
  background-color: #7d002c;
  box-shadow: 0px 0px 8px #7d002c;
  transform: scale(1.05);
  cursor: pointer;
}

.add-button-style {
  height: 30px;
  /* background-color: #7d002c; */
  text-transform: none;
  box-shadow: 10px 5px 5px #7d002c;
  /* 0px 0px 5px #7d002c; */
}
</style>