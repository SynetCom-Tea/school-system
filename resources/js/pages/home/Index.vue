<template>
  <div>
    <v-card><v-card-text>Content</v-card-text></v-card>
  </div>
</template>

<script>
import { Head, Link, router } from "@inertiajs/vue3";
import { Icon } from "@iconify/vue";

import { mdiDotsVertical, mdiPencil, mdiSkipBackward, mdiArrowLeftCircle } from "@mdi/js";

export default {
  components: {
    Icon,

    mdiArrowLeftCircle,
    mdiSkipBackward,
    mdiDotsVertical,
    mdiPencil,
  },
  data() {
    return {
      slide: 0,
      sliding: null,
      icons: {
        mdiArrowLeftCircle,
        mdiSkipBackward,
        mdiDotsVertical,
        mdiPencil,
      },
    };
  },
  computed: {},
  methods: {},
};
</script>
<style scoped></style>
