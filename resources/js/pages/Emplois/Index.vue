<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import "qalendar/dist/style.css";
import {
    router,
    useForm
} from "@inertiajs/vue3";
import {
    mdiPlus,
    mdiTimetable,
    mdiDelete,
    mdiPencil
} from "@mdi/js";
import {
    Qalendar
} from "qalendar";
export default {
    layout: AuthenticatedLayout,
    components: {
        Qalendar,
    },
    props: ["emplois", "events", "AllClasses", "niveaux", "emplois", "sectionID"],
    data() {
        return {
            icons: {
                mdiPlus,
                mdiTimetable,
                mdiPencil,
                mdiDelete
            },
            headers: [{
                    title: 'Code',
                    align: 'start',
                    sortable: false,
                    key: 'code',
                },
                {
                    title: 'Date',
                    align: 'center',
                    key: 'tranche_date'
                },
                {
                    title: 'Classe',
                    align: 'center',
                    key: 'nom_classe'
                },
                {
                    title: 'Actions',
                    align: 'center',
                    key: 'actions'
                },
            ],
            classes: [],
            form: useForm({
                niveau: null,
                classe: null,
                date: null,
                emploi: null,
                section_id: null
            }),
        };
    },
    methods: {
        goTo() {
            this.form.get(route("emplois.create"))
            // router.get(route("emplois.create"));
        },
        setClasse(niveau) {
            this.form.classe = null
            this.form.emploi = null
            this.classes = this.AllClasses.filter((classe) => {
                return classe.niveau_id == niveau;
            });
        },
        setEmploi(classe) {
            this.$inertia.replace(this.$page.url, {
                data: {
                    classe: classe,
                }
            })
        },
        editItem() {

        },
        deleteItem() {

        }
    },
    mounted() {
        this.form.section_id = this.sectionID
        console.log(this.emplois)
    }
};
</script>
<template>
<v-card>
    <Toolbar :icon="icons.mdiTimetable" toolbarTitle="Gestion des Emplois"></Toolbar>
    <v-card-text>
        <v-toolbar flat color="white">
            <v-toolbar-title style="
            font-size: 1em;
            width: 250px;
            word-wrap: break-word;
            white-space: pre-wrap;
            word-break: break-word;
          ">
                <v-row>
                    <v-col md="4">
                        <autocomplete label="Niveau" v-model="form.niveau" :items="niveaux" isRequired class="mt-4" @update:modelValue="setClasse(form.niveau)" item-title="libelle" item-value="id"></autocomplete>
                    </v-col>
                    <v-col md="4">
                        <autocomplete label="Classe" v-model="form.classe" :items="classes" :disabled="!form.niveau" @update:modelValue="setEmploi(form.classe)" class="mt-4" isRequired item-title="libelle" item-value="id"></autocomplete>
                    </v-col>
                </v-row>
            </v-toolbar-title>
        </v-toolbar>
        <v-card>
            <Datatable titleDatatable="Liste des emplois" :headers="headers" :items="emplois" :functionOnClickAddButton="goTo">
                <template v-slot:item.actions="{item}">
                    <v-icon size="small" class="me-2" title="Modifier" @click="editItem(item.raw)" :icon="icons.mdiPencil" color="orange">
                    </v-icon>
                    <v-icon size="small" class="me-2" title="Supprimer" @click="deleteItem(item.raw)" :icon="icons.mdiDelete" color="red">
                    </v-icon>
                </template>
            </Datatable>
        </v-card>
    </v-card-text>
</v-card>
</template>

<style scoped>
.add-button-style:hover {
    background-color: #7d002c;
    box-shadow: 0px 0px 8px #7d002c;
    transform: scale(1.05);
    cursor: pointer;
}

.add-button-style {
    height: 30px;
    /* background-color: #7d002c; */
    text-transform: none;
    box-shadow: 10px 5px 5px #7d002c;
    /* 0px 0px 5px #7d002c; */
}
</style>
