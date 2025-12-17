<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { router } from '@inertiajs/vue3'

import {
  mdiAccountSchool,
  mdiPlus,
  mdiPencil,
  mdiDelete,
  mdiPlusCircle,
  mdiClipboardEditOutline,
  mdiOfficeBuilding,
  mdiMail,
  mdiCalendar,
  mdiLock,
  mdiArchiveOutline,
  mdiLockOpenVariant,
  mdiBookOpenPageVariant
} from "@mdi/js";
export default {
  components: {
    mdiAccountSchool,
    mdiPlus,
    mdiPencil,
    mdiDelete,
    mdiPlusCircle,
    mdiClipboardEditOutline,
    mdiOfficeBuilding,
    mdiMail,
    mdiCalendar,

  },
  layout: AuthenticatedLayout,
  props: ["annees"],
  data() {
    return {
      icon: {
        mdiAccountSchool,
        mdiPlus,
        mdiPencil,
        mdiDelete,
        mdiPlusCircle,
        mdiClipboardEditOutline,
        mdiOfficeBuilding,
        mdiMail,
        mdiCalendar,
        mdiLock,
        mdiArchiveOutline,
        mdiLockOpenVariant,
        mdiBookOpenPageVariant
      },
      headers: [
        {
          title: "ID",
          align: "start",
          sortable: true,
          key: "id",
        },
        { title: "Année Scolaire", align: "center", key: "libelle" },
        { title: "Statut", align: "center", key: "Status" },
        { title: "Actions", align: "center", key: "actions" },
      ],

      dialog_title: "Nouvelle Annee",
      dialog: false,

      form: useForm({
        libelle: "",
      }),
      rules: [
        (value) => {
          if (value) return true;
          return "Ce champ est requis!";
        },
      ],
    };
  },
  methods: {
    create() {
      if (this.getStatusYears().existAnneeEnAttente) {
        return this.$swal({
          icon: "error",
          title: "Création refusée",
          text: "Une année est déjà en attente d'activation.",
        });
      }
      this.dialog = true;
      this.dialog_title = "Nouvelle Année Scolaire";
    },
    editItem(item) {
      //console.log('edit',item)
      this.dialog_title = "Modifier l'année";
      this.form.id = item.id;
      this.form.libelle = item.libelle;
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
          this.form.delete(route("annees.destroy", item.id), {
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
      if (!valid) return;

      // 🔴 Vérification doublon
      if (this.yearAlreadyExists(this.form.libelle)) {
        return this.$swal({
          icon: "error",
          title: "Ajout refusé",
          text: "Cette année scolaire existe déjà.",
        });
      }
      if (!this.form.id && valid) {
        this.form.post(route("annees.store"), {
          onFinish: () => {
            //console.log(this.form)
            this.close();
            this.$swal({
              icon: "success",
              title: "Enregistrement",
              text: "Annee créée avec succès!",
              toast: true,
              position: "top-end",
              showConfirmButton: false,
              timer: 5000,
              timerProgressBar: true,
            });
          },
        });
      } else if (this.form.id && valid) {
        const { id, annee } = this.form;

        this.form.put(route("annees.update", this.form.id), {
          onFinish: () => {
            this.close();
            this.$swal({
              icon: "success",
              title: "Modification",
              text: "Année modifiée avec succès!",
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
      this.form.libelle = "";
      this.dialog = false;
    },

    activeYear(item) {
      // console.log('annnneee', this.getStatusYears());

      if (this.getStatusYears().existAnneeEncours) {
        return this.$swal({
          icon: "error",
          title: "Activation refusée",
          text: "Veuiller clôturer l'année en cours avant d'en activer une nouvelle.",
        });
      }
      const isActive = item.actif == 1;
      const actionText = isActive ? "Désactiver" : "Activer";

      this.$swal({
        title: `${actionText} l'année academique ${item.libelle} ?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Oui!",
        cancelButtonText: "Annuler !",
        position: "center",
      }).then((result) => {
        console.log(result);
        if (!result.isConfirmed) {
          // return router.get(route("annees.index"));
          return this.$inertia.get(route("annees.index"));
        }

        this.$inertia.put(route("annees.activer", item.id), {}, {
          onSuccess: () => {
            this.$swal({
              icon: "success",
              title: `Activation`,
              text: `L'année ${item.libelle} activée avec succès !`,
              toast: true,
              position: "top-end",
              showConfirmButton: false,
              timer: 5000,
            });
          },
          onError: () => {
            this.$swal({
              icon: "error",
              title: "Erreur",
              text: "Impossible d'activer l'année.",
            });
          },
        });

      });
    },

    closeYear(item) {
      const isActive = item.actif == 1;
      const actionText = isActive ? "Désactiver" : "Activer";
      // const successText = isActive ? "Désactivé" : "Activé";
      // const errorText = isActive ? "Désactiver" : "Activer";

      this.$swal({
        title: `${actionText} l'année academique ${item.libelle} ?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Oui!",
        cancelButtonText: "Annuler !",
        position: "center",
      }).then((result) => {
        console.log(result);
        if (!result.isConfirmed) {
          // return router.get(route("annees.index"));
          return this.$inertia.get(route("annees.index"));
        }

        // this.$inertia.post(route("annees.activer", item.id), {
        //   onSuccess: () =>
        //     this.$swal({
        //       icon: "success",
        //       title: actionText,
        //       text: `${item.libelle} ${successText} avec succès!`,
        //       toast: true,
        //       position: "top-end",
        //       showConfirmButton: false,
        //       timer: 5000,
        //       timerProgressBar: true,
        //     }),

        //   onError: () =>
        //     this.$swal({
        //       icon: "error",
        //       title: actionText,
        //       text: `Désolé vous ne pouvez pas ${errorText}!`,
        //       toast: true,
        //       position: "top-end",
        //       showConfirmButton: false,
        //       timer: 5000,
        //       timerProgressBar: true,
        //     }),
        // });

        this.$inertia.put(route("annees.cloturer", item.id), {}, {
          onSuccess: () => {
            this.$swal({
              icon: "success",
              title: `Clôture`,
              text: `${item.libelle} clôturée avec succès !`,
              toast: true,
              position: "top-end",
              showConfirmButton: false,
              timer: 5000,
            });
          },
          onError: () => {
            this.$swal({
              icon: "error",
              title: "Erreur",
              text: "Impossible d'activer l'année.",
            });
          },
        });

      });
    },

    openItem(item) {
      // Exemple : redirection vers le détail
      this.$inertia.get(route('annees.show', item.id));
    },

    archiveYear(item) {
      this.$swal({
        title: "Archiver cette année ?",
        text: `L'année ${item.libelle} sera archivée.`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Oui, archiver",
        cancelButtonText: "Annuler",
      }).then((result) => {
        if (result.isConfirmed) {
          this.$inertia.put(route('annees.archiver', item.id), {}, {
            onSuccess: () => {
              this.$swal({
                icon: "success",
                title: "Archivage",
                text: "Année archivée avec succès",
                toast: true,
                position: "top-end",
                timer: 4000,
                showConfirmButton: false,
              });
            },
          });
        }
      });
    },

    getStatusYears() {
      return {
        "existAnneeEncours": this.annees.some(annee => annee.actif === 1),
        "existAnneeEnAttente": this.annees.some(annee => annee.actif === 0)
      };
    },
    yearAlreadyExists(libelle) {
      return this.annees.some(
        annee => annee.libelle.trim().toLowerCase() === libelle.trim().toLowerCase()
      );
    },

  },

  // mounted() {
  //   console.log('URL:', this.$page.url);
  // }


};
</script>
<template>
  <v-card>
    <Toolbar :icon="icon.mdiCalendar" toolbarTitle="Gestion des années scolaires"></Toolbar>

    <v-dialog v-model="dialog" transition="dialog-top-transition" persistent width="500px">
      <template v-slot:default="{ isActive }">
        <v-card>
          <v-toolbar dense color="primary" dark>
            <v-toolbar-title>
              <v-icon left>{{ form.id ? icon.mdiPencil : icon.mdiPlusCircle }}</v-icon>
              {{ dialog_title }}
            </v-toolbar-title>
            <v-spacer></v-spacer>
          </v-toolbar>
          <v-card-text>
            <v-form ref="form">
              <v-row>
                <v-col cols="12" md="12">
                  <text-field label="Année acdemique" placeholder="Année: 2024-2025" v-model="form.libelle" isRequired
                    :rules="rules"></text-field>
                </v-col>
              </v-row>
            </v-form>
          </v-card-text>
          <v-card-actions class="justify-end">
            <v-spacer></v-spacer>
            <v-btn dark small type="button" color="red" @click="close">
              <v-icon :icon="icon.mdiCancel" left></v-icon> Annuler
            </v-btn>
            <v-btn type="submit" small color="success" @click="submit">
              <v-icon :icon="icon.mdiCheckCircle" left></v-icon> Enregistrer
            </v-btn>
          </v-card-actions>
        </v-card>
      </template>
    </v-dialog>
    <v-card-text>
      <Datatable :displayAddButton="this.$page.url == '/annees/academique?section_id=2' ? false : true" :items="annees" titleDatatable="Liste des années academiques"
        :headers="headers" :permission="'manage_school'" :functionOnClickAddButton="create">
        <!-- <template v-slot:addBtn>
          <btn @click="create"><v-icon>{{ icon.mdiPlus }}</v-icon> Ajouter</btn>
        </template> -->
        <template v-slot:item.actions="{ item }">
          <v-icon v-if="item.actif == 0 && this.$page.url !== '/annees/academique?section_id=2'" size="x-large" color="warning" title="Modifier" class="me-2"
            @click="editItem(item)" :icon="icon.mdiPencil">
          </v-icon>
          <v-icon v-if="item.actif == 0 && this.$page.url !== '/annees/academique?section_id=2'" size="x-large" color="error" title="Supprimer" @click="deleteItem(item)"
            :icon="icon.mdiDelete">
          </v-icon>

          <v-icon size="x-large" class="me-2" title="Activer" :icon="icon.mdiLockOpenVariant" v-if="item.actif == 0 && this.$page.url !== '/annees/academique?section_id=2'"
            color="primary" :model-value="true" label="" @click="activeYear(item)"></v-icon>
          <!-- <v-switch v-else color="primary" :model-value="false" label="" @click="activeItem(item)"></v-switch> -->

          <!-- Ouvrir -->
          <v-icon v-if="item.actif == 1 && this.$page.url !== '/annees/academique?section_id=2'" size="x-large" color="primary" title="Clôturer" class="me-2"
            @click="closeYear(item)" :icon="icon.mdiLock" />

          <!-- Archiver -->
          <v-icon v-if="item.actif == 2 && this.$page.url !== '/annees/academique?section_id=2'" size="x-large" color="orange" title="Archiver" @click="archiveYear(item)"
            :icon="icon.mdiArchiveOutline" />

            <v-icon v-if="(item.actif == 2 || item.actif == 3) && this.$page.url == '/annees/academique?section_id=2'" size="x-large" color="#1976D2" title="Ouvrir" @click="openYear(item)"
            :icon="icon.mdiBookOpenPageVariant" />
        </template>
        <template v-slot:item.Status="{ item }">
          <v-chip variant="flat" size="small" class="text-white" :style="{
            backgroundColor:
              item.actif === 1 ? 'green' :
                item.actif === 0 ? '#004980' :
                  item.actif === 2 ? 'orange' :
                    item.actif === 3 ? 'grey' : ''
          }">
            {{
              item.actif === 0 ? 'En attente' :
                item.actif === 1 ? 'En cours' :
                  item.actif === 2 ? 'Clôturée' :
                    item.actif === 3 ? 'Archivée' : ''
            }}
          </v-chip>
        </template>

      </Datatable>
    </v-card-text>
  </v-card>
</template>
<style></style>
