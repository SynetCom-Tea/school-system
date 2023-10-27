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
                  :rules="[(v) => !!v || 'Ce champ est requis!']"
                ></TextField>
              </v-col>
              <v-col cols="2">
                <TextField
                  label="Prénom"
                  :isRequired="true"
                  @update:modelValue="submitForm(tuteur)"
                  placeholder="Prénom"
                  v-model="tuteur.prenom"
                  :rules="[(v) => !!v || 'Ce champ est requis!']"
                ></TextField>
              </v-col>
              <v-col cols="2">
                <TextField
                  label="Téléphone"
                  :isRequired="true"
                  placeholder="Téléphone"
                  @update:modelValue="submitForm(tuteur)"
                  v-model="tuteur.tel"
                  :rules="[(v) => !!v || 'Ce champ est requis!']"
                ></TextField>
              </v-col>
              <v-col cols="2">
                <Autocomplete
                    label="Sexe"
                    isRequired
                    @update:modelValue="submitForm()"
                    v-model="tuteur.sexe"
                    :items="['Masculin', 'Féminin']"
                    :rules="[(v) => !!v || 'Ce champ est requis!']"
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
  import { useVuelidate } from '@vuelidate/core';
  import { required , email, alpha, minLength, maxLength, numeric } from '@vuelidate/validators';
  export default {
    props: ["type","tuteurs","tuteurShow"],
    components: {
      mdiPlusCircle,
      mdiCloseCircle,
      mdiInformation,
      XLSX,
    },
    data: () => ({
      v$: useVuelidate(),
      tooltipModel: false,
      alertFirst: true,
      alertSecond: true,
      icons: { mdiPlusCircle, mdiCloseCircle, mdiInformation },
      step: 1,
      
      file: null,
      section: null,
      form: useForm({
        selection: null,
        tuteurs: [
           {
            nom: '',
            prenom: '',
            tel: '',
            sexe: '',
            email: ''
           }
        ],
        selectTuteurs: [],
        etablissement_section_id: null,
      }),
    }),
    validations () {
    console.log('ggggg',typeof this.type);
      return {
        form: {
        tuteurs: {
            nom: { required, alpha },
            prenom: { required, alpha },
            sexe: { required }
        }
      }
      }
  },
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
        const v = await this.isValid();
        this.form.etablissement_section_id = this.$page.props.sections[0].sections.find(
          (el) => el.libelle == this.section
        );
        this.$emit("formSubmitted", this.form);
        this.$emit("tuteurFormValid", v);
      },
      async isValid() {

        // test

        // let valid = false; // Par défaut, considérez le formulaire comme valide.
        // console.log(await this.v$)
        // const elementValid = await this.v$.form.tuteur.$validate();
        // Vérifiez la validité de chaque élément du tableau.
        // for (const tuteur of this.form.tuteurs) {
        //   const elementValid = await this.v$.tuteur.$invalid;
        //   if (elementValid) {
        //     valid = false;
        //     break; // S'il y a une erreur de validation, arrêtez la vérification.
        //   }
        // }
        // console.log('valid',elementValid);

        // return valid = elementValid;

        // fin test

        let valid = false;
        const result = await this.v$.$validate()
        console.log('ttesttttt',result);
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
      
      this.section = this.getSection(this.type);
    },
  };
  </script>
  