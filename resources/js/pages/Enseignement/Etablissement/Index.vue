<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Datatable from "@/components/customizedComponents/datatable.vue";

import {
    router,
    useForm
} from '@inertiajs/vue3'
import {
    mdiAccountSchool,
    mdiPencil,
    mdiDelete,
    mdiPlus,
    mdiEye,
    mdiCloseCircle,
    mdiCheckCircle,
    mdiReceipt
} from '@mdi/js'
export default {
    components: {
        mdiAccountSchool,
        mdiPencil,
        mdiDelete,
        mdiPlus,
        mdiEye,
        mdiCloseCircle,
        mdiReceipt,
        Datatable,
        mdiCheckCircle
    },
    layout: AuthenticatedLayout,
    props: ["type_etablissements","etablissements"],
    data() {
        return {
            icon: {
                mdiAccountSchool,
                mdiPencil,
                mdiDelete,
                mdiPlus,
                mdiEye,
                mdiCloseCircle,
                mdiCheckCircle,
                mdiReceipt
            },
            headers: [{
                    title: 'Nom',
                    align: 'start',
                    sortable: false,
                    key: 'name',
                },
                {
                    title: 'Type etablissement',
                    align: 'center',
                    key: 'type_etablissement.name'
                },
                {
                    title: 'Email',
                    align: 'center',
                    key: 'mail'
                },
            ],
            searchQuery: '',
            target: {},
            show: false,
            form: useForm({
                name: null,
                ville: null,
                tel: null,
                type_etablissement_id: null,
                mail: null,
                adresse: null,
            }),
        }
    },
    methods: {
        goTo() {
            this.show = true
            // router.get(route('enseignement/etablissements.create'))
        },
        close() {
            this.show = false
        },
        submit() {
            this.form.post(route('etablissements.store'),{
                onFinish: () => {
                this.form.reset() 
                this.show = false
                this.$swal({
                    icon: 'success',
                    title: 'Enregistrement',
                    text: 'Etablissement enregistré avec succès!',
                    toast: true,
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                });
            }, 
            }) 
        }

    },
    created() {
        // console.log(this.type_etablissements)
        // console.log(this.$page.props.flash.message)
        // if (this.$page.props.flash ? .message ? .type == 'error') {
        //     this.$swal(
        //         'error',
        //         'Oops...',
        //         'Something went wrong!',
        //     )
        // } else if (this.$page.props.flash ? .message ? .type == 'success') {
        //     this.$swal(
        //         'Enregistrement / Modification!',
        //         this.$page.props.flash ? .message ? .text,
        //         'success'
        //     )
        // }
    }
}
</script>
<template>
<v-card>
    <page-toolbar :icon="icon.mdiAccountSchool">Gestion des etablissements</page-toolbar>
    <v-dialog v-model="show" max-width="750">
        <v-card>
            <v-toolbar dark style="background-color: #45007d">

                <v-toolbar-title>
                    <v-icon>{{ icon.mdiPlus }}</v-icon> Ajouter nouvel etablissement
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn :icon="icon.mdiCloseCircle" title="Annuler" color="red" @click="close()"></v-btn>
            </v-toolbar>
            <v-card-text>
                <v-card flat class="mb-6">
                    <v-row>
                        <v-col md="6">
                            <v-autocomplete label="Type Etablissement" :isRequired="true" :items="type_etablissements" item-title="name" item-value="id" v-model="form.type_etablissement_id" v-model:search="modelSearch" :variant="variant">
                            </v-autocomplete>
                        </v-col>
                        <v-col md="6">
                            <TextField label="Nom de l'etablissement" outlined :isRequired="true" v-model="form.name" dense></TextField>
                        </v-col>

                    </v-row>
                    <v-row>
                        <v-col md="6">
                            <TextField label="Email" outlined v-model="form.mail" dense></TextField>
                        </v-col>
                        <v-col md="6">
                            <TextField label="Telephone" outlined v-model="form.tel" dense></TextField>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col md="6">
                            <TextField label="Adresse" outlined v-model="form.adresse" dense></TextField>
                        </v-col>
                        <v-col md="6">
                            <TextField label="Ville" outlined v-model="form.ville" dense></TextField>
                        </v-col>
                    </v-row>
                </v-card>
                <v-card-actions class="justify-end">
                    <v-spacer></v-spacer>
                    <v-btn small color="success" variant="outlined" @click="submit">
                        <v-icon :icon="icon.mdiCheckCircle" left></v-icon> Enregistrer
                    </v-btn>
                </v-card-actions>
            </v-card-text>
        </v-card>

    </v-dialog>
    <v-card-text>
        <btn @click="goTo()">
            <v-icon>{{ icon.mdiPlus }}</v-icon> Ajouter
        </btn>
        <v-data-table :headers="headers" :items="etablissements">
        </v-data-table>
    </v-card-text>
</v-card>
</template>

<style>
  
</style>
