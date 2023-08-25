<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router } from "@inertiajs/vue3";
import {
    mdiPlus,
    mdiTimetable
} from '@mdi/js'
export default {
    layout: AuthenticatedLayout,
    props: ["emplois"],
    data() {
        return {
            icon: {
                mdiPlus,
                mdiTimetable
            },
        }
    },
    methods: {
        goTo() {
            router.get(route('emplois.create'))
        },
    }
}
</script>
<template>
    <v-card>
        <page-toolbar :icon="icon.mdiTimetable">Gestion des Emplois</page-toolbar>
        <v-card-text>
            <v-card>
                <btn v-bind="props">
                    <v-icon  @click="goTo()">{{ icon.mdiPlus }}</v-icon> Ajouter
                </btn>
            </v-card>
        </v-card-text>
    </v-card>
</template>