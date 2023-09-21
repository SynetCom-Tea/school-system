<script>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { router, useForm } from '@inertiajs/vue3';
    import {
        mdiAccountSchool,
        mdiEmailOutline,
        mdiCancel,
        mdiCheckCircle,
        mdiPlusCircle,
        mdiCloseCircle
    } from '@mdi/js'
    export default{
        components: {
            mdiAccountSchool,
            mdiEmailOutline,
            mdiCancel,
            mdiCheckCircle,
            mdiPlusCircle,
            mdiCloseCircle
        },
        props: ["types", "fillieres", "etablissement"],
        layout: AuthenticatedLayout,
        data() {
            return {
                icon: {
                    mdiAccountSchool,
                    mdiEmailOutline,
                    mdiCancel,
                    mdiCheckCircle,
                    mdiPlusCircle,
                    mdiCloseCircle
                },
                form: useForm({
                    name: '',
                    adresse: '',
                    mail: '',
                    telephone: ['', '', ''],
                    type_etablissement_id: '',
                    pays: '',
                    ville: '',
                    facultes: [],
                    filliere: []
                }),
            }
        },
        methods: {
            goBack(){
                router.get(route('etablissements.index'))
                console.log()
            },
            addRow() {
                this.form.facultes.push({code: null, name: null, before: null, after: null})
            },
            removeRow(p) {
                this.form.facultes = this.form.facultes.filter((product) => product !== p)
            },
            async verify(p) {
                const array = this.form.facultes.filter(el => el.code !== null && el.code == p.code )

                if(array.length > 1) {
                    this.removeRow(p)
                    this.$alert.error("L'élément existe déjà !");
                }
            },
            submit(){
                // console.log(this.form)
                this.form.put(route('etablissements.update', this.form.id), {
                    onFinish: () => this.form.reset(),
                });
            },
        },
        mounted() {
            // this.addRow()
        },
        created() {
            const etablissement = this.etablissement
            this.form.id = etablissement.id
            this.form.name = etablissement.name
            this.form.adresse = etablissement.adresse
            this.form.mail = etablissement.mail
            this.form.telephone = etablissement.telephone
            this.form.type_etablissement_id = etablissement.type_etablissement_id
            this.form.pays = etablissement.pays
            this.form.ville = etablissement.ville
            this.form.filliere = etablissement.fillieres
            if(!this.form.facultes.length) {
                etablissement.facultes.forEach((item) => {
                    this.form.facultes.push({
                        code: item.code,
                        name: item.name,
                        filliere: item.fillieres,
                        item: {...item},
                    })
                })
            }
        }
    }
</script>
<template>
    <v-card>
        <page-toolbar :icon="icon.mdiAccountSchool">Modifier etablissement</page-toolbar>
        <v-card-text>
            <v-form>
                <v-row>
                    <v-col md="4">
                        <select-field
                            label="Type"
                            :items="types"
                            item-title="name"
                            item-value="id"
                            v-model="form.type_etablissement_id">    
                        </select-field>
                        <text-field
                            name="name"
                            label="Nom etablissement"
                            placeholder="Nom etablissement"
                            v-model="form.name"
                        ></text-field>
                        <text-field
                            name="adresse"
                            label="Adresse"
                            placeholder="Adresse"
                            v-model="form.adresse"
                        ></text-field>
                    </v-col>
                    <v-col md="4">
                        <text-field
                            name="mail"
                            label="Mail"
                            placeholder="Mail"
                            v-model="form.mail"
                        ></text-field>
                        <text-field
                            name="pays"
                            label="Pays"
                            placeholder="Pays"
                            v-model="form.pays"
                        ></text-field>
                        <text-field
                            name="ville"
                            label="Ville"
                            placeholder="Ville"
                            v-model="form.ville"
                        ></text-field>
                    </v-col>
                    <v-col md="4">
                        <text-field
                            name="tel1"
                            label="Téléphone 1"
                            placeholder="Téléphone 1"
                            v-model="form.telephone[0]"
                        ></text-field>
                        <text-field
                            name="tel2"
                            label="Téléphone 2"
                            placeholder="Téléphone 2"
                            v-model="form.telephone[1]"
                        ></text-field>
                        <text-field
                            name="tel3"
                            label="Téléphone 3"
                            placeholder="Téléphone 3"
                            v-model="form.telephone[2]"
                        ></text-field>
                    </v-col>
                </v-row>
                <select-field v-if="form.type_etablissement_id != 1" label="Filières" item-title="name" item-value="id" :items="fillieres" multiple chips v-model="form.filliere">
                </select-field>
                <v-row v-if="form.type_etablissement_id == 1">
                    <v-card-text>
                        <v-chip label variant="outlined" text-color="white" color="green" class="text-md-h6 green--text">Faculté</v-chip>
                        <v-card outlined class="mb-md-2">
                            <v-card-text>
                                <v-row disabled :key="faculte.id" v-for="(faculte, i) in form.facultes">
                                    <v-col md="2">
                                        <text-field
                                            label="Code faculté"
                                            placeholder="Code faculté"
                                            v-model="faculte.code"
                                        ></text-field>
                                    </v-col>
                                    <v-col md="3">
                                        <text-field
                                            label="Libelle faculté"
                                            placeholder="Libelle faculté"
                                            v-model="faculte.name"
                                        ></text-field>
                                    </v-col>
                                    <v-col md="6">
                                        <select-field label="Filières" item-title="name" item-value="id" :items="fillieres" multiple chips v-model="faculte.filliere">
                                        </select-field>
                                    </v-col>
                                    <v-col md="1">
                                        <v-btn variant="outlined" :disabled="!(form.facultes.length > 1)" icon @click="removeRow(faculte)" fab small color="error">
                                            <v-icon :icon="icon.mdiCloseCircle"></v-icon>
                                        </v-btn>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col offset-md="11" md="1">
                                        <v-btn variant="outlined" icon @click="addRow" fab small color="green">
                                            <v-icon :icon="icon.mdiPlusCircle"></v-icon>
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </v-card>
                    </v-card-text>
                </v-row>
                <br>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        dark
                        small
                        type="button"
                        color="red"
                        @click="goBack"
                    ><v-icon :icon="icon.mdiCancel" left></v-icon> Annuler</v-btn>
                    <v-btn
                        small
                        color="success"
                        @click="submit"
                    ><v-icon :icon="icon.mdiCheckCircle" left></v-icon> Enregistrer</v-btn>
                </v-card-actions>
            </v-form>
        </v-card-text>
    </v-card>
</template>