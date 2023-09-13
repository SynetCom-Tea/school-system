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
  mdiChevronLeft,
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
  mdiCalendar,
} from "@mdi/js";
export function listMenus(page) {
    // console.log('this.$page.props.roles:', page)
      let tabs = [];
    let enfants = [];
    let MenuAdmin;
    const sections = [
      { title: "Primaire", icon: mdiSchool, link: "/enseignement/configuration/1" },
      { title: "Secondaire", icon: mdiSchool, link: "/enseignement/configuration/2" },
      { title: 'Supérieur', icon: mdiSchool, link: '/enseignement/configuration/lmd/3' },
      { title: 'Universitaire', icon: mdiSchool, link: '/enseignement/configuration/lmd/4' },
    ];

    if (page?.roles == "Administrateur") {

      if (page?.sections[0]?.sections) {
        tabs = page?.sections[0].sections.map(function (el) {
          return el.libelle;
        });
      }
    }

    if (tabs != []) {
        sections.forEach((section) => {
            //   console.log('ele:',section)
          if (tabs.includes(section.title)) {
            // console.log('herre22')
          enfants.push(section);
        }
      });
    }
MenuAdmin = {
      icon: mdiCogOutline,
      title: "Configurations",
      "icon-alt": mdiChevronLeft,
      model: false,
      children: enfants,
}


    let singleItems = [
        {
            title: "Profil",
            icon: mdiAccount,
            link: "/profile",
            permissions: "manage_school",
        },
        {
            icon: mdiSchool,
            title: "Établissements",
            link: "/etablissements",
            permissions: "manage_system",
        },
        /* {
            title: "Home",
            icon: mdiHomeCity,
            link: "/dashboard",
            permissions: "manage_system",
        },
        // {
        //     title: "Test",
        //     icon: mdiCogOutline,
        //     link: "/enseignement/test",
        //     permissions: "manage_system",
        // },
        // {
        //     title: "Attribution de notes",
        //     icon: mdiReceiptTextCheckOutline,
        //     link: "/receptions",
        //     permissions: "manage_system",
        // },
        {
            title: "Evaluation",
            icon: mdiCogOutline,
            link: "/gestionnote/evaluation",
        },
        {
            title: "Inscription",
            icon: mdiAccountSchool,
            link: "/inscriptions/create",
            permissions: "manage_system",
        }, */
    ];

    let usersMenu = {
        icon: mdiAccountCogOutline,
        title: "Gestion Utilisateurs",
        "icon-alt": mdiChevronDown,
        permissions: "manage_system",
        model: false,
        children: [
            {
                icon: mdiSquareMedium,
                title: "Liste utilisateurs",
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
                link: "/gestionnote/note/affichage",
                permissions: "manage_system",
            },
            {
                icon: mdiWalletMembership,
                title: "Attribution de notes",
                link: "/gestionnote/note/attribution",
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
                title: "Établissements",
                link: "/organizations",
                permissions: "manage_system",
            },
            {
                icon: mdiCalendar,
                title: "Années Scolaires",
                link: "/annees",
                permissions: "manage_system",
            },

            {
                icon: mdiGoogleClassroom,
                title: "Niveaux",
                link: "/niveaux",
                permissions: "manage_system",
            },
            {
                icon: mdiGoogleClassroom,
                title: "Salle de cours",
                link: "/salles",
                title: "Attribution de notes",
                link: "/gestionnote/note/attribution",
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
        // children: [
        //     {
        //         icon:mdiGoogleClassroom,
        //         title: "Généralités",
        //         link: "/manage-welcome",
        //         permissions: "manage_welcome",
        //     },
        //     {
        //         icon: formsAppsScriptOutlineRounded,
        //         title: "Formulaires",
        //         link: "/manage-welcome/forms",
        //         permissions: "manage_welcome",
        //     },
        //     {
        //         icon: articlesIcon,
        //         title: "Articles",
        //         link: "/manage-welcome/articles",
        //         permissions: "manage_welcome",
        //     },
        // ],
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
                link: "/emploi/emplois/create",
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

    let admin = {
        icon: mdiTimetable,
        title: "Configurations",
        "icon-alt": mdiChevronDown,
        // permissions: "manage_system",
        model: false,
        children: [
            {
                icon: mdiGift,
                title: "Config 1",
                link: "/enseignement/test",
                // permissions: "manage_system",
            },
            {
                icon: mdiWalletMembership,
                title: "Config 2",
                link: "/emploi/emplois/create",
                // permissions: "manage_system",
            },
            // {
            //     icon: mdiSquareMedium,
            //     title: "Permissions",
            //     link: "/permissions",
            //     permissions: "manage_system",
            // },
        ],
    };
       if (page?.roles == "Administrateur") {
         singleItems= singleItems.filter(el=>el.title!="Établissements")
    }
    return [singleItems,usersMenu,configsMenu,welcomeMenu, emploiMenu,MenuAdmin]
}
