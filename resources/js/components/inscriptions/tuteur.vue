<template>
    <form novalidate @submit.prevent="submitForm">
      <v-container fluid>
        <v-card variant="outlined" style="border: 2px solid #7d002c">
          <v-card-title style="color: white; background-color: #7d002c"
            >INFORMATIONS SUR LES TUTEURS</v-card-title
          >
          <v-divider></v-divider>
          <br />
          <div style="margin: 10px">
            <v-alert
              v-model="alertFirst"
              border="start"
              variant="tonal"
              closable
              close-label="Close Alert"
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
  
            <div v-if="!alertFirst" style="margin: auto; width: 50%; padding: 10px">
              <Button
                style="height: 30px"
                title="Plier la note"
                @click="onclickAlertButton('first')"
                variant="outlined"
                color="primary"
                nameButton="Relire la note"
              >
              </Button>
            </div>
          </div>

          <!-- selection multiple de tuteur qui existe déjà -->

          <v-card-text style="margin: 10px" v-if="tuteurShow == '1'">
          <v-row>
            <v-col>
              <v-switch
                v-model="form.selection"
                @update:modelValue="submitForm(null)"
                color="#004980"
                inset
                :label="'Selectionner tuteurs existants'"
              ></v-switch>
            </v-col>
            <v-col v-if="form.selection">
              <Autocomplete
                label="Tuteurs"
                @update:modelValue="submitForm()"
                v-model="form.selectTuteurs"
                :items="setTuteurs"
                item-title="code_libelle"
                item-value="id"
                multiple
                chips
                closable-chips
              >
              </Autocomplete>
            </v-col>
          </v-row>
        </v-card-text>
          <!-- selection multiple de tuteur qui existe déjà -->

          <v-card-text v-if="!form.selection">
            <v-row :key="tuteur.id" v-for="(tuteur, i) in form.tuteurs">
              <!-- <v-col md="2"></v-col> -->
              <v-col cols="2">
                <TextField
                  label="Nom"
                  :isRequired="true"
                  placeholder="Nom"
                  @update:modelValue="submitForm(tuteur)"
                  v-model="tuteur.nom"
                ></TextField>
              </v-col>
              <v-col cols="2">
                <TextField
                  label="Prénom"
                  :isRequired="true"
                  @update:modelValue="submitForm(tuteur)"
                  placeholder="Prénom"
                  v-model="tuteur.prenom"
                ></TextField>
              </v-col>
              <v-col cols="2">
                <TextField
                  label="Téléphone"
                  :isRequired="true"
                  placeholder="Téléphone"
                  @update:modelValue="submitForm(tuteur)"
                  v-model="tuteur.tel"
                ></TextField>
              </v-col>
              <v-col cols="2">
                <Autocomplete
                    label="Sexe"
                    isRequired
                    @update:modelValue="submitForm()"
                    v-model="form.sexe"
                    :items="['Sélectionner', 'Masculin', 'Féminin']"
                ></Autocomplete>
              </v-col>
              <!-- <v-col cols="2">
                <TextField
                  label="Adresse"
                  :isRequired="true"
                  placeholder="Adresse"
                  @update:modelValue="submitForm(tuteur)"
                  v-model="tuteur.adresse"
                ></TextField>
              </v-col> -->
              <v-col cols="2">
                <TextField
                  label="Email"
                  :isRequired="true"
                  placeholder="Email"
                  @update:modelValue="submitForm(tuteur)"
                  v-model="tuteur.email"
                ></TextField>
              </v-col>
              <v-col cols="2">
                <br />
  
                <v-tooltip v-model="tooltipModel" v-if="form.tuteurs.length == 1" bottom>
                  <template v-slot:activator="{ props }">
                    <Button
                      variant="outlined"
                      v-bind="props"
                      icon
                      size="large"
                      small
                      color="error"
                    >
                      <v-icon :icon="icons.mdiCloseCircle"></v-icon>
                    </Button>
                  </template>
                  <div style="width: 200px">
                    Ce bouton reste inactif.Vous ne pouvez supprimer que s'il y'a au moins 2
                    lignes.
                  </div>
                </v-tooltip>
                <Button
                  type="button"
                  variant="outlined"
                  v-if="form.tuteurs.length >= 2"
                  icon
                  @click="removeRow(tuteur)"
                  size="large"
                  small
                  title="Supprimer la ligne"
                  color="error"
                >
                  <v-icon :icon="icons.mdiCloseCircle"></v-icon>
                </Button>
              </v-col>
            </v-row>
            <v-row>
              <v-col offset-md="11" cols="4">
                <Button
                  type="button"
                  variant="outlined"
                  :disabled="form.tuteurs.length >= 3"
                  @click="addRow"
                  title="Ajouter une nouvelle ligne"
                  icon
                  size="large"
                  color="primary"
                >
                  <v-icon :icon="icons.mdiPlusCircle" small></v-icon>
                </Button>
              </v-col>
            </v-row>
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
    props: ["type","tuteurs","tuteurShow"],
    components: {
      mdiPlusCircle,
      mdiCloseCircle,
      mdiInformation,
      XLSX,
    },
    data: () => ({
      tooltipModel: false,
      alertFirst: true,
      alertSecond: true,
      icons: { mdiPlusCircle, mdiCloseCircle, mdiInformation },
      step: 1,
      
      file: null,
      section: null,
      form: useForm({
        selection: null,
        tuteurs: [],
        selectTuteurs: [],
        etablissement_section_id: null,
      }),
    }),
    computed:{
        setTuteurs() {
        let list = [];

        if (this.tuteurs) {
            this.tuteurs.forEach((element) => {
            if (element) {
                list.push({
                ...element,
                code_libelle: element.tuteur.nom + "-" + element.tuteur.prenom + "-" + element.tuteur.telephone,
                });
            }
            });
        }
        return list ?? [];
        },
    },
  
    methods: {
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
          return "Supérieur";
        } else {
          return "Université";
        }
      },
      resetForm(check) {
        if (check) {
          this.form.tuteurs = [];
          this.addRow();
        }
      },
      async submitForm(element) {
        await this.verify(element);
        await this.isValid();
        this.form.etablissement_section_id = this.$page.props.sections[0].sections.find(
          (el) => el.libelle == this.section
        );
        this.$emit("formSubmitted", this.form);
        this.$emit("tuteurFormValid", this.isValid());
      },
      async isValid() {
        let valid = false;
        console.log('tttttt',this.tuteurShow)
        if(this.tuteurShow == '1'){
            if (!this.form.selection &&
            !this.form.tuteurs.find(
                (el) =>
                el.tel == null ||
                el.email == null ||
                el.tel.trim() == "" ||
                el.email.trim() == ""
            )
            ){
                valid = true;
            }else if(this.form.selection && this.form.selectTuteurs.length != 0){
                valid = true;
            } 
        }else{
            valid = true;
        }
       
        return valid;
      },
      goBack() {
        router.get(route("etablissements.index"));
      },
      addRow() {
        this.form.tuteurs.push({
          nom: '',
          prenom: '',
          tel: '',
          sexe: '',
          adresse: '',
          email: ''
        });
      },
      removeRow(id) {
        this.form.tuteurs = this.form.tuteurs.filter((el) => el !== id);
      },
      async verify(element) {
        if (element) {
          const array = this.form.tuteurs.filter(
            (el) =>
              (el.tel != null && el.tel == element.tel) ||
              (el.email != "" && el.email == element.email)
          );
  
          if (array.length > 1) {
            this.removeRow(element);
            this.$swal("L'élément existe déjà !");
            // this.$alert.error("L'élément existe déjà !");
          }
        }
      },
    },
    mounted() {
        console.log('showtuteur',this.tuteurShow)
      this.addRow();
      this.section = this.getSection(this.type);
    },
  };
  </script>
  