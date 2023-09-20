<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {
    router,
    useForm
} from "@inertiajs/vue3";
import {
    mdiAccountSchool,
    mdiEmailOutline,
    mdiCancel,
    mdiCheckCircle,
    mdiPlusCircle,
    mdiCloseCircle,
} from "@mdi/js";
export default {
    components: {
        mdiAccountSchool,
        mdiEmailOutline,
        mdiCancel,
        mdiCheckCircle,
        mdiPlusCircle,
        mdiCloseCircle,
    },
    props: ["filliere_etablissements"],
    layout: AuthenticatedLayout,
    data() {
        return {
            icon: {
                mdiAccountSchool,
                mdiEmailOutline,
                mdiCancel,
                mdiCheckCircle,
                mdiPlusCircle,
                mdiCloseCircle,
            },
            form: useForm({
                libelle: "",
                filiere_id: null,
                matieres: [],
            }),
            errors: {},
        };
    },
    methods: {
        goBack() {
            router.get(route("etablissements.index"));
            console.log();
        },
        addRow() {
            this.form.matieres.push({
                code: null,
                nom: null,
            });
        },
        removeRow(p) {
            this.form.matieres = this.form.matieres.filter(
                (product) => product !== p
            );
        },
        submit() {
            console.log(this.form);
            // this.form.post(route("ues.store"), {
            //     onFinish: () => this.form.reset(),
            // });
        },
    },
    mounted() {
        this.addRow()
    },
    created() {},
};
</script>

<template>
<div style="margin-top: 40px; max-width: 1300px; margin-left: 100px">
    <v-card>
        <page-toolbar :icon="icon.mdiAccountSchool">Nouvel UE</page-toolbar>

        <v-card-text>
            <v-form>
                <v-row>
                    <v-col md="5">
                        <text-field name="libelle" label="Nom de l'UE" placeholder="Nom de l'UE" :error-messages="errors.name" v-model="form.libelle"></text-field>
                    </v-col>
                    <v-col md="6">
                        <select-field label="Filières" item-title="filliere" item-value="id" :items="filliere_etablissements" v-model="form.filliere">
                        </select-field>
                    </v-col>
                </v-row>
                <!-- 
                    insert into etablissement_filliere (code,etablissement_id,filliere_id) values('FE1',1,2),
                    ('FE2',2,1);
                 -->
                <v-row>
                    <v-card-text>
                        <v-chip label variant="outlined" text-color="white" color="green" class="text-md-h6 green--text">Matières</v-chip>
                        <v-card outlined class="mb-md-2">
                            <v-card-text>
                                <v-row disabled :key="matiere.id" v-for="(matiere, i) in form.matieres">
                                    <v-col md="5">
                                        <text-field label="Code matière" placeholder="Code matière" v-model="matiere.code"></text-field>
                                    </v-col>
                                    <v-col md="6">
                                        <text-field label="Nom matière" placeholder="Nom matière" v-model="matiere.nom"></text-field>
                                    </v-col>
                                    <v-col md="1">
                                        <v-btn variant="outlined" :disabled="!(form.matieres.length > 1)" icon @click="removeRow(matiere)" fab small color="error">
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
                <br />
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn dark small type="button" variant="outlined" color="red" @click="goBack">
                        <v-icon :icon="icon.mdiCancel" left></v-icon>
                        Annuler
                    </v-btn>
                    <v-btn small color="success" variant="outlined" @click="submit">
                        <v-icon :icon="icon.mdiCheckCircle" left></v-icon>
                        Enregistrer
                    </v-btn>
                </v-card-actions>
            </v-form>
        </v-card-text>
    </v-card>
</div>
</template>
