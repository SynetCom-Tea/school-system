<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router, useForm } from "@inertiajs/vue3";
import { inject, ref, provide, onMounted, watch } from "vue";
import { generateColorsForGraph } from "../../utils/commonFunctions.js";
import { mdiPresentation, mdiCheck, mdiPencil, mdiClose } from "@mdi/js";
import { toRefs } from "@vue/reactivity";
export default {
  props: {
    item: Object,
    // dialogFrais: Boolean,
  },
  setup(props) {
    let { item } = toRefs(props);
    const dataVersements = ref([]);
    const icons = {
      mdiPresentation,
      mdiCheck,
      mdiPencil,
      mdiClose,
    };

    let myDialog = false;

    let vmodelDialog = inject("vmodeldialogFrais");

    async function onclickFrais() {
      myDialog = vmodelDialog;
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
      let frais, student, restant;
      if (axiosResult && axiosResult.length > 0) {
        axiosResult.forEach((element, index) => {
          if (element) {
            student = element.apprenant;
            frais = element.frais;
            restant =
              (element.frais.montant ? parseFloat(element.frais.montant) : 0) -
              (element.montant ? parseFloat(element.montant) : 0);

            dataR.push({
              restant: restant ? restant.toLocaleString() : null,
              nomApprenant: student ? student.nom + " " + student.prenom : null,
              date_versement: element.date_versement,
              type_frais: frais.type_frais.libelle,
              color: generateColorsForGraph(index + 1),
              frais: frais,
              apprenant: student,
              montant_total_a_verser: frais.montant
                ? parseFloat(frais.montant).toLocaleString() + " Fcfa"
                : null,
              versement_fait: element.montant
                ? parseFloat(element.montant).toLocaleString() + " Fcfa"
                : null,
            });
          }
        });

        dataVersements.value = dataR ?? [];

        return dataR ?? [];
      }
    }
    function oncloseDialog() {
      // const vmodelDialoDU = inject("vmodeldialogFrais");

      myDialog = false;
      vmodelDialog.value = false;
    }
    return {
      item,
      myDialog,
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
        return this.myDialog;
      },
      set(newValue) {
        this.$emit("value", newValue);
      },
    },
    // observeT() {
    //   return this.dataVersements;
    // },
  },

  methods: {
    onClose() {
      this.vmodelDialog = false;
    },
  },
};
</script>

<template>
  <div>
    <Dialog
      :modelDialog="vmodelDialog"
      :toolbarTitle="'Détail Frais de ' + dataVersements[0]?.nomApprenant"
      :iconHeaderModal="icons.mdiPresentation"
      :onCloseModale="oncloseDialog"
      :widthDialog="700"
      :heightDialog="600"
    >
      <template v-slot:toolbars-items>
        <v-icon
          title="Fermer la modale"
          fab
          :icon="icons.mdiClose"
          @click="onClose()"
          style="margin: 15px"
        ></v-icon
      ></template>
      <template v-slot:content>
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
                  <strong>Date de versement</strong>: &nbsp;
                  {{
                    key?.date_versement
                      ? new Date(key?.date_versement).toLocaleDateString()
                      : null
                  }}
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
      </template>
    </Dialog>
  </div>
</template>
