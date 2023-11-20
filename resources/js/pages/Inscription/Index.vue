<template>
  <AuthenticatedLayout>
    <Toolbar
      styleToolbar="background-color: white;"
      :icon="icons.mdiAccountSchool"
      :toolbarTitle="'LISTE DES INSCRITS DE LA ' + Title   "
    ></Toolbar>
    <div style="margin: 10px; border: 2px solid #7d002c; padding: 10px; border-radius: 25px"
      class="mt-3">
      <v-container class="bg-primary-variant">
        <v-row align="center">
          <v-col cols="3">
              <v-switch class="mt-5" v-model="recherche" color="#004980" inset :label="'Recherche avec Nom et prenom'"></v-switch>
          </v-col>

          <!-- /////////////////////////////////////////// -->
          <v-col cols="1" v-if="!recherche"></v-col>
          <v-col cols="5" v-if="!recherche">
              <TextField class="mt-5" label="Matricule" :isRequired="true" placeholder="Matricule" v-model="matricule"></TextField>
          </v-col>
          <v-col cols="3" v-if="recherche">
              <TextField class="mt-5" label="Nom" :isRequired="true" placeholder="Nom" v-model="nom"></TextField>
          </v-col>
          <v-col cols="3" v-if="recherche">
              <TextField class="mt-5" label="Prénom" :isRequired="true" placeholder="Prenom" v-model="prenom"></TextField>
          </v-col>
          <v-col cols="3">
            <v-btn color="primary" @click="startRechercheInscription()" style="height=80px;text-transform: none; font-size: 10px">Rechercher</v-btn>
          </v-col>

          <!-- ////////////////////////////////// -->

          <!-- <v-col cols="3">
            <Autocomplete
              :items="academicYears"
              v-model="year"
              class="mt-2"
              itemValue="id"
              itemTitle="libelle"
              isRequired
              label="Année"
              @update:modelValue="onChangeModelValueYears(year)"
            ></Autocomplete>
          </v-col> -->
          <!-- <v-col cols="3">
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
          </v-col> -->
          <!-- <v-col cols="4">
            <Autocomplete
              v-if="section == 1"
              :items="niveauxPrimaire"
              class="mt-2"
              v-model="primaire"
              itemValue="id"
              itemTitle="libelle"
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
              class="mt-2"
              itemTitle="libelle"
              label="Secondaire"
              @update:modelValue="
                onChangeModelValueNiveaux('secondaire', secondaire, section, year)
              "
            ></Autocomplete>

            <Autocomplete
              v-if="section == 3"
              :items="niveauxSuperieur"
              v-model="superieur"
              itemValue="id"
              class="mt-2"
              itemTitle="libelle"
              label="Supérieur"
              @update:modelValue="
                onChangeModelValueNiveaux('Supérieure', superieur, section, year)
              "
            ></Autocomplete>
          </v-col> -->

          <!-- <Button
            color="primary"
            sizeButton="x-large"
            style="height=70px;text-transform: none; font-size: 10px"
            @click="reset()"
          >
            Réinitialiser</Button
          > -->
        </v-row>
      </v-container>
    </div>
    <!-- <div>
      <v-container>
        <v-row>
          <v-col cols="10"></v-col>
          <v-col>
            <Button
              color="primary"
              sizeButton="x-large"
              style="height=70px;text-transform: none; font-size: 10px"
              @click="addNewInscription(null)"
            >
              Réinitialiser</Button
            >
          </v-col>
        </v-row>
      </v-container>
      
    </div> -->

     
    <div
      style="margin: 10px; border: 2px solid #7d002c; padding: 10px; border-radius: 25px"
      class="mt-3"
    >
    <v-row>
          <v-col cols="10"></v-col>
          <v-col>
            <v-btn
              color="primary"
              sizeButton="x-large"
              title="Nouvel inscription"
              :prepend-icon="icons.mdiPlus"
              @click="addNewInscription(null)"
            >
              <!-- <template v-slot:prepend>
                <v-icon color="success"></v-icon>
              </template> -->

              Inscription

              <!-- <template v-slot:append>
                <v-icon color="warning"></v-icon>
              </template> -->
            </v-btn>
            <!-- <v-btn
            icon="mdi-plus"
              color="primary"
              sizeButton="x-large"
              style="height=70px;text-transform: none; font-size: 10px"
              @click="addNewInscription(null)"
            >
              </v-btn
            > -->
          </v-col>
        </v-row><br>
      <v-data-iterator
        v-model:items-per-page="itemsPerPage"
        v-model:page="page"
        :items="subscribers"
        :search="search"
        :sort-by="sortBy"
      >
        <template v-slot:header>
          <v-toolbar dark color="secondary" class="px-2 mb-2">
            <v-text-field
              v-model="search"
              clearable
              hide-details
              :prepend-inner-icon="icons.mdiMagnify"
              placeholder="Search"
              variant="solo"
              density="comfortable"
            ></v-text-field>
            <v-spacer></v-spacer>
            <v-select
              v-model="sortKey"
              hide-details
              :items="headers"
              :item-value="(item) => item"
              :prepend-inner-icon="icons.mdiSort"
              label="Filtrer par"
              density="comfortable"
            ></v-select>
            <v-spacer></v-spacer>
            <v-btn-toggle v-model="sortOrder" mandatory>
              <Button value="asc" color="primary" :appendIcon="icons.mdiArrowUp">
                <!-- <v-icon :icon="icons.mdiArrowUp"></v-icon> -->
              </Button>
              <Button value="desc">
                <v-icon :icon="icons.mdiArrowDown"></v-icon>
              </Button>
            </v-btn-toggle>
          </v-toolbar>
        </template>

        <template v-slot:no-data>
          <!-- <span color="primary">Aucune donnée</span> -->
          <v-row>
            <v-col></v-col>
            <v-col>
              <v-btn
          @click="addNewInscription(null)"
          variant="text"
          >Nouvel inscription?</v-btn>
            </v-col>
            <v-col></v-col>
          </v-row>
          
        </template>

        <template v-slot:default="props">
          <v-row>
            <v-col
              v-for="item in props.items"
              :key="item?.matricule"
              cols="12"
              sm="6"
              md="4"
              lg="3"
            >
              <v-card>
                <v-card-title class="subheading font-weight-bold">
                  {{ item.raw?.matricule }}
                </v-card-title>

                <v-divider></v-divider>

                <v-list density="compact">
                  <v-list-item 
                    v-for="(key, index) in filteredKeys"
                    :key="index"
                    :title="key.title"
                    :class="{ 'text-blue': sortKey === key.title.toLowerCase() }"
                  >
                    <v-list-item-subtitle
                      ><span v-if="key.title != 'Détails'">{{
                        String(item.raw[key.key]) ?? "Non renseigné"
                      }}</span>

                      <div class="text-center" :key="index" v-else>
                        <v-row>
                          <v-col cols="5">
                            <a
                              style="cursor: pointer"
                              class="text-caption text-decoration-none text-primary"
                              target="_blank"
                            >
                              Documents</a
                            ></v-col
                          >
                          <v-col cols="3" @click="onclickFrais(item.raw)">
                            <a
                              style="cursor: pointer"
                              class="text-caption text-decoration-none text-secondary"
                              target="_blank"
                            >
                              Frais</a
                            ></v-col
                          >
                          <v-col cols="3" @click="onclickTuteurs(item.raw)">
                            <a
                              style="cursor: pointer"
                              class="text-caption text-decoration-none text-primary"
                              target="_blank"
                            >
                              Tuteurs</a
                            ></v-col
                          >
                        </v-row>
                        <v-row>
                          <v-col cols="4"></v-col>
                          <v-col cols="4" @click="addNewInscription(item.raw)">
                            <a
                              style="cursor: pointer"
                              class="text-caption text-decoration-none text-warning"
                              target="_blank"
                            >
                              Réinscription</a
                            ></v-col
                          >
                        </v-row>
                      </div>
                    </v-list-item-subtitle>
                  </v-list-item>
                </v-list>
              </v-card>
            </v-col>
          </v-row>
        </template>

        <template v-slot:footer>
          <div class="d-flex align-center justify-space-around pa-4">
            <span class="grey--text">Élément par page</span>
            <v-menu>
              <template v-slot:activator="{ props }">
                <v-btn
                  variant="text"
                  color="primary"
                  class="ml-2"
                  :append-icon="icons.mdiChevronDown"
                  v-bind="props"
                >
                  {{ itemsPerPage }}
                </v-btn>
              </template>
              <v-list>
                <v-list-item
                  v-for="(number, index) in itemsPerPageArray"
                  :key="index"
                  :title="number"
                  @click="itemsPerPage = number"
                ></v-list-item>
              </v-list>
            </v-menu>

            <v-spacer></v-spacer>

            <span class="mr-4 grey--text"> Page {{ page }} de {{ numberOfPages }} </span>
            <v-btn icon size="small" @click="prevPage">
              <v-icon :icon="icons.mdiChevronLeft"></v-icon>
            </v-btn>
            <v-btn icon size="small" class="ml-2" @click="nextPage">
              <v-icon :icon="icons.mdiChevronRight"></v-icon>
            </v-btn>
          </div>
        </template>
      </v-data-iterator>
      <div v-if="selectedFrais != null">
        <FraisDetail :item="selectedFrais" />
      </div>
    </div>
  </AuthenticatedLayout>
