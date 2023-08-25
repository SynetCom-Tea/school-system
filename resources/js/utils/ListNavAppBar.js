import articlesIcon from "@iconify-icons/fluent-mdl2/articles";
import formsAppsScriptOutlineRounded from "@iconify-icons/material-symbols/forms-apps-script-outline-rounded";
import {
  mdiAccount,
  mdiPurse,
  mdiHomeOutline,
  mdiPresentation,
  mdiGift,
  mdiSquareMedium,
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
            title: "Evaluation",
            icon: mdiCogOutline,
            link: "/gestionnote/evaluation",
        },
        // {
        //     title: "Attribution de notes",
        //     icon: mdiReceiptTextCheckOutline,
        //     link: "/receptions",
        //     permissions: "manage_system",
        // },
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
    // Gestion de Notes
    let configsMenu = {
        icon: mdiCog,
        "icon-alt": mdiChevronDown,
        title: "Notes",
        permissions: "manage_system",
        divider: true,
        model: false,
        children: [
            {
                icon: mdiGift,
                title: "Affichage de notes",
                link: "gestionnote/note/affichage",
                permissions: "manage_system",
            },
            {
                icon: mdiWalletMembership,
                title: "Attribution de notes",
                link: "/schedule",
                permissions: "manage_system",
            },
            // {
            //     icon: mdiAccountSchool,
            //     title: "Enseignants",
            //     link: "/teachers",
            //     permissions: "manage_system",
            // },
            // {
            //     icon: mdiSchool,
            //     title: "Etablissements",
            //     link: "/organizations",
            //     permissions: "manage_system",
            // },
        ],
    };
    // Gestion de Notes
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
    return [singleItems,usersMenu,configsMenu,welcomeMenu]
}