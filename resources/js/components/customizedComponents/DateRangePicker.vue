<template>
    <VueDatePicker
    />
</template>

<script>
export default {
  props: {
    maxHeightResponsive: {
      type: Number,
      required: false,
      // default: 100,
    },
    heightResponsive: {
      type: Number,
      required: false,
    },
    classResponsive: {
      type: String,

      default: "py-1",
    },
    maxWidthResponsive: {
      type: Number,
      required: false,
      // default: 250,
    },
  },
  data() {
    return {
      range: true,
      format: 'yyyy-MM-dd',
    };
  },
};
</script>
<style scoped>
.custom-datepicker .dp__input,
.custom-datepicker .dp__input:focus {
  /* Ajustez la hauteur et la largeur du champ selon vos besoins */
  height: 50px !important;
  width: 300px !important; /* Vous pouvez ajuster cette valeur selon vos besoins */
  font-size: 16px !important;
  padding: 10px !important;
  border: 1px solid #1976d2 !important;
}
</style>