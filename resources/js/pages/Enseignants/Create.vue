<template>
     <Toolbar
      styleToolbar="background-color: white;"
      :icon="icons.mdiBookOpenVariant"
      toolbarTitle="Gestion des Enseignants"
    ></Toolbar>
   <form @submit.prevent="submitForm" novalidate>
     <v-container fluid>
       <v-card variant="outlined" style="border: 2px solid #7d002c">
         <v-card-title style="color: white; background-color: #7d002c"
           >Ajouter enseignant</v-card-title
         >
         <v-divider></v-divider>

         <div style="margin: 10px">
           <v-alert
             v-model="alertFirst"
             border="start"
             variant="tonal"
             closable
             close-label="Close Alert"
             color="primary"
             type="info"
             title="Information"
           >
             <li>
               Cette section vous permet d'ajouter un enseignant attribuer les matières et affecter les classes
             </li>
             <li>
               Le formulaire sera valide si et seulement si tous les champs obligatoires
               marqués par <span style="color: red">*</span> sont renseignés
             </li>
           </v-alert>

           <div v-if="!alertFirst" style="margin: auto; width: 50%; padding: 10px">
             <Button
               style="height: 30px"
               title="Plier la note"
               @click="onclickAlertButton('first')"
               variant="outlined"
               color="primary"
               nameButton="Relire la note"
             >
             </Button>
           </div>
         </div>

         <v-divider></v-divider>
         <v-card-text>
               <!-- <v-divider></v-divider> -->
               <v-row style="margin-top: 5px">

                <v-col cols="4" md="4" style="height: 80px">
                  <text-field
                    label="Nom"
                    placeholder="Nom"
                    v-model="form.nom"
                    isRequired
                    class="mt-2"
                    :rules="rules"
                  ></text-field>
                </v-col>
                <v-col cols="4" md="4" style="height: 80px">
                  <text-field
                    label="Prénom"
                    placeholder="Prénom"
                    v-model="form.prenom"
                    isRequired
                    class="mt-2"
                    :rules="rules"
                  ></text-field>
                </v-col>
                <v-col cols="4" md="4" style="height: 90px">
                  <text-field
                    type="date"
                    class="mt-2"
                    label="Date de Naissance"
                    placeholder="Date de Naissance"
                    v-model="form.date_naissance"
                    isRequired
                    :rules="rules"
                  ></text-field>
                </v-col>
                <v-col cols="4" md="4" style="height: 80px">
                  <text-field
                    label="lieu de Naissance"
                    class="mt-2"
                    placeholder="lieu de Naissance"
                    v-model="form.lieu_naissance"
                    isRequired
                    :rules="rules"
                  ></text-field>
                </v-col>
                <v-col cols="4" md="4" style="height: 80px">
                  <Autocomplete
                    v-model="form.sex"
                    :isRequired="true"
                    itemTitle="Genre"
                    class="mt-2"
                    placeholder="Genre"
                    label="Genre"
                    :items="['Masculin', 'Féminin']"
                    :rules="rules"
                  >
                  </Autocomplete>

                </v-col>
                <v-col cols="4" md="4" style="height: 80px">
                  <text-field
                    label="Téléphone"
                    placeholder="Téléphone"
                    v-model="form.telephone"
                    class="mt-2"
                    isRequired
                    :rules="rules"
                  ></text-field>
                </v-col>
                <v-col cols="4" md="4" v-if="form.id == ''" style="height: 80px">
                  <v-switch
                    label="Voulez vous créer un compte pour pour cet enseignant ? "
                    v-model="form.compte"
                    color="info"
                    inset
                  ></v-switch>

                </v-col>
                <v-col
                  cols="4"
                  md="4"
                  v-if="form.id == '' && form.compte == true"
                  style="height: 80px"
                >
                  <text-field
                    label="email"
                    placeholder="email"
                    v-model="form.email"
                    class="mt-2"
                    isRequired
                    :rules="rules"
                  ></text-field>
                </v-col>

                <v-col cols="12" md="12">
                    <v-alert type="info" text> Attribution des matières et affectation des classes à l'enseignant </v-alert>
                </v-col>
                <v-col cols="12" md="12">
               <v-row disabled :key="matiere.id" v-for="(matiere, i) in form.matieres">

                 <v-col cols="5" md="5" style="height: 80px">
                   <Autocomplete
                     label="Matière"
                     placeholder="Matière"
                     class="mt-2"
                     item-title="matiere"
                     item-value="id"
                     isRequired
                     :items="itemsmatieres"
                     chips
                     v-model="matiere.matiere"
                     :rules="rules"
                     @update:modelValue="submitForm(matiere),setclasses(i)"
                   >
                   </Autocomplete>
                 </v-col>

                 <v-col cols="5" md="5" style="height: 80px">
                   <Autocomplete
                       v-model="matiere.classes"
                       isRequired
                       itemValue="id"
                       class="mt-2"
                       itemTitle="classe.libelle"
                       placeholder="Classes"
                       label="Classes"
                       multiple
                       chips
                       :items="classes"
                       :rules="rules"
                       @update:modelValue="submitForm(matiere)"
                       >
                   </Autocomplete>
                 </v-col>
                 <v-col  cols="2" md="2" style="height: 80px">
                    <br>
                   <Button
                     type="button"
                     variant="outlined"
                     :disabled="!(form.matieres.length > 1)"
                     icon
                     @click="removeRow(matiere)"
                     size="large"
                     small
                     color="error"
                   >
                     <v-icon :icon="icons.mdiCloseCircle"></v-icon>
                   </Button>
                 </v-col>
               </v-row>
               <v-row>
                 <v-col offset-md="10" cols="12">
                   <Button
                     type="button"
                     variant="outlined"
                     @click="addRow"
                     icon
                     size="large"
                     color="primary"
                   >
                     <v-icon :icon="icons.mdiPlusCircle" small></v-icon>
                   </Button>
                 </v-col>
               </v-row>
            </v-col>
        </v-row>

         </v-card-text>
         <v-card-actions class="justify-end">
     <v-spacer></v-spacer>
     <v-btn dark small type="button" color="red" @click="goBack">
       <v-icon :icon="icons.mdiCancel" left></v-icon> Annuler
     </v-btn>
     <v-btn small color="primary" @click="submit">
       <v-icon :icon="icons.mdiCheckCircle" left></v-icon> Enregistrer
     </v-btn>
   </v-card-actions>
       </v-card>
     </v-container>
   </form>
 </template>
 <script>
 import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
 import { router, useForm } from "@inertiajs/vue3";
 import { mdiCloseCircle, mdiPlusCircle, mdiInformation,mdiCancel,mdiCheckCircle } from "@mdi/js";
 export default {
   layout: AuthenticatedLayout,
   props: ["matieres","section_id", "classes", 'enseignants'],
   components: {
     mdiPlusCircle,
     mdiCloseCircle,
     mdiInformation,
     mdiCancel,
     mdiCheckCircle
   },
   data: () => ({
     alertFirst: true,
     alertSecond: true,
     icons: { mdiPlusCircle, mdiCloseCircle, mdiInformation ,mdiCancel,mdiCheckCircle},
     step: 1,
     importation: false,
     section: null,
     uetabs: [],
     form: useForm({
        id: "",
        nom: "",
        prenom: "",
        sex: "",
        date_naissance: "",
        lieu_naissance: "",
        telephone: "",
        compte: "",
        email: "",
       matieres: [],
     }),
     rules: [
                        value => {
                            if (value) return true
                            return 'Ce champ est requis!'
                        },
                ],
   }),

   methods: {

       setclasses(i){
            console.log('matiere',this.form.matieres[i].matiere);
            // this.form.matieres[i].classes=[];
           this.$emit('input',this.form.matieres[i].matiere)
           let mat=this.form.matieres[i].matiere;
           router.replace(this.$page.url,{data:{matiere:mat}});
           console.log('fdgfggg',this.classes);


       },
       goBack() {
           router.get(route('enseignants.index'))
       },
     onclickAlertButton(type) {
       if (type == "second") {
         this.alertSecond = true;
       }
       if (type == "first") this.alertFirst = true;
     },
     formatNiveauLabel(item) {
       if (item) {
         return `${item?.code} - ${item?.libelle}`;
       }
     },
     getSection(type) {
       if (type == "1") {
         return "Primaire";
       } else if (type == "2") {
         return "Secondaire";
       } else {
         return "Supérieur";
       }
     },
     resetForm(check) {
       if (check) {
         this.form.matieres = [];
         this.addRow();
       }
     },
     async submitForm(element) {
       await this.verify(element);
       await this.isValid();

       this.form.etablissement_section_id = this.$page.props.sections.find(
         (el) => el.section == this.section
       );
       this.$emit("formSubmitted", this.form);
       this.$emit("niveauMatiereFormValid", this.isValid());
     },
     async isValid() {
       let valid = false;
      if (
         !this.form.matieres.find(
           (el) =>
             this.form.nom == null ||
             this.form.nom == "" ||
             this.form.prenom == null ||
             this.form.prenom == "" ||
             this.form.sex == null ||
             this.form.sex == "" ||
             this.form.date_naissance == null ||
             this.form.date_naissance == "" ||
             this.form.lieu_naissance == null ||
             this.form.lieu_naissance == "" ||
             this.form.telephone == null ||
             this.form.telephone == "" ||
             this.form.matieres == null ||
             this.form.matieres == "" ||
             el.matiere == null ||
             el.matiere == "" ||
             el.classes == "" ||
             el.classes == null
         )
       ) {
           valid = true;
       }

       return valid;
     },
     addRow() {
       this.form.matieres.push({
         matiere: null,
         classes: [],
         after: null,
       });
     },
     removeRow(matiere) {
       this.form.matieres = this.form.matieres.filter((el) => el !== matiere);
     },
     async verify(matiere) {
       const array = this.form.matieres.filter(
         (el) => el.matiere !== null && el.matiere == matiere.matiere
       );
       if (array.length > 1) {
         this.removeRow(matiere);
         this.$swal("L'élément existe déjà !");
       }
     },

     async submit() {
           console.log('enseignant',this.form.enseignant,'matiere', this.form.matieres);
           if (await this.isValid()) {
               console.log(this.form)
               this.form.post(route('enseignants.store'), {
                   onFinish: () => {
                       this.$swal({
                           icon: 'success',
                               iconColor: '#004980',
                               color: '#004980',
                               title: 'Enregistrement',
                               text: 'Affectation a été enrégistré avec succès!',
                               toast: true,
                               position: 'top-end',
                               showConfirmButton: false,
                               timer: 5000,
                               timerProgressBar: true,
                       });
                   },
               });
           }else{
               this.$swal.fire({
               title: "Erreur",
               text:
                 "Veuillez remplir tous les champs du formulaire !",
               icon: "warning",
               confirmButtonText: "OK",
             });

           }
       },
   },
   created() {},
   mounted() {
     this.addRow();
     this.section = this.getSection(this.section_id);
   },

   computed: {

    itemsmatieres() {

        let list = [];

        if (this.matieres) {
        this.matieres.forEach((element) => {
            if (element) {
            element.forEach((element2) => {
                if(element2){
                    // console.log('element',element2);
                    list.push({
                    ...element2,
                        matiere: element2.code,
                    });
                }
            })

            }
        });
        }
        return list ?? [];
        },

       Title() {
       switch (this.section_id) {
           case "1":
           return "SECTION PRIMAIRE";
           case "2":
           return "SECTION SECONDAIRE";
           case "3":
           return "SECTION SUPERIEUR";
           default:
           return "SECTION UNIVERSITAIRE";
       }
       },
   },
 };
 </script>
