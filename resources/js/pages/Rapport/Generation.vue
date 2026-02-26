<script>
const PdfPrinter = () => import("../../components/Rapports/PdfPrinter.vue");
import DetailBulletin from '@/components/Rapports/DetailBulletin.vue';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {
    mdiDatabaseSync,
    mdiTimerSync,
    mdiPrinter,
    mdiAccountFileTextOutline,
    mdiCloseCircle,
    mdiEye,
    mdiRepeat,
    mdiChartDonut,
    mdiRepeatVariant
} from "@mdi/js";
import jsPDF from 'jspdf';
export default {
    components: {
        PdfPrinter,
        DetailBulletin
    },
    layout: AuthenticatedLayout,
    props: ["sectionID", "resultats", "periodes", "filieres", "cycle_filieres", "apprenant", "section", "apprenants", "premieregeneration"],
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
        headers: [{
            title: 'Matricule',
            align: 'start',
            sortable: false,
            key: 'matricule_apprenant',
        },
        {
            title: 'Nom & Prénom',
            align: 'center',
            key: 'nom_prenom_apprenant'
        },
        {
            title: 'Moyenne',
            align: 'center',
            key: 'moyenne_details_notes'
        },
        {
            title: 'Actions',
            align: 'center',
            key: 'actions'
        },
        ],
        headersSecondaire: [{
            title: 'Matricule',
            align: 'start',
            sortable: false,
            key: 'matricule_apprenant',
        },
        {
            title: 'Nom & Prénom',
            align: 'center',
            key: 'nom_prenom_apprenant'
        },
        {
            title: 'Moyenne',
            align: 'center',
            key: 'moyenne_details_notes'
        },
        {
            title: 'Actions',
            align: 'center',
            key: 'actions'
        },
        ],
        headersSup: [{
            title: 'Matricule',
            align: 'start',
            sortable: false,
            key: 'matricule_apprenant',
        },
        {
            title: 'Nom & Prénom',
            align: 'center',
            key: 'nom_prenom_apprenant'
        },
        {
            title: 'Moyenne',
            align: 'center',
            key: 'moyenne_details_notes'
        },
        {
            title: 'Actions',
            align: 'center',
            key: 'actions'
        },
        ],
        tab: 'option-1',
        data: [],
        donnees: [],
        detailData: null,
        apprenantData: [],
        classes: [],
        session1: null,
        session2: null,
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
        '$page.props.flash.message': {
            handler(val) {
                if (val) {
                    this.$swal({
                        icon: val.type || 'info',
                        title: val.type == 'error' ? 'Erreur' : 'Information',
                        text: val.text,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                    });
                }
            },
            deep: true,
        },
    },
    methods: {
        impBulClasse() {
            console.log(this.classe, this.periode, this.sectionID, 'heeee');
            window.open(route('bulletin', {
                type: 1,
                classe: this.classe,
                periode: this.periode,
                section: this.sectionID
            }), '_blank');
            // window.location.href = route('bulletin', { type: 1, classe: this.classe, periode: this.periode, section: this.sectionID}) 
        },
        async generate(action = 'generate') {
            if (this.tab == 'option-1') {
                if (!this.classe || !this.periode) {
                    this.$swal({
                        icon: 'warning',
                        title: 'Champs requis',
                        text: 'Veuillez sélectionner une classe et une période.',
                    });
                    return;
                }

                const processInertiaCall = () => {
                    this.$inertia.replace(this.$page.url, {
                        data: {
                            classe: this.classe,
                            periode: this.periode,
                            tab: this.tab,
                            session: this.session1,
                            action: action
                        }
                    });
                    if (this.sectionID == 3) {
                        this.setData(this.classe);
                    }
                    if (this.sectionID == 1) {
                        this.setData(this.classe);
                    }
                    this.data = this.resultats;
                };

                if (action === 'generate') {
                    this.$swal({
                        title: 'Êtes-vous sûr?',
                        text: "Voulez-vous vraiment générer les bulletins pour cette classe ? Cette action recalculera toutes les moyennes.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#004980',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Oui, générer!',
                        cancelButtonText: 'Annuler'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            processInertiaCall();
                        }
                    });
                } else {
                    processInertiaCall();
                }

            } else if (this.tab == 'option-2') {
                console.log('section', this.sectionID, 'periode', this.periode2, 'classe ', this.classe2, 'tab', this.tab, 'apprenant', this.apprenant2);

                if (!this.classe2 || !this.periode2 || (this.sectionID == 3 && !this.session2)) {
                    this.$swal({
                        icon: 'warning',
                        title: 'Champs requis',
                        text: 'Veuillez remplir tous les champs obligatoires.',
                    });
                    return;
                }this.$inertia.replace(this.$page.url, {
                        data: {
                             section_id: this.sectionID,
                            classe: this.classe2,
                            periode: this.periode2,
                            tab: this.tab,
                            apprenant: this.apprenant2,
                            session: this.session2
                        }
                    });
                // await axios
                //     .get(
                //         route('bulletinbyapprenant', {
                //             section_id: this.sectionID,
                //             classe: this.classe2,
                //             periode: this.periode2,
                //             tab: this.tab,
                //             apprenant: this.apprenant2,
                //             session: this.session2
                //         })
                //     )
                //     .then(res => {
                //         console.log(res.data)
                //         this.donnees = res.data;
                //     })
                    // .catch(error => {
                    //     console.error("Erreur lors de la récupération des bulletins:", error);
                    //     this.$swal({
                    //         icon: 'error',
                    //         title: 'Erreur réseau',
                    //         text: "Une erreur est survenue lors de la récupération des bulletins. Veuillez vérifier votre connexion ou réessayer plus tard.",
                    //     });
                    // });
                    // .catch(error => {
                    //     console.error(error.response);
                    //     this.$swal({
                    //         icon: 'error',
                    //         title: 'Erreur',
                    //         text: error.response?.data?.message || 'Erreur serveur'
                    //     });
                    // });
            }
        },
        setData(classe) {
            if (this.sectionID == 1) {
                this.data = this.resultats;
            } else if (this.sectionID == 3) {
                this.data = this.resultats;
                // console.log('daza', this.$page.props.resultats);
            }
        },
        setClasse(filiere) {
            if (this.sectionID == 1 || this.sectionID == 2) {
                this.$inertia.replace(this.$page.url, {
                    data: {
                        classe: this.classe2,
                        periode: this.periode2,
                        tab: this.tab
                    }
                });
            } else if (this.sectionID == 3) {
                let cf = this.$page.props.cycle_filieres.filter((c_f) => c_f.filiere_id == filiere);
                const cycleFiliereIds = cf.map((item) => item.id);
                this.classes = this.$page.props.classes.filter((classe) => cycleFiliereIds.includes(classe.cycle_filiere_id));
            }
        },
        setApprenant() {
            this.$inertia.replace(this.$page.url, {
                data: {
                    classe: this.classe2,
                    tab: this.tab,
                    session: this.session2
                }
            });
        },
        openBulletinDialog(item) {
            this.detailData = item;
            console.log('Po', item)
            this.dialog = true;
        },
        closeDetailBulletin() {
            this.dialog = false;
        },
        printItem(item) {
            console.log('item print', item);
        }
    },
    mounted() {
        if (this.sectionID == 1 || this.sectionID == 2) {
            this.classes = this.$page.props.classes
        }
    }
}
</script>

