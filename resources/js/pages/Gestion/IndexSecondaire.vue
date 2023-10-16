<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {
    listMenusBySection
} from "../../utils/ListNavAppBar.js";
import {
    router,
    usePage,
    useForm
} from "@inertiajs/vue3";
import {
    mdiTimerStarOutline,
    mdiAccountSchoolOutline,
    mdiWeatherHurricane,
    mdiWeatherPouring,
    mdiWeatherWindy,
    mdiAlert,
} from "@mdi/js";
export default {
    components: {
        AuthenticatedLayout
    },
    data() {
        return {
            authPage: this.$page.props,
            listTitles: [{
                name: "Forida"
            }, {
                name: "Niamey"
            }],
            icons: {
                mdiTimerStarOutline,
                mdiAccountSchoolOutline,
                mdiWeatherHurricane,
                mdiWeatherPouring,
                mdiWeatherWindy,
                mdiAlert,
            },
            form: this.$inertia.form({
                section_id: 2,
            }),
            expand: {},
            time: 0,
        };
    },
    mounted() {
        this.getMenus;
    },
    computed: {
        getMenus() {
            let list = this.listMenusBySection(this.authPage, 1);
            console.log(list)
            return list[0] ?? [];
        },
    },
    methods: {
        listMenusBySection,
        goToPage(item) {
            if (item.link == "/users") {
                this.form.get(route("users.index"));
            }
            if (item.link == "/subscribers") {
                this.form.get(route("inscriptions.index"));
            }
            if (item.link == "emplois") {
                this.form.get(route("emplois.index"));
            }
            if (item.link == "emploisCreate") {
                this.form.get(route("emplois.create"));
            }
            if (item.link == "evaluation") {
                this.form.get(route("evaluation.index_admin"));
            }
        },
        onClickExpland(item) {
            let vExpand = item.expand;
            // console.log(" vExpand:", vExpand);
            this.expand[item.expand] = !vExpand;
            // item.expand = this.expand[item.expand];
            // console.log("expand:", this.expand[item.expand]);
        },
    },
};
</script>

<template>
<AuthenticatedLayout>
    <div style="margin: 10px">
        <Toolbar styleToolbar="background-color: white;" :icon="icons.mdiTimerStarOutline" toolbarTitle="Liste des menus Secondaire"></Toolbar>
        <div style="margin: 10px">
            <h2 class="text-color-secondary">Gestion Secondaire</h2>
        </div>

        <v-row>
            <v-col v-for="(item, i) in getMenus" cols="4">
                <v-card :prepend-icon="item.icon" class="mx-auto" max-width="250" :color="item.color" style="cursor: pointer" @click="goToPage(item)">
                    <v-card-text class="py-0" :key="i">
                        <v-card-title style="color: primary">{{ item.title }}</v-card-title>

                        <!-- <v-icon color="secondary" :icon="item.icon"></v-icon> -->

                        <div class="d-flex py-3 justify-space-between">
                            <v-list-item density="compact" :prepend-icon="icons.mdiWeatherWindy">
                                <v-list-item-subtitle>Section Secondaire</v-list-item-subtitle>
                            </v-list-item>
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </div>
</AuthenticatedLayout>
</template>
