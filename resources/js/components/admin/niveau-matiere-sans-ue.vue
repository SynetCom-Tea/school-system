<template>
  <form @submit.prevent="submitForm" novalidate>
    <v-container fluid>
      <v-card variant="outlined" style="border: 2px solid #7d002c">
        <v-card-title style="color: white; background-color: #7d002c"
          >AFFECTATION DE MATIÈRES AUX NIVEAUX</v-card-title
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
              Cette section vous permet d'attribuer les matieres aux
              <span v-if="type == '3' || type == '4'">filieres</span
              ><span v-else>niveaux</span>
            </li>
            <li v-if="type == '3'">
              Configurer également si l'établissement prend en charge le système
              LMD(Licence Master Doctorat) et le régime d'évaluation
            </li>
            <li>
              Le formulaire sera valide si et seulement si tous les champs obligatoires
              marqués par <span style="color: red">*</span> sont renseignés
            </li>
          </v-alert>

          <div v-if="!alertFirst" style="margin: auto; width: 50%; padding: 10px">
            <Button
              style="height: 30px"
              type="button"
              title="Plier la note"
              @click="onclickAlertButton('first')"
              variant="outlined"
              color="primary"
              nameButton="Relire la note"
            >
            </Button>
          </div>
        </div>
        <v-card>
          <v-card-text style="margin: 10px"> </v-card-text>
          <v-card-text>
            <v-row>
              <!-- <v-col md="1"></v-col> -->
              <v-col md="6">
                <Autocomplete
                  itemValue="id"
                  class="mt-2"
                  v-model="form.filiere"
                  itemTitle="code"
                  :isRequired="true"
                  label="Filieres"
                  @update:modelValue="submitForm(any)"
                  :items="filieres"
                >
                </Autocomplete>
              </v-col>
              <v-col md="6">
                <Autocomplete
                  itemValue="id"
                  class="mt-2"
                  v-model="form.niveau"
                  :isRequired="true"
                  :itemTitle="formatNiveauLabel"
                  @update:modelValue="submitForm(any)"
                  label="Niveaux"
                  :items="niveaux"
                >
                </Autocomplete>
              </v-col>
            </v-row>
            <!-- <v-divider></v-divider> -->
            <v-card class="mx-auto" max-width="1200">
              <v-card-title flat style="color: #7d002c; background-color: white"
                >les Matières</v-card-title
              >
              <v-divider></v-divider>
              <br />
              <v-card-text>
                <!-- <v-divider></v-divider> -->

                <v-row disabled :key="matiere.id" v-for="(matiere, i) in form.matieres">
                  <v-col md="1"></v-col>
                  <v-col md="4">
                    <Autocomplete
                      itemValue="id"
                      class="mt-2"
                      v-model="matiere.matiere"
                      :isRequired="true"
                      itemTitle="libelle"
                      @update:modelValue="submitForm(matiere)"
                      label="Matieres"
                      :items="matieres"
                    >
                    </Autocomplete>
                  </v-col>
                  <v-col md="2">
                    <TextField
                      label="Coeff"
                      class="mt-2"
                      :isRequired="true"
                      placeholder="Coeff"
                      @update:modelValue="submitForm(matiere)"
                      v-model="matiere.coefficient"
                    ></TextField>
                  </v-col>
                  <v-col md="2">
                    <TextField
                      label="VH"
                      class="mt-2"
                      :isRequired="true"
                      @update:modelValue="submitForm(matiere)"
                      placeholder="VH"
                      v-model="matiere.volume_horaire"
                    ></TextField>
                  </v-col>
                  <v-col md="1">
                    <br />
                    <Button
                      type="button"
                      variant="outlined"
                      :disabled="!(form.matieres.length > 1)"
                      icon
                      @click="removeRow(matiere)"
                      size="large"
                      small
                      color="error"
                    >
                      <v-icon :icon="icons.mdiCloseCircle"></v-icon>
                    </Button>
                    <!-- <v-btn variant="outlined" :disabled="!(form.matieres.length > 1)" icon @click="removeRow(matiere)" fab small color="error">
                                    <v-icon :icon="icons.mdiCloseCircle"></v-icon>
                                </v-btn> -->
                  </v-col>
                </v-row>
                <v-row>
                  <v-col offset-md="11" cols="4">
                    <Button
                      type="button"
                      variant="outlined"
                      @click="addRow"
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
          </v-card-text>
          <br />
        </v-card>
        <br />
      </v-card>
      <br />
    </v-container>
  </form>
