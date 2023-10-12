<template>
  <form novalidate @submit.prevent="submitForm">
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
                  <v-list-item v-if="apprenant" title="Classe Antérieure"
                  >
                    <v-list-item-subtitle
                      >
                      <span>{{ apprenant.more.classeAnnee.classe.libelle }} en {{ apprenant.more.classeAnnee.annee.libelle }}</span>
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
                    @update:modelValue="type == '1' || type == '2' ? checkClasseExist(form.niveau) : ''"
                  ></Autocomplete>
                </v-col>
                <v-col :cols="mdCycle" v-if="type == '3' || type == '4'">
                  <Autocomplete 
                    label="Cycles"
                    :isRequired="true"
                    :items="cycles"
                    item-title="name"
                    item-value="id"
                    class="mt-3"
                    v-model="vCycle"
                    @update:modelValue="requete()"
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
                    :items="setCycleFilieres"
                  ></Autocomplete>
                </v-col>
                <v-col :cols="mdClasse" v-if="resultClasse.length != 0">
                  <v-autocomplete
                    label="Classes"
                    :isRequired="true"
                    :items="resultClasse ? resultClasse : []"
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
                <v-col :cols="mdVersement">
                  <TextField
                    label="1er versement"
                    :isRequired="true"
                    @input="submitForm(),setHint()"
                    v-model="form.versement"
                    :hint="hint"
                  ></TextField>
                </v-col>
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
export default {
  props: ["type","niveaux","apprenant","annees","formapprenant","cycleFilieres","cycles"],
  components: {
    mdiPlusCircle,
    mdiCloseCircle,
    mdiInformation,
    XLSX,
  },
  data: () => ({
   
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
    created(){
    },
  methods: {
    requete(){
      this.$emit('input',this.vCycle)
          router.replace(this.$page.url,{data:{cycle_id:this.vCycle}});
    },
    setHint(){
      let frais = 0
      this.$emit('input',this.form.versement)
      axios
        .get(
          route("getfrais", {
            niveau: this.form.niveau,
          })
        )
        .then((res) => {
          console.log('res',res.data)
          if (typeof res.data == "string" || typeof res.data == "undefined") {
            
          } else {
              frais = res.data ?? [];
              let r = frais - this.form.versement
              this.hint = 'Il vous reste '+ r + ' FCFA à payer sur ' + frais + ' FCFA'
              if(r < 0){
                this.form.versement = 0
              }
          }
        });
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
            if (typeof res.data == "string" || typeof res.data == "undefined") {
             
            } else {
               return res.data ?? [];
            }
          });
      }
      if(this.resultClasse.length == 0){
        this.mdVersement = 8
      }else{
        this.mdVersement = 4
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
      await this.isValid();
      this.form.apprenant = this.apprenant
      this.$emit("formSubmitted", this.form);
      this.$emit("anneeFormValid", this.isValid());
    },
    async isValid() {
      let valid = false;
      if ( (this.form.annee != null && this.form.annee != '') && this.form.versement != ''){
        valid = true;
      }
      return valid;
    },
    goBack() {
      router.get(route("etablissements.index"));
    },

    async verify() {
     
    },
  },
  mounted() {
    console.log('date',typeof this.form.date_naissance)
    this.section = this.getSection(this.type);
    this.form.etablissement_section_id = this.$page.props.sections[0].sections.find(
        (el) => el.libelle == this.section
      );
      console.log('hhhhhh',this.$page.props.sections[0],this.form.etablissement_section_id);
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
