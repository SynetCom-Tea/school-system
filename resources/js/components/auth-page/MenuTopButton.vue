<template>
  <div>
    <v-menu v-model="menu" :close-on-content-click="true" location="end">
      <template v-slot:activator="{ props }">
        <div style="float: right">
          <Button
            style="width: 90px; height: 40px"
            :prependIcon="icons.mdiMenu"
            ripple
            title="Voir la liste de Menu"
            nameButton="Menu"
            v-bind="props"
          ></Button>
        </div>
      </template>
      <v-card class="bg-green">
        <v-navigation-drawer
          permanent
          location="right"
          v-model="drawer"
          class="navigation"
        >
          <template v-slot:prepend>
            <v-list-item
              lines="two"
              prepend-avatar="https://randomuser.me/api/portraits/women/81.jpg"
              :title="username"
              subtitle="Connecté(e)"
            >
              <template v-slot:append>
                <v-icon
                  title="Fermer"
                  :icon="icons.mdiClose"
                  @click="menu = !menu"
                ></v-icon>
              </template>
            </v-list-item>
          </template>

          <v-divider></v-divider>

          <v-list density="compact" nav v-for="item in getListMenus">
            <v-list-item
              :prepend-icon="item.icon"
              :title="item.title"
              :value="item.title"
              @click="page(item.link)"
            ></v-list-item>
          </v-list>
        </v-navigation-drawer>
      </v-card>
      <v-main style="height: 650px"></v-main>
    </v-menu>
  </div>
</template>

<script>
import { router } from "@inertiajs/vue3";
import Button from "../customizedComponents/Button.vue";
import { mdiMenu, mdiClose } from "@mdi/js";
import { listMenus } from "../../utils/ListNavAppBar.js";
export default {
  name: "Sidebar",
  components: {
    Button,
    mdiMenu,
    mdiClose,
  },
  props: { onClickMenuButton: { type: Function } },
  data: () => {
    return {
      drawer: true,
      username: "",
      fav: true,

      menu: false,
      message: false,
      hints: true,
      icons: { mdiMenu, mdiClose },
    };
  },
  mounted() {
    console.log("test:", this.$page.props.auth.user);
    this.username =
      this.$page.props.auth?.user?.nom + " " + this.$page.props.auth?.user?.prenom;
  },
  computed: {
    getListMenus() {
      let list = this.listMenus();
      let flattened;
      let flattened2 = [];

      list.forEach((element) => {
        if (element instanceof Array) {
          flattened = element.flat();
        }
        if (element instanceof Object) {
          flattened2.push(element.children);
        }
      });
      let filteredFlattened2 = flattened2.filter((el) => el);
      let filteredFlattened22 = filteredFlattened2.flat();
      let result = flattened.concat(filteredFlattened22);
      return result ?? [];
    },
  },
  methods: {
    listMenus,
    page(link) {
      router.get(link);
    },
    //  onClickMenuButton() {
    // this.drawer = !this.drawer;
    // },
  },
};
</script>
<style scoped>
nav.v-navigation-drawer {
  top: 50px;
}
.navigation {
  border: 2px solid rgb(125, 0, 44, 0.75);
  margin-left: 0px;
}
</style>
