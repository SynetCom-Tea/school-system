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
    mdiCheckCircle,
    mdiPlus
} from '@mdi/js'
export default {
    components: {
        mdiAccountPlusOutline,
        mdiEmailOutline,
        mdiCancel,
        mdiCheckCircle,
        mdiPlus
    },
    layout: AuthenticatedLayout,
    props: ['role', 'AllSections', 'etablissements', 'tuteurs', 'enseignants', 'etablissement_sections', 'section_id'],
    data() {
        return {
            role_p_u: null,
            icon: {
                mdiAccountPlusOutline,
                mdiEmailOutline,
                mdiCancel,
                mdiCheckCircle,
                mdiPlus
            },
            form: useForm({
                nom: '',
                prenom: '',
                type_user: null,
                roles: null,
                etablissement_id: null,
                sections: [],
                tuteur_id: null,
                enseignant_id: null,
                section: null,
                checkbox: null
            }),
            userTypes: ['Enseignant', 'Tuteur', 'Autre'],
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
            // console.log(this.$page.props.sections)
        },
        setInfoForTuteur() {
            this.form.nom = this.tuteurs.filter(el => el.id == this.form.tuteur_id)[0].nom
            this.form.prenom = this.tuteurs.filter(el => el.id == this.form.tuteur_id)[0].prenom
        },
        updateUserTypes(sectionId) {
            console.log('SectionID',sectionId)
            this.userTypes = ['Enseignant', 'Tuteur'];
            if (sectionId == 1 || sectionId == 2) {
                this.userTypes.push('Élève');
                this.userTypes.push('Autre');
            }
            if (sectionId == 3) {
                this.userTypes.push('Étudiant');
                this.userTypes.push('Autre');
            }
        },
    },
    created() {
        this.role_p_u = this.role.filter(el => el.name !== 'Administrateur' && el.name !== 'Super-administrateur')
    },
    mounted() {
        //  this.updateUserTypes(this.section_id);
    },
}
</script>
<template>
<v-card>
    <Toolbar :icon="icon.mdiAccountPlusOutline" toolbarTitle="Nouvel Utilisateur"></Toolbar>
    <v-card-text>
        <v-form>
                <v-row>
                    <v-col cols="6">
                        <autocomplete
                            class="mt-4"
                            v-model="form.type_user"
                            label="Type utilisateur"
                            :items="userTypes"
                            variant="outlined"
                            :isRequired="true"
                            clearable
                            >
                        </autocomplete>
                    </v-col>
                    <v-col cols="6">
                        <v-checkbox
                            v-model="form.checkbox"
                            value="1"
                            label="Utilisateur d'une section ?"
                            type="checkbox"
                            >
                        </v-checkbox>
                    </v-col>
                    <v-col v-if="form.checkbox == 1" md="3">
                        <autocomplete class="mt-4" label="Section" :isRequired="true" itemTitle="libelle" item-value="id" :items="etablissement_sections" multiple chips clearable v-model="form.section" :rules="[v => !!v || 'Ce champ est requis!'] ">
                        </autocomplete>
                    </v-col>
                    <v-col v-if="form.type_user == 'Autre'" md="3">
                        <text-field class="mt-4" name="nom" label="Nom" placeholder="Nom" v-model="form.nom" :isRequired="true" :rules="[v => !!v || 'Ce champ est requis!'] "></text-field>
                    </v-col>
                    <v-col v-if="form.type_user == 'Autre'" md="3">
                        <text-field class="mt-4" name="prenom" label="Prenom" placeholder="Prenom" :isRequired="true" v-model="form.prenom" :rules="[v => !!v || 'Ce champ est requis!'] "></text-field>
                    </v-col>
                    <v-col v-if="form.type_user == 'Enseignant'" md="4">
                        <autocomplete class="mt-4" label="Enseignant" v-model="form.enseignant_id" @update:modelValue="setInfoForEnseignant" :isRequired="true" item-title="nomcomplet" item-value="id" :items="enseignants" chips clearable :rules="[v => !!v || 'Ce champ est requis!'] ">
                        </autocomplete>
                    </v-col>
                    <v-col v-if="form.type_user == 'Tuteur'" md="4">
                        <autocomplete class="mt-4" label="Tuteur" v-model="form.tuteur_id" @update:modelValue="setInfoForTuteur" :isRequired="true" itemTitle="nomcomplet" item-value="id" :items="tuteurs" chips clearable :rules="[v => !!v || 'Ce champ est requis!'] ">
                        </autocomplete>
                    </v-col>
                    <!-- <v-col v-if="form.tuteur_id != null" md="4">
                        <autocomplete class="mt-4" label="Tuteur" v-model="form.tuteur_id" :isRequired="true" itemTitle="nomcomplet" item-value="id" :items="tuteurs" chips clearable :rules="[v => !!v || 'Ce champ est requis!'] ">
                        </autocomplete>
                    </v-col> -->
                    <v-col md="3">
                        <autocomplete class="mt-4" :isRequired="true" label="Roles" itemTitle="name" item-value="id" :items="role_p_u" chips clearable v-model="form.roles" :rules="[v => !!v || 'Ce champ est requis!'] ">
                        </autocomplete>
                    </v-col>
                </v-row>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn dark small type="button" variant="outlined" color="red" @click="goBack">
                        <v-icon :icon="icon.mdiCancel" left></v-icon> Annuler
                    </v-btn>
                    <v-btn small :loading="form.processing" color="primary" variant="outlined" @click="submit">
                        <v-icon :icon="icon.mdiCheckCircle" left></v-icon> Enregistrer
                    </v-btn>
                    <!-- <v-btn small :loading="form.processing" color="success" variant="outlined" @click="submit">
                        <v-icon :icon="icon.mdiCheckCircle" left></v-icon> Enregistrer
                    </v-btn> -->
                </v-card-actions>
        </v-form>
    </v-card-text>
</v-card>
</template>
