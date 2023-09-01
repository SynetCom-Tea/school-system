<script>
export default {
    props: ["items","headers"],

    data() {
        return {
            searchQuery: '',
            rules:{
                required: v => !!v || "Veuillez renseigner la note",
                validator: v=> !(Math.sign(v) == -1) ||  "La note doit être positif",
                max: v=> v <= 20 ||  "La note ne doit pas dépasser 20"
            },
        }
    },
}
</script>

<template>
    <div>
        <v-row>
            <v-col md="6">
                <text-field
                    label="Recherche"
                    placeholder="Recherche..."
                    v-model="searchQuery"
                ></text-field>
            </v-col>
            <v-spacer></v-spacer>
            <v-col md="3">
                <slot name="addBtn"></slot>
            </v-col>
        </v-row>
        <v-data-table
            :headers="headers"
            :items="items"
            :search="searchQuery"
            item-key="id"
            class="elevation-1 my-3 pt-3"
        >
            <template v-slot:item.note="{ item }">
                <v-text-field
                    v-model="item.note"
                    outlined
                    dense
                    :rules="[rules.required, rules.validator, rules.max]"
                    style="max-width: 500px"
                ></v-text-field>
            </template>
        </v-data-table>
    </div>
</template>

<style scoped>
.elevation-1 {
    border: 1px solid orange;
    border-radius: 4px;
}

.custom-table-header {
    background-color: #24bb68;
}

.custom-table-header-cell {
    font-weight: bold;
    padding: 12px;
    text-align: left;
}

.custom-table-cell {
    padding: 12px;
}
</style>
