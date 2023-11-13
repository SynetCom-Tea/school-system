<template>
  <form ref="form" novalidate @submit.prevent="submitForm">
    <v-container fluid>
      <v-card variant="outlined" style="border: 2px solid #7d002c">
        <v-card-title style="color: white; background-color: #7d002c"
          >Année academique</v-card-title
        >
        <v-divider></v-divider>
        <br />
        <div style="margin: 10px">
          <v-alert
            v-model="alertFirst"
            border="start"
            variant="tonal"
            color="primary"
            type="info"
            title="Note"
          >
            <li>
              Le formulaire sera valide <strong>si et seulement si </strong>tous les
              champs obligatoires marqués par <span style="color: red">*</span> sont
              renseignés
            </li>
          </v-alert>

          
        </div>




        <!-- debut du card -->
          <v-row>
            <v-col md="1"></v-col>
            <v-col md="3">
              <v-card>
                <v-card-title class="subheading font-weight-bold">
                  {{ apprenant ? apprenant.matricule : 'Nouvel élève' }}
                </v-card-title>

                <v-divider></v-divider>

                <v-list density="compact">
                  <v-list-item v-if="apprenant && (type == '1' || type == '2')" title="Classe Antérieure"
                  >
                    <v-list-item-subtitle
                      >
                      <span>{{ apprenant.more.classeAnnee.classe.libelle }} en {{ apprenant.more.classeAnnee.annee.libelle }}</span>
                    </v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item v-if="apprenant && (type == '3' || type == '4')" title="Année Antérieure"
                  >
                    <v-list-item-subtitle
                      >
                      <span>{{ apprenant.annee }}</span>
                    </v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item v-if="apprenant && (type == '3' || type == '4')" title="Cycle/Niveau"
                  >
                    <v-list-item-subtitle
                      >
                      <span>{{ apprenant.cycle_niveau }}</span>
                    </v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item v-if="apprenant && (type == '3' || type == '4')" title="Filiere"
                  >
                    <v-list-item-subtitle
                      >
                      <span>{{ apprenant.filiere }}</span>
                    </v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item title="Nom & Prénom"
                  >
                    <v-list-item-subtitle
                      ><span v-if="formapprenant">{{ formapprenant.nom }}</span>
                      <span v-if="apprenant">{{ apprenant.name }}</span>
                    </v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item title="Date et lieu de naissance"
                  >
                    <v-list-item-subtitle
                      ><span v-if="formapprenant">{{ formapprenant.date_naissance }}</span>
                      <span v-if="apprenant">{{ apprenant.date_lieu_naissance }}</span>
                    </v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item title="Téléphone"
                  >
                    <v-list-item-subtitle
                      ><span v-if="formapprenant">{{ formapprenant.telephone }}</span>
                      <span v-if="apprenant">{{ apprenant.telephone }}</span>
                    </v-list-item-subtitle>
                  </v-list-item>
                  
                </v-list>
              </v-card>
            </v-col>
            <v-col md="7">
              <v-row >
            <!-- <v-col md="2"></v-col> -->
                <v-col cols="1"></v-col>
                <v-col :cols="mdAnnee">
                  <Autocomplete
                    label="Année academique"
                    :isRequired="true"
                    :items="annees"
                    class="mt-3"
                    item-title="libelle"
                    item-value="id"
                    v-model="form.annee"
                    @update:modelValue="submitForm()"
                    :rules="[(v) => !!v || 'Ce champ est requis!']"
                  ></Autocomplete>
                </v-col>
                <v-col :cols="mdNiveau">
                  <Autocomplete
                    label="Niveaux"
                    :isRequired="true"
                    :items="niveaux"
                    item-title="libelle"
                    item-value="id"
                    class="mt-3"
                    v-model="form.niveau"
                    @update:modelValue="type == '1' || type == '2' ? checkClasseExist(form.niveau) : '',submitForm()"
                    :rules="[(v) => !!v || 'Ce champ est requis!']"
                  ></Autocomplete>
                </v-col>
                <v-col :cols="mdCycle" v-if="type == '3' || type == '4'">
                  <Autocomplete 
                    label="Cycles"
                    :items="cycles"
                    item-title="name"
                    item-value="id"
                    class="mt-3"
                    v-model="vCycle"
                    @update:modelValue="requete(),submitForm()"
                  ></Autocomplete>
                </v-col>
                <v-col cols="1"></v-col>
              </v-row>
              <v-row>
                <v-col cols="1"></v-col>
                <v-col :cols="mdCycleFiliere" v-if="type == '3' || type == '4'">
                  <Autocomplete
                    label="Filieres"
                    :isRequired="true"
                    item-title="code_libelle"
                    item-value="id"
                    v-model="form.cycle_filiere"
                    @update:modelValue="submitForm()"
                    :items="setCycleFilieres"
                    :rules="[(v) => !!v || 'Ce champ est requis!']"
                  ></Autocomplete>
                </v-col>
                <v-col :cols="mdClasse" v-if="resultClasse.length != 0">
                  <v-autocomplete
                    label="Classes"
                    :items="resultClasse.length > 0 ? resultClasse : []"
                    chips
                    item-title="classe.classe.libelle"
                    item-value="classe.classe.id"
                    v-model="form.classe"
                    @update:modelValue="submitForm()"
                  >
                    <template v-slot:item="{ props, item }">
                      <v-list-item
                        v-bind="props"
                        :title="item?.raw?.classe.classe.libelle"
                        :subtitle="item?.raw?.nbre + ' Apprenant'"
                      ></v-list-item>
                    </template>
                  </v-autocomplete>
                </v-col>
                <!-- <v-col :cols="mdVersement">
                  <TextField
                    label="1er versement"
                    :isRequired="true"
                    @input="submitForm(),setHint()"
                    v-model="form.versement"
                    :hint="hint"
                  ></TextField>
                </v-col> -->
                <v-col cols="1"></v-col>
              </v-row>
            </v-col>
            </v-row>

        <!-- fin du card -->



        <v-card-text>
          
        </v-card-text>
      </v-card>
    </v-container>
    <br />
  </form>
