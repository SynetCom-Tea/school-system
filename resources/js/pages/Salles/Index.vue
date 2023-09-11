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
    mdiCheckCircle,
    mdiAccount
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
                mdiCheckCircle,
                mdiAccount
            },
            itemsPerPage: 10,
            headerws: [
                { text: 'Dessert Name', value: 'name' },
                // Add other headers here
            ],
            desserts: [
                { name: 'Cake', calories: 250 },
                // Add other dessert items here
            ],
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
                    key: 'libelle'
                },
                {
                    title: 'Actions',
                    align: 'center',
                    key: 'actions'
                },
            ],
            dialog_title: 'Nouvelle Salle',
            dialog: false,
            isDialog: false,
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
        // create() {
        //     this.dialog = true;
        // },
        // editItem(item) {
        //     this.editdata.code = item.code
        //     this.editdata.libele = item.libele
        //     this.editdata.id = item.id
        //     this.dialogEdit = true
        // },
        // deleteItem(item) {
        //     this.editdata.id = item.id
        //     this.$swal({
        //         title: 'Es-tu sûr?',
        //         text: "Vous ne pourrez pas revenir en arrière !",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: 'orange',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Oui, supprimez-le!',
        //         cancelButtonText: 'Non, annulez !',
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             this.editdata.delete(route('salles.destroy', this.editdata.id), {
        //                 onFinish: () => {
        //                     this.$swal(
        //                         'Supprimé!',
        //                         'Votre element a été supprimé.',
        //                         'success'
        //                     )
        //                 }
        //             })
        //         }
        //     });
        // },
        // submit() {
        //     this.form.post(route('salles.store'), {
        //         onSuccess: () => {
        //             this.form.reset()
        //             this.dialog = false
        //             this.$swal({
        //                 icon: 'success',
        //                 title: 'Enregistrement',
        //                 text: 'Salle créé avec succès!',
        //                 toast: true,
        //                 position: 'top-end',
        //                 showConfirmButton: false,
        //                 timer: 5000,
        //                 timerProgressBar: true,
        //             });
        //         },
        //     });
        // },
        // submitEdit() {
        //     this.editdata.put(route('salles.update', this.editdata.id), {
        //         onSuccess: () => {
        //             this.editdata.reset(),
        //             this.dialogEdit = false
        //             this.$swal({
        //                 icon: 'success',
        //                 title: 'Modification',
        //                 text: 'Salle modifiée avec succès!',
        //                 toast: true,
        //                 position: 'top-end',
        //                 showConfirmButton: false,
        //                 timer: 5000,
        //                 timerProgressBar: true,
        //             });
        //         },
        //     })
        // },
        close() {
            this.dialog = false
            this.dialog_title = 'Nouvelle Salle'
            this.form = {}
        },
        closeEdit() {
            this.dialogEdit = false
        },
        onClickBt() {
            this.isDialog = !this.isDialog;
        },
        onCloseModale() {
            this.isDialog = false;
        },
        onChangeTitle(e) {
            console.log("testE:", e.target.value);
        },
        editItem(){console.log("testE:");}
    }
}
</script>
<template>
<v-card>
    <Toolbar
      styleToolbar="background-color: white;"
      :icon="icon.mdiGoogleClassroom"
      toolbarTitle="Gestion des Salles"
    ></Toolbar>
    <v-card-text>
        <Datatable titleDatatable="Liste des salles de cours "
        :headers="headers" :items="salles"
          :functionEditItem="editItem"
        />

    </v-card-text>

</v-card>
</template>

