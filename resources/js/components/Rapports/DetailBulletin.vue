<template>
    <v-dialog v-model="dialog" max-width="1200" persistent>
        <v-card v-if="data != null" class="rounded-lg elevation-4">
            <!-- Header Premium -->
            <v-toolbar color="deep-purple-accent-4" dark>
                <v-toolbar-title class="text-h6 font-weight-bold">
                    <v-icon :icon="icons.mdiAccountFileTextOutline" start></v-icon>
                    Détails du Bulletin - {{ data.periode }}
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn icon @click="closeDialog">
                    <v-icon :icon="icons.mdiClose"></v-icon>
                </v-btn>
            </v-toolbar>

            <v-card-text class="pa-6">
                <!-- Zone Info Étudiant (Header de contenu) -->
                <v-sheet border rounded class="pa-4 mb-6 bg-grey-lighten-4">
                    <v-row align="center">
                        <v-col cols="12" md="6">
                            <div class="d-flex align-center mb-2">
                                <v-avatar color="deep-purple-lighten-4" size="48" class="mr-4">
                                    <v-icon color="deep-purple-accent-4" :icon="icons.mdiAccount" size="32"></v-icon>
                                </v-avatar>
                                <div>
                                    <div class="text-overline mb-0 pb-0 text-grey-darken-1">Nom & Prénom</div>
                                    <div class="text-h6 font-weight-bold text-deep-purple-accent-4">{{
                                        data.nom_prenom_apprenant }}</div>
                                </div>
                            </div>
                            <div class="d-flex align-center">
                                <v-icon :icon="icons.mdiCardAccountDetails" size="18" color="grey"
                                    class="mr-2"></v-icon>
                                <span class="text-body-2 text-grey-darken-2">Matricule: <strong>{{
                                    data.matricule_apprenant }}</strong></span>
                            </div>
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-row no-gutters>
                                <v-col cols="6">
                                    <div class="d-flex align-center mb-2">
                                        <v-icon :icon="icons.mdiSchool" color="deep-purple-accent-4"
                                            class="mr-2"></v-icon>
                                        <div>
                                            <div class="text-caption text-grey">Classe</div>
                                            <div class="text-body-1 font-weight-medium">{{ data.nom_classe }}</div>
                                        </div>
                                    </div>
                                </v-col>
                                <v-col cols="6">
                                    <div class="d-flex align-center mb-2">
                                        <v-icon :icon="icons.mdiChartBar" color="deep-purple-accent-4"
                                            class="mr-2"></v-icon>
                                        <div>
                                            <div class="text-caption text-grey">Moyenne</div>
                                            <div class="text-body-1 font-weight-bold">{{ data.moyenne_details_notes }}
                                            </div>
                                        </div>
                                    </div>
                                </v-col>
                                <v-col cols="12">
                                    <div class="d-flex align-center">
                                        <v-icon :icon="icons.mdiFormatListNumbered" color="deep-purple-accent-4"
                                            class="mr-2"></v-icon>
                                        <div>
                                            <span class="text-caption text-grey">Rang: </span>
                                            <span class="text-body-1 font-weight-medium">{{ data.rang || 'N/A' }}</span>
                                        </div>
                                    </div>
                                </v-col>
                            </v-row>
                        </v-col>
                    </v-row>
                </v-sheet>

                <!-- Tables de notes -->
                <!-- Primaire (1) -->
                <v-table density="comfortable" v-if="typeSection == 1" class="border rounded">
                    <thead class="bg-grey-lighten-3">
                        <tr>
                            <th class="text-left font-weight-bold">Matière</th>
                            <th class="text-center font-weight-bold">Notation</th>
                            <th class="text-center font-weight-bold">Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in data.historique_notes" :key="item.nom_matiere">
                            <td>{{ item.nom_matiere }}</td>
                            <td class="text-center">{{ item.notation_matiere }}</td>
                            <td class="text-center font-weight-bold">{{ item.note }}</td>
                        </tr>
                    </tbody>
                </v-table>

                <!-- Secondaire (2) -->
                <v-table density="comfortable" v-if="typeSection == 2" class="border rounded">
                    <thead class="bg-grey-lighten-3">
                        <tr>
                            <th class="text-left font-weight-bold">Matière</th>
                            <th class="text-center font-weight-bold">Coeff.</th>
                            <th class="text-center font-weight-bold">Note Classe</th>
                            <th class="text-center font-weight-bold">Note Classe Coeff.</th>
                            <th class="text-center font-weight-bold">Note Comp.</th>
                            <th class="text-center font-weight-bold">Note Comp. Coeff.</th>
                            <th class="text-center font-weight-bold">Moyenne</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in data.historique_notes" :key="item.nom_matiere">
                            <td>{{ item.nom_matiere }}</td>
                            <td class="text-center">{{ item.coefficient }}</td>
                            <td class="text-center">{{ item.note_de_classe }}</td>
                            <td class="text-center">{{ item.note_de_classe_coefficiente }}</td>
                            <td class="text-center">{{ item.note_de_composition }}</td>
                            <td class="text-center">{{ item.note_de_composition_coefficiente }}</td>
                            <td class="text-center font-weight-bold">{{ item.moyenne }}</td>
                        </tr>
                    </tbody>
                </v-table>

                <!-- Supérieur (3) -->
                <v-data-table v-if="typeSection == 3" :headers="headers" :items="data.historique_notes"
                    :group-by="groupBy" item-value="name" class="border rounded" density="comfortable">
                    <template v-slot:group-header="{ item, columns, toggleGroup, isGroupOpen }">
                        <tr class="bg-deep-purple-lighten-5">
                            <td :colspan="columns.length">
                                <v-btn size="small" variant="text" :icon="isGroupOpen(item) ? '$expand' : '$next'"
                                    @click="toggleGroup(item)"></v-btn>
                                <span class="font-weight-bold text-deep-purple-darken-2">UE: {{ item.value }}</span>
                            </td>
                        </tr>
                    </template>
                </v-data-table>
            </v-card-text>

            <v-divider></v-divider>
            <v-card-actions class="pa-4 bg-grey-lighten-4">
                <v-spacer></v-spacer>
                <v-btn color="deep-purple-accent-4" variant="elevated" @click="closeDialog"
                    :prepend-icon="icons.mdiClose">
                    Fermer
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import {
    mdiAccount,
    mdiSchool,
    mdiCardAccountDetails,
    mdiChartBar,
    mdiFormatListNumbered,
    mdiAccountFileTextOutline,
    mdiClose
} from "@mdi/js";

export default {
    props: {
        data: {
            type: Object,
            required: true
        },
        typeSection: {
            type: null,
            required: true
        }
    },
    data() {
        return {
            dialog: false,
            icons: {
                mdiAccount,
                mdiSchool,
                mdiCardAccountDetails,
                mdiChartBar,
                mdiFormatListNumbered,
                mdiAccountFileTextOutline,
                mdiClose
            },
            groupBy: [
                {
                    key: 'nom_eu',
                    order: 'asc',
                },
            ],
            headers: [
                { title: 'Matière', align: 'start', sortable: false, key: 'nom_matiere' },
                { title: 'Coefficient', align: 'center', key: 'coefficient' },
                { title: 'Vol. Hor.', align: 'center', key: 'volume_horaire_matiere' },
                { title: 'Note Devoir', align: 'center', key: 'note_origine_devoir' },
                { title: 'Note Examen', align: 'center', key: 'note_origine_examen' },
                { title: 'Moyenne', align: 'center', key: 'note_generale' },
                { title: 'Moyenne Coeff.', align: 'center', key: 'note_generale_coefficiente' },
            ],
        };
    },
    methods: {
        closeDialog() {
            this.$emit('close');
        }
    }
};
</script>