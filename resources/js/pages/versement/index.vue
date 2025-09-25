<template>
    <AuthenticatedLayout>
      <Toolbar
        styleToolbar="background-color: white;"
        :icon="icons.mdiAccountSchool"
        :toolbarTitle="'ESPACE DE VERSEMENT ' + Title   "
      ></Toolbar>
<!-- Section d'exportation - ICÔNES AVEC BADGE NOIR -->
<div class="export-section">
  <h3>Exporter les inscriptions</h3>
  
  <div class="export-icons">
    <!-- Icône PDF avec badge noir -->
    <v-menu location="bottom">
      <template v-slot:activator="{ props }">
        <div class="icon-container pdf-container">
          <v-btn 
            v-bind="props" 
            icon 
            class="pdf-icon animated-icon"
            size="x-large"
            v-tooltip="'Télécharger en PDF'"
          >
            <v-icon size="40" color="#F44336">mdi-file-pdf-box</v-icon>
            <div class="download-badge-black">↓</div>
          </v-btn>
          <span class="icon-label">PDF</span>
        </div>
      </template>
      <v-list class="export-menu">
        <v-list-subheader>📄 Exporter en PDF</v-list-subheader>
        <v-list-item @click="exportData('all', 'pdf')">
          <v-icon color="#F44336" left>mdi-file-multiple</v-icon>
          <v-list-item-title>Tous les inscriptions</v-list-item-title>
        </v-list-item>
        <v-list-item @click="exportData('payees', 'pdf')">
          <v-icon color="#4CAF50" left>mdi-check-circle</v-icon>
          <v-list-item-title>Inscriptions payées</v-list-item-title>
        </v-list-item>
        <v-list-item @click="exportData('non-payees', 'pdf')">
          <v-icon color="#FF9800" left>mdi-alert-circle</v-icon>
          <v-list-item-title>Inscriptions non payées</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu>

    <!-- Icône Excel avec badge noir -->
    <v-menu location="bottom">
      <template v-slot:activator="{ props }">
        <div class="icon-container excel-container">
          <v-btn 
            v-bind="props" 
            icon 
            class="excel-icon animated-icon"
            size="x-large"
            v-tooltip="'Télécharger en Excel'"
          >
            <v-icon size="40" color="#4CAF50">mdi-file-excel-box</v-icon>
            <div class="download-badge-black">↓</div>
          </v-btn>
          <span class="icon-label">Excel</span>
        </div>
      </template>
      <v-list class="export-menu">
        <v-list-subheader>📊 Exporter en Excel</v-list-subheader>
        <v-list-item @click="exportData('all', 'excel')">
          <v-icon color="#4CAF50" left>mdi-file-multiple</v-icon>
          <v-list-item-title>Tous les inscriptions</v-list-item-title>
        </v-list-item>
        <v-list-item @click="exportData('payees', 'excel')">
          <v-icon color="#4CAF50" left>mdi-check-circle</v-icon>
          <v-list-item-title>Inscriptions payées</v-list-item-title>
        </v-list-item>
        <v-list-item @click="exportData('non-payees', 'excel')">
          <v-icon color="#FF9800" left>mdi-alert-circle</v-icon>
          <v-list-item-title>Inscriptions non payées</v-list-item-title>
        </v-list-item>
        <v-list-item @click="exportData('combinees', 'excel')">
          <v-icon color="#9C27B0" left>mdi-merge</v-icon>
          <v-list-item-title>Inscriptions combinées</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu>
  </div>

  <!-- Indicateur visuel "Cliquez pour exporter" -->
  <div class="export-hint">
    <v-icon color="#FFD600" small>mdi-lightbulb-on</v-icon>
    <span>Cliquez sur les icônes pour exporter vos données</span>
  </div>
