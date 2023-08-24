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
        mdiReceipt,
        mdiReceiptTextSendOutline,
        mdiPrinter,
        mdiBookEdit,
    } from '@mdi/js'
    import {
    useToast
} from 'vue-toastification';
const toast = useToast();
    export default {
        components: {
            mdiAccountSchool,
            mdiPencil,
            mdiDelete,
            mdiPlus,
            mdiEye,
            mdiCloseCircle,
            mdiReceipt,
            mdiReceiptTextSendOutline,
            mdiPrinter,
            mdiBookEdit,
        },
        layout: AuthenticatedLayout,
        props: ["promotions"],
        data() {
            return {
                icon: {
                    mdiAccountSchool,
                    mdiPencil,
                    mdiDelete,
                    mdiPlus,
                    mdiEye,
                    mdiCloseCircle,
                    mdiReceipt,
                    mdiReceiptTextSendOutline,
                    mdiPrinter,
                    mdiBookEdit,
                },
                searchQuery: '',
                headers: [
                    { title: 'N°', align: 'center', key: 'id' },
                    { title: 'Date début', align: 'center', key: 'date_debut' },
                    { title: 'Date Fin', align: 'center', key: 'date_fin' },
                    { title: 'Année', align: 'center', key: 'annees.annee' },
                    { title: 'Classe', align: 'center', key: 'classes.libele' },
                    { title: 'Actions', align: 'center', key: 'actions' },
                ],
            }
        },
        methods:{
            goTo() {
                router.get(route('promotions.create'))
            },
            editItem(item){
                router.get(route('promotions.edit', item.id))
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
                        router.delete(route('promotions.destroy', item.id), {
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
        <page-toolbar :icon="icon.mdiReceiptTextSendOutline">Gestion des promotions</page-toolbar>
        <v-card-text>
            <table-component 
                :headers="headers"
                :items="promotions">
                <template v-slot:addBtn>
                    <btn @click="goTo()"><v-icon>{{ icon.mdiPlus }}</v-icon> Ajouter</btn>
                </template>
                <template v-slot:[`item.actions`]="{ item }">
                    <v-icon size="large" color="warning" title="Modifier" class="me-2" @click="editItem(item.raw)" :icon="icon.mdiPencil">
                    </v-icon>
                    <v-icon size="large" color="red" title="Supprimer" class="me-2" @click="deleteItem(item.raw)" :icon="icon.mdiDelete">
                    </v-icon>
                </template>
            </table-component>
        </v-card-text>
    </v-card>
</template>
<style>
.pdfobject-container {
    height: 50rem;
    border: 1rem solid rgba(0, 0, 0, .1);
}
</style>