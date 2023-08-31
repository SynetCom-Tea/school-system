<template>
  <div style="height: 100%">
    <v-app-bar color="rgb(0, 73, 128)" prominent>
      <div class="app-bar-content">
        <div class="text-white text-h5">Bienvenue sur Système scolaire!</div>
        <!-- <div class="transition-default">Bienvenue sur Système scolaire!</div> -->
        <div class="d-flex">
          <SiteWebButton />
          <MenuTopButton :onClickMenuButton="onClickMenuButton" />
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
              :src="'../assets/' + getProfile.photo.file"
              :alt="getProfile.photo.title"
            />
            <v-slide-x-transition mode="in-out" leave-absolute>
              <v-list-item
                id="profile-name"
                lines="two"
                :title="getProfile.name"
                :subtitle="getProfile.typeUser"
              >
              </v-list-item>
            </v-slide-x-transition>
          </div>
          <div class="sidebar-links">
            <small>Menu</small>
            <hr class="divider" />
            <div class="links">
              <v-list density="compact" v-model:opened="open">
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
                <v-list-group :value="getListMenus[4].title">
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
                <v-list-group :value="getListMenus[1].title">
                  <template v-slot:activator="{ props }">
                    <v-list-item class="group-title" v-bind="props">
                      <template v-slot:prepend>
                        <v-icon
                          :title="getListMenus[1].title"
                          :icon="getListMenus[1].icon"
                        ></v-icon>
                      </template>
                      <v-list-item-title
                        class="text-wrap"
                        v-text="getListMenus[1].title"
                      ></v-list-item-title>
                    </v-list-item>
                  </template>

                  <v-list-item
                    class="sub-list-group"
                    v-for="(item, i) in getListMenus[1].children"
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
                </v-list-group> -->
                <v-list-group :value="getListMenus[2].title">
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
      </div>
    </v-navigation-drawer>
  </div>
</template>

<script>
import { router } from "@inertiajs/vue3";
import { mdiChevronLeft, mdiLogout, mdiMenu } from "@mdi/js";
import { listMenus } from "../../utils/ListNavAppBar.js";
import { Vue3Marquee } from "vue3-marquee";
import Button from "../customizedComponents/Button.vue";
import SiteWebButton from "./SiteWebButton.vue";
import MenuTopButton from "./MenuTopButton.vue";
export default {
  name: "Sidebar",
  components: {
    mdiChevronLeft,
    mdiLogout,
    mdiMenu,
    MenuTopButton,
    SiteWebButton,
  },

  data: () => {
    return {
      listGreetings: [
        { id: 1, text: "Wa fonda kayan!" },
        { id: 2, text: "Barka da zouwa!" },
        { id: 3, text: "Bienvenue!" },
        { id: 1, text: "Welcome!" },
        { id: 1, text: "Marhaba!" },
      ],
      open: ["getListMenus[1]"],
      drawer: true,
      menuCompact: {
        hidden: true,
      },
      icons: {
        mdiChevronLeft,
        mdiLogout,
        mdiMenu,
      },
      username: "",
      profileInfo: {
        name: "Super Admin",
        photo: {
          file: "team.png",
          title: "photo profile user",
        },
      },
      rail: true,
    };
  },
  mounted() {
    this.$gates.setRoles(this.$page.props.roles);
    this.$gates.setPermissions(this.$page.props.permissions);
    this.username =
      this.$page.props.auth?.user?.nom + " " + this.$page.props.auth?.user?.prenom;
  },
  computed: {
    getProfile() {
      let fullName =
        this.$page.props.auth?.user?.nom + " " + this.$page.props.auth?.user?.prenom;
      let item = {
        name: fullName,
        typeUser: "Super-Admin",
        photo: {
          file: "team.png",
          title: "photo profile user",
        },
      };
      return item;
    },
    getListMenus() {
      return listMenus();
    },
  },
  methods: {
    listMenus,
    logout() {
      router.post("/logout");
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
};
</script>
<style scoped>
.defile {
  cursor: pointer;

  border-radius: 3px;
}
#sidebar {
  margin: 0;
  top: 0;
  left: 0;
  /* background-color: rgb(0, 73, 128); */
  /* height: 100%; */
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  /* box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.6); */
  user-select: none;
}

.sidebar-body {
  flex-grow: 1;
}

.sidebar-profile {
  position: relative;
  display: flex;
  flex-direction: row;
  justify-content: left;
  align-items: center;
  margin-block: 15px;
  margin-inline: 10px;
  padding: 4px;
  background-image: linear-gradient(to right, rgb(125, 0, 44, 0.7), rgb(125, 0, 44, 0.4));
  border-radius: 50px;
  border: 2px solid rgb(125, 0, 44, 0.75);
  transition: 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  margin-bottom: 20px;
}

.sidebar-profile:hover {
  background-color: rgba(0, 255, 255, 0.85);
  box-shadow: 0px 0px 8px rgba(0, 255, 255, 0.85);
  transform: scale(1.05);
  cursor: pointer;
}

.sidebar-profile #profile-name {
  font-weight: 100;
  flex-grow: 1;
  font-size: 10px;
  text-align: center;
  color: white;
}

