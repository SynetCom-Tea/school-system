<template>
  <AuthenticatedLayout>
    <!-- En-tête amélioré -->
    <Toolbar
      styleToolbar="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;"
      :icon="icons.mdiAccountSchool"
      :toolbarTitle="'ESPACE DE VERSEMENT - ' + Title"
    ></Toolbar>

    <!-- Conteneur principal -->
    <div class="main-container">
      <!-- Section Exportation - Design moderne -->
      <div class="export-section-modern">
        <div class="section-header">
          <div class="header-content">
            <v-icon color="#2196F3" size="28" class="me-3">mdi-database-export</v-icon>
            <div>
              <h2 class="section-title">Exportation des Données</h2>
              <p class="section-subtitle">Exportez les inscriptions dans différents formats</p>
            </div>
          </div>
          <v-chip color="primary" variant="flat" prepend-icon="mdi-shield-check">
            Sécurisé
          </v-chip>
        </div>

        <!-- Cartes d'exportation -->
        <div class="export-cards">
          <!-- Carte PDF -->
          <div class="export-card pdf-card">
            <div class="card-header">
              <div class="card-icon pdf">
                <v-icon color="#F44336" size="32">mdi-file-pdf-box</v-icon>
              </div>
              <div class="card-title">
                <h3>Format PDF</h3>
                <span class="file-format">.pdf</span>
              </div>
            </div>
            
            <p class="card-description">
              Export haute qualité pour impression et archivage
            </p>

            <v-menu location="bottom" offset="10">
              <template v-slot:activator="{ props }">
                <v-btn 
                  v-bind="props"
                  color="#F44336"
                  variant="flat"
                  size="large"
                  class="export-btn"
                  prepend-icon="mdi-download"
                >
                  Exporter en PDF
                </v-btn>
              </template>
              <v-list class="export-menu-modern">
                <v-list-subheader class="menu-header">
                  <v-icon color="#F44336">mdi-file-pdf-box</v-icon>
                  Options PDF
                </v-list-subheader>
                <v-list-item 
                  v-for="item in pdfOptions"
                  :key="item.value"
                  @click="exportData(item.value, 'pdf')"
                  class="menu-item"
                >
                  <template v-slot:prepend>
                    <v-icon :color="item.color">{{ item.icon }}</v-icon>
                  </template>
                  <v-list-item-title>{{ item.title }}</v-list-item-title>
                  <v-list-item-subtitle>{{ item.subtitle }}</v-list-item-subtitle>
                </v-list-item>
              </v-list>
            </v-menu>
          </div>

          <!-- Carte Excel -->
          <div class="export-card excel-card">
            <div class="card-header">
              <div class="card-icon excel">
                <v-icon color="#4CAF50" size="32">mdi-file-excel-box</v-icon>
              </div>
              <div class="card-title">
                <h3>Format Excel</h3>
                <span class="file-format">.xlsx</span>
              </div>
            </div>
            
            <p class="card-description">
              Données structurées pour analyse et traitement
            </p>

            <v-menu location="bottom" offset="10">
              <template v-slot:activator="{ props }">
                <v-btn 
                  v-bind="props"
                  color="#4CAF50"
                  variant="flat"
                  size="large"
                  class="export-btn"
                  prepend-icon="mdi-download"
                >
                  Exporter en Excel
                </v-btn>
              </template>
              <v-list class="export-menu-modern">
                <v-list-subheader class="menu-header">
                  <v-icon color="#4CAF50">mdi-file-excel-box</v-icon>
                  Options Excel
                </v-list-subheader>
                <v-list-item 
                  v-for="item in excelOptions"
                  :key="item.value"
                  @click="exportData(item.value, 'excel')"
                  class="menu-item"
                >
                  <template v-slot:prepend>
                    <v-icon :color="item.color">{{ item.icon }}</v-icon>
                  </template>
                  <v-list-item-title>{{ item.title }}</v-list-item-title>
                  <v-list-item-subtitle>{{ item.subtitle }}</v-list-item-subtitle>
                </v-list-item>
              </v-list>
            </v-menu>
          </div>
        </div>

        <!-- Indicateur amélioré -->
        <div class="export-hint-modern">
          <div class="hint-content">
            <v-icon color="#FFD600" class="hint-icon">mdi-lightbulb-on-outline</v-icon>
            <div>
              <strong>Conseil :</strong> Choisissez le format adapté à vos besoins
            </div>
          </div>
          <div class="hint-tips">
            <v-chip size="small" variant="outlined" color="primary">PDF pour impression</v-chip>
            <v-chip size="small" variant="outlined" color="success">Excel pour analyse</v-chip>
          </div>
        </div>
      </div>

