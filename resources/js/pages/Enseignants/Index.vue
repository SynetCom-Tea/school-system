<script>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { useForm } from '@inertiajs/vue3';

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
        props: ["enseignants"],
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
                        title: 'Matricule',
                        align: 'start',
                        sortable: false,
                        key: 'matricule',
                    },
                    { title: 'Nom et Prenom', align: 'center', key: 'NomComplet' },
                    { title: 'Genre', align: 'center', key: 'sex' },
                    { title: 'Date et Lieu de naissance', align: 'center', key: 'date_lieu_nais' },
                    { title: 'Téléphone', align: 'center', key: 'telephone' },
                    {title: 'Actions', align: 'center', key: 'actions'},
                ],
                dialog_title: 'Création d\'enseignant',
                dialog: false,

                form: useForm({
                    id:'',
                    matricule: '',
                    nom: '',
                    prenom: '',
                    sex: '',
                    date_naissance: '',
                    lieu_naissance: '',
                    telephone: '',
                    compte:'',
                    email:'',
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
            create() {
                this.dialog = true;
                this.dialog_title = 'Création d\'enseignant'
            },
            editItem(item){
                //console.log('edit',item)
                this.dialog_title = 'Modifier enseignant'
                this.form.id = item.id
                this.form.matricule = item.matricule
                this.form.nom = item.nom
                this.form.prenom = item.prenom
                this.form.sex = item.sex
                this.form.date_naissance = item.date_naissance
                this.form.lieu_naissance = item.lieu_naissance
                this.form.telephone = item.telephone
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

                       this.form.delete(route('enseignants.destroy', item.id), {
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
                if(!this.form.id && valid) {
                    this.form.post(route('enseignants.store'), {
                        onFinish: () => {
                            //console.log(this.form)
                            this.close()

                            this.$swal({
                                icon: 'success',
                                iconColor: '#004980',
                                color: '#004980',
                                title: 'Enregistrement',
                                text: 'Enseignant créée avec succès!',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                            });
                        },
                    });

                }else if(this.form.id && valid) {

                     const {id,code,nom} = this.form

                    this.form.put(route('enseignants.update', this.form.id), {
                        onFinish: () => {
                           this.close()
                            this.$swal({
                                icon: 'success',
                                iconColor: '#004980',
                                color: '#004980',
                                title: 'Modification',
                                text: 'Enseignant modifiée avec succès!',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                            });
                        },
                    })
                }

            },
            close() {
                this.form.id = ""
                this.form.matricule = ""
                this.form.nom = ""
                this.form.prenom = ""
                this.form.sex = ""
                this.form.date_naissance = ""
                this.form.lieu_naissance = ""
                this.form.telephone = ""
                this.form.compte = ""
                this.form.email = ""
                this.dialog = false
            }
        }
    }
</script>
<template>
    <v-card>
    <Toolbar
      styleToolbar="background-color: white;"
      :icon="icons.mdiBookOpenVariant"
      toolbarTitle="Gestion des Enseignants"
    ></Toolbar>
        <v-dialog v-model="dialog" transition="dialog-top-transition" persistent width="900px">
                        <template v-slot:default="{ isActive }">
                <v-card>
                    <v-toolbar dense style="background-color: #7d002c">
                        <v-toolbar-title style="color:white">
                        <v-icon left :icon="icons.mdiPencil"></v-icon> {{ dialog_title }}
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-icon :icon="icons.mdiCloseCircle" title="Annuler" size="large" style="margin:10px" color="white" @click="close"></v-icon>
                    </v-toolbar>
                    <v-card-text>
                                    <v-form ref="form">
                                        <v-row>
                                            <v-col cols="6" md="6">
                                                <text-field label="Matricule" placeholder="Matricule" v-model="form.matricule" isRequired :rules="rules"></text-field>

                                            </v-col>
                                            <v-col cols="6" md="6">
                                                <text-field label="Nom" placeholder="Nom" v-model="form.nom" isRequired :rules="rules"></text-field>
                                            </v-col>
                                            <v-col cols="6" md="6">
                                                <text-field label="Prénom" placeholder="Prénom" v-model="form.prenom" isRequired :rules="rules"></text-field>
                                            </v-col>
                                            <v-col cols="6" md="6">
                                                <text-field type="date" label="Date de Naissance" placeholder="Date de Naissance" v-model="form.date_naissance" isRequired :rules="rules"></text-field>
                                            </v-col>
                                            <v-col cols="6" md="6">
                                                <text-field label="lieu de Naissance" placeholder="lieu de Naissance" v-model="form.lieu_naissance" isRequired :rules="rules"></text-field>
                                            </v-col>
                                            <v-col cols="6" md="6">
                                                <Autocomplete
                                                    v-model="form.sex"
                                                    :isRequired="true"
                                                    itemTitle="Genre"
                                                    placeholder="Genre"
                                                    label="Genre"
                                                    :items="['Masculin','Féminin']"
                                                    >
                                                </Autocomplete>
                                                <!-- <text-field label="Genre" placeholder="Genre" v-model="form.sex" isRequired :rules="rules"></text-field> -->
                                            </v-col>
                                            <v-col cols="6" md="6">
                                                <text-field label="Téléphone" placeholder="Téléphone" v-model="form.telephone" isRequired :rules="rules"></text-field>
                                            </v-col>
                                            <v-col cols="6" md="6" v-if="form.id==''">
                                                <v-switch
                                                    label="Voulez vous créer un compte pour pour cet enseignant ? "
                                                    v-model="form.compte"
                                                    color="info"
                                                    inset
                                                    ></v-switch>
                                                <!-- <text-field label="compte" placeholder="compte" v-model="form.compte" isRequired :rules="rules"></text-field> -->
                                            </v-col>
                                            <v-col cols="6" md="6" v-if="form.id=='' && form.compte==true">
                                                <text-field label="email" placeholder="email" v-model="form.email" isRequired :rules="rules"></text-field>
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
        <v-card-text>
            <Datatable titleDatatable="Liste des enseignants" :headers="headers" :items="enseignants" :functionOnClickAddButton="create" >

            <template v-slot:item.actions="{item}">
                <v-icon size="small" class="me-2" title="Modifier" @click="editItem(item.raw)" :icon="icons.mdiPencil" color="orange">
                </v-icon>
                <v-icon size="small" class="me-2" title="Supprimer" @click="deleteItem(item.raw)" :icon="icons.mdiDelete" color="red">
                </v-icon>
            </template>
        </Datatable>
        </v-card-text>
    </v-card>
</template>
<style>

</style>
