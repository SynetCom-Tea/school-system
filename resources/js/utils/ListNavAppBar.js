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
     console.log('listNav:', page)
    let tabs = [];
    let enfants = [];
    let tab,tab_s = [];
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

  //  Début de menu pre-configs
    if (page?.roles[0] == "Administrateur") {

      if (page?.sections[0]?.sections) {
        tabs = page?.sections[0].sections.map(function (el) {
          return el.libelle;
        });
      }
    }

    if (tabs.length!=0) {

        sections.forEach((section) => {

          if (tabs.includes(section.title)) {

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

  // Fin de menu pre-configs
    if (page?.roles[0]== "Enseignant") {
      if (page?.section_users[0]?.libelle) {
        tab_s = page?.section_users.map(el =>el.libelle);
      }
    }

    if (tab_s != []) {
        section_users.forEach((s) => {

          if (tab_s.includes(s.title)) {

            section_user.push(s);
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


    if (tab != []) {
        section.forEach((sect) => {

          if (tab.includes(sect.title)) {

          enfant.push(sect);
        }
      });
    }
       }
MenuGestion = {
      icon: mdiCogOutline,
      title: "Post Configs",
      "icon-alt": mdiChevronLeft,
      model: false,
      children: enfant,
}

//Fin du menu des cruds

    let pageSections = page.sections? page.sections[0]?.sections:null

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
                listMenusSections.push({
                    icon: iconSection,
                    title: element.libelle,
                    model: false,
 children:childrenBySection
                })
            }
        })
    }

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

let superAdminMenus=[]

    if (page?.roles[0] != "Super-administrateur") {
           singleItems = singleItems.filter(el => el.title != "Établissements")
    }
  if (page?.roles[0] == "Super-administrateur") {
   superAdminMenus.push(usersMenu)
  }

    return [singleItems,listMenusSections,MenuAdmin,MenuGestion,MenuEvaluation,superAdminMenus]
}