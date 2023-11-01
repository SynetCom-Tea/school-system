// noteProcessing.js
export function processNotesData(notesArray) {
    console.log(notesArray)
    const apprenants = {};
    notesArray.forEach(note => {
        if (!apprenants[note.id_apprenant]) {
            apprenants[note.id_apprenant] = {
                nom_apprenant: note.nom_apprenant,
                prenom_apprenant: note.prenom_apprenant,
                moyenne: 0,
                count: 0,
                totalNotes: 0,
            };
        }
  
        if (!isNaN(note.note)) {
            apprenants[note.id_apprenant].totalNotes += note.note;
            apprenants[note.id_apprenant].count++;
        }
  
        apprenants[note.id_apprenant][note.nom_matiere] = note.note;
    });
  
    // Calcul de la moyenne pour chaque apprenant
    Object.values(apprenants).forEach(apprenant => {
        if (apprenant.count > 0) {
            apprenant.moyenne = (apprenant.totalNotes / apprenant.count).toFixed(2);
        }
    });
  
    return Object.values(apprenants);
  }
  