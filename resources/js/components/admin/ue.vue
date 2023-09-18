<template>
    <form @submit.prevent="submitForm" novalidate>
        <v-container fluid>
            <v-card variant="outlined" style="border: 2px solid #7d002c">
        <v-card-title style="color: white; background-color: #7d002c"
          >UNITE D'ENSEIGNEMENT</v-card-title
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
            title="Note"
          >
            <li>Cette section vous permet de configurer les unités des enseignements de cet établissement</li>
            <li>Le formulaire sera valide si est seulement si tous les champs obligatoires marqués par <span style="color: red;">*</span> sont renseignés</li>
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
    <v-card>
        <v-card-text>

            <v-row>
                <v-col>
                    <v-switch label="Souhaiterez-vous importez le fichier des unités des enseignements ?" @update:modelValue="resetForm(importation)" v-model="importation" color="info" inset></v-switch>
                </v-col>
                <v-col v-if="importation">
                    <v-file-input
                        clearable
                        required
                        v-model="form.fichier_ue"
                        label="Charger le fichier des UES"
                        variant="solo-inverted"
                    ></v-file-input>
                </v-col>
                <v-col v-if="importation"><v-btn 
                    class="ma-2" 
                    outlined 
                    type="button"
                    color="primary"
                    href="../models/echantillons/fiche_echantillonage.ods"
                    download>
                        Télécharger le Model
                </v-btn></v-col>
            </v-row>
        </v-card-text>

        <v-card-text v-if="!importation">
            <v-row disabled :key="ue.id" v-for="(ue, i) in form.ues">
                <v-col md="4">
                    <TextField label="Code UE"  class="mt-2" :isRequired="true" placeholder="Code UE" @change="verify(ue)" v-model="ue.code"></TextField>
                </v-col>
                <v-col md="4">
                    <TextField label="Nom de l'UE" class="mt-2"  :isRequired="true" placeholder="Nom de l'UE" v-model="ue.libelle"></TextField>
                </v-col>
                <v-col md="1">
                    <br>
                    <Button
                    type="button"
                    variant="outlined"
                    :disabled="!(form.ues.length > 1)"
                    icon
                    @click="removeRow(ue)"
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
    </v-card>
    <br>
        <v-row class="text-center ml-3 mb-3"
          ><v-col cols="auto">
            <Button
              type="submit"
              title="Enregistrer cette étape"
              nameButton="Enregistrer"
              variant="flat"
              @click="submitForm"
              density="comfortable"
              class="text-center"
              :isBlock="true"
              size="large"
              style="text-transform: none"
            >
            </Button> </v-col
        ></v-row>
    </v-card>

    </v-container>
        <!-- <v-row>
            <v-col md="5"></v-col>
            <v-col md="4">
                <v-btn type="submit" title="enregistrer" color="info">
                    Enregistrer
                </v-btn>
            </v-col>
        </v-row> -->
        <br>
    </form>
</template>
<script>
    import { router,useForm} from '@inertiajs/vue3';
    import { mdiCloseCircle, mdiPlusCircle, mdiInformation } from "@mdi/js";
  export default {
    props:['type'],
    components: {
        mdiPlusCircle,
        mdiCloseCircle,
        mdiInformation
    },
    data: () => ({
        alertFirst: true,
        alertSecond: true,
        icons: {mdiPlusCircle,mdiCloseCircle,mdiInformation},
        step: 1,
        importation: false,
        form: useForm({
            fichier_ue: null,
            ues: [],
        }),
    }),

    methods: {
        onclickAlertButton(type) {
        if (type == "second") {
            this.alertSecond = true;
        }
        if (type == "first") this.alertFirst = true;
        },
        formatNiveauLabel(item) {
            if(item){
                return `${item?.code} - ${item?.libelle}`;
            }
        },
        resetForm(check){
            if(check){
                this.form.ues = []
                this.addRow()
            }
        },
        submitForm() {
            // Empêche l'envoi du formulaire par défaut
            event.preventDefault();
            // Valide le formulaire avant de l'envoyer
            if (this.isValid()) {
                this.$emit('formSubmitted', this.form);
                this.$swal.fire({
                    title: 'Réussi',
                    text: "Mise à jour réussi avec succes!",
                    icon: 'success',
                    confirmButtonText: 'OK',
                });
                // this.$swal("Enregistrement réussi avec succes!")
            }else{
                // this.$swal.fire("Le formulaire n\'est pas valide. Merci de renseigner correctement et de reessayer!")
                this.$swal.fire({
                    title: 'Erreur',
                    text: "Le formulaire n\'est pas valide. Merci de renseigner correctement et de reessayer!",
                    icon: 'warning',
                    confirmButtonText: 'OK',
                });

            }
        },
        isValid() {
            let fichier = false
            let valid = false

            if(this.importation && this.form.fichier_ue != null){
                fichier = true
            }else if(!this.importation && !this.form.ues.find((el) => {
                return el.code == null || el.libelle == null || el.code == '' || el.libelle == '';
            }))
            {
                fichier = true
            }

            if(fichier){
                valid = true
            }else{
                valid = false
            }
            return valid
        },
        goBack() {
            router.get(route('etablissements.index'))
            console.log()
        },
        addRow() {
            this.form.ues.push({
                code: null,
                libelle: null,
                etablissement: this.$page.props.admin_etablissement.etablissement_id,
                before: null,
                after: null
            })
        },
        removeRow(id) {
            this.form.ues = this.form.ues.filter((el) => el !== id)
        },
        async verify(element) {
            const array = this.form.ues.filter(el => el.code !== null && el.code == element.code)

            if (array.length > 1) {
                this.removeRow(element)
                this.$swal("L'élément existe déjà !")
                // this.$alert.error("L'élément existe déjà !");
            }
        },
    },
    mounted() {
        this.addRow()
    },
  }
</script>

