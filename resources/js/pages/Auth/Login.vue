<template>
  <div>
    <LoginComponent />
  </div>
</template>

<script>
import { router, useForm } from "@inertiajs/vue3";
import FooterIndex from "../../components/welcome/Footer.index.vue";
import LoginComponent from "../../components/auth-page/Login.component.vue";

export default {
  components: {
    LoginComponent,
    FooterIndex,
  },
  computed: {},
  created() {},
  methods: {},
};
</script>
