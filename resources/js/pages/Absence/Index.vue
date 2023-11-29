<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router, useForm } from "@inertiajs/vue3";
import { mdiPlus, mdiTimetable, mdiDelete, mdiPencil } from "@mdi/js";
export default {
  layout: AuthenticatedLayout,
  components: {
    
  },
  props: ["absencesAll", "sectionID", "niveaux", "AllClasses"],
  data() {
    return {
      icons: {
        mdiPlus,
        mdiTimetable,
        mdiPencil,
        mdiDelete
      },
      headers: [
        {
          title: 'Matricule',
          align: 'start',
          sortable: false,
          key: 'matricule_apprenant',
        },
        { title: 'Nom & Prénom', align: 'center', key: 'nom_prenom_apprenant' },
        { title: 'Absence journée entière', align: 'center', key: 'journee' },
        { title: 'Seance', align: 'center', key: 'nom_matiere_heure_debut' },
        {title: 'Actions', align: 'center', key: 'actions'},
      ],
      classes: [],
      form: useForm({
        niveau: null,
        classe: null,
        date: null,
        emploi: null,
        section_id: null
      }),
    };
  },
  methods: {
    goTo() {
      this.form.get(route("absences.create"))
      // router.get(route("absences.create"));
    },
    setClasse(niveau) {
      this.form.classe = null
      this.form.emploi = null
      this.classes = this.AllClasses.filter((classe) => {
        return classe.niveau_id == niveau;
      });
    },
    setAbsence(date) {
      this.$inertia.replace(this.$page.url, {
        data: {
          classe: this.form.classe,
          date: date
        }
      })
    },
    formatDate(dateString) {
      if (!dateString) {
        return ''; // Si la date est nulle, retournez une chaîne vide
      }

      // Convertir la chaîne de date en objet Date
      const dateObject = new Date(dateString);

      // Vérifier si la conversion est réussie
      if (isNaN(dateObject.getTime())) {
        return 'Date invalide';
      }

      // Formater la date selon vos préférences locales
      const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
      return dateObject.toLocaleDateString('fr-FR', options);
    },
    editItem(){

    },
    deleteItem(){

    }
  },
  mounted(){
    this.form.section_id = this.sectionID
    console.log(this.absences)
  }
};
</script>
<template>
  <v-card>
    <Toolbar :icon="icons.mdiTimetable" toolbarTitle="Gestion des absences"></Toolbar>
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
          <v-col cols="4">
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
        <v-col cols="3">
          <autocomplete
            label="Classe"
            v-model="form.classe"
            :items="classes"
            :disabled="!form.niveau"
            class="mt-4"
            isRequired
            item-title="libelle"
            item-value="id"
          ></autocomplete>
        </v-col>
        <v-col cols="3">
          <TextField
            class="mt-4" 
            label="Date"
            type="date" 
            variant="outlined"
            :disabled="!form.classe"
            placeholder="Date" 
            v-model="form.date" 
            :isRequired="true"
          >
          </TextField>
        </v-col>
        <v-col cols="2">
          <v-btn
            color="deep-purple-accent-4"
            class="mt-4" 
            @click="setAbsence(form.date)"
            :disabled="!form.date"
            >
            Générer
            </v-btn>
        </v-col>
        </v-row>
        </v-toolbar-title>
      </v-toolbar>
      <v-card>
        <Datatable :titleDatatable="`Liste des absences du ${formatDate(form.date)}`" :headers="headers" :items="absencesAll" :functionOnClickAddButton="goTo" >   
            <template v-slot:item.actions="{item}">
                <v-icon size="small" class="me-2" title="Modifier" @click="editItem(item.raw)" :icon="icons.mdiPencil" color="orange">
                </v-icon>
                <v-icon size="small" class="me-2" title="Supprimer" @click="deleteItem(item.raw)" :icon="icons.mdiDelete" color="red">
                </v-icon>
            </template>
        </Datatable>
      </v-card>
    </v-card-text>
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