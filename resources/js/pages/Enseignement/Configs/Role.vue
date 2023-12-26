<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Permission from "@/pages/Enseignement/Configs/Permission.vue"
import {
    router,
    useForm
} from "@inertiajs/vue3";
import {
    mdiSecurity,
    mdiClose,
    mdiPlus,
    mdiCancel,
    mdiCheckCircle,
    mdiCloseCircle,
    mdiPencil,
    mdiDelete,
    mdiContentSaveEditOutline,
} from "@mdi/js";

export default {
    components: {
        mdiPencil,
        mdiDelete,
        mdiSecurity,
        mdiClose,
        mdiPlus,
        mdiCancel,
        mdiCheckCircle,
        mdiCloseCircle,
        mdiContentSaveEditOutline,
        Permission
    },
    layout: AuthenticatedLayout,
    props: ["allRoles", "Allpermissions", "section_id"],
    data() {
        return {
            tab: null,
            role_p_a: null,
            role_p_u: null,
            form: useForm({
                name: null,
                permissions: [],
                section_id: null
            }),
            icon: {
                mdiPencil,
                mdiDelete,
                mdiCloseCircle,
                mdiSecurity,
                mdiClose,
                mdiPlus,
                mdiCancel,
                mdiCheckCircle,
                mdiContentSaveEditOutline,
            },
            headers: [{
                    title: "Libellé",
                    align: "center",
                    key: "name",
                },
                {
                    title: "Permissions",
                    align: "center",
                    key: "permissions",
                },
                {
                    title: "Actions",
                    align: "center",
                    key: "actions",
                },
            ],
            dialog: false,
            dialogEdit: false,
            item: null,
            permission_roles: [],
            searchQuery: null,
        };
    },
    methods: {
        create() {
            this.dialog = true;
        },
        submit() {
            // console.log(this.form)
            this.form.post(route("roles.store"), {
                onFinish: () => {
                    this.close()
                    if (this.$page.props.flashd.messages) {
                        this.$swal({
                            icon: "error",
                            title: "Attetion!!",
                            text: this.$page.props.flashd.messages,
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                        });
                    }
                    if (this.$page.props.flash.message) {
                        this.$swal({
                            icon: "success",
                            title: "Enregistrement",
                            text: this.$page.props.flash.message,
                            toast: true,
                            position: "top-end",
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
                });
            }
            this.dialogEdit = true;
            this.form.role = item.role.id;
            this.form.permissions = item.permissions.map((el) => el.permission);
        },

        update() {
            // console.log(this.form.role)
            this.form.put(route("roles.update", this.form.role), {
                onFinish: () => {
                    this.closeEdit()
                    this.dialogEdit = false,

                    this.$swal({
                        position: "top-end",
                        icon: "success",
                        title: "Modification",
                        text: "Role modifié avec succès!",
                        toast: true,
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                        //netstat -ano | findstr :8000
                        //chkdsk/f
                    });
                },
            });
        },
        deleteItem(item) {
            // console.log(this.$page.props.auth.id)
            this.$swal({
                title: "Es-tu sûr?",
                text: "Vous ne pourrez pas revenir en arrière !",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "orange",
                cancelButtonColor: "#d33",
                confirmButtonText: "Oui, supprimez-le!",
                cancelButtonText: "Non, annulez !",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.form.delete(route("roles.destroy", item.id), {
                        onFinish: () => {
                            this.dialogEdit = false;
                            this.form.reset();
                            this.$swal({
                                icon: "success",
                                title: "Supperssion",
                                text: "Role supprimé avec succès!",
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                            });
                        },
                    });
                }
            });
        },
        close() {
            this.dialog = false;
            this.form.name = null;
            this.form.permissions = null;
        },
        closeEdit() {
            this.dialogEdit = false;
            this.form.name = null;
            this.form.permissions = null;
        }
    },
    created(){
        this.form.section_id = this.section_id
    },
    mounted() {
        // this.role_p_u = this.allRoles.filter(
        //     (el) => el.name !== "Administrateur" && el.name !== "Super-administrateur"
        // );
        // this.role_p_a = this.allRoles.filter((el) => el.name !== "Super-administrateur");
    },
};
</script>

<template>
<v-card>
    <Toolbar :icon="icon.mdiSecurity" toolbarTitle="Gestion des rôles"></Toolbar>
    <v-card>
        <v-tabs
            v-model="tab"
            color="deep-purple-accent-4"
            align-tabs="center"
            >
            <v-tab :value="1">Rôles</v-tab>
            <v-tab :value="2">Permissions</v-tab>
        </v-tabs>
        <v-window v-model="tab">
            <v-window-item
                :value="1"
            >
                <v-container fluid>
                    <v-card-text>
                        <v-dialog v-model="dialog" transition="dialog-top-transition" persistent width="500px">
                            <v-card>
                                <v-toolbar dense style="background-color: #7d002c">
                                    <v-toolbar-title style="color: white">
                                        <v-icon left :icon="icon.mdiPlus"></v-icon> Nouveau Rôle
                                    </v-toolbar-title>
                                    <v-spacer></v-spacer>
                                    <v-icon :icon="icon.mdiCloseCircle" title="Annuler" size="large" style="margin: 10px" color="white" @click="close()"></v-icon>
                                </v-toolbar>
                                <v-card-text>
                                    <v-form>
                                        <v-row>
                                            <v-col md="12">
                                                <text-field class="mt-4" name="name" label="Rôle" placeholder="Rôle" v-model="form.name"></text-field>
                                            </v-col>
                                            <v-col md="12">
                                                <Autocomplete class="mt-4" v-model="form.permissions" label="Permission" itemTitle="description" itemValue="id" :items="Allpermissions" multiple chips clearable>
                                                </Autocomplete>
                                            </v-col>
                                        </v-row>
                                    </v-form>
                                </v-card-text>

                                <v-card-actions class="justify-end">
                                    <v-spacer></v-spacer>
                                    <Button variant="outlined" class="mb-2" nameButton="Enregistrer" title="Valider et Fermer la modale" style="height: 30px" :prependIcon="icon.mdiContentSaveEditOutline" @click="submit"></Button>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                        <v-dialog v-model="dialogEdit" transition="dialog-top-transition" persistent width="500px">
                            <template v-slot:default="{ isActive }">
                                <v-card>
                                    <v-toolbar dense style="background-color: #7d002c">
                                        <v-toolbar-title style="color: white">
                                            <v-icon left :icon="icon.mdiPencil"></v-icon> Modification de Rôle
                                        </v-toolbar-title>
                                        <v-spacer></v-spacer>
                                        <v-icon :icon="icon.mdiCloseCircle" title="Annuler" size="large" style="margin: 10px" color="white" @click="closeEdit()"></v-icon>
                                    </v-toolbar>
                                    <v-card-text>
                                        <v-form>
                                            <v-row>
                                                <v-col md="12">
                                                    <Autocomplete label="Rôle" class="mt-1" disabled v-model="form.role" item-title="name" item-value="id" :items="role_p_a" variant="solo-filled" chips clearable>
                                                    </Autocomplete>
                                                </v-col>
                                                <v-col md="12">
                                                    <Autocomplete v-model="form.permissions" label="Permission" item-title="description" item-value="id" :items="permissions" variant="solo-filled" multiple chips clearable>
                                                    </Autocomplete>
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col md="12">
                                                    <Autocomplete label="Role" disabled v-model="form.role" item-title="name" item-value="id" :items="role_p_u" chips clearable>
                                                    </Autocomplete>
                                                </v-col>
                                                <v-col md="12">
                                                    <Autocomplete v-model="form.permissions" label="Permission" item-title="description" item-value="id" :items="permission" multiple chips clearable>
                                                    </Autocomplete>
                                                </v-col>
                                            </v-row>
                                        </v-form>
                                    </v-card-text>
                                    <v-card-actions class="justify-end">
                                        <v-spacer></v-spacer>
                                        <Button variant="outlined" class="mb-2" nameButton="Modifier" title="Valider et Fermer la modale" style="height: 30px" :prependIcon="icon.mdiPencil" @click="update"></Button>
                                    </v-card-actions>
                                </v-card>
                            </template>
                        </v-dialog>
                        <Datatable titleDatatable="Liste des roles" :headers="headers" :items="allRoles" :functionOnClickAddButton="create">
                            <template v-slot:item.permissions="{ item }">
                                <v-chip-group column selected-class="text-purple">
                                    <v-chip v-for="tag in item.permissions" :key="tag">
                                        {{ tag.description }}
                                    </v-chip>
                                </v-chip-group>
                            </template>
                            <template v-slot:item.actions="{ item }">
                                <v-icon size="small" class="me-2" title="Modifier" @click="editItem(item)" :icon="icon.mdiPencil" color="orange">
                                </v-icon>
                                <v-icon size="small" class="me-2" title="Supprimer" @click="deleteItem(item)" :icon="icon.mdiDelete" color="red">
                                </v-icon>
                            </template>
                        </Datatable>
                    </v-card-text>
                </v-container>
            </v-window-item>
            <v-window-item
                :value="2"
            >
                <v-container fluid>
                    <Permission
                        :permissions="Allpermissions"
                    />
                </v-container>
            </v-window-item>
        </v-window>
    </v-card>
</v-card>
</template>
