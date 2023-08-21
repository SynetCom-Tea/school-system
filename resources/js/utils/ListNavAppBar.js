export function listMenus() {
    let singleItems = [
        {
            text: "Home",
            icon: mdiHomeCity,
            link: "/dashboard",
            permissions: "manage_system",
        },
        {
            text: "Mon compte",
            icon: mdiCogOutline,
            link: "/profile",
        },





        {
            text: "Etablissements",
            icon: mdiReceiptTextCheckOutline,
            link: "/receptions",
            permissions: "manage_system",
        },


    ];
    let usersMenu = {
        icon: mdiAccountCogOutline,
        "icon-alt": mdiChevronDown,
        title: "Utilisateurs",
        permissions: "manage_system",
        divider: true,
        model: false,
        children: [
            {
                icon: mdiSquareMedium,
                title: "Utilisateur",
                link: "/users",
                permissions: "manage_system",
            },
            {
                icon: mdiSquareMedium,
                title: "Role",
                link: "/roles",
                permissions: "manage_system",
            },
            {
                icon: mdiSquareMedium,
                title: "Permission",
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
}