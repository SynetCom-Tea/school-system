<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {
    Form
} from 'vee-validate';
import {
    router,
    usePage,
    useForm
} from '@inertiajs/vue3';
import {
    mdiAccountPlusOutline,
    mdiEmailOutline,
    mdiCancel,
    mdiCheckCircle
} from '@mdi/js'
export default {
    components: {
        mdiAccountPlusOutline,
        mdiEmailOutline,
        mdiCancel,
        mdiCheckCircle
    },
    layout: AuthenticatedLayout,
    props:['roles','etablissements'],
    data() {
        return {
            icon: {
                mdiAccountPlusOutline,
                mdiEmailOutline,
                mdiCancel,
                mdiCheckCircle
            },
            form: useForm({
                nom: '',
                prenom: '',
                tel: '',
                sex: '',
                roles: '',
            }),
        }
    },
    methods: {
        goBack() {
            router.get(route('users.index'))
        },
        submit() {
            this.form.post(route('users.store'), {
                onFinish: () => this.form.reset(),
            });
        },
        
    },
}
</script>
<template>
<v-card>
    <page-toolbar :icon="icon.mdiAccountPlusOutline">Nouvel utilisateur</page-toolbar>
    <v-card-text>
        <v-form>
            <v-row>
                <v-col md="6">
                    <TextField name="nom" label="Nom" placeholder="Nom" v-model="form.nom"></TextField>
                    <TextField name="prenom" label="Prenom" placeholder="Prenom" v-model="form.prenom"></TextField>
                    <TextField name="tel" label="Téléphone" placeholder="Téléphone" v-model="form.tel"></TextField>
                </v-col>
                <v-col md="6">
                    <v-radio-group color="orange" label="Sexe" v-model="form.sex">
                        <v-radio label="Masculin" value="M"></v-radio>
                        <v-radio label="Féminin" value="F"></v-radio>
                    </v-radio-group>
                    <v-autocomplete label="Roles" :items="roles" v-model="form.roles">
                    </v-autocomplete>
                    <v-autocomplete label="Etablissement" :items="etablissements" v-model="form.roles">
                    </v-autocomplete>
                </v-col>
            </v-row>
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
