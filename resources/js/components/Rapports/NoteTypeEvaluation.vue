<template>
    <Datatable 
        :displayAddButton="false" 
        :titleDatatable="typeEvaluation" 
        :headers="headers" 
        :items="data" 
        item-key="nom_apprenant"
        >
        <template v-for="header in headers" v-slot:[`item.${header.key}`]="{ item }">
            <template v-if="header.key !== 'nom_apprenant' && header.key !== 'moyenne' && header.key !== 'action'">
            <td>{{ item[header.key] }}</td>
            </template>
            <template v-else>
            <td @click="openBulletinDialog(item)">{{ item.nom_apprenant + ' ' + item.prenom_apprenant }}</td>
            </template>
        </template>
    </Datatable>
</template>

<script>
  export default {
    props: {
      data: {
        type: Object,
        required: true
      },
      headers: {
        type: Object,
        required: true
      },
      typeEvaluation: {
        type: String,
        required: true
      }
    },
    data() {
      return {
        dialog: false
      };
    },
    methods: {
        openBulletinDialog(item) {
            this.$emit('open', item);
        }
    }
  };
  </script>