.sidebar-profile img {
  max-width: 60px;
  border-radius: 100%;
  border: 4px inset rgb(125, 0, 44, 0.25);
}

.sidebar-links {
  padding-inline: 15px;
}

.sidebar-links small {
  /* color: rgba(255, 255, 255, 0.4); */
  text-transform: uppercase;
  letter-spacing: 2px;
  font-size: 12px;
}

.divider {
  opacity: 0.25;
  border-radius: 100%;
  margin-bottom: 25px;
}
.sidebar-links .links .v-list {
  display: flex;
  flex-direction: column;
}
.sidebar-links .v-list .list-case {
  cursor: pointer;
  text-decoration: none;
  /* background-color: rgba(255, 255, 255, 0.75); */
  border-radius: 25px;
  padding-inline: 4px;
  padding-block: 8px;
  margin-block: 3px;
  border-width: thick;
  font-weight: 100;
  border: 1px solid rgba(255, 255, 255, 0.85);
  transition: 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
.sidebar-links .v-list .list-case:hover {
  background-color: rgb(125, 0, 44, 1);
  box-shadow: 0px 0px 8px rgb(125, 0, 44, 0.85);
  border-color: rgb(125, 0, 44);
  color: white;
}
.sidebar-links .v-list .v-list-group .group-title:hover {
  background-color: rgb(125, 0, 44, 1);
  box-shadow: 0px 0px 8px rgb(125, 0, 44, 0.85);
  border-color: rgb(125, 0, 44);
  color: white;
}
.sidebar-links .v-list .v-list-group .sub-list-group {
  justify-content: flex-start;
  cursor: pointer;
  text-decoration: none;
  /* margin-left: 35px; */
  background-color: rgb(125, 0, 44, 1);
  border-width: thin;
  border-radius: 25px;
  margin-block: 2px;
  color: white;
  font-weight: 80;
  padding-inline: 4px;
  padding-block: 5px;
  transition: 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  /* border: 1px rgb(125, 0, 44, 1);
    padding-inline: 20px;
  padding-block: 10px;

  */
}
.sidebar-links .v-list .v-list-group .sub-list-group:hover {
  background-color: rgba(255, 255, 255, 0.75);
  color: #000000de;
  font-weight: 100;
}
.sidebar-links .v-list .v-list-group .group-title {
  text-decoration: none;
  /* background-color: rgba(255, 255, 255, 0.75); */
  border-width: thick;
  border-radius: 25px;
  padding-inline: 4px;
  padding-block: 8px;
  margin-block: 3px;
  font-weight: 100;
  border: 1px solid rgba(255, 255, 255, 0.85);
  transition: 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.v-list-group__items {
  background-color: white;
  border-radius: 25px;
  margin-left: 15px;
}
.sidebar-links .icon {
  color: white;
  margin-top: -1px;
  margin-left: 3px;
}
.sidebar-links .icon:hover {
  color: #000000de;
}
.sidebar-toggle {
  top: 0px;
  right: 0px;
}

#btn-toggle {
  background-color: rgba(255, 255, 255, 0.15);
  transition: 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  padding: 5px;
  cursor: pointer;
  display: flex;
  justify-content: center;
}

#btn-toggle:hover {
  background-color: rgb(125, 0, 44, 1);
  box-shadow: 0px 0px 6px aqua;
}

.app-bar-content {
  display: flex;
  align-items: center;
  width: 100%;
  justify-content: space-between;
}

.app-bar-content h2 {
  color: rgba(255, 255, 255, 0.75);
}

.app-bar-content h2:hover {
  color: rgba(255, 255, 255, 1);
}

.transition-default {
  font-family: monospace;
  font-size: 2em;
  animation: color-change 1s infinite;
}

@keyframes color-change {
  0% {
    color: blue;
  }
  10% {
    color: #8e44ad;
  }
  20% {
    color: #1abc9c;
  }
  30% {
    color: #d35400;
  }
  40% {
    color: green;
  }
  50% {
    color: #34495e;
  }
  60% {
    color: orange;
  }
  70% {
    color: #2980b9;
  }
  80% {
    color: #f1c40f;
  }
  90% {
    color: #2980b9;
  }
  100% {
    color: pink;
  }
}
@media screen and (max-width: 600px) {
  .app-bar-content h2 {
    font-size: 18px;
  }
}
</style>
