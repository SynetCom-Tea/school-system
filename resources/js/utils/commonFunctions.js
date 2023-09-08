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