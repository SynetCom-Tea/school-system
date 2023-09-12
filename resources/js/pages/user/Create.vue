<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
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
    props: ['roles', 'sections', 'etablissements'],
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
                roles: [],
                etablissement_id: null,
                sections: []
            }),
        }
    },
    methods: {
        goBack() {
            router.get(route('users.index'))
        },
        submit() {
            this.form.post(route('users.store'), {
                onFinish: () => {
                    // this.form.reset()
                    if (this.$page.props.flashd.messages) {
                        this.$swal({
                            icon: 'warning',
                            title: 'Création',
                            text: this.$page.props.flashd.messages,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                        });
                    }
                },
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
                    <TextField name="nom" label="Nom" placeholder="Nom" v-model="form.nom" isRequired="true"></TextField>
                    <TextField name="prenom" label="Prenom" placeholder="Prenom" isRequired="true" v-model="form.prenom"></TextField>
                    <v-autocomplete label="Roles" item-title="name"  item-value="id" :items="roles" variant="solo-filled" multiple chips clearable v-model="form.roles">
                    </v-autocomplete>
                </v-col>
                <v-col md="6">
                    <v-autocomplete label="Etablissement" isRequired="true" item-title="name" item-value="id" variant="solo-filled" :items="etablissements" v-model="form.etablissement_id">
                    </v-autocomplete>
                    <v-autocomplete label="Section" item-title="libelle" item-value="id" variant="solo-filled" :items="sections" multiple chips clearable v-model="form.sections">
                    </v-autocomplete>
                </v-col>
            </v-row>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn dark small type="button" variant="outlined" color="red" @click="goBack">
                    <v-icon :icon="icon.mdiCancel" left></v-icon> Annuler
                </v-btn>
                <v-btn small color="success" variant="outlined" @click="submit">
                    <v-icon :icon="icon.mdiCheckCircle" left></v-icon> Enregistrer
                </v-btn>
            </v-card-actions>
        </v-form>
    </v-card-text>
</v-card>
</template>
