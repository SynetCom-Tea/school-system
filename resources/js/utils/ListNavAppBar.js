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
    mdiPrinterPosStar,
    mdiAccountSchoolOutline,
   mdiTimerStar,mdiTimerStarOutline, mdiTimerStopOutline,mdiTimerSyncOutline
} from "@mdi/js";
export function listMenus(page) {
    // console.log('this.$page.props.roles:', page)
    let tabs = [];
    let enfants = [];
    let tab = [];
    let section_user = [];
    let MenuEvaluation;
    let MenuAdmin;
    const sections = [
      { title: "Primaire", icon: mdiSchool, link: "/enseignement/configuration/1" },
      { title: "Secondaire", icon: mdiSchool, link: "/enseignement/configuration/2" },
      { title: 'Supérieure', icon: mdiSchool, link: '/enseignement/configuration/lmd/3' },
      { title: 'Universitaire', icon: mdiSchool, link: '/enseignement/configuration/lmd/4' },
    ];
    const section_users = [
      { title: "Primaire", icon: mdiSchool, link: "/gestionnote/evaluation/1" },
      { title: "Secondaire", icon: mdiSchool, link: "/gestionnote/evaluation/2" },
      { title: 'Supérieur', icon: mdiSchool, link: '/gestionnote/evaluation/3' },
      { title: 'Universitaire', icon: mdiSchool, link: '/gestionnote/evaluation/4' },
    ];
    // console.log(page?.section_users)
    if (page?.role == "Administrateur") {

      if (page?.sections[0]?.sections) {
        tabs = page?.sections[0].sections.map(function (el) {
          return el.libelle;
        });
      }
    }
    if (page?.role == "Enseignant") {
      if (page?.section_users[0]?.libelle) {
        tab = page?.section_users.map(el =>el.libelle);
      }
    }

    if (tab != []) {
        section_users.forEach((s) => {
            //   console.log('ele:',section)
          if (tab.includes(s.title)) {
            // console.log('herre22')
            section_user.push(s);
        }
      });
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
    MenuEvaluation = {
        icon: mdiCogOutline,
        title: "Evaluations",
        "icon-alt": mdiChevronLeft,
        model: false,
        children: section_user,
  }

MenuAdmin = {
      icon: mdiCogOutline,
      title: "Configurations",
      "icon-alt": mdiChevronLeft,
      model: false,
      children: enfants,
}

//Menu pour la gestion des cruds après config

    let enfant = [];
    let MenuGestion;
    const section = [
      { title: "Primaire", icon: mdiSchool, link: "/enseignement/gestion/1" },
      { title: "Secondaire", icon: mdiSchool, link: "/enseignement/gestion/2" },
      { title: 'Supérieure', icon: mdiSchool, link: '/enseignement/gestion/3' },
      { title: 'Universitaire', icon: mdiSchool, link: '/enseignement/gestion/4' },
    ];

    if (page?.roles == "Administrateur") {

      if (page?.sections[0]?.sections) {
        tab = page?.sections[0].sections.map(function (el) {
          return el.libelle;
        });
      }
    }

    if (tab != []) {
        section.forEach((sect) => {
            //   console.log('ele:',section)
          if (tab.includes(sect.title)) {
            // console.log('herre22')
          enfant.push(sect);
        }
      });
    }
MenuGestion = {
      icon: mdiCogOutline,
      title: "Post Configs",
      "icon-alt": mdiChevronLeft,
      model: false,
      children: enfant,
}

//Fin du menu des cruds

    let pageSections = page.sections[0]?.sections
    console.log('pageSections:', pageSections)
    let listMenusSections = []
    let iconSection;
    let childrenBySection = [
      {
                icon: mdiSquareMedium,
                title: "Liste utilisateurs",
                link: "/users",
                permissions: "manage_system",
            },
            {
                icon: mdiSquareMedium,
                title: "Rôles",
                link: "/enseignement/roles",
                permissions: "manage_system",
            },
            {
                icon: mdiSquareMedium,
                title: "Permissions",
                link: "/enseignement/permissions",
                permissions: "manage_system",
            },
        {
            title: "Inscription",
            icon: mdiAccountSchool,
            link: "/inscriptions",
            permissions: "manage_system"},
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
]
    if (pageSections) {
        pageSections.forEach((element, index) => {
            if (element) {
                iconSection = element.id == 1 ? mdiAccountSchoolOutline : element.id == 2 ? mdiTimerStarOutline :
                      element.id==3?mdiTimerSyncOutline:mdiOfficeBuilding
                console.log('element:', element)
                listMenusSections.push({
                    icon: iconSection,
                    title: element.libelle,
                    model: false,
 children:childrenBySection
                })
            }
        })
    }
    console.log('listMenusSections:',listMenusSections)
    let singleItems = [
     {
            title: "Home",
            icon: mdiHomeCity,
            link: "/dashboard",
            roles: "manage_system",
        },
        {
            title: "Profil",
            icon: mdiAccount,
            link: "/profile",
            roles: "manage_school",
        },
        {
            icon: mdiSchool,
            title: "Établissements",
            link: "/etablissements",
            permissions : "manage_system",
        },
    ];
    let singleMenus = singleItems.concat(listMenusSections)
    // console.log('singleMenus:',singleMenus)

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
                link: "/enseignement/roles",
                permissions: "manage_system",
            },
            {
                icon: mdiSquareMedium,
                title: "Permissions",
                link: "/enseignement/permissions",
                permissions: "manage_system",
            },
        ],
    };
    let enseignements = {
        icon: mdiAccountCogOutline,
        title: "Gestions d'Enseignements",
        "icon-alt": mdiChevronDown,
        permissions: "manage_system",
        model: false,
        children: [
            {
                icon: mdiSquareMedium,
                title: "Fillières",
                link: "/enseignement/fillieres",
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


    if (page?.roles != "Super-administrateur") {
           singleItems = singleItems.filter(el => el.title != "Établissements")
    }
    return [singleItems,listMenusSections,MenuAdmin,MenuGestion,MenuEvaluation]
}