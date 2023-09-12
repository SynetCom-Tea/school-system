<script>
export default {
    props: {
        headers: {
            type: Array,
            required: true,
        },
        items: {
            type: Array,
            required: true,
        },
    },

    data() {
        return {
            searchQuery: '',
        }
    },
    methods: {

    },
    computed: {
        scopedSlots() {
            return this.$slots;
        },
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
            class="elevation-1 my-3 pt-3"
        >
            <template v-for="(index, name) in $slots" v-slot:[name]>
                <slot :name="name"></slot>
            </template>
            <template v-for="(index, name) of $slots" v-slot:[name]="data">
                <slot :name="name" v-bind="data"></slot>
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
