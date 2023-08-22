<template>
  <div>
    <v-app-bar short dense color="#004980" app>
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
    <v-navigation-drawer
      v-model="drawer"
      :temporary="false"
      disable-resize-watcher
      :mini-variant="!menuCompact.hidden"
      mini-variant-width="100"
      app
    >
      <div id="sidebar">
        <div class="sidebar-toggle">
          <div @click="changeToggleState()" id="btn-toggle">
            <v-icon id="btn-toggle-icon" :icon="icons.mdiChevronLeft" x-large></v-icon>
          </div>
        </div>
        <div class="sidebar-body">
          <div class="sidebar-profile" v-show="memberActive">
            <img
              :src="'../assets/' + profileInfo.photo.file"
              :alt="profileInfo.photo.title"
            />
            <v-slide-x-transition mode="in-out" leave-absolute>
              <div v-show="menuCompact.hidden" id="profile-name">
                {{ profileInfo.name }}
              </div>
            </v-slide-x-transition>
          </div>
          <div class="sidebar-links">
            <small>Menu</small>
            <hr class="divider" />
            <div class="links">
              <v-list density="compact">
                <v-list-item
                  v-for="link in menuLinks"
                  :key="link.title"
                  :href="link.path"
                >
                  <template v-slot:prepend>
                    <v-icon :icon="link.icon"></v-icon>
                  </template>
                  <v-list-item-title>
                    <v-slide-x-transition mode="in-out" leave-absolute>
                      <div class="link-title" v-show="menuCompact.hidden">
                        {{ link.title }}
                      </div>
                    </v-slide-x-transition>
                  </v-list-item-title>
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
import {
  mdiMenu,
  mdiChevronLeft,
  mdiHandshake,
  mdiHome,
  mdiEmail,
  mdiLogoutVariant,
  mdiInformationVariantCircleOutline,
} from "@mdi/js";
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
      memberActive: true,
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
  methods: {
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
  /* background-color: rgb(8, 12, 19); */
  /* height: 100%; */
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
  background-image: linear-gradient(to right, rgb(0, 73, 128, 0.7), rgb(0, 73, 128, 0.4));
  border-radius: 50px;
  border: 2px solid rgb(0, 73, 128, 0.75);
  transition: 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  margin-bottom: 25px;
}

.sidebar-profile:hover {
  background-color: rgb(125, 0, 44);
  box-shadow: 0px 0px 8px rgb(125, 0, 44);
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

.sidebar-links .links {
  display: flex;
  flex-direction: column;
}

.sidebar-links a {
  text-decoration: none;
  background-color: rgba(255, 255, 255, 0.75);
  border-radius: 25px;
  padding-inline: 20px;
  padding-block: 15px;
  margin-block: 3px;
  font-weight: 900;
  border: 1px solid rgba(255, 255, 255, 0.85);
  transition: 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.sidebar-links a:hover {
  transform: scale(1.08);
  background-color: rgb(125, 0, 44, 1);
  box-shadow: 0px 0px 8px rgb(125, 0, 44, 0.85);
  border-color: rgb(125, 0, 44);
}

.sidebar-links a:nth-last-of-type(1):hover {
  background-image: linear-gradient(to right, red, rgb(100, 0, 0));
  box-shadow: 0px 0px 8px red;
  border-color: red;
}

.sidebar-links .links a {
  display: flex;
  flex-direction: row;
  align-items: center;
  color: rgba(0, 0, 0, 0.6);
}
.sidebar-links .links a:hover {
  display: flex;
  flex-direction: row;
  align-items: center;
  color: white;
}

.sidebar-links .link-title {
  margin-left: 10px;
}

.sidebar-links .icon {
  color: rgba(0, 0, 0, 0.9);
  margin-top: -1px;
  margin-left: 3px;
}
.sidebar-links .icon:hover {
  color: white;
  margin-top: -1px;
  margin-left: 3px;
}

.sidebar-toggle {
  top: 0px;
  right: 0px;
}
.v-icon__svg :hover {
  color: white;
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
  box-shadow: 0px 0px 6px rgb(125, 0, 44);
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
  color: white;
  cursor: pointer;
}

@media screen and (max-width: 600px) {
  .app-bar-content h2 {
    font-size: 18px;
  }
}
</style>
