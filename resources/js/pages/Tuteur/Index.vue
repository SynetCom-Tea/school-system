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
       mdiAccount
       
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
            mdiAccount
        },
        layout: AuthenticatedLayout,
        props: ["tuteurs"],
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
                    mdiAccount
                },
                headers: [
                    {
                        title: 'Nom 1',
                        align: 'start',
                        sortable: false,
                        key: 'nom1',
                    },
                    { title: 'Téléphone 1', align: 'center', key: 'tel1' },
                    {
                        title: 'Nom 2',
                        align: 'start',
                        sortable: false,
                        key: 'nom2',
                    },
                    { title: 'Téléphone 2', align: 'center', key: 'tel2' },
                    {title: 'Actions', align: 'center', key: 'actions'},
                ],
                dialog_title: 'Nouveau tuteur',
                dialog: false,
                
                form: useForm({
                    nom1: '',
                    tel1: '',
                    nom2: '',
                    tel2: '',
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
                this.dialog_title = 'Nouveau tuteur'
            },
            editItem(item){ 
                this.dialog_title = 'Modifier le tuteur' 
                this.form.id = item.id
                this.form.nom1 = item.nom1
                this.form.tel1 = item.tel1
                this.form.nom2 = item.nom2
                this.form.tel2 = item.tel2
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
                        
                       this.form.delete(route('tuteurs.destroy', item.id), {
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
                    this.form.post(route('tuteurs.store'), {
                        onFinish: () => {
                            this.close()
                            
                            this.$swal({
                                icon: 'success',
                                title: 'Enregistrement',
                                text: 'Tuteur créé avec succès!',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                            });
                        },
                    });
                    
                }else if(this.form.id && valid) {
                    
                     const {id,nom1,tel1,nom2,tel2} = this.form
                    
                    this.form.put(route('tuteurs.update', this.form.id), {
                        onFinish: () => {
                           this.close()
                            this.$swal({
                                icon: 'success',
                                title: 'Modification',
                                text: 'Tuteur modifié avec succès!',
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
                this.form.nom1 = ""
                this.form.tel1 = ""
                this.form.nom2 = ""
                this.form.tel2 = ""
                this.dialog = false
            }
        }
    }
</script>
<template>
    <v-card>
        <page-toolbar :icon="icon.mdiAccount">Gestion des tuteurs</page-toolbar>
        <v-card-text>
            <table-component 
                :headers="headers"
                :items="tuteurs">
                <template v-slot:addBtn>
                    <v-dialog v-model="dialog" transition="dialog-top-transition" persistent width="500px">
                        <template v-slot:activator="{ props }">
                            <div class="custom-add-button">
                                <v-btn @click="create" x-small variant="outlined" color="green" v-bind="props"> Ajouter
                                </v-btn>
                            </div>
                        </template>
                        <template v-slot:default="{ isActive }">
                            <v-card>
                                <v-toolbar dense color="orange" dark>
                                    <v-toolbar-title>
                                        <v-icon left>{{ form.id ? icon.mdiPencil : icon.mdiPlusCircle }}</v-icon> {{ dialog_title }}
                                        
                                    </v-toolbar-title>
                                    <v-spacer></v-spacer>
                                   
                                </v-toolbar>
                                <v-card-text>
                                    <v-form ref="form">
                                        <v-row>
                                            <v-col cols="12" md="12">
                                                <text-field label="Nom 1" placeholder="Nom 1" v-model="form.nom1" isRequired :rules="rules"></text-field>
                                            
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12" md="12">
                                                <text-field label="Tél 1" placeholder="Tél 1" v-model="form.tel1" isRequired :rules="rules"></text-field>
                                            
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12" md="12">
                                                <text-field label="Nom 2" placeholder="Nom 2" v-model="form.nom2" isRequired :rules="rules"></text-field>
                                            
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12" md="12">
                                                <text-field label="Tél 2" placeholder="Tél 2" v-model="form.tel2" isRequired :rules="rules"></text-field>
                                            
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