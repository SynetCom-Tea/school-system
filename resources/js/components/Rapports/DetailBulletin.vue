<template>
    <v-dialog v-model="dialog" max-width="800">
        <v-card v-if="data != null">
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
        
    </v-dialog>
</template>

<script>
  export default {
    props: {
      data: {
        type: Object,
        required: true
      },
    },
    data() {
      return {
        dialog: false
      };
    },
    methods: {
        closeDialog() {
            this.$emit('close');
        }
    }
  };
  </script>