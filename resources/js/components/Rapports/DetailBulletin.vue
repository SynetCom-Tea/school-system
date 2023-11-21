<template>
    <v-dialog v-model="dialog" max-width="1200">
        <v-card v-if="data != null && typeSection == 1">
            <v-card-subtitle
                class="mx-auto"
                max-width="425"
            >
                <v-list lines="two">
                <v-list-subheader>{{ 'Classe: ' + data.nom_classe }}</v-list-subheader>

                <v-list-item
                    :title="'Matricule: '+data.matricule_apprenant"
                >
                    <template v-slot:subtitle>
                    <span class="font-weight-bold">{{ 'Nom & Prénom: ' +  data.nom_apprenant + ' ' + data.prenom_apprenant }}</span> &mdash; Moyenne: {{ data.moyenne }}
                    </template>
                </v-list-item>

                <v-divider inset></v-divider>
                </v-list>
            </v-card-subtitle>
            <v-card-text>
                <v-table density="compact">
                    <thead>
                    <tr>
                        <th class="text-left">
                        Matière
                        </th>
                        <th class="text-left">
                        Notation
                        </th>
                        <th class="text-left">
                        Note
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="item in data.details_notes"
                        :key="item.nom_matiere"
                    >
                        <td>{{ item.nom_matiere }}</td>
                        <td>{{ item.notation_matiere }}</td>
                        <td>{{ item.note }}</td>
                    </tr>
                    </tbody>
                </v-table>
            </v-card-text>
            <v-card-actions>
                <v-btn color="blue darken-1" text @click="closeDialog">Fermer</v-btn>
            </v-card-actions>
        </v-card>
        <v-card v-if="data != null">
            <v-card-subtitle
                v-if="typeSection == 2 || typeSection == 3"
                class="mx-auto"
                max-width="425"
            >
                <v-list lines="two">
                <v-list-subheader>{{data.periode +' ' +  'Classe: ' + data.nom_classe }}</v-list-subheader>

                <v-list-item
                    :title="'Matricule: '+data.matricule_apprenant"
                >
                    <template v-slot:subtitle>
                    <span class="font-weight-bold">{{ 'Nom & Prénom: ' +  data.nom_prenom_apprenant }}</span> &mdash; Moyenne: {{ data.moyenne_details_notes }} - Rang {{ data.rang }}
                    </template>
                </v-list-item>

                <v-divider inset></v-divider>
                </v-list>
            </v-card-subtitle>
            <v-card-text>
                <v-table density="compact" v-if="typeSection == 2">
                    <thead>
                    <tr>
                        <th class="text-left">
                        Matière
                        </th>
                        <th class="text-left">
                        Coefficient
                        </th>
                        <th class="text-left">
                        Note de classe
                        </th>
                        <th class="text-left">
                        Note de classe coefficienté
                        </th>
                        <th class="text-left">
                        Note de composition
                        </th>
                        <th class="text-left">
                        Note de composition coefficienté
                        </th>
                        <th class="text-left">
                            Moyenne
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="item in data.details_notes"
                        :key="item.nom_matiere"
                    >
                        <td>{{ item.nom_matiere }}</td>
                        <td>{{ item.coefficient }}</td>
                        <td>{{ item.noteDeClasse }}</td>
                        <td>{{ item.noteDeClasseCoefficiente }}</td>
                        <td>{{ item.noteDeComposition }}</td>
                        <td>{{ item.noteDeCompositionCoefficiente }}</td>
                        <td>{{ item.moyenne }}</td>
                    </tr>
                    </tbody>
                </v-table>
                <v-table density="compact" v-if="typeSection == 4">
                    <thead>
                    <tr>
                        <th class="text-left">
                        Matière
                        </th>
                        <th class="text-left">
                        UE
                        </th>
                        <th class="text-left">
                        Coefficient
                        </th>
                        <th class="text-left">
                        Volume Horaire
                        </th>
                        <th class="text-left">
                            Note de devoir
                        </th>
                        <th class="text-left">
                            Note d'examen
                        </th>
                        <th class="text-left">
                        Note
                        </th>
                        <th class="text-left">
                        Note coefficienté
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="item in data.historique_notes"
                        :key="item.nom_matiere"
                    >
                        <td>{{ item.nom_matiere }}</td>
                        <td>{{ item.nom_eu }}</td>
                        <td>{{ item.coefficient }}</td>
                        <td>{{ item.volume_horaire_matiere }}</td>
                        <td>{{ item.note_origine_devoir }}</td>
                        <td>{{ item.note_origine_examen }}</td>
                        <td>{{ item.note_generale }}</td>
                        <td>{{ item.note_generale_coefficiente }}</td>
                    </tr>
                    </tbody>
                </v-table>
                <v-data-table
                    v-if="typeSection == 3"
                    :headers="headers"
                    :items="data.historique_notes"
                    :group-by="groupBy"
                    item-value="name"
                >
                    <template v-slot:group-header="{ item, columns, toggleGroup, isGroupOpen }">
                    <tr>
                        <td :colspan="columns.length">
                        <VBtn
                            size="small"
                            variant="text"
                            :icon="isGroupOpen(item) ? '$expand' : '$next'"
                            @click="toggleGroup(item)"
                        ></VBtn>
                        {{ item.value }}
                        </td>
                    </tr>
                    </template>
                </v-data-table>
            </v-card-text>
            <v-card-actions>
                <v-btn color="blue darken-1" text @click="closeDialog">Fermer</v-btn>
            </v-card-actions>
        </v-card>
        
    </v-dialog>
</template>

<script>
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
        groupBy: [
          {
            key: 'nom_eu',
            order: 'asc',
          },
        ],
        headers: [
          {
            title: 'Matière',
            align: 'start',
            sortable: false,
            key: 'nom_matiere',
          },
          { title: 'Coefficient', key: 'coefficient' },
          { title: 'Volume Horaire', key: 'volume_horaire_matiere' },
          { title: 'Note de devoir', key: 'note_origine_devoir' },
          { title: 'Note d\'examen', key: 'note_origine_examen' },
          { title: 'Moyenne', key: 'note_generale' },
          { title: 'Moyenne coefficienté', key: 'note_generale_coefficiente' },
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