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
    props: ['roles', 'sections', 'etablissements', 'apprenants', 'enseignants','etablissement_sections'],
    data() {
        return {
            role_p_u: null,
            icon: {
                mdiAccountPlusOutline,
                mdiEmailOutline,
                mdiCancel,
                mdiCheckCircle
            },
            form: useForm({
                nom: '',
                prenom: '',
                roles: null,
                etablissement_id: null,
                sections: [],
                apprenant_id: null,
                enseignant_id: null,
                section : null
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
        setInfoForEnseignant() {
            this.form.nom = this.enseignants.filter(el => el.id == this.form.enseignant_id)[0].nom
            this.form.prenom = this.enseignants.filter(el => el.id == this.form.enseignant_id)[0].prenom
            console.log(this.$page.props.sections)
        },
        setInfoForApprenant() {
            this.form.nom = this.apprenants.filter(el => el.id == this.form.apprenant_id)[0].nom
            this.form.prenom = this.apprenants.filter(el => el.id == this.form.apprenant_id)[0].prenom
        },

    },
    created() {
        this.role_p_u = this.roles.filter(el => el.name !== 'Administrateur' && el.name !== 'Super-administrateur')
    }
}
</script>
<template>
<v-card>
    <Toolbar :icon="icon.mdiAccountPlusOutline" toolbarTitle="Nouvel Utilisateur"></Toolbar>
    <v-card-text>
        <v-form>
            <v-row>
                <v-col md="6">
                    <TextField name="nom" label="Nom" placeholder="Nom" v-model="form.nom" isRequired="true"></TextField>
                    <TextField name="prenom" label="Prenom" placeholder="Prenom" isRequired="true" v-model="form.prenom"></TextField>
                    <Autocomplete v-if="$page.props.auth.user.id !== 1 && form.enseignant_id" label="Section" :isRequired="true" item-title="libelle" item-value="id" variant="solo-filled" :items="etablissement_sections" multiple chips clearable v-model="form.section">
                    </Autocomplete>
                </v-col>
                <v-col v-if="$page.props.auth.user.id !=1">
                    <Autocomplete :isRequired="true" label="Roles" item-title="name" item-value="id" :items="role_p_u" variant="solo-filled" chips clearable v-model="form.roles">
                    </Autocomplete>
                    <Autocomplete label="Enseignant" v-if="form.roles==3" v-model="form.enseignant_id" @update:modelValue="setInfoForEnseignant" :isRequired="true" item-title="matricule" item-value="id" variant="solo-filled" :items="enseignants" chips clearable>
                    </Autocomplete>
                    <Autocomplete label="Apprenants" v-if="form.roles==4" v-model="form.apprenant_id" @update:modelValue="setInfoForApprenant" :isRequired="true" item-title="matricule" item-value="id" variant="solo-filled" :items="apprenants" chips clearable>
                    </Autocomplete>
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