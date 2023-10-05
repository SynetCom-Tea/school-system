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
        <v-divider></v-divider>
        <v-card>
          <v-card-text>
            <v-row>
              <v-col md="2"></v-col>
              <v-col md="4">
                <Autocomplete
                  label="Filieres"
                  item-title="libelle"
                  item-value="id"
                  :items="filieres"
                  v-model="form.filiere"
                  @update:modelValue="submitForm(null, null, null)"
                  chips
                >
                </Autocomplete>
              </v-col>
              <v-col md="4">
                <Autocomplete
                  label="Niveaux"
                  item-title="code_libelle"
                  item-value="id"
                  :items="setNiveaux"
                  v-model="form.niveau"
                  @update:modelValue="submitForm(null, null, null)"
                  chips
                >
                </Autocomplete>
              </v-col>
            </v-row>
            <!-- <v-divider></v-divider> -->
            <v-card class="mx-auto" max-width="1200">
              <v-card-title flat style="color: #7d002c; background-color: white"
                >Unité d'enseingment</v-card-title
              >
              <v-card-text disabled :key="ue.id" v-for="(ue, i) in form.ues">
                <v-row>
                  <v-col md="1"></v-col>
                  <v-col md="3">
                    <Autocomplete
                      label="Unité d'enseignement"
                      class="mt-2"
                      item-title="libelle"
                      item-value="id"
                      :items="ues"
                      v-model="ue.ue"
                      @update:modelValue="submitForm(form.ues[i], null, null)"
                      chips
                    >
                    </Autocomplete>
                  </v-col>
                  <v-col md="2">
                    <TextField
                      label="credit"
                      class="mt-2"
                      :isRequired="true"
                      placeholder="credit"
                      v-model="form.ues[i].credit"
                      @update:modelValue="submitForm(form.ues[i], null, null)"
                      required
                    ></TextField>
                  </v-col>
                  <v-col md="2">
                    <TextField
                      label="Volume horaire"
                      class="mt-2"
                      :isRequired="true"
                      placeholder="Volume horaire"
                      v-model="form.ues[i].volume_horaire"
                      @update:modelValue="submitForm(form.ues[i], null, null)"
                      required
                    ></TextField>
                  </v-col>
                  <v-col md="1">
                    <br />
                    <Button
                      type="button"
                      variant="outlined"
                      :disabled="form.ues ? !(form.ues.length > 1) : true"
                      icon
                      @click="removeRowUe(form.ues[i])"
                      size="large"
                      small
                      color="error"
                    >
                      <v-icon :icon="icons.mdiCloseCircle"></v-icon>
                    </Button>
                    <!-- <v-btn variant="outlined" :disabled="form.ues ? !(form.ues.length > 1) : true" icon @click="removeRowUe(form.ues[i])" fab small color="error">
                                        <v-icon :icon="icons.mdiCloseCircle"></v-icon>
                                    </v-btn> -->
                  </v-col>
                </v-row>
                <!-- <v-divider></v-divider> -->
                <v-card class="mx-auto" max-width="800">
                  <v-card-title flat style="color: #7d002c; background-color: white"
                    >les Matières</v-card-title
                  >
                  <v-card-text>
                    <v-row disabled :key="matiere.id" v-for="(matiere, j) in ue.matieres">
                      <v-col md="1"></v-col>
                      <v-col md="4">
                        <Autocomplete
                          label="Matieres"
                          class="mt-2"
                          item-title="libelle"
                          item-value="id"
                          :items="matieres"
                          chips
                          v-model="ue.matieres[j].matiere"
                          @update:modelValue="submitForm(form.ues[i], j, matiere)"
                        >
                        </Autocomplete>
                      </v-col>
                      <v-col md="2">
                        <TextField
                          label="Coeff"
                          class="mt-2"
                          placeholder="Coeff"
                          :isRequired="true"
                          v-model="ue.matieres[j].coefficient"
                          @update:modelValue="submitForm(form.ues[i], jc, matiere)"
                        ></TextField>
                      </v-col>
                      <v-col md="2">
                        <TextField
                          label="VH"
                          class="mt-2"
                          :isRequired="true"
                          placeholder="VH"
                          v-model="ue.matieres[j].volume_horaire"
                          @update:modelValue="submitForm(form.ues[i], j, matiere)"
                        ></TextField>
                      </v-col>
                      <v-col md="1">
                        <br />
                        <Button
                          type="button"
                          variant="outlined"
                          :disabled="ue.matieres ? !(ue.matieres.length > 1) : true"
                          icon
                          @click="removeRow(ue, ue.matieres[i])"
                          size="large"
                          small
                          color="error"
                        >
                          <v-icon :icon="icons.mdiCloseCircle"></v-icon>
                        </Button>
                        <!-- <v-btn variant="outlined" :disabled="ue.matieres ? !(ue.matieres.length > 1) : true" icon @click="removeRow(ue,ue.matieres[i])" fab small color="error">
                                                <v-icon :icon="icons.mdiCloseCircle"></v-icon>
                                            </v-btn> -->
                      </v-col>
                    </v-row>
                    <v-row>
                      <v-col offset-md="11" cols="4">
                        <Button
                          type="button"
                          variant="outlined"
                          @click="addRow(ue)"
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
import Ue from "./ue.vue";
export default {
  props: ["type", "niveaux", "matieres", "filieres", "ues"],
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
      filiere: null,
      niveau: null,
      ues: [],
      etablissement_section_id: null,
    }),
  }),
  watch: {},
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
    async verifySomme(ue, i) {
      if (ue) {
        const somme = ue.matieres.reduce((accumulator, currentItem) => {
          return accumulator + parseFloat(currentItem.volume_horaire);
        }, 0);
        if (somme > ue.volume_horaire) {
          this.removeRow(ue, ue.matieres[i]);
          this.$swal(
            "La somme des volumes horaires ne doivent pas dépasser " +
              ue.volume_horaire +
              "!"
          );
        }
      }
    },
    // onSelectChange(itemToRemove){
    //     const indexToRemove = this.uetabs.indexOf(itemToRemove);
    //     if (indexToRemove !== -1) {
    //         // Si l'élément existe dans le tableau, supprimez-le
    //         this.uetabs.splice(indexToRemove, 1);
    //     }
    // },
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
    async submitForm(element, index, matiere) {
      await this.verify(element, index, matiere);
      await this.verifyUe(element);
      await this.verifySomme(element, index);
      await this.isValid();

      this.form.etablissement_section_id = this.$page.props.sections.find(
        (el) => el.section == this.section
      );
      this.$emit("formSubmitted", this.form);
      this.$emit("niveauMatiereSupFormValid", this.isValid());
    },
    async checkNiveauMatiereForm() {
      let valid = true;
      for (let i = 0; i < this.form.ues.length; i++) {
        const ue = this.form.ues[i];
        if (
          !ue.ue ||
          ue.ue == "" ||
          ue.ue == null ||
          ue.credit == 0 ||
          ue.credit == "" ||
          ue.credit == null
        ) {
          valid = false;
          break; // Sortez de la boucle car une condition n'est pas remplie
        }

        // Parcourez chaque élément de "matieres" pour cette "ue"
        for (let j = 0; j < ue.matieres.length; j++) {
          const matiere = ue.matieres[j];

          // Vérifiez si la propriété "matiere" n'est pas vide
          if (
            !matiere.matiere ||
            matiere.matiere == "" ||
            matiere.matiere == null ||
            matiere.coefficient == "" ||
            matiere.coefficient == null ||
            matiere.matiere == 0
          ) {
            valid = false; // Si "matiere" est vide, définissez fichier sur false
            break; // Sortez de la boucle car une condition n'est pas remplie
          }
        }

        if (!valid) {
          break; // Sortez de la boucle externe si une condition n'est pas remplie
        }
        return valid;
      }
    },
    async isValid() {
      let valid = false;
      const result = await this.checkNiveauMatiereForm();
      if (
        this.form.filiere != null &&
        this.form.filiere != "" &&
        this.form.niveau != null &&
        this.form.niveau != "" &&
        result == true
      ) {
        valid = true;
      }
      return valid;
    },

    addRowUe() {
      this.form.ues.push({
        ue_id: null,
        credit: 0,
        volume_horaire: 0,
        matieres: [],
        before: null,
        after: null,
      });
      let ue = this.form.ues[this.form.ues.length - 1];
      this.addRow(ue);
    },
    addRow(ue) {
      ue.matieres.push({
        matiere_id: null,
        coefficient: 0,
        volume_horaire: 0,
        after: null,
      });
    },
    removeRowUe(id) {
      this.form.ues = this.form.ues.filter((el) => el !== id);
    },
    removeRow(ue, matiere) {
      ue.matieres = ue.matieres.filter((el) => el !== matiere);
    },
    async verifyUe(element) {
      if (element) {
        const array = this.form.ues.filter((el) => el.ue !== null && el.ue == element.ue);
        if (array.length > 1) {
          this.removeRowUe(element);
          this.$swal("L'élément existe déjà !");
        }
      }
    },
    async verify(ue, index, matiere) {
      if (matiere) {
        const array = ue.matieres
          ? ue.matieres.filter(
              (el) => el.matiere !== null && el.matiere == matiere.matiere
            )
          : [];
        if (array.length > 1) {
          this.removeRow(ue, ue.matieres[index]);
          this.$swal("L'élément existe déjà !");
        }
      }
    },
  },
  created() {},
  mounted() {
    this.addRowUe();
  },
};
</script>
