<script>
import { mdiCancel, mdiContentSaveEditOutline } from "@mdi/js";
import { provide } from "vue";
export default {
  components: { mdiCancel, mdiContentSaveEditOutline },
  props: {
    onClickSaveButton: { type: Function },
    onClickCancelButton: { type: Function },
    isEditing: { type: Boolean, default: false },
  },

  data: () => ({
    icons: {
      mdiCancel,
      mdiContentSaveEditOutline,
    },
    detailUpdateTitle: "",
  }),

  updated() {},
  watch: {},
  computed: {},

  methods: {},
};
</script>
<template>
  <div>
    <Button
      variant="text"
      class="mb-2"
      color="red"
      nameButton="Annuler"
      title="Annuler et Fermer la modale"
      style="height: 30px"
      :prependIcon="icons.mdiCancel"
      @click="onClickCancelButton"
    ></Button>

    <Button
      variant="text"
      class="mb-2"
      nameButton="Enregistrer"
      title="Valider et Fermer la modale"
      style="height: 30px"
      :disabled="!isEditing"
      :prependIcon="icons.mdiContentSaveEditOutline"
      @click="onClickSaveButton"
    ></Button>
  </div>
</template>
<style scoped></style>
