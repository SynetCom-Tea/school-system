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
            headers: [
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
    methods: {
        initialize() {
            this.users
        },
        goTo() {
            router.get(route("users.create"));
        },
    },
    created() {
        this.initialize()
        if (this.$page.props.flash.message) {
            this.$swal({
                icon: 'success',
                title: 'Creation',
                text: this.$page.props.flash.message,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
            });
        }
    }
};
</script>

<template>
<v-card>
    <Toolbar :icon="icon.mdiSchool" toolbarTitle="Gestion des utilisateurs"></Toolbar>
    <v-card-text>
        <Datatable :headers="headers" :items="users" :functionOnClickAddButton="goTo">
        </Datatable>
    </v-card-text>
</v-card>
</template>
