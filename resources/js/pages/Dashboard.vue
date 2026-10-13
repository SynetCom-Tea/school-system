<script>
import AuthenticatedLayout from "@/layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import ExampleApplicationDatatable from "../components/customizedComponents/ExampleApplicationDatatable.vue";
import Dialog from "../components/customizedComponents/Dialog.vue";
import Loader from "../components/customizedComponents/Loader.vue";
import ModalDetailUpdate from "../components/customizedComponents/ModalDetailUpdate.vue";
import {
    mdiAccount,
    mdiPurse,
    mdiHomeOutline,
    mdiPresentation,
    mdiGift,
    mdiCalendarBlankOutline,
    mdiCalendarCheckOutline,
} from "@mdi/js";
import {
    Vue3Marquee
} from "vue3-marquee";
import {
    VueSpinner,
    VueSpinnerHourglass
} from "vue3-spinners";
import Datatable from "../components/customizedComponents/datatable.vue";
import Toolbar from "../components/customizedComponents/Toolbar.vue";
export default {
    props: {
        dashboardStats: {
            type: Object,
            default: () => ({
                students: 0,
                classes: 0,
                teachers: 0,
                payments: 0,
                terminal_a: 0,
                terminal_d: 0,
                troisieme: 0,
                unpaid_payments: 0,
            }),
        },
        schoolYearLabel: {
            type: String,
            default: "Aucune année active",
        },
        isSelectedYearActive: {
            type: Boolean,
            default: false,
        },
        schoolYears: {
            type: Array,
            default: () => [],
        },
        selectedYearId: {
            type: Number,
            default: null,
        },
    },
    components: {
        ExampleApplicationDatatable,
        Loader,
        Datatable,
        Toolbar,
        ModalDetailUpdate,
        VueSpinnerHourglass,
        AuthenticatedLayout,
        VueSpinner,
        Head,
        Dialog,
        Vue3Marquee,
        mdiAccount,
        mdiPurse,
        mdiHomeOutline,
        mdiPresentation,
        mdiGift,
    },
    computed: {
        selectedYearStatus() {
            if (!this.selectedYearId) {
                return "Aucune année sélectionnée";
            }

            return this.isSelectedYearActive ? "active" : "Année sélectionnée";
        },
        overviewCards() {
            return [
                { label: "Élèves inscrits", value: this.dashboardStats.students, icon: mdiAccount, detail: `Pour l'année ${this.schoolYearLabel}`, color: "#176b5b" },
                { label: "Classes ouvertes", value: this.dashboardStats.classes, icon: mdiHomeOutline, detail: `Pour l'année ${this.schoolYearLabel}`, color: "#b45b35" },
                { label: "Enseignants affectés", value: this.dashboardStats.teachers, icon: mdiPresentation, detail: `Pour l'année ${this.schoolYearLabel}`, color: "#3d638c" },
                { label: "Versements encaissés", value: this.formatAmount(this.dashboardStats.payments), icon: mdiPurse, detail: "Montant cumulé · FCFA", color: "#8b6a20" },
                { label: "Élèves en Terminale A", value: this.dashboardStats.terminal_a, icon: mdiAccount, detail: `Pour l'année ${this.schoolYearLabel}`, color: "#176b5b" },
                { label: "Élèves en Terminale D", value: this.dashboardStats.terminal_d, icon: mdiAccount, detail: `Pour l'année ${this.schoolYearLabel}`, color: "#3d638c" },
                { label: "Élèves en Troisième", value: this.dashboardStats.troisieme, icon: mdiAccount, detail: `Pour l'année ${this.schoolYearLabel}`, color: "#b45b35" },
                { label: "Reste à encaisser", value: this.formatAmount(this.dashboardStats.unpaid_payments), icon: mdiPurse, detail: "Montant restant · FCFA", color: "#9b3e36" },
            ];
        },
    },
    data() {
        return {
            subjects: [], // Liste des matières uniques
            tableHeaders: [], // En-têtes du tableau
            test: "Abou",
            isDialog: false,
            rules: {
                required: (value) => !!value || "Required.",
                counter: (value) => value.length <= 20 || "Max 20 characters",
                email: (value) => {
                    const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    return pattern.test(value) || "Invalid e-mail.";
                },
            },
            

            icons: { mdiGift, mdiAccount, mdiCalendarBlankOutline, mdiCalendarCheckOutline },
           
        };
    },
    methods: {
        formatAmount(amount) {
            return new Intl.NumberFormat("fr-FR", { maximumFractionDigits: 0 }).format(Number(amount) || 0);
        },
        selectSchoolYear(yearId) {
            if (!yearId || Number(yearId) === Number(this.selectedYearId)) {
                return;
            }

            router.get("/dashboard", { annee_id: yearId }, {
                preserveScroll: true,
                replace: true,
            });
        },
        getGrades(student, subject) {
            const foundGrade = student.grades.find(grade => grade.subject === subject);
            if (foundGrade) {
                return `Classe: ${foundGrade.classGrade}, Composition: ${foundGrade.compositionGrade}`;
            } else {
                return 'N/A';
            }
        },
        calculateWeightedAverage(student) {
            const totalGrades = student.grades.reduce((total, grade) => {
                return total + (grade.classGrade + grade.compositionGrade) / 2 * grade.coefficient;
            }, 0);

            const totalCoefficients = student.grades.reduce((total, grade) => {
                return total + grade.coefficient;
            }, 0);

            return totalCoefficients !== 0 ? (totalGrades / totalCoefficients).toFixed(2) : 'N/A';
        },
        onClickBt() {
            this.isDialog = !this.isDialog;
        },
        onCloseModale() {
            this.isDialog = false;
        },
        onChangeTitle(e) { },

        editItem(item) { },
        deleteItem(item) { },
    },
};
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <Toolbar styleToolbar="background-color: white;" :icon="mdiHomeOutline" toolbarTitle="Accueil"></Toolbar>
        <main class="dashboard-overview">
            <header class="overview-heading">
                <div>
                    <p class="overview-eyebrow">VUE D'ENSEMBLE</p>
                    <h1>Tableau de bord</h1>
                    <p class="overview-caption">Les principaux indicateurs de votre établissement.</p>
                </div>
                <div class="year-controls">
                    <v-select
                        class="year-select"
                        :model-value="selectedYearId"
                        :items="schoolYears"
                        item-title="libelle"
                        item-value="id"
                        label="Année scolaire"
                        :prepend-inner-icon="icons.mdiCalendarBlankOutline"
                        :menu-props="{ attach: 'body', maxHeight: 360 }"
                        variant="outlined"
                        density="comfortable"
                        hide-details
                        @update:model-value="selectSchoolYear"
                    />
                    <v-chip
                        class="year-status"
                        :color="isSelectedYearActive ? 'success' : 'default'"
                        :prepend-icon="icons.mdiCalendarCheckOutline"
                        variant="tonal"
                    >
                        {{ schoolYearLabel }} · {{ selectedYearStatus }}
                    </v-chip>
                </div>
            </header>

            <v-row class="overview-grid">
                <v-col v-for="card in overviewCards" :key="card.label" cols="12" sm="3" xl="3">
                    <v-card class="overview-card" variant="flat">
                        <div class="overview-icon" :style="{ color: card.color, backgroundColor: `${card.color}16` }">
                            <v-icon :icon="card.icon" size="22" />
                        </div>
                        <div class="overview-card-copy">
                            <p>{{ card.label }}</p>
                            <strong>{{ card.value }}</strong>
                            <span>{{ card.detail }}</span>
                        </div>
                    </v-card>
                </v-col>
            </v-row>
        </main>
       
    </AuthenticatedLayout>
