<template>
  <div style="float: right">
    <Button
      style="width: 90px; height: 40px"
      :variant="default"
      :prependIcon="icons.mdiMenu"
      ripple
      title="Voir la liste de Menu"
      nameButton="Menu"
      :onClickButton="onClickMenuButton"
    ></Button>
  </div>
</template>

<script>
import { router } from "@inertiajs/vue3";
import Button from "../customizedComponents/Button.vue";
import { mdiMenu } from "@mdi/js";
export default {
  name: "Sidebar",
  components: {
    Button,
    mdiMenu,
  },
  props: { onClickMenuButton: { type: Function } },
  data: () => {
    return { icons: { mdiMenu } };
  },
  mounted() {},
  methods: {
    //  onClickMenuButton() {
    // this.drawer = !this.drawer;
    // },
  },
};
</script>
