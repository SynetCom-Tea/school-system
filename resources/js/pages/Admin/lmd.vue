<template>
    <AuthenticatedLayout>
    <Toolbar
      styleToolbar="background-color: white;"
      :icon="icons.mdiSchool"
      :toolbarTitle="Title"
    ></Toolbar>
    <br>
    <v-card class="mx-auto" variant="outlined" style="border: 2px solid #7d002c">
        <v-card-title style="color: white; background-color: #7d002c"
          >Configuration du système LMD</v-card-title>
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
            title="Note"
          >
            <li>Cette section vous permet de configurer si votre établissement utilise le système LMD ou pas, si OUI choisir le type du système</li>
            <!-- <li>Le formulaire sera valide si est seulement si tous les champs obligatoires marqués par <span style="color: red;">*</span> sont renseignés</li> -->
          </v-alert>

          <div v-if="!alertFirst" style="margin: auto; width: 50%; padding: 10px">
            <Button
              style="height: 30px"
              type="button"
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
    <!-- <v-card class="mx-auto" max-width="1000"> -->
        <v-form v-model="valid">
            <v-card-text>
                <v-row>
                <v-col>
                    <v-switch
                    label="Souhaiterez-vous appliquez le système LMD ?"
                    v-model="form.lmd"
                    @change="test()"
                    color="primary"
                    inset
                    ></v-switch>
                </v-col>
                <v-col v-if="form.lmd">
                    <Autocomplete
                        :items="lmds"
                        item-title="libelle"
                        item-value="id"
                        v-model="form.type_lmd"
                        @update:modelValue="test()"
                        chips
                        closable-chips
                        required
                        color="blue-grey-lighten-2"

                        label="Select"
                    ></Autocomplete>
                </v-col>
                <v-col>
                    <v-switch
                    label="Souhaiterez-vous appliquez le régime d'évaluation ?"
                    v-model="form.regime_evaluation"
                    color="indigo"
                    inset
                    ></v-switch>
                </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions>
                <v-btn
                    variant="text"
                    color="error"
                    @click="goBack"
                >
                Annuler
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn variant="text" color="info" :disabled='check' @click="submit">Enregistrer</v-btn>
            </v-card-actions>
        </v-form>
    </v-card>
    </AuthenticatedLayout>
  </template>
  <script>

    import { router,useForm} from '@inertiajs/vue3';
    import AuthenticatedLayout from "@/layouts/AuthenticatedLayout.vue";
    import Toolbar from "@/components/customizedComponents/Toolbar.vue";
    // import Datatable from "@/components/customizedComponents/datatable.vue";
    import Loader from "@/components/customizedComponents/Loader.vue";
    import { mdiAccount, mdiSchool, mdiHomeOutline, mdiInformation, mdiCloseCircle, mdiPlusCircle, mdiCogOutline,  mdiPresentation, mdiGift } from "@mdi/js";
  export default {
    props:['type','lmds'],
    components: {

    Loader,
    // Datatable,
    Toolbar,
    AuthenticatedLayout,
    mdiAccount,
    mdiCogOutline,
    mdiInformation,
    mdiSchool,
    mdiHomeOutline,
    mdiPlusCircle,
    mdiPresentation,
    mdiCloseCircle,
    mdiGift,
  },
    data: () => ({
        alertFirst: true,
        alertSecond: true,
        icons: {mdiAccount,mdiPlusCircle,mdiCloseCircle,mdiSchool,mdiInformation,mdiHomeOutline,mdiPresentation,mdiGift,mdiCogOutline},
        valid: false,
        check: false,
        form: useForm({
            lmd: false,
            type_lmd: null,
            regime_evaluation: false,
            type: null
        }),
    }),

    methods: {
        onclickAlertButton(type) {
        if (type == "second") {
            this.alertSecond = true;
        }
        if (type == "first") this.alertFirst = true;
        },
        test(){
            if(this.form.lmd == true && this.form.type_lmd !== null){
                this.check = false
            }else if(this.form.lmd == false ){
                this.check = false
            }else{
                this.check = true
            }
            console.log('check',this.check,'type_lmd', this.form.type_lmd );
        },
        submit(){
            this.form.type = this.type
            this.form.post(route('lmd.store'), {
                onFinish: () => {
                    this.$swal({
                        icon: 'success',
                        title: 'Enregistrement',
                        text: 'Enregistrer avec succès!',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                    });
                },
            });
        },

        goBack() {
            router.get(route('dashboard'))
        },
    },

    mounted() {

      // console.log('Admin etablissement',this.$page.props.admin_etablissement.etablissement_id)
    },
    computed: {

      Title () {
        switch (this.type) {
          case '1': return 'SECTION PRIMAIRE'
          case '2': return 'SECTION SECONDAIRE'
          case '3': return 'SECTION SUPERIEUR'
          default: return 'SECTION UNIVERSITAIRE'
        }
      },
    //   currentTitle () {
    //     switch (this.step) {
    //       case 1: return 'MATIERES'
    //       case 2: return 'SALLES'
    //       case 3:if (this.type === '3') {
    //                 return 'FILIERES';
    //             }else if (this.type === '4') {
    //                 return 'FACULTES';
    //             }else{return 'FRAIS';}
    //       case 4:if (this.type === '3') {
    //                 return 'FRAIS';
    //             }else if (this.type === '4') {
    //                         return 'FILIERES';
    //             }else{return 'AFFECTATION DE MATIERES AUX NIVEAUX';}
    //       case 5:if (this.type === '4') {
    //                 return 'FRAIS';
    //             }else{ return 'UNITE D\'ENSEIGNEMENT'}
    //       case 6:if (this.type === '4') {
    //                 return 'UNITE D\'ENSEIGNEMENT';
    //             }else{ return 'AFFECTATION DE MATIERES AUX NIVEAUX'}
    //       case 7: return 'AFFECTATION DE MATIERES AUX NIVEAUX'
    //     }
    //   },
    },
  }
</script>
