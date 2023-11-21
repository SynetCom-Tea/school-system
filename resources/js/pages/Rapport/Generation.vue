<script>
const PdfPrinter = () =>  import("../../components/Rapports/PdfPrinter.vue");
import DetailBulletin from '@/components/Rapports/DetailBulletin.vue';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { mdiDatabaseSync, mdiTimerSync, mdiPrinter, mdiAccountFileTextOutline, mdiCloseCircle, mdiEye } from "@mdi/js";
import jsPDF from 'jspdf';
export default {
    components: {
        PdfPrinter,
        DetailBulletin
    },
    layout: AuthenticatedLayout,
    props: ["sectionID", "resultats", "periodes","filieres", "cycle_filieres"],
    data: () => ({
        icons: {
        mdiDatabaseSync,
        mdiTimerSync,
        mdiPrinter,
        mdiAccountFileTextOutline,
        mdiCloseCircle,
        mdiEye
        },
        headers: [
            {
                title: 'Matricule',
                align: 'start',
                sortable: false,
                key: 'matricule_apprenant',
            },
            { title: 'Nom', align: 'center', key: 'nom_apprenant' },
            { title: 'Prénom', align: 'center', key: 'prenom_apprenant' },
            { title: 'Moyenne', align: 'center', key: 'moyenne' },
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
        data: [],
        detailData: null,
        apprenantData: [],
        classes: [],
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
                data: { classe: this.classe, periode: this.periode }
            });
            if(this.sectionID ==3){
                this.setData(this.classe)
            }
            // console.log('ojjj', this.classes.length, (this.classes.length !== 0))
            // const filteredResults = this.resultats;
            // this.data = this.resultats;
            // console.log('filteredResults',this.resultats)
        },
        setData(classe){
            if(this.sectionID == 1){
                const filteredResults = this.resultats[classe];
                this.data = this.resultats[classe];
                // console.log('daza',this.data);
            }else if(this.sectionID == 3){
                this.data = this.resultats;
                console.log('daza',this.$page.props.resultats);
            }
        },
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
        
    }
}
</script>

<template>
  <v-card>
    <Toolbar :icon="icons.mdiDatabaseSync" toolbarTitle="Génération des bulletins"></Toolbar>
    <v-card-text>
        <!-- <div class="text-center">
            
        </div> -->
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
            <v-col md="4">
                <autocomplete
                label="Classe"
                v-model="classe"
                :items="classes"
                @update:modelValue="setData(classe)"
                class="mt-4"
                isRequired
                item-title="libelle"
                item-value="id"
                ></autocomplete>
            </v-col>
            <v-col cols="4">
                <autocomplete 
                    class="mt-4" 
                    v-model="periode" 
                    label="Periodes" 
                    itemTitle="libelle" 
                    itemValue="id" 
                    :items="periodes" variant="outlined" :isRequired="true" :disabled="!classe" chips clearable>
                </autocomplete>
            </v-col>
            <v-col md="4"  v-if="sectionID != 1">
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
