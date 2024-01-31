<template>
<v-row>
    <v-col md="1"></v-col>
    <v-col md="3">
        <Autocomplete v-model="selectedClasse" :items="classes" item-title="code" item-value="id" @update:modelValue="requete(selectedClasse)" outlined required dense chips small-chips label="Classes"></Autocomplete>
    </v-col>
    <v-col md="3">
        <Autocomplete v-model="selectedEvaluation" :disabled="!selectedClasse" :items="evaluations " item-title="formatEvaluationLabel" item-value="id" outlined required dense chips small-chips label="Evaluations"></Autocomplete>
    </v-col>
    <v-col md="3" class="pt-5">
        <Button color="secondary" variant="outlined" class="mb-3" @click="rechercher()" nameButton="Recherche.." title="Rechercher..." style="height: 40px" :prependIcon="icon.mdiSearchWeb" :loading="form.processing" :disabled="!selectedClasse || !selectedEvaluation"></Button>
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
    mdiSearchWeb
} from '@mdi/js'
export default {
    components: {
        mdiSearchWeb
    },
    props: ["classes", "evaluations", "type"],
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
            // console.log(this.type)
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
            // console.log(console.log(this.type));
        },
    },
    created() {

    },
};
</script>