<!-- Section Génération de Documents - Design moderne -->
        <div class="generation-section-modern">
          <div class="section-header">
            <div class="header-content">
              <v-icon color="#9C27B0" size="28" class="me-3">mdi-file-cog</v-icon>
              <div>
                <h2 class="section-title">Génération de Documents</h2>
                <p class="section-subtitle">Créez des listes et fiches personnalisées</p>
              </div>
            </div>
          </div>

          <div class="generation-cards">
            <!-- Fiche de Présence -->
            <div class="generation-card">
              <div class="card-icon-wrapper presence">
                <v-icon color="#4CAF50" size="28">mdi-clipboard-check</v-icon>
              </div>
              <div class="card-content">
                <h3>Fiche de Présence</h3>
                <p class="text-muted">Génère une fiche avec cases à cocher pour le contrôle quotidien</p>
                <div class="card-features">
                  <v-chip size="small" color="green-lighten-5" text-color="green">
                    <v-icon size="small" class="me-1">mdi-checkbox-marked</v-icon>
                    Cases à cocher
                  </v-chip>
                  <v-chip size="small" color="blue-lighten-5" text-color="blue">
                    <v-icon size="small" class="me-1">mdi-calendar</v-icon>
                    Quotidien
                  </v-chip>
                </div>
              </div>
                <v-btn 
                    color="success" 
                    :href="route('scolarite.fiche.presence', { section: vSectionID })"
                    target="_blank"
                    prepend-icon="mdi-file-document-outline"
                  >
                Générer
              </v-btn>
            </div>

            <!-- Liste d'Affichage -->
            <div class="generation-card">
              <div class="card-icon-wrapper display">
                <v-icon color="#2196F3" size="28">mdi-view-list</v-icon>
              </div>
              <div class="card-content">
                <h3>Liste d'Affichage</h3>
                <p class="text-muted">Liste simplifiée pour affichage en classe</p>
                <div class="card-features">
                  <v-chip size="small" color="blue-lighten-5" text-color="blue">
                    <v-icon size="small" class="me-1">mdi-format-list-bulleted</v-icon>
                    Format simplifié
                  </v-chip>
                  <v-chip size="small" color="purple-lighten-5" text-color="purple">
                    <v-icon size="small" class="me-1">mdi-wall</v-icon>
                    Affichage
                  </v-chip>
                </div>
              </div>
               <v-btn 
                    color="primary" 
                    :href="route('scolarite.liste.affichage', { section: vSectionID })"
                    target="_blank"
                    prepend-icon="mdi-view-list"
                  >
                Générer
              </v-btn>
            </div>
          </div>

          <!-- Options avancées améliorées -->
          <div class="advanced-options">
            <v-expansion-panels variant="accordion">
              <v-expansion-panel class="advanced-panel">
                <v-expansion-panel-title expand-icon="mdi-chevron-down" collapse-icon="mdi-chevron-up">
                  <div class="panel-header">
                    <v-icon color="#FF9800" class="me-2">mdi-cog</v-icon>
                    <span>Options avancées de génération</span>
                  </div>
                </v-expansion-panel-title>
                <v-expansion-panel-text>
                  <div class="advanced-form">
                    <h4 class="form-title">Paramètres personnalisés</h4>
                     <form :action="route('scolarite.fiche.presence')" method="GET" class="row g-3">
                      <input type="hidden" name="section" :value="section">
                      
                      <div class="form-field">
                        <v-select
                          label="Type de période"
                          name="type_periode"
                          :items="periodTypes"
                          variant="outlined"
                          prepend-icon="mdi-calendar"
                        ></v-select>
                      </div>
                      
                      <div class="form-field">
                        <v-text-field
                          label="Période/Matière"
                          name="periode"
                          variant="outlined"
                          prepend-icon="mdi-text-box"
                        ></v-text-field>
                      </div>
                      <div class="col-md-4">
                            <v-btn type="submit" color="success" block>
                              Générer avec paramètres
                            </v-btn>
                          </div>
                    </form>
                  </div>
                </v-expansion-panel-text>
              </v-expansion-panel>
            </v-expansion-panels>
          </div>
        </div>


      <!-- Section Recherche - Design moderne -->
      <div class="search-section-modern">
        <div class="search-card">
          <div class="search-header">
            <v-icon color="#7d002c" size="28" class="me-2">mdi-magnify</v-icon>
            <h3 class="search-title">Recherche d'Inscription</h3>
          </div>
          
          <div class="search-content">
            <v-row align="center">
              <v-col cols="12" md="4">
                <v-switch 
                  v-model="recherche" 
                  @click="inscriptions = []" 
                  color="#004980" 
                  inset 
                  :label="'Recherche avec Mle/Nom & Prénom'"
                  hide-details
                ></v-switch>
              </v-col>
              <v-col cols="12" md="5">
                <TextField 
                  label="Code de l'inscription" 
                  :isRequired="true" 
                  placeholder="Saisissez le code d'inscription"
                  v-model="code"
                  variant="outlined"
                  prepend-icon="mdi-identifier"
                ></TextField>
              </v-col>
              <v-col cols="12" md="3">
                <v-btn 
                  color="primary" 
                  @click="RechercheInscription()" 
                  size="large"
                  class="search-btn"
                  prepend-icon="mdi-magnify"
                  block
                >
                  Rechercher
                </v-btn>
              </v-col>
            </v-row>
          </div>

          <!-- Résultats de recherche -->
          <v-card v-if="recherche" class="search-results-card">
            <v-card-title class="search-results-title">
              <TextField 
                label="Mle/Nom & Prénom" 
                :isRequired="true" 
                placeholder="Saisissez le matricule, nom ou prénom"
                v-model="search" 
                @update:modelValue="getItems(search)"
                variant="outlined"
                prepend-icon="mdi-account-search"
              ></TextField>
            </v-card-title>

            <v-divider></v-divider>

            <v-virtual-scroll 
              v-if="items.length > 0"
              :items="items"
              height="320"
              item-height="64"
            >
              <template v-slot:default="{ item }">
                <v-list-item
                  :title="`${item.apprenant.nom} ${item.apprenant.prenom}`"
                  :subtitle="`${item.niveau.libelle} en ${item.annee.libelle}`"
                  @click="getCodeInscription(item), RechercheInscription()"
                  class="result-item"
                >
                  <template v-slot:prepend>
                    <v-avatar color="primary" size="40">
                      <v-icon color="white" :icon="icons.mdiAccountSchool"></v-icon>
                    </v-avatar>
                  </template>

                  <template v-slot:append>
                    <v-chip size="small" color="primary" variant="flat">
                      {{ item.code }}
                    </v-chip>
                  </template>
                </v-list-item>
                <v-divider></v-divider>
              </template>
            </v-virtual-scroll>

            <div v-else class="no-results">
              <v-icon color="#7d002c" size="64" class="mb-3">mdi-database-off</v-icon>
              <p class="no-results-text">Aucune inscription trouvée</p>
            </div>
          </v-card>
        </div>
      </div>

      <!-- Section Résultats - Design moderne -->
      <div v-if="inscriptions.length > 0 && !loading" class="results-section-modern">
        <div class="results-card">
          <div class="results-header">
            <div class="student-info">
              <v-avatar color="primary" size="60" class="me-3">
                <v-icon color="white" size="32">mdi-account-school</v-icon>
              </v-avatar>
              <div>
                <h3 class="student-name">
                  {{ inscriptions[0].apprenant.nom }} {{ inscriptions[0].apprenant.prenom }}
                </h3>
                <p class="student-details">
                  {{ inscriptions[0].niveau.libelle }} • {{ inscriptions[0].annee.libelle }}
                </p>
                <p class="student-matricule">
                  Matricule: {{ inscriptions[0].apprenant.matricule }}
                </p>
              </div>
            </div>
            <v-chip 
              :color="inscriptions[0].versements.length == 0 ? 'warning' : 'success'" 
              variant="flat"
              prepend-icon="mdi-account-cash"
            >
              {{ inscriptions[0].versements.length == 0 ? 'Inscription inactive' : 'Inscription active' }}
            </v-chip>
          </div>

          <Datatable 
            :displaySearch="false" 
            :titleDatatable="getDatatableTitle()"
            :headers="headers" 
            :items="inscriptions[0].versements"  
            :functionOnClickAddButton="create" 
            :libelleButton="'Nouveau Versement'"
            class="versements-table"
          >
            <template v-slot:item.statut="{ item }">
              <v-chip :color="item.statut == 0 ? 'blue' : 'green'" variant="flat">
                <v-icon start :icon="item.statut == 0 ? 'mdi-clock' : 'mdi-check-circle'"></v-icon>
                {{ item.statut == 0 ? 'En attente' : 'Actif' }}
              </v-chip>
            </template>
            <template v-slot:item.actions="{ item }">
              <div class="action-buttons">
                <v-tooltip text="Imprimer le reçu" location="top">
                  <template v-slot:activator="{ props }">
                    <v-btn
                      v-bind="props"
                      :href="route('generateRecuVersement', { id: item.id, section: section })"
                      target="_blank"
                      icon
                      size="small"
                      color="primary"
                      variant="text"
                    >
                      <v-icon :icon="icons.mdiPrinter"></v-icon>
                    </v-btn>
                  </template>
                </v-tooltip>
                
                <v-tooltip text="Supprimer le versement" location="top">
                  <template v-slot:activator="{ props }">
                    <v-btn
                      v-bind="props"
                      @click="deleteItem(item)"
                      icon
                      size="small"
                      color="red"
                      variant="text"
                    >
                      <v-icon :icon="icons.mdiDelete"></v-icon>
                    </v-btn>
                  </template>
                </v-tooltip>
              </div>
            </template>
          </Datatable>
        </div>
      </div>

      <!-- Dialog de versement - Design moderne -->
      <v-dialog v-model="dialog" persistent width="500">
        <v-card class="dialog-card">
          <v-card-title class="dialog-header">
            <div class="dialog-title">
              <v-icon color="primary" class="me-2">mdi-account-cash</v-icon>
              <div>
                <div class="dialog-main-title">Nouveau Versement</div>
                <div class="dialog-subtitle">
                  {{ inscriptions[0]?.apprenant?.nom }} {{ inscriptions[0]?.apprenant?.prenom }}
                </div>
              </div>
            </div>
          </v-card-title>

          <v-card-text class="dialog-content">
            <v-container>
              <v-form ref="form">
                <v-row>
                  <v-col cols="12">
                    <v-switch 
                      v-model="tous_frais" 
                      @update:modelValue="calculFrais(tous_frais), form.type_frais = null" 
                      color="#004980" 
                      inset 
                      :label="'Paiement de tous les frais (Non payés)'"
                      hide-details
                    ></v-switch>
                  </v-col>

                  <v-col v-if="!tous_frais" cols="12">
                    <Autocomplete 
                      :items="type_frais"
                      item-title="etablissement_type_frais.type_frais.libelle"
                      item-value="etablissement_type_frais.type_frais.id"
                      label="Type de frais"
                      isRequired
                      v-model="form.type_frais"
                      @update:modelValue="calculFrais()"
                      :rules="[(v) => !!v || 'Ce champ est requis!']"
                      variant="outlined"
                      prepend-icon="mdi-cash"
                    ></Autocomplete>
                  </v-col>

                  <v-col cols="12" v-if="!tous_frais">
                    <TextField
                      label="Montant"
                      isRequired
                      v-model="form.montant"
                      @update:modelValue="calculFrais()"
                      placeholder="Montant du versement"
                      :rules="[(v) => !!v || 'Ce champ est requis!']"
                      variant="outlined"
                      prepend-icon="mdi-currency-usd"
                      type="number"
                    ></TextField>
                  </v-col>
                </v-row>

                <v-row v-if="spinnerLoading" justify="center" class="my-4">
                  <v-col cols="auto">
                    <half-circle-spinner
                      :animation-duration="1000"
                      :size="60"
                      color="#3c80e7"
                    />
                  </v-col>
                </v-row>
              </v-form>
            </v-container>
            
            <div class="amount-info" :class="{ 'error': done, 'success': !done }">
              <v-icon v-if="done" color="warning" class="me-1">mdi-alert</v-icon>
              <v-icon v-else color="success" class="me-1">mdi-information</v-icon>
              {{ restant }}
            </div>
          </v-card-text>

          <v-card-actions class="dialog-actions">
            <v-btn
              color="grey"
              variant="text"
              @click="dialog = false"
              prepend-icon="mdi-close"
            >
              Annuler
            </v-btn>
            <v-spacer></v-spacer>
            <v-btn
              color="primary"
              variant="flat"
              :disabled="done || spinnerLoading"
              @click="submit(tous_frais)"
              prepend-icon="mdi-check"
              :loading="spinnerLoading"
            >
              Confirmer le versement
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <!-- Loader -->
      <div class="loader" v-if="loading"></div>
    </div>
  </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router, useForm } from "@inertiajs/vue3";
