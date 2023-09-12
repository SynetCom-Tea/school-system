<template>
<div>
    <LoginComponent />
</div>
</template>

<script>
import {
    router,
    useForm
} from "@inertiajs/vue3";
import FooterIndex from "../../components/welcome/Footer.index.vue";
import LoginComponent from "../../components/auth-page/Login.component.vue";

export default {
    components: {
        LoginComponent,
        FooterIndex,
    },
    computed: {},
    created() {
        //console.log(this.$page.props)
    },
    methods: {
        //   goToLoginPage() {
        //     //   return router.visit("/login", {
        //     //     preserveScroll: true,
        //     //   });
        //     this.$router.push("/login");
        //     // return router.get(route("login"));
        //   },
        //   goToWelcomePage() {
        //     return router.get("/");
        //     // this.$router.back();
        //   },
    },
};
</script>

<style>
@import url("https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700;800;900&display=swap");

#app-login {
    font-family: Raleway, Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
    background: url("https://images.unsplash.com/photo-1531297484001-80022131f5a1?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1414&q=80") no-repeat center center fixed;
    background-repeat: no-repeat;
    background-size: cover;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
}

.sm-main-style {
    margin: auto;
    width: 95%;
}

.md-main-style {
    margin: auto;
    width: 70%;
}

.footer-style {
    height: 50px;
    margin-top: 10px;
    background-color: #7d002c;
}

.footer-md {
    padding: 30px 0px;
}

.footer-md a {
    text-decoration: none;
    color: white !important;
    font-size: 1.1rem;
    font-family: cursive;
    font-weight: 600;
}

.footer-sm {
    padding: 20px 0px;
}

.footer-sm a {
    text-decoration: none;
    color: white !important;
    font-size: 0.8rem;
    font-family: cursive;
    font-weight: 600;
}
</style>
