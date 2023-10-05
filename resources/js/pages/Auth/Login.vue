<template>
  <div>
    <LoginComponent />
  </div>
</template>

<script>
import { router, useForm } from "@inertiajs/vue3";
import LoginComponent from "../../components/auth-page/Login.component.vue";

export default {
  components: {
    LoginComponent,
  },
  computed: {},
  created() {},
  methods: {},
};
</script>