import { computed } from "vue";
import { HalfCircleSpinner } from 'epic-spinners'
import {
  mdiChevronLeft,
  mdiChevronRight,
  mdiChevronDown,
  mdiAccountCircle,
  mdiAccountSchool,
  mdiCurrencyUsd,
  mdiDelete,
  mdiCash,
  mdiPrinter,
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
  mdiFile,
} from "@mdi/js";

export default {
  components: {
    AuthenticatedLayout,
    HalfCircleSpinner,
  },

  props: ["section", "type_frais", "resultCalculFrais"],
  data() {
    return {
      headers: [
        {
          title: "Type de frais",
          align: "start",
          key: "frais.etablissement_type_frais.type_frais.libelle",
          sortable: false,
        },
        { title: "Montant", align: "center", key: "montant" },
        { title: "Date du versement", align: "center", key: "created_at" },
        { title: 'Actions', align: 'center', key: 'actions' },
      ],
      icons: {
        mdiChevronDown,
        mdiChevronLeft,
        mdiChevronRight,
        mdiMagnify,
        mdiSort,
        mdiAccountCircle,
        mdiAccountSchool,
        mdiPrinter,
        mdiCurrencyUsd,
        mdiPlus,
        mdiClose,
        mdiDelete,
        mdiCash,
        mdiArrowDown,
        mdiArrowUp,
        mdiHeart,
        mdiMinus,
        mdiCheck,
        mdiPencil,
        mdiAlertCircle,
        mdiFile,
      },
      code: '',
      search: '',
      tous_frais: null,
      spinnerLoading: false,
      loading: false,
      dialog: false,
      done: false,
      recherche: null,
      items: [],
      inscriptions: [],
      restant: 'Aucune information disponible',
      form: useForm({
        montant: 0,
        type_frais: null,
      }),
      pdfOptions: [
        {
          value: 'all',
          title: 'Tous les inscriptions',
          subtitle: 'Export complet',
          icon: 'mdi-file-multiple',
          color: '#F44336'
        },
        {
          value: 'payees',
          title: 'Inscriptions payées',
          subtitle: 'Uniquement les payées',
          icon: 'mdi-check-circle',
          color: '#4CAF50'
        },
        {
          value: 'non-payees',
          title: 'Inscriptions non payées',
          subtitle: 'Uniquement les impayées',
          icon: 'mdi-alert-circle',
          color: '#FF9800'
        }
      ],
      excelOptions: [
        {
          value: 'all',
          title: 'Tous les inscriptions',
          subtitle: 'Export complet',
          icon: 'mdi-file-multiple',
          color: '#4CAF50'
        },
        {
          value: 'payees',
          title: 'Inscriptions payées',
          subtitle: 'Uniquement les payées',
          icon: 'mdi-check-circle',
          color: '#4CAF50'
        },
        {
          value: 'non-payees',
          title: 'Inscriptions non payées',
          subtitle: 'Uniquement les impayées',
          icon: 'mdi-alert-circle',
          color: '#FF9800'
        },
        {
          value: 'combinees',
          title: 'Inscriptions combinées',
          subtitle: 'Avec statistiques',
          icon: 'mdi-merge',
          color: '#9C27B0'
        }
      ],
      periodTypes: [
        { title: 'Journalier', value: 'jour' },
        { title: 'Hebdomadaire', value: 'semaine' },
        { title: 'Mensuel', value: 'mois' },
        { title: 'Par matière', value: 'matiere' }
      ]
    };
  },

  computed: {
    Title() {
      switch (this.section) {
        case '1':
          return "SECTION PRIMAIRE";
        case '2':
          return "SECTION SECONDAIRE";
        case '3':
          return "SECTION SUPERIEURE";
        default:
          return "SECTION UNIVERSITAIRE";
      }
    },
    vSectionID() {
      return this.section;
    }
  },

  methods: {
    getDatatableTitle() {
      if (this.inscriptions[0]?.versements?.length == 0) {
        return 'Aucun versement enregistré';
      }
      return `Versements de ${this.inscriptions[0]?.apprenant?.nom} ${this.inscriptions[0]?.apprenant?.prenom}`;
    },

    getCodeInscription(ligne) {
      this.code = ligne.code;
    },

    async getItems(search) {
      if (search) {
        axios
          .get(
            route("getInscriptionAboutMle", {
              search: search ?? null,
              section: this.section,
            })
          )
          .then((item) => {
            if (item.data == "ERREUR") {
              // Gérer l'erreur
            } else {
              this.items = item.data;
            }
          });
      }
    },

    calculFrais(type) {
      if (type != false) {
        axios
          .get(
            route("getCalculFrais", {
              inscription: this.inscriptions[0].id ?? null,
              type_frais: this.form.type_frais,
              tous_frais: type,
              section: this.section,
            })
          )
          .then((res) => {
            if (res.data == "ERREUR") {
              // Gérer l'erreur
            } else if (res.data.code == 1) {
              let r = res.data.list.total - res.data.list.somme_versee;
              if (r == 0) {
                this.restant = 'Vous avez payé toute la somme du frais sélectionné';
              } else {
                this.restant = 'Il vous reste ' + r + ' FCFA à payer pour le type de frais sélectionné';
              }
              if ((parseInt(r) < parseInt(this.form.montant)) || r == 0) {
                this.done = true;
              } else {
                this.done = false;
              }
            } else {
              this.restant = 'Pas de frais pour ce type de frais pour l\'année en cours';
              this.done = true;
            }
          });
      }
    },

    create() {
      this.dialog = true;
    },

    async RechercheInscription() {
      if (this.code.trim() == '') {
        return;
      }
      this.inscriptions = await this.ajax(this.code);
    },

    async ajax(item) {
      this.search = '';
      this.items = [];
      this.recherche = false;
      this.loading = true;
      let axiosResult = [];
      
      if (item) {
        axiosResult = await axios
          .get(
            route("getInscriptionForVersement", {
              code: item ?? null,
              section: this.section,
            })
          )
          .then((res) => {
            this.loading = false;
            if (typeof res.data == "string" || typeof res.data == "undefined") {
              // Gérer l'erreur
            } else {
              return res.data;
            }
          });
      }
      return axiosResult ?? [];
    },

    deleteItem(item) {
      this.$swal({
        title: 'Confirmer la suppression',
        text: 'Êtes-vous sûr de vouloir supprimer ce versement ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Oui, supprimer',
        cancelButtonText: 'Annuler'
      }).then((result) => {
        if (result.isConfirmed) {
          axios
            .get(
              route("deleteVersement", {
                id: item.id ?? null,
                inscription: this.inscriptions[0].id ?? null,
                type_frais: this.form.type_frais,
                section: this.section,
              })
            )
            .then((del) => {
              if (del.data == "ERREUR") {
                this.showError('Erreur serveur');
              } else if (del.data.code == 1) {
                this.inscriptions = [];
                this.inscriptions = del.data.list ?? [];
                this.showSuccess('Suppression effectuée avec succès');
              }
            });
        }
      });
    },

    async submit(type) {
      const { valid } = await this.$refs.form.validate();
      if (valid) {
        this.spinnerLoading = true;
        axios
          .get(
            route("postVersement", {
              inscription: this.inscriptions[0].id ?? null,
              montant: this.form.montant,
              type_frais: this.form.type_frais,
              section: this.section,
              tous_frais: type
            })
          )
          .then((response) => {
            this.spinnerLoading = false;
            if (response.data == "ERREUR") {
              this.showError('Erreur serveur');
            } else if (response.data.code == 1) {
              this.form.reset();
              this.dialog = false;
              this.inscriptions = [];
              this.inscriptions = response.data.list ?? [];
              this.showSuccess('Versement enregistré avec succès');
            } else if (response.data.code == 0) {
              this.showWarning('Vous avez déjà versé les frais d\'inscriptions');
            }
          });
      }
    },

    exportData(type, format) {
      let routeName = '';
      if (type === 'all') {
        routeName = 'inscriptions.export';
      } else if (type === 'payees') {
        routeName = 'inscriptions.export.payees';
      } else if (type === 'non-payees') {
        routeName = 'inscriptions.export.non-payees';
      } else if (type === 'combinees') {
        routeName = 'inscriptions.export.combinees';
      } else {
        console.error('Type d\'exportation inconnu');
        return;
      }

      const url = route(routeName, { format: format });
      window.location.href = url;
    },

    showSuccess(message) {
      this.$swal({
        icon: 'success',
        title: 'Succès',
        text: message,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
      });
    },

    showError(message) {
      this.$swal({
        icon: 'error',
        title: 'Erreur',
        text: message,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
      });
    },

    showWarning(message) {
      this.$swal({
        icon: 'warning',
        title: 'Attention',
        text: message,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
      });
    }
  },

  provide() {
    return {
      vmodeldialogFrais: computed(() => this.dialogFrais),
    };
  },
};
</script>

