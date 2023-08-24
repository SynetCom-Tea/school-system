<template>
  <div>
    <v-app-bar color="rgb(0, 73, 128)" prominent>
      <div class="app-bar-content">
        <h2 class="transition-default">Bienvenue sur Système scolaire!</h2>
        <div class="text-end">
          <v-btn
            @click="redirectToWebsite"
            class="text-none"
            style="color: rgb(125, 0, 44); background-color: white"
            rounded
            variant="flat"
            width="90"
          >
            Site web
          </v-btn>
        </div>
        <v-btn ripple color="white" @click="drawer = !drawer">
          <v-icon title="Menu" :icon="icons.mdiMenu"></v-icon>
          <div>Menu</div>
        </v-btn>
      </div>
    </v-app-bar>
    <v-navigation-drawer v-model="drawer" rail-width="320" permanent rail app>
      <div id="sidebar">
        <div class="sidebar-toggle">
          <div @click.stop="drawer = !drawer" id="btn-toggle">
            <v-icon id="btn-toggle-icon" :icon="icons.mdiChevronLeft"></v-icon>
          </div>
        </div>
        <div class="sidebar-body">
          <div class="sidebar-profile">
            <img
              :src="'../assets/' + profileInfo.photo.file"
              :alt="profileInfo.photo.title"
            />
            <v-slide-x-transition mode="in-out" leave-absolute>
              <div id="profile-name">
                {{ profileInfo.name }}
              </div>
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
                  @click="onClickMenuItem(link.link)"
                >
                  <template v-slot:prepend>
                    <v-icon :title="link.title" :icon="link.icon"></v-icon>
                  </template>

                  <v-list-item-title
                    class="text-wrap"
                    v-text="link.title"
                  ></v-list-item-title>
                </v-list-item>
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
import {
  mdiMenu,
  mdiChevronLeft,
  mdiHandshake,
  mdiHome,
  mdiEmail,
  mdiLogoutVariant,
  mdiInformationVariantCircleOutline,
} from "@mdi/js";
import { listMenus } from "../../utils/ListNavAppBar.js";
export default {
  name: "Sidebar",
  components: {
    mdiMenu,
    mdiChevronLeft,
    mdiHome,
    mdiHandshake,
    mdiInformationVariantCircleOutline,
    mdiEmail,
    mdiLogoutVariant,
  },
  data: () => {
    return {
      open: ["getListMenus[1]"],
      drawer: true,
      menuCompact: {
        hidden: true,
      },
      icons: {
        mdiMenu,
        mdiChevronLeft,
        mdiHome,
        mdiHandshake,
        mdiInformationVariantCircleOutline,
        mdiEmail,
        mdiLogoutVariant,
      },
      profileInfo: {
        name: "Super Admin",
        photo: {
          file: "team.png",
          title: "photo profile user",
        },
      },
      rail: true,
      menuLinks: [
        { path: "#", title: "Home", icon: mdiHome },
        { path: "#", title: "About", icon: mdiInformationVariantCircleOutline },
        { path: "#", title: "Contact", icon: mdiEmail },
        { path: "#", title: "Work With Us", icon: mdiHandshake },
        { path: "#", title: "Logout", icon: mdiLogoutVariant },
        { path: "#", title: "Home", icon: mdiHome },
        { path: "#", title: "About", icon: mdiInformationVariantCircleOutline },
        { path: "#", title: "Contact", icon: mdiEmail },
        { path: "#", title: "Work With Us", icon: mdiHandshake },
        { path: "#", title: "Logout", icon: mdiLogoutVariant },
      ],
    };
  },
  mounted() {
    console.log("ListNavAppNav:", this.getListMenus);
    console.log("group:", this.getListMenus[1]);
  },
  computed: {
    getListMenus() {
      return listMenus();
    },
  },
  methods: {
    listMenus,
    onClickMenuItem(item) {
      router.get(item);
    },
    redirectToWebsite() {
      router.get("/");
    },
    changeToggleState() {
      let btnToggleIcon = document.getElementById("btn-toggle-icon");
      this.menuCompact.hidden = !this.menuCompact.hidden;

      if (this.menuCompact.hidden) {
        return (btnToggleIcon.style.transform = "rotateY(0deg)");
      } else {
        return (btnToggleIcon.style.transform = "rotateY(180deg)");
      }
    },
  },
};
</script>
<style scoped>
#sidebar {
  margin: 0;
  top: 0;
  left: 0;
  background-color: rgb(0, 73, 128);
  height: 900px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.6);
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
  margin-inline: 14px;
  padding: 4px;
  background-image: linear-gradient(to right, rgb(125, 0, 44, 0.7), rgb(125, 0, 44, 0.4));
  border-radius: 50px;
  border: 2px solid rgb(125, 0, 44, 0.75);
  transition: 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  margin-bottom: 25px;
}

.sidebar-profile:hover {
  background-color: rgba(0, 255, 255, 0.85);
  box-shadow: 0px 0px 8px rgba(0, 255, 255, 0.85);
  transform: scale(1.05);
  cursor: pointer;
}

.sidebar-profile #profile-name {
  font-weight: 900;
  flex-grow: 1;
  font-size: 16px;
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
  color: rgba(255, 255, 255, 0.4);
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
  text-decoration: none;
  background-color: rgba(255, 255, 255, 0.75);
  border-radius: 25px;
  padding-inline: 20px;
  padding-block: 15px;
  margin-block: 3px;
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
  text-decoration: none;
  margin-left: 15px;
  background-color: rgb(125, 0, 44, 1);
  border-width: thick;
  border-radius: 25px;
  margin-block: 2px;
  color: white;
  font-weight: 100;
  transition: 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  /* border: 1px rgb(125, 0, 44, 1);
    padding-inline: 20px;
  padding-block: 10px;

  */
}
.sidebar-links .v-list .v-list-group .sub-list-group:hover {
  margin-left: 15px;
  background-color: rgba(255, 255, 255, 0.75);
  border-width: thick;
  border-radius: 25px;
  margin-block: 2px;
  color: bold;
  font-weight: 100;
}
.sidebar-links .v-list .v-list-group .group-title {
  text-decoration: none;
  background-color: rgba(255, 255, 255, 0.75);
  border-radius: 25px;
  padding-inline: 15px;
  padding-block: 15px;
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

/* .sidebar-links .v-list .v-list-group:hover {
  background-color: rgb(125, 0, 44, 1);
  box-shadow: 0px 0px 8px rgb(125, 0, 44, 0.85);
  border-color: rgb(125, 0, 44);
} */

/* .sidebar-links .v-list .v-list-item:nth-last-of-type(1):hover {
  background-image: linear-gradient(to right, red, rgb(100, 0, 0));
  box-shadow: 0px 0px 8px red;
  border-color: red;
} */

/* .sidebar-links .links .v-list .v-list-group {
  display: flex;
  flex-direction: row;
  align-items: center;
  color: rgba(0, 0, 0, 0.6);
}
.sidebar-links .links .v-list .v-list-group:hover {
  display: flex;
  flex-direction: row;
  align-items: center;
  color: white;
} */

/* Debut list-item */
.sidebar-links .icon:hover {
  color: white;
}
.sidebar-links .icon {
  color: rgba(0, 0, 0, 0.9);
  margin-top: -1px;
  margin-left: 3px;
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
  transition: 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  cursor: pointer;
}

@media screen and (max-width: 600px) {
  .app-bar-content h2 {
    font-size: 18px;
  }
}
</style>
