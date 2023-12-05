<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {
    router,
    useForm
} from "@inertiajs/vue3";
import {
    mdiPlus,
    mdiSchool,
    mdiAccountSchool,
    mdiCheckCircle,
    mdiCancel,
   mdiGoogleClassroom,
    mdiPlusCircle,
    mdiCloseCircle,
    mdiContentSave
} from '@mdi/js'
export default {
    layout: AuthenticatedLayout,
    props: ["section_id", "niveaux","filieres"],
    data() {

        return {

        tooltipModel: false,
        alertFirst: true,
        alertSecond: true,
            icon: {
                mdiPlus,
                mdiSchool,
                mdiAccountSchool,
                mdiCheckCircle,
                mdiCancel,
                mdiGoogleClassroom,
                mdiPlusCircle,
                mdiCloseCircle,
                mdiContentSave
            },

            form: useForm({
                donnees: []
            }),
        }
    },
    mounted() {
        this.addRow()
    },
    methods: {
        onclickAlertButton(type) {
            if (type == "second") {
                this.alertSecond = true;
            }
            if (type == "first") this.alertFirst = true;
        },
        goBack() {
            router.get(route('classes.index', this.section_id))
        },
        addRow() {
            this.form.donnees.push({
                niveau_id: null,
                filiere:null,
                niveaux:[],
                option: null,
                nombre: null,
                before: null,
                after: null
            });
            let data = this.form.donnees[this.form.donnees.length - 1];
            // this.addChild(data);
        },
        // addChild(donnee) {
        //     donnee.enfants.push({
        //         code: null,
        //         libelle: null,
        //         before: null,
        //         after: null
        //     })
        // },

        removeRow(classe) {
       this.form.donnees = this.form.donnees.filter((el) => el !== classe);
     },
     async verify(classe) {
       const array = this.form.donnees.filter(
         (el) => el.niveau_id !== null && el.niveau_id == classe.niveau_id
       );
       if (array.length > 1) {
         this.removeRow(classe);
         this.$swal("L'élément existe déjà !");
       }
     },
        // removeRow(p) {
        //     this.form.donnees = this.form.donnees.filter((product) => product !== p)
        // },
        // removeChild(p,enfant) {
        //     p.enfants = p.enfants.filter((product) => product !== enfant)
        // },
        // async verify(p) {
        //     const array = this.form.donnees.filter((el) => el.niveau_id !== null && el.niveau_id == p.niveau_id)
        //     if (array.length > 1) {
        //        this.removeRow(p)
        //         this.$swal({
        //                         icon: 'error',
        //                         title: 'Erreur',
        //                         text: 'Ce niveau existe déjà!',
        //                         toast: true,
        //                         position: 'top-end',
        //                         showConfirmButton: false,
        //                         timer: 5000,
        //                         timerProgressBar: true,
        //                     });
        //     } else {
        //         return true
        //     }
        // },
        // async verifyChild(p,enfant) {
        //     const array = p.enfants.filter((el) => el.libelle !== null && el.libelle == enfant.libelle || el.code == enfant.code)
        //     if (array.length > 1) {
        //        this.removeChild(p,enfant)
        //         this.$swal({
        //                         icon: 'error',
        //                         title: 'Erreur',
        //                         text: 'Cette classe existe déjà!',
        //                         toast: true,
        //                         position: 'top-end',
        //                         showConfirmButton: false,
        //                         timer: 5000,
        //                         timerProgressBar: true,
        //                     });
        //     } else {
        //         return true
        //     }
        // },
        async submit() {
            const {
                valid
            } = await this.$refs.form.validate()
            if (valid) {
                console.log(this.form)
                this.$swal({
                    title: 'Etês-vous sûr de vouloir enregistrer?',
                    text: "Vous ne pourrez pas revenir en arrière !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#004980',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, Enregistrer !',
                    cancelButtonText: 'Non, annulez !',
                    }).then((result) => {
                    if (result.isConfirmed) {
                        this.form.post(route('classes.store',this.section_id), {
                            onFinish: () => {
                                this.close()
                                this.$swal({
                                    icon: 'success',
                                        iconColor: '#004980',
                                        color: '#004980',
                                        title: 'Enregistrement',
                                        text: 'Classes créées avec succès!',
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 5000,
                                        timerProgressBar: true,
                                });
                            },
                        });
                    }
                })
            }
        },
        close() {
                this.form.reset()
            }
    },


    computed: {
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

    }
}
</script>
<template>
     <Toolbar
      styleToolbar="background-color: white;"
      :icon="icon.mdiSchool"
      :toolbarTitle="Title"
    ></Toolbar>
    <br>
    <!-- <Toolbar :icon="icon.mdiGoogleClassroom" toolbarTitle="Création Classes"></Toolbar> -->
