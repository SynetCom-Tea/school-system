<script>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { useForm,router } from '@inertiajs/vue3';

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
                        key: 'enseignant.matricule',
                    },
                    { title: 'Nom et Prénom', align: 'center', key: 'enseignant.NomComplet' },
                    { title: 'Matières/Classes', align: 'center', key: 'list' },
                    { title: 'Année scolaire', align: 'center', key: 'annee' },
                    {title: 'Actions', align: 'center', key: 'actions'},
                ],
                dialog_title: 'Affectation des enseignants',
                dialog: false,

                form: useForm({
                    id:null,
                    matiere:null,
                    classe:null,
                    enseignant: null,

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

            setclasses(){
            this.form.classe=null;
            this.$emit('input',this.form.matiere)
            let mat=this.form.matiere;
            console.log('mat',this.form.matiere);
            router.replace(this.$page.url,{data:{matiere:mat}});
            console.log('fdgfggg',this.classes);


        },
            create() {
                router.get(route('affectationEnseignants.create', this.section_id));
            },
            editItem(item){
                console.log('edit',item)
            //     this.$emit('input',this.form.matiere)
            // let mat=this.form.matiere;
            // console.log('mat',this.form.matiere);
            if(this.section_id<=2){
                router.replace(this.$page.url,{data:{matiere:item.niveau_matiere.matiere.id}});
            }else{
                router.replace(this.$page.url,{data:{matiere:item.filiere_niveau_matiere_ue.matiere.id}});
            }
                // router.get(route('AffectationEnseignants.edit',item.id ));


                console.log('classes',this.classes)
                this.dialog_title = 'Mise à jour d\'affectation de'+ " "+item.enseignant.NomComplet

                this.form.id = item.id
                this.form.classe = item.classe_annee_id
                if(this.section_id<=2){
                     this.form.matiere = item.niveau_matiere.matiere_id
                }else{
                    this.form.matiere = item.filiere_niveau_matiere_ue.matiere_id
                }
                this.form.enseignant= item.enseignant_id
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
                this.form.id =null
                this.form.matiere =null
                this.form.enseignant = null
                this.form.classe = null
                this.dialog = false
            }
        },
    computed: {
        Title() {
            console.log('eeeef',this.enseignements);
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
            >AFFECTATION DES MATIÈRES ET CLASSES AUX ENSEIGNANTS</v-card-title
          >
          <v-divider></v-divider>
        <br>
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
                                                    chips
                                                    :items="enseignants"
                                                    :rules="[(v) => !!v || 'Ce champ est requis!']"
                                                    >
                                                </Autocomplete>

                                            </v-col>

                                            <v-col cols="12" md="12">
                                                <Autocomplete
                                                    v-model="form.matiere"
                                                    isRequired
                                                    itemValue="id"
                                                    itemTitle="code"
                                                    placeholder="Matiere"
                                                    label="Matiere"
                                                    chips
                                                    @update:modelValue="setclasses()"
                                                    :items="niveauMatieres"
                                                    :rules="[(v) => !!v || 'Ce champ est requis!']"
                                                    >
                                                </Autocomplete>

                                            </v-col>

                                            <v-col cols="12" md="12" >
                                                <autocomplete
                                                    v-model="form.classe"
                                                    isRequired
                                                    placeholder="Classes"
                                                    label="Classes"
                                                    chips
                                                    :items="classes"
                                                    :rules="[(v) => !!v || 'Ce champ est requis!']"
                                                    item-value="id"
                                                    item-title="classe.libelle"
                                                    >
                                                </autocomplete>

                                            </v-col>



                                        </v-row>

                                    </v-form>
                                    </v-card-text>



                    <v-card-actions class="justify-end">
                        <v-spacer></v-spacer>
                        <Button color="red" variant="outlined" class="mb-2" style="height: 30px" nameButton="Annuler" title="Annuler"  :prependIcon="icons.mdiCancel" @click="close"></Button>
                        <Button variant="outlined" class="mb-2" nameButton="Enregistrer" title="Valider et Fermer la modale" style="height: 30px" :prependIcon="icons.mdiContentSave" @click="submit"></Button>
                    </v-card-actions>
                </v-card>


            </template>

                </v-dialog>
        <v-card-text>
            <Datatable titleDatatable="Liste des enseignements  " :headers="headers" :items="enseignements" :functionOnClickAddButton="create" >
                <template v-slot:item.list="{ item, index}">
                    <v-chip-group column selected-class="text-purple">
                        <v-chip v-for="tag in item.list">
                            {{ tag.classe.libelle }} =>{{ tag.matiere.nom }}
                            <v-icon end size="small" class="me-2" title="Modifier" @click="editItem(tag.id)" :icon="icons.mdiPencil" color="orange">
                            </v-icon>
                            <v-icon size="small" class="me-2" title="Supprimer" @click="deleteItem(tag.id)" :icon="icons.mdiDelete" color="red">
                            </v-icon>

                        </v-chip>
                    </v-chip-group>
                </template>
            <template v-slot:item.actions="{item}">
                <v-icon size="small" class="me-2" title="Supprimer" @click="deleteItem(item.raw)" :icon="icons.mdiDelete" color="red">
                </v-icon>
            </template>
        </Datatable>
        </v-card-text>
    </v-card>
</v-container>
</template>
<style>

</style>
