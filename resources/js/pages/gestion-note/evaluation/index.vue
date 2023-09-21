<script>
import AuthenticatedLayout from "@/layouts/AuthenticatedLayout.vue";
import { useForm } from "@inertiajs/vue3";
// import Datatable from "@/components/customizedComponents/datatable.vue";

import {
  mdiAccountSchool,
  mdiPlus,
  mdiPencil,
  mdiDelete,
  mdiPlusCircle,
  mdiClipboardEditOutline,
  mdiTools,
} from "@mdi/js";
export default {
  components: {
    // Datatable,
    mdiAccountSchool,
    mdiPlus,
    mdiPencil,
    mdiDelete,
    mdiPlusCircle,
    mdiClipboardEditOutline,
    mdiTools,
  },
  layout: AuthenticatedLayout,
  props: [
    "evaluations",
    "periodes",
    "typeEvaluations",
    "enseigements",
    "sections",
    "nivau_matieres",
    "enseignant",
  ],
  data() {
    return {
      icon: {
        mdiAccountSchool,
        mdiPlus,
        mdiPencil,
        mdiDelete,
        mdiPlusCircle,
        mdiClipboardEditOutline,
        mdiTools,
      },

      headers: [
        {
          title: "N°",
          align: "center",
          key: "id",
        },
        {
          title: "Matière",
          align: "center",
          key: "enseignement_annee.niveau_matiere.matiere.libelle",
        },
        {
          title: "Niveau/Classe",
          align: "center",
          key: "enseignement_annee.niveau_matiere.niveau.libelle",
        },
        {
          title: "Enseignant",
          align: "center",
          key: "enseignement_annee.enseignant.nom",
        },
        {
          title: "Date Evaluation",
          align: "center",
          key: "date",
        },
        {
          title: "Type Evaluation",
          align: "center",
          key: "type_evaluation.libelle",
        },
        {
          title: "periodes",
          align: "center",
          key: "periode.libelle",
        },
        {
          title: "Pourcentage",
          align: "center",
          key: "pourcentage",
        },
        {
          title: "Actions",
          align: "center",
          key: "actions",
        },
      ],

      dialog_title: "Nouveau Evaluation",
      dialog: false,

      form: useForm({
        date: "",
        pourcentage: "",
        type_evaluation_id: "",
        periode_id: "",
        enseignement_annee_id: "",
      }),
    };
  },

  methods: {
    create() {
      this.dialog = true;
      this.dialog_title = "Nouveau Evaluation";
    },
    editItem(item) {
      console.log("edit", item);
      this.dialog_title = "Modifier Evaluation " + item.id;
      this.form.id = item.id;
      this.form.date = item.date;
      this.form.pourcentage = item.pourcentage;
      this.form.periode_id = item.periode_id;
      this.form.type_evaluation_id = item.type_evaluation_id;
      this.form.enseignement_annee_id = item.enseignement_annee_id;
      this.dialog = true;
    },
    deleteItem(item) {
      this.$swal({
        title: "Es-tu sûr?",
        text: "Vous ne pourrez pas revenir en arrière !",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "orange",
        cancelButtonColor: "#d33",
        confirmButtonText: "Oui, supprimez-le!",
        cancelButtonText: "Non, annulez !",
      }).then((result) => {
        if (result.isConfirmed) {
          this.form.delete(route("evaluation.destroy", item.id), {
            onFinish: () => {
              if (this.$page.props.flash?.message?.type == "error") {
                this.$swal({
                  icon: "error",
                  title: "Suppression",
                  text: this.$page.props.flash?.message?.text,
                  toast: true,
                  position: "top-end",
                  showConfirmButton: false,
                  timer: 5000,
                  timerProgressBar: true,
                });
              } else if (this.$page.props.flash?.message?.type == "success") {
                this.$swal({
                  icon: "success",
                  title: "Suppression",
                  text: this.$page.props.flash?.message?.text,
                  toast: true,
                  position: "top-end",
                  showConfirmButton: false,
                  timer: 5000,
                  timerProgressBar: true,
                });
              }
            },
          });
        }
      });
    },
    async submit() {
      const { valid } = await this.$refs.form.validate();
      if (!this.form.id && valid) {
        // console.log(this.form)
        this.form.post(route("evaluation.store"), {
          onFinish: () => {
            this.close();
            this.$swal({
              icon: "success",
              title: "Enregistrement",
              text: "Evaluation créée avec succès!",
              toast: true,
              position: "top-end",
              showConfirmButton: false,
              timer: 5000,
              timerProgressBar: true,
            });
          },
        });
      } else if (this.form.id && valid) {
        const {
          date,
          pourcentage,
          periode_id,
          type_evaluation_id,
          enseignement_annee_id,
        } = this.form;

        this.form.put(route("evaluation.update", this.form.id), {
          onFinish: () => {
            this.close();
            this.$swal({
              icon: "success",
              title: "Enregistrement",
              text: "Evaluation modifié avec succès!",
              toast: true,
              position: "top-end",
              showConfirmButton: false,
              timer: 5000,
              timerProgressBar: true,
            });
          },
        });
      }
    },
    close() {
      this.form.id = "";
      this.form.date = "";
      this.form.pourcentage = "";
      this.form.periode_id = "";
      this.form.type_evaluation_id = "";
      this.form.enseignement_annee_id = "";
      this.dialog = false;
    },
  },
};
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <v-card>
      <Toolbar :icon="icon.mdiTools" toolbarTitle="Gestion des Evaluations"></Toolbar>
      <v-card-text>
        <br />

        <Datatable
          titleDatatable="Listes des evaluations "
          :headers="headers"
          :items="evaluations"
        >
          <template v-slot:addBtn>
            <br /><br />
            <v-row justify="center">
              <v-dialog
                v-model="dialog"
                transition="dialog-top-transition"
                persistent
                width="900px"
              >
                <template v-slot:activator="{ props }">
                  <div class="custom-add-button">
                    <Button
                      @click="create"
                      x-small
                      variant="outlined"
                      color="primary"
                      v-bind="props"
                    >
                      Ajouter
                    </Button>
                  </div>
                </template>
                <v-card>
                  <!-- <v-card-title dense color="orange" dark> -->
                  <v-toolbar dense color="primary" dark>
                    <v-toolbar-title>
                      <v-icon left>{{
                        form.id ? icon.mdiPencil : icon.mdiPlusCircle
                      }}</v-icon>
                      {{ dialog_title }}
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                  </v-toolbar>
                  <!-- </v-card-title> -->
                  <v-card-text>
                    <v-form ref="form">
                      <v-container>
                        <v-row>
                          <v-col cols="12" sm="6">
                            <TextField
                              label="Date Evaluation"
                              type="date"
                              variant="outlined"
                              placeholder="Date"
                              v-model="form.date"
                              isRequired
                              :rules="[(v) => !!v || 'Ce champ est requis!']"
                            >
                            </TextField>
                          </v-col>
                          <v-col cols="12" sm="6">
                            <TextField
                              label="Pourcentage"
                              variant="outlined"
                              placeholder="pourcentage"
                              v-model="form.pourcentage"
                              isRequired
                              :rules="[(v) => !!v || 'Ce champ est requis!']"
                            >
                            </TextField>
                          </v-col>
                          <v-col cols="12" sm="6" md="6">
                            <Select
                              label="Periode"
                              variant="outlined"
                              item-title="libelle"
                              item-value="id"
                              :items="periodes"
                              v-model="form.periode_id"
                            >
                            </Select>
                          </v-col>
                          <v-col cols="12" sm="6">
                            <Select
                              label="Type Evaluation"
                              variant="outlined"
                              item-title="libelle"
                              item-value="id"
                              :items="typeEvaluations"
                              v-model="form.type_evaluation_id"
                            >
                            </Select>
                          </v-col>
                          <v-col cols="12" sm="6">
                            <Select
                              label="Matiere/Niveau/Classe"
                              variant="outlined"
                              item-title="code"
                              item-value="id"
                              :items="enseigements"
                              v-model="form.enseignement_annee_id"
                            >
                            </Select>
                          </v-col>
                        </v-row>
                      </v-container>
                    </v-form>
                  </v-card-text>
                  <v-card-actions class="justify-end">
                    <v-spacer></v-spacer>
                    <v-btn dark small type="button" color="red" @click="close">
                      <v-icon :icon="icon.mdiCancel" left></v-icon> Annuler
                    </v-btn>
                    <v-btn small color="success" @click="submit">
                      <v-icon :icon="icon.mdiCheckCircle" left></v-icon> Enregistrer
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </v-row>
          </template>
          <template v-slot:[`item.actions`]="{ item }">
            <v-icon
              size="small"
              color="warning"
              title="Modifier"
              class="me-2"
              @click="editItem(item.raw)"
              :icon="icon.mdiPencil"
            >
            </v-icon>
            <v-icon
              size="small"
              color="error"
              @click="deleteItem(item.raw)"
              :icon="icon.mdiDelete"
            >
            </v-icon>
          </template>
        </Datatable>
      </v-card-text>
    </v-card>
  </AuthenticatedLayout>
</template>