</template>
<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router, useForm } from "@inertiajs/vue3";
import { inject, provide, computed } from "vue";
import {
  getNiveauxPrimaire,
  getNiveauxSecondaire,
  getNiveauxSuperieur,
  getAcademicYears,
  generateColorsForGraph,
} from "../../utils/commonFunctions.js";
import FraisDetail from "../../components/inscriptions/FraisDetail.vue";
import {
  mdiChevronLeft,
  mdiChevronRight,
  mdiChevronDown,
  mdiAccountCircle,
  mdiAccountSchool,
  mdiCurrencyUsd,
  mdiPlus,
  mdiClose,
  mdiMagnify,
  mdiSort,
  mdiArrowDown,
  mdiArrowUp,
  mdiHeart,
  mdiMinus,
  mdiCheck,
  mdiPencil,
  mdiAlertCircle,
} from "@mdi/js";
export default {
  components: {
    FraisDetail,
    AuthenticatedLayout,
    mdiAccountCircle,
    mdiAccountSchool,
    mdiCurrencyUsd,
    mdiPlus,
    mdiClose,
    mdiHeart,
    mdiMinus,
    mdiCheck,
    mdiPencil,
    mdiAlertCircle,
  },
  //*403#
  // layout: AuthenticatedLayout,
  props: ["vSectionID","inscriptions"],
  data() {
    return {
      dialogFrais: false,
      selectedFrais: null,
      itemsPerPageArray: [3, 6, 9],
      itemsPerPage: 3,
      page: 1,
      search: "",
      sortKey: "matricule",
      sortOrder: "asc",

      // FIN
      matricule: null,
      nom: null,
      prenom: null,
      recherche: null,
      year: null,
      annee: null,
      section: this.vSectionID,
      primaire: null,
      secondaire: null,
      superieur: null,
      niveauxPrimaire: [],
      niveauxSecondaire: [],
      niveauxSuperieur: [],
      headers: [
        {
          title: "Matricule",
          align: "start",
          key: "matricule",
          sortable: false,
        },
        { title: "Année", align: "center", key: "annee_scolaire" },
        { title: "Nom & Prénom", align: "center", key: "name" },
        // { title: "Prénom", align: "center", key: "prenom" },
        { title: "Niveau/Classe", align: "center", key: "classe_code" },
        { title: "Date & Lieu Naissance", align: "center", key: "date_lieu_naissance" },
        // { title: "Lieu Naissance", align: "center", key: "lieu_naissance" },
        // { title: "Classe", align: "center", key: "classe_code" },

        {
          title: "Détails",
          key: "actions",
          sortable: false,
        },
      ],
      headers_sup: [
        {
          title: "Matricule",
          align: "start",
          key: "matricule",
          sortable: false,
        },
        { title: "Nom & Prénom", align: "center", key: "name" },
        // { title: "Prénom", align: "center", key: "prenom" },
        { title: "Année", align: "center", key: "annee" },
        { title: "Cycle/Niveau", align: "center", key: "cycle_niveau" },
        { title: "Filière", align: "center", key: "filiere" },
        { title: "Date & Lieu Naissance", align: "center", key: "date_lieu_naissance" },
        // { title: "Lieu Naissance", align: "center", key: "lieu_naissance" },
        // { title: "Classe", align: "center", key: "classe_code" },

        {
          title: "Détails",
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
        mdiChevronDown,
        mdiChevronLeft,
        mdiChevronRight,
        mdiMagnify,
        mdiSort,
        mdiAccountCircle,
        mdiAccountSchool,
        mdiCurrencyUsd,
        mdiPlus,
        mdiClose,
        mdiArrowDown,
        mdiArrowUp,
        mdiHeart,
        mdiMinus,
        mdiCheck,
        mdiPencil,
        mdiAlertCircle,
      },
      dParams: {},
      academicYears: [],

      selectedItemForUpdate: "",
      listSections: [],
      dataVersements: [],
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
    this.academicYears = await this.getAcademicYears();
    this.getSections;
  },
  computed: {
    modelValueDialogFrais: {
      get() {
        return this.dialogFrais;
      },
      set(newValue) {
        this.$emit("value", newValue);
      },
    },
    numberOfPages() {
      if (this.subscribers.length > 0)
        return Math.ceil(this.subscribers.length / this.itemsPerPage);
    },
    filteredKeys() {
      if(this.vSectionID == 1 || this.vSectionID == 2){
        return this.headers.filter((key) => {
          return key && key.title !== "Matricule";
        });
      }else if(this.vSectionID == 3 || this.vSectionID == 4){
        return this.headers_sup.filter((key) => {
          return key && key.title !== "Matricule";
        });
      }
    },
    sortBy() {
      return [
        {
          key: this.sortKey,
          order: this.sortOrder,
        },
      ];
    },
    getSections() {
      let list = [];
      let page = this.$page.props.sections;
      if (page) {
        list = page[0].sections;
      }
      return list ?? [];
    },
    Title() {
      switch (this.vSectionID) {
        case 1:
          return "SECTION PRIMAIRE";
        case 2:
          return "SECTION SECONDAIRE";
        case 3:
          return "SECTION SUPERIEURE";
        default:
          return "SECTION UNIVERSITAIRE";
      }
    },
  },
  created(){
    this.subscribers = this.customizeData(this.inscriptions)
  },
  methods: {
    getNiveauxPrimaire,
    getNiveauxSecondaire,
    getNiveauxSuperieur,
    getAcademicYears,
    generateColorsForGraph,

    startRechercheInscription(){
        axios
          .get(
            route("getInscriptionsByRecherche", {
              matricule: this.matricule ?? null,
              nom: this.nom ?? null,
              prenom: this.prenom ?? null,
              section: this.vSectionID,
            })
          )
          .then((res) => {
            console.log('response',res.data);
            if (typeof res.data == "string" || typeof res.data == "undefined") {
              // this.$toast.error("Données non valides!");
            } else {
              this.subscribers = this.customizeData(res.data);
              // return res.data; 
            }
          });
     
    },
    addNewInscription(item){
      // console.log('ismoooo',item)
      // router.post('/scolarite/inscription/page/',{apprenant:item});
      router.get(route("inscriptionPage", {apprenant: JSON.stringify(item), section: JSON.stringify(this.vSectionID)}))
    },
    onclickTuteurs(e) {},
    async onclickFrais(e) {
      this.selectedFrais = e;

      this.dialogFrais = true;
    },
    nextPage() {
      if (this.page + 1 <= this.numberOfPages) this.page += 1;
    },
    prevPage() {
      if (this.page - 1 >= 1) this.page -= 1;
    },
    onClickRow(value) {},
    reset() {
      this.dParams = {};
      this.subscribers = [];
      this.year = null;
      this.annee = null;
      this.section = null;
      this.primaire = null;
      this.secondaire = null;
      this.superieur = null;
      this.niveauxPrimaire = [];
      this.niveauxSecondaire = [];
      this.niveauxSuperieur = [];
    },
    async onChangeModelValueNiveaux(classe, value, section, year) {
      let niveau;
      if (classe == "primaire" && value) {
        niveau = this.niveauxPrimaire.find((el) => el.id == value);
      }
      if (classe == "secondaire" && value) {
        niveau = this.niveauxSecondaire.find((el) => el.id == value);
      }
      if (classe == "Supérieure" && value) {
        niveau = this.niveauxSuperieur.find((el) => el.id == value);
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
      let list;
      this.dParams = {
        idSection: this.vSectionID,
        niveauSection: "niveau0",
        academicYear: year,
      };
      let getData = await this.getListUsers(this.dParams);
      this.subscribers = this.customizeData(getData);

      if (this.vSectionID && this.vSectionID == 1) {
        list = await this.getNiveauxPrimaire();
        this.niveauxPrimaire = list;
      }
      if (this.vSectionID && this.vSectionID == 2) {
        list = await this.getNiveauxSecondaire();
        this.niveauxSecondaire = list;
      }
      if (this.vSectionID && this.vSectionID == 3) {
        list = await this.getNiveauxSuperieur();
        this.niveauxSuperieur = list;
      }
    },
    async onChangeModelValueSections(e, year) {},
    async getListUsers(params) {
      let axiosResult = [];
      let items = [];
      let vItems = [];

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
            console.log('response',res.data);
            if (typeof res.data == "string" || typeof res.data == "undefined") {
              // this.$toast.error("Données non valides!");
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
            if(element.cycle_filiere_id == null){
              niveau = element.classe_annee?.classe?.niveau;
            }else{
              niveau = element.niveau;
            }
            columns.push({
              matricule: element.apprenant?.matricule,
              name: element.apprenant?.nom + " " + element.apprenant?.prenom,
              adresse: element.apprenant?.adresse,
              date_lieu_naissance:
                element.apprenant?.date_naissance +
                " à " +
                element.apprenant?.lieu_naissance,
              lieu_naissance: element.apprenant?.lieu_naissance,
              telephone: element.apprenant?.telephone,
              classe_code: element.classe_annee?.classe?.code,
              annee_scolaire: element.classe_annee?.annee?.libelle,
              cycle_niveau: element.cycle_filiere?.cycle?.name + ' / ' + element.niveau?.libelle,
              filiere: element.cycle_filiere?.filiere?.code,
              annee: element.annee?.libelle,
              more: {
                apprenant: element.apprenant,
                classeAnnee: element.classe_annee,
              },
            });
          }
        });
      }
      return columns ?? [];
    },
    // functionOnClickAddButton() {
    //   router.get(route("inscriptions.create"));
    // },
    submitNewLine() {},
    editItem(item) {
      this.editedObject = Object.assign({}, item);
      if (item) {
        this.selectedItemForUpdate = item;
      }
    },
    deleteItem(item) {
      // console.log("item from deleteItem:", item);
    },
    onConfirmDeleting() {},

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
  provide() {
    return {
      vmodeldialogFrais: computed(() => this.dialogFrais),
    };
  },
};
</script>
