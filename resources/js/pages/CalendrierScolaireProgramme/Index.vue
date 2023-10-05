<script>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { router } from '@inertiajs/vue3';
    
    import {
        mdiBookOpenVariant,
        mdiPencil,
        mdiDelete
    } from '@mdi/js'
    export default {
        components: {
        },
        layout: AuthenticatedLayout,
        props: ["programmes", "section_id"],
        data() {
            return {
                icons: {
                    mdiBookOpenVariant,
                    mdiPencil,
                    mdiDelete
                },
                headers: [
                    {
                        title: 'Code',
                        align: 'start',
                        sortable: false,
                        key: 'code',
                    },
                    { title: 'Libellé', align: 'center', key: 'nom' },
                    {title: 'Actions', align: 'center', key: 'actions'},
                ],
            }
        },
        methods:{
            create() {
                let type = this.section_id;  // Assurez-vous que this.type contient la valeur que vous souhaitez

                // Construire l'URL en concaténant le type
                let url = `/calendrierscolaire/${type}/create`;

                // Utilisez 'url' comme vous le souhaitez, par exemple, dans votre router
                router.get(url);
            },
            editItem(item){
                
            },
            deleteItem(item){
                
            },
        }
    }
</script>
<template>
    <v-card>
    <Toolbar
      styleToolbar="background-color: white;"
      :icon="icons.mdiBookOpenVariant"
      toolbarTitle="Calendrier Scolaire"
    ></Toolbar>
        <v-card-text>
            <Datatable titleDatatable="Liste des programmes" :headers="headers" :items="programmes" :functionOnClickAddButton="create" >
            
            <template v-slot:item.actions="{item}">
                <v-icon size="small" class="me-2" title="Modifier" @click="editItem(item.raw)" :icon="icons.mdiPencil" color="orange">
                </v-icon>
                <v-icon size="small" class="me-2" title="Supprimer" @click="deleteItem(item.raw)" :icon="icons.mdiDelete" color="red">
                </v-icon>
            </template>
        </Datatable>
        </v-card-text>
    </v-card>
</template>
<style>

</style>