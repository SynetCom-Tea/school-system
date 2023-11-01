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
            mdiContentSave
        },
        layout: AuthenticatedLayout,
        props: ["classes","section_id", "niveaux"],
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
                dialog_title: 'Création Classe',
                dialog: false,
                
                form: useForm({
                    code: '',
                    libelle: '',
                    niveau_id: '',
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
                router.get(route('classes.create', this.section_id))
            },
            editItem(item){
                this.dialog_title = 'Modifier la classe' 
                this.form.id = item.id
                this.form.niveau_id = item.niveau_id
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
                        
                       this.form.delete(route('classes.destroy', item.id), {
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
                    
                     const {id,code,libelle,niveau_id} = this.form
                    
                    this.form.put(route('classes.update', this.form.id), {
                        onFinish: () => {
                           this.close()
                            this.$swal({
                                icon: 'success',
                                iconColor: '#004980',
                                color: '#004980',
                                title: 'Modification',
                                text: 'Classe modifiée avec succès!',
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
                this.form.niveau_id = ""
                this.form.code = ""
                this.form.libelle = ""
                this.dialog = false
            }
        }
    }
</script>
<template>
    <v-card>
    <Toolbar
      styleToolbar="background-color: white;"
      :icon="icons.mdiGoogleClassroom"
      toolbarTitle="Gestion des classes"
    ></Toolbar>
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
                    <v-card-text>
                                    <v-form ref="form">
                                        <v-row>
                                            <v-col cols="12" md="12">
                                                <Select
                                                    label="Niveau"
                                                    :items="niveaux"
                                                    variant="outlined"
                                                    itemValue="id"
                                                    itemTitle="libelle"
                                                    v-model="form.niveau_id"
                                                    isRequired
                                                    :rules="[(v) => !!v || 'Ce champ est requis!']"
                                                    >
                                                </Select>
                                            </v-col>
                                        </v-row>
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
        <v-card-text>
            <Datatable titleDatatable="Liste des classes" :headers="headers" :items="classes" :functionOnClickAddButton="create" >
             
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