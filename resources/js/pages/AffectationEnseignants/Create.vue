<template>
     <Toolbar
      styleToolbar="background-color: white;"
      :icon="icons.mdiSchool"
      :toolbarTitle="Title"
    ></Toolbar>
    <form @submit.prevent="submitForm" novalidate>
      <v-container fluid>
        <v-card variant="outlined" style="border: 2px solid #7d002c">
          <v-card-title style="color: white; background-color: #7d002c"
            >AFFECTATION DES MATIÈRES ET CLASSES AUX ENSEIGNANTS</v-card-title
          >
          <v-divider></v-divider>
          <br />
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
                Cette section vous permet d'attribuer les matières et classes aux enseignants
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
            <v-row>
              <v-col md="1"></v-col>
              <v-col md="4">
                <Autocomplete
                  label="Enseignant"
                  class="mt-2"
                  item-title="NomComplet"
                  placeholder="Enseignant"
                  item-value="id"
                  isRequired
                  :items="enseignants"
                  v-model="form.enseignant"
                  :rules="[(v) => !!v || 'Ce champ est requis!']"
                  @update:modelValue="submitForm(any)"
                  chips
                >
                </Autocomplete>
              </v-col>
              <v-col cols="6" md="6" v-if="section_id=='1'">
              <v-switch
                v-model="form.importation"
                color="#004980"
                inset
                :label="'Attribution des matières par classe'"
              ></v-switch>
            </v-col>
            </v-row>
            <!-- <v-divider></v-divider> -->
            <v-card class="mx-auto" max-width="1000">

              <v-card-text v-if="!form.importation">
                <!-- <v-divider></v-divider> -->

                <v-row disabled :key="matiere.id" v-for="(matiere, i) in form.matieres">
                  <v-col md="1"></v-col>
                  <v-col md="4">
                    <Autocomplete
                      label="Matière"
                      placeholder="Matière"
                      class="mt-2"
                      item-title="code"
                      item-value="id"
                      isRequired
                      :items="matieres"
                      chips
                      v-model="matiere.matiere"
                      :rules="[(v) => !!v || 'Ce champ est requis!']"
                      @update:modelValue="submitForm(matiere),setclasses(i)"

                    >
                    </Autocomplete>
                  </v-col>

                  <v-col md="4">
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
                        :items="classetabs[i]"
                        @click="classeset(i)"
                        :rules="[(v) => !!v || 'Ce champ est requis!']"
                        @update:modelValue="submitForm(matiere)"
                        >
                    </Autocomplete>
                  </v-col>
                  <v-col md="1">
                    <br />
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
                  <v-col offset-md="11" cols="4">
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
              </v-card-text>

              <v-card-text v-if="form.importation">
                <!-- <v-divider></v-divider> -->

                <v-row disabled :key="classe.id" v-for="(classe, i) in form.classes">
                  <v-col md="1"></v-col>
                  <v-col md="4">
                    <Autocomplete
                      label="Classes"
                      placeholder="Classes"
                      class="mt-2"
                      item-title="classe.libelle"
                      item-value="id"
                      isRequired
                      :items="classe_annees"
                      chips
                      v-model="classe.classe"
                      :rules="[(v) => !!v || 'Ce champ est requis!']"
                      @update:modelValue="submitForm(classe),setmatiere(i)"

                    >
                    </Autocomplete>
                  </v-col>

                  <v-col md="4">
                    <Autocomplete
                        v-model="classe.matieres"
                        isRequired
                        itemValue="id"
                        class="mt-2"
                        itemTitle="code"
                        placeholder="Matière"
                        label="Matière"
                        multiple
                        chips
                        :items="niveau_matieres"
                        :rules="[(v) => !!v || 'Ce champ est requis!']"
                        @update:modelValue="submitForm(classe)"
                        >
                    </Autocomplete>
                  </v-col>
                  <v-col md="1">
                    <br />
                    <Button
                      type="button"
                      variant="outlined"
                      :disabled="!(form.classes.length > 1)"
                      icon
                      @click="removeRowc(classe)"
                      size="large"
                      small
                      color="error"
                    >
                      <v-icon :icon="icons.mdiCloseCircle"></v-icon>
                    </Button>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col offset-md="11" cols="4">
                    <Button
                      type="button"
                      variant="outlined"
                      @click="addRowc"
                      icon
                      size="large"
                      color="primary"
                    >
                      <v-icon :icon="icons.mdiPlusCircle" small></v-icon>
                    </Button>
                  </v-col>
                </v-row>
              </v-card-text>
            </v-card>
          </v-card-text>
          <v-card-actions class="justify-end">
      <v-spacer></v-spacer>
      <Button variant="outlined" class="mb-2" style="height: 30px" small type="button" color="red" @click="goBack">
        <v-icon :icon="icons.mdiCancel" left></v-icon> Annuler
      </Button>
      <Button variant="outlined" class="mb-2" style="height: 30px" small color="primary" @click="submit">
        <v-icon :icon="icons.mdiContentSave" left></v-icon> Enregistrer
      </Button>
    </v-card-actions>
        </v-card>
      </v-container>
    </form>
  </template>
  <script>
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
  import { router, useForm } from "@inertiajs/vue3";
  import { mdiCloseCircle, mdiPlusCircle, mdiInformation,mdiCancel,mdiCheckCircle,mdiContentSave } from "@mdi/js";
