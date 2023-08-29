<script>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { router, useForm } from '@inertiajs/vue3'
    import {
        mdiAccountSchool,
        mdiPencil,
        mdiDelete,
        mdiPlus,
        mdiEye,
        mdiCloseCircle,
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
            mdiReceipt
        },
        layout: AuthenticatedLayout,
        props: ["etablissements"],
        data() {
            return {
                icon: {
                    mdiAccountSchool,
                    mdiPencil,
                    mdiDelete,
                    mdiPlus,
                    mdiEye,
                    mdiCloseCircle,
                    mdiReceipt
                },
                searchQuery: '',
                headers: [
                    {
                        title: 'ID',
                        align: 'start',
                        sortable: false,
                        key: 'id',
                    },
                    { title: 'Nom', align: 'center', key: 'name' },
                    { title: 'Mail', align: 'center', key: 'mail' },
                    { title: 'Téléphone', align: 'center', key: 'telephone' },
                    { title: 'Adresse', align: 'center', key: 'adresse' },
                    { title: 'Pays', align: 'center', key: 'pays' },
                    { title: 'Ville', align: 'center', key: 'ville' },
                    { title: 'Etablissements', align: 'center', key: 'etablissement.name' },
                    { title: 'Actions', align: 'center', key: 'actions' },
                ],
                target: {},
                show: false,
                form: useForm({}),
            }
        },
        methods:{
            goTo() {
                router.get(route('etablissements.create'))
            },
            editItem(item){
                router.get(route('etablissements.edit', item.id))
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
                        router.delete(route('etablissements.destroy', item.id))
                    }
                });
            },
            showItem(item){
                this.target = item
                this.show  = true
            }
        },
        created() {
            // console.log(this.$page.props.flash.message)
            if(this.$page.props.flash?.message?.type == 'error'){
                this.$swal(
                    'error',
                    'Oops...',
                    'Something went wrong!',
                )
            }else if(this.$page.props.flash?.message?.type == 'success'){
                this.$swal(
                    'Enregistrement / Modification!',
                    this.$page.props.flash?.message?.text,
                    'success'
                )
            }
        }
    }
</script>
<template>
    <v-card>
        <page-toolbar :icon="icon.mdiAccountSchool">Gestion des etablissements</page-toolbar>
        <v-card-text>
            <v-dialog v-model="show" max-width="750" v-if="target">
                <v-card>
                    <v-toolbar dark color="orange">
                        <v-toolbar-title> Détails de l'etablissement</v-toolbar-title>
                    </v-toolbar>
                    <v-card-text>
                        <v-card flat class="mt-3 mb-6" v-if="target.id">
                            <v-card>
                                <v-table dense >
                                    <tbody>
                                    <tr>
                                        <td class="font-weight-black">Type Etablissement :</td>
                                        <td>{{ target.type_etablissement.name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-black">Nom Etablissement :</td>
                                        <td>{{ target.name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-black">Mail </td>
                                        <td>{{ target.mail }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-black">Téléphone :</td>
                                        <td>
                                            <v-chip-group column >
                                                <v-chip label color="orange" :key="i" v-for="(t, i) in target.telephone">{{ t }}</v-chip>
                                            </v-chip-group>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-black">Adresse :</td>
                                        <td>{{ target.adresse }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-black">Pays :</td>
                                        <td>{{ target.pays }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-black">Ville :</td>
                                        <td>{{ target.ville }}</td>
                                    </tr>
                                    <tr v-if="target.fillieres[0]">
                                        <td class="font-weight-black">Fillieres :</td>
                                        <td>
                                            <v-chip-group column >
                                                <v-chip label color="orange" :key="i" v-for="(t, i) in target.fillieres">{{ t.name }}</v-chip>
                                            </v-chip-group>
                                        </td>
                                    </tr>
                                    </tbody>
                                </v-table>
                            </v-card>
                            <v-card v-if="target.facultes[0]">
                                <v-table dense>
                                    <thead>
                                    <tr>
                                        <th class="blue-grey--text">Code Faculté</th>
                                        <th class="blue-grey--text">Nom</th>
                                        <th class="blue-grey--text">Fillieres</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr :key="line.id" v-for="line in target.facultes">
                                        <td>{{ line.code }}</td>
                                        <td>{{ line.name }}</td>
                                        <td>
                                            <v-chip-group column >
                                                <v-chip label color="orange" :key="i" v-for="(t, i) in line.fillieres">{{ t.name }}</v-chip>
                                            </v-chip-group>
                                        </td>
                                    </tr>
                                    </tbody>
                                </v-table>
                            </v-card>
                        </v-card>
                    </v-card-text>
                </v-card>
            </v-dialog>
            <table-component 
                :headers="headers"
                :items="etablissements">
                <template v-slot:addBtn>
                    <btn @click="goTo()"><v-icon>{{ icon.mdiPlus }}</v-icon> Ajouter</btn>
                </template>
                <template v-slot:item.actions="{item}">
                    <v-icon size="large" color="warning" title="Modifier" class="me-2" @click="editItem(item.raw)" :icon="icon.mdiPencil">
                    </v-icon>
                    <v-icon size="large" color="red" @click="deleteItem(item.raw)" :icon="icon.mdiDelete">
                    </v-icon>
                    <v-icon size="large" color="info" @click="showItem(item.raw)" :icon="icon.mdiEye">
                    </v-icon>
                </template>
                <template v-slot:item.telephone="{item}">
                    <v-chip-group column >
                        <v-chip label color="orange" :key="i" v-for="(t, i) in item.columns.telephone">{{ t }}</v-chip>
                    </v-chip-group>
                </template>
            </table-component>
        </v-card-text>
    </v-card>
</template>

<style>
  
</style>