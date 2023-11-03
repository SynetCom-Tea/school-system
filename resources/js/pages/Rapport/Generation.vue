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
    props: ["sectionID", "classes", "resultats"],
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
            {title: 'Actions', align: 'center', key: 'actions'},
        ],
        data: [],
        detailData: null,
        apprenantData: [],
        dialog: false,
        overlay: false,
        classe: null,
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
        async generateBulletin() {
        this.overlay = true; // Affiche l'overlay au début du traitement

        try {
            // Effectuez votre traitement, par exemple, une opération asynchrone
            // Exemple avec await this.$inertia.replace()
            const classe = 'VotreClasse';
            await this.$inertia.replace(this.$page.url, {
            data: { classe: classe }
            });

            // L'overlay reste visible après la fin du traitement si la page est cliquée dans le vide
        } catch (error) {
            console.error(error); // Gérez les erreurs potentielles ici
        } finally {
            this.overlay = false; // Cache l'overlay une fois le traitement terminé
        }
        },
        setData(classe){
            const filteredResults = this.resultats[classe];
            this.data = this.resultats[classe];
            console.log(filteredResults);
        },
        openBulletinDialog(item) {
            this.detailData = item;
            console.log('Po',item)
            this.dialog = true;
        },
        closeDetailBulletin() {
            this.dialog = false;
        },
        generatePdfFromData(content) {
            // Créez un nouvel document PDF
            const doc = new jsPDF();

            // Définissez les données de l'étudiant dans le PDF
            doc.text(`Matricule: ${content.matricule_apprenant}`, 20, 20);
            doc.text(`Nom: ${content.nom_apprenant}`, 20, 30);
            doc.text(`Prénom: ${content.prenom_apprenant}`, 20, 40);
            doc.text(`Moyenne: ${content.moyenne}`, 20, 50);
            // Ajoutez d'autres données de l'étudiant comme souhaité

            // Générez le PDF sous forme d'URI de données (data URI)
            const pdfDataUri = doc.output('datauristring');

            // Retournez l'URI de données pour affichage dans le composant PdfPrinter
            return pdfDataUri;
        },
        printItem(item) {
            // Générer le PDF à partir des données de l'étudiant
            const pdfDataUri = this.generatePdfFromData(item);

            // Afficher le PDF dans le composant PdfPrinter
            this.apprenantData = pdfDataUri;
            this.printPdf = true;
        }
    },
    mounted(){
        console.log(this.classes, this.resultats)
    }
}
</script>

<template>
  <v-card>
    <Toolbar :icon="icons.mdiDatabaseSync" toolbarTitle="Génération des bulletins"></Toolbar>
    <v-card-text>
        <div class="text-center" v-if="sectionID != 1">
            <v-btn
            :append-icon="icons.mdiTimerSync"
            color="deep-purple-accent-4"
            @click="generateBulletin"
            :disabled="overlay || classes.length != 0"
            >
            Générer
            </v-btn>

            <v-overlay :value="overlay" absolute fullscreen>
            <v-progress-circular
                color="primary"
                indeterminate
                size="64"
            ></v-progress-circular>
            </v-overlay>
        </div>
         <v-col md="4" v-if="classes.length != 0">
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
        <Datatable v-if="classes.length != 0" titleDatatable="Liste des élèves" :headers="headers" :items="data" :displayAddButton="false" >
            <template v-slot:item.actions="{item}">
                <v-icon size="small" class="me-2" title="Imprimer" @click="printItem(item)" :icon="icons.mdiPrinter" color="info">
                </v-icon>
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
        @close="closeDetailBulletin"
    />
  </v-card>
</template>