<v-card variant="outlined" style="border: 2px solid #7d002c">
    <v-card-title style="color: white; background-color: #7d002c">Création Classes</v-card-title>
            <v-divider></v-divider>
            <br />

            <div style="margin: 10px">
                <v-alert v-model="alertFirst" border="start" variant="tonal" closable close-label="Close Alert" color="primary" type="info" title="Information">
                    <li v-if="section_id <=2">
                        Cette section vous permet de créer les classes de façon automatique en renseignant les nombres et la notation souhaiter par niveau  dans cet
                        établissement
                    </li>
                    <li v-if="section_id >=3">
                        Cette section vous permet de créer les Niveaux de façon automatique en renseignant les nombres souhaiter  dans cet
                        établissement
                    </li>
                    <li>
                        Le formulaire sera valide <strong>si et seulement si </strong>tous les
                        champs obligatoires marqués par <span style="color: red">*</span> sont
                        renseignés
                    </li>
                </v-alert>

                <div v-if="!alertFirst" style="margin: auto; width: 50%; padding: 10px">
                    <Button  size="large" style="height: 30px" title="Plier la note" @click="onclickAlertButton('first')" variant="outlined" color="primary" nameButton="Relire la note">
                    </Button>
                </div>
            </div>
    <v-card-text>
        <v-card>
        <v-form ref="form">

                    <v-row  :key="donnee.id" v-for="(donnee, i) in form.donnees">
                        <v-col cols="1" md="1"></v-col>
                                <v-col cols="4" md="4" style="height: 90px" v-if="section_id >=3">
                                    <Autocomplete
                                        label="Cycle/Filière"
                                        :items="filieres"
                                        placeholder="Cycle/Filière"
                                        variant="outlined"
                                        item-value="id"
                                        class="mt-2"
                                        item-title="code"
                                        v-model="donnee.filiere"
                                        isRequired
                                        chips
                                        :rules="[(v) => !!v || 'Ce champ est requis!']"
                                            @update:modelValue=" verify(donnee)"
                                        >
                                    ></Autocomplete>
                                </v-col>
                                <v-col cols="3" md="3" style="height: 80px" v-if="section_id <=2">
                                     <Autocomplete
                                        label="Niveau"
                                        :items="niveaux"
                                        placeholder="Niveau"
                                        variant="outlined"
                                        item-value="id"
                                        class="mt-2"
                                        item-title="libelle"
                                        v-model="donnee.niveau_id"
                                        isRequired
                                        chips
                                        :rules="[(v) => !!v || 'Ce champ est requis!']"
                                        @update:modelValue=" verify(donnee)"
                                        >
                                    ></Autocomplete>

                                </v-col>

                                <v-col cols="3" md="3" style="height: 80px" v-if="section_id <=2">
                                        <Autocomplete
                                            v-model="donnee.option"
                                            :isRequired="true"
                                            itemTitle="Option"
                                            class="mt-2"
                                            placeholder="Option"
                                            label="Option"
                                            :items="['Alphabet', 'Numérique']"
                                            chips
                                            :rules="[(v) => !!v || 'Ce champ est requis!']"
                                            @update:modelValue=" verify(donnee)"
                                        >
                                        </Autocomplete>
                                        <!-- <text-field label="Genre" placeholder="Genre" v-model="form.sex" isRequired :rules="rules"></text-field> -->
                                        </v-col>
                                        <v-col cols="3" md="3" style="height: 80px" v-if="section_id <=2">
                                            <text-field
                                                type="number"
                                                label="Nonbre des classes"
                                                class="mt-2"
                                                placeholder="Nonbre des classes"
                                                v-model="donnee.nombre"
                                                isRequired
                                                :rules="[(v) => !!v || 'Ce champ est requis!']"
                                                @update:modelValue=" verify(donnee)"
                                            ></text-field>
                                            </v-col>
                                            <v-col cols="5" md="5"  v-if="section_id >=3">
                                                <Autocomplete
                                                    label="Niveau"
                                                    :items="niveaux"
                                                    placeholder="Niveau"
                                                    variant="outlined"
                                                    item-value="id"
                                                    class="mt-2"
                                                    item-title="libelle"
                                                    v-model="donnee.niveaux"
                                                    multiple
                                                    chips
                                                    isRequired
                                                    :rules="[(v) => !!v || 'Ce champ est requis!']"
                                                    @update:modelValue=" verify(donnee)"
                                                    >
                                                ></Autocomplete>
                                            </v-col>
                                <v-col md="2">
                                    <br>
                                    <Button  size="large" title="supprimer le niveau et ses classes" variant="outlined" :disabled="!(form.donnees.length > 1)" icon @click="removeRow(donnee)" fab small color="error">
                                        <v-icon :icon="icon.mdiCloseCircle"></v-icon>
                                    </Button>
                                </v-col>

                            </v-row>
                            <v-row>
                                <v-col md="10">
                                </v-col>
                                <v-col md="2">
                                    <Button  size="large" title="ajouter un niveau" variant="outlined" icon @click="addRow()" fab small color="primary">
                                        <v-icon :icon="icon.mdiPlusCircle"></v-icon>
                                    </Button>
                                </v-col>
                            </v-row>
        </v-form>
        <br>
        </v-card>
        </v-card-text>
        <v-card-actions class="justify-end">
      <v-spacer></v-spacer>
      <Button   variant="outlined" class="mb-2" style="height: 30px"  type="button" color="red" @click="goBack">
        <v-icon :icon="icon.mdiCancel" left></v-icon> Annuler
      </Button>
      <Button variant="outlined" class="mb-2" style="height: 30px"   color="primary" @click="submit">
        <v-icon :icon="icon.mdiContentSave" left></v-icon> Enregistrer
      </Button>
    </v-card-actions>
</v-card>
</template>