<style scoped>
.main-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}

/* Section Exportation */
.export-section-modern {
  background: white;
  border-radius: 16px;
  padding: 24px;
  margin-bottom: 24px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  border: 1px solid #e0e0e0;
}

.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
  padding-bottom: 16px;
  border-bottom: 2px solid #f5f5f5;
}

.header-content {
  display: flex;
  align-items: center;
}

.section-title {
  font-size: 1.5rem;
  font-weight: 600;
  color: #2c3e50;
  margin: 0;
}

.section-subtitle {
  color: #7f8c8d;
  margin: 4px 0 0 0;
  font-size: 0.9rem;
}

.export-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 20px;
  margin-bottom: 24px;
}

.export-card {
  background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
  border-radius: 12px;
  padding: 24px;
  border: 1px solid #e9ecef;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.export-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(90deg, var(--card-color, #667eea), #764ba2);
}

.pdf-card { --card-color: #F44336; }
.excel-card { --card-color: #4CAF50; }

.export-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.card-header {
  display: flex;
  align-items: center;
  margin-bottom: 16px;
}

.card-icon {
  width: 60px;
  height: 60px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 16px;
}

.card-icon.pdf { background: rgba(244, 67, 54, 0.1); }
.card-icon.excel { background: rgba(76, 175, 80, 0.1); }

.card-title h3 {
  margin: 0;
  font-size: 1.2rem;
  font-weight: 600;
}

.file-format {
  color: #7f8c8d;
  font-size: 0.8rem;
  font-weight: 500;
}

.card-description {
  color: #5a6c7d;
  margin-bottom: 20px;
  line-height: 1.5;
}

.export-btn {
  width: 100%;
  font-weight: 600;
}

/* Section Génération */
.generation-section-modern {
  background: white;
  border-radius: 16px;
  padding: 24px;
  margin-bottom: 24px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  border: 1px solid #e0e0e0;
}

.generation-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
  gap: 20px;
  margin-bottom: 24px;
}

.generation-card {
  display: flex;
  align-items: center;
  background: #f8f9fa;
  border-radius: 12px;
  padding: 20px;
  border: 1px solid #e9ecef;
  transition: all 0.3s ease;
}

.generation-card:hover {
  background: white;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  transform: translateY(-2px);
}

.card-icon-wrapper {
  width: 50px;
  height: 50px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 16px;
  flex-shrink: 0;
}

.card-icon-wrapper.presence { background: rgba(76, 175, 80, 0.1); }
.card-icon-wrapper.display { background: rgba(33, 150, 243, 0.1); }

.card-content {
  flex: 1;
}

.card-content h3 {
  margin: 0 0 8px 0;
  font-size: 1.1rem;
  font-weight: 600;
  color: #2c3e50;
}

.card-features {
  display: flex;
  gap: 8px;
  margin-top: 12px;
}

.generate-btn {
  margin-left: 16px;
  flex-shrink: 0;
}

/* Options avancées */
.advanced-options {
  margin-top: 24px;
}

.advanced-panel {
  border-radius: 12px !important;
  overflow: hidden;
}

.panel-header {
  display: flex;
  align-items: center;
  font-weight: 600;
  color: #2c3e50;
}

.advanced-form {
  padding: 8px 0;
}

.form-title {
  margin-bottom: 16px;
  color: #2c3e50;
  font-weight: 600;
}

.form-grid {
  display: grid;
  grid-template-columns: 1fr 1fr auto;
  gap: 16px;
  align-items: end;
}

.generate-advanced-btn {
  height: 56px;
}

/* Section Recherche */
.search-section-modern {
  margin-bottom: 24px;
}

.search-card {
  background: white;
  border-radius: 16px;
  padding: 24px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  border: 1px solid #e0e0e0;
}

.search-header {
  display: flex;
  align-items: center;
  margin-bottom: 20px;
  padding-bottom: 16px;
  border-bottom: 2px solid #f5f5f5;
}

.search-title {
  font-size: 1.3rem;
  font-weight: 600;
  color: #2c3e50;
  margin: 0;
}

.search-btn {
  height: 56px;
  font-weight: 600;
}

.search-results-card {
  margin-top: 20px;
  border-radius: 12px;
  overflow: hidden;
}

.search-results-title {
  padding-bottom: 16px;
}

.result-item {
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.result-item:hover {
  background-color: #f8f9fa;
}

.no-results {
  padding: 40px 20px;
  text-align: center;
  color: #7f8c8d;
}

.no-results-text {
  margin: 0;
  font-size: 1.1rem;
}

/* Section Résultats */
.results-section-modern {
  margin-bottom: 24px;
}

.results-card {
  background: white;
  border-radius: 16px;
  padding: 24px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  border: 1px solid #e0e0e0;
}

.results-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
  padding-bottom: 20px;
  border-bottom: 2px solid #f5f5f5;
}

.student-info {
  display: flex;
  align-items: center;
}

.student-name {
  font-size: 1.4rem;
  font-weight: 600;
  color: #2c3e50;
  margin: 0 0 4px 0;
}

.student-details {
  color: #7f8c8d;
  margin: 0 0 4px 0;
  font-size: 1rem;
}

.student-matricule {
  color: #004980;
  font-weight: 500;
  margin: 0;
}

.versements-table {
  margin-top: 20px;
}

.action-buttons {
  display: flex;
  gap: 8px;
  justify-content: center;
}

/* Dialog */
.dialog-card {
  border-radius: 16px;
  overflow: hidden;
}

.dialog-header {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 20px 24px;
}

.dialog-title {
  display: flex;
  align-items: center;
}

.dialog-main-title {
  font-size: 1.3rem;
  font-weight: 600;
}

.dialog-subtitle {
  font-size: 0.9rem;
  opacity: 0.9;
}

.dialog-content {
  padding: 24px;
}

.amount-info {
  padding: 12px 16px;
  border-radius: 8px;
  margin-top: 16px;
  font-weight: 500;
  display: flex;
  align-items: center;
}

.amount-info.success {
  background: rgba(76, 175, 80, 0.1);
  color: #2e7d32;
  border: 1px solid rgba(76, 175, 80, 0.2);
}

.amount-info.error {
  background: rgba(255, 152, 0, 0.1);
  color: #ef6c00;
  border: 1px solid rgba(255, 152, 0, 0.2);
}

.dialog-actions {
  padding: 16px 24px;
  background: #f8f9fa;
}

/* Loader */
.loader,
.loader:after {
  border-radius: 50%;
  width: 10em;
  height: 10em;
}

.loader {
  margin: 60px auto;
  font-size: 10px;
  position: relative;
  text-indent: -9999em;
  border-top: 1.1em solid rgba(255, 255, 255, 0.2);
  border-right: 1.1em solid rgba(255, 255, 255, 0.2);
  border-bottom: 1.1em solid rgba(255, 255, 255, 0.2);
  border-left: 1.1em solid #3c80e7;
  -webkit-transform: translateZ(0);
  -ms-transform: translateZ(0);
  transform: translateZ(0);
  -webkit-animation: load8 1.1s infinite linear;
  animation: load8 1.1s infinite linear;
}

@-webkit-keyframes load8 {
  0% { -webkit-transform: rotate(0deg); transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); transform: rotate(360deg); }
}

