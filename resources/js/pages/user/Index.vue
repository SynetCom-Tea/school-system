<script>
import {
    mdiAccountGroup,
    mdiMagnify,
    mdiLogout,
    mdiPencil,
    mdiDelete,
    mdiPlus,
} from '@mdi/js'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {
    router,
    usePage,
    useForm
} from '@inertiajs/vue3';
export default {
    components: {
        mdiAccountGroup,
        mdiPlus,
    },
    layout: AuthenticatedLayout,
    props: ["users"],
    // Properties returned from data() become reactive state
    // and will be exposed on `this`.
    data() {
        return {
            form: this.$inertia.form({
                nom: '',
                email: '',
                password: '',
                password_confirmation: '',
            }),
            icon: {
                mdiAccountGroup,
                mdiPlus,
            },
            search: '',
            dialog: false,
            dialogDelete: false,
            headers: [{
                    title: 'Id',
                    align: 'start',
                    key: 'id',
                    sortable: false,
                    key: "id",
                },
                {
                    title: "Nom",
                    align: "center",
                    key: "nom"
                },
                {
                    title: "Prénom",
                    align: "center",
                    key: "prenom"
                },
                {
                    title: "Sexe",
                    align: "center",
                    key: "sex"
                },
                {
                    title: "Téléphone",
                    align: "center",
                    key: "telephone"
                },
                {
                    title: "Email",
                    align: "center",
                    key: "email"
                },
                {
                    title: "Actions",
                    align: "center",
                    key: "actions"
                },
            ],
            searchQuery: "",
            isLoading: false,
        };
    },

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
        },
    },

    watch: {
        dialog(val) {
            val || this.close()
        },
        dialogDelete(val) {
            val || this.closeDelete()
        },
    },

    created() {
        this.initialize()
        // if (this.$page.props.flash ? .message ? .type == 'success') {
        //     this.$swal(
        //         'Enregistrement / Modification!',
        //         this.$page.props.flash ? .message ? .text,
        //         'success'
        //     )
        // }
    },
    methods: {
        initialize() {
            this.users
        },
        goTo() {
            router.get(route("users.create"));
        },
    },
};
</script>

<template>
<v-card>
    <page-toolbar :icon="icon.mdiAccountGroup">Gestion des utilisateurs</page-toolbar>
    <v-card-text>
        <btn @click="goTo()">
            <v-icon>{{ icon.mdiPlus }}</v-icon> Ajouter
        </btn>
        <v-data-table :headers="headers" :items="users">

            <template v-slot:item.actions="{item}">
            </template>
        </v-data-table>
    </v-card-text>
</v-card>
</template>
