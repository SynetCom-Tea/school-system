<template>
<v-row>
    <v-col md="1"></v-col>
    <v-col md="4">
        <Autocomplete v-model="selectedClasse" :items="classes" item-title="libelle" item-value="id" @update:modelValue="requete(selectedClasse)" outlined required dense chips small-chips label="Classes"></Autocomplete>
    </v-col>
    <v-col md="4" v-if="$page.props.evaluations != null">
        <Autocomplete v-model="selectedEvaluation"  :items="$page.props.evaluations ? $page.props.evaluations : null" :item-title="formatEvaluationLabel" item-value="id" outlined required dense chips small-chips label="Evaluations"></Autocomplete>
    </v-col>
    <v-col md="3" >
        <Button  color="secondary" variant="outlined" class="mb-3" @click="rechercher()"  nameButton="Recherche.." title="Rechercher..." style="height: 40px" :prependIcon="icon.mdiSearchWeb" :loading="form.processing" :disabled="!selectedClasse || !selectedEvaluation"></Button>
     </v-col>
    <v-col md="2"></v-col>
</v-row>
</template>

<script>
import {
    router,
    usePage,
    useForm
} from "@inertiajs/vue3";
import {
    provide
} from 'vue';
import {
    mdiSearchWeb
} from '@mdi/js'
export default {
    components: {
        mdiSearchWeb
    },
    props: ["classes","evaluations"],
    data() {
        return {
            icon: {
                mdiSearchWeb
            },
            selectedClasse: null,
            selectedTypeExamen: null,
            selectedEvaluation: null,
            selectedMatiere: null,
            form: useForm({
                classe: "",
                prenom: "",
                tel: "",
                sex: "",
                roles: "",
            }),
        };
    },

    methods: {
        formatEvaluationLabel(item) {
            if (item.enseignement_annee.niveau_matiere) {
                // Concatenate the relevant properties for the label
                // console.log(item.type_evaluation.libelle)
                return `${item ? item?.type_evaluation?.libelle : 'Pas de données'} - ${item ? item?.enseignement_annee?.niveau_matiere?.matiere?.nom : ''}`;
            }else{
                 return `${item ? item?.type_evaluation?.libelle : 'Pas de données'} - ${item ? item?.enseignement_annee?.filiere_niveau_matiere_ue?.matiere?.nom : ''}`;
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
        requete(id) {
            this.selectedEvaluation = null
            router.replace(this.$page.url, {
                data: {
                    classe: id
                }
            });
            // console.log('id',id)   
        },
        goBack() {
            router.get(route("users.index"));
            console.log();
        },
        submit() {
            // console.log(this.form)
            this.form.post(route("users.store"), {
                onFinish: () => this.form.reset(),
            });
        },
        onChange() {
            // console.log("Picture changed!");
        },
    },
    created() {

    },
};
</script>
