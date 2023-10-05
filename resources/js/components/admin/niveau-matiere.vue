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
              Cette section vous permet d'attribuer les matières aux
              <span v-if="type == '3' || type == '4'">filières</span
              ><span v-else>niveaux</span>
            </li>
            <li>
              Le formulaire sera valide si et seulement si tous les champs obligatoires
              marqués par <span style="color: red">*</span> sont renseignés
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

        <v-divider></v-divider>
        <v-card-text>
          <v-row>
            <v-col md="4"></v-col>
            <v-col md="4">
              <Autocomplete
                label="Niveaux"
                class="mt-2"
                item-title="code_libelle"
                item-value="id"
                :isRequired="true"
                :items="niveaux"
                v-model="form.niveau"
                @update:modelValue="submitForm(any)"
                chips
              >
              </Autocomplete>
            </v-col>
          </v-row>
          <!-- <v-divider></v-divider> -->
          <v-card class="mx-auto" max-width="1200">
            <v-card-text>
              <!-- <v-divider></v-divider> -->

              <v-row disabled :key="matiere.id" v-for="(matiere, i) in form.matieres">
                <v-col md="1"></v-col>
                <v-col md="4">
                  <Autocomplete
                    label="Matieres"
                    class="mt-2"
                    item-title="libelle"
                    item-value="id"
                    :isRequired="true"
                    :items="matieres"
                    chips
                    v-model="matiere.matiere"
                    @update:modelValue="submitForm(matiere)"
                  >
                  </Autocomplete>
                </v-col>
                <v-col md="2">
                  <TextField
                    label="Coeff"
                    class="mt-2"
                    :isRequired="true"
                    placeholder="Coeff"
                    required
                    v-model="matiere.coefficient"
                    @update:modelValue="submitForm(matiere)"
                  ></TextField>
                </v-col>
                <v-col md="2">
                  <TextField
                    label="VH"
                    class="mt-2"
                    placeholder="VH"
                    required
                    v-model="matiere.volume_horaire"
                    @update:modelValue="submitForm(matiere)"
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
    </v-container>
  </form>
</template>
<script>
import { router, useForm } from "@inertiajs/vue3";
import { mdiCloseCircle, mdiPlusCircle, mdiInformation } from "@mdi/js";
export default {
  props: ["type", "niveaux", "matieres"],
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
      niveau: null,
      matieres: [],
    }),
  }),

  computed: {
    setNiveaux() {
      let list = [];

      if (this.niveaux) {
        this.niveaux.forEach((element) => {
          if (element) {
            list.push({
              ...element,
              code_libelle: element.code + "- " + element.libelle,
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

      this.form.etablissement_section_id = this.$page.props.sections.find(
        (el) => el.section == this.section
      );
      this.$emit("formSubmitted", this.form);
      this.$emit("niveauMatiereFormValid", this.isValid());
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
            this.form.niveau == null ||
            this.form.niveau == "" ||
            this.form.matiere == "" ||
            el.matiere == null ||
            el.matiere == "" ||
            el.coefficient == 0 ||
            el.coefficient == null ||
            el.coefficient.trim() == ""
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
    addRow() {
      this.form.matieres.push({
        etablissement_section_id: this.$page.props.admin_etablissement.etablissement_id,
        matiere: null,
        coefficient: 0,
        volume_horaire: 0,
        after: null,
      });
    },
    removeRow(matiere) {
      this.form.matieres = this.form.matieres.filter((el) => el !== matiere);
    },
    async verify(matiere) {
      const array = this.form.matieres.filter(
        (el) => el.matiere !== null && el.matiere == matiere.matiere
      );
      if (array.length > 1) {
        this.removeRow(matiere);
        this.$swal("L'élément existe déjà !");
      }
    },
  },
  created() {},
  mounted() {
    this.addRow();
    this.section = this.getSection(this.type);
    console.log("setNiveaux:", this.setNiveaux);
  },
};
</script>
