<template>
  <v-card><v-card-text>Content</v-card-text></v-card>
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
  computed: {},
  methods: {},
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
.dropdown-menu > li > a {
  color: white;
}

.dropdown-menu > li > a:hover {
  background-color: red;
  background-image: none;
}

.navbar-nav {
  --bs-nav-link-color: #fff;
  --bs-nav-link-hover-color: white;
  /* background-color: orange; */
  --bs-nav-link-disabled-color: var(--bs-navbar-disabled-color);
}
.nav-item:hover {
  background-color: orange;
}
.icon_socialnet_btn:hover {
  background-color: orange;
}
.connexion_btn:hover {
  color: orange;
}
.list-item:hover {
  color: orange;
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
.bg-dots-darker {
  background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
  .dark\:bg-dots-lighter {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
  }
}
</style>