@keyframes load8 {
  0% { -webkit-transform: rotate(0deg); transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); transform: rotate(360deg); }
}

/* Indicateur amélioré */
.export-hint-modern {
  background: linear-gradient(135deg, #fff9e6 0%, #fff3cd 100%);
  border: 1px solid #ffeaa7;
  border-radius: 12px;
  padding: 16px 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.hint-content {
  display: flex;
  align-items: center;
  gap: 12px;
}

.hint-icon {
  flex-shrink: 0;
}

.hint-tips {
  display: flex;
  gap: 8px;
}

/* Menus modernes */
.export-menu-modern {
  border-radius: 12px;
  padding: 8px;
}

.menu-header {
  font-weight: 600;
  color: #2c3e50;
  display: flex;
  align-items: center;
  gap: 8px;
}

.menu-item {
  border-radius: 8px;
  margin: 4px 0;
}

/* Responsive */
@media (max-width: 768px) {
  .main-container {
    padding: 16px;
  }
  
  .export-cards,
  .generation-cards {
    grid-template-columns: 1fr;
  }
  
  .section-header {
    flex-direction: column;
    gap: 12px;
    align-items: flex-start;
  }
  
  .results-header {
    flex-direction: column;
    gap: 16px;
    align-items: flex-start;
  }
  
  .student-info {
    flex-direction: column;
    text-align: center;
    gap: 12px;
  }
  
  .export-hint-modern {
    flex-direction: column;
    gap: 12px;
    text-align: center;
  }
  
  .hint-tips {
    justify-content: center;
    flex-wrap: wrap;
  }
  
  .form-grid {
    grid-template-columns: 1fr;
    gap: 16px;
  }
  
  .generation-card {
    flex-direction: column;
    text-align: center;
  }
  
  .generate-btn {
    margin-left: 0;
    margin-top: 16px;
    width: 100%;
  }
}

@media (max-width: 480px) {
  .search-content .row {
    gap: 16px;
  }
  
  .dialog-card {
    margin: 16px;
    width: calc(100% - 32px);
  }
  
  .card-features {
    flex-direction: column;
    align-items: center;
  }
}
</style>