</div>
      <!-- Fin de la section d'exportation -->

      <div style="margin: 10px; border: 2px solid #7d002c; padding: 10px; border-radius: 25px"
        class="mt-3">
        <v-container class="bg-primary-variant">
          <v-row align="center">
           
            <v-col cols="4">
                <v-switch class="mt-5" v-model="recherche" @click="inscriptions = []" color="#004980" inset :label="'Recherche avec Mle/Nom & prenom'"></v-switch>
            </v-col>
            <v-col cols="5">
                <TextField class="mt-5" label="Entrer le Code de l'inscription" :isRequired="true" placeholder="Taper le code" v-model="code"></TextField>
            </v-col>
            <v-col cols="3">
              <v-btn color="primary" @click="RechercheInscription()" style="height:80px;text-transform: none; font-size: 10px">Rechercher</v-btn>
            </v-col>
          </v-row>
        </v-container>
      </div>
      <v-card v-if="recherche"
        class="mx-auto"
        max-width="500"
      >
        <v-card-title>
          <TextField class="mt-5" label="Entrer le Mle/Nom & Prenom" :isRequired="true" placeholder="Merci de saisir" v-model="search" @update:modelValue="getItems(search)"></TextField>

        </v-card-title>

        <v-divider></v-divider>

        <v-virtual-scroll v-if="items.length > 0"
          :items="items"
          height="320"
          item-height="48"
        >
          <template v-slot:default="{ item }">
            <v-list-item
              :title="`${item.apprenant.nom} ${item.apprenant.prenom}` "
              :subtitle="`${item.niveau.libelle} en ${item.annee.libelle}`"
              @click="getCodeInscription(item),RechercheInscription()"
            >
              <template v-slot:prepend>
                <v-icon class="bg-primary" :icon="icons.mdiAccountSchool"></v-icon>
              </template>

              <!-- <template v-slot:append>
                <v-btn
                  icon="mdi-pencil"
                  size="x-small"
                  variant="tonal"
                ></v-btn>
              </template> -->
            </v-list-item>
          </template>
        </v-virtual-scroll>
        <template v-else>
          <v-row>
            <v-col></v-col>
            <v-col>
              <span style="color:#7d002c">Aucune donnée</span>
            </v-col>
            <v-col></v-col>
          </v-row>
        </template>
      </v-card>
      <div v-if="inscriptions.length > 0 && !loading"
        style="margin: 10px; border: 2px solid #7d002c; padding: 10px; border-radius: 25px"
        class="mt-3"
      >
        <Datatable :displaySearch="false" :titleDatatable="inscriptions[0].versements.length == 0 ? 'Inscription inactive' : 'Les versements de '+inscriptions[0].apprenant.nom + ' ' + inscriptions[0].apprenant.prenom+' de l\'année academique '+ inscriptions[0].annee.libelle + ' immatriculé sous le N° '+inscriptions[0].apprenant.matricule" :headers="headers" :items="inscriptions[0].versements"  :functionOnClickAddButton="create" :libelleButton="'Versement'">
            <!-- <template v-slot:item.list="{ item, index}">
                <v-chip-group column selected-class="text-purple">
                    <v-chip v-for="tag in item.columns.list">
                    {{ tag.matiere.nom }} => {{ tag.classe.libelle }}
                    </v-chip>
                </v-chip-group>
            </template> -->
            <template v-slot:item.statut="{item}">
              <v-chip v-if="item.statut == 0">
                    <span style="color: blue;">En attente</span>
              </v-chip>
              <v-chip v-else>
                <span style="color: green;">Actif</span>
              </v-chip>
            </template>
            <template v-slot:item.actions="{item}">
              <a :href="route('generateRecuVersement', { id: item.id, section: section })" target="__blank">
                <v-icon size="small" class="me-2" :icon="icons.mdiPrinter" color="primary"></v-icon>
              </a>
                <v-icon size="small" class="me-2" title="Supprimer" @click="deleteItem(item)" :icon="icons.mdiDelete" color="red">
                </v-icon>
            </template>
        </Datatable>
      </div>
      <!-- Exemple dialog -->
  <v-row justify="center">
    <v-dialog
      v-model="dialog"
      persistent
      width="500"
    >
    
      <v-card>
        <v-card-title color="red">
          <span class="text-h6">{{ 'N° ' + inscriptions[0].code }} </span><br>
          <span class="text-h6">{{'Compte de ' + inscriptions[0].apprenant.nom + ' ' + inscriptions[0].apprenant.prenom + ' ' + inscriptions[0].annee.libelle }} </span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-form ref="form">
              <v-row>
                <v-col
                  cols="12"
                  sm="6"
                  md="12"
                >
                  <v-switch class="mt-5" v-model="tous_frais" @update:modelValue="calculFrais(tous_frais),form.type_frais = null" color="#004980" inset :label="'Payement de tous les frais (Non payés)'"></v-switch>
                </v-col>
                <v-col v-if="!tous_frais"
                  cols="12"
                  sm="6"
                  md="12"
                >
                <Autocomplete 
                    :items="type_frais"
                    item-title="etablissement_type_frais.type_frais.libelle"
                    item-value="etablissement_type_frais.type_frais.id"
                    label="Frais"
                    isRequired
                    v-model="form.type_frais"
                    @update:modelValue="calculFrais()"
                    :rules="[(v) => !!v || 'Ce champ est requis!']"
                  ></Autocomplete>
                </v-col>
              
                <v-col cols="12" v-if="!tous_frais">
                  <TextField
                    label="Montant"
                    isRequired
                    v-model="form.montant"
                    @update:modelValue="calculFrais()"
                    placeholder="Montant"
                    :rules="[(v) => !!v || 'Ce champ est requis!']"
                  ></TextField>
                  
                </v-col>
                
              </v-row>
              <v-row v-if="spinnerLoading">
                <v-col cols="5"></v-col>
                <v-col>
                  <half-circle-spinner
                    :animation-duration="1000"
                    :size="60"
                    color="#3c80e7"
                  />
                </v-col>
            </v-row>
            </v-form>
          </v-container>
          <small style="color: #7d002c;">{{ restant }}</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="red"
            variant="text"
            @click="dialog = false"
          >
            Fermer
          </v-btn>
          <v-btn
            color="blue-darken-1"
            variant="text"
            :disabled="done"
            @click="submit(tous_frais)"
          >
            Enregistrer
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>


      <!-- Exemple dialog -->
      
      <!-- <br>
        <div v-if="loading">
          <v-row>
            <v-col cols="5"></v-col>
            
            <scaling-squares-spinner :animation-duration="2000" :size="150" color="blue" />
          </v-row>
        </div> -->
      
     
      <div class="loader" v-if="loading"></div>

      <!-- <template>
        <div>
          <vue3-html2pdf
        :show-layout="false"
        :float-layout="true"
        :enable-download="true"
        :preview-modal="true"
        :paginate-elements-by-height="1400"
        filename="hee hee"
        :pdf-quality="2"
        :manual-pagination="false"
        pdf-format="a4"
        pdf-orientation="landscape"
        pdf-content-width="800px"

        @progress="onProgress($event)"
        @hasStartedGeneration="hasStartedGeneration()"
        @hasGenerated="hasGenerated($event)"
        ref="html2Pdf"
    >
        <section slot="pdf-content">
          <section class="pdf-item">
              <h4>
                  Title
              </h4>

              <span>
                  Value
              </span>
          </section>
          <div class="html2pdf__page-break"/>

    <section class="pdf-item">
        <h4>
            Title
        </h4>

        <span>
            Value
        </span>
    </section>
        </section>
    </vue3-html2pdf> -->
        <!-- </div>
      </template> -->
 
    </AuthenticatedLayout>
  </template>
  <script>
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
  import { router, useForm } from "@inertiajs/vue3";
  import { inject, provide, computed } from "vue";
  import { AtomSpinner,ScalingSquaresSpinner,HollowDotsSpinner, HalfCircleSpinner } from 'epic-spinners'
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
      AtomSpinner,
      ScalingSquaresSpinner,
      HollowDotsSpinner,
      HalfCircleSpinner,
      mdiAccountCircle,
      mdiAccountSchool,
      mdiCurrencyUsd,
      mdiPlus,
      mdiPrinter,
      mdiDelete,
      mdiCash,
      mdiClose,
      mdiHeart,
      mdiMinus,
      mdiCheck,
      mdiPencil,
      mdiAlertCircle,
    },
  
    //*403#
    // layout: AuthenticatedLayout,
    props: ["section","type_frais","resultCalculFrais"],
    data() {
      return {
        // FIN
        
        headers: [
          {
            title: "Type de frais",
            align: "start",
            key: "frais.etablissement_type_frais.type_frais.libelle",
            sortable: false,
          },
          { title: "Montant", align: "center", key: "montant" },
          { title: "Date du versement", align: "center", key: "created_at" },
          {title: 'Actions', align: 'center', key: 'actions'},
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
          { title: "Statut", align: "center", key: "statut" },
          {title: 'Actions', align: 'center', key: 'actions'},
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
        montant: 0,
        form: useForm({
          montant: 0,
          type_frais: null,
        }),
      };
    },
  
    async mounted() {
      
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
    },
    created(){
    },
    methods: {
      generateReport (recup) {
            this.$refs.html2Pdf.generatePdf()
        },
        hasGenerated(e){
          console.log('hasDowloaded',e);
        },
        onProgress(e){
          console.log('onProgress',e);
        },
        hasStartedGeneration(){
          
        },
      // reset(){
      //   this.restant = '';
      // },
      getCodeInscription(ligne){
        this.code = ligne.code
      },
      async getItems(search){
        if (search) {
         axios
          .get(
            route("getInscriptionAboutMle", {
              search: search ?? null,
              section: this.section,
            })
          )
          .then((item) => {
            console.log('response',item.data);
            if (item.data == "ERREUR") {
              // this.$toast.error("Données non valides!");
            } else {
              this.items = item.data; 
            }
            
          });
        }
      },



      calculFrais(type){
        console.log('type',type);
        this.$emit('input',this.form.montant)
        if(type != false){
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
              // this.loading = false
              console.log('response',res.data);
              if (res.data == "ERREUR") {
                // this.$toast.error("Données non valides!");
              } else if(res.data.code == 1){
                let r = res.data.list.total - res.data.list.somme_versee
                if(r == 0){
                  this.restant = 'Vous avez payé toute la somme du frais sélectionné'
                }else{
                  this.restant = 'Il vous reste ' + r + ' FCFA à payer pour le type de frais sélectionné' ; 
                }
                if((parseInt(r) < parseInt(this.form.montant)) || r == 0  ){
                  this.done = true
                }else{
                  this.done = false
                }
              }else{
                this.restant = 'Pas de frais pour ce type de frais pour l\'année en cours';
                this.done = true
              }
              
            });
          }
      },
      create(){
        this.dialog = true
      },
      addNewInscription(item){
        router.get(route("inscriptionPage", {apprenant: JSON.stringify(item), section: JSON.stringify(this.vSectionID)}))
      },
      async RechercheInscription(){
      
        if(this.code.trim() == ''){
        }else{
          this.inscriptions = await this.ajax(this.code)
        }
      },
      async ajax(item){
        this.search = ''
        this.items = []
        this.recherche = false
        this.loading = true
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
            this.loading = false
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
      deleteItem(item){
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
            console.log('response',del.data);
            if (del.data == "ERREUR") {
              this.$swal({
                  icon: 'error',
                  title: 'ERREUR',
                  text: 'Erreur serveur',
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 5000,
                  timerProgressBar: true,
              });
              // this.$toast.error("Données non valides!");
            } else if(del.data.code == 1) {
              this.inscriptions = []
              this.inscriptions = del.data.list ?? []
              this.$swal({
                  icon: 'success',
                  iconColor: '#004980',
                  color: '#004980',
                  title: 'Suppression',
                  text: 'Suppression effectuée avec succes',
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 5000,
                  timerProgressBar: true,
              });
            }
          });
      },


      async submit(type){
        const { valid } = await this.$refs.form.validate()
        if(valid) {
          this.spinnerLoading = true
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
            this.spinnerLoading = false
            // this.loading = false
            console.log('response',response.data);
            if (response.data == "ERREUR") {
              this.$swal({
                  icon: 'error',
                  title: 'ERREUR',
                  text: 'Erreur serveur',
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 5000,
                  timerProgressBar: true,
              });
              // this.$toast.error("Données non valides!");
            } else if(response.data.code == 1) {
              this.form.reset()
              this.dialog = false
              this.inscriptions = []
              this.inscriptions = response.data.list ?? []
              this.$swal({
                  icon: 'success',
                  iconColor: '#004980',
                  color: '#004980',
                  title: 'Enregistrement',
                  text: 'Versement enregistré avec succes',
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 5000,
                  timerProgressBar: true,
              });
            }else if(response.data.code == 0){
              this.$swal({
                  icon: 'warning',
                  title: 'Frais inscription',
                  text: 'Vous avez déjà versé les frais d\inscriptions',
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 5000,
                  timerProgressBar: true,
              });
            }
          });
        }else{
          console.log('revois ton formulaire');
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
        }else if (type === 'combinees') {
          routeName = 'inscriptions.export.combinees';
        } 
        else {
          console.error('Type d\'exportation inconnu');
          return;
        }
    
        // Construire l'URL avec Inertia.js
        const url = route(routeName, { format: format });
    
        // Rediriger vers l'URL pour déclencher le téléchargement
        window.location.href = url;
      },  
        
    },
    provide() {
      return {
        vmodeldialogFrais: computed(() => this.dialogFrais),
      };
    },
    
  };
  
  </script>
  <style scoped>
  .form-wizard-vue .fw-body-list .fw-list-progress-active {
    background: #004980;
  }
  
  #fw-1695140104041 > ul > li:nth-child(1) > div.fw-list-progress.fw-list-progress-active {
    background: red;
  }
  
  /* This is a css loader. It's not related to vue-form-wizard */
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
    0% {
      -webkit-transform: rotate(0deg);
      transform: rotate(0deg);
    }
    100% {
      -webkit-transform: rotate(360deg);
      transform: rotate(360deg);
    }
  }
  @keyframes load8 {
    0% {
      -webkit-transform: rotate(0deg);
      transform: rotate(0deg);
    }
    100% {
      -webkit-transform: rotate(360deg);
      transform: rotate(360deg);
    }
  }
