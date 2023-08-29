import articlesIcon from "@iconify-icons/fluent-mdl2/articles";
import formsAppsScriptOutlineRounded from "@iconify-icons/material-symbols/forms-apps-script-outline-rounded";
import {
    mdiTimetable,
  mdiAccount,
  mdiPurse,
  mdiHomeOutline,
  mdiPresentation,
  mdiGift,
  mdiSquareMedium,
  mdiGoogleClassroom,
  mdiClipboardEditOutline,
  mdiInstagram,
  mdiTwitter,
  mdiFacebook,
  mdiDotsVertical,
  mdiLogout,
  mdiAccountBoxMultiple,
  mdiCogOutline,
  mdiHomeCity,
  mdiLinkedin,
  mdiCartArrowUp,
  mdiStocking,
  mdiCartPlus,
  mdiFaceAgent,
  mdiChevronDown,
  mdiAccountCogOutline,
  mdiCog,
  mdiSchool,
  mdiWalletMembership,
  mdiAccountSchool,
  mdiInformation,
  mdiCardAccountDetails,
  mdiBookOpenPageVariantOutline,
  mdiShieldCheck,
  mdiTools,
  mdiOfficeBuilding,
  mdiShareCircle,
  mdiMail,
  mdiReceiptTextSendOutline,
  mdiReceiptTextCheckOutline,
} from "@mdi/js";
export function listMenus() {
    let singleItems = [
        {
            title: "Home",
            icon: mdiHomeCity,
            link: "/dashboard",
            permissions: "manage_system",
        },
        {
            title: "Mon compte",
            icon: mdiCogOutline,
            link: "/profile",
        },
        {
            title: "Etablissements",
            icon: mdiReceiptTextCheckOutline,
            link: "/receptions",
            permissions: "manage_system",
        },
        {
            title: "Etudiants",
            icon: mdiAccountSchool,
            link: "/etudiants",
            permissions: "manage_system",
        },
    ];
    let usersMenu = {
        icon: mdiAccountCogOutline,
        title: "Gestions Utilisateurs",
        "icon-alt": mdiChevronDown,
        permissions: "manage_system",
        model: false,
        children: [
            {
                icon: mdiSquareMedium,
                title: "Liste",
                link: "/users",
                permissions: "manage_system",
            },
            {
                icon: mdiSquareMedium,
                title: "Rôles",
                link: "/roles",
                permissions: "manage_system",
            },
            {
                icon: mdiSquareMedium,
                title: "Permissions",
                link: "/permissions",
                permissions: "manage_system",
            },
        ],
    };
    let configsMenu = {
        icon: mdiCog,
        "icon-alt": mdiChevronDown,
        title: "Configuration",
        permissions: "manage_system",
        divider: true,
        model: false,
        children: [
            {
                icon: mdiGift,
                title: "Programmes",
                link: "/program",
                permissions: "manage_system",
            },
            {
                icon: mdiWalletMembership,
                title: "Emploi du temps",
                link: "/schedule",
                permissions: "manage_system",
            },
            {
                icon: mdiAccountSchool,
                title: "Enseignants",
                link: "/teachers",
                permissions: "manage_system",
            },
            {
                icon: mdiSchool,
                title: "Etablissements",
                link: "/organizations",
                permissions: "manage_system",
            },
            {
                icon: mdiSchool,
                title: "Années Scolaires",
                link: "/annees",
                permissions: "manage_system",
            },

            {
                icon: mdiSchool,
                title: "Classes",
                link: "/classes",
                permissions: "manage_system",
            },
            {
                icon: mdiGoogleClassroom,
                title: "Salle de cours",
                link: "/salles",
                permissions: "manage_system",
            },
        ],
    };
    let welcomeMenu = {
        icon: "simple-icons:welcometothejungle",
        "icon-alt": mdiChevronDown,
        title: "Paramétrage du site vitrine",
        permissions: "manage_welcome",
        divider: true,
        model: false,
        children: [
            {
                icon: "dashicons:welcome-widgets-menus",
                title: "Généralités",
                link: "/manage-welcome",
                permissions: "manage_welcome",
            },
            {
                icon: formsAppsScriptOutlineRounded,
                title: "Formulaires",
                link: "/manage-welcome/forms",
                permissions: "manage_welcome",
            },
            {
                icon: articlesIcon,
                title: "Articles",
                link: "/manage-welcome/articles",
                permissions: "manage_welcome",
            },
        ],
    }
    let emploiMenu = {
        icon: mdiTimetable,
        title: "Gestions Emplois",
        "icon-alt": mdiChevronDown,
        permissions: "manage_system",
        model: false,
        children: [
            {
                icon: mdiSquareMedium,
                title: "Emploi",
                link: "/emploi/emplois",
                permissions: "manage_system",
            },
            {
                icon: mdiSquareMedium,
                title: "Calendrier",
                link: "/emploi/emplois",
                permissions: "manage_system",
            },
            // {
            //     icon: mdiSquareMedium,
            //     title: "Permissions",
            //     link: "/permissions",
            //     permissions: "manage_system",
            // },
        ],
    };
    return [singleItems,usersMenu,configsMenu,welcomeMenu, emploiMenu];
}