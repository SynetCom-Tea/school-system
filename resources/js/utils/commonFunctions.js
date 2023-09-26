export   async function  getAcademicYears() {
      let axiosResult = [];
      axiosResult = await axios
        .get(
          route("getUsersByCategory", {
            params: "allyears",
          })
        )
        .then((res) => {
          if (typeof res.data == "string" || typeof res.data == "undefined") {
            this.$toast.error("Données non valides!");
          } else {
            return res.data;
          }
        });
      return axiosResult ?? [];
    }

export async function getNiveauxPrimaire() {
      let axiosResult = [];
      axiosResult = await axios
        .get(
          route("getUsersByCategory", {
            params: "primaireClasses",
          })
        )
        .then((res) => {
          if (typeof res.data == "string" || typeof res.data == "undefined") {
            this.$toast.error("Données non valides!");
          } else {
            return res.data;
          }
        });
      return axiosResult ?? [];
    }
export async function  getNiveauxSecondaire() {
      let axiosResult = [];
      axiosResult = await axios
        .get(
          route("getUsersByCategory", {
            params: "secondaireClasses",
          })
        )
        .then((res) => {
          if (typeof res.data == "string" || typeof res.data == "undefined") {
            this.$toast.error("Données non valides!");
          } else {
            return res.data;
          }
        });
      return axiosResult ?? [];
    }

export function getTypeEtablissementById(vId) {
  let formatVId = vId ? parseInt(vId) : null
  if (formatVId) {
    if (formatVId == 1) return 'Université'
     if(formatVId==2) return 'École'
      if(formatVId==3) return 'Institut'
  }

}


//Fonction pour autoriser la saisie des chiffres positifs uniquement. Le point est autorisé pour indiquer un nombre à virgule
export function isNumber(e) {
  let char = String.fromCharCode(e.keyCode); // Get the character

  if (/^[0-9.]+$/.test(char)) return true;
  // Match with regex
  else {
    // alert("Les lettres ne sont pas autorisées!!");
    e.preventDefault();
  }
}
//Fonction pour autoriser la saisie des entiers naturels uniquement.
export function isInteger(e) {
  let char = String.fromCharCode(e.keyCode); // Get the character

  if (/^[0-9]+$/.test(char)) return true;
  // Match with regex
  else {

    e.preventDefault();
  }
}
//Fonction pour autoriser la saisie des lettres uniquement.
export function isAlpha(e) {
  let char = String.fromCharCode(e.keyCode); // Get the character
  if (/^[A-Za-z]+$/.test(char)) return true; // Match with regex
  else e.preventDefault(); // If not match, don't add to input text
}
//Fonction pour autoriser la saisie des lettres et entiers uniquement.
export function isAlphaInteger(e) {
  let char = String.fromCharCode(e.keyCode); // Get the character
  if (/^[A-Za-z0-9]+$/.test(char)) return true; // Match with regex
  else e.preventDefault(); // If not match, don't add to input text
}

export function isDateFormat(e) {
      console.log('e:',e)
    let char = String.fromCharCode(e.keyCode); // Get the character
    console.log('char:',char)
    if (/^\d{4}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])$/.test(e)) return true;
    // else e.preventDefault(); // If not match, don't add to input text

}


