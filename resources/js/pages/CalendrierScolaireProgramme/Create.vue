<script>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { router, useForm } from '@inertiajs/vue3';
    
    import {
        mdiBookOpenVariant,
        mdiPencil,
        mdiDelete,
        mdiCloseCircle,
        mdiPlusCircle, 
        mdiInformation,
        mdiCancel,
        mdiCheckCircle
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
                    mdiDelete,
                    mdiPlusCircle, mdiCloseCircle, mdiInformation, mdiCancel, mdiCheckCircle
                },
                form: useForm({
                    date: null,
                    programmes: [],
                }),
            }
        },
        methods:{
            addRow() {
                this.form.programmes.push({
                    code: null,
                    libelle: null,
                    before: null,
                    after: null,
                });
            },
            removeRow(id) {
                this.form.programmes = this.form.programmes.filter((el) => el !== id);
            },
            goBack(){

            },
            submit(){
                console.log(this.form);
                let type = this.section_id;  // Assurez-vous que this.type contient la valeur que vous souhaitez

                // Construire l'URL en concaténant le type
                let url = `/calendrierscolaire/${type}`;
                this.form.post(url, {
                    // onFinish: () => this.form.reset(),
                    onError: (error) => {
                    // Logique à exécuter en cas d'erreur
                    this.$swal(
                        "Oops...",
                        `<ul> <li v-for"${name} in ${error}"> ${name} </li> </ul>`,
                        "error"
                    );
                    // console.log('Erreur de requête');
                    console.log(error);
                    },
                });
            }
            // handleDate() {
            //     let vh = document.getElementById("heit");
            //     vh.style.height = "auto";
            //     return vh;
            // },
            // handleFocusDate() {
            //     let vh = document.getElementById("heit");
            //     return (vh.style.height = "1000px");
            // },
        },
        mounted() {
            this.addRow();
        },
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
            <form novalidate @submit.prevent="submitForm">
                <v-container fluid>
                    <v-card variant="outlined" style="border: 2px solid #7d002c">
                        <v-card-title style="color: white; background-color: #7d002c"
                        >Programmes</v-card-title
                        >
                        <v-divider></v-divider>
                        <br />
                        <div style="margin: 10px">
                            
                        </div>
                        <v-card-text style="margin: 10px">
                            <v-row dense :key="programme.id" v-for="(programme, i) in form.programmes">
                                <v-col md="3">
                                    <date-range-picker
                                    v-model="programme.date"
                                    locale="fr"
                                    cancelText="Annuler"
                                    selectText="Confirme"
                                    :only-date="true"
                                    date-picker
                                    class="mt-4"
                                    :min-date="new Date()"
                                    placeholder="programme du ..."
                                    >
                                    </date-range-picker>
                                </v-col>
                                <v-col md="2">
                                    <autocomplete
                                    class="mt-4"
                                        dense
                                        label="Type activité"
                                        placeholder="Type activité"
                                        :items="['Activités parascolaire','Activités extrascolaires']"
                                        v-model="programme.type"
                                    >
                                    </autocomplete>
                                </v-col>
                                <v-col md="3">
                                <TextField
                                    class="mt-4"
                                    label="Activité"
                                    :isRequired="true"
                                    placeholder="Activité"
                                    v-model="programme.activite"
                                ></TextField>
                                </v-col>
                                <v-col md="3">
                                <Textarea
                                    class="mt-4"
                                    label="Description"
                                    :isRequired="true"
                                    placeholder="Description"
                                    v-model="programme.description"
                                ></Textarea>
                                </v-col>
                                <v-col md="1">

                                <Button
                                    class="mt-4"
                                    type="button"
                                    variant="outlined"
                                    :disabled="!(form.programmes.length > 1)"
                                    icon
                                    @click="removeRow(programme)"
                                    size="large"
                                    small
                                    title="Supprimer la ligne"
                                    color="error"
                                >
                                    <v-icon :icon="icons.mdiCloseCircle"></v-icon>
                                </Button>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col offset-md="11" md="1">
                                <Button
                                    type="button"
                                    variant="outlined"
                                    @click="addRow"
                                    title="Ajouter une nouvelle ligne"
                                    icon
                                    size="large"
                                    color="primary"
                                >
                                    <v-icon :icon="icons.mdiPlusCircle" small></v-icon>
                                </Button>
                                </v-col>
                            </v-row>
                        </v-card-text>
                        <v-card-actions class="justify-end">
                            <v-spacer></v-spacer>
                            <v-btn dark small type="button" color="red" @click="goBack">
                                <v-icon :icon="icons.mdiCancel" left></v-icon> Annuler
                            </v-btn>
                            <v-btn small color="primary" @click="submit">
                                <v-icon :icon="icons.mdiCheckCircle" left></v-icon> Enregistrer
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-container>
            </form>
        </v-card-text>
    </v-card>
</template>
<style>

</style>