<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router, useForm } from "@inertiajs/vue3";
import {
    mdiPlus,
    mdiSchool,
    mdiPencil,
    mdiEye,
} from '@mdi/js'
export default {
    layout: AuthenticatedLayout,
    props: ["ecoles","instituts","universités"],
    
    data() {
        return {
            icon: {
                mdiPlus,
                mdiSchool,
                mdiPencil,
                mdiEye
            },
            tab: null,
            model: 'Activer',
            page: 1,
            itemsPerPage: 3,
            form: useForm({
                    type_etablissement_id: '',
                    section: [],
                }),
            dialog: false,
        }
    },
    methods: {
        goTo() {
            router.get(route('etablissements.create'))
        },
        editItem(item){
                console.log('edit',item)  
                this.form.id = item.id
                this.form.type_etablissement_id = item.type_etablissement_id
                item.sections.forEach((it) => {
                    this.form.section.push(
                        it.id,
                    )
            })
                this.dialog = true
            },
    },
    computed: {
      pageCount () {
        return Math.ceil(this.instituts.length / this.itemsPerPage)
      },
      ecolelenghtCount(){
        return Math.ceil(this.ecoles.length / this.itemsPerPage)
      },
      univlenghtCount(){
        return Math.ceil(this.universités.length / this.itemsPerPage)
      },
      ecoles(){
        return this.ecoles.slice((this.page -1)* this.itemsPerPage, this.page* this.itemsPerPage)
      },
      instituts(){
        return this.instituts.slice((this.page -1)* this.itemsPerPage, this.page* this.itemsPerPage)
      },
      universités(){
        return this.universités.slice((this.page -1)* this.itemsPerPage, this.page* this.itemsPerPage)
      },
    },
}
</script>
<template>
    <v-card>
        <page-toolbar :icon="icon.mdiSchool">Gestion des Etablissements</page-toolbar>
        <v-card-text>
            <v-btn variant="outlined" color="primary" :prepend-icon="icon.mdiPlus" @click="goTo()" elevation="4" rounded="lg">
                Ajouter
            </v-btn>
        </v-card-text>
        <v-tabs
            v-model="tab"
            color="primary"
            align-tabs="end"
            >
            <v-tab value="1">Ecoles</v-tab>
            <v-tab value="2">Instituts</v-tab>
            <v-tab value="3">Universités</v-tab>
        </v-tabs>
        <v-card-text>
            <v-window v-model="tab">
                <v-window-item value="1">
                <v-container>
                <v-row>
                    <v-col :key="i" v-for="(t, i) in ecoles">
                <v-card  elevation="6" width="300" style="border-color: blue;">
                            <v-img
                            style="object-fit: fill; width:300px; height:200px;"
                            :src="'../logos/' + t.logo"
                            class="text-white"
                            >
                            <v-toolbar
                                color="rgba(0, 0, 0, 0)"
                            >
                                <template v-slot:prepend>
                                <v-btn :icon="icon.mdiEye" @click="showItem(item.raw)"></v-btn>
                                </template>

                                <template v-slot:append>
                                <v-btn :icon="icon.mdiPencil" @click="editItem(item.raw)"></v-btn>
                                </template>
                            </v-toolbar>
                            </v-img>
                        
                            <P class="text-h4">{{t.name}} </P>
                                <v-switch
                                    v-model="model"
                                    color="primary"
                                    hide-details
                                    true-value="Désactiver"
                                    false-value="Activer"
                                    :label="`${model}`"
                                ></v-switch>
                            </v-card>
                    </v-col>
                            </v-row>
                            
                                
                            
                </v-container>
                <div style="align:center;">
                                    <v-pagination
                                    v-model="page"
                                    :length="ecolelenghtCount"
                                    :total-visible="6"
                                    :items-per-page="itemsPerPage"
                                    ></v-pagination>
                                </div>
                </v-window-item>

                <v-window-item value="2">
                    <v-container>
                        <v-row >
                        <v-col :key="i" v-for="(t, i) in instituts">
                        <v-card  elevation="6" width="300" style="border-color: red;">
                            <v-img
                            style="object-fit: fill; width:300px; height:200px;"
                            :src="'../logos/' + t.logo"
                            class="text-white"
                            >
                            <v-toolbar
                                color="rgba(0, 0, 0, 0)"
                            >
                                <template v-slot:prepend>
                                <v-btn :icon="icon.mdiEye" @click="showItem(item.raw)"></v-btn>
                                </template>

                                <template v-slot:append>
                                <v-btn :icon="icon.mdiPencil" @click="editItem(item.raw)"></v-btn>
                                </template>
                            </v-toolbar>
                            </v-img>
                        
                            <P class="text-h4">{{t.name}} </P>
                                <v-switch
                                    v-model="model"
                                    color="primary"
                                    hide-details
                                    true-value="Désactiver"
                                    false-value="Activer"
                                    :label="`${model}`"
                                ></v-switch>
                            </v-card>
                             </v-col>
                            </v-row>  
                </v-container>
                <div class="text-center pt-2">
                                    <v-pagination
                                    v-model="page"
                                    :length="pageCount"
                                    :total-visible="6"
                                    :items-per-page="itemsPerPage"
                                    ></v-pagination>
                                </div>
                </v-window-item>

                <v-window-item value="3">
                    <v-container>
                <v-row>
                <v-col :key="i" v-for="(t, i) in universités">
                <v-card  elevation="6" width="300">
                            <v-img
                            style="object-fit: fill; width:300px; height:200px;"
                            :src="'../logos/' + t.logo"
                            class="text-white"
                            >
                            <v-toolbar
                                color="rgba(0, 0, 0, 0)"
                            >
                                <template v-slot:prepend>
                                <v-btn :icon="icon.mdiEye" @click="showItem(item.raw)"></v-btn>
                                </template>

                                <template v-slot:append>
                                <v-btn :icon="icon.mdiPencil" @click="editItem(item.raw)"></v-btn>
                                </template>
                            </v-toolbar>
                            </v-img>
                        
                            <P class="text-h4">{{t.name}} </P>
                                <v-switch
                                    v-model="model"
                                    color="primary"
                                    hide-details
                                    true-value="Désactiver"
                                    false-value="Activer"
                                    :label="`${model}`"
                                ></v-switch>
                            </v-card>
                </v-col>
                            </v-row>
                            
                                
                            
                </v-container>
                <div style="align:center;">
                                    <v-pagination
                                    v-model="page"
                                    :items-per-page="itemsPerPage"
                                    :length="univlenghtCount"
                                    :total-visible="6"
                                    ></v-pagination>
                                </div>
                </v-window-item>
            </v-window>
        </v-card-text>
    </v-card>
</template>
