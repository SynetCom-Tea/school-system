import articlesIcon from "@iconify-icons/fluent-mdl2/articles";
import formsAppsScriptOutlineRounded from "@iconify-icons/material-symbols/forms-apps-script-outline-rounded";
import {
  mdiTimetable,
  mdiBarn,
  mdiAccountGroup,
  mdiAccount,
  mdiPurse,
  mdiHomeOutline,
  mdiPresentation,
  mdiGift,
  mdiSquareMedium,
  mdiCash,
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
  mdiHumanMaleBoard ,
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
mdiTimerStarOutline,mdiTimerSyncOutline
} from "@mdi/js";
export function listMenus(page) {

    let tabs = [];
    let enfants = [];
    let tab,tab_s = [];
    let section_user = [],notes = [],note = [];
    let MenuEvaluation;
    let MenuAdmin,linkSection,MenuNote;
    const sections = [
      { title: "Primaire", icon: mdiSchool, link: "/enseignement/configuration/1" },
      { title: "Secondaire", icon: mdiSchool, link: "/enseignement/configuration/2" },
      { title: 'Supérieure', icon: mdiSchool, link: '/enseignement/configuration/lmd/3' },
      { title: 'Universitaire', icon: mdiSchool, link: '/enseignement/configuration/lmd/4' },
    ];
    const section_users = [
      { title: "Primaire", icon: mdiSchool, link: "/gestionnote/evaluation/1" },
      { title: "Secondaire", icon: mdiSchool, link: "/gestionnote/evaluation/2" },
      { title: 'Supérieure', icon: mdiSchool, link: '/gestionnote/evaluation/3' },
      { title: 'Universitaire', icon: mdiSchool, link: '/gestionnote/evaluation/4' },
    ];
    const section_notes = [
      { title: "Primaire", icon: mdiSchool, link: "/gestionnote/note/1" },
      { title: "Secondaire", icon: mdiSchool, link: "/gestionnote/note/2" },
      { title: 'Supérieure', icon: mdiSchool, link: '/gestionnote/note/3' },
      { title: 'Universitaire', icon: mdiSchool, link: '/gestionnote/note/4' },
    ];
    // debut gestion note
    if (page?.roles[0]== "Enseignant") {
      if (page?.section_users[0]?.libelle) {
        note = page?.section_users.map(el =>el.libelle);
      }
    }

    if (note != []) {
      section_notes.forEach((s) => {

          if (note.includes(s.title)) {

            notes.push(s);
            // console.log(notes)
        }
      });
    }
    MenuNote = {
      icon: mdiCogOutline,
      title: "Notes",
      "icon-alt": mdiChevronLeft,
      model: false,
      children: notes,
  }
    // Fin gestion note
  //  Début de menu pre-configs
  // console.log(page?.section_users)
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
         permissions:"enseignant",
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

    if (page?.roles[0] == "Administrateur") {

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
            link: "/scolarite/inscriptions",
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
                  element.id == 3 ? mdiTimerSyncOutline : mdiOfficeBuilding
              linkSection = element.id == 1 ? 'gestion/primaire' : element.id == 2 ? 'gestion/secondaire' :
                      element.id==3?'gestion/superieure':'gestion/universitaire'
                listMenusSections.push({
                    icon: iconSection,
                    title: element.libelle,
                  model: false,
                    link:linkSection
//  children:childrenBySection
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
      {
      icon:mdiBarn,
      title: "Rôles/Permissions",
      link: "/enseignement/roles",
      color: "rgb(139,0,0)",
      note: "Ce menu permet d'accèder à la liste des rôles  et permissions",
      expand:false,
      permissions: "manage_system",
    }
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


    let gestionSections = {
        icon: mdiAccountCogOutline,
        title:pageSections?.length>1?"Gestion des sections":'Gestion de la section',
        "icon-alt": mdiChevronDown,
        permissions: "manage_system",
        model: false,
        children: [
      ...listMenusSections
        ],
    };
let superAdminMenus=[]

    if (page?.roles[0] != "Super-administrateur") {
           singleItems = singleItems.filter(el => el.title != "Établissements")
    }
    if ( page?.roles[0] != "Administrateur") {
           singleItems = singleItems.filter(el => el.title != "Rôles/Permissions")
    }
  if (page?.roles[0] == "Super-administrateur") {
   superAdminMenus.push(usersMenu)
  }

  /********************* Menu Gestion des enseignants  ************************ */

  let menuTeachers, childrenTeachers;
  childrenTeachers=[
    {
      icon: mdiAccountGroup,
      title: "Liste des enseignants",
         link: "teachers",
         color: "rgb(205,92,92)",
         note: "Ce menu permet d'accèder à la liste des enseignants de l'établissement",
      expand:false,
      permissions: "enseignant",
    },
    {
      icon: mdiSquareMedium,
      title: "Affectations des enseignants aux classes",
      link: "matching",
      color: "rgb(139,0,0)",
      note: "Ce menu permet d'accèder à la liste des rôles de la section",
      expand:false,
      permissions: "enseignant",
    }]

  menuTeachers= {
        icon: mdiHumanMaleBoard,
        title:"Gestion des enseignants",
        "icon-alt": mdiChevronDown,
        permissions: "enseignant",
        model: false,
        children: [
      ...childrenTeachers
        ],
    };


    /*********************Fin  Menu Gestion des enseignants  ************************ */

    return{singleItems,gestionSections,MenuAdmin,MenuGestion,MenuEvaluation,superAdminMenus, menuTeachers,MenuNote}
}
//Menu par section
export function listMenusBySection(page, sectionID) {
  let result



     let childrenBySection = [
    {
      icon: mdiAccountGroup,
      title: "Liste utilisateurs",
         link: "/users",
         color: "rgb(205,92,92)",
         note: "Ce menu permet d'accèder à la liste des utilisateurs de la section",
      expand:false,
      permissions: "manage_system",
    },

    {
      title: "Inscription",
      icon: mdiAccountSchool,
      link: "/subscribers",
      color: "rgb(128,0,128)",
      note: "Ce menu permet d'accèder à la liste des inscrits de la section",
      expand:false,
      permissions: "manage_system"
    },
    {
      icon: mdiCash,
      title: "Versements",
      link: "versements",
      color: "rgb(24,18,42)",
      note: "Ce menu permet d'effectuer des versements de la section",
      expand:false,
      permissions: "manage_system",
    },
    {
      icon:mdiBookOpenPageVariantOutline,
      title: "Emploi",
      link: "emplois",
      color: "rgb(75,0,130)",
      note: "Ce menu permet d'accèder à la liste des emplois de la section",
      expand:false,
      permissions: "manage_system",
    },
    {
      icon:  mdiCalendar,
      title: "Calendrier",
      link: "emploisCreate",
      color: "#795c9d",
      note: "Ce menu permet d'ajouter un nouvel emploi de temps",
      expand:false,
      permissions: "manage_system",
       },
      {
      title: "Évaluations",
      icon: mdiAccountSchool,
      link: "evaluation",
      color: "#363600",
      note: "Ce menu permet d'accèder aux évaluations  section",
      expand:false,
      permissions: "manage_system"
    },
  ];
  if (page?.roles[0] == "Administrateur") { result= [childrenBySection]}
  return result??[]

}


///Menu du tuteur

export function menusTuteur(page, sectionID) {
  let result
     let childrenBySection = [
    {
      icon: mdiAccountGroup,
      title: "Mes enfants",
         link: "children",
         color: "rgb(205,92,92)",
         note: "Ce menu permet d'accèder à la liste des apprenants sous tutelle",
      expand:false,
      permissions: "tuteur",
    },
    {
      icon: mdiSquareMedium,
      title: "Alertes/Avertissements",
      link: "alertes",
      color: "rgb(139,0,0)",
      note: "Ce menu permet d'accèder à la liste des alertes et avertissements de ses enfants",
      expand:false,
      permissions: "tuteur",
    },
    {
      icon: mdiSquareMedium,
      title: "Réunions",
      link: "meetings",
      color: "rgb(210,105,30)",
      note: "Ce menu permet d'accèder à la liste des reunions",
      expand:false,
      permissions: "tuteur",
    },
    {
      title: "Messagerie",
      icon: mdiAccountSchool,
      link: "mailBox",
      color: "rgb(128,0,128)",
      note: "Ce menu permet d'accèder aux mails envoyés par l'école",
      expand:false,
      permissions: "tuteur"
    },

     ];


      let MTuteur = {
        icon: mdiAccountCogOutline,
        title:"Espace Tuteurs",
        "icon-alt": mdiChevronDown,
        permissions: "tuteur",
        model: false,
        children: [
      ...childrenBySection
        ],
      };
   //if (page?.roles[0] == "Tuteur" && (sectionID==1 || sectionID==2)) { result= MTuteur}
  if (page?.roles[0] == "Tuteur") { result= MTuteur}
  return result??{}

}