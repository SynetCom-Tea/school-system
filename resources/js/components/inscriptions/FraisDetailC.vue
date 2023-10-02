<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router, useForm } from "@inertiajs/vue3";
import { inject, ref, provide, onMounted, watch } from "vue";
import { generateColorsForGraph } from "../../utils/commonFunctions.js";
import { mdiPresentation, mdiClose, mdiCheck, mdiPencil } from "@mdi/js";
import { toRefs } from "@vue/reactivity";
export default {
  props: {
    item: Object,
    dialogFrais: Boolean,
  },
  setup(props) {
    let { item, dialogFrais } = toRefs(props);
    const dataVersements = ref([]);
    const icons = {
      mdiPresentation,
      mdiCheck,
      mdiClose,
      mdiPencil,
    };
    console.log("setup:", item, dialogFrais);
    // const vmodelDialog = ref(false);
    const vmodelDialog = inject("vmodeldialogFrais");
    console.log("vmodelDialog:", vmodelDialog);
    async function onclickFrais() {
      // console.log("onclickFrais in component:", this.item);

      let axiosResult = [];
      let idClasseAnnee, idApprenant;
      if (this.item && this.item.more) {
        idClasseAnnee = this.item.more.classeAnnee.id;
        idApprenant = this.item.more.apprenant.id;
      }

      axiosResult = await axios
        .get(
          route("getVersementsByClasseAnneeAndStudent", {
            classeAnnee: idClasseAnnee,
            apprenant: idApprenant,
          })
        )
        .then((res) => {
          if (typeof res.data == "string" || typeof res.data == "undefined") {
            this.$toast.error("Données non valides!");
          } else {
            return res.data;
          }
        });

      let dataR = [];
      let frais, student;
      if (axiosResult && axiosResult.length > 0) {
        axiosResult.forEach((element, index) => {
          if (element) {
            student = element.apprenant;
            frais = element.frais;

            dataR.push({
              nomApprenant: student ? student.nom + " " + student.prenom : null,
              date_versement: element.date_versement,
              type_frais: frais.type_frais.libelle,
              color: generateColorsForGraph(index + 1),
              frais: frais,
              apprenant: student,
              montant_total_a_verser: frais.montant
                ? parseFloat(frais.montant).toLocaleString()
                : null,
              versement_fait: element.montant
                ? parseFloat(element.montant).toLocaleString()
                : null,
            });
          }
        });

        dataVersements.value = dataR ?? [];
        console.log("Versements:", dataVersements);
        return dataR ?? [];
      }
    }
    function oncloseDialog() {
      // const vmodelDialoDU = inject("vmodeldialogFrais");

      vmodelDialog = false;
      console.log("vmodelDialoDU from function:", vmodelDialog);
    }
    return {
      item,
      dialogFrais,
      icons,
      dataVersements,
      icons,
      onclickFrais,
      oncloseDialog,
      vmodelDialog,
    };
  },
  async mounted() {
    await this.onclickFrais();
  },
  computed: {
    modelValue: {
      get() {
        return this.vmodelDialog;
      },
      set(newValue) {
        console.log("newValue55:", newValue);
        this.$emit("value", newValue);
      },
    },
    // observeT() {
    //   return this.dataVersements;
    // },
  },

  methods: {},
};
</script>

<template>
  <div>
    <v-card v-if="vmodelDialog" :width="600">
      <v-dialog
        v-model="modelValue"
        persistent
        scrollable
        :scrim="false"
        width="600"
        height="500"
      >
        <v-card>
          <v-toolbar dark color="secondary">
            <v-icon
              title="Icon de la modale"
              style="margin: 10px"
              :icon="icons.mdiPresentation"
              size="x-large"
            ></v-icon>

            <v-toolbar-title
              style="
                font-size: 1em;
                width: 100px;
                word-wrap: break-word;
                white-space: pre-wrap;
                word-break: break-word;
              "
            >
              Détail Frais de {{ dataVersements[0]?.nomApprenant }}
            </v-toolbar-title>

            <v-toolbar-items>
              <v-icon
                title="Fermer la modale"
                fab
                :icon="icons.mdiClose"
                @click="oncloseDialog"
                style="margin: 15px"
              ></v-icon>
            </v-toolbar-items>
          </v-toolbar>
          <!-- content -->
          <v-card-text v-for="(key, index) in dataVersements" :key="index">
            <div class="font-weight bg-primary text-white ms-1 mb-2">
              Versement {{ index }}
            </div>

            <v-timeline density="compact" align="start">
              <v-timeline-item :dot-color="key.color" size="x-small">
                <div class="mb-3">
                  <div class="font-weight-normal">
                    <strong>Type de frais</strong>: &nbsp; {{ key?.type_frais }}
                  </div>
                  <div class="font-weight-normal">
                    <strong>Date de versement</strong>: &nbsp; {{ key?.date_versement }}
                  </div>

                  <div class="font-weight-normal">
                    <strong>Montant total à verser</strong>: &nbsp;{{
                      key?.montant_total_a_verser
                    }}
                  </div>
                  <div class="font-weight-normal">
                    <strong>Montant versé</strong>: &nbsp;{{ key?.versement_fait }}
                  </div>
                </div>
              </v-timeline-item>
            </v-timeline>
          </v-card-text>
          <v-divider></v-divider>
          <v-card-actions>
            <v-spacer></v-spacer>
            <div
              class="mt-4"
              style="
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                background-size: cover;
              "
            >
              <Button
                title="Fermer la modale"
                variant="text"
                color="red"
                nameButton="Quitter"
                @click="modelValue = false"
                style="float: right; margin: 10px; height: 30px"
              ></Button>
            </div>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-card>
  </div>
</template>
