<template>
  <div style="height: 100%">
      <v-app-bar color="rgb(0, 73, 128)" prominent>
          <div class="app-bar-content">
              <div class="text-white text-h5">Bienvenue sur Système Scolaire!</div>
              <!-- <div class="transition-default">Bienvenue sur Système scolaire!</div> -->
              <div class="d-flex align-center ml-auto" id="profile-bar">
                  <v-list-item @click="goToProfilePage()" lines="two" :title="getUserProfile.name" :subtitle="getUserProfile.typeUser">
                      <template v-slot:prepend>
                          <v-icon size="22" :icon="icons.mdiAccount"></v-icon>
                      </template>
                  </v-list-item>
              </div>
              &nbsp; &nbsp;
              <div class="d-flex">
                  <SiteWebButton />
                  <MenuTopButton />
              </div>
          </div>
      </v-app-bar>
  
      <v-navigation-drawer
        v-model="drawer"
        rail-width="300"
        class="bg-primary"
        permanent
        :rail="rail"
        width="300"
      >
        <div id="sidebar">
          <div class="sidebar-toggle">
            <div @click="changeToggleState()" id="btn-toggle">
              <v-icon id="btn-toggle-icon" :icon="icons.mdiChevronLeft"></v-icon>
            </div>
          </div>
          <div class="sidebar-body">
            <div class="sidebar-profile">
              <img
                :src="'/logos/' + getOrganizationProfile.photo.file"
                :alt="getOrganizationProfile.photo.title"
              />
              <v-slide-x-transition mode="in-out" leave-absolute class="text-wrap">
                <v-list-item
                  id="profile-name"
                  lines="two"
                  :title="getOrganizationProfile.organization.name"
                >
                  <template v-slot:subtitle="{ subtitle }">
                    <span class="text-wrap" style="font-size: 0.9em, color:bold">
                      {{ getOrganizationProfile.organization.type }}
                    </span>
                  </template>
                </v-list-item>
              </v-slide-x-transition>
            </div>
          </div>
          <div class="sidebar-links">
            <small>Menu</small>
            <hr class="divider" />
            <div class="links">
              <v-list density="compact">
                <v-list-item
                  class="list-case"
                  v-for="link in getListMenus[0]"
                  :key="link.title"
                  @click="page(link.link)"
                >
                  <template v-slot:prepend>
                    <v-icon :title="link.title" :icon="link.icon"></v-icon>
                  </template>
                  <v-list-item-title
                    class="text-wrap"
                    v-text="link.title"
                  ></v-list-item-title>
                </v-list-item>
                <!-- <v-list-group :value="getListMenus[1].title"> -->
                <v-list-group
                  v-if="
                    $page.props?.roles[0] && $page.props?.roles[0] != 'Super-administrateur'
                  "
                  :value="getListMenus[4].title"
                >
                  <template v-slot:activator="{ props }">
                    <v-list-item class="group-title" v-bind="props">
                      <template v-slot:prepend>
                        <v-icon
                          :title="getListMenus[4].title"
                          :icon="getListMenus[4].icon"
                        ></v-icon>
                      </template>
                      <v-list-item-title
                        class="text-wrap"
                        v-text="getListMenus[4].title"
                      ></v-list-item-title>
                    </v-list-item>
                  </template>
  
                  <v-list-item
                    class="sub-list-group"
                    v-for="(item, i) in getListMenus[4].children"
                    :key="i"
                    @click="page(item.link)"
                  >
                    <template v-slot:prepend>
                      <v-icon :title="item.title" :icon="item.icon"></v-icon>
                    </template>
  
                    <v-list-item-title
                      class="text-wrap"
                      v-text="item.title"
                    ></v-list-item-title>
                  </v-list-item>
                </v-list-group>
                <v-list-group :value="getListMenus[1]?.title">
                  <template v-slot:activator="{ props }">
                    <v-list-item class="group-title" v-bind="props">
                      <template v-slot:prepend>
                        <v-icon
                          :title="getListMenus[1]?.title"
                          :icon="getListMenus[1]?.icon"
                        ></v-icon>
                      </template>
                      <v-list-item-title
                        class="text-wrap"
                        v-text="getListMenus[1]?.title"
                      ></v-list-item-title>
                    </v-list-item>
                  </template>
  
                  <v-list-item
                    class="sub-list-group"
                    v-for="(item, i) in getListMenus[1]?.children"
                    :key="i"
                    @click="page(item.link)"
                  >
                    <template v-slot:prepend>
                      <v-icon :title="item.title" :icon="item.icon"></v-icon>
                    </template>
  
                    <v-list-item-title
                      class="text-wrap"
                      v-text="item.title"
                    ></v-list-item-title>
                  </v-list-item>
                </v-list-group>
  
                <v-list-group
                  :value="MenuAdmin.title"
                  v-if="$page.props.roles[0] == 'Administrateur'"
                >
                  <template v-slot:activator="{ props }">
                    <v-list-item class="group-title" v-bind="props">
                      <template v-slot:prepend>
                        <v-icon :title="MenuAdmin.title" :icon="MenuAdmin.icon"></v-icon>
                      </template>
                      <v-list-item-title
                        class="text-wrap"
                        v-text="MenuAdmin.title"
                      ></v-list-item-title>
                    </v-list-item>
                  </template>
  
                  <v-list-item
                    class="sub-list-group"
                    v-for="(item, i) in MenuAdmin.children"
                    :key="i"
                    @click="page(item.link)"
                  >
                    <template v-slot:prepend>
                      <v-icon :title="item.title" :icon="item.icon"></v-icon>
                    </template>
  
                    <v-list-item-title
                      class="text-wrap"
                      v-text="item.title"
                    ></v-list-item-title>
                  </v-list-item>
                </v-list-group>
  
                <v-list-group
                  :value="getListMenus[2].title"
                  v-if="$page.props.roles == 'Note'"
                >
                  <template v-slot:activator="{ props }">
                    <v-list-item class="group-title" v-bind="props">
                      <template v-slot:prepend>
                        <v-icon
                          :title="getListMenus[2].title"
                          :icon="getListMenus[2].icon"
                        ></v-icon>
                      </template>
                      <v-list-item-title
                        class="text-wrap"
                        v-text="getListMenus[2].title"
                      ></v-list-item-title>
                    </v-list-item>
                  </template>
  
                  <v-list-item
                    class="sub-list-group"
                    v-for="(item, i) in getListMenus[2].children"
                    :key="i"
                    @click="page(item.link)"
                  >
                    <template v-slot:prepend>
                      <v-icon :title="item.title" :icon="item.icon"></v-icon>
                    </template>
  
                    <v-list-item-title
                      class="text-wrap"
                      v-text="item.title"
                    ></v-list-item-title>
                  </v-list-item>
                </v-list-group>
  
                <!-- Déconnexion doit etre le dernier menu -->
                <v-list-item class="list-case" @click="logout" key="logout">
                  <template v-slot:prepend>
                    <v-icon title="logout" :icon="icons.mdiLogout"></v-icon>
                  </template>
                  <v-list-item-title class="text-wrap">Déconnexion</v-list-item-title>
                </v-list-item>
              </v-list>
            </div>
          </div>
        </div>
      </v-navigation-drawer>
  </div>
  </template>
  
  <script>
  import {
      router
  } from "@inertiajs/vue3";
  import {
      mdiChevronLeft,
      mdiAccount,
      mdiSchool,
      mdiCogOutline,
      mdiLogout,
      mdiMenu,
  } from "@mdi/js";
  import {
      listMenus
  } from "../../utils/ListNavAppBar.js";
  import {
      Vue3Marquee
  } from "vue3-marquee";
  import {
      getTypeEtablissementById
  } from "../../utils/commonFunctions.js";
  import SiteWebButton from "./SiteWebButton.vue";
  import MenuTopButton from "./MenuTopButton.vue";
  export default {
      name: "Sidebar",
      components: {
          mdiAccount,
          mdiChevronLeft,
          mdiCogOutline,
          mdiLogout,
          mdiMenu,
          mdiSchool,
          MenuTopButton,
          SiteWebButton,
      },
  
    data: () => {
      return {
        MenuAdmin: [],
        open: ["getListMenus[1]"],
        drawer: true,
        menuCompact: {
          hidden: true,
        },
        icons: {
          mdiChevronLeft,
          mdiCogOutline,
          mdiLogout,
          mdiMenu,
          mdiAccount,
        },
        username: "",
  
              rail: true,
          };
      },
      created() {
          console.log("ici", this.$page.props.roles[0]);
          this.getListMenus;
          this.getUserProfile;
          this.getOrganizationProfile;
          listMenus(this.$page.props);
      },
      mounted() {
          console.log("ici", this.$page.props.roles.name);
          axios.interceptors.response.use(
              function (response) {
                  // console.log("response:", response);
                  return response;
              },
              function (error) {
                  // console.log("error:", error);
                  if (error.response ?.status === 403) {
                      alert(
                          "Session expirée. Vous serez redirigé(e) vers la page d'authentification!!"
                      );
                      window.location.href = "/login";
                  }
                  return Promise.reject(error);
              }
          );
          this.$gates.setRoles(this.$page.props.roles);
          this.$gates.setPermissions(this.$page.props.permissions);
          // console.log("console sections", this.$page.props.sections);
      },
      computed: {
          getOrganizationProfile() {
              let fullName;
              let organization;
              let user = this.$page.props.auth ? this.$page.props.auth.user : null;
              let sections, allSections;
              if (this.$page.props && this.$page.props.admin_etablissement) {
                  organization = this.$page.props.admin_etablissement.etablissement;
                  if (this.$page.props ?.sections[0] && this.$page.props ?.sections[0].sections) {
                      sections = this.$page.props.sections[0].sections;
                  }
              }
  
              if (sections && sections.length == 4) {
                  allSections = "Toutes les Sections";
              }
  
              if (this.$page.props.admin_etablissement == null) {
                  organization = {
                      name: "Concepteur logiciel",
                      type: "Super-Admin",
                  };
              }
              let roles = this.$page.props ?.roles ? this.$page.props ?.roles[0] : null;
              let organizationName = allSections ?
                  allSections :
                  getTypeEtablissementById(organization.type_etablissement_id);
  
              fullName = user ?.nom + " " + user ?.prenom;
              let item = {
                  typeUser: roles,
                  organization: {
                      name: organization.name,
                      type: organizationName ?? organization.type,
                  },
                  photo: {
                      file: organization.logo ?? "team.png",
                      title: "photo de l'établissement",
                  },
              };
  
        return item;
      },
      getUserProfile() {
        let fullName, firstname, lastname;
        let organization;
        let user = this.$page.props.auth ? this.$page.props.auth.user : null;
        let roles = this.$page.props.roles ? this.$page.props.roles[0] : null;
        let vRoles = this.$page.props.roles.length > 1 ? "Profil" : roles;
        firstname = user.nom ?? "Nom";
        lastname = user.prenom ?? "Preom";
        fullName = firstname + " " + lastname;
        let item = {
          name: fullName,
          typeUser: vRoles,
          photo: {
            file: "team.png",
            title: "photo de l'établissement",
          },
        };
        return item;
      },
      getListMenus() {
        let list = listMenus(this.$page.props);
        let role = this.$page.props.roles ? this.$page.props.roles[0] : null;
        this.MenuAdmin = list[5];
        return list;
      },
    },
    methods: {
      listMenus,
      getTypeEtablissementById,
      goToProfilePage() {
        router.get("/profile");
      },
      logout() {
        router.post("/logout");
        // window.location.reload(true);
      },
      onClickMenuItem(item) {
        router.get(item);
      },
      onClickMenuButton() {
        this.drawer = !this.drawer;
      },
      page(link) {
        router.get(link);
      },
      changeToggleState() {
        let btnToggleIcon = document.getElementById("btn-toggle-icon");
        this.menuCompact.hidden = !this.menuCompact.hidden;
  
              if (this.menuCompact.hidden) {
                  return (btnToggleIcon.style.transform = "rotateY(0deg)");
              } else {
                  return (btnToggleIcon.style.transform = "rotateY(180deg)");
              }
              this.rail = !this.rail;
          },
      },
      mounted(){
          console.log(this.$page.props.roles)
      }
  };
  // <v-list density="compact" v-model:opened="open">
  </script>
  
  <style scoped src="../../../css/side-bar-style.css"></style>