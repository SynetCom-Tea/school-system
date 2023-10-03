<script>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { useForm, router} from '@inertiajs/vue3';
    
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
       mdiContentSave,
       mdiCurrencyUsd,
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
            mdiContentSave,
            mdiCurrencyUsd
        },
        layout: AuthenticatedLayout,
        props: ["frais","section_id", "niveaux","annees","typefrais"],
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
                    mdiContentSave,
                    mdiCurrencyUsd,
                },
                headers: [
                    {
                        title: 'Libellé',
                        align: 'start',
                        sortable: false,
                        key: 'type_frais.libelle',
                    },
                    { title: 'Montant', align: 'center', key: 'montant' },
                    { title: 'Année Scolaire', align: 'center', key: 'annee.libelle' },
                    { title: 'Niveau', align: 'center', key: 'niveau.libelle' },
                    {title: 'Actions', align: 'center', key: 'actions'},
                ],
                dialog_title: 'Modifier Frais',
                dialog: false,
                
                form: useForm({
                    type_frais_id: '',
                    montant: '',
                    niveau_id: '',
                    annee_id: '',
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
                router.get(route('frais.create', this.section_id))
            },
            editItem(item){
                //console.log('edit',item) 
                this.dialog_title = 'Modifier le frais' 
                this.form.id = item.id
                this.form.niveau_id = item.niveau_id
                this.form.type_frais_id = item.type_frais_id
                this.form.montant = item.montant
                this.form.annee_id = item.annee_id
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
                        
                       this.form.delete(route('frais.destroy', item.id), {
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
                    
                     const {id,type_frais_id,montant,niveau_id,annee_id} = this.form
                    
                    this.form.put(route('frais.update', this.form.id), {
                        onFinish: () => {
                           this.close()
                            this.$swal({
                                icon: 'success',
                                iconColor: '#004980',
                                color: '#004980',
                                title: 'Modification',
                                text: 'Frais modifié avec succès!',
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
                this.form.type_frais_id = ""
                this.form.montant = ""
                this.form.annee_id = ""
                this.dialog = false
            }
        }
    }
</script>
<template>
    <v-card>
    <Toolbar
      styleToolbar="background-color: white;"
      :icon="icons.mdiCurrencyUsd"
      toolbarTitle="Gestion des frais"
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
                                                    label="Année"
                                                    :items="annees"
                                                    variant="outlined"
                                                    itemValue="id"
                                                    itemTitle="libelle"
                                                    v-model="form.annee_id"
                                                    isRequired
                                                    :rules="[(v) => !!v || 'Ce champ est requis!']"
                                                    >
                                                </Select>
                                            </v-col>
                                        </v-row>
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
                                                <Select
                                                    label="Type Frais"
                                                    :items="typefrais"
                                                    variant="outlined"
                                                    itemValue="id"
                                                    itemTitle="libelle"
                                                    v-model="form.type_frais_id"
                                                    isRequired
                                                    :rules="[(v) => !!v || 'Ce champ est requis!']"
                                                    >
                                                </Select>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12" md="12">
                                                <text-field type="number" label="Montant" placeholder="Montant" v-model="form.montant" isRequired :rules="rules"></text-field>
                                            
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
            <Datatable titleDatatable="Liste des frais" :headers="headers" :items="frais" :functionOnClickAddButton="create" >
            
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