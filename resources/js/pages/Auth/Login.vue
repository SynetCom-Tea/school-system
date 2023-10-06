<template>
  <div>
    <LoginComponent />
  </div>
</template>

<script>
import { router, useForm } from "@inertiajs/vue3";
import LoginComponent from "../../components/auth-page/Login.component.vue";
import { mdiCloseCircle, mdiInformation } from "@mdi/js";
export default {
  components: {
    LoginComponent,
    mdiCloseCircle,
  },
  data() {
    return {
      snackbar: false,
      y: "top",
      x: null,
      mode: "",
      timeout: 6000,
      icons: { mdiCloseCircle },
      errorMessage: null,
    };
  },
  computed: {},
  mounted() {},
  created() {
    console.log("T:", this.$page.props);
    if (this.$page.props.flash?.message?.type == "error") {
      console.log("herre");
      this.snackbar = true;
      this.errorMessage = this.$page.props.flash.message.text;
      this.$toast.error(this.$page.props.flash.message.text);
    }
  },
  methods: {},
};
</script>
