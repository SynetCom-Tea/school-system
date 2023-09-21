<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { mdiAccountSchool, mdiPlus, mdiPencil, mdiDelete, mdiPlusCircle } from "@mdi/js";
export default {
  components: {
    mdiAccountSchool,
    mdiPlus,
    mdiPencil,
    mdiDelete,
    mdiPlusCircle,
  },
  layout: AuthenticatedLayout,
  props: ["fillieres", "cycles"],
  data() {
    return {
      icon: {
        mdiAccountSchool,
        mdiPlus,
        mdiPencil,
        mdiDelete,
        mdiPlusCircle,
      },
      headers: [
        {
          title: "ID",
          align: "start",
          sortable: false,
          key: "id",
        },
        {
          title: "Code",
          align: "center",
          key: "code",
        },
        {
          title: "Nom",
          align: "center",
          key: "name",
        },
        {
          title: "Cycle",
          align: "center",
          key: "cycle.name",
        },
        {
          title: "Actions",
          align: "center",
          key: "actions",
        },
      ],
      dialog_title: "Nouvelle Filière",
      dialog: false,
      dialogEdit: false,
      editdata: {},
      form: useForm({
        name: "",
        code: "",
        cycle_id: null,
      }),
    };
  },
  methods: {
    create() {
      this.dialog = true;
    },
    editItem(item) {
      this.form.code = item.code;
      this.form.name = item.name;
      this.form.cycle_id = item.cycle_id;
      this.editdata = item;
      this.dialogEdit = true;
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
          this.$swal("Supprimé!", "Votre element a été supprimé.", "success");
        }
      });
    },
    submit() {
      this.form.post(route("fillieres.store"), {
        onFinish: () => {
          this.form = {};
          this.dialog = false;
          this.$swal({
            icon: "success",
            title: "Enregistrement",
            text: "Filière créé avec succès!",
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
          });
        },
      });
    },
    submitEdit() {
      this.form.put(route("fillieres.update", this.editdata.id), {
        onFinish: () => {
          this.form = {};
          this.dialog = false;
          this.$swal({
            icon: "success",
            title: "Modification",
            text: "Filière modifier avec succès!",
            toast: true,
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            //netstat -ano | findstr :8000
            //chkdsk/f
          });
        },
      });
    },
    close() {
      this.dialog = false;
      this.dialog_title = "Nouvelle Filière";
      this.form = {};
    },
    closeEdit() {
      this.dialogEdit = false;
    },
  },
};
</script>
<template>
  <v-card>
    <Toolbar :icon="icon.mdiAccountSchool" toolbarTitle="Gestion des filières"></Toolbar>
    <v-card-text>
      <v-dialog
        v-model="dialogEdit"
        transition="dialog-top-transition"
        persistent
        width="500px"
      >
        <template v-slot:default="{ isActive }">
          <v-card>
            <v-toolbar dense color="orange" dark>
              <v-toolbar-title>
                <v-icon left :icon="icon.mdiPencil"></v-icon> Modifier la filière
                {{ editdata.code }}
              </v-toolbar-title>
              <v-spacer></v-spacer>
            </v-toolbar>
            <v-card-text>
              <v-form>
                <v-row>
                  <v-col cols="12" md="12">
                    <text-field
                      label="Code"
                      placeholder="Code"
                      v-model="form.code"
                    ></text-field>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col cols="12" md="12">
                    <text-field
                      name="name"
                      label="Libelle"
                      placeholder="Libelle"
                      v-model="form.name"
                    ></text-field>
                  </v-col>
                </v-row>
                <v-row>
                  <select-field
                    label="Cycles"
                    item-title="name"
                    item-value="id"
                    :items="cycles"
                    v-model="form.cycle_id"
                  >
                  </select-field>
                </v-row>
              </v-form>
            </v-card-text>
            <v-card-actions class="justify-end">
              <v-spacer></v-spacer>
              <v-btn dark small type="button" color="red" @click="closeEdit">
                <v-icon :icon="icon.mdiCancel" left></v-icon> Annuler
              </v-btn>
              <v-btn small color="success" @click="submitEdit">
                <v-icon :icon="icon.mdiCheckCircle" left></v-icon> Enregistrer
              </v-btn>
            </v-card-actions>
          </v-card>
        </template>
      </v-dialog>
      <v-btn @click="create" x-small variant="outlined" color="green" v-bind="props">
        Ajouter
      </v-btn>
      <v-data-table :headers="headers" :items="fillieres">
        <template v-slot:addBtn>
          <v-dialog
            v-model="dialog"
            transition="dialog-top-transition"
            persistent
            width="500px"
          >
            <template v-slot:default="{ isActive }">
              <v-card>
                <v-toolbar dense color="orange" dark>
                  <v-toolbar-title>
                    <v-icon left>{{
                      form.id ? icon.mdiPencil : icon.mdiPlusCircle
                    }}</v-icon>
                    {{ dialog_title }}
                    <!-- <v-icon left :icon="icon.mdiPlus"></v-icon> Nouvelle Filière -->
                  </v-toolbar-title>
                  <v-spacer></v-spacer>
                </v-toolbar>
                <v-card-text>
                  <v-form>
                    <v-row>
                      <v-col cols="12" md="12">
                        <text-field
                          label="Code"
                          placeholder="Code"
                          v-model="form.code"
                        ></text-field>
                      </v-col>
                    </v-row>
                    <v-row>
                      <v-col cols="12" md="12">
                        <text-field
                          name="name"
                          label="Libelle"
                          placeholder="Libelle"
                          v-model="form.name"
                        ></text-field>
                      </v-col>
                    </v-row>
                    <v-row>
                      <select-field
                        label="Cycles"
                        item-title="name"
                        item-value="id"
                        :items="cycles"
                        v-model="form.cycle_id"
                      >
                      </select-field>
                    </v-row>
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
            </template>
          </v-dialog>
        </template>
        <template v-slot:item.actions="{ item }">
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
      </v-data-table>
    </v-card-text>
  </v-card>
</template>
