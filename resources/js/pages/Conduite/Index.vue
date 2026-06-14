<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {
    mdiAccountEdit,
    mdiContentSave,
    mdiMagnify,
    mdiReload,
} from "@mdi/js";

export default {
    layout: AuthenticatedLayout,
    props: ["sectionID", "classes", "periodes", "eleves", "filters"],
    data() {
        return {
            icons: {
                mdiAccountEdit,
                mdiContentSave,
                mdiMagnify,
                mdiReload,
            },
            classe: this.filters?.classe ? Number(this.filters.classe) : null,
            periode: this.filters?.periode ? Number(this.filters.periode) : null,
            noteCommune: null,
            lignes: this.transformEleves(this.eleves),
            headers: [
                { title: "Matricule", align: "start", key: "matricule" },
                { title: "Nom & Prénom", align: "start", key: "nom_complet" },
                { title: "Conduite", align: "center", key: "note" },
            ],
            form: this.$inertia.form({
                classe: null,
                periode: null,
                notes: [],
            }),
            requiredRules: [(v) => !!v || "Ce champ est requis"],
        };
    },
    watch: {
        eleves: {
            handler(value) {
                this.lignes = this.transformEleves(value);
            },
            immediate: true,
            deep: true,
        },
        "$page.props.flash.message": {
            handler(val) {
                if (val) {
                    this.$swal({
                        icon: val.type || "info",
                        title: val.type === "error" ? "Erreur" : "Information",
                        text: val.text,
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 4000,
                        timerProgressBar: true,
                    });
                }
            },
            deep: true,
        },
    },
    methods: {
        transformEleves(eleves) {
            return (eleves || []).map((eleve) => ({
                ...eleve,
                note: Number(eleve.note ?? 18),
            }));
        },
        rechercher() {
            this.$inertia.get(route("conduites.index"), {
                section_id: this.sectionID,
                classe: this.classe,
                periode: this.periode,
            }, {
                preserveState: true,
                replace: true,
            });
        },
        appliquerNoteCommune() {
            if (this.noteCommune === null || this.noteCommune === undefined) {
                this.$swal({
                    icon: "warning",
                    title: "Attention",
                    text: "Veuillez entrer une note commune avant de l'appliquer.",
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                });
                return;
            }
            this.lignes = this.lignes.map((eleve) => ({
                ...eleve,
                note: Number(this.noteCommune),
            }));
            this.noteCommune = null;
        },
        enregistrer() {
            this.form.classe = this.classe;
            this.form.periode = this.periode;
            this.form.notes = this.lignes.map((eleve) => ({
                apprenant_id: eleve.apprenant_id,
                note: Number(eleve.note),
            }));
            
            this.form.post(route("conduites.store"), {
                preserveScroll: true,
            });
        },
    },
};
</script>

<template>
    <v-card>
        <Toolbar :icon="icons.mdiAccountEdit" toolbarTitle="Gestion des conduites"></Toolbar>
        <v-card-text>
            <v-row>
                <v-col cols="12" md="4">
                    <Autocomplete v-model="periode" label="Période" :items="periodes" item-title="libelle"
                        item-value="id" :isRequired="true" clearable></Autocomplete>
                </v-col>
                <v-col cols="12" md="4">
                    <Autocomplete v-model="classe" label="Classe" :items="classes" item-title="libelle"
                        item-value="classe_annee_id" :disabled="!periode" :isRequired="true" clearable></Autocomplete>
                </v-col>
                <v-col cols="12" md="4" class="my-3">
                    <v-btn color="primary" :append-icon="icons.mdiMagnify" :disabled="!classe || !periode"
                        @click="rechercher">
                        Rechercher
                    </v-btn>
                </v-col>
            </v-row>

            <v-divider class="my-4"></v-divider>

            <v-row v-if="lignes.length">
                <v-col cols="12" md="3">
                    <v-text-field v-model.number="noteCommune" type="number" label="Note commune" min="0" max="20"
                        step="0.25" variant="outlined" density="comfortable" :rules="requiredRules"></v-text-field>
                </v-col> 
                <v-col cols="12" md="3" class="d-flex align-center">
                    <v-btn color="primary" :append-icon="icons.mdiReload"
                        @click="appliquerNoteCommune">
                        Appliquer à toute la classe
                    </v-btn>
                </v-col>
                <v-col cols="12" md="3" v-if="lignes.length" class="d-flex align-center">
                <v-btn color="primary" :append-icon="icons.mdiContentSave" :loading="form.processing"
                    @click="enregistrer">
                    Enregistrer
                </v-btn>
            </v-col>
            </v-row>

            <Datatable titleDatatable="Liste des notes de conduite" :displayAddButton="false" v-if="lignes && lignes.length > 0" :headers="headers" :items="lignes" class="mt-4">
                <template v-slot:item.note="{ item }">
                    <v-text-field v-model.number="item.note" type="number" min="0" max="20" step="0.25"
                        variant="outlined" density="compact" hide-details style="max-width: 130px; margin: auto;">
                    </v-text-field>
                </template>
            </Datatable>

            <v-alert v-else-if="classe && periode" type="info" variant="tonal" class="mt-4">
                Cliquez sur "Rechercher" pour voir les élèves.
            </v-alert>
            <v-alert v-else type="info" variant="tonal" class="mt-4">
                Veuillez sélectionner une période et une classe pour afficher les élèves.
            </v-alert>

            
        </v-card-text>
    </v-card>
</template>
