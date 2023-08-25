<!-- <script setup>
    import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
    import { Head } from "@inertiajs/vue3";
</script> -->

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
       mdiTools,

    } from '@mdi/js'
    export default {
        components: {
            mdiAccountSchool,
            mdiPlus,
            mdiPencil,
            mdiDelete,
            mdiPlusCircle,
            mdiClipboardEditOutline,
            mdiTools,
        },
        layout: AuthenticatedLayout,
        props: ["periode", "typeEvaluation", "evaluation"],
        data() {
            return {
                icon: {
                    mdiAccountSchool,
                    mdiPlus,
                    mdiPencil,
                    mdiDelete,
                    mdiPlusCircle,
                    mdiClipboardEditOutline,
                    mdiTools,
                },
                headers: [

                    { title: 'Code', align: 'center', key: 'id'},
                    { title: 'Designation', align: 'center', key: 'designation' },
                    { title: 'Type', align: 'center', key: 'type'},
                    { title: 'Etat', align: 'center', key: 'etat'},
                    {title: 'Actions', align: 'center', key: 'actions'},
                ],
                types: ['periode'],
                dialog_title: 'Nouveau Evaluation',
                dialog: false,

                form: evaluationForm({
                    id: '',
                    designation: '',
                    type: '',
                    etat: '',
                }),
            }
        },
        methods:{
            create() {
                this.dialog = true;
                this.dialog_title = 'Nouvelle Evaluation'
            },
            editItem(item){
                console.log('edit',item)
                this.dialog_title = 'Modifier Evaluation ' + item.code
                this.form.id = item.id
                this.form.code = item.code
                this.form.designation = item.designation
                this.form.type = item.type
                this.form.etat = item.etat
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

                        this.form.delete(route('besoins.destroy', item.id),{

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
                    // console.log(this.form)
                    this.form.post(route('evaluation.store'), {
                        onFinish: () => {
                            this.close()
                            this.$swal({
                                icon: 'success',
                                title: 'Enregistrement',
                                text: 'Evaluation créée avec succès!',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                            });
                        },
                    });
                }else if(this.form.id && valid) {
                    const {id, code, designation, type, etat} = this.form

                    this.form.put(route('besoins.update', this.form.id), {
                        onFinish: () => {
                            this.close()
                            this.$swal({
                                icon: 'success',
                                title: 'Enregistrement',
                                text: 'Besoin modifié avec succès!',
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
                this.form.designation = ""
                this.form.type = ""
                this.form.etat = ""
                this.dialog = false
            }
        }
    }
</script>
<template>

  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Evaluation</h2>
    </template>

    <v-card style="margin: 20px">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">Evaluation

            <v-data-table :headers="headers" :items="items" item-key="id">
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>Ma Data Table</v-toolbar-title>
      </v-toolbar>
      <v-dialog v-model="dialog" transition="dialog-top-transition" persistent width="900px">
                        <template v-slot:activator="{ props }">
                            <div class="custom-add-button" >
                                <v-btn @click="create" x-small variant="outlined" color="primary" v-bind="props"> Ajouter
                                </v-btn>
                            </div>
                        </template>
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
                                        <v-container>
                                            <v-row>

                                            <v-col
                                                cols="12"
                                                sm="6"
                                            >
                                            <v-text-field
                                                label="Date d'evaluation *"
                                                type="date"
                                                required
                                                ></v-text-field>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                            >
                                            <v-text-field
                                                label="Poucentage de l'evaluation en % *"
                                                type="text"
                                                required
                                                ></v-text-field>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                            >
                                                <v-select
                                                :items="['1', '2', '3', '4']"
                                                label="Periode *"
                                                required
                                                ></v-select>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                            >
                                                <v-select
                                                :items="['1', '2', '3', '4']"
                                                label="Type evaluation*"
                                                required
                                                ></v-select>
                                            </v-col>

                                            </v-row>
                                        </v-container>
                                    </v-form>
                                </v-card-text>
                                <v-card-actions class="justify-end">
                                    <v-spacer></v-spacer>
                                    <v-btn dark small type="button" color="red" @click="close">
                                        <v-icon :icon="icon.mdiCancel" left></v-icon> Annuler
                                    </v-btn>
                                    <v-btn small color="success" @click="submit">
                                        <v-icon :icon="icon.mdiCheckCircle" left></v-icon> Enregistrer
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </template>
                    </v-dialog>
    </template>
  </v-data-table>
          </div>
        </div>
      </div>
    </v-card>
  </AuthenticatedLayout>
</template>
