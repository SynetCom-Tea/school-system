<script>
// Données des notes des élèves par matière avec coefficients, note de classe et note de composition
const students = [{
        id: 1,
        name: "Alice",
        grades: [{
                subject: "Mathématiques",
                classGrade: 80,
                compositionGrade: 90,
                coefficient: 3
            },
            {
                subject: "Français",
                classGrade: 75,
                compositionGrade: 85,
                coefficient: 2
            },
            // Autres matières, notes de classe et de composition pour Alice
        ],
    },
    {
        id: 2,
        name: "Bob",
        grades: [{
                subject: "Mathématiques",
                classGrade: 70,
                compositionGrade: 85,
                coefficient: 3
            },
            {
                subject: "Français",
                classGrade: 80,
                compositionGrade: 90,
                coefficient: 2
            },
            // Autres matières, notes de classe et de composition pour Bob
        ],
    },
    // Autres élèves avec leurs matières, notes de classe et de composition
];

import AuthenticatedLayout from "@/layouts/AuthenticatedLayout.vue";
import {
    Head
} from "@inertiajs/vue3";

import ExampleApplicationDatatable from "../components/customizedComponents/ExampleApplicationDatatable.vue";
import Dialog from "../components/customizedComponents/Dialog.vue";
import Loader from "../components/customizedComponents/Loader.vue";
import ModalDetailUpdate from "../components/customizedComponents/ModalDetailUpdate.vue";
import {
    mdiAccount,
    mdiPurse,
    mdiHomeOutline,
    mdiPresentation,
    mdiGift
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
    data() {
        return {
            headersH: [{
                    title: "Dessert (100g serving)",
                    align: "start",
                    sortable: false,
                    key: "name",
                },
                {
                    title: "Calories",
                    key: "calories"
                },
                {
                    title: "Fat (g)",
                    key: "fat"
                },
                {
                    title: "Carbs (g)",
                    key: "carbs"
                },
                {
                    title: "Protein (g)",
                    key: "protein"
                },
                {
                    title: "Actions",
                    key: "actions",
                    sortable: false
                },
            ],
            headers: [{
                    title: "N°",
                    align: "start",
                    key: "id",
                    sortable: false,
                },
                {
                    title: "Titre",
                    align: "center",
                    key: "title"
                },

                {
                    title: "Actions",
                    key: "actions",
                    sortable: false,
                },
            ],
            dataH: [{
                    id: 1,
                    title: "Ali",
                },
                {
                    id: 2,
                    title: "Sara",
                },
                {
                    id: 3,
                    title: "Sani",
                },
            ],
            desserts: [{
                    name: "Frozen Yogurt",
                    calories: 159,
                    fat: 6.0,
                    carbs: 24,
                    protein: 4.0,
                },
                {
                    name: "Ice cream sandwich",
                    calories: 237,
                    fat: 9.0,
                    carbs: 37,
                    protein: 4.3,
                },
                {
                    name: "Eclair",
                    calories: 262,
                    fat: 16.0,
                    carbs: 23,
                    protein: 6.0,
                },
                {
                    name: "Cupcake",
                    calories: 305,
                    fat: 3.7,
                    carbs: 67,
                    protein: 4.3,
                },
                {
                    name: "Gingerbread",
                    calories: 356,
                    fat: 16.0,
                    carbs: 49,
                    protein: 3.9,
                },
                {
                    name: "Jelly bean",
                    calories: 375,
                    fat: 0.0,
                    carbs: 94,
                    protein: 0.0,
                },
                {
                    name: "Lollipop",
                    calories: 392,
                    fat: 0.2,
                    carbs: 98,
                    protein: 0,
                },
                {
                    name: "Honeycomb",
                    calories: 408,
                    fat: 3.2,
                    carbs: 87,
                    protein: 6.5,
                },
                {
                    name: "Donut",
                    calories: 452,
                    fat: 25.0,
                    carbs: 51,
                    protein: 4.9,
                },
                {
                    name: "KitKat",
                    calories: 518,
                    fat: 26.0,
                    carbs: 65,
                    protein: 7,
                },
            ],
            students: [
                // Inclure les données des élèves avec notes de classe, notes de composition, matières et coefficients
            ],
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
            editedObject: {
                name: "",
                calories: 0,
                fat: 0,
                carbs: 0,
                protein: 0,
            },

            icons: {
                mdiGift,
                mdiAccount
            },
            listGreetings: [{
                    id: 1,
                    text: "Wa fonda kayan!",
                    color: "red"
                },
                {
                    id: 2,
                    text: "Barka da zouwa!",
                    color: "blue"
                },
                {
                    id: 3,
                    text: "Bienvenue!",
                    color: "gray"
                },
                {
                    id: 1,
                    text: "Welcome!",
                    color: "green"
                },
                {
                    id: 1,
                    text: "Marhaba!",
                    color: "red"
                },
            ],
        };
    },
    mounted() {
        this.extractSubjects();

    },

    methods: {
        extractSubjects() {
            // Extraction des matières uniques à partir des données
            const allSubjects = students.flatMap(student => student.grades.map(grade => grade.subject));
            this.subjects = [...new Set(allSubjects)];
            this.tableHeaders = ['Élève', ...this.subjects, 'Moyenne'];

            console.log('Students', students)
            console.log('allSubjects', allSubjects)
            console.log('tableHeaders', this.tableHeaders)
            console.log('this.subjects', this.subjects)
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
        onChangeTitle(e) {},

        editItem(item) {},
        deleteItem(item) {},
    },
};
</script>

<template>
<Head title="Dashboard" />

<AuthenticatedLayout>
    <Toolbar styleToolbar="background-color: white;" :icon="icons.mdiHome" toolbarTitle="Acceuil"></Toolbar>
    <div class="mt-10">
        <Vue3Marquee :duration="25">
            <v-row>
                <v-col :cols="12 / listGreetings.length" v-for="item in listGreetings" :key="item.id" style="cursor:' pointer; background-color:#7d002c; color:white">
                    <v-hover v-slot="{ isHovering, props }" open-delay="200">
                        <v-card-text :elevation="isHovering ? 4 : 2" :color="isHovering ? 'primary' : 'undefined'" :class="{ 'on-hover': isHovering }" v-bind="props">{{ item.text }}
                        </v-card-text>
                    </v-hover>
                </v-col>
                &nbsp;&nbsp;
            </v-row>
        </Vue3Marquee>
    </div>
    <br /><br /><br /><br /><br /><br />

    <div>
        <h2>Tableau Récapitulatif des Notes par Matière avec Moyenne Ponderée</h2>
        <v-card>
            <v-card-title>Notes des Élèves</v-card-title>
            <v-data-table :headers="tableHeaders" :items="students" item-key="id">
                <template v-for="subject in subjects" v-slot:[`item.${subject}`]="{ item }">
                    <td>
                        {{ getGrades(item, subject) }}
                    </td>
                </template>
                <template v-slot:[`item.Moyenne`]="{ item }">
                    <td>
                        {{ calculateWeightedAverage(item) }}
                    </td>
                </template>
            </v-data-table>
        </v-card>
    </div>

    <Button variant="flat" density="comfortable" title="title" class="m-4" color="red" nameButton="Test Loader" :prependIcon="icons.mdiAccount" :appendIcon="icons.mdiGift" :onClickButton="onClickBt"></Button>
</AuthenticatedLayout>
</template>
