<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm, router } from '@inertiajs/vue3';
import {
    mdiAccountTie,
    mdiCancel,
    mdiCloseCircle,
    mdiContentSave,
    mdiDelete,
    mdiPencil,
    mdiPlus,
} from '@mdi/js';

export default {
    layout: AuthenticatedLayout,
    props: {
        chefs: {
            type: Array,
            default: () => [],
        },
        etablissementSections: {
            type: Array,
            default: () => [],
        },
        chefEtablissement: {
            type: Object,
            default: null,
        },
        showForm: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            icons: {
                mdiAccountTie,
                mdiCancel,
                mdiCloseCircle,
                mdiContentSave,
                mdiDelete,
                mdiPencil,
                mdiPlus,
            },
            dialog: false,
            form: useForm({
                id: null,
                nom: '',
                prenom: '',
                email: '',
                telephone: '',
                etablissement_section_id: null,
            }),
        };
    },
    mounted() {
        if (this.showForm) {
            this.openForm(this.chefEtablissement);
        }
    },
    methods: {
        sectionLabel(item) {
            const section = item?.etablissement_section || item?.etablissementSection;
            return section?.section?.libelle || section?.section?.name || section?.code || 'Non renseigne';
        },
        openForm(chef = null) {
            this.form.clearErrors();
            this.form.id = chef?.id || null;
            this.form.nom = chef?.nom || '';
            this.form.prenom = chef?.prenom || '';
            this.form.email = chef?.email || '';
            this.form.telephone = chef?.telephone || '';
            this.form.etablissement_section_id = chef?.etablissement_section_id || null;
            this.dialog = true;
        },
        closeForm() {
            this.dialog = false;
            this.form.reset();
            this.form.clearErrors();
        },
        submit() {
            const options = {
                preserveScroll: true,
                onSuccess: () => {
                    this.closeForm();
                    this.$swal({
                        icon: 'success',
                        iconColor: '#004980',
                        color: '#004980',
                        title: this.form.id ? 'Modification' : 'Enregistrement',
                        text: this.form.id ? 'Chef d\'établissement modifié avec succès!' : 'Chef d\'établissement créé avec succès!',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                    });
                },
            };

            if (this.form.id) {
                this.form.put(route('chef-etablissements.update', this.form.id), options);
            } else {
                this.form.post(route('chef-etablissements.store'), options);
            }
        },
        destroyChef(chef) {
            this.$swal({
                title: 'Es-tu sûr?',
                text: "Vous ne pourrez pas revenir en arrière !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#004980',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimez-le!',
                cancelButtonText: 'Non, annulez !',
            }).then((result) => {
                if (result.isConfirmed) {
                    router.delete(route('chef-etablissements.destroy', chef.id), {
                        preserveScroll: true,
                        onSuccess: () => {
                            this.$swal({
                                icon: 'success',
                                iconColor: '#004980',
                                color: '#004980',
                                title: 'Suppression',
                                text: 'Chef d\'établissement supprimé avec succès!',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                            });
                        },
                    });
                }
            });
        },
    },
};
</script>

<template>
    <Toolbar :icon="icons.mdiAccountTie" toolbarTitle="Gestion des chefs d'etablissement"></Toolbar>

    <v-card variant="outlined" class="mt-4">
        <v-card-title class="d-flex align-center">
            <span>Chef d'etablissement</span>
            <v-spacer></v-spacer>
            <v-btn color="primary" :prepend-icon="icons.mdiPlus" @click="openForm()">
                Ajouter
            </v-btn>
        </v-card-title>

        <v-card-text>
            <v-table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Email</th>
                        <th>Telephone</th>
                        <th>Section</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="chef in chefs" :key="chef.id">
                        <td>{{ chef.nom }}</td>
                        <td>{{ chef.prenom }}</td>
                        <td>{{ chef.email }}</td>
                        <td>{{ chef.telephone }}</td>
                        <td>{{ sectionLabel(chef) }}</td>
                        <td class="text-center">
                            <v-btn size="small" variant="text" color="warning" :icon="icons.mdiPencil" title="Modifier"
                                @click="openForm(chef)"></v-btn>
                            <v-btn size="small" variant="text" color="error" :icon="icons.mdiDelete" title="Supprimer"
                                @click="destroyChef(chef)"></v-btn>
                        </td>
                    </tr>
                    <tr v-if="!chefs.length">
                        <td colspan="6" class="text-center py-6">Aucun chef trouve</td>
                    </tr>
                </tbody>
            </v-table>
        </v-card-text>
    </v-card>

    <v-dialog v-model="dialog" max-width="650" persistent>
        <v-card>
            <v-toolbar color="orange">
                <v-toolbar-title>
                    <v-icon :icon="icons.mdiAccountTie" class="mr-2"></v-icon>
                    Chef d'etablissement
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn :icon="icons.mdiCloseCircle" title="Fermer" @click="closeForm"></v-btn>
            </v-toolbar>

            <v-card-text>
                <v-form @submit.prevent="submit">
                    <v-row>
                        <v-col cols="12" md="6">
                            <v-text-field v-model="form.nom" label="Nom" variant="outlined"
                                :error-messages="form.errors.nom"></v-text-field>
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field v-model="form.prenom" label="Prenom" variant="outlined"
                                :error-messages="form.errors.prenom"></v-text-field>
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field v-model="form.email" label="Email" type="email" variant="outlined"
                                :error-messages="form.errors.email"></v-text-field>
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field v-model="form.telephone" label="Telephone" variant="outlined"
                                :error-messages="form.errors.telephone"></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-select v-model="form.etablissement_section_id" label="Section de l'etablissement"
                                :items="etablissementSections" item-value="id"
                                :item-title="item => item.section?.libelle || item.section?.name || item.code || `Section ${item.id}`"
                                variant="outlined" :error-messages="form.errors.etablissement_section_id"></v-select>
                        </v-col>
                    </v-row>

                    <div class="d-flex justify-end">
                        <v-btn class="mr-2" variant="outlined" color="error" :prepend-icon="icons.mdiCancel"
                            :disabled="form.processing" @click="closeForm">
                            Annuler
                        </v-btn>
                        <v-btn color="primary" type="submit" :prepend-icon="icons.mdiContentSave"
                            :loading="form.processing">
                            Enregistrer
                        </v-btn>
                    </div>
                </v-form>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>
