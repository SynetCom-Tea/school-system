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
        },
        layout: AuthenticatedLayout,
        props: ["niveaux"],
        data() {
            return {
                icon: {
                    mdiAccountSchool,
                    mdiPlus,
                    mdiPencil,
                    mdiDelete,
                    mdiPlusCircle,
                    mdiClipboardEditOutline,
                    mdiOfficeBuilding,
                    mdiMail,
                    mdiGoogleClassroom,
                },
                headers: [
                    {
                        title: 'Code',
                        align: 'start',
                        sortable: false,
                        key: 'code',
                    },
                    { title: 'Libelé', align: 'center', key: 'libele' },
                    {title: 'Actions', align: 'center', key: 'actions'},
                ],
                dialog_title: 'Création Niveau',
                dialog: false,
                
                form: useForm({
                    code: '',
                    libele: '',
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
                this.dialog_title = 'Création Niveau'
            },
            editItem(item){
                //console.log('edit',item) 
                this.dialog_title = 'Modifier le niveau' 
                this.form.id = item.id
                this.form.code = item.code
                this.form.libele = item.libele
                this.dialog = true
            },
            deleteItem(item){
                this.$swal({
                    title: 'Es-tu sûr?',
                    text: "Vous ne pourrez pas revenir en arrière !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: 'orange',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, supprimez-le!',
                    cancelButtonText: 'Non, annulez !',
                    }).then((result) => {
                    if (result.isConfirmed) {
                        
                       this.form.delete(route('niveaux.destroy', item.id), {
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
                    this.form.post(route('niveaux.store'), {
                        onFinish: () => {
                            //console.log(this.form)
                            this.close()
                            
                            this.$swal({
                                icon: 'success',
                                title: 'Enregistrement',
                                text: 'Niveau créé avec succès!',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                            });
                        },
                    });
                    
                }else if(this.form.id && valid) {
                    
                     const {id,code,libele} = this.form
                    
                    this.form.put(route('niveaux.update', this.form.id), {
                        onFinish: () => {
                           this.close()
                            this.$swal({
                                icon: 'success',
                                title: 'Modification',
                                text: 'Niveau modifié avec succès!',
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
                this.form.code = ""
                this.form.libele = ""
                this.dialog = false
            }
        }
    }
</script>
<template>
    <v-card>
        <page-toolbar :icon="icon.mdiGoogleClassroom">Gestion des niveaux</page-toolbar>
        <v-dialog v-model="dialog" transition="dialog-top-transition" persistent width="500px">
                        <template v-slot:default="{ isActive }">
                            <v-card>
                                <v-toolbar dense color="primary" dark>
                                    <v-toolbar-title>
                                        <v-icon left>{{ form.id ? icon.mdiPencil : icon.mdiPlusCircle }}</v-icon> {{ dialog_title }}
                                        
                                    </v-toolbar-title>
                                    <v-spacer></v-spacer>
                                   
                                </v-toolbar>
                                <v-card-text>
                                    <v-form ref="form">
                                        <v-row>
                                            <v-col cols="12" md="12">
                                                <text-field label="Code" placeholder="Code" v-model="form.code" isRequired :rules="rules"></text-field>
                                            
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12" md="12">
                                                <text-field label="Libelé" placeholder="Libelé" v-model="form.libele" isRequired :rules="rules"></text-field>
                                            
                                            </v-col>
                                        </v-row>
                                    </v-form>
                                </v-card-text>
                                <v-card-actions class="justify-end">
                                    <v-spacer></v-spacer>
                                    <v-btn dark small type="button" color="red" @click="close">
                                        <v-icon :icon="icon.mdiCancel" left></v-icon> Annuler
                                    </v-btn>
                                    <v-btn type="submit" small color="success" @click="submit">
                                        <v-icon :icon="icon.mdiCheckCircle" left></v-icon> Enregistrer
                                    </v-btn>
                                </v-card-actions> 
                            </v-card>
                        </template>
                    </v-dialog>
        <v-card-text>
            <table-component 
                :headers="headers"
                :items="niveaux">
                <template v-slot:addBtn>
                    <btn @click="create"><v-icon>{{ icon.mdiPlus }}</v-icon> Ajouter</btn>
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-icon size="small" color="warning" title="Modifier" class="me-2" @click="editItem(item.raw)" :icon="icon.mdiPencil">
                    </v-icon>
                    <v-icon size="small" color="error" title="Supprimer" @click="deleteItem(item.raw)" :icon="icon.mdiDelete">
                    </v-icon>
                </template>
            </table-component>
        </v-card-text>
    </v-card>
</template>
<style>

</style>