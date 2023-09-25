<template>
  <AuthenticatedLayout>
    <Toolbar
      styleToolbar="background-color: white;"
      :icon="icons.mdiAccountSchool"
      toolbarTitle="Inscriptions"
    ></Toolbar>
    <div class="mt-3">
      <v-container class="bg-primary-variant">
        <v-row align="center">
          <v-col cols="3">
            <Autocomplete
              :items="academicYears"
              v-model="year"
              class="mt-2"
              itemValue="libelle"
              itemTitle="libelle"
              isRequired
              label="Année"
              @update:modelValue="onChangeModelValueYears(year)"
            ></Autocomplete>
          </v-col>
          <v-col cols="4">
            <Autocomplete
              :items="getSections"
              v-model="section"
              class="mt-2"
              itemValue="id"
              itemTitle="libelle"
              isRequired
              label="Section"
              @update:modelValue="onChangeModelValueSections(section, year)"
            ></Autocomplete>
          </v-col>
          <v-col cols="4">
            <Autocomplete
              v-if="section == 1"
              :items="niveauxPrimaire"
              class="mt-2"
              v-model="primaire"
              itemValue="id"
              itemTitle="libelle"
              isRequired
              label="Niveau primaire"
              @update:modelValue="
                onChangeModelValueNiveaux('primaire', primaire, section, year)
              "
            ></Autocomplete>

            <Autocomplete
              v-if="section == 2"
              :items="niveauxSecondaire"
              v-model="secondaire"
              itemValue="id"
              itemTitle="libelle"
              isRequired
              label="Secondaire"
              @update:modelValue="
                onChangeModelValueNiveaux('secondaire', secondaire, section, year)
              "
            ></Autocomplete>
          </v-col>
        </v-row>
        <v-btn color="primary" @click="reset()"> Réinitialiser</v-btn>
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
        @click:row="onClickRow"
      >
        <template v-slot:contentDialogUpdateDetail>
          <v-dialog v-model="onDetailUpdate">
            <h1>Contenu</h1>
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
  getNiveauxPrimaire,
  getNiveauxSecondaire,
  getAcademicYears,
} from "../../utils/commonFunctions.js";
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
      year: null,
      annee: null,
      section: null,
      primaire: null,
      secondaire: null,
      niveauxPrimaire: [],
      niveauxSecondaire: [],
      headers: [
        {
          title: "N°",
          align: "start",
          key: "apprenant.matricule",
          sortable: false,
        },
        { title: "Nom", align: "center", key: "apprenant.nom" },
        { title: "Prénom", align: "center", key: "apprenant.prenom" },
        { title: "Niveau", align: "center", key: "classe.code" },

        {
          title: "Actions",
          key: "actions",
          sortable: false,
        },
      ],
      subscribers: [],
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
      dParams: {},
      academicYears: [],
      onDetailUpdate: false,
      dialogDetailUpdate: true,
      selectedItemForUpdate: "",
      listSections: [],
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
    // console.log("page:", this.$page.props);

    this.academicYears = await this.getAcademicYears();

    this.getSections;
  },
  computed: {
    getSections() {
      let list = [];
      let page = this.$page.props.sections;
      if (page) {
        list = page[0].sections;
      }
      return list ?? [];
    },
  },
  methods: {
    getNiveauxPrimaire,
    getNiveauxSecondaire,
    getAcademicYears,
    onClickRow(value) {
      console.log("onClickRow:", value);
    },
    reset() {
      this.dParams = {};
    },
    async onChangeModelValueNiveaux(classe, value, section, year) {
      let niveau;
      if (classe == "primaire" && value) {
        niveau = this.niveauxPrimaire.find((el) => el.id == value);
      }
      if (classe == "secondaire" && value) {
        niveau = this.niveauxSecondaire.find((el) => el.id == value);
      }
      this.dParams = {
        section: classe,
        idSection: section,
        niveauSection: niveau ?? "niveau0",
        academicYear: year,
      };
      let getData = await this.getListUsers(this.dParams);
      this.subscribers = this.customizeData(getData);
    },
    async onChangeModelValueYears(year) {
      console.log("year from onChangeModelValueYears", year);
    },
    async onChangeModelValueSections(e, year) {
      let list;
      this.dParams = {
        idSection: e,
        niveauSection: "niveau0",
        academicYear: year,
      };
      let getData = await this.getListUsers(this.dParams);
      this.subscribers = this.customizeData(getData);

      if (e && e == 1) {
        list = await this.getNiveauxPrimaire();
        this.niveauxPrimaire = list;
      }
      if (e && e == 2) {
        list = await this.getNiveauxSecondaire();
        this.niveauxSecondaire = list;
      }
    },

    async getListUsers(params) {
      let axiosResult = [];
      let items = [];
      let vItems = [];
      console.log("params from getListUsers:", params);
      if (params) {
        axiosResult = await axios
          .get(
            route("getInscriptionsByYearAndSection", {
              year: params.academicYear,
              section: params.idSection,
              niveau: params.niveauSection ?? null,
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
      }
      return axiosResult ?? [];
    },
    customizeData(data) {
      let flattenedData = data ? data.flat() : [];
      let columns = [];
      let apprenant, classe, niveau;
      if (flattenedData || flattenedData.length > 0) {
        flattenedData.forEach((element, index) => {
          if (element) {
            apprenant = element.apprenant;
            classe = element.classe_annee?.classe;
            niveau = element.classe_annee?.classe?.niveau;

            columns.push({
              apprenant: element.apprenant,
              classe: element.classe_annee?.classe,
              niveau: element.classe_annee?.classe?.niveau,
            });
          }
        });
      }
      console.log("flattenedData", columns);
      return columns ?? [];
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
