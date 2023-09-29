<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {
    useForm,
    router
} from "@inertiajs/vue3";

import {
    mdiAccountSchool,
    mdiPlus,
    mdiPencil,
    mdiDelete,
    mdiPlusCircle,
    mdiClipboardEditOutline,
    mdiOfficeBuilding,
    mdiMail,
    mdiGoogleClassroom,
    mdiSchool,
    mdiCancel,
    mdiCloseCircle,
    mdiContentSave,
    mdiCurrencyUsd,
} from "@mdi/js";
export default {
    components: {
        mdiAccountSchool,
        mdiPlus,
        mdiPencil,
        mdiDelete,
        mdiPlusCircle,
        mdiClipboardEditOutline,
        mdiOfficeBuilding,
        mdiMail,
        mdiGoogleClassroom,
        mdiSchool,
        mdiCancel,
        mdiCloseCircle,
        mdiContentSave,
        mdiCurrencyUsd,
    },
    layout: AuthenticatedLayout,
    props: ["niveauMatieres", "section_id", "niveaux", "matieres"],
    data() {
        return {
            icons: {
                mdiAccountSchool,
                mdiPlus,
                mdiPencil,
                mdiDelete,
                mdiPlusCircle,
                mdiClipboardEditOutline,
                mdiOfficeBuilding,
                mdiMail,
                mdiGoogleClassroom,
                mdiSchool,
                mdiCancel,
                mdiCloseCircle,
                mdiContentSave,
                mdiCurrencyUsd,
            },
            headers: [{
                    title: "Matière",
                    align: "start",
                    sortable: false,
                    key: "matiere.nom",
                },
                {
                    title: "Niveau",
                    align: "center",
                    key: "niveau.libelle"
                },
                {
                    title: "Volume Horaire",
                    align: "center",
                    key: "volume_horaire"
                },
                {
                    title: "Coefficient",
                    align: "center",
                    key: "coefficient"
                },
                {
                    title: "Actions",
                    align: "center",
                    key: "actions"
                },
            ],
            dialog_title: "Modifier Niveau_Matière",
            dialog: false,

            form: useForm({
                volume_horaire: "",
                coefficient: "",
                niveau_id: "",
                matiere_id: "",
            }),
            rules: [
                (value) => {
                    if (value) return true;
                    return "Ce champ est requis!";
                }
            ],
        }
    },
                methods: {
                    create() {
                        router.get(route('affectations.create', this.section_id))
                    },
                    editItem(item) {
                        console.log(item)
                        this.dialog_title = 'Modifier ' + item.matiere.nom + ' ' + item.niveau.code
                        this.form.id = item.id
                        this.form.niveau_id = item.niveau_id
                        this.form.volume_horaire = item.volume_horaire
                        this.form.coefficient = item.coefficient
                        this.form.matiere_id = item.matiere_id
                        this.dialog = true
                    },
                    deleteItem(item) {
                        this.$swal({
                            title: "Es-tu sûr?",
                            text: "Vous ne pourrez pas revenir en arrière !",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#004980",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Oui, supprimez-le!",
                            cancelButtonText: "Non, annulez !",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.form.delete(route("affectations.destroy", item.id), {
                                    onFinish: () => {
                                        if (this.$page.props.flash ? .message ? .type == "error") {
                                            this.$swal({
                                                icon: "error",
                                                title: "Suppression",
                                                text: this.$page.props.flash ? .message ? .text,
                                                toast: true,
                                                position: "top-end",
                                                showConfirmButton: false,
                                                timer: 5000,
                                                timerProgressBar: true,
                                            });
                                        } else if (this.$page.props.flash ? .message ? .type == "success") {
                                            this.$swal({
                                                icon: "success",
                                                iconColor: "#004980",
                                                color: "#004980",
                                                title: "Suppression",
                                                text: this.$page.props.flash ? .message ? .text,
                                                toast: true,
                                                position: "top-end",
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
                        const {
                            valid
                        } = await this.$refs.form.validate();
                        if (this.form.id && valid) {
                            const {
                                id,
                                volume_horaire,
                                coefficient,
                                niveau_id,
                                matiere_id
                            } = this.form;

                            this.form.put(route("affectations.update", this.form.id), {
                                onFinish: () => {
                                    this.close();
                                    this.$swal({
                                        icon: "success",
                                        iconColor: "#004980",
                                        color: "#004980",
                                        title: "Modification",
                                        text: "Niveau_Matière modifié avec succès!",
                                        toast: true,
                                        position: "top-end",
                                        showConfirmButton: false,
                                        timer: 5000,
                                        timerProgressBar: true,
                                    });
                                },
                            });
                        }
                    },
                    close() {
                        this.form.id = "";
                        this.form.niveau_id = "";
                        this.form.volume_horaire = "";
                        this.form.coefficient = "";
                        this.form.matiere_id = "";
                        this.dialog = false;
                    },
                },        
    }
</script>
<template>
<v-card>
    <Toolbar styleToolbar="background-color: white;" :icon="icons.mdiClipboardEditOutline" toolbarTitle="Gestion des matières par niveau"></Toolbar>
    <v-dialog v-model="dialog" transition="dialog-top-transition" persistent width="500px">
        <template v-slot:default="{ isActive }">
            <v-card>
                <v-toolbar dense style="background-color: #7d002c">
                    <!-- <v-icon left color="white" :icon="icons.mdiPencil"></v-icon> -->
                    <v-toolbar-title style="
                font-size: 1.15em;
                width: 350px;
                word-wrap: break-word;
                white-space: pre-wrap;
                word-break: break-word;
                color: white;
              ">
                        <p class="text-wrap">{{ dialog_title }}</p>
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-icon :icon="icons.mdiCloseCircle" title="Annuler" size="large" style="margin: 10px" color="white" @click="close"></v-icon>
                </v-toolbar>
                <v-card-text>
                    <v-form ref="form">
                        <v-row>
                            <v-col cols="12" md="12">
                                <Select label="Matière" :items="matieres" variant="outlined" class="mt-1" itemValue="id" itemTitle="nom" v-model="form.matiere_id" isRequired :rules="[(v) => !!v || 'Ce champ est requis!']">
                                </Select>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" md="12">
                                <Select label="Niveau" :items="niveaux" variant="outlined" itemValue="id" itemTitle="libelle" v-model="form.niveau_id" class="mt-1" isRequired :rules="[(v) => !!v || 'Ce champ est requis!']">
                                </Select>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" md="12">
                                <TextField class="mt-2" type="number" label="Volume_horaire" placeholder="Volume_horaire" v-model="form.volume_horaire" isRequired :rules="rules"></TextField>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" md="12">
                                <TextField class="mt-1" type="number" label="Coefficient" placeholder="Coefficient" v-model="form.coefficient" isRequired :rules="rules"></TextField>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-card-text>
                <v-card-actions class="justify-end">
                    <v-spacer></v-spacer>
                    <Button color="red" variant="outlined" class="mb-2" nameButton="Annuler" title="Annuler" style="height: 30px" :prependIcon="icons.mdiCancel" @click="close"></Button>
                    <Button variant="outlined" class="mb-2" nameButton="Enregistrer" title="Valider et Fermer la modale" style="height: 30px" :prependIcon="icons.mdiContentSave" @click="submit"></Button>
                </v-card-actions>
            </v-card>
        </template>
    </v-dialog>
    <v-card-text>
        <Datatable titleDatatable="Liste des matières par niveau" :headers="headers" :items="niveauMatieres" :functionOnClickAddButton="create">
            <template v-slot:item.actions="{ item }">
                <v-icon size="small" class="me-2" title="Modifier" @click="editItem(item.raw)" :icon="icons.mdiPencil" color="orange">
                </v-icon>
                <v-icon size="small" class="me-2" title="Supprimer" @click="deleteItem(item.raw)" :icon="icons.mdiDelete" color="red">
                </v-icon>
            </template>
        </Datatable>
    </v-card-text>
</v-card>
</template>

<style></style>
