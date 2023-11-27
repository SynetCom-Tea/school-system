<script>
const PdfPrinter = () =>  import("../../components/Rapports/PdfPrinter.vue");
import DetailBulletin from '@/components/Rapports/DetailBulletin.vue';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { mdiDatabaseSync, mdiTimerSync, mdiPrinter, mdiAccountFileTextOutline, mdiCloseCircle, mdiEye, mdiRepeat, mdiChartDonut, mdiRepeatVariant } from "@mdi/js";
import jsPDF from 'jspdf';
export default {
    components: {
        PdfPrinter,
        DetailBulletin
    },
    layout: AuthenticatedLayout,
    props: ["sectionID", "resultats", "periodes","filieres", "cycle_filieres", "apprenant", "section"],
    data: () => ({
        icons: {
            mdiDatabaseSync,
            mdiTimerSync,
            mdiPrinter,
            mdiAccountFileTextOutline,
            mdiCloseCircle,
            mdiEye,
            mdiRepeatVariant,
            mdiChartDonut,
            mdiRepeat
        },
        headers: [
            {
                title: 'Matricule',
                align: 'start',
                sortable: false,
                key: 'matricule_apprenant',
            },
            { title: 'Nom & Prénom', align: 'center', key: 'nom_prenom_apprenant' },
            { title: 'Moyenne', align: 'center', key: 'moyenne_details_notes' },
            { title: 'Rang', align: 'center', key: 'rang' },
            {title: 'Actions', align: 'center', key: 'actions'},
        ],
        headersSecondaire: [
            {
                title: 'Matricule',
                align: 'start',
                sortable: false,
                key: 'matricule_apprenant',
            },
            { title: 'Nom', align: 'center', key: 'nom_apprenant' },
            { title: 'Prénom', align: 'center', key: 'prenom_apprenant' },
            { title: 'Moyenne', align: 'center', key: 'moyenne_details_notes' },
            { title: 'Rang', align: 'center', key: 'rang' },
            {title: 'Actions', align: 'center', key: 'actions'},
        ],
        headersSup: [
            {
                title: 'Matricule',
                align: 'start',
                sortable: false,
                key: 'matricule_apprenant',
            },
            { title: 'Nom & Prénom', align: 'center', key: 'nom_prenom_apprenant' },
            { title: 'Moyenne', align: 'center', key: 'moyenne_details_notes' },
            { title: 'Rang', align: 'center', key: 'rang' },
            {title: 'Actions', align: 'center', key: 'actions'},
        ],
        tab: 'option-1',
        data: [],
        detailData: null,
        apprenantData: [],
        classes: [],
        apprenant2: null,
        classe2: null,
        filiere2: null,
        periode2: null,
        dialog: false,
        overlay: false,
        classe: null,
        filiere: null,
        periode: null,
        printPdf: false
    }),
    watch: {
        overlay(val) {
            if (val) {
                // Si overlay est vrai, attendre pour le masquer
                setTimeout(() => {
                    if (this.overlay) {
                    // Si l'overlay est toujours affiché après 3 secondes, le masquer
                    this.overlay = false;
                    }
                }, 3000);
            }
        },
    },
    methods: {
        generate() {
            this.$inertia.replace(this.$page.url, {
                data: { classe: this.classe, periode: this.periode, tab: this.tab }
            });
            if(this.sectionID ==3){
                this.setData(this.classe)
            }
            if(this.sectionID ==1){
                this.setData(this.classe)
                // this.data = this.resultats;
            }
            // console.log('ojjj', this.classes.length, (this.classes.length !== 0))
            // const filteredResults = this.resultats;
            this.data = this.resultats;
            // console.log('filteredResults',this.resultats)
        },
        setData(classe){
            if(this.sectionID == 1){
                // const filteredResults = this.resultats[classe];
                this.data = this.resultats;
                // console.log('daza',this.data);
            }else if(this.sectionID == 3){
                this.data = this.resultats;
                console.log('daza',this.$page.props.resultats);
            }
        },
        // setPeriode(periode){
        //     this.$inertia.replace(this.$page.url, {
        //         data: { periode: periode }
        //     });
        // },
        setClasse(filiere){
            let cf = this.$page.props.cycle_filieres.filter((c_f) => c_f.filiere_id == filiere);
            const cycleFiliereIds = cf.map((item) => item.id);
            this.classes = this.$page.props.classes.filter((classe) => cycleFiliereIds.includes(classe.cycle_filiere_id));
        },
        openBulletinDialog(item) {
            this.detailData = item;
            console.log('Po',item)
            this.dialog = true;
        },
        closeDetailBulletin() {
            this.dialog = false;
        },
        printItem(item) {
            console.log('item print',item);
        }
    },
    mounted(){
        if(this.sectionID == 1 || this.sectionID == 2){
            this.classes = this.$page.props.classes
        }
    }
}
</script>

