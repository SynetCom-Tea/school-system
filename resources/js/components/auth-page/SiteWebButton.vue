<template>
  <div style="margin-right: 10px">
    <Button
      class="text-secondary"
      style="color: rgb(125, 0, 44); background-color: white; width: 90px; height: 40px"
      variant="flat"
      color="white"
      title="Visiter le site Web"
      nameButton=" Site web"
      rounded
      @click="redirectToWebsite"
    ></Button>
  </div>
</template>

<script>
import { router } from "@inertiajs/vue3";

export default {
  components: {},
  data: () => {
    return {};
  },
  mounted() {},
  methods: {
    redirectToWebsite() {
      router.get("/");
    },
  },
};
</script>