</template>
<script>
import { router, useForm } from "@inertiajs/vue3";
import { mdiCloseCircle, mdiPlusCircle, mdiInformation } from "@mdi/js";
export default {
  props: ["type", "niveaux", "filieres", "matieres"],
  components: {
    mdiPlusCircle,
    mdiCloseCircle,
    mdiInformation,
  },
  data: () => ({
    alertFirst: true,
    alertSecond: true,
    icons: { mdiPlusCircle, mdiCloseCircle, mdiInformation },
    step: 1,
    importation: false,
    section: null,
    uetabs: [],
    form: useForm({
      filiere: null,
      niveau: null,
      matieres: [],
      etablissement_section_id: null,
    }),
  }),

  watch: {
    // Surveillez les valeurs spécifiques ici
    filieres(data, old) {
      console.log("nouvelle", data);
      if (this.type == "3") {
        this.tabsFilieres = data ? data.filieres : [];
      } else if (this.type == "4") {
        if (data.departements && Array.isArray(data.departements)) {
          data.departements.forEach((element) => {
            this.tabsFilieres = this.tabsFilieres.concat(element.filieres);
          });
        }
      }
    },
  },

  methods: {
    onclickAlertButton(type) {
      if (type == "second") {
        this.alertSecond = true;
      }
      if (type == "first") this.alertFirst = true;
    },
    formatNiveauLabel(item) {
      if (item) {
        return `${item?.code} - ${item?.libelle}`;
      }
    },
    getSection(type) {
      if (type == "1") {
        return "Primaire";
      } else if (type == "2") {
        return "Secondaire";
      } else {
        return "Supérieur";
      }
    },
    resetForm(check) {
      if (check) {
        this.form.matieres = [];
        this.addRow();
      }
    },
    async submitForm(element) {
      await this.verify(element);
      await this.isValid();
      console.log("isValid", this.isValid());
      this.form.etablissement_section_id = this.$page.props.sections.find(
        (el) => el.section == this.section
      );
      this.$emit("formSubmitted", this.form);
      this.$emit("niveauMatieresansUEFormValid", this.isValid());
    },
    async isValid() {
      let fichier = false;
      let valid = false;
      if (this.importation && this.form.fichier_matiere != null) {
        fichier = true;
      } else if (
        !this.importation &&
        !this.form.matieres.find(
          (el) =>
            this.form.filiere == null ||
            this.form.filiere == "" ||
            this.form.niveau == null ||
            this.form.niveau == "" ||
            this.form.matiere == "" ||
            el.matiere == null ||
            el.matiere == "" ||
            el.coefficient == 0 ||
            el.coefficient == null ||
            el.coefficient.trim() == "" ||
            el.volume_horaire == null ||
            el.volume_horaire.trim() == ""
        )
      ) {
        fichier = true;
      }
      if (fichier) {
        valid = true;
      } else {
        valid = false;
      }
      return valid;
    },
    goBack() {
      router.get(route("etablissements.index"));
    },
    addRow() {
      this.form.matieres.push({
        coefficient: 0,
        volume_horaire: 0,
        after: null,
      });
    },
    removeRow(matiere) {
      this.form.matieres = this.form.matieres.filter((el) => el !== matiere);
    },
    async verify(element) {
      // console.log('ue',ue,'index',index,'matiere',matiere)
      if (element) {
        const array = this.form.matieres.filter(
          (el) => el.matiere !== null && el.matiere == element.matiere
        );
        if (array.length > 1) {
          this.removeRow(matiere);
          this.$swal("L'élément existe déjà !");
          // this.$alert.error("L'élément existe déjà !");
        }
      }
    },
  },
  created() {
    if (this.type == "3") {
      this.tabsFilieres = this.filieres ? this.filieres.filieres : [];
    } else if (this.type == "4") {
      if (this.filieres.departements && Array.isArray(this.filieres.departements)) {
        this.filieres.departements.forEach((element) => {
          this.tabsFilieres = this.tabsFilieres.concat(element.filieres);
        });
      }
    }
  },
  mounted() {
    // this.addRowInit()
    this.addRow();
    this.section = this.getSection(this.type);
  },
};
</script>