.export-section {
  margin: 20px;
  padding: 20px;
  border: 1px solid #49080826;
  border-radius: 15px;
  background: linear-gradient(135deg, #FFFFFF0D 0%, #FFFFFF08 100%);
  text-align: center;
  position: relative;
  overflow: hidden;
}

.export-section::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, #FFFFFF10, transparent);
  animation: shine 3s infinite;
}

@keyframes shine {
  0% { left: -100%; }
  100% { left: 100%; }
}

.export-section h3 {
  margin-top: 0;
  margin-bottom: 20px;
  color: #1b5788;
  font-weight: bold;
  font-size: 1.9rem;
  text-shadow: 0 2px 4px rgba(0,0,0,0.5);
}

.export-icons {
  display: flex;
  justify-content: center;
  gap: 30px;
  flex-wrap: wrap;
  margin-bottom: 15px;
}

.icon-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
  position: relative;
}

/* Effet de pulsation pour les icônes */
.animated-icon {
  position: relative;
  border-radius: 50%;
  padding: 15px;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0% { transform: scale(1); }
  50% { transform: scale(1.05); }
  100% { transform: scale(1); }
}

.animated-icon:hover {
  animation: none;
  transform: scale(1.1) rotate(5deg);
}

/* Badge de téléchargement */

/* BADGE NOIR avec flèche ↓ */
.download-badge-black {
  position: center;
  top: -5px;
  right: -5px;
  background: #f8f5f5; /* Noir pur */
  color: #FFFFFF; /* Texte blanc pour contraste */
  border-radius: 50%;
  width: 24px;
  height: 24px;
  font-size: 14px;
  font-weight: bold;
  display: flex;
  align-items: center;
  justify-content: center;
  animation: bounce 0,01s infinite alternate;
  border: 2px solid #FFFFFF; /* Bordure blanche pour mieux ressortir */
  box-shadow: 6px 2px 8px rgba(241, 238, 238, 0.5);
}