export function generateColorsForGraph(index) {
  let colors = [
    { number: 1, purple: "rgb(128,0,128)", name: "rgb(128,0,128)" },
    { number: 2, indigo: "rgb(75,0,130)", name: "rgb(75,0,130)" },
    { number: 3, indianred: "rgb(205,92,92)", name: "rgb(205,92,92)" },
    { number: 4, darked: "rgb(139,0,0)", name: "rgb(139,0,0)" },
    { number: 5, darkgreen: "rgb(0,100,0)", name: "rgb(0,100,0)" },
    { number: 6, saddlebrown: "rgb(139,69,19)", name: "rgb(139,69,19)" },
    { number: 7, rosybrown: "rgb(188,143,143)", name: "rgb(188,143,143)" },
    { number: 8, gold: "rgb(255,215,0)", name: "rgb(255,215,0)" },
    { number: 9, darkslategray: "rgb(47,79,79)", name: "rgb(47,79,79)" },
    { number: 10, seagreen: "rgb(46,139,87)", name: "rgb(46,139,87)" },
    { number: 11, darkgoldenrod: "rgb(184,134,11)", name: "rgb(184,134,11)" },
    { number: 12, coral: "rgb(255,127,80)", name: "rgb(255,127,80)" },
    { number: 13, olive: "rgb(128,128,0)", name: "rgb(128,128,0)" },
    { number: 14, chocolate: "rgb(210,105,30)", name: "rgb(210,105,30)" },
    { number: 15, gray: "rgb(128,128,128)", name: "rgb(128,128,128)" },
    { number: 16, mediumvioletred: "rgb(199,21,133)", name: "rgb(199,21,133)" },
    { number: 17, darkblue: "rgb(0,0,0,139)", name: "rgb(0,0,0,139)" },
    { number: 18, lightsalmon: "rgb(255,160,122)", name: "rgb(255,160,122)" },
    { number: 19, darkolivegreen: "rgb(85,107,47)", name: "rgb(85,107,47)" },
    { number: 20, khaki: "rgb(240,230,140)", name: "rgb(240,230,140)" },
    { number: 21, maroon: "rgb(128,0,0)", name: "rgb(128,0,0)" },
    { number: 22, burlywood: "rgb(222,184,135)", name: "rgb(222,184,135)" },
    { number: 23, blue: "rgb(0,0,255)", name: "rgb(0,0,255)" },
    { number: 24, name24: "#9d905c", name: "#9d905c" },
    { number: 25, name25: "#84e0e0", name: "#84e0e0" },
    { number: 26, name26: "#e084c9", name: "#e084c9" },
    { number: 27, name27: "#e0ce84", name: "#e0ce84" },
    { number: 28, name28: "#5c9d9d", name: "#5c9d9d" },
    { number: 29, name29: "#819d5c", name: "#819d5c" },
    { number: 30, name30: "#795c9d", name: "#795c9d" },
    { number: 31, name31: "#b9e084", name: "#b9e084" },
    { number: 32, name32: "#b9e084", name: "#b9e084" },
    { number: 33, name33: "#ffff00", name: "#ffff00" },
    { number: 34, name34: "#ff0000", name: "#ff0000" },
    { number: 35, name35: "#b39e8f", name: "#b39e8f" },
    { number: 36, name36: "#d3ffcc", name: "#d3ffcc" },
    { number: 37, name37: "#b30086", name: "#b30086" },
    { number: 38, name38: "#b30000", name: "#b30000" },
    { number: 39, name39: "#575546", name: "#575546" },
    { number: 40, name40: "#b30000", name: "#b30000" },
    { number: 41, name41: "#4d0000", name: "#4d0000" },
    { number: 42, name42: "#00134d", name: "#00134d" },
    { number: 43, name43: "#363600", name: "#363600" },
    { number: 44, name44: "#360029", name: "#360029" },
    { number: 45, name45: "#ffbc80", name: "#ffbc80" },
    { number: 46, name46: "#361a00", name: "#361a00" },
    { number: 47, name47: "#ffdebf", name: "#ffdebf" },
    { number: 48, name48: "#032600", name: "#032600" },
    { number: 49, name49: " #e0c184", name: "#e0c184" },
    { number: 50, name50: "#002620", name: "#002620" },
    { number: 51, name51: "#000000", name: "#000000" },
     { number: 52, purple: "rgb(128,0,128)", name: "rgb(128,0,128)" },
    { number: 53, indigo: "rgb(75,0,130)", name: "rgb(75,0,130)" },
    { number: 54, indianred: "rgb(205,92,92)", name: "rgb(205,92,92)" },
    { number: 55, darked: "rgb(139,0,0)", name: "rgb(139,0,0)" },
    { number: 56, darkgreen: "rgb(0,100,0)", name: "rgb(0,100,0)" },
    { number: 57, saddlebrown: "rgb(139,69,19)", name: "rgb(139,69,19)" },
    { number: 58, rosybrown: "rgb(188,143,143)", name: "rgb(188,143,143)" },
    { number: 59, gold: "rgb(255,215,0)", name: "rgb(255,215,0)" },
    { number: 60, darkslategray: "rgb(47,79,79)", name: "rgb(47,79,79)" },
    { number: 61, seagreen: "rgb(46,139,87)", name: "rgb(46,139,87)" },
    { number: 62, darkgoldenrod: "rgb(184,134,11)", name: "rgb(184,134,11)" },
    { number: 63, coral: "rgb(255,127,80)", name: "rgb(255,127,80)" },
    { number: 64, olive: "rgb(128,128,0)", name: "rgb(128,128,0)" },
    { number: 65, chocolate: "rgb(210,105,30)", name: "rgb(210,105,30)" },
    { number: 66, gray: "rgb(128,128,128)", name: "rgb(128,128,128)" },
  ];

  if (index) {
    return colors[index].name;
  }
}