<template>
    <form novalidate @submit.prevent="submitForm">
      <v-container fluid>
        <v-card variant="outlined" style="border: 2px solid #7d002c">
          <v-card-title style="color: white; background-color: #7d002c"
            >INFORMATIONS SUR LES DOCUMENTS</v-card-title
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
          <v-card-text>
            <v-row :key="document.id" v-for="(document, i) in form.documents">
              <v-col cols="2"></v-col>
              <v-col cols="3">
                <Autocomplete
                    label="Type de fichier"
                    :isRequired="true"
                    :items="typeDocuments"
                    item-title="libelle"
                    item-value="id"
                    v-model="document.type"
                    @update:modelValue="submitForm(document)"
                  ></Autocomplete>
              </v-col>
              <v-col cols="3">
                <v-file-input
                clearable
                required
                v-model="document.file"
                @update:modelValue="submitForm(document)"
                label="Charger le fichier"
                variant="solo-inverted"
              ></v-file-input>
              </v-col>
              
              <v-col cols="3">
                <br />
  
                <v-tooltip v-model="tooltipModel" v-if="form.documents.length == 1" bottom>
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
                  v-if="form.documents.length >= 2"
                  icon
                  @click="removeRow(document)"
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
    props: ["type","typeDocuments"],
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
        documents: [],
        etablissement_section_id: null,
      }),
    }),
  
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
          this.form.documents = [];
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
        this.$emit("documentFormValid", this.isValid());
      },
      async isValid() {
        let valid = false;
       if (
          !this.form.documents.find(
            (el) =>
              (el.type !== null && el.type == "") || (el.file !== null && el.file == "")
          )
        ) {
          valid = true;
        }
        return valid;
      },
      goBack() {
        router.get(route("etablissements.index"));
      },
      addRow() {
        this.form.documents.push({
          type: null,
          file: null,
          before: null,
        });
      },
      removeRow(id) {
        this.form.documents = this.form.documents.filter((el) => el !== id);
      },
      async verify(element) {
        if (element) {
          const array = this.form.documents.filter(
            (el) =>
              (el.type !== null && el.type == element.type) 
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
      this.addRow();
      this.section = this.getSection(this.type);
    },
  };
  </script>
  