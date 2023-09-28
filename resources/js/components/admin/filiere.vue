<template>
  <form @submit.prevent="submitForm" novalidate>
    <v-container fluid>
      <v-card variant="outlined" style="border: 2px solid #7d002c">
        <v-card-title style="color: white; background-color: #7d002c"
          >FILIÈRES</v-card-title
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
              Cette section vous permet de configurer les filieres enseignées dans cet
              établissement
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

        <v-card>
          <v-card-text> </v-card-text>
          <v-card-text>
            <v-row>
              <v-col offset-md="3" md="6">
                <Autocomplete
                  label="Faculté"
                  class="mt-2"
                  :items="facultes"
                  v-model="form.faculte"
                  @update:modelValue="submitForm(null, null, null)"
                  itemValue="id"
                  itemTitle="libelle"
                  chips
                  closable-chips
                >
                </Autocomplete>
              </v-col>
            </v-row>

            <!-- <v-divider></v-divider> -->
            <v-card class="mx-auto">
              <v-card-title flat style="color: #7d002c; background-color: white"
                >Les départements</v-card-title
              >
              <v-divider></v-divider>
              <br />
              <v-card-text
                disabled
                :key="departement.id"
                v-for="(departement, i) in form.departements"
              >
                <v-row>
                  <v-col offset-md="3" md="6">
                    <TextField
                      label="Departement"
                      class="mt-2"
                      :isRequired="true"
                      placeholder="Departement"
                      v-model="departement.departement"
                      @update:modelValue="submitForm(form.departements[i], null, null)"
                    ></TextField>
                  </v-col>

                  <v-col md="1">
                    <br />
                    <Button
                      type="button"
                      variant="outlined"
                      :disabled="!(form.departements.length > 1)"
                      icon
                      @click="removeRowUe(departement)"
                      size="large"
                      small
                      color="error"
                    >
                      <v-icon :icon="icons.mdiCloseCircle"></v-icon>
                    </Button>
                  </v-col>
                </v-row>
                <!-- <v-divider></v-divider> -->

                <v-card-text>
                  <v-card class="mx-auto" max-width="800">
                    <v-card-title flat style="color: #7d002c; background-color: white"
                      >Les filières</v-card-title
                    >
                    <v-divider></v-divider>
                    <br />
                    <v-row
                      disabled
                      :key="filiere.id"
                      v-for="(filiere, j) in departement.filieres"
                    >
                      <v-col offset-md="1" md="4">
                        <TextField
                          label="Code filière"
                          class="mt-2"
                          :isRequired="true"
                          placeholder="Code filière"
                          v-model="filiere.code"
                          @update:modelValue="
                            submitForm(form.departements[i], j, filiere)
                          "
                        ></TextField>
                      </v-col>
                      <v-col md="4">
                        <TextField
                          label="Nom de la filière"
                          class="mt-2"
                          :isRequired="true"
                          placeholder="Nom de la filière"
                          v-model="filiere.libelle"
                          @update:modelValue="
                            submitForm(form.departements[i], j, filiere)
                          "
                        ></TextField>
                      </v-col>
                      <v-col md="1">
                        <br />
                        <Button
                          type="button"
                          variant="outlined"
                          :disabled="!(departement.filieres.length > 1)"
                          icon
                          @click="removeRow(departement, filiere)"
                          size="large"
                          small
                          color="error"
                        >
                          <v-icon :icon="icons.mdiCloseCircle"></v-icon>
                        </Button>
                      </v-col>
                    </v-row>
                    <v-row>
                      <v-col offset-md="10" cols="4">
                        <Button
                          type="button"
                          variant="outlined"
                          @click="addRow(departement)"
                          icon
                          size="large"
                          color="primary"
                        >
                          <v-icon :icon="icons.mdiPlusCircle" small></v-icon>
                        </Button>
                      </v-col>
                    </v-row>
                    <br />
                  </v-card>
                </v-card-text>
              </v-card-text>
              <v-row>
                <v-col offset-md="11" cols="4">
                  <Button
                    type="button"
                    variant="outlined"
                    @click="addRowUe"
                    icon
                    size="large"
                    color="primary"
                  >
                    <v-icon :icon="icons.mdiPlusCircle" small></v-icon>
                  </Button>
                </v-col>
              </v-row>
              <br />
            </v-card>

            <br />
          </v-card-text>
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
  props: ["type", "niveaux", "facultes"],
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
    form: useForm({
      faculte: null,
      fichier_filiere: null,
      departements: [],
      tabsFilieres: [],
    }),
  }),
  // watch: {
  //     // Surveillez les valeurs spécifiques ici
  //     departements(nou,old){
  //         console.log('tttttt',nou)
  //             // if (data.departements && Array.isArray(data.departements)) {
  //             //     data.departements.forEach(element => {
  //             //         this.form.tabsFilieres = this.form.tabsFilieres.concat(element.filieres)
  //             //     });
  //             // }
  //     },
  // },

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
      console.log("type", type);
      if (type == "1") {
        return "Primaire";
      } else if (type == "2") {
        return "Secondaire";
      } else if (type == "3") {
        return "Supérieur";
      } else {
        return "Universitaire";
      }
    },
    test() {
      this.form.tabsFilieres = [];
      if (this.form.departements && Array.isArray(this.form.departements)) {
        this.form.departements.forEach((element) => {
          this.form.tabsFilieres = this.form.tabsFilieres.concat(element.filieres);
        });
      }
    },
    resetForm(check) {
      if (check) {
        this.form.departements = [];
        this.addRowUe();
      }
    },
    async submitForm(departement, index, filiere) {
      await this.verify(departement, index, filiere);
      await this.verifyUe(departement);
      await this.isValid();
      this.test();

      this.form.etablissement_section_id = this.$page.props.sections.find(
        (el) => el.section == this.section
      );

      this.$emit("formSubmitted", this.form);
      this.$emit("filiereFormValid", this.isValid());
    },
    async checkFiliereForm() {
      let valid = true; // Initialisez la variable fichier à true par défaut
      // Parcourez chaque élément de "ues"
      for (let i = 0; i < this.form.departements.length; i++) {
        const departement = this.form.departements[i];
        // Vérifiez si "ue" est défini et si "matieres" existe et n'est pas vide
        if (
          !departement ||
          !departement.departement ||
          departement.departement === "" ||
          !departement.filieres ||
          departement.filieres.length === 0
        ) {
          valid = false; // Si l'une des conditions n'est pas remplie, définissez fichier sur false
          break; // Sortez de la boucle car une condition n'est pas remplie
        }

        // Parcourez chaque élément de "matieres" pour cette "ue"
        for (let j = 0; j < departement.filieres.length; j++) {
          const filiere = departement.filieres[j];
          // Vérifiez si la propriété "matiere" n'est pas vide
          if (
            !filiere.code ||
            filiere.code === "" ||
            filiere.libelle === "" ||
            filiere.code == null ||
            filiere.libelle == null
          ) {
            valid = false; // Si "matiere" est vide, définissez fichier sur false
            break; // Sortez de la boucle car une condition n'est pas remplie
          }
        }

        if (!valid) {
          break; // Sortez de la boucle externe si une condition n'est pas remplie
        }
      }
      return valid;
    },
    async isValid() {
      let valide = false;
      const result = await this.checkFiliereForm();
      if (this.form.faculte != null && this.form.faculte !== "" && result === true) {
        valide = true;
      }
      return valide;
    },
    addRowUe() {
      this.form.departements.push({
        etablissement: this.$page.props.admin_etablissement.etablissement_id,
        departement: null,
        filieres: [],
        before: null,
        after: null,
      });
      let departements = this.form.departements[this.form.departements.length - 1];
      this.addRow(departements);
    },
    addRow(depart) {
      depart.filieres.push({
        code: null,
        libelle: null,
        before: null,
        after: null,
      });
    },
    removeRowUe(id) {
      this.form.departements = this.form.departements.filter((el) => el !== id);
    },
    removeRow(departement, filiere) {
      departement.filieres = departement.filieres.filter((el) => el !== filiere);
    },
    async verifyUe(element) {
      if (element) {
        const array = this.form.departements.filter(
          (el) => el.departement !== null && el.departement == element.departement
        );

        if (array.length > 1) {
          this.removeRowUe(element);
          this.$swal("L'élément existe déjà !");
        }
      }
    },
    async verify(departement, index, filiere) {
      if (departement) {
        const array = departement.filieres.filter(
          (el) => el.code !== null && el.code == filiere.code
        );

        if (array.length > 1) {
          this.removeRow(departement, departement.filieres[index]);
          this.$swal("L'élément existe déjà !");
        }
      }
    },
  },
  mounted() {
    this.addRowUe();
    // this.addRowInit()
    this.section = this.getSection(this.type);
  },
};
</script>
