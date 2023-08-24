<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {
    router,
    useForm
} from '@inertiajs/vue3';
import {
    mdiAccountSchool,
    mdiEmailOutline,
    mdiCancel,
    mdiCheckCircle,
    mdiPlusCircle,
    mdiCloseCircle,
    mdiReceiptTextSendOutline,
} from '@mdi/js'
export default {
    components: {
        mdiAccountSchool,
        mdiEmailOutline,
        mdiCancel,
        mdiCheckCircle,
        mdiPlusCircle,
        mdiCloseCircle,
        mdiReceiptTextSendOutline,
    },
    props: ["annees", "classes"],
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
                mdiReceiptTextSendOutline,
            },
            form: useForm({
                date_debut: '',
                date_fin: '',
                annee_id: '',
                classes: [],
            }),
            today: new Date().toISOString().slice(0,10),
        }
    },
    methods: {
        goBack() {
            router.get(route('promotions.index'))
            console.log()
        },
        async submit() {
            const { valid } = await this.$refs.form.validate()
            if(valid){
            this.form.post(route('promotions.store'), {
                onFinish: () => this.form.reset(),
                onError: (error) => {
                    // Logique à exécuter en cas d'erreur
                    this.$swal(
                        'Oops...',
                        `<ul> <li v-for"${(name)} in ${error}"> ${name} </li> </ul>`,
                        'error'
                    )
                    // console.log('Erreur de requête');
                    console.log(error);
                }
            });
            }
        },
    },
}
</script>

<template>
<v-card>
    <page-toolbar :icon="icon.mdiReceiptTextSendOutline">Nouvelle Promotion</page-toolbar>
    <v-card-text>
        <v-form ref="form">
            <v-row>
                <v-col md="4">
                    <select-field label="Année" :items="annees" item-title="annee" item-value="id" v-model="form.annee_id" isRequired :rules="[v => !!v || 'Ce champ est requis!']">
                    </select-field>
                </v-col>
                 <v-col md="4">
                    <text-field type="date" name="date_debut" label="Date début" v-model="form.date_debut" isRequired :rules="[v => !!v || 'Ce champ est requis!']" ></text-field>
                </v-col>
                <v-col md="4">
                    <text-field type="date" name="date_fin" label="Date fin" v-model="form.date_fin" :min="form.date_debut"></text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col md="12">
                    <select-field label="Classes" item-title="libele" item-value="id" :items="classes" multiple chips v-model="form.classes" isRequired :rules="[v => v.length>0 || 'Ce champ est requis!']">
                    </select-field>
                </v-col>
            </v-row>
            <br>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn dark small type="button" color="red" @click="goBack">
                    <v-icon :icon="icon.mdiCancel" left></v-icon> Annuler
                </v-btn>
                <v-btn small color="success" @click="submit">
                    <v-icon :icon="icon.mdiCheckCircle" left></v-icon> Enregistrer
                </v-btn>
            </v-card-actions>
        </v-form>
    </v-card-text>
</v-card>
</template>
