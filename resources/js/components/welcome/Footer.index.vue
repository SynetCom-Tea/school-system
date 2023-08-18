<template>
  <footer
    style="
      position: absolute;
      bottom: 0;
      left: 0;
      background-color: #004980;
      width: 100%;
      background-size: cover;
    "
  >
    <v-row>
      <v-col cols="8"
        ><div style="margin: 5px">
          <v-row no-gutters>
            <v-col cols="12">
              <v-btn
                v-for="link in links"
                :key="link"
                variant="text"
                class="link_btn"
                rounded="xl"
              >
                {{ link }}
              </v-btn>
            </v-col>
          </v-row>
          <v-row no-gutters>
            <v-btn class="connexion_btn"> Connexion </v-btn>
          </v-row>
        </div></v-col
      >
      <v-col cols="4"
        ><div>
          <span style="color: white">Rejoingnez-nous sur les réseaux sociaux:</span>

          <v-spacer></v-spacer>
          <v-btn
            style="margin: 10px"
            v-for="icon in iconsFooter"
            :key="icon.id"
            :icon="icon"
            @click="goSocialMediasURL(icon)"
            class="icon_socialnet_btn"
            ><Icon :icon="icon.icon" />
          </v-btn></div
      ></v-col>
    </v-row>
    <!-- <div
      class="d-flex justify-content: space-between; flex-direction: row; flex-wrap: wrap;margin:5px"
    >
      <span style="color: white">Rejoingnez-nous sur les réseaux sociaux:</span>

      <v-spacer></v-spacer>
      <v-btn
        style="margin-top: 10px"
        v-for="icon in iconsFooter"
        :key="icon.id"
        :icon="icon"
        @click="goSocialMediasURL(icon)"
        class="icon_socialnet_btn"
        ><Icon :icon="icon.icon" />
      </v-btn>
    </div> -->

    <!-- <div>
      <v-row class="row">
        <v-col class="col-md-3 col-lg-4 col-xl-3 mx-auto">
          <p style="color: white">
            Sa principale mission consiste à apporter plus de lisibilité dans la gestion
            des subventions de l’éducation.
          </p>
          <p>
            <v-btn class="connexion_btn" @click="goToLoginPage"> Connexion </v-btn>
          </p>
        </v-col>
      </v-row>
    </div> -->
    <div
      class="text-white"
      style="background-color: #7d002c; margin-bottom: 0; text-align: center"
    >
      © {{ new Date().getFullYear() }}&nbsp; Copyright:
      <a class="text-reset text-white" href="https://mdbootstrap.com/">synetcom.com</a>
    </div>
  </footer>
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
      links: ["Acceuil", "A propos", "Equipe", "Services", "Blog", "Contacts"],
      iconsVidoeo: [
        { icon: "mdi-rewind" },
        { icon: "mdi-play" },
        { icon: "mdi-fast-forward" },
      ],
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
  computed: {
    iconsFooter() {
      let list = [
        {
          id: 1,
          name: "facebook",
          url:
            "https://web.facebook.com/people/Agence-Nig%C3%A9rienne-des-Allocations-et-des-Bourses-ANAB/100080244188935/?_rdc=1&_rdr",
          class: "me-4 link-secondary",
          icon: "logos:facebook",
        },
        {
          id: 2,
          name: "twitter",
          url: "https://twitter.com",
          class: "me-4 link-secondary",
          icon: "skill-icons:twitter",
        },
        {
          id: 3,
          name: "google",
          url: "https://www.google.com/",
          class: "me-4 link-secondary",
          icon: "flat-color-icons:google",
        },
        {
          id: 4,
          name: "instagram",
          url: "https://www.instagram.com/",
          class: "me-4 link-secondary",
          icon: "skill-icons:instagram",
        },
        {
          id: 5,
          name: "instagram",
          url: "https://www.linkedin.com/",
          class: "me-4 link-secondary",
          icon: "devicon:linkedin",
          // icon: "logos:linkedin",
        },
      ];
      return list;
    },
  },
  methods: {
    goSocialMediasURL(icon) {
      return window.open(icon.url);
    },
    goToMenuItemPage(name) {
      if (name && name != "") {
        return router.visit(`/${name}`, {
          preserveScroll: true,
        });
      } else return;
    },
    goToRegisterPage() {
      return router.visit("/register", {
        preserveScroll: true,
      });
    },
    goToLoginPage() {
      return router.visit("/login", {
        preserveScroll: true,
      });
    },
  },
};
</script>
<style scoped>
.logoApp {
  width: 80px;

  object-fit: cover;
  /* width: 50px;
    height: 70px;

    clip-path: inset(40px 20px 20px 40px); */
}

.nav-item:hover {
  background-color: orange;
}
.icon_socialnet_btn:hover {
  background-color: #7d002c;
}
.link_btn {
  color: white;
}
.link_btn:hover {
  color: #7d002c;
}
.connexion_btn:hover {
  color: #7d002c;
}
.list-item:hover {
  color: #7d002c;
}
.dropdow_item_user {
  text-transform: none;
}
.dropdow_item_user:hover {
  text-transform: none;
  color: orange;
}
.navbar-text:hover {
  color: white;
}
</style>
