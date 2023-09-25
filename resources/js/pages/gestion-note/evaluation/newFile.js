import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/vue3';

export default (await import('vue')).defineComponent({
components: {
// Datatable,
mdiAccountSchool,
mdiPlus,
mdiPencil,
mdiDelete,
mdiPlusCircle,
mdiClipboardEditOutline,
mdiTools,
mdiCloseCircle,
mdiCheckCircle,
mdiPercentOutline,
mdiTimelineAlert,
mdiContentSaveEditOutline
},
layout: AuthenticatedLayout,
props: ["evaluations", "periodes", "typeEvaluations", "enseigements", "sections", "nivau_matieres", "enseignant"],
data() {
return {
icon: {
mdiAccountSchool,
mdiPlus,
mdiPencil,
mdiDelete,
mdiPlusCircle,
mdiClipboardEditOutline,
mdiTools,
mdiCloseCircle,
mdiCheckCircle,
mdiPercentOutline,
mdiTimelineAlert,
mdiContentSaveEditOutline
},

headers: [
{
title: "N°",
align: 'center',
key: 'id'
},
{
title: 'Matière',
align: 'center',
key: 'enseignement_annee.niveau_matiere.matiere.libelle',
},
{
title: 'Niveau/Classe',
align: 'center',
key: 'enseignement_annee.niveau_matiere.niveau.libelle'
},
{
title: 'Enseignant',
align: 'center',
key: 'enseignement_annee.enseignant.nom'
},
{
title: 'Date Evaluation',
align: 'center',
key: 'date'
},
{
title: 'Type Evaluation',
align: 'center',
key: 'type_evaluation.libelle'
},
{
title: 'periodes',
align: 'center',
key: 'periode.libelle'
},
{
title: 'Pourcentage',
align: 'center',
key: 'pourcentage'
},
{
title: 'Actions',
align: 'center',
key: 'actions'
},
],

dialog_title: 'Nouveau Evaluation',
dialog: false,

form: useForm({
date: '',
pourcentage: null,
type_evaluation_id: null,
periode_id: null,
enseignement_annee_id: null,
}),
};
},

methods: {
create() {
this.dialog = true;
this.dialog_title = 'Nouveau Evaluation';
console.log(this.sections);
},
editItem(item) {
console.log('edit', item);
this.dialog_title = 'Modifier Evaluation ' + item.id;
this.form.id = item.id;
this.form.date = item.date;
this.form.pourcentage = item.pourcentage;
this.form.periode_id = item.periode_id;
this.form.type_evaluation_id = item.type_evaluation_id;
this.form.enseignement_annee_id = item.enseignement_annee_id;
this.dialog = true;
},
deleteItem(item) {
this.$swal({
title: 'Es-tu sûr?',
text: "Vous ne pourrez pas revenir en arrière !",
icon: 'warning',
showCancelButton: true,
confirmButtonColor: 'orange',
cancelButtonColor: '#d33',
confirmButtonText: 'Oui, supprimez-le!',
cancelButtonText: 'Non, annulez !',
}).then((result) => {
if (result.isConfirmed) {

this.form.delete(route('evaluation.destroy', item.id), {
onFinish: () => {
if (this.$page.props.flash?.message?.type == 'error') {
this.$swal({
icon: 'error',
title: 'Suppression',
text: this.$page.props.flash?.message?.text,
toast: true,
position: 'top-end',
showConfirmButton: false,
timer: 5000,
timerProgressBar: true,
});
} else if (this.$page.props.flash?.message?.type == 'success') {
this.$swal({
icon: 'success',
title: 'Suppression',
text: this.$page.props.flash?.message?.text,
toast: true,
position: 'top-end',
showConfirmButton: false,
timer: 5000,
timerProgressBar: true,
});
}
},
});
}
});
},
async submit() {
const {
valid
} = await this.$refs.form.validate();
if (!this.form.id && valid) {
// console.log(this.form)
this.form.post(route('evaluation.store'), {
onFinish: () => {
this.close();
this.$swal({
icon: 'success',
title: 'Enregistrement',
text: 'Evaluation créée avec succès!',
toast: true,
position: 'top-end',
showConfirmButton: false,
timer: 5000,
timerProgressBar: true,
});
},
});
} else if (this.form.id && valid) {
const {
date, pourcentage, periode_id, type_evaluation_id, enseignement_annee_id
} = this.form;

this.form.put(route('evaluation.update', this.form.id), {
onFinish: () => {
this.close();
this.$swal({
icon: 'success',
title: 'Enregistrement',
text: 'Evaluation modifié avec succès!',
toast: true,
position: 'top-end',
showConfirmButton: false,
timer: 5000,
timerProgressBar: true,
});
},
});
}

},
close() {
this.form.id = "";
this.form.date = "";
this.form.pourcentage = "";
this.form.periode_id = "";
this.form.type_evaluation_id = "";
this.form.enseignement_annee_id = "";
this.dialog = false;
},
setPeriode(e) {
// console.log(e)
this.form.periode_id = null;
this.$inertia.replace(this.$page.url, {
data: {
section_id: e,
},
});
}
}
});
