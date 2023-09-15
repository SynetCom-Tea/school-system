<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {
    router,
    useForm
} from '@inertiajs/vue3';
import {
    mdiSecurity,
    mdiClose,
    mdiPlus,
    mdiCancel,
    mdiCheckCircle,
    mdiCloseCircle,
    mdiPencil,
    mdiDelete
} from '@mdi/js'

export default {
    components: {
        mdiPencil,
        mdiDelete,
        mdiSecurity,
        mdiClose,
        mdiPlus,
        mdiCancel,
        mdiCheckCircle,
        mdiCloseCircle
    },
    layout: AuthenticatedLayout,
    props: ["permission_role_users", "roles", "permissions", "permission"],
    data() {
        return {
            role_p_a: null,
            role_p_u: null,
            form: useForm({
                role_id: null,
                name: '',
                permissions: null,
            }),
            icon: {
                mdiPencil,
                mdiDelete,
                mdiCloseCircle,
                mdiSecurity,
                mdiClose,
                mdiPlus,
                mdiCancel,
                mdiCheckCircle
            },
            headers: [{
                    title: 'Libellé',
                    align: 'center',
                    key: 'role.name'
                },
                {
                    title: 'Permissions',
                    align: 'center',
                    key: 'permissions'
                },
                {
                    title: 'Actions',
                    align: 'center',
                    key: 'actions'
                },
            ],
            dialog: false,
            dialogEdit: false,
            item: null,
            permission_roles: [],
            searchQuery: null,
        }
    },
    methods: {
        create() {
            this.dialog = true;
        },
        submit() {
            // console.log(this.form)
            this.form.post(route('roles.store'), {
                onFinish: () => {
                    this.form = {}
                    this.dialog = false
                    if (this.$page.props.flashd.messages) {
                        this.$swal({
                            icon: 'error',
                            title: 'Attetion!!',
                            text: this.$page.props.flashd.messages,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                        });
                    }
                    if (this.$page.props.flash.message) {
                        this.$swal({
                            icon: 'success',
                            title: 'Enregistrement',
                            text: this.$page.props.flash.message,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                        });
                    }

                },
            });
        },
        editItem(item) {
            // console.log(item.role.id)
            if (this.$page.props.auth.user.id != 1) {
                this.$inertia.replace(this.$page.url, {
                    data: {
                        role: item.role.id,
                    },
                })
            }
            this.dialogEdit = true
            this.form.name = item.role.name
            this.form.permissions = item.permissions.map(el => el.permission)
        },

        update() {
            this.form.put(route('roles.update', this.role.item), {
                onFinish: () => {
                    this.form.reset()
                    this.dialogEdit = false

                    this.$swal({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Modification',
                        text: 'Role modifié avec succès!',
                        toast: true,
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                        //netstat -ano | findstr :8000
                        //chkdsk/f
                    });
                },
            })
        },
        deleteItem(item) {
            // console.log(this.$page.props.auth.id)
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
                    this.form.delete(route('roles.destroy', item.id), {
                        onFinish: () => {
                            this.dialogEdit = false
                            this.form.reset()
                            this.$swal({
                                icon: 'success',
                                title: 'Supperssion',
                                text: 'Role supprimé avec succès!',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                            });
                        },
                    })
                }
            });
        },
        close() {
            this.dialog = false
        },
        closeEdit() {
            this.dialogEdit = false
        },
        setPermission(e) {
            // console.log('message',e)
            this.$inertia.replace(this.$page.url, {
                data: {
                    role: e,
                },

            })
        }
    },
    mounted() {
        this.role_p_u = this.roles.filter(el => el.name !== 'Administrateur' && el.name !== 'Super-administrateur')
        this.role_p_a = this.roles.filter(el => el.name !== 'Super-administrateur')
        // console.log('roles',this.roles)
        // this.permission_roles =  this.permission_role_users
    }
}
</script>

