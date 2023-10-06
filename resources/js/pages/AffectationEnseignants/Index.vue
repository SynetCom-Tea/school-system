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
        props: ["enseignants","niveauMatieres","section_id","classes","enseignements"],
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
                    { title: 'Nom et Prénom', align: 'center', key: 'NomComplet' },
                    { title: 'Matières', align: 'center', key: 'matiere' },
                    { title: 'Classes', align: 'center', key: 'classes' },
                    { title: 'Année scolaire', align: 'center', key: 'annee' },
                    {title: 'Actions', align: 'center', key: 'actions'},
                ],
                dialog_title: 'Affectation des enseignants',
                dialog: false,

                form: useForm({
                    niveau_matiere:'',
                    classe: '',
                    enseignant: '',

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
                this.dialog_title = 'Affecter un enseignant'
            },
            editItem(item){
                // console.log('edit',item)
                this.dialog_title = 'Mise à jour d\'ffectation de'+ " " + item.NomComplet
                this.form.id = item.id
                this.form.niveau_matiere = item.matiere
                this.form.classe = item.classes
                this.form.enseignant= item.NomComplet
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

                       this.form.delete(route('AffectationEnseignants.destroy', item.id), {
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
                    this.form.post(route('AffectationEnseignants.store',this.section_id), {
                        onFinish: () => {
                            //console.log(this.form)
                            this.close()

                            this.$swal({
                                icon: 'success',
                                iconColor: '#004980',
                                color: '#004980',
                                title: 'Enregistrement',
                                text: 'Affectation a été enregistrée avec succès!',
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

                    this.form.put(route('AffectationEnseignants.update', this.form.id), {
                        onFinish: () => {
                           this.close()
                            this.$swal({
                                icon: 'success',
                                iconColor: '#004980',
                                color: '#004980',
                                title: 'Modification',
                                text: 'Affectation a été modifiée avec succès!',
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
                this.form.niveau_matiere = ""
                this.form.enseignant = ""
                this.form.classe = ""
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
      toolbarTitle="Affectation des enseignants aux classes"
    ></Toolbar>
        <v-dialog v-model="dialog" transition="dialog-top-transition" persistent width="700px">
            <template v-slot:default="{ isActive }">
                <v-card>
                    <v-toolbar dense style="background-color: #7d002c">
                        <v-toolbar-title style="
                        font-size: 1em;
                        width: auto;
                        word-wrap: break-word;
                        white-space: pre-wrap;
                        word-break: break-word;
                        color:white"

                        ><p class="text-wrap">
                            <v-icon left :icon="icons.mdiPencil"  style=" font-size: 1.5em;"></v-icon>{{ dialog_title }}
                        </p>
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-icon :icon="icons.mdiCloseCircle" title="Annuler" size="large" style="margin:10px" color="white" @click="close"></v-icon>
                    </v-toolbar>
                    <v-card-text>
                                    <v-form ref="form">
                                        <v-row>
                                            <v-col cols="12" md="12">
                                                <Autocomplete
                                                    v-model="form.enseignant"
                                                    isRequired
                                                    itemValue="id"
                                                    itemTitle="NomComplet"
                                                    placeholder="Enseignant"
                                                    label="Enseignant"
                                                    ships
                                                    :items="enseignants"
                                                    :rules="[(v) => !!v || 'Ce champ est requis!']"
                                                    >
                                                </Autocomplete>
                                                <!-- <text-field label="Nom" placeholder="Nom" v-model="form.nom" isRequired :rules="rules"></text-field> -->
                                            </v-col>
                                            <v-col cols="12" md="12">
                                                <Autocomplete
                                                    v-model="form.niveau_matiere"
                                                    isRequired
                                                    itemValue="id"
                                                    itemTitle="code"
                                                    placeholder="Niveau/Matiere"
                                                    label="Niveau/Matiere"
                                                    multiple
                                                    ships
                                                    :items="niveauMatieres"
                                                    :rules="[(v) => !!v || 'Ce champ est requis!']"
                                                    >
                                                </Autocomplete>

                                            </v-col>

                                            <v-col cols="12" md="12">
                                                <Autocomplete
                                                    v-model="form.classe"
                                                    isRequired
                                                    itemValue="id"
                                                    itemTitle="libelle"
                                                    placeholder="Classes"
                                                    label="Classes"
                                                    multiple
                                                    ships
                                                    :items="classes"
                                                    :rules="[(v) => !!v || 'Ce champ est requis!']"
                                                    >
                                                </Autocomplete>
                                                <!-- <text-field label="Prénom" placeholder="Prénom" v-model="form.prenom" isRequired :rules="rules"></text-field> -->
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
            <Datatable titleDatatable="Liste des enseignants " :headers="headers" :items="enseignements" :functionOnClickAddButton="create" >

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
