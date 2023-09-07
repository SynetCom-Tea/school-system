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
    props: ["roles", "permissions"],
    data() {
        return {
            form: useForm({
                name: '',
                permission: [],
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
            headers: [
                {
                    title: 'Libellé',
                    align: 'center',
                    key: 'name'
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
            item: null
        }
    },
    methods: {
        create() {
            this.dialog = true;
        },
        submit() {
            this.form.post(route('roles.store'), {
                onFinish: () => {
                    this.form.reset()
                    this.dialog = false
                    this.$swal({
                        icon: 'success',
                        title: 'Enregistrement',
                        text: 'Role enregistré avec succes',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                    });
                },
            });
        },
        editItem(item) {
            this.item = item.id
            this.dialogEdit = true
            this.form.name = item.name
            this.form.permission = item.permissions
        },
        update() {
            this.form.put(route('roles.update', this.item), {
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
        }
    },
    created() {
        // console.log(this.roles)
    }
}
</script>

<template>
<v-card>
    <page-toolbar :icon="icon.mdiSecurity">Gestion des rôles</page-toolbar>
    <v-card-text>

        <v-dialog v-model="dialog" transition="dialog-top-transition" persistent width="500px">
            <template v-slot:activator="{ props }">
                <div class="custom-add-button">
                    <v-btn @click="create" x-small variant="outlined" color="green" v-bind="props"> Ajouter
                    </v-btn>
                </div>
            </template>
            <template v-slot:default="{ isActive }">
                <v-card>
                    <v-toolbar dense style="background-color: #45007d">
                        <v-toolbar-title>
                            <v-icon left :icon="icon.mdiPlus"></v-icon> Nouveau Rôle
                        </v-toolbar-title>
                        <v-spacer></v-spacer>

                        <v-btn :icon="icon.mdiCloseCircle" title="Annuler" color="red" @click="close()"></v-btn>
                    </v-toolbar>
                    <v-card-text>
                        <v-form>
                            <v-row>
                                <v-col cols="12" md="12">
                                    <text-field name="name" label="Rôle" placeholder="Rôle" v-model="form.name"></text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12" md="12">
                                    <v-autocomplete label="Permission" item-title="description" item-value="id" :items="permissions" variant="solo-filled" multiple chips clearable v-model="form.permission">
                                    </v-autocomplete>
                                </v-col>
                            </v-row>
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-spacer></v-spacer>
                        <v-btn small color="success" variant="outlined" @click="submit">
                            <v-icon :icon="icon.mdiCheckCircle" left></v-icon> Enregistrer
                        </v-btn>
                    </v-card-actions>
                </v-card>
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
                            <v-row>
                                <v-col cols="12" md="12">
                                    <text-field name="name" label="Rôle" placeholder="Rôle" v-model="form.name"></text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12" md="12">
                                    <v-autocomplete label="Permission" item-title="description" item-value="id" :items="permissions" variant="solo-filled" multiple chips clearable v-model="form.permission">
                                    </v-autocomplete>
                                </v-col>
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
        <v-data-table :headers="headers" :items="roles">
            <template v-slot:item.permissions="{item}">
                <v-chip-group column selected-class="text-purple">
                    <v-chip v-for="tag in item.columns.permissions" :key="tag">
                        {{ tag.description }}
                    </v-chip>
                </v-chip-group>
            </template>
            <template v-slot:item.actions="{item}">
                <v-icon size="small" color="warning" title="Modifier" class="me-2" @click="editItem(item.raw)" :icon="icon.mdiPencil">
                </v-icon>
                <v-icon size="small" color="error" @click="deleteItem(item.raw)" :icon="icon.mdiDelete">
                </v-icon>
            </template>
        </v-data-table>
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