@keyframes bounce {
  0% { transform: translateY(0); }
  100% { transform: translateY(-3px); }
}

/* Survol du badge */
.download-badge-black:hover {
  background: #333333; /* Noir légèrement plus clair au survol */
  transform: scale(1.1);
}

/* Containers spécifiques */
.pdf-container .animated-icon {
  background: linear-gradient(135deg, #F4433620 0%, #F4433610 100%);
  border: 2px solid #F4433640;
}

.pdf-container .animated-icon:hover {
  background: linear-gradient(135deg, #F4433630 0%, #F4433620 100%);
  border-color: #F44336;
  box-shadow: 0 0 20px #F4433640;
}

.excel-container .animated-icon {
  background: linear-gradient(135deg, #4CAF5020 0%, #4CAF5010 100%);
  border: 2px solid #4CAF5040;
}

.excel-container .animated-icon:hover {
  background: linear-gradient(135deg, #4CAF5030 0%, #4CAF5020 100%);
  border-color: #4CAF50;
  box-shadow: 0 0 20px #4CAF5040;
}

/* Labels des icônes */
.icon-label {
  color: #1d0101;
  font-size: 14px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 1px;
  text-shadow: 0 1px 2px rgba(0,0,0,0.5);
}

/* Menu modal amélioré */
.export-menu {
  background: linear-gradient(135deg, #2D3748 0%, #4A5568 100%) !important;
  border: 1px solid #FFFFFF30;
  border-radius: 10px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.5);
}

.export-menu .v-list-subheader {
  color: #d3dde2 !important;
  font-weight: bold;
  font-size: 1.1em;
}

.export-menu .v-list-item {
  color: #E2E8F0 !important;
  transition: all 0.2s ease;
  border-bottom: 1px solid #FFFFFF10;
}

.export-menu .v-list-item:hover {
  background: linear-gradient(135deg, #4A5568 0%, #2D3748 100%) !important;
  transform: translateX(5px);
}

/* Indicateur d'aide */
.export-hint {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  color: #00040f;
  font-size: 0.9rem;
  font-style: italic;
  padding: 10px;
  background: #FFFFFF08;
  border-radius: 8px;
  animation: fadeIn 2s ease-in;
}

@keyframes fadeIn {
  0% { opacity: 0; }
  100% { opacity: 1; }
}

/* Effet de surbrillance au survol */
.export-section:hover {
  border-color: #FFFFFF40;
  box-shadow: 0 5px 20px rgba(255,255,255,0.1);
}

/* Version responsive */
@media (max-width: 768px) {
  .export-icons {
    gap: 20px;
  }
  
  .animated-icon {
    padding: 12px;
  }
  
  .v-icon {
    size: 35px;
  }
  
  .download-badge {
    width: 20px;
    height: 20px;
    font-size: 12px;
  }
}
  </style>
  