<template>
  <v-card>
    <Toolbar :icon="icons.mdiDatabaseSync" :toolbarTitle="`Génération des bulletins - Section ${section}`"></Toolbar>
    <v-card-text>
        <v-alert
            type="info"
            title="Information"
            text="La génération par période s'effectue à la fin des évaluations de la période sélectionnée. En revanche, la génération par élève concerne ceux dont les notes ont été modifiées, ceux qui n'ont pas participé à une évaluation, ou encore ceux qui sont en session."
            variant="tonal"
        ></v-alert>
        <div class="d-flex flex-row">
            <v-tabs
                v-model="tab"
                direction="vertical"
                color="primary"
            >
                <v-tab value="option-1">
                    <v-icon start>
                        {{ icons.mdiChartDonut }}
                    </v-icon>
                    Par periode
                    </v-tab>
                <v-tab value="option-2">
                    <v-icon start>
                        {{ icons.mdiRepeatVariant }}
                    </v-icon>
                    Par {{ apprenant }}
                </v-tab>
            </v-tabs>
            <v-window v-model="tab">
                <v-window-item value="option-1">
                    <v-card class="d-flex justify-center align-center">
                        <v-card-text>
                            <v-row v-if="sectionID == 3  || sectionID == 4">
                                <v-col md="5">
                                    <autocomplete
                                        label="Filière"
                                        v-model="filiere"
                                        class="mt-4"
                                        :items="$page.props.filieres"
                                        @update:modelValue="setClasse(filiere)"
                                        item-title="code"
                                        item-value="id"
                                    ></autocomplete>
                                </v-col>
                                <v-col md="3" v-if="filiere">
                                    <autocomplete
                                    label="Classe"
                                    v-model="classe"
                                    :items="classes"
                                    class="mt-4"
                                    isRequired
                                    item-title="libelle"
                                    item-value="id"
                                    ></autocomplete>
                                </v-col>
                                <v-col cols="2">
                                    <autocomplete 
                                        class="mt-4" 
                                        v-model="periode" 
                                        label="Periodes" 
                                        itemTitle="libelle" 
                                        itemValue="id" 
                                        :items="periodes" variant="outlined" :isRequired="true" :disabled="!classe" chips clearable>
                                    </autocomplete>
                                </v-col>
                                <v-col md="2">
                                    <v-btn
                                    class="mt-4"
                                    :append-icon="icons.mdiTimerSync"
                                    color="deep-purple-accent-4"
                                    @click="generate()"
                                    :disabled="!periode"
                                    >
                                    Générer
                                    </v-btn>
                                </v-col>
                            </v-row>
                            <v-row v-if="sectionID == 1  || sectionID == 2">
                                <v-col cols="4">
                                    <autocomplete 
                                        class="mt-4" 
                                        v-model="periode" 
                                        label="Periodes"
                                        itemTitle="libelle" 
                                        itemValue="id" 
                                        :items="periodes" variant="outlined" :isRequired="true" chips clearable>
                                    </autocomplete>
                                </v-col>
                                <v-col md="3">
                                    <autocomplete
                                    label="Classe"
                                    v-model="classe"
                                    :items="classes"
                                    :disabled="!periode"
                                    class="mt-4"
                                    isRequired
                                    item-title="libelle"
                                    item-value="id"
                                    ></autocomplete>
                                </v-col>
                                <v-col md="2">
                                    <v-btn
                                    class="mt-4"
                                    :append-icon="icons.mdiTimerSync"
                                    color="deep-purple-accent-4"
                                    @click="generate"
                                    :disabled="!periode"
                                    >
                                    Générer
                                    </v-btn>
                                </v-col>
                                <v-col md="2" v-if="classe">
                                    <a :href="route('bulletin', { type: 1, classe: classe, periode: periode, section: sectionID })" target="__blank">
                                        <v-btn
                                    class="mt-4"
                                    :append-icon="icons.mdiTimerSync"
                                    color="deep-purple-accent-4"
                                    :disabled="!periode"
                                    >
                                    Classe
                                    </v-btn>
                                    </a>
                                </v-col>
                            </v-row>
                            <Datatable v-if="classes.length !== 0 && (sectionID == 1)" titleDatatable="Liste des élèves" :headers="headers" :items="data" :displayAddButton="false" >
                                <template v-slot:item.actions="{item}">
                                    <a :href="route('bulletin', { type: 0, id: item.id, section: sectionID })" target="__blank">
                                        <v-icon size="small" class="me-2" title="Imprimer" :icon="icons.mdiPrinter" color="info"></v-icon>
                                    </a>
                                    <v-icon size="small" class="me-2" title="Detail" @click="openBulletinDialog(item)" :icon="icons.mdiEye" color="info">
                                    </v-icon>
                                </template>
                            </Datatable>
                            <Datatable v-if="classes.length !== 0 && (sectionID == 2)" titleDatatable="Liste des élèves" :headers="headersSecondaire" :items="data" :displayAddButton="false" >
                                <template v-slot:item.actions="{item}">
                                    <a :href="route('bulletin', { type: 0, id: item.id, section: sectionID })" target="__blank">
                                        <v-icon size="small" class="me-2" title="Imprimer" :icon="icons.mdiPrinter" color="info"></v-icon>
                                    </a>
                                    <v-icon size="small" class="me-2" title="Detail" @click="openBulletinDialog(item)" :icon="icons.mdiEye" color="info">
                                    </v-icon>
                                </template>
                            </Datatable>
                            <Datatable v-if="classes.length !== 0 && (sectionID == 3)" titleDatatable="Liste des etudiants" :headers="headersSup" :items="data" :displayAddButton="false" >
                                <template v-slot:item.actions="{item}">
                                    <a :href="route('bulletin', { type: 0, id: item.id, section: sectionID })" target="__blank">
                                        <v-icon size="small" class="me-2" title="Imprimer" :icon="icons.mdiPrinter" color="info"></v-icon>
                                    </a>
                                    <v-icon size="small" class="me-2" title="Detail" @click="openBulletinDialog(item)" :icon="icons.mdiEye" color="info">
                                    </v-icon>
                                </template>
                            </Datatable>
                        </v-card-text>
                    </v-card>
                </v-window-item>
                <v-window-item value="option-2">
                    <v-card flat>
                        <v-card-text>
                            <v-row v-if="sectionID == 1  || sectionID == 2">
                                <v-col cols="4">
                                    <autocomplete 
                                        class="mt-4" 
                                        v-model="periode2" 
                                        label="Periodes"
                                        itemTitle="libelle" 
                                        itemValue="id" 
                                        :items="periodes" variant="outlined" :isRequired="true" chips clearable>
                                    </autocomplete>
                                </v-col>
                                <v-col md="4">
                                    <autocomplete
                                    label="Classe"
                                    v-model="classe2"
                                    :items="classes"
                                    :disabled="!periode"
                                    class="mt-4"
                                    isRequired
                                    item-title="libelle"
                                    item-value="id"
                                    ></autocomplete>
                                </v-col>
                                <v-col md="4">
                                    <autocomplete
                                    :label="apprenant"
                                    v-model="apprenant2"
                                    :items="classes"
                                    :disabled="!periode"
                                    class="mt-4"
                                    isRequired
                                    item-title="libelle"
                                    item-value="id"
                                    ></autocomplete>
                                </v-col>
                                <v-col md="4">
                                    <v-btn
                                    class="mt-4"
                                    :append-icon="icons.mdiTimerSync"
                                    color="deep-purple-accent-4"
                                    @click="generate"
                                    :disabled="!periode"
                                    >
                                    Générer
                                    </v-btn>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-window-item>
            </v-window>
        </div>
    </v-card-text>
    <v-dialog overlay-opacity="0.7" v-model="printPdf" max-width="750">
        <v-card>
            <v-toolbar dark color="orange">
                <v-toolbar-title> <v-icon left :icon="icons.mdiAccountFileTextOutline"></v-icon> Bulletin</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn :icon="icons.mdiCloseCircle" title="Fermer" color="error" @click="close()"></v-btn>
            </v-toolbar>
            <PdfPrinter :content="apprenantData"/>
        </v-card>
    </v-dialog>
    <DetailBulletin
        v-if="detailData !== null"
        v-model="dialog"
        :data="detailData"
        :typeSection="sectionID"
        @close="closeDetailBulletin"
    />
  </v-card>
</template>
