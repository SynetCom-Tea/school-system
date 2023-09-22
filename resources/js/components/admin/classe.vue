<template>
    <form @submit.prevent="submitForm" novalidate>
        <v-container fluid>
        <v-card variant="outlined" style="border: 2px solid #7d002c">
            <v-card-title style="color: white; background-color: #7d002c"
            >SALLES</v-card-title
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
                <li>Cette section vous permet de configurer les salles de cet établissement</li>
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
            <v-card >
                <v-card-text>

                    <v-row>
                        <v-col>
                            <v-switch
                            label="Importatation d\'un fichier pour alimenter les salles de cours"
                            @update:modelValue="resetForm(importation)"
                            v-model="importation"
                            color="info" inset></v-switch>
                        </v-col>
                        <v-col v-if="importation">

                            <v-file-input
                                clearable
                                required
                                v-model="form.fichier_classe"
                                label="Charger le fichier de salles"
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
                    <v-row :key="classe.id" v-for="(classe, i) in form.classes">
                        <v-col cols="3" v-if="type == '1' || type == '2'">

                        <v-autocomplete
                            :items="niveaux"
                            v-model="classe.niveau"
                            @update:modelValue="submitForm(classe)"
                            class="mt-2"
                            :item-title="formatNiveauLabel"
                            item-value="id"
                            closable-chips
                            label="Niveaux"
                        ></v-autocomplete>
                        </v-col>
                        <v-col cols="4">
                        <TextField label="Code salle" class="mt-2"  :isRequired="true" placeholder="Code salle" required @update:modelValue="submitForm(classe)" v-model="classe.code"></TextField>
                        </v-col>
                        <v-col cols="4">
                        <TextField label="Libelle salle" class="mt-2" :isRequired="true" placeholder="Libelle salle" required v-model="classe.libelle" @update:modelValue="submitForm(classe)"></TextField>
                        </v-col>
                        <v-col cols="1">
                            <br />
                            <Button
                                type="button"
                                variant="outlined"
                                :disabled="!(form.classes.length > 1)"
                                icon
                                @click="removeRow(classe)"
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
        </v-card>
        </v-container>
        <br>
    </form>
</template>
<script>
    import { router,useForm} from '@inertiajs/vue3';
    import { mdiCloseCircle, mdiPlusCircle, mdiInformation } from "@mdi/js";
  export default {
    props:['type','niveaux'],
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
            fichier_classe: null,
            classes: [],
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
                this.form.classes = []
                this.addRow()
            }
        },
        async submitForm(element) {
            await this.verify(element)
            await this.isValid()
            this.$emit('formSubmitted', this.form);
            this.$emit("classeFormValid", this.isValid());
        },
        async isValid() {
            let fichier = false
            let valid = false
            if(this.importation && this.form.fichier_classe != null){
                fichier = true
            }else if(!this.importation && !this.form.classes.find((el) => {
                if(this.type == '1' || this.type == '2'){
                    return el.niveau == null || el.niveau == '' || el.code == null || el.libelle == null || el.code.trim() == '' || el.libelle.trim() == '';
                }else{
                    return el.code == null || el.libelle == null || el.code.trim() == '' || el.libelle.trim() == '';
                }}))
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
            this.form.classes.push({
                niveau: null,
                code: null,
                libelle: null,
                before: null,
                after: null
            })
        },
        removeRow(id) {
            this.form.classes = this.form.classes.filter((el) => el !== id)
        },
        async verify(element) {
            const array = this.form.classes.filter(el => el.code !== null && el.code == element.code)
            if (array.length > 1) {
                this.removeRow(element)
                this.$swal("L'élément existe déjà !")
            }
        },
    },
    mounted() {
        this.addRow()
    },
  }
</script>