</template>
<script>
// import XLSX from "xlsx/dist/xlsx.extendscript.js";
import * as XLSX from "xlsx/xlsx.mjs";
import { router, useForm } from "@inertiajs/vue3";
import { mdiCloseCircle, mdiPlusCircle, mdiInformation } from "@mdi/js";
import { useVuelidate } from '@vuelidate/core';
import { required } from '@vuelidate/validators';
export default {
  props: ["type","niveaux","nextIndex","apprenant","annees","formapprenant","cycleFilieres","cycles","nbre_limite_eleve"],
  components: {
    mdiPlusCircle,
    mdiCloseCircle,
    mdiInformation,
    XLSX,
  },
  data: () => ({
    v$: useVuelidate(),
    alertFirst: true,
    alertSecond: true,
    icons: { mdiPlusCircle, mdiCloseCircle, mdiInformation },
    step: 1,
    mdAnnee: null,
    mdNiveau: null,
    mdCycle: null,
    mdCycleFiliere: null,
    mdClasse: null,
    mdVersement: null,
    section: null,
    vCycle: null,
    resultClasse: [],
    hint:'',
    form: useForm({
      apprenant: null,
      annee: null,
      classe: null,
      cycle_filiere: null,
      niveau: null,
      versement: 0,
      etablissement_section_id: null,
    }),
  }),
  validations () {
    if(this.type == '1' || this.type == '2'){
      return {
        form: {
          annee: { required },
          niveau: { required },
        }
      }
    }else if(this.type == '3' || this.type == '4'){
      return {
        form: {
          annee: { required },
          niveau: { required },
          cycle_filiere: { required },
        }
      }
    }
  },
  watch: {
      // Surveillez les valeurs spécifiques ici
      async nextIndex(){
          await this.submitForm()
      },
  },

  computed:{
    setCycleFilieres() {
      let list = [];
      if (this.cycleFilieres) {
          this.cycleFilieres.forEach((element) => {
          if (element) {
              list.push({
              ...element,
              code_libelle: element.cycle.name + " - " + element.filiere.name,
              });
          }
          });
      }
      return list ?? [];
      },
  },
  async mounted(){
    await this.submitForm()
  },
  created(){
    
  },
  
  methods: {
    
    requete(){
      this.$emit('input',this.vCycle)
          router.replace(this.$page.url,{data:{cycle_id:this.vCycle}});
    },
    async checkClasseExist(niveau) {
      if (niveau) {
        this.resultClasse = await axios
          .get(
            route("getcheckClasse", {
              niveau: niveau,
              etabSection: this.form.etablissement_section_id
            })
          )
          .then((res) => {
            console.log('res',res.data)
            if (res.data == "ERREUR") {
             
            } else if(res.data.code == 1){
               return res.data.result ?? [];
            }else{
              return []
            }
          });
      }
      if(this.resultClasse.length == 0){
        this.mdVersement = 8
      }else{
        this.mdVersement = 4
      }
      if(this.resultClasse[this.resultClasse.length - 1]?.nbre >= this.nbre_limite_eleve){
        this.$swal({
            title: 'Création d\'une nouvelle classe?',
            text: "Voulez-vous créer une nouvelle classe car ''" + this.resultClasse[this.resultClasse.length - 1].classe.classe.code + "'' est pleine !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#004980',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, créer!',
            cancelButtonText: 'Non!',
          }).then((result) => {
          if (result.isConfirmed) {
            // redirection vers la page de création des classes
            router.get(route('classes.index',{type:this.type}))
          }
        });
      }
    },
    onclickAlertButton(type) {
      if (type == "second") {
        this.alertSecond = true;
      }
      if (type == "first") this.alertFirst = true;
    },
    getSection(type) {
      if (type == "1") {
        return "Primaire";
      } else if (type == "2") {
        return "Secondaire";
      } else if (type == "3") {
        return "Supérieure";
      } else {
        return "Universitaire";
      }
    },
    resetForm(check) {
      if (check) {
        this.form.matieres = [];
        this.addRow();
      }
    },
    async submitForm() {
      const v = await this.isValid();
      this.form.apprenant = this.apprenant
      this.$emit("formSubmitted", this.form);
      this.$emit("anneeFormValid", v);
    },
    async isValid() {
      let valid = false;
      const result = await this.v$.$validate()
      console.log('result',result);
      if (result) {
        valid = true;
      }
      return valid;
    },
    goBack() {
      router.get(route("etablissements.index"));
    },
  },
  mounted() {
    this.section = this.getSection(this.type);
    this.form.etablissement_section_id = this.$page.props.sections[0].sections.find(
        (el) => el.libelle == this.section
      );
      this.mdVersement = 8
    if(this.type == '1' || this.type == '2'){
      this.mdAnnee = 4
      this.mdNiveau = 4
      this.mdClasse = 4
    }else if(this.type == '3'){
      this.mdAnnee = 3
      this.mdNiveau = 3
      this.mdCycle = 3
      this.mdCycleFiliere = 4
      this.mdVersement = 5
    }else if(this.type == '4'){

    }
    
  },
};
</script>