</template>

<style scoped>
.dashboard-overview {
    padding: 32px clamp(16px, 3vw, 40px) 8px;
}

.overview-heading {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 24px;
}

.overview-eyebrow {
    margin: 0 0 8px;
    color: #176b5b;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1px;
}

.overview-heading h1 {
    margin: 0;
    color: #172b29;
    font-size: 28px;
    font-weight: 700;
}

.overview-caption {
    margin: 6px 0 0;
    color: #687774;
    font-size: 14px;
}

.year-controls {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    flex-wrap: wrap;
    gap: 12px;
    min-width: 0;
}

.year-select {
    flex: 0 1 280px;
    min-width: 220px;
}

.year-status {
    max-width: 100%;
}

.overview-grid {
    row-gap: 4px;
}

.overview-card {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    min-height: 142px;
    padding: 22px;
    border: 1px solid #e4eae7;
    border-radius: 6px;
    background: #fff;
}

.overview-icon {
    display: grid;
    flex: 0 0 44px;
    width: 44px;
    height: 44px;
    place-items: center;
    border-radius: 6px;
}

.overview-card-copy {
    display: flex;
    min-width: 0;
    flex-direction: column;
}

.overview-card-copy p,
.overview-card-copy span {
    margin: 0;
    color: #687774;
    font-size: 13px;
}

.overview-card-copy strong {
    overflow-wrap: anywhere;
    margin: 9px 0 5px;
    color: #172b29;
    font-size: 26px;
    line-height: 1.15;
}

@media (max-width: 600px) {
    .overview-heading {
        align-items: flex-start;
        flex-direction: column;
    }

    .year-select {
        width: 100%;
        max-width: 360px;
    }

    .year-controls {
        align-items: flex-start;
        flex-direction: column;
        width: 100%;
    }

    .overview-heading h1 {
        font-size: 24px;
    }
}
</style>
