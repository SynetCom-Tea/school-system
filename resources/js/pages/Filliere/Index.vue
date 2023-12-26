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
       mdiContentSave,
       mdiClose
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
            mdiContentSave,
            mdiClose
        },
        layout: AuthenticatedLayout,
        props: ["filieres","section_id","cycles"],
        data() {
            return {
                icons: {
                    mdiAccountSchool,
                    mdiPlus,
                    mdiClose,
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
                        key: 'filiere.code',
                    },
                    { title: 'Nom de la filière', align: 'center', key: 'filiere.name' },
                    { title: 'Cycle', align: 'center', key: 'cycle' },
                    {title: 'Actions', align: 'center', key: 'actions'},
                ],
                dialog_title: 'Modifier la filière',
                dialog: false,

                form: useForm({
                    id:'',
                    code: '',
                    name: '',
                    option:'',
                    cycles:[],
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
                router.get(route('filieres.create', this.section_id))
            },
            createcycle(item) {

                this.form.id=item.filiere.id;
                 console.log('option',this.form.option);
                this.dialog = true;
                this.dialog_title = 'Ajouter des cycles'


            },
            editItem(item){
                this.form.option=1;
                console.log('edit',item.filiere)
                this.dialog_title = 'Modifier la filière '+ item.filiere.name
                this.form.id = item.filiere.id
                this.form.code = item.filiere.code
                this.form.name = item.filiere.name
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

                       this.form.delete(route('filieres.destroy', item.filiere.id), {
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


            deleteItemc(item){
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
                        console.log('item',item);
                    if (result.isConfirmed) {

                       this.form.delete(route('filieres.supprimer', item.id), {
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
                if(!this.form.option && valid) {
                    this.form.post(route('filieres.ajout', this.section_id), {
                        onFinish: () => {
                            //console.log(this.form)
                            this.close()

                            this.$swal({
                                icon: 'success',
                                iconColor: '#004980',
                                color: '#004980',
                                title: 'Enregistrement',
                                text: 'le cycle a été enregistrée avec succès!',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                            });
                        },
                    });

                }else if(this.form.option && valid) {

                     const {id,code,nom} = this.form

                    this.form.put(route('filieres.update', this.form.id), {
                        onFinish: () => {
                           this.close()
                            this.$swal({
                                icon: 'success',
                                iconColor: '#004980',
                                color: '#004980',
                                title: 'Modification',
                                text: 'la filière a été modifiée avec succès!',
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
                this.form.id =""
                this.form.code = ""
                this.form.name = ""
                this.form.cycles = []
                this.form.option=""
                this.dialog = false
            }
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
    },
    }
</script>
<template>
       <Toolbar
      styleToolbar="background-color: white;"
      :icon="icons.mdiSchool"
      :toolbarTitle="Title"
    ></Toolbar>
    <v-container fluid>

    <v-card variant="outlined" style="border: 2px solid #7d002c">

    <v-card-title style="color: white; background-color: #7d002c"
            >GESTION DES FILIERES</v-card-title
          >
          <v-divider></v-divider>
        <br>
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
                                            <v-col cols="12" md="12" v-if="form.option != ''">
                                                <text-field label="Code" placeholder="Code" v-model="form.code" isRequired :rules="rules"></text-field>

                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12" md="12" v-if="form.option != ''">
                                                <text-field label="Nom de la filière" placeholder="Nom de la filière" v-model="form.name" isRequired :rules="rules"></text-field>

                                            </v-col>

                                            <v-col cols="12" md="12" v-if="form.option == ''">
                                            <Autocomplete
                                                v-model="form.cycles"
                                                isRequired
                                                item-title="name"
                                                item-value="id"
                                                multiple
                                                chips
                                                class="mt-2"
                                                placeholder="Cycle"
                                                label="Cycles"
                                                :items="cycles"
                                            >
                                            </Autocomplete>
                                            <!-- <text-field label="Genre" placeholder="Genre" v-model="form.sex" isRequired :rules="rules"></text-field> -->
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
            <Datatable titleDatatable="Liste des filières" :headers="headers" :permission="'manage_school|filiere.create'" :items="filieres" :functionOnClickAddButton="create" >
                <template v-slot:item.cycle="{ item, index}">
                    <v-chip-group column selected-class="text-purple">
                        <v-chip v-for="tag in item.cycle">
                            {{ tag.cycle.name}}
                            <v-icon end  class="me-2" title="Supprimer cycle" @click="deleteItemc(tag)" v-permission:any="'manage_school|filiere.delete'" :icon="icons.mdiCloseCircle">
                            </v-icon>
                        </v-chip>
                    </v-chip-group>
                </template>
            <template v-slot:item.actions="{item}">
                <v-icon size="small" class="me-2" title="Ajouter des cycles" @click="createcycle(item)" v-permission:any="'manage_school|filiere.create'" :icon="icons.mdiPlusCircle" color="primary">
                </v-icon>
                <v-icon size="small" class="me-2" title="Modifier" @click="editItem(item)" v-permission:any="'manage_school|filiere.update'" :icon="icons.mdiPencil" color="orange">
                </v-icon>
                <v-icon size="small" class="me-2" title="Supprimer" @click="deleteItem(item)" v-permission:any="'manage_school|filiere.delete'" :icon="icons.mdiDelete" color="red">
                </v-icon>
            </template>
        </Datatable>
        </v-card-text>
    </v-card>
    </v-container>
</template>
<style>

</style>
