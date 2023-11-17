<template>
    <Toolbar
      styleToolbar="background-color: white;"
      :icon="icons.mdiSchool"
      :toolbarTitle="Title"
    ></Toolbar>
    <v-card variant="outlined" style="border: 2px solid #7d002c">
        <v-card-title style="color: white; background-color: #7d002c">Parametrage</v-card-title>
        <v-divider></v-divider>
        <div style="margin: 10px;font-size: 16px;">
            <v-alert v-model="alertFirst" border="start" variant="tonal" color="primary" type="info" title="Note">
                <li>
                    Cette section vous permet de configurer les <b>TYPE DE FRAIS, DOCUMENTS et NOMBRE LIMITE</b> des élèves autorisés dans une seule classe
                </li>
                <li>
                    Le formulaire sera valide <strong>si et seulement si </strong>les deux tableaux ont au moins un element coché
                </li>
                <li>
                    Un type de frais déjà utilisé dans frais ne pourra pas être décocher
                </li>
            </v-alert>
        </div>
        <v-expansion-panels>
            <v-expansion-panel>
                <v-expansion-panel-title>
                    <template v-slot:default="{ open }">
                        <v-row no-gutters>
                            <v-col cols="4" class="d-flex justify-start">
                                Cocher les&nbsp;<span style="font-size: 15px; color: blue;">TYPES DE FRAIS</span>&nbsp;que vous utilisiez
                            </v-col>
                            <v-col
                                cols="8"
                                class="text-grey"
                            >
                                <v-fade-transition leave-absolute>
                                    <span
                                        v-if="open"
                                        key="0"
                                    >
                                        Cocher les types de frais
                                    </span>
                                    <span
                                        v-else
                                        key="1"
                                    >
                                        {{ items_frais.length == 0 ? 'Vous n\'avez coché aucun frais' : items_frais }}
                                    </span>
                                </v-fade-transition>
                            </v-col>
                        </v-row>
                    </template>
                </v-expansion-panel-title>
                <v-expansion-panel-text>
                    <v-data-table
                        v-model="form.selected_frais"
                        :headers="headers_frais"
                        :items="type_frais"
                        @update:modelValue="rowClickFrais(form.selected_frais)"
                        item-value="id"
                        show-select
                        class="elevation-1"
                    ></v-data-table>
                </v-expansion-panel-text>
            </v-expansion-panel>

        <!-- **************************** fin type frais ************************** -->

            <v-expansion-panel>
                <v-expansion-panel-title v-slot="{ open }">
                    <v-row no-gutters>
                        <v-col cols="4" class="d-flex justify-start">
                            Cocher les&nbsp;<span style="font-size: 15px; color: blue;">TYPES DE DOCUMENTS</span>&nbsp;que vous utilisiez
                        </v-col>
                        <v-col
                        cols="8"
                        class="text-grey"
                        >
                            <v-fade-transition leave-absolute>
                                <span
                                v-if="open"
                                key="0"
                                >
                                Cocher les types de documents
                                </span>
                                <span
                                v-else
                                key="1"
                                >
                                {{ items_documents.length == 0 ? 'Vous n\'avez coché aucun document' : items_documents }}
                                </span>
                            </v-fade-transition>
                        </v-col>
                    </v-row>
                </v-expansion-panel-title>
                <v-expansion-panel-text>
                    <v-row no-gutters>
                        <v-spacer></v-spacer>
                        <v-data-table
                            v-model="form.selected_documents"
                            :headers="headers_documents"
                            :items="type_documents"
                            @update:modelValue="rowClickDocument(form.selected_documents)"
                            item-value="id"
                            show-select
                            class="elevation-1"
                        >
                        <template v-slot:item.obligatoire="{ item }">
                            <v-checkbox
                                v-model="item.obligatoire"
                                :label="`${item.obligatoire}` == 'true' ? 'Oui' : 'Non'"
                            ></v-checkbox>
                        </template>
                    </v-data-table>
                    </v-row>
                </v-expansion-panel-text>
            </v-expansion-panel>

         <!-- **************************** fin type documents ************************** -->

            <v-expansion-panel>
                <v-expansion-panel-title v-slot="{ open }">
                    <v-row no-gutters>
                        <v-col cols="5" class="d-flex justify-start">
                            Définissez le&nbsp;<span style="font-size: 15px; color: blue;">NOMBRE LIMITE</span>&nbsp;des élèves dans une classe
                        </v-col>
                        <v-col
                        cols="7"
                        class="text-grey"
                        >
                            <v-fade-transition leave-absolute>
                                <span v-if="open">When do you want to travel?</span>
                                <v-row
                                v-else
                                no-gutters
                                style="width: 100%"
                                >
                                    <v-col cols="7" class="d-flex justify-start">
                                        {{ form.nbre_limite ? 'Nombre limite:' + form.nbre_limite : 'Vous n\'avez pas encore saisi' }}
                                    </v-col>
                                </v-row>
                            </v-fade-transition>
                        </v-col>
                    </v-row>
                </v-expansion-panel-title>
                <v-expansion-panel-text>
                    <v-row
                        justify="space-around"
                        no-gutters
                    >
                        <v-col cols="3">
                            <v-text-field
                                v-model="form.nbre_limite"
                                label="Nombre limite"
                                type="number"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                </v-expansion-panel-text>
            </v-expansion-panel>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                variant="text"
                color="secondary"
                @click="retour"
                >
                Annuler
                </v-btn>
                <v-btn
                variant="text"
                color="primary"
                @click="submit"
                >
                Enregistrer
                </v-btn>
            </v-card-actions>
        </v-expansion-panels>
    </v-card>
  </template>
  <script>
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
  import { router, useForm } from "@inertiajs/vue3";
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
    props: ["type","type_documents","type_frais","liste_document","liste_frais","nbre"],
    data: () => ({
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
        headers_frais: [
          { title: 'Libelle', key: 'libelle' },
        ],
        headers_documents: [
          { title: 'Libelle', key: 'libelle' },
          { title: 'Obligatoire', key: 'obligatoire' },
        ],
        items_frais: [],
        items_documents: [],
        form: useForm({
            nbre_limite: null,
            selected_frais: [],
            selected_documents: [],
            selected_obligatoires: [],
            section: null
        }),
    }),
    created(){
        this.createdHandler()
    },
    computed: {
        Title() {

        switch (this.type) {
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
    methods: {
        createdHandler() {
            this.items_frais = [],
            this.items_documents = [],
            console.log('liste_document',this.liste_document,'type_document',this.type_documents);
            if (this.liste_frais && this.liste_frais.length > 0) {
                this.form.selected_frais = this.liste_frais.map((e)=>{
                    this.items_frais.push(e.type_frais.libelle)
                    return e.type_frais?.id
                })
            }
            if (this.liste_document && this.liste_document.length > 0) {
                this.form.selected_documents = this.liste_document.map((e)=>{
                    if(e){
                        let find = this.type_documents.find((el)=> el.id == e.type_document.id)
                        if(e.obligatoire == 1){
                            find.obligatoire = true
                        }
                    }
                    this.items_documents.push(e.type_document.libelle)
                    return e.type_document?.id
                }) 
            }
            this.form.nbre_limite = this.nbre ? this.nbre : null
            console.log('type_document',this.type_documents,this.form.selected_frais,this.items_frais,this.form.selected_documents,this.items_documents);
    
            // // Vous pouvez ajouter une logique ici pour gérer les mises à jour du champ de saisie.
            // console.log(`Mise à jour de customField pour l'élément ${item.id} : ${item.obligatoire}`);
        },
        rowClickFrais(ids){
            let tabs = this.type_frais.filter((el) => ids.includes(el.id))
            this.items_frais = tabs.map((e)=>{
                return e.libelle
            })
        },
        rowClickDocument(ids){
            let tabs = this.type_documents.filter((el) => ids.includes(el.id))
            this.items_documents = tabs.map((e)=>{
                return e.libelle
            })
        },
        retour(){
            router.get(route('admin.gestion',this.type))
        },
        submit(){
            if(this.form.selected_frais.length == 0 || this.form.selected_documents.length == 0 ){
                this.$swal({
                    icon: 'error',
                    title: 'Echec de l\'enregistrement',
                    text: 'Les deux tableaux doivent avoir au moins une ligne cochée',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 10000,
                    timerProgressBar: true,
                });
            }else{
                this.$swal({
                    title: 'Etês-vous sûr de vouloir enregistrer?',
                    text: "Vous ne pouviez pas revenir en arrière !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#004980',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, enregistrer!',
                    cancelButtonText: 'Non, annuler !',
                    }).then((result) => {
                    if (result.isConfirmed) {
                        this.form.section = this.type
                        let tabs = this.type_documents.filter(item => item.obligatoire);
                        this.form.selected_obligatoires = tabs.map((e)=> {
                            return e.id
                        })
                       this.form.post(route('param.save'), {
                        onFinish: () => {
                            if(this.$page.props.flash?.message?.type == 'error'){
                                this.$swal({
                                icon: 'error',
                                title: 'Echec de l\'enregistrement',
                                text: this.$page.props.flash?.message?.text,
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 10000,
                                timerProgressBar: true,
                            });
                            }else if(this.$page.props.flash?.message?.type == 'success'){
                                this.createdHandler();
                                this.$swal({
                                icon: 'success',
                                iconColor: '#004980',
                                color: '#004980',
                                title: 'Enregistrement réussi',
                                text: this.$page.props.flash?.message?.text,
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 10000,
                                timerProgressBar: true,
                            });
                            }
                        },
                        });
                    }
                });
            }
        }
    }
  }
</script>