<template>
    <v-card>
        <Toolbar :icon="icons.mdiDatabaseSync" :toolbarTitle="`Génération des bulletins - Section ${section}`">
        </Toolbar>
        <v-card-text>
            <v-alert type="info" title="Information"
                text="La génération par période s'effectue à la fin des évaluations de la période sélectionnée. En revanche, la génération par élève concerne ceux dont les notes ont été modifiées, ceux qui n'ont pas participé à une évaluation, ou encore ceux qui sont en session."
                variant="tonal"></v-alert>
            <v-card>
                <v-tabs v-model="tab" color="deep-purple-accent-4" align-tabs="center">
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
                                <v-row v-if="sectionID == 3">
                                    <v-col md="2">
                                        <autocomplete label="Filière" v-model="filiere" class="mt-4"
                                            :items="$page.props.filieres" @update:modelValue="setClasse(filiere)"
                                            item-title="code" item-value="id"></autocomplete>
                                    </v-col>
                                    <v-col md="4" v-if="filiere">
                                        <autocomplete label="Classe" v-model="classe" :items="classes" class="mt-4"
                                            isRequired item-title="libelle" item-value="id"></autocomplete>
                                    </v-col>
                                    <v-col cols="2">
                                        <autocomplete class="mt-4" v-model="periode" label="Periodes"
                                            itemTitle="libelle" itemValue="id" :items="periodes" variant="outlined"
                                            :isRequired="true" :disabled="!classe" chips clearable>
                                        </autocomplete>
                                    </v-col>
                                    <v-col cols="2">
                                        <autocomplete class="mt-4" v-model="session1" label="Sessions"
                                            :items="['Prémiere session', 'Deuxiéme session']" variant="outlined"
                                            :isRequired="true" clearable>
                                        </autocomplete>
                                    </v-col>
                                    <v-col md="4" class="d-flex align-center">
                                        <v-btn v-if="premieregeneration" class="mt-4" :append-icon="icons.mdiTimerSync"
                                            color="deep-purple-accent-4" @click="generate('generate')"
                                            :disabled="!session1">
                                            Générer
                                        </v-btn>
                                        <template v-else>
                                            <v-btn class="mt-4" :append-icon="icons.mdiEye" color="info"
                                                @click="generate('view')" :disabled="!session1">
                                                Voir
                                            </v-btn>
                                        </template>
                                    </v-col>
                                </v-row>
                                <v-row v-if="sectionID == 1 || sectionID == 2">
                                    <v-col cols="4">
                                        <autocomplete class="mt-4" v-model="periode" label="Periodes"
                                            itemTitle="libelle" itemValue="id" :items="periodes" variant="outlined"
                                            :isRequired="true" chips clearable>
                                        </autocomplete>
                                    </v-col>
                                    <v-col md="3">
                                        <autocomplete label="Classe" v-model="classe" :items="classes"
                                            :disabled="!periode" class="mt-4" isRequired item-title="libelle"
                                            item-value="id">
                                        </autocomplete>
                                    </v-col>
                                    <v-col md="2" class="d-flex align-center">
                                        <v-btn :append-icon="icons.mdiTimerSync" color="deep-purple-accent-4"
                                            @click="generate('generate')" :disabled="!periode">
                                            Générer
                                        </v-btn>
                                        <v-btn class="mx-4" :append-icon="icons.mdiEye" color="info"
                                            @click="generate('view')" :disabled="!periode">
                                            Voir
                                        </v-btn>
                                    </v-col>
                                </v-row>
                                <Datatable v-if="classes.length !== 0 && (sectionID == 1)"
                                    titleDatatable="Liste des élèves" :headers="headers" :items="data"
                                    :functionOnClickAddButton="impBulClasse" :libelleButton="'Bulletin de la classe'"
                                    :displayAddButton="classe ? true : false">
                                    <template v-slot:item.actions="{ item }">
                                        <a :href="route('bulletin', { type: 0, id: item.id, section: sectionID })"
                                            target="__blank">
                                            <v-icon size="small" class="me-2" title="Imprimer" :icon="icons.mdiPrinter"
                                                color="info"></v-icon>
                                        </a>
                                        <v-icon size="small" class="me-2" title="Detail"
                                            @click="openBulletinDialog(item)" :icon="icons.mdiEye" color="info">
                                        </v-icon>
                                    </template>
                                </Datatable>
                                <Datatable v-if="classes.length !== 0 && (sectionID == 2)"
                                    titleDatatable="Liste des élèves" :headers="headersSecondaire" :items="data"
                                    :functionOnClickAddButton="impBulClasse" :libelleButton="'Bulletin de la classe'"
                                    :displayAddButton="classe ? true : false">
                                    <template v-slot:item.actions="{ item }">
                                        <a :href="route('bulletin', { type: 0, id: item.id, section: sectionID })"
                                            target="__blank">
                                            <v-icon size="small" class="me-2" title="Imprimer" :icon="icons.mdiPrinter"
                                                color="info"></v-icon>
                                        </a>
                                        <v-icon size="small" class="me-2" title="Detail"
                                            @click="openBulletinDialog(item)" :icon="icons.mdiEye" color="info">
                                        </v-icon>
                                    </template>
                                </Datatable>
                                <Datatable v-if="classes.length !== 0 && (sectionID == 3)"
                                    titleDatatable="Liste des etudiants" :headers="headersSup" :items="data"
                                    :displayAddButton="false">
                                    <template v-slot:item.actions="{ item }">
                                        <a :href="route('bulletin', { type: 0, id: item.id, section: sectionID })"
                                            target="__blank">
                                            <v-icon size="small" class="me-2" title="Imprimer" :icon="icons.mdiPrinter"
                                                color="info"></v-icon>
                                        </a>
                                        <v-icon size="small" class="me-2" title="Detail"
                                            @click="openBulletinDialog(item)" :icon="icons.mdiEye" color="info">
                                        </v-icon>
                                    </template>
                                </Datatable>
                            </v-card-text>
                        </v-card>
                    </v-window-item>
                    <v-window-item value="option-2">
                        <v-card flat>
                            <v-card-text>
                                <v-row v-if="sectionID == 1 || sectionID == 2">
                                    <v-col cols="4">
                                        <autocomplete class="mt-4" v-model="periode2" label="Periodes"
                                            itemTitle="libelle" itemValue="id" :items="periodes" variant="outlined"
                                            :isRequired="true" chips clearable>
                                        </autocomplete>
                                    </v-col>
                                    <v-col md="4">
                                        <autocomplete label="Classe" v-model="classe2" :items="classes"
                                            @update:modelValue="setClasse(classe2)" :disabled="!periode2" class="mt-4"
                                            isRequired item-title="libelle" item-value="id"></autocomplete>
                                    </v-col>
                                    <v-col md="4">
                                        <autocomplete :label="apprenant" v-model="apprenant2" :items="apprenants"
                                            :disabled="!classe2" chips class="mt-4" isRequired
                                            :item-title="item => `${item.nom} ${item.prenom}`" item-value="id">
                                        </autocomplete>
                                    </v-col>
                                    <v-col md="4">
                                        <v-btn class="mt-4" :append-icon="icons.mdiTimerSync"
                                            color="deep-purple-accent-4" @click="generate" :disabled="!apprenant2">
                                            Générer
                                        </v-btn>
                                    </v-col>
                                </v-row>
                                <v-row v-if="sectionID == 3">
                                    <v-col md="2">
                                        <autocomplete label="Filière" v-model="filiere2" class="mt-4"
                                            :items="$page.props.filieres" @update:modelValue="setClasse(filiere2)"
                                            item-title="code" item-value="id"></autocomplete>
                                    </v-col>
                                    <v-col md="2" v-if="filiere2">
                                        <autocomplete label="Classe" v-model="classe2" :items="classes" class="mt-4"
                                            isRequired item-title="libelle" item-value="id"></autocomplete>
                                    </v-col>
                                    <v-col cols="2">
                                        <autocomplete class="mt-4" v-model="periode2" label="Periodes"
                                            itemTitle="libelle" itemValue="id" :items="periodes" variant="outlined"
                                            :isRequired="true" :disabled="!classe2" chips clearable>
                                        </autocomplete>
                                    </v-col>
                                    <v-col cols="2">
                                        <autocomplete class="mt-4" v-model="session2" label="Sessions"
                                            :items="['Prémiere session', 'Deuxiéme session']"
                                            @update:modelValue="setApprenant()" variant="outlined" :isRequired="true"
                                            :disabled="!periode2" clearable>
                                        </autocomplete>
                                    </v-col>
                                    <v-col md="2">
                                        <autocomplete :label="apprenant" v-model="apprenant2" :items="apprenants"
                                            :disabled="!session2" multiple chips class="mt-4" isRequired
                                            item-title="matricule" item-value="id">
                                        </autocomplete>
                                    </v-col>
                                    <v-col md="2">
                                        <v-btn class="mt-4" :append-icon="icons.mdiTimerSync"
                                            color="deep-purple-accent-4" @click="generate" :disabled="!apprenant2">
                                            Générer
                                        </v-btn>
                                    </v-col>
                                </v-row>
                                <Datatable v-if="(sectionID == 1)" titleDatatable="Liste des élèves" :headers="headers"
                                    :items="donnees" :functionOnClickAddButton="impBulClasse"
                                    :libelleButton="'Bulletin de la classe'" :displayAddButton="classe ? true : false">
                                    <template v-slot:item.actions="{ item }">
                                        <a :href="route('bulletin', { type: 0, id: item.id, section: sectionID })"
                                            target="__blank">
                                            <v-icon size="small" class="me-2" title="Imprimer" :icon="icons.mdiPrinter"
                                                color="info"></v-icon>
                                        </a>
                                        <v-icon size="small" class="me-2" title="Detail"
                                            @click="openBulletinDialog(item)" :icon="icons.mdiEye" color="info">
                                        </v-icon>
                                    </template>
                                </Datatable>
                                <Datatable v-if="(sectionID == 2)" titleDatatable="Liste des élèves"
                                    :headers="headersSecondaire" :items="donnees"
                                    :functionOnClickAddButton="impBulClasse" :libelleButton="'Bulletin de la classe'"
                                    :displayAddButton="classe ? true : false">
                                    <template v-slot:item.actions="{ item }">
                                        <a :href="route('bulletin', { type: 0, id: item.id, section: sectionID })"
                                            target="__blank">
                                            <v-icon size="small" class="me-2" title="Imprimer" :icon="icons.mdiPrinter"
                                                color="info"></v-icon>
                                        </a>
                                        <v-icon size="small" class="me-2" title="Detail"
                                            @click="openBulletinDialog(item)" :icon="icons.mdiEye" color="info">
                                        </v-icon>
                                    </template>
                                </Datatable>
                                <Datatable v-if="(sectionID == 3)" titleDatatable="Liste des etudiants"
                                    :headers="headersSup" :items="donnees" :displayAddButton="false">
                                    <template v-slot:item.actions="{ item }">
                                        <a :href="route('bulletin', { type: 0, id: item.id, section: sectionID })"
                                            target="__blank">
                                            <v-icon size="small" class="me-2" title="Imprimer" :icon="icons.mdiPrinter"
                                                color="info"></v-icon>
                                        </a>
                                        <v-icon size="small" class="me-2" title="Detail"
                                            @click="openBulletinDialog(item)" :icon="icons.mdiEye" color="info">
                                        </v-icon>
                                    </template>
                                </Datatable>
                            </v-card-text>
                        </v-card>
                    </v-window-item>

                </v-window>
            </v-card>
        </v-card-text>
        <v-dialog overlay-opacity="0.7" v-model="printPdf" max-width="750">
            <v-card>
                <v-toolbar dark color="orange">
                    <v-toolbar-title>
                        <v-icon left :icon="icons.mdiAccountFileTextOutline"></v-icon> Bulletin
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-btn :icon="icons.mdiCloseCircle" title="Fermer" color="error" @click="close()"></v-btn>
                </v-toolbar>
                <PdfPrinter :content="apprenantData" />
            </v-card>
        </v-dialog>
        <DetailBulletin v-if="detailData !== null" v-model="dialog" :data="detailData" :typeSection="sectionID"
            @close="closeDetailBulletin" />
    </v-card>
</template>
