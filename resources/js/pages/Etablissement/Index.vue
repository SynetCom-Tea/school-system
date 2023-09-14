<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router, useForm } from "@inertiajs/vue3";
import {
  mdiContentSaveEditOutline,
  mdiCancel,
  mdiPlus,
  mdiSchool,
  mdiPencil,
  mdiEye,
} from "@mdi/js";
export default {
  layout: AuthenticatedLayout,
  props: ["ecoles", "instituts", "universites", "types", "sections"],

  data() {
    return {
      icons: {
        mdiCancel,
        mdiPlus,
        mdiSchool,
        mdiPencil,
        mdiEye,
        mdiContentSaveEditOutline,
      },
      tab: null,
      model: "Activer",
      page: 1,
      itemsPerPage: 3,
      form: useForm({
        type_etablissement_id: "",
        section: [],
      }),
      dialog: false,
      target: {},
      show: false,
    };
  },

  methods: {
    goTo() {
      router.get(route("etablissements.create"));
    },
    editItem(item) {
      this.dialog = true;
      this.dialog_title = "Mise à jour de " + item.name;
      this.form.id = item.id;
      this.form.type_etablissement_id = item.type_etablissement_id;
      item.sections.forEach((it) => {
        this.form.section.push(it.id);
      });
    },
    showItem(item) {
      this.target = item;
      this.show = true;
    },
    activeItem(item) {
      if (item.statut == 1) {
        this.$swal({
          title: "Désactiver " + item.name + " ?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Oui!",
          cancelButtonText: "Annuler!",
          position: "top-end",
        }).then((result) => {
          if (result.isConfirmed) {
            router.post(route("etablissement.activer", item.id), {
              onFinish: () =>
                this.$swal({
                  icon: "success",
                  title: "Désactivation",
                  text: item.name + " Désactivé avec succès!",
                  toast: true,
                  position: "top-end",
                  showConfirmButton: false,
                  timer: 5000,
                  timerProgressBar: true,
                }),
              onError: () =>
                this.$swal({
                  icon: "danger",
                  title: "Désactivation",
                  text: "Désolé vous ne pouvez pas Désactiver!",
                  toast: true,
                  position: "top-end",
                  showConfirmButton: false,
                  timer: 5000,
                  timerProgressBar: true,
                }),
            });
          } else {
            router.get(route("etablissements.index"));
          }
        });
      } else if (item.statut == 0) {
        this.$swal({
          title: "Activer " + item.name + " ?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Oui!",
          cancelButtonText: "Annuler!",
          position: "top-end",
        }).then((result) => {
          if (result.isConfirmed) {
            router.post(route("etablissement.activer", item.id), {
              onFinish: () =>
                this.$swal({
                  icon: "success",
                  title: "Activation",
                  text: item.name + " Activé avec succès!",
                  toast: true,
                  position: "top-end",
                  showConfirmButton: false,
                  timer: 5000,
                  timerProgressBar: true,
                }),
              onError: () =>
                this.$swal({
                  icon: "danger",
                  title: "Activation",
                  text: "Désolé vous ne pouvez pas Activer!",
                  toast: true,
                  position: "top-end",
                  showConfirmButton: false,
                  timer: 5000,
                  timerProgressBar: true,
                }),
            });
          } else {
            router.get(route("etablissements.index"));
          }
        });
      }
    },
    async submit() {
      console.log("submit", this.form);
      const { valid } = await this.$refs.form.validate();
      if (valid) {
        this.form.put(route("etablissements.update", this.form.id), {
          onFinish: () => {
            this.close();
            this.$swal({
              icon: "success",
              title: "Modification",
              text: "Sections modifiées avec succès!",
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
      this.form.type_etablissement_id = "";
      this.form.section = [];
      this.dialog = false;
    },
  },
  computed: {
    pageCount() {
      return Math.ceil(this.instituts.length / this.itemsPerPage);
    },
    ecolelenghtCount() {
      return Math.ceil(this.ecoles.length / this.itemsPerPage);
    },
    univlenghtCount() {
      return Math.ceil(this.universites.length / this.itemsPerPage);
    },
    getSchools() {
      return this.ecoles.slice(
        (this.page - 1) * this.itemsPerPage,
        this.page * this.itemsPerPage
      );
    },
    getInstituts() {
      return this.instituts.slice(
        (this.page - 1) * this.itemsPerPage,
        this.page * this.itemsPerPage
      );
    },
    getUniversities() {
      return this.universites.slice(
        (this.page - 1) * this.itemsPerPage,
        this.page * this.itemsPerPage
      );
    },
  },
};
</script>
<template>
  <v-card>
    <page-toolbar :icon="icons.mdiSchool">Gestion des Etablissements</page-toolbar>
    <v-dialog v-model="show" max-width="700" v-if="target">
      <v-card>
        <v-toolbar dark color="primary">
          <v-toolbar-title>
            Détail de l'établissement <v-icon size="large"> </v-icon>
          </v-toolbar-title>
        </v-toolbar>
        <v-card-text>
          <v-card flat class="mt-3 mb-6" v-if="target.id">
            <v-card>
              <v-table dense>
                <tbody>
                  <tr>
                    <td class="font-weight-black">Type:</td>
                    <td>{{ target.type_etablissement.name }}</td>
                  </tr>
                  <tr>
                    <td class="font-weight-black">Nom Etablissement:</td>
                    <td>{{ target.name }}</td>
                  </tr>
                  <tr>
                    <td class="font-weight-black">Ville</td>
                    <td>{{ target.ville }}</td>
                  </tr>
                  <tr>
                    <td class="font-weight-black">Adresse :</td>
                    <td>{{ target.adresse }}</td>
                  </tr>
                  <tr>
                    <td class="font-weight-black">Email :</td>
                    <td>{{ target.email }}</td>
                  </tr>
                  <tr v-if="target.sections[0]">
                    <td class="font-weight-black">Sections :</td>
                    <td>
                      <v-chip-group column>
                        <v-chip
                          label
                          color="primary"
                          :key="i"
                          v-for="(t, i) in target.sections"
                          >{{ t.libelle }}</v-chip
                        >
                      </v-chip-group>
                    </td>
                  </tr>
                  <tr>
                    <td class="font-weight-black">Administrateur:</td>
                    <td :key="i" v-for="(t, i) in target.users">
                      {{ t.nom }} {{ t.prenom }}
                    </td>
                  </tr>
                  <tr>
                    <td class="font-weight-black">Email Admin:</td>
                    <td :key="i" v-for="(t, i) in target.users">{{ t.email }}</td>
                  </tr>
                  <tr>
                    <td class="font-weight-black">Statut:</td>
                    <td v-if="target.statut == 1">Actif</td>
                    <td v-if="target.statut == 0">Inactif</td>
                  </tr>
                </tbody>
              </v-table>
            </v-card>
          </v-card>
        </v-card-text>
        <v-card-actions class="justify-end" id="actions">
          <v-btn color="danger" variant="text" @click="show = false"> Fermer </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog
      v-model="dialog"
      transition="dialog-top-transition"
      persistent
      max-width="500px"
    >
      <template v-slot:default="{ isActive }">
        <v-card>
          <v-toolbar dense color="primary" dark>
            <v-toolbar-title
              style="
                font-size: 0.9em;
                width: auto;
                word-wrap: break-word;
                white-space: pre-wrap;
                word-break: break-word;
              "
            >
              <p style="width: auto" class="text-wrap">
                <v-icon left>{{
                  form.id ? icons.mdiPencil : icons.mdiPlusCircle
                }}</v-icon>
                {{ dialog_title }}
              </p></v-toolbar-title
            >
          </v-toolbar>
          <v-card-text>
            <v-form ref="form">
              <v-row>
                <v-col cols="12" md="12">
                  <Select
                    label="Type"
                    :items="types"
                    variant="outlined"
                    item-value="id"
                    item-title="name"
                    v-model="form.type_etablissement_id"
                  ></Select>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" md="12">
                  <Select
                    label="Section"
                    :items="sections"
                    variant="outlined"
                    item-value="id"
                    item-title="libelle"
                    v-model="form.section"
                    isMultiple
                    chips
                    v-if="form.type_etablissement_id == 2"
                  ></Select>
                </v-col>
              </v-row>
            </v-form>
          </v-card-text>
          <v-card-actions class="justify-end">
            <v-spacer></v-spacer>
            <Button
              dark
              variant="outlined"
              small
              type="button"
              title="Fermer et quitter"
              color="red"
              @click="close"
              nameButton="Annuler"
            >
              <v-icon :icon="icons.mdiCancel" left></v-icon>
            </Button>
            <Button
              type="submit"
              small
              color="primary"
              @click="submit"
              title="Valider la modification"
              nameButton="Modifier"
            >
              <v-icon :icon="icons.mdiContentSaveEditOutline" left></v-icon>
            </Button>
          </v-card-actions>
        </v-card>
      </template>
    </v-dialog>
    <v-card-text>
      <v-btn
        variant="outlined"
        color="primary"
        :prepend-icon="icons.mdiPlus"
        @click="goTo()"
        elevation="4"
        rounded="lg"
      >
        Ajouter
      </v-btn>
    </v-card-text>
    <v-tabs v-model="tab" color="primary" align-tabs="end">
      <v-tab value="1">Ecoles</v-tab>
      <v-tab value="2">Instituts</v-tab>
      <v-tab value="3">Universités</v-tab>
    </v-tabs>
    <v-card-text>
      <v-window v-model="tab">
        <v-window-item value="1">
          <v-container>
            <v-row>
              <v-col :key="i" v-for="(t, i) in getSchools">
                <v-card
                  elevation="6"
                  width="300"
                  style="border-color: #004980"
                  variant="outlined"
                  rounded="shaped"
                >
                  <v-img
                    style="object-fit: fill; width: 300px; height: 200px"
                    :src="'../logos/' + t.logo"
                    class="text-white"
                  >
                    <v-toolbar color="rgba(0, 0, 0, 0)">
                      <template v-slot:prepend>
                        <v-icon
                          color="primary"
                          :icon="icons.mdiEye"
                          title="Détail l'établissement"
                          style="top: 0; left: 0; display: absolute"
                          @click="showItem(t)"
                        ></v-icon>
                      </template>

                      <template v-slot:append>
                        <v-icon
                          color="primary"
                          :icon="icons.mdiPencil"
                          title="Modifier l'établissement"
                          style="top: 0; right: 0; display: absolute"
                          @click="editItem(t)"
                        ></v-icon>
                      </template>
                    </v-toolbar>
                  </v-img>

                  <p class="text-h6" style="text-align: center">{{ t.name }}</p>
                  <v-switch
                    v-if="t.statut == 1"
                    color="primary"
                    :model-value="true"
                    label="Désactiver"
                    @click="activeItem(t)"
                  ></v-switch>
                  <v-switch
                    v-if="t.statut == 0"
                    color="primary"
                    class="custom-red"
                    :model-value="false"
                    label="Activer"
                    @click="activeItem(t)"
                  ></v-switch>
                </v-card>
              </v-col>
            </v-row>
          </v-container>
          <div style="align: center">
            <v-pagination
              v-model="page"
              :length="ecolelenghtCount"
              :total-visible="6"
              :items-per-page="itemsPerPage"
            ></v-pagination>
          </div>
        </v-window-item>

        <v-window-item value="2">
          <v-container>
            <v-row>
              <v-col :key="i" v-for="(t, i) in getInstituts">
                <v-card
                  elevation="6"
                  width="300"
                  style="border-color: #004980"
                  variant="outlined"
                  rounded="shaped"
                >
                  <v-img
                    style="object-fit: fill; width: 300px; height: 200px"
                    :src="'../logos/' + t.logo"
                    class="text-white"
                  >
                    <v-toolbar color="rgba(0, 0, 0, 0)">
                      <template v-slot:prepend>
                        <v-icon
                          color="primary"
                          :icon="icons.mdiEye"
                          title="Détail l'établissement"
                          style="top: 0; left: 0; display: absolute"
                          @click="showItem(t)"
                        ></v-icon>
                      </template>

                      <template v-slot:append>
                        <v-icon
                          color="primary"
                          :icon="icons.mdiPencil"
                          title="Modifier l'établissement"
                          style="top: 0; right: 0; display: absolute"
                          @click="editItem(t)"
                        ></v-icon>
                      </template>
                    </v-toolbar>
                  </v-img>

                  <p class="text-h6" style="text-align: center">{{ t.name }}</p>
                  <v-switch
                    v-if="t.statut == 1"
                    color="primary"
                    :model-value="true"
                    label="Désactiver"
                    @click="activeItem(t)"
                  ></v-switch>
                  <v-switch
                    v-if="t.statut == 0"
                    color="primary"
                    class="custom-red"
                    :model-value="false"
                    label="Activer"
                    @click="activeItem(t)"
                  ></v-switch>
                </v-card>
              </v-col>
            </v-row>
          </v-container>
          <div class="text-center pt-2">
            <v-pagination
              v-model="page"
              :length="pageCount"
              :total-visible="6"
              :items-per-page="itemsPerPage"
            ></v-pagination>
          </div>
        </v-window-item>

        <v-window-item value="3">
          <v-container>
            <v-row>
              <v-col :key="i" v-for="(t, i) in getUniversities">
                <v-card
                  elevation="6"
                  max-width="300"
                  style="border-color: #004980"
                  variant="outlined"
                  rounded="shaped"
                >
                  <v-img
                    style="object-fit: fill; width: 300px; height: 200px"
                    :src="'../logos/' + t.logo"
                    class="text-white"
                  >
                    <v-toolbar color="rgba(0, 0, 0, 0)">
                      <template v-slot:prepend>
                        <v-icon
                          color="primary"
                          :icon="icons.mdiEye"
                          title="Détail l'établissement"
                          style="top: 0; left: 0; display: absolute"
                          @click="showItem(t)"
                        ></v-icon>
                      </template>

                      <template v-slot:append>
                        <v-icon
                          color="primary"
                          :icon="icons.mdiPencil"
                          title="Modifier l'établissement"
                          style="top: 0; right: 0; display: absolute"
                          @click="editItem(t)"
                        ></v-icon>
                      </template>
                    </v-toolbar>
                  </v-img>

                  <p class="text-h6" style="text-align: center">{{ t.name }}</p>
                  <v-switch
                    v-if="t.statut == 1"
                    color="primary"
                    :model-value="true"
                    label="Désactiver"
                    @click="activeItem(t)"
                  ></v-switch>
                  <v-switch
                    v-if="t.statut == 0"
                    color="primary"
                    class="custom-red"
                    :model-value="false"
                    label="Activer"
                    @click="activeItem(t)"
                  ></v-switch>
                </v-card>
              </v-col>
            </v-row>
          </v-container>
          <div style="align: center">
            <v-pagination
              v-model="page"
              :items-per-page="itemsPerPage"
              :length="univlenghtCount"
              :total-visible="6"
            ></v-pagination>
          </div>
        </v-window-item>
      </v-window>
    </v-card-text>
  </v-card>
</template>
<style scoped>
.custom-red {
  color: rgb(168, 12, 12);
}
</style>
