<template>
<AuthenticatedLayout>
    <Toolbar :icon="icon.mdiAccountPlusOutline" toolbarTitle="Gestion des notes"></Toolbar>
    <br>
    <div style="margin: 20px">
        <Button class="mb-2" style="height: 40px" nameButton="Ajouter" title="Valider et Fermer la modale" small color="primary" variant="outlined" :prependIcon="icon.mdiPlus" @click="create">
        </Button>
    </div>
    <v-card variant="outlined" style="border: 2px solid #7d002c;margin: 20px">
        <v-card-title style="color: white; background-color: #7d002c">Choisissez les criteres</v-card-title>
        <v-divider></v-divider>
        <br />
        <v-row>
            <v-col md="1"></v-col>
            <v-col md="2" >
                    <Autocomplete  v-model="form.annee" :items="annees" item-title="libelle" item-value="id"  outlined required dense chips small-chips label="Années academiques" @update:modelValue="setClasse(form.annee)"></Autocomplete>
                </v-col>
            <v-col md="3">
                <Autocomplete v-model="form.classe" :items="classes" :item-title="formatClasseLabel" item-value="id" @update:modelValue="requete(form.classe)" outlined required dense chips small-chips label="Classes"></Autocomplete>
            </v-col>
            <v-col md="3">
                <Autocomplete v-model="form.evaluation" :disabled="!form.classe" :items="evaluations " :item-title="formatEvaluationLabel" item-value="id" outlined required dense chips small-chips label="Evaluations"></Autocomplete>
            </v-col>
            <v-col md="3">
                <Button color="secondary" variant="outlined" class="mb-3" @click="rechercher()" nameButton="Recherche.." title="Rechercher..." style="height: 40px" :prependIcon="icon.mdiSearchWeb" :loading="form.processing" :disabled="!form.classe || !form.evaluation"></Button>
            </v-col>
            <v-col md="2"></v-col>
        </v-row>
    </v-card>

</AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {
    Head,
    router,
    useForm
} from "@inertiajs/vue3";
import {
    mdiPlus,
    mdiPencil,
    mdiDelete,
    mdiCloseCircle,
} from '@mdi/js'
export default {
    components: {
        mdiPlus,
        mdiPencil,
        mdiDelete,
        mdiCloseCircle,
    },
    layout: AuthenticatedLayout,
    props: ['classes', 'evaluations', 'notes','annees', 'type'],
    data() {
        return {
            icon: {
                mdiPlus,
                mdiPencil,
                mdiDelete,
                mdiCloseCircle,
            },
            dialogEdit: false,
            headers: [{
                    title: '#',
                    align: 'start',
                    key: 'apprenant.matricule',
                    sortable: false,
                },
                {
                    title: "Nom",
                    align: "center",
                    key: "apprenant"
                },
                {
                    title: "Note",
                    align: "center",
                    key: "note"
                },
                {
                    title: "Action",
                    align: "center",
                    key: "action"
                },
            ],
            rules: {
                required: v => !!v || "Veuillez renseigner la note",
                validator: v => !(Math.sign(v) == -1) || "La note doit être positif",
                max: v => v <= 20 || "La note ne doit pas dépasser 20"
            },
            format: useForm({
                section_id: null,
            }),
            form: useForm({
                section_id: null,
                type_matiere: null,
                nom_prenom: null,
                id_note: null,
                note: null,
                annee : null,
                classe : null,
                evaluation : null
            }),

        }
    },
    methods: {
        create() {
            this.format.section_id = this.type
            this.format.get(route('note.attribution_admin'))
        },
        formatEvaluationLabel(item) {
            if (item.enseignement_annee.niveau_matiere) {
                return `${item ? item?.type_evaluation?.libelle : 'Pas de données'} - ${item ? item?.enseignement_annee?.niveau_matiere?.matiere?.nom : ''}`;
            } else {
                return `${item ? item?.type_evaluation?.libelle : 'Pas de données'} - ${item ? item?.enseignement_annee?.filiere_niveau_matiere_ue?.matiere?.nom : ''}`;
            }
        },
        formatClasseLabel(item){
            if (this.type >= 3) {
                return `${item ? item?.cycle_filiere.filiere.code : 'Pas de données'} - ${item ? item.niveau.code : 'Pas de données'} - ${item ? item.libelle : 'Pas de données'}`
            }
            else{
                return `${item ? item?.libelle : 'Pas de données'}`
            }
        },
        rechercher() {
            router.replace(this.$page.url, {
                data: {
                    classe: this.selectedClasse,
                    evaluation: this.selectedEvaluation
                }
            });
            // console.log('je suis la',this.selectedClasse,this.selectedEvaluation)
        },
        setClasse(a) {
            // console.log(this.form)
            router.replace(this.$page.url, {
                data: {
                    annee: a,
                }
            });
        },
        requete(id) {
            // console.log(this.type)
            this.selectedEvaluation = null
            router.replace(this.$page.url, {
                data: {
                    classe: id
                }
            });
            // console.log('id',id)   
        },
    }
}
</script>
