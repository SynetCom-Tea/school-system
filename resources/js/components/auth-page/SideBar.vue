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

    <v-navigation-drawer v-model="drawer" rail-width="300" class="bg-primary" permanent :rail="rail" width="300">
        <div id="sidebar">
            <div class="sidebar-toggle">
                <div @click="changeToggleState()" id="btn-toggle">
                    <v-icon id="btn-toggle-icon" :icon="icons.mdiChevronLeft"></v-icon>
                </div>
            </div>
            <div class="sidebar-body">
                <div class="sidebar-profile">
                    <img :src="'/logos/' + getOrganizationProfile.photo.file" :alt="getOrganizationProfile.photo.title" />
                    <v-slide-x-transition mode="in-out" leave-absolute class="text-wrap">
                        <v-list-item id="profile-name" lines="two" :title="getOrganizationProfile.organization.name">
                            <template v-slot:subtitle="{ subtitle }">
                                <span class="text-wrap" style="font-size: 0.9em; color:bold">
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
                        <v-list-item class="list-case" v-for="link in getListMenus.singleItems" :key="link.title" @click="page(link.link)">
                            <template v-slot:prepend>
                                <v-icon :title="link.title" :icon="link.icon"></v-icon>
                            </template>
                            <v-list-item-title class="text-wrap" v-text="link.title"></v-list-item-title>
                        </v-list-item>
                        <!-- Début Super-Admin  -->
                        <div v-for="(itemSection, i) in superAdminMenus" :key="i">
                            <v-list-group :value="itemSection.title" v-if="$page.props.roles[0] == 'Super-administrateur'">
                                <template v-slot:activator="{ props }">
                                    <v-list-item class="group-title" v-bind="props">
                                        <template v-slot:prepend>
                                            <v-icon :title="itemSection.title" :icon="itemSection.icon"></v-icon>
                                        </template>
                                        <v-list-item-title class="text-wrap" v-text="itemSection.title"></v-list-item-title>
                                    </v-list-item>
                                </template>

                                <v-list-item class="sub-list-group" v-for="(item, i) in itemSection.children" :key="i" @click="page(item.link)">
                                    <template v-slot:prepend>
                                        <v-icon :title="item.title" :icon="item.icon"></v-icon>
                                    </template>

                                    <v-list-item-title class="text-wrap" v-text="item.title"></v-list-item-title>
                                </v-list-item>
                            </v-list-group>
                        </div>

                        <!-- Fin Super-Admin -->
                        <!--Debut des menu sections -->
                        <v-list-group :value="menusBySection.title" v-permission:any="'manage_school|manage_section'">
                            <template v-slot:activator="{ props }">
                                <v-list-item class="group-title" v-bind="props">
                                    <template v-slot:prepend>
                                        <v-icon :title="menusBySection.title" :icon="menusBySection.icon"></v-icon>
                                    </template>
                                    <v-list-item-title class="text-wrap" v-text="menusBySection.title"></v-list-item-title>
                                </v-list-item>
                            </template>

                            <v-list-item class="sub-list-group" v-for="(item, i) in menusBySection.children" :key="i" @click="pageSection(item)">
                                <template v-slot:prepend>
                                    <v-icon :title="item.title" :icon="item.icon"></v-icon>
                                </template>

                                <v-list-item-title class="text-wrap" v-text="item.title"></v-list-item-title>
                            </v-list-item>
                        </v-list-group>
                        <!-- Debut evaluation  -->
                        <v-list-group :value="getListMenus.MenuEvaluation && getListMenus.MenuEvaluation.title" v-permission="'espace_enseignant'">
                            <template v-slot:activator="{ props }">
                                <v-list-item class="group-title" v-bind="props">
                                    <template v-slot:prepend>
                                        <v-icon :title="getListMenus.MenuEvaluation.title" :icon="getListMenus.MenuEvaluation.icon"></v-icon>
                                    </template>
                                    <v-list-item-title class="text-wrap" v-text="getListMenus.MenuEvaluation.title"></v-list-item-title>
                                </v-list-item>
                            </template>

                            <v-list-item class="sub-list-group" v-for="(item, i) in getListMenus.MenuEvaluation.children" :key="i" @click="page(item.link)">
                                <template v-slot:prepend>
                                    <v-icon :title="item.title" :icon="item.icon"></v-icon>
                                </template>

                                <v-list-item-title class="text-wrap" v-text="item.title"></v-list-item-title>
                            </v-list-item>
                        </v-list-group>
                        <v-list-group :value="getListMenus.MenuEtudiant && getListMenus.MenuEtudiant.title" v-permission="'espace_etudiant'">
                            <template v-slot:activator="{ props }">
                                <v-list-item class="group-title" v-bind="props">
                                    <template v-slot:prepend>
                                        <v-icon :title="getListMenus.MenuEtudiant.title" :icon="getListMenus.MenuEtudiant.icon"></v-icon>
                                    </template>
                                    <v-list-item-title class="text-wrap" v-text="getListMenus.MenuEtudiant.title"></v-list-item-title>
                                </v-list-item>
                            </template>

                            <v-list-item class="sub-list-group" v-for="(item, i) in getListMenus.MenuEtudiant.children" :key="i" @click="page(item.link)">
                                <template v-slot:prepend>
                                    <v-icon :title="item.title" :icon="item.icon"></v-icon>
                                </template>

                                <v-list-item-title class="text-wrap" v-text="item.title"></v-list-item-title>
                            </v-list-item>
                        </v-list-group>
                        <v-list-group :value="getListMenus.MenuNote && getListMenus.MenuNote.title" v-permission="'espace_enseignant'">
                            <template v-slot:activator="{ props }">
                                <v-list-item class="group-title" v-bind="props">
                                    <template v-slot:prepend>
                                        <v-icon :title="getListMenus.MenuNote.title" :icon="getListMenus.MenuNote.icon"></v-icon>
                                    </template>
                                    <v-list-item-title class="text-wrap" v-text="getListMenus.MenuNote.title"></v-list-item-title>
                                </v-list-item>
                            </template>

                            <v-list-item class="sub-list-group" v-for="(item, i) in getListMenus.MenuNote.children" :key="i" @click="page(item.link)">
                                <template v-slot:prepend>
                                    <v-icon :title="item.title" :icon="item.icon"></v-icon>
                                </template>
                                <v-list-item-title class="text-wrap" v-text="item.title"></v-list-item-title>
                            </v-list-item>
                        </v-list-group>

                        <!-- Fin evaluation -->

                        <!-- Debut du menu preconfig -->

                        <!-- <v-list-group
                v-permission="'manage_school'"
                :value="getListMenus.MenuAdmin.title"
              >
                <template v-slot:activator="{ props }">
                  <v-list-item class="group-title" v-bind="props">
                    <template v-slot:prepend>
                      <v-icon
                        :title="getListMenus.MenuAdmin.title"
                        :icon="getListMenus.MenuAdmin.icon"
                      ></v-icon>
                    </template>
                    <v-list-item-title
                      class="text-wrap"
                      v-text="getListMenus.MenuAdmin.title"
                    ></v-list-item-title>
                  </v-list-item>
                </template>

                <v-list-item
                  class="sub-list-group"
                  v-for="(item, i) in getListMenus.MenuAdmin.children"
                  :key="i"
                  @click="page(item.link)"
                >
                  <template v-slot:prepend>
                    <v-icon :title="item.title" :icon="item.icon"></v-icon>
                  </template>
                    <v-list-item-title class="text-wrap" v-text="item.title"></v-list-item-title>
                </v-list-item>
              </v-list-group> -->
                        <!-- Menu Gestion -->
                        <v-list-group :value="MenuGestion.title" v-permission:any="'manage_school|manage_config'">
                            <template v-slot:activator="{ props }">
                                <v-list-item class="group-title" v-bind="props">
                                    <template v-slot:prepend>
                                        <v-icon :title="MenuGestion.title" :icon="MenuGestion.icon"></v-icon>
                                    </template>
                                    <v-list-item-title class="text-wrap" v-text="MenuGestion.title"></v-list-item-title>
                                </v-list-item>
                            </template>
                            <v-list-item class="sub-list-group" v-for="(item, i) in MenuGestion.children" :key="i" @click="page(item.link)">
                                <template v-slot:prepend>
                                    <v-icon :title="item.title" :icon="item.icon"></v-icon>
                                </template>
                                <v-list-item-title class="text-wrap" v-text="item.title"></v-list-item-title>
                            </v-list-item>
                        </v-list-group>
                        <v-list-group :value="MenuUser.title" v-permission:any="'manage_school|manage_config'" >
                            <template v-slot:activator="{ props }">
                                <v-list-item class="group-title" v-bind="props">
                                    <template v-slot:prepend>
                                        <v-icon :title="MenuUser.title" :icon="MenuUser.icon"></v-icon>
                                    </template>
                                    <v-list-item-title class="text-wrap" v-text="MenuUser.title"></v-list-item-title>
                                </v-list-item>
                            </template>
                            <v-list-item class="sub-list-group" v-for="(item, i) in MenuUser.children" :key="i" @click="page(item.link)">
                                <template v-slot:prepend>
                                    <v-icon :title="item.title" :icon="item.icon"></v-icon>
                                </template>
                                <v-list-item-title class="text-wrap" v-text="item.title"></v-list-item-title>
                            </v-list-item>
                        </v-list-group>
                        <!-- Fin Menu Gestion -->

                        <!-- Début menu Tuteur -->

                        <v-list-group :value="menuTuteur.title" v-permission="'espace_tuteur'">
                            <template v-slot:activator="{ props }">
                                <v-list-item class="group-title" v-bind="props">
                                    <template v-slot:prepend>
                                        <v-icon :title="menuTuteur.title" :icon="menuTuteur.icon"></v-icon>
                                    </template>
                                    <v-list-item-title class="text-wrap" v-text="menuTuteur.title"></v-list-item-title>
                                </v-list-item>
                            </template>

                            <v-list-item class="sub-list-group" v-for="(item, i) in menuTuteur.children" :key="i" @click="pageTuteur(item.link)">
                                <template v-slot:prepend>
                                    <v-icon :title="item.title" :icon="item.icon"></v-icon>
                                </template>

                                <v-list-item-title class="text-wrap" v-text="item.title"></v-list-item-title>
                            </v-list-item>
                        </v-list-group>
                        <!-- Fin Menu Tuteur -->
                        <!-- Debut Menu Comptable-->
                        <v-list-group :value="getListMenus.MenuComptable && getListMenus.MenuComptable.title" v-permission="'espace_comptable'">
                            <template v-slot:activator="{ props }">
                                <v-list-item class="group-title" v-bind="props">
                                    <template v-slot:prepend>
                                        <v-icon :title="getListMenus.MenuComptable.title" :icon="getListMenus.MenuComptable.icon"></v-icon>
                                    </template>
                                    <v-list-item-title class="text-wrap" v-text="getListMenus.MenuComptable.title"></v-list-item-title>
                                </v-list-item>
                            </template>

                            <v-list-item class="sub-list-group" v-for="(item, i) in getListMenus.MenuComptable.children" :key="i" @click="page(item.link)">
                                <template v-slot:prepend>
                                    <v-icon :title="item.title" :icon="item.icon"></v-icon>
                                </template>
                                <v-list-item-title class="text-wrap" v-text="item.title"></v-list-item-title>
                            </v-list-item>
                        </v-list-group>

                        <!-- Fin Menu Comptable-->
                        
                        <!-- Fin du menu preconfig -->

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
    listMenus,
    menusTuteur
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
            menuTuteur: null,
            MenuGestion: [],
            MenuUser: [],
            menusBySection: [],
            menuTeachers: [],
            superAdminMenus: [],
            open: null,
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
        this.getUserProfile;
        this.getOrganizationProfile;
        this.$gates.setRoles(this.$page.props.roles);
        this.$gates.setPermissions(this.$page.props.permissions);
        // listMenus(this.$page.props);
        // console.log('Vuegates',this.$gates.setRoles(this.$page.props.roles))
    },
    mounted() {
        this.$gates.getRoles();
        this.$gates.getPermissions();
        axios.interceptors.response.use(
            function (response) {
                return response;
            },
            function (error) {
                if (error.response ?.status === 403) {
                    alert(
                        "Session expirée. Vous serez redirigé(e) vers la page d'authentification!!"
                    );
                    window.location.href = "/login";
                }
                return Promise.reject(error);
            }
        );
        // console.log('permi', this.$page.props.permissions)
    },
    computed: {
        getOrganizationProfile() {
            let fullName;
            let organization;
            let user = this.$page.props.auth ? this.$page.props.auth.user : null;
            let sections, allSections;
            if (this.$page.props && this.$page.props.admin_etablissement) {
                organization = this.$page.props.admin_etablissement.etablissement;
                if (this.$page.props.sections[0] && this.$page.props.sections[0].sections) {
                    sections = this.$page.props.sections[0].sections;
                }
            }

            if (sections && sections.length == 3) {
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
                    file: organization.logo ?? "team1.png",
                    title: "photo de l'établissement",
                },
            };

            return item;
        },
        getUserProfile() {
            let fullName, firstname, lastname;
            let organization;
            let apprenant, enseignant, tuteur;
            if (this.$page.props.auth && this.$page.props.auth.user) {
                apprenant = this.$page.props.auth.user.apprenant;
                enseignant = this.$page.props.auth.user.enseignant;
                tuteur = this.$page.props.auth.user.tuteur;
            }
            let user = apprenant ?
                apprenant :
                enseignant ?
                enseignant :
                tuteur ?
                tuteur :
                this.$page.props.auth.user;

            let roles = this.$page.props.roles ? this.$page.props.roles[0] : null;
            let vRoles = this.$page.props.roles.length > 1 ? "Profil" : roles;
            firstname = user.nom ?? "Nom";
            lastname = user.prenom ?? "Prénom";
            fullName = firstname + " " + lastname;
            let item = {
                name: fullName,
                typeUser: vRoles,
                photo: {
                    file: "team1.png",
                    title: "photo de l'établissement",
                },
            };
            return item;
        },
        getListMenus() {
            let list = listMenus(this.$page.props);
            let {
                singleItems,
                gestionSections,
                MenuAdmin,
                usersMenu,
                MenuGestion,
                MenuUser,
                MenuEvaluation,
                MenuNote,
                superAdminMenus,
                menuTeachers,
                menuRolePermission,
            } = list;

            let role = this.$page.props.roles ? this.$page.props ?.roles[0] : null;
            this.menusBySection = gestionSections ?? [];

            this.MenuGestion = MenuGestion;
            this.MenuUser = MenuUser;
            this.superAdminMenus = superAdminMenus;

            this.menuTuteur = menusTuteur(this.$page.props);

            // console.log(this.MenuGestion)
            return list ?? null;
        },
    },
    methods: {
        listMenus,
        menusTuteur,
        getTypeEtablissementById,
        pageTuteur(item) {
            if (item == "children") {
                router.get(route("tuteurs.index"));
            }
            if (item == "alertes") {
                router.get(route("tuteurs.listWarnings"));
            }
            if (item == "meetings") {
                router.get(route("tuteurs.meetings"));
            }
            if (item == "dashboard") {
                router.get(route("tuteurs.dashboard"));
            }
            if (item == "result") {
                router.get(route("tuteurs.result"));
            }
            if (item == "meetings") {
                router.get(route("tuteurs.meetings"));
            }
            if (item == "mailBox") {
                router.get(route("tuteurs.mailBox"));
            }
        },
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
        pageSection(item) {
            if (item.link == "gestion/primaire") {
                router.get(route("indexPrimaire"));
            }
            if (item.link == "gestion/secondaire") {
                router.get(route("indexSecondaire"));
            }
            if (item.link == "gestion/superieure") {
                router.get(route("indexSuperieure"));
            }
            if (item.link == "gestion/universitaire") {
                router.get(route("indexUniversitaire"));
            }
            // router.get("/dashboard");
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
// <v-list density="compact" v-model:opened="open">
</script>

<style scoped src="../../../css/side-bar-style.css"></style>
