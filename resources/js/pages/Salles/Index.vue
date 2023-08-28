<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {
    useForm
} from '@inertiajs/vue3'
import {
    mdiGoogleClassroom,
    mdiPlus,
    mdiPencil,
    mdiDelete,
    mdiPlusCircle,
    mdiCancel,
    mdiCheckCircle
} from '@mdi/js'
export default {
    components: {
        mdiGoogleClassroom,
        mdiPlus,
        mdiPencil,
        mdiDelete,
        mdiPlusCircle,
        mdiCancel,
        mdiCheckCircle
    },
    layout: AuthenticatedLayout,
    props: ["salles"],
    data() {
        return {
            icon: {
                mdiGoogleClassroom,
                mdiPlus,
                mdiPencil,
                mdiDelete,
                mdiPlusCircle,
                mdiCancel,
                mdiCheckCircle
            },
            headers: [{
                    title: 'ID',
                    align: 'start',
                    sortable: false,
                    key: 'id',
                },
                {
                    title: 'Code salle',
                    align: 'center',
                    key: 'code'
                },
                {
                    title: 'Nom salle',
                    align: 'center',
                    key: 'libele'
                },
                {
                    title: 'Actions',
                    align: 'center',
                    key: 'actions'
                },
            ],
            dialog_title: 'Nouvelle Salle',
            dialog: false,
            dialogEdit: false,
            form: useForm({
                libele: '',
                code: '',
            }),
            editdata: useForm({
                id:null,
                libele: '',
                code: '',
            }),
        }
    },
    methods: {
        create() {
            this.dialog = true;
        },
        editItem(item) {
            this.editdata.code = item.code
            this.editdata.libele = item.libele
            this.editdata.id = item.id
            this.dialogEdit = true
        },
        deleteItem(item) {
            this.editdata.id = item.id
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
                    this.editdata.delete(route('salles.destroy', this.editdata.id), {
                        onFinish: () => {
                            this.$swal(
                                'Supprimé!',
                                'Votre element a été supprimé.',
                                'success'
                            )
                        }
                    })
                }
            });
        },
        submit() {
            this.form.post(route('salles.store'), {
                onSuccess: () => {
                    this.form.reset()
                    this.dialog = false
                    this.$swal({
                        icon: 'success',
                        title: 'Enregistrement',
                        text: 'Salle créé avec succès!',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                    });
                },
            });
        },
        submitEdit() {
            this.editdata.put(route('salles.update', this.editdata.id), {
                onSuccess: () => {
                    this.editdata.reset(),
                    this.dialogEdit = false
                    this.$swal({
                        icon: 'success',
                        title: 'Modification',
                        text: 'Salle modifiée avec succès!',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                    });
                },
            })
        },
        close() {
            this.dialog = false
            this.dialog_title = 'Nouvelle Salle'
            this.form = {}
        },
        closeEdit() {
            this.dialogEdit = false
        }
    }
}
</script>
<template>
<v-card>
    <page-toolbar :icon="icon.mdiGoogleClassroom">Gestion des Salles</page-toolbar>
    <v-card-text>
        <v-dialog v-model="dialogEdit" transition="dialog-top-transition" persistent width="500px">
            <template v-slot:default="{ isActive }">
                <v-card>
                    <v-toolbar dense color="orange" dark>
                        <v-toolbar-title>
                            <v-icon left :icon="icon.mdiPencil"></v-icon> Modifier la Salle {{ editdata.code }}
                        </v-toolbar-title>
                        <v-spacer></v-spacer>
                    </v-toolbar>
                    <v-card-text>
                        <v-form>
                            <v-row>
                                <v-col cols="12" md="12">
                                    <text-field label="Code" placeholder="Code" v-model="editdata.code"></text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12" md="12">
                                    <text-field name="libele" label="Libelle" placeholder="Libelle" v-model="editdata.libele"></text-field>
                                </v-col>
                            </v-row>
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-spacer></v-spacer>
                        <v-btn dark variant="outlined" small type="button" color="red" @click="closeEdit">
                            <v-icon :icon="icon.mdiCancel" left></v-icon> Annuler
                        </v-btn>
                        <v-btn small variant="outlined" color="warning" @click="submitEdit">
                            <v-icon :icon="icon.mdiPencil" left></v-icon> Modifier
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </template>
        </v-dialog>
        <table-component :headers="headers" :items="salles">
            <template v-slot:addBtn>
                <v-dialog v-model="dialog" transition="dialog-top-transition" persistent width="500px">
                    <template v-slot:activator="{ props }">
                        <div class="custom-add-button">
                            <v-btn @click="create" x-small variant="outlined" color="green" v-bind="props">
                                <v-icon :icon="icon.mdiPlus"></v-icon> Ajouter
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
                                <v-form>
                                    <v-row>
                                        <v-col cols="12" md="12">
                                            <text-field label="Code de la salle" placeholder="Code de la salle" v-model="form.code"></text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="12" md="12">
                                            <text-field libele="libele" label="Nom de la salle" placeholder="Nom de la salle" v-model="form.libele"></text-field>
                                        </v-col>
                                    </v-row>
                                </v-form>
                            </v-card-text>
                            <v-card-actions class="justify-end">
                                <v-spacer></v-spacer>
                                <v-btn dark variant="outlined" small type="button" color="red" @click="close">
                                    <v-icon :icon="icon.mdiCancel" left></v-icon> Annuler
                                </v-btn>
                                <v-btn small variant="outlined" color="success" @click="submit">
                                    <v-icon :icon="icon.mdiCheckCircle" left></v-icon> Enregistrer
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </template>
                </v-dialog>
            </template>
            <template v-slot:item.actions="{item}">
                <v-icon size="small" color="warning" title="Modifier" class="me-2" @click="editItem(item.raw)" :icon="icon.mdiPencil">
                </v-icon>
                <v-icon size="small" color="error" @click="deleteItem(item.raw)" :icon="icon.mdiDelete">
                </v-icon>
            </template>
        </table-component>
    </v-card-text>
</v-card>
</template>
