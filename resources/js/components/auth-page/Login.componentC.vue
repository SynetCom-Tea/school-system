<template>
  <v-container
    id="container-login"
    :class="isSignInPanelActive ? 'container right-panel-active' : 'container-login'"
  >
    <SignUpForm v-if="currentSignUpStep == 1" />
    <SignUpContinuationForm v-if="currentSignUpStep == 2" />
    <SignInForm />
    <div class="overlay-container">
      <div class="overlay">
        <OverlaySignUp />
        <OverlaySignIn />
      </div>
    </div>
    <!-- <div class="footer-style">
      <footer
        :class="{
          'footer-sm': '500',
          'footer-md': '700',
        }"
      >
        <span class="text-reset text-white"
          >© {{ new Date().getFullYear() }}&nbsp; Copyright:
          <a href="https://mdbootstrap.com/">synetcom.com</a></span
        >
      </footer>
    </div> -->
  </v-container>
</template>

<script>
import SignInForm from "./sign-in-form.vue";
//"../components/auth-page/sign-in-form.vue";
import SignUpForm from "./sign-up-form.vue";
import SignUpContinuationForm from "./sign-up-continuation-form.vue";
import OverlaySignUp from "./overlay-sign-up.vue";
import OverlaySignIn from "./overlay-sign-in.vue";
export default {
  components: {
    SignInForm,
    SignUpForm,
    OverlaySignUp,
    OverlaySignIn,
    SignUpContinuationForm,
  },
  computed: {
    isSignInPanelActive: {
      get: function () {
        return this.$store.getters["authPageModule/getIsSignInPanelActive"];
      },
      set: function (newVal) {
        this.$store.commit("authPageModule/setIsSignInPanelActive", newVal);
      },
    },
    currentSignUpStep: {
      get: function () {
        return this.$store.getters["authPageModule/getCurrentSignUpStep"];
      },
      set: function (newVal) {
        this.$store.commit("authPageModule/setCurrentSignUpStep", newVal);
      },
    },
  },
};
</script>

<style>
/* @import url("https://fonts.googleapis.com/css?family=Montserrat:400,800"); */

form {
  background-color: #ffffff;
  height: 100%;
}

.container-login {
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
  position: relative;
  overflow: hidden;
  max-width: 100%;
  min-height: 480px;
  height: 70vh;
}

.form-container {
  position: absolute;
  top: 0;
  height: 100%;
  transition: all 0.6s ease-in-out;
}

.overlay-container {
  position: absolute;
  top: 0;
  left: 50%;
  width: 50%;
  height: 100%;
  overflow: hidden;
  transition: transform 0.6s ease-in-out;
  z-index: 100;
}

.container.right-panel-active .overlay-container {
  transform: translateX(-100%);
}

.overlay {
  background: #ff416c;
  background: -webkit-linear-gradient(to right, #e260c6, #004980);
  background: linear-gradient(to right, #284563, #004980);
  background-repeat: no-repeat;
  background-size: cover;
  background-position: 0 0;
  color: #ffffff;
  position: relative;
  left: -100%;
  height: 100%;
  width: 200%;
  transform: translateX(0);
  transition: transform 0.6s ease-in-out;
}

.container.right-panel-active .overlay {
  transform: translateX(50%);
}

.overlay-panel {
  position: absolute;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  text-align: center;
  top: 0;
  height: 100%;
  width: 50%;
  transform: translateX(0);
  transition: transform 0.6s ease-in-out;
}
.container.right-panel-active .overlay-left {
  transform: translateX(0);
}

.container.right-panel-active .overlay-right {
  transform: translateX(20%);
}
/* font sizes */
.sm-title {
  font-size: 18px;
}
.md-title {
  font-size: 44px;
}
.sm-description {
  font-size: 12px;
}
.md-description {
  font-size: 16px;
}
footer-style {
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