<template>
<v-card>
    <page-toolbar :icon="icon.mdiSecurity"> Gestion des rôles</page-toolbar>
    <v-card-text>

        <v-dialog v-model="dialog" transition="dialog-top-transition" persistent width="500px">
            <template v-slot:activator="{ props }">
                <div class="custom-add-button">
                    <v-btn @click="create" x-small variant="outlined" color="green" v-bind="props"> Ajouter
                    </v-btn>
                </div>
            </template>
            
        </v-dialog>
        <v-dialog v-model="dialogEdit" transition="dialog-top-transition" persistent width="500px">
            <template v-slot:default="{ isActive }">
                <v-card>
                    <v-toolbar dense style="background-color: #45007d">
                        <v-toolbar-title>
                            <v-icon left :icon="icon.mdiPencil"></v-icon> Modification de Rôle
                        </v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-btn :icon="icon.mdiCloseCircle" title="Annuler" color="red" @click="closeEdit()"></v-btn>
                    </v-toolbar>
                    <v-card-text>
                        <v-form>
                            <v-row v-if="$page.props.auth.user.id == 1">
                                <Autocomplete label="Role" disabled v-model="form.name" item-title="name" item-value="id" :items="role_p_a" variant="solo-filled" chips clearable>
                                </Autocomplete>
                            </v-row>
                            <v-row v-if="$page.props.auth.user.id !=1">
                                <Autocomplete label="Role" disabled v-model="form.name" itemTitle="name" itemValue="id" :items="role_p_u" chips clearable>
                                </Autocomplete>
                            </v-row>
                            <v-row v-if="$page.props.auth.user.id ==1">
                                <Autocomplete v-model="form.permissions" label="Permission" itemTitle="description" itemValue="id" :items="permissions" variant="solo-filled" multiple chips clearable>
                                </Autocomplete>
                            </v-row>
                            <v-row v-if="$page.props.auth.user.id !== 1">
                                <Autocomplete v-model="form.permissions" label="Permission" itemTitle="description" itemValue="id" :items="permission" multiple chips clearable>
                                </Autocomplete>
                            </v-row>
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-spacer></v-spacer>
                        <v-btn small color="success" variant="outlined" @click="update">
                            <v-icon :icon="icon.mdiPencil" left></v-icon> Modifier
                        </v-btn>
                    </v-card-actions>
                </v-card> 
            </template>
        </v-dialog>
        <Datatable :headers="headers" :items="permission_role_users" :search="searchQuery">
            <template v-slot:addDialogContent>
                
                        <v-form>
                            <v-row v-if="$page.props.auth.user.id == 1">
                                <Autocomplete label="Role" v-model="form.role_id" item-title="name" item-value="id" :items="role_p_a" variant="solo-filled" chips clearable>
                                </Autocomplete>
                            </v-row>
                            <v-row v-if="$page.props.auth.user.id !=1">
                                <Autocomplete label="Role" v-model="form.role_id" @update:modelValue="setPermission(form.role_id)" itemTitle="name" itemValue="id" :items="role_p_u" chips clearable>
                                </Autocomplete>
                            </v-row>
                            <v-row v-if="$page.props.auth.user.id ==1">
                                <Autocomplete v-model="form.permissions" label="Permission" itemTitle="description" itemValue="id" :items="permissions" variant="solo-filled" multiple chips clearable>
                                </Autocomplete>
                            </v-row>
                            <v-row v-if="$page.props.auth.user.id !== 1">
                                <Autocomplete v-model="form.permissions" label="Permission" itemTitle="description" itemValue="id" :items="permission" multiple chips clearable>
                                </Autocomplete>
                            </v-row>
                        </v-form>
        
            </template>
            <template v-slot:item.permissions="{item}">
                <v-chip-group column selected-class="text-purple">
                    <v-chip v-for="tag in item.columns.permissions" :key="tag">
                        {{ tag.permission.description }}
                    </v-chip>
                </v-chip-group>
            </template>
            <template v-slot:item.actions="{item}">
                <v-icon size="small" color="warning" title="Modifier" class="me-2" @click="editItem(item.raw)" :icon="icon.mdiPencil">
                </v-icon>
                <v-icon size="small" color="error" @click="deleteItem(item.raw)" :icon="icon.mdiDelete">
                </v-icon>
            </template>
        </Datatable>
    </v-card-text>
</v-card>
</template>

<style scoped>
.custom-add-button {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 16px;
    font-size: 10px;
    /* Personnalisez la taille de la police */
    padding: 6px 12px;
}
</style>
