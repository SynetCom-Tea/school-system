<template>
    <AuthenticatedLayout>
      <Toolbar
        styleToolbar="background-color: white;"
        :icon="icons.mdiAccountSchool"
        :toolbarTitle="'ESPACE DE VERSEMENT ' + Title   "
      ></Toolbar>
      <div style="margin: 10px; border: 2px solid #7d002c; padding: 10px; border-radius: 25px"
        class="mt-3">
        <v-container class="bg-primary-variant">
          <v-row align="center">
            <v-col cols="3"></v-col>
            <v-col cols="5">
                <TextField class="mt-5" label="Entrer le Code de l'inscription" :isRequired="true" placeholder="Taper le code" v-model="code"></TextField>
            </v-col>
            <v-col cols="3">
              <v-btn color="primary" @click="RechercheInscription()" style="height=80px;text-transform: none; font-size: 10px">Rechercher</v-btn>
            </v-col>
          </v-row>
        </v-container>
      </div>
     
      <div v-if="inscriptions.length > 0 && !loading"
        style="margin: 10px; border: 2px solid #7d002c; padding: 10px; border-radius: 25px"
        class="mt-3"
      >
        <Datatable :displaySearch="false" :titleDatatable="inscriptions[0].versements.length == 0 ? 'Inscription inactive' : 'Les versements de '+inscriptions[0].apprenant.nom + ' ' + inscriptions[0].apprenant.prenom+' de l\'année academique '+ inscriptions[0].annee.libelle + ' immatriculé sous le N° '+inscriptions[0].apprenant.matricule" :headers="section == '1' || section == '2' ? headers : headers_sup" :items="inscriptions[0].versements"  :functionOnClickAddButton="create" :libelleButton="'Versement'">
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
                <v-icon size="small" class="me-2" title="Imprimer le reçu" @click="" :icon="icons.mdiPrinter" color="primary">
                </v-icon>
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
                <Autocomplete
                    :items="type_frais"
                    item-title="libelle"
                    item-value="id"
                    label="Frais"
                    isRequired
                    v-model="form.type_frais"
                    :rules="[(v) => !!v || 'Ce champ est requis!']"
                  ></Autocomplete>
                </v-col>
              
                <v-col cols="12">
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
            @click="submit()"
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
            key: "frais.type_frais.libelle",
            sortable: false,
          },
          { title: "Montant", align: "center", key: "montant" },
          { title: "Date du versement", align: "center", key: "date_versement" },
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
        },
        code: '',
        spinnerLoading: false,
        loading: false,
        dialog: false,
        done: false,
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
      // reset(){
      //   this.restant = '';
      // },
      calculFrais(){
        this.$emit('input',this.form.montant)
        axios
          .get(
            route("getCalculFrais", {
              inscription: this.inscriptions[0].id ?? null,
              type_frais: this.form.type_frais,
            })
          )
          .then((res) => {
            // this.loading = false
            console.log('response',res.data);
            if (typeof res.data == "string" || typeof res.data == "undefined") {
              // this.$toast.error("Données non valides!");
            } else {
              let r = res.data.total - res.data.somme_versee

              this.restant = 'Il vous reste ' + r + ' FCFA à payer' ; 
              if(parseInt(r) < parseInt(this.form.montant)  ){
                this.done = true
              }else{
                this.done = false
              }
            }
            
          });
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


      async submit(){
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
  </style>
  