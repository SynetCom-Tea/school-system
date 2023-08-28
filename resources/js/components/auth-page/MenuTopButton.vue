<template>
  <div class="text-center">
    <v-menu v-model="menu" :close-on-content-click="false" location="end">
      <template v-slot:activator="{ props }">
        <div style="float: right">
          <Button
            style="width: 90px; height: 40px"
            :variant="default"
            :prependIcon="icons.mdiMenu"
            ripple
            title="Voir la liste de Menu"
            nameButton="Menu"
            v-bind="props"
          ></Button>
        </div>
      </template>

      <v-card min-width="300">
        <v-list>
          <v-list-item
            prepend-avatar="https://cdn.vuetifyjs.com/images/john.jpg"
            title="John Leider"
            subtitle="Founder of Vuetify"
          >
            <template v-slot:append>
              <v-btn
                variant="text"
                :class="fav ? 'text-red' : ''"
                icon="mdi-heart"
                @click="fav = !fav"
              ></v-btn>
            </template>
          </v-list-item>
        </v-list>

        <v-divider></v-divider>

        <v-list>
          <v-list-item>
            <v-switch
              v-model="message"
              color="purple"
              label="Enable messages"
              hide-details
            ></v-switch>
          </v-list-item>

          <v-list-item>
            <v-switch
              v-model="hints"
              color="purple"
              label="Enable hints"
              hide-details
            ></v-switch>
          </v-list-item>
        </v-list>

        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn variant="text" @click="menu = false"> Cancel </v-btn>
          <v-btn color="primary" variant="text" @click="menu = false"> Save </v-btn>
        </v-card-actions>
      </v-card>
    </v-menu>
  </div>
</template>

<script>
import { router } from "@inertiajs/vue3";
import Button from "../customizedComponents/Button.vue";
import { mdiMenu } from "@mdi/js";
export default {
  name: "Sidebar",
  components: {
    Button,
    mdiMenu,
  },
  props: { onClickMenuButton: { type: Function } },
  data: () => {
    return {
      fav: true,
      menu: false,
      message: false,
      hints: true,
      icons: { mdiMenu },
    };
  },
  mounted() {},
  methods: {
    //  onClickMenuButton() {
    // this.drawer = !this.drawer;
    // },
  },
};
</script>
