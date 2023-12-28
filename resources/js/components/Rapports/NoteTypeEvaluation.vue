<template>
<Datatable :displayAddButton="false" :titleDatatable="typeEvaluation" :headers="headers" :items="data" item-key="nom_apprenant">
    <template v-for="header in headers" v-slot:[`item.${header.key}`]="{ item }">
        <template v-if="header.key !== 'nom_apprenant' && header.key !== 'moyenne' && header.key !== 'action'">
            <v-chip :color="getColor(item[header.key])">
                {{ item[header.key] }}
            </v-chip>
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
        },
        getColor(note) {
            if (note < 10) return 'red'
            else if (note < 15) return 'orange'
            else return 'green'
        },
    }
};
</script>
