<script>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { useForm, router } from '@inertiajs/vue3';

    import {
        mdiAccountSchool,
        mdiPlus,
        mdiPencil,
        mdiDelete,
        mdiPlusCircle,
       mdiClipboardEditOutline,
       mdiOfficeBuilding,
       mdiMail,
       mdiGoogleClassroom,
       mdiSchool,
       mdiCancel,
       mdiCloseCircle,
       mdiBookOpenVariant,
       mdiContentSave
    } from '@mdi/js'
    export default {
        components: {
            mdiAccountSchool,
            mdiPlus,
            mdiPencil,
            mdiDelete,
            mdiPlusCircle,
            mdiClipboardEditOutline,
            mdiOfficeBuilding,
            mdiMail,
            mdiGoogleClassroom,
            mdiSchool,
            mdiCancel,
            mdiCloseCircle,
            mdiBookOpenVariant,
            mdiContentSave
        },
        layout: AuthenticatedLayout,
        props: ["salles"],
        data() {
            return {
                icons: {
                    mdiAccountSchool,
                    mdiPlus,
                    mdiPencil,
                    mdiDelete,
                    mdiPlusCircle,
                    mdiClipboardEditOutline,
                    mdiOfficeBuilding,
                    mdiMail,
                    mdiGoogleClassroom,
                    mdiSchool,
                    mdiCancel,
                    mdiCloseCircle,
                    mdiBookOpenVariant,
                    mdiContentSave
                },
                headers: [
                    {
                        title: 'Code',
                        align: 'start',
                        sortable: false,
                        key: 'code',
                    },
                    { title: 'Libellé', align: 'center', key: 'libelle' },
                    {title: 'Actions', align: 'center', key: 'actions'},
                ],
                dialog_title: 'Modifier la salle',
                dialog: false,
                ajoutdialog : false,
                alertFirst: true,
                alertSecond: true,

                form: useForm({
                    id:null,
                    code: '',
                    libelle: '',
                    donnees: [],
                }),
                rules: [
                        value => {
                            if (value) return true
                            return 'Ce champ est requis!'
                        },
                ],
            }
        },

        methods:{
            onclickAlertButton(type) {
                if (type == "second") {
                this.alertSecond = true;
                }
                if (type == "first") this.alertFirst = true;
            },
            create() {
                this.addRow()
                this.dialog_titlecreate= 'Ajouter la salle',
                // router.get(route('salles.create'))
                this.ajoutdialog = true
            },

            addRow() {
                this.form.donnees.push({
                    code: null,
                    libelle: null,
                    before: null,
                    after: null
                });

            },


            removeRow(p) {
            this.form.donnees = this.form.donnees.filter((product) => product !== p)
        },

        async verify(p) {
            const array = this.form.donnees.filter((el) => el.code !== null && el.libelle == p.libelle)
            if (array.length > 1) {
                this.removeRow(p)

                this.$swal({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Cette salle existe déjà!',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                });

            }
        },
            editItem(item){
                //console.log('edit',item)
                this.dialog_title = 'Modifier la salle'
                this.form.id = item.id
                this.form.code = item.code
                this.form.libelle = item.libelle
                this.dialog = true
            },
            deleteItem(item){
                this.$swal({
                    title: 'Es-tu sûr?',
                    text: "Vous ne pourrez pas revenir en arrière !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#004980',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, supprimez-le!',
                    cancelButtonText: 'Non, annulez !',
                    }).then((result) => {
                    if (result.isConfirmed) {

                       this.form.delete(route('salles.destroy', item.id), {
                        onFinish: () => {
                            if(this.$page.props.flash?.message?.type == 'error'){
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
                            }else if(this.$page.props.flash?.message?.type == 'success'){
                                this.$swal({
                                icon: 'success',
                                iconColor: '#004980',
                                color: '#004980',
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
                const { valid } = await this.$refs.form.validate()
                if(this.form.id && valid) {

                     const {id,code,libelle} = this.form

                    this.form.put(route('salles.update', this.form.id), {
                        onFinish: () => {
                           this.close()
                            this.$swal({
                                icon: 'success',
                                iconColor: '#004980',
                                color: '#004980',
                                title: 'Modification',
                                text: 'Salle modifiée avec succès!',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                            });
                        },
                    })
                }else if (valid){

                    this.form.post(route('salles.store'), {
                        onFinish: () => {
                            this.close();
                            this.$swal({
                                icon: 'success',
                                iconColor: '#004980',
                                color: '#004980',
                                title: 'Enregistrement',
                                text: 'Salles créées avec succès!',
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
                //  this.form.reset()
                this.form.id = null
                this.form.code = ""
                this.form.libelle = ""
                this.form.donnees=[]
                this.dialog = false
                this.ajoutdialog = false

            }
            // close() {
            //     this.form.id = ""
            //     this.form.code = ""
            //     this.form.libelle = ""

            // }
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
      :icon="icons.mdiSchool"
      toolbarTitle="GESTION DES SALLES"
    ></Toolbar>
    <br>
    <v-card variant="outlined" style="border: 2px solid #7d002c">
        <v-card-title style="color: white; background-color: #7d002c"
            >GESTION DES SALLES</v-card-title
          >
          <v-divider></v-divider>
    <!-- <Toolbar
      styleToolbar="background-color: white;"
      :icon="icons.mdiGoogleClassroom"
      toolbarTitle="Gestion des salles"
    ></Toolbar> -->
        <v-dialog v-model="dialog" transition="dialog-top-transition" persistent width="500px">
                        <template v-slot:default="{ isActive }">
                <v-card>
                    <v-toolbar dense style="background-color: #7d002c">
                        <v-toolbar-title style="color:white">
                        <v-icon left :icon="icons.mdiPencil"></v-icon> {{ dialog_title }}
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-icon :icon="icons.mdiCloseCircle" title="Annuler" size="large" style="margin:10px" color="white" @click="close"></v-icon>
                    </v-toolbar>
                    <v-card-text v-if="form.id !=null">
                        <v-form ref="form">
                            <v-row>
                                <v-col cols="12" md="12">
                                    <text-field label="Code" placeholder="Code" v-model="form.code" isRequired :rules="rules"></text-field>

                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12" md="12">
                                    <text-field label="Libellé" placeholder="Libellé" v-model="form.libelle" isRequired :rules="rules"></text-field>

                                </v-col>
                            </v-row>
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-spacer></v-spacer>
                        <Button color="red" variant="outlined" class="mb-2" nameButton="Annuler" title="Annuler" style="height: 30px" :prependIcon="icons.mdiCancel" @click="close"></Button>
                        <Button variant="outlined" class="mb-2" nameButton="Enregistrer" title="Valider et Fermer la modale" style="height: 30px" :prependIcon="icons.mdiContentSave" @click="submit"></Button>
                    </v-card-actions>
                </v-card>
            </template>

        </v-dialog>


        <v-dialog v-model="ajoutdialog" transition="dialog-top-transition" persistent width="800px">
            <template v-slot:default="{ isActive }">
                <v-card>
                    <v-toolbar dense style="background-color: #7d002c">
                        <v-toolbar-title style="color:white">
                        <v-icon left :icon="icons.mdiPencil"></v-icon> {{ dialog_titlecreate }}
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-icon :icon="icons.mdiCloseCircle" title="Annuler" size="large" style="margin:10px" color="white" @click="close"></v-icon>
                    </v-toolbar>

                    <v-card-text v-if="form.id ==null">

                        <v-form ref="form">
                            <v-card-text>
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
                                        Cette section vous permet de configurer les salles de cet
                                        établissement
                                    </li>
                                    <li>
                                        Le formulaire sera valide si est seulement si tous les champs obligatoires
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
                                <!-- <v-chip label variant="outlined" text-color="white" color="primary" class="text-md-h6 green--text">Ajout des salles</v-chip> -->
                                <v-card outlined class="mb-md-2">
                                    <v-card-text>
                                        <v-row :key="donnee.id" v-for="(donnee, i) in form.donnees">

                                            <v-row style="margin: 5px;">
                                                <v-col cols="1"></v-col>
                                                <v-col cols="4" style="height: 80px">
                                                    <TextField   class="mt-2" label="Code" placeholder="Code" v-model="donnee.code" isRequired :rules="[(v) => !!v || 'Ce champ est requis!']" @update:modelValue=" verify(donnee)"></TextField>
                                                </v-col>
                                                <v-col cols="4" style="height: 80px">
                                                    <TextField  class="mt-2" label="Libellé" placeholder="Libellé" v-model="donnee.libelle" isRequired :rules="[(v) => !!v || 'Ce champ est requis!']" @update:modelValue=" verify(donnee)"></TextField>
                                                </v-col>

                                                <v-col  cols="2" style="height: 80px">
                                                    <br>
                                                    <Button size="large"  title="supprimer la salle" variant="outlined" :disabled="!(form.donnees.length > 1)" icon @click="removeRow(donnee)" color="error">
                                                        <v-icon :icon="icons.mdiCloseCircle" small></v-icon>
                                                    </Button >
                                                </v-col>
                                            </v-row>
                                        </v-row>
                                        <v-row>

                                            <v-col  offset-md="9" cols="2">
                                                <Button size="large"  class="mb-2" title="ajouter une salle" variant="outlined" icon @click="addRow()"  color="primary">
                                                    <v-icon :icon="icons.mdiPlusCircle" small></v-icon>
                                                </Button >
                                            </v-col>
                                        </v-row>
                                    </v-card-text>
                                </v-card>

                            </v-card-text>
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-spacer></v-spacer>
                        <Button color="red" variant="outlined" class="mb-2" nameButton="Annuler" title="Annuler" style="height: 30px" :prependIcon="icons.mdiCancel" @click="close"></Button>
                        <Button variant="outlined" class="mb-2" nameButton="Enregistrer" title="Valider et Fermer la modale" style="height: 30px" :prependIcon="icons.mdiContentSave" @click="submit"></Button>
                    </v-card-actions>
                </v-card>
            </template>

        </v-dialog>
        <v-card-text>
            <Datatable titleDatatable="Liste des salles" :headers="headers" :items="salles" :functionOnClickAddButton="create" >

            <template v-slot:item.actions="{item}">
                <v-icon size="small" class="me-2" title="Modifier" @click="editItem(item)" :icon="icons.mdiPencil" color="orange">
                </v-icon>
                <v-icon size="small" class="me-2" title="Supprimer" @click="deleteItem(item)" :icon="icons.mdiDelete" color="red">
                </v-icon>
            </template>
        </Datatable>
        </v-card-text>
    </v-card>
</template>
<style>

</style>
