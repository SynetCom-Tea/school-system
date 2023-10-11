<script >
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import FiltreAffichageNote from "@/Components/Gestion-note/FiltreAffichageNote.vue";
import TableauDeNote from "@/Components/Gestion-note/TableauDeNote.vue";
import {
    Head,
    router,
    useForm
} from "@inertiajs/vue3";
import {
    mdiAccountSchool,
    mdiPlus,
    mdiPencil,
    mdiDelete,
    mdiPlusCircle,
    mdiClipboardEditOutline,
    mdiTools,
    mdiCloseCircle,
    mdiCheckCircle,
    mdiPercentOutline,
    mdiTimelineAlert,
    mdiContentSaveEditOutline,
} from '@mdi/js'
export default {
    components: {
      FiltreAffichageNote,
      FiltreAffichageNote,
        // Datatable,
        mdiAccountSchool,
        mdiPlus,
        mdiPencil,
        mdiDelete,
        mdiPlusCircle,
        mdiClipboardEditOutline,
        mdiTools,
        mdiCloseCircle,
        mdiCheckCircle,
        mdiPercentOutline,
        mdiTimelineAlert,
        mdiContentSaveEditOutline
    },
    layout: AuthenticatedLayout,
    props: ['classes', 'evaluations', 'notes','type'],
    data() {
        return {
            icon: {
                mdiAccountSchool,
                mdiPlus,
                mdiPencil,
                mdiDelete,
                mdiPlusCircle,
                mdiClipboardEditOutline,
                mdiTools,
                mdiCloseCircle,
                mdiCheckCircle,
                mdiPercentOutline,
                mdiTimelineAlert,
                mdiContentSaveEditOutline
            },
            headers : [{
                    title: '#',
                    align: 'start',
                    key: 'apprenant.matricule',
                    sortable: false,
                },
                {
                    title: "Nom",
                    align: "center",
                    key: "apprenant"
                },
                {
                    title: "Note",
                    align: "center",
                    key: "note"
                },
            ],
            form: useForm({
                section_id : null
            }),
        }
    },
    methods:{
      create(){
        this.form.section_id = this.type
        this.form.get(route('note.attribution'))
      }
    }
}
</script>

<template>
<Head title="Notes" />
<AuthenticatedLayout>
    <Toolbar :icon="icon.mdiAccountPlusOutline" toolbarTitle="Gestion des notes"></Toolbar>
<br>
<Button class="mb-2" style="height: 40px" nameButton="Ajouter" title="Valider et Fermer la modale" small color="primary" variant="outlined" :prependIcon="icon.mdiPlus" @click="create">
</Button>
    <v-card style="margin: 20px">
        <v-card-title>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">Choisissez les criteres</div>
                </div>
            </div>
        </v-card-title>
        <FiltreAffichageNote :classes="classes" :evaluations="evaluations"></FiltreAffichageNote>
    </v-card>
    <v-card style="margin: 20px" v-if="notes">
        <v-card-title>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">Liste de notes</div>
                </div>
            </div>
        </v-card-title>
        <!-- <v-data-table :items="props.notes" :headers="headers" :search="search"></v-data-table> -->
        <Datatable titleDatatable="Listes des notes" v-if="notes" :displayAddButton="false" :items="notes" :headers="headers">
            <template v-slot:item.apprenant="{ item}">
                    {{ item.columns.apprenant.nom }} {{ item.columns.apprenant.prenom }}
        </template>
        </Datatable>
    </v-card>
</AuthenticatedLayout>
</template>