import axios from "axios";
  export default {
    layout: AuthenticatedLayout,
    props: ["matieres","section_id", "classes", 'enseignants', 'classe_annees','niveau_matieres'],
    components: {
      mdiPlusCircle,
      mdiCloseCircle,
      mdiInformation,
      mdiCancel,
      mdiCheckCircle,
      mdiContentSave
    },
    data: () => ({
      alertFirst: true,
      alertSecond: true,

      icons: { mdiPlusCircle, mdiCloseCircle, mdiInformation ,mdiCancel,mdiCheckCircle,mdiContentSave},
      step: 1,

      section: null,
        classetabs:{},
        tab:[],
      form: useForm({
        enseignant: null,
        importation: false,
        matieres: [],
        classes: [],
      }),
    }),

    methods: {

        // setmatiere(){
        //     console.log('enseignant',this.form.enseignant);
        //     this.matieres=[];
        //     this.$emit('input',this.form.enseignant)
        //     let eng=this.form.enseignant;
        //     router.replace(this.$page.url,{data:{enseignant:eng}});
        //     console.log('fdgfggg',this.matieres);


        //     },


            setmatiere(i){
            console.log('classes',this.form.classes[i].classe);
            // this.form.matieres[i].classes=[];
           this.$emit('input',this.form.classes[i].classe)
           let classes=this.form.classes[i].classe;
           router.replace(this.$page.url,{data:{ classes: classes}});
           console.log('fdgfggg',this.niveau_matieres);


       },
        setclasses(i){
            this.form.matieres[i].classes=[];
            this.$emit('input',this.form.matieres[i].matiere)
            let mat=this.form.matieres[i].matiere;
            router.replace(this.$page.url,{data:{matiere:mat}});
            // console.log(' routechech', routechech);


        },

        classeset(i){

          if(this.tab.length==0)
           {
            this.classetabs[i]=this.classes;
            this.tab[i]=this.form.matieres[i].matiere;
          }else if(this.tab[i]!=this.form.matieres[i].matiere){
            this.classetabs[i]=this.classes;
            this.tab[i]=this.form.matieres[i].matiere;
            console.log('i',this.tab[i]!=this.form.matieres[i].matiere);
          }
            console.log('fdgfggg',this.classetabs);

        },
        goBack() {
            router.get(route('AffectationEnseignants.index', this.section_id))
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
          this.form.classes = [];
          this.addRow();
        }
      },
      async submitForm(element) {
        if(this.form.importation==false){
        await this.verify(element);
        await this.isValid();
        }else{
            await this.verifyc(element);
            await this.isValidc();
        }
        this.form.etablissement_section_id = this.$page.props.sections.find(
          (el) => el.section == this.section
        );
        this.$emit("formSubmitted", this.form);
        this.$emit("niveauMatiereFormValid", this.isValid());
        this.$emit("niveauMatiereFormValid", this.isValidc());
      },
      async isValid() {
        let valid = false;
       if (
          !this.form.matieres.find(
            (el) =>
              this.form.enseignant == null ||
              this.form.enseignant == "" ||
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

      async isValidc() {
        let valid = false;
       if (
          !this.form.classes.find(
            (el) =>
              this.form.enseignant == null ||
              this.form.enseignant == "" ||
              this.form.classes == null ||
              this.form.classes == "" ||
              el.classe == null ||
              el.classe == "" ||
              el.matieres == "" ||
              el.matieres == null
          )
        ) {
            valid = true;
        }

        return valid;
      },
      addRowc() {
        this.form.classes.push({
            classe: null,
            matieres: [],
          after: null,
        });
      },
      removeRowc(classe) {
        this.form.classes = this.form.classes.filter((el) => el !== classe);
      },
      async verifyc(classe) {
        const array = this.form.classes.filter(
          (el) => el.classe !== null && el.classe == classe.classe
        );
        if (array.length > 1) {
          this.removeRowc(classe);
          this.$swal("L'élément existe déjà !");
        }
      },
      async submit() {
            console.log('enseignant',this.form.enseignant,'matiere', this.form.matieres);
        if(this.form.importation==false){
            if (await this.isValid()) {
                console.log(this.form)
                this.form.post(route('AffectationEnseignants.store',this.section_id), {
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
        }else{
            console.log('form',this.form)
            if (await this.isValidc()) {

                this.form.post(route('AffectationEnseignants.store',this.section_id), {
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
        }
        },
    },
    created() {},
    mounted() {
      this.addRow();
      this.addRowc();
      this.section = this.getSection(this.section_id);
    },

    computed: {


        itemsClasses() {
      let list = [];

      if (this.classes) {
        this.classes.forEach((element) => {
          if (element) {
            element.forEach((element2) => {
                if(element2){
                    console.log('element',element2);
                    list.push({
                    ...element2,
                    code_libelle: element2.classe.libelle,
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
