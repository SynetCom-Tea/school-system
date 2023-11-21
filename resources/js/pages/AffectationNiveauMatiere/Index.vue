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
    mdiEye,
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
        mdiEye
    },
    layout: AuthenticatedLayout,
    props: ["niveauMatieres", "section_id", "niveaux", "matieres","systemeLMD","filieres","ues"],
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
                mdiEye
            },
            headers: [
                {
                    title: "Niveau",
                    align: "center",
                    key: "niveau.libelle"
                },
                {
                    title: "Matières/Coefficients",
                    align: "start",
                    sortable: false,
                    key: "matiere",
                },

                {
                    title: "Actions",
                    align: "center",
                    key: "actions"
                },
            ],


            headerspri: [
                {
                    title: "Niveau",
                    align: "center",
                    key: "niveau.libelle"
                },
                {
                    title: "Matières/Notations",
                    align: "start",
                    sortable: false,
                    key: "matiere",
                },
                {
                    title: "Actions",
                    align: "center",
                    key: "actions"
                },
            ],


            headersupue: [
                {
                    title: "Filière/Cycle",
                    align: "center",
                    key: "cycle_filiere.code"
                },
                {
                    title: "Niveau",
                    align: "center",
                    key: "niveau.libelle"
                },

                {
                    title: "Unités des enseignements",
                    align: "center",
                    key: "ues"
                },
                // {
                //     title: "Matière",
                //     align: "start",
                //     sortable: false,
                //     key: "matieres",
                // },
                {
                    title: "Actions",
                    align: "center",
                    key: "actions"
                },

            ],

            headersup: [
                {
                    title: "Filière/Cycle",
                    align: "center",
                    key: "cycle_filiere.code"
                },
                {
                    title: "Niveau",
                    align: "center",
                    key: "niveau.libelle"
                },

                {
                    title: "Les matières",
                    align: "center",
                    key: "matiere"
                },
                // {
                //     title: "Matière",
                //     align: "start",
                //     sortable: false,
                //     key: "matieres",
                // },
                {
                    title: "Actions",
                    align: "center",
                    key: "actions"
                },

            ],
            dialog_title: "Modifier Niveau_Matière",
            dialog: false,
            target: {},
            show: false,
            ajout:false,
            form: useForm({
                cycle_filiere_id:null,
                volume_horaire: "",
                ue_id:null,
                type:this.section_id,
                coefficient: "",
                notation: "",
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

                    createmat(item) {
                        this.ajout=true;
                        console.log('item',item.matieres[0]);
                            // this.form.id=item.filiere.id;
                        this.form.niveau_id = item.matieres[0].niveau_id
                        this.form.ue_id=item.matieres[0].ue_id
                        this.form.cycle_filiere_id = item.matieres[0].cycle_filiere_id
                        this.dialog = true;
                        this.dialog_title = 'Ajouter la matière'


                    },
                    create() {
                        router.get(route('affectations.create', this.section_id))
                    },
                    showItem(item) {
                        console.log('target',item);
                        this.target = item;
                        this.show = true;
                    },
                    editItem(item) {
                        console.log(item)
                        this.dialog_title = 'Modifier '+item.matiere.nom+' '+item.niveau.code
                        this.form.id = item.id
                        this.form.cycle_filiere_id=item.cycle_filiere_id
                        this.form.niveau_id = item.niveau_id
                        this.form.volume_horaire = item.volume_horaire
                        this.form.coefficient = item.coefficient
                        this.form.notation = item.notation
                        this.form.matiere_id = item.matiere_id
                        this.dialog = true
                    },
                    deleteItem(item) {
                        console.log('item sup', item);
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

                                if(this.section_id<=2){
                                    this.form.delete(route("affectations.destroy", item.id), {
                                    onFinish: () => {
                                        if (this.$page.props.flash?.message?.type == "error") {
                                            this.$swal({
                                                icon: "error",
                                                title: "Suppression",
                                                text: this.$page.props.flash?.message?.text,
                                                toast: true,
                                                position: "top-end",
                                                showConfirmButton: false,
                                                timer: 5000,
                                                timerProgressBar: true,
                                            });
                                        } else if (this.$page.props.flash?.message?.type == "success") {
                                            this.$swal({
                                                icon: "success",
                                                iconColor: "#004980",
                                                color: "#004980",
                                                title: "Suppression",
                                                text: this.$page.props.flash?.message?.text,
                                                toast: true,
                                                position: "top-end",
                                                showConfirmButton: false,
                                                timer: 5000,
                                                timerProgressBar: true,
                                            });
                                        }
                                    },
                                });
                            }else{
                                this.form.delete(route("affectationsup.supprimer", item.id,this.section_id), {
                                    onFinish: () => {
                                        if (this.$page.props.flash?.message?.type == "error") {
                                            this.$swal({
                                                icon: "error",
                                                title: "Suppression",
                                                text: this.$page.props.flash?.message?.text,
                                                toast: true,
                                                position: "top-end",
                                                showConfirmButton: false,
                                                timer: 5000,
                                                timerProgressBar: true,
                                            });
                                        } else if (this.$page.props.flash?.message?.type == "success") {
                                            this.$swal({
                                                icon: "success",
                                                iconColor: "#004980",
                                                color: "#004980",
                                                title: "Suppression",
                                                text: this.$page.props.flash?.message?.text,
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
                        }else if(valid){
                            // const {
                            //     cycle_filiere_id,
                            //     ue_id,
                            //     volume_horaire,
                            //     coefficient,
                            //     niveau_id,
                            //     matiere_id
                            // } = this.form;
                            this.form.post(route('affectations.store',this.section_id), {
                                onFinish: () => {
                                    this.close();
                                    this.$swal({
                                        icon: 'success',
                                        iconColor: '#004980',
                                        color: '#004980',
                                        title: 'Enregistrement',
                                        text: 'La matière a été affectée aux niveaux avec succès!',
                                        toast: true,
                                        position: 'top-end',
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
                        this.form.notation = "";
                        this.ajout=false;
                        this.dialog = false;
                    },
                },

        computed: {
        Title() {
        switch (this.section_id) {
            case "1":
            return "SECTION PRIMAIRE";
            case "2":
            return "SECTION SECONDAIRE";
            case "3":
            return "SECTION SUPERIEUR";
            default:
            return "SECTION UNIVERSITAIRE";
        }
        },
    }
    }
</script>
<template>
    <Toolbar
      styleToolbar="background-color: white;"
      :icon="icons.mdiSchool"
      :toolbarTitle="Title"
    ></Toolbar>
    <br>
<v-card variant="outlined" style="border: 2px solid #7d002c">
    <v-card-title style="color: white; background-color: #7d002c" v-if="systemeLMD==null">GESTION DES MATIERES PAR NIVEAUX</v-card-title>
            <v-card-title style="color: white; background-color: #7d002c" v-else>GESTION DES UNITES DES ENSEIGNEMENTS</v-card-title>
          <v-divider></v-divider>
      <v-dialog v-model="dialog" transition="dialog-top-transition" persistent width="800px">
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
                        <v-row v-if="section_id ==3 || section_id ==4" style="height: 80px">
                            <v-col cols="6" md="6" >
                                <autocomplete  :disabled="true" label="cycle/filière" chips :items="filieres" variant="outlined" itemValue="id" itemTitle="code" v-model="form.cycle_filiere_id" class="mt-1" isRequired :rules="[(v) => !!v || 'Ce champ est requis!']">
                                </autocomplete>
                            </v-col>
                            <v-col cols="6" md="6" >
                                <autocomplete  :disabled="true" label="Niveau" chips :items="niveaux" variant="outlined" itemValue="id" itemTitle="libelle" v-model="form.niveau_id" class="mt-1" isRequired :rules="[(v) => !!v || 'Ce champ est requis!']">
                                </autocomplete>
                            </v-col>
                        </v-row>


                        <v-row style="height: 80px">
                            <v-col cols="6" md="6" >
                                <autocomplete  :disabled="true" label="Unité d'enseignement" chips :items="ues" variant="outlined" itemValue="id" itemTitle="libelle" v-model="form.ue_id" class="mt-1" isRequired :rules="[(v) => !!v || 'Ce champ est requis!']">
                                </autocomplete>
                            </v-col>
                            <v-col cols="6" md="6" v-if="ajout == false">
                                <autocomplete :disabled="true" label="Matière" placeholder="Matière" :items="matieres" variant="outlined" class="mt-1" itemValue="id" itemTitle="nom" v-model="form.matiere_id" isRequired :rules="[(v) => !!v || 'Ce champ est requis!']">
                                </autocomplete>
                            </v-col>
                            <v-col cols="6" md="6" v-if="ajout == true">
                                <autocomplete  label="Matière" :items="matieres" placeholder="Matière" variant="outlined" class="mt-1" itemValue="id" itemTitle="nom" v-model="form.matiere_id" isRequired :rules="[(v) => !!v || 'Ce champ est requis!']">
                                    Matière</autocomplete>
                            </v-col>
                        </v-row>

                        <v-row style="height: 80px">
                            <v-col cols="6" md="6">
                                <TextField class="mt-2" type="number" label="Volume_horaire" placeholder="Volume_horaire" v-model="form.volume_horaire" isRequired :rules="rules"></TextField>
                            </v-col>
                            <v-col cols="6" md="6" v-if="section_id != 1">
                                <TextField class="mt-1" type="number" label="Coefficient" placeholder="Coefficient" v-model="form.coefficient" isRequired :rules="rules"></TextField>
                            </v-col>
                            <v-col cols="6" md="6" v-else>
                                <TextField class="mt-1" type="number" label="Notation" placeholder="Notation" v-model="form.notation" isRequired :rules="rules"></TextField>
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

    <!-- <v-dialog v-model="show" max-width="600" v-if="target">
        <v-card>
            <v-toolbar dark color="primary">
                <v-toolbar-title>
                    Les matières avec leurs coefficient et volume horaire <v-icon size="large"> </v-icon>
                </v-toolbar-title>
            </v-toolbar>
            <v-card-text>
                <v-card flat class="mt-3 mb-6" >
                    <v-card>
                        <v-table dense>

                            <tbody>
                                <tr :key="i" v-for="(t, i) in target.matieres">
                                    <td >{{ t.matiere.nom }}</td>
                                    <td >{{ t.coefficient }}</td>
                                    <td >{{ t.volume_horaire }}</td>
                                    <td><v-icon size="small" class="me-2" title="Supprimer" @click="deleteItem()" :icon="icons.mdiDelete" color="red">
                                        </v-icon></td>
                                </tr>
                                 <tr>
                                    <td class="font-weight-black">Nom Etablissement:</td>
                                    <td>{{ target.name }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-black">Ville</td>
                                    <td>{{ target.ville }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-black">Adresse :</td>
                                    <td>{{ target.adresse }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-black">Email :</td>
                                    <td>{{ target.email }}</td>
                                </tr>
                                <tr v-if="target.sections[0]">
                                    <td class="font-weight-black">Sections :</td>
                                    <td>
                                        <v-chip-group column>
                                            <v-chip label color="primary" :key="i" v-for="(t, i) in target.sections">{{ t.libelle }}</v-chip>
                                        </v-chip-group>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-black">Administrateur:</td>
                                    <td :key="i" v-for="(t, i) in target.users">
                                        {{ t.nom }} {{ t.prenom }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-black">Email Admin:</td>
                                    <td :key="i" v-for="(t, i) in target.users">{{ t.email }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-black">Statut:</td>
                                    <td v-if="target.statut == 1">Actif</td>
                                    <td v-if="target.statut == 0">Inactif</td>
                                </tr>
                            </tbody>
                        </v-table>
                    </v-card>
                </v-card>
            </v-card-text>
            <v-card-actions class="justify-end" id="actions">
                <v-btn color="danger" variant="text" @click="show = false"> Fermer </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog> -->
    <v-card-text>
        <Datatable  v-if="section_id == 1" titleDatatable="Liste des matières par niveau" :headers="headerspri" :items="niveauMatieres" :functionOnClickAddButton="create">

            <template v-slot:item.matiere="{ item, index}">
                    <v-chip-group column selected-class="text-purple">
                        <v-chip v-for="tag in item.matiere">
                            {{ tag.matiere.nom }} => {{ 'Notation: ' }}{{ tag.notation }}
                            <v-icon size="small" class="me-2" title="Modifier" @click="editItem(tag)" :icon="icons.mdiPencil" color="orange"></v-icon>
                            <!-- <v-icon end color="primary" :icon="icons.mdiEye" title="Détail l'établissement" style="top: 0; left: 0; display: absolute" @click="showItem(tag)"></v-icon> -->
                            <v-icon end size="small" class="me-2" title="Supprimer" @click="deleteItem(tag)" :icon="icons.mdiCloseCircle" >
                            </v-icon>

                        </v-chip>
                    </v-chip-group>
                </template>
            <template v-slot:item.actions="{ item }">
                <v-icon size="small" class="me-2" title="Modifier" @click="editItem(item)" :icon="icons.mdiPencil" color="orange">
                </v-icon>
                <v-icon size="small" class="me-2" title="Supprimer" @click="deleteItem(item)" :icon="icons.mdiDelete" color="red">
                </v-icon>
            </template>
        </Datatable>
        <Datatable  v-if="section_id == 2" titleDatatable="Liste des matières par niveau" :headers="headers" :items="niveauMatieres" :functionOnClickAddButton="create">
            <template v-slot:item.matiere="{ item, index}">
                    <v-chip-group column selected-class="text-purple">
                        <v-chip v-for="tag in item.matiere">
                            {{tag.matiere.nom}} =>{{ 'Coeff: ' }} {{tag.coefficient}}
                            <v-icon end size="small" class="me-2" title="Modifier" @click="editItem(tag)" :icon="icons.mdiPencil" color="orange">
                            </v-icon>
                            <!-- <v-icon end color="primary" :icon="icons.mdiEye" title="Détail l'établissement" style="top: 0; left: 0; display: absolute" @click="showItem(tag)"></v-icon> -->
                            <v-icon end size="small" class="me-2" title="Supprimer" @click="deleteItem(tag)" :icon="icons.mdiCloseCircle" >
                            </v-icon>

                        </v-chip>
                    </v-chip-group>
                </template>
            <template v-slot:item.actions="{ item }">

                <v-icon size="small" class="me-2" title="Supprimer" @click="deleteItem(item)" :icon="icons.mdiDelete" color="red">
                </v-icon>
            </template>
        </Datatable>
        <Datatable v-if="section_id >= 3 && systemeLMD !=null" titleDatatable="Liste des matières par niveau" :headers="headersupue" :items="niveauMatieres" :functionOnClickAddButton="create">
            <template v-slot:item.ues="{ item, index}">
                    <v-chip-group size="small" column selected-class="text-purple" style="width:90%;">
                        <v-chip  v-for="tag in item.ues" style=" height: auto;  ">
                            {{ tag.ue.libelle }} =>

                            <v-chip-group column selected-class="text-purple" style="width:90%;">
                                <v-chip size="small" :key="i" v-for="(t, i) in tag.matieres"  style=" color: white; background-color: #7d002c; size:10px;">
                                    {{ t.matiere.nom }}
                                    {{ '/ VH: ' }}{{ t.volume_horaire }}
                                    {{ ';Coeff: ' }}{{ t.coefficient }}
                                    <v-icon end size="small" class="me-2" title="Modifier" @click="editItem(t)" :icon="icons.mdiPencil" color="orange">
                                    </v-icon>
                                    <v-icon end size="small" class="me-2" title="Supprimer" @click="deleteItem(t)" :icon="icons.mdiCloseCircle">
                                    </v-icon>
                                </v-chip>
                            </v-chip-group>
                             {{'credit: ' }} {{ tag.credit }}

                             <v-icon end size="small" class="me-2" title="Ajouter des cycles" @click="createmat(tag)" :icon="icons.mdiPlusCircle" color="primary"></v-icon>
                            <!-- <v-icon end color="primary" :icon="icons.mdiEye" title="Détail l'établissement" style="top: 0; left: 0; display: absolute" @click="showItem(tag)"></v-icon> -->
                            <v-icon end size="small" class="me-2" title="Supprimer" @click="deleteItem(tag)" :icon="icons.mdiCloseCircle">
                            </v-icon>

                        </v-chip>
                    </v-chip-group>
                </template>

            <template v-slot:item.actions="{ item }">
                <!-- <v-icon size="small" class="me-2" title="Modifier" @click="editItem(item)" :icon="icons.mdiPencil" color="orange">
                </v-icon> -->
                <v-icon size="small" class="me-2" title="Supprimer" @click="deleteItem(item)" :icon="icons.mdiDelete" color="red">
                </v-icon>
            </template>
        </Datatable>

        <Datatable v-if="section_id >= 3 && systemeLMD ==null" titleDatatable="Liste des matières par niveau" :headers="headersup" :items="niveauMatieres" :functionOnClickAddButton="create">
            <template v-slot:item.matiere="{ item, index}">
                    <v-chip-group column selected-class="text-purple">
                        <v-chip v-for="tag in item.matiere">
                            {{ tag.matiere.nom }} =><v-chip> {{ 'VH: ' }} {{ tag.volume_horaire }}</v-chip> <v-chip>  {{ '  Coeff: ' }} {{ tag.coefficient }}</v-chip>
                            <v-icon size="small" class="me-2" title="Modifier" @click="editItem(tag)" :icon="icons.mdiPencil" color="orange"></v-icon>
                            <v-icon end size="small" class="me-2" title="Supprimer" @click="deleteItem(tag)" :icon="icons.mdiCloseCircle">
                            </v-icon>

                        </v-chip>
                    </v-chip-group>
                </template>

            <template v-slot:item.actions="{ item }">
                <!-- <v-icon size="small" class="me-2" title="Modifier" @click="editItem(item)" :icon="icons.mdiPencil" color="orange">
                </v-icon> -->
                <v-icon size="small" class="me-2" title="Supprimer" @click="deleteItem(item)" :icon="icons.mdiDelete" color="red">
                </v-icon>
            </template>
        </Datatable>
    </v-card-text>
</v-card>
</template>

<style></style>
