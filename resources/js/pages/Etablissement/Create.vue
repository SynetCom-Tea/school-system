<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {
    router,
    useForm
} from "@inertiajs/vue3";
import {
    mdiPlus,
    mdiSchool,
    mdiAccountSchool,
    mdiCheckCircle,
    mdiCancel,
    mdiCamera,
} from '@mdi/js'
export default {
    layout: AuthenticatedLayout,
    props: ["types", "sections"],
    data() {
        return {
            icon: {
                mdiPlus,
                mdiSchool,
                mdiAccountSchool,
                mdiCheckCircle,
                mdiCancel,
                mdiCamera,
            },
            villes: ['Agadez', 'Diffa', 'Dosso', 'Maradi', 'Niamey', 'Tahoua', 'Tilabéri', 'Zinder'],
            form: useForm({
                name: "",
                email: "",
                adresse: "",
                telephone: "",
                ville: "",
                logo: [],
                section: [],
                type_etablissement_id: "",
                nom: "",
                prenom: "",
                mail: "",
            }),
        }
    },
    created() {
        console.log('typessssss')
    },
    methods: {

        goBack() {
            router.get(route('etablissements.index'))
        },
        async submit() {
            const {
                valid
            } = await this.$refs.form.validate()
            if (valid) {
                console.log(this.form)
                this.form.post(route('etablissements.store'), {
                    onFinish: () => {
                        this.close()
                        this.$swal({
                            icon: 'success',
                            title: 'Enregistrement',
                            text: 'Etablissement créé avec succès!',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                        });
                    },
                });
            }
        },
    }
}
</script>
<template>
<v-card>
    <Toolbar :icon="icon.mdiSchool" toolbarTitle="Création d'un Etablissement"></Toolbar>

    <v-card-text>
        <v-form ref="form">
            <v-row>
                <v-col>
                    <v-alert type="info" text>
                        Etablissement
                    </v-alert>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="6" >
                    <Autocomplete label="Type" :items="types"  itemValue="id" itemTitle="name" v-model="form.type_etablissement_id" :isRequired="true" :rules="[(v) => !!v || 'Ce champ est requis!']">
                    </Autocomplete>
                </v-col>
                <v-col cols="6" >
                    <Autocomplete label="Sections" :items="sections" variant="outlined" itemValue="id" itemTitle="libelle" v-model="form.section" multiple chips v-if="form.type_etablissement_id == 2"></Autocomplete>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="4" md="4">
                    <TextField label="Nom" placeholder="Nom Etablissement" v-model="form.name" isRequired :rules="[(v) => !!v || 'Ce champ est requis!']"></TextField>
                </v-col>
                <v-col cols="4" md="4">
                    <Select label="Ville" placeholder="Ville" :items="villes" variant="outlined" v-model="form.ville" isRequired :rules="[(v) => !!v || 'Ce champ est requis!']"></Select>
                </v-col>
                <v-col cols="4" md="4">
                    <v-file-input v-model="form.logo" accept="image/*" color="blue" counter :prepend-icon="icon.mdiCamera" label="Logo" base-color="primary" placeholder="Charger le Logo" variant="outlined" :show-size="1000">
                        <template v-slot:selection="{ fileNames }">
                            <template v-for="(fileName, index) in fileNames" :key="fileName">
                                <v-chip v-if="index < 2" color="blue" label size="small" class="me-2">
                                    {{ fileName }}
                                </v-chip>

                                <span v-else-if="index === 2" class="text-overline text-grey-darken-3 mx-2">
                                    +{{ files.length - 2 }} File(s)
                                </span>
                            </template>
                        </template>
                    </v-file-input>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="4" md="4">
                    <TextField label="Adresse" placeholder="Adresse" v-model="form.adresse" isRequired :rules="[(v) => !!v || 'Ce champ est requis!']"></TextField>
                </v-col>
                <v-col cols="4" md="4">
                    <TextField label="Mail" placeholder="Mail" v-model="form.email" isRequired :rules="[
                                        (v) => !!v || 'Ce champ est requis!',
                                        (v) =>
                                        /^[a-z.-]+@[a-z.-]+\.[a-z]+$/i.test(v) ||
                                        'Adresse Email invalide!',
                                    ]"></TextField>
                </v-col>
                <v-col cols="4" md="4">
                    <text-field label="Téléphone"  placeholder="Téléphone" v-model="form.telephone" isRequired :rules="[(v) => !!v || 'Ce champ est requis!']"></text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <v-alert color="info" :icon="icon.mdiAccountSchool" text>
                        Administrateur de l'établissement
                    </v-alert>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="4" md="4">
                    <text-field label="Nom" placeholder="Nom" v-model="form.nom" isRequired :rules="[(v) => !!v || 'Ce champ est requis!']"></text-field>
                </v-col>
                <v-col cols="4" md="4">
                    <text-field label="Prénom" placeholder="Prénom" v-model="form.prenom" isRequired :rules="[(v) => !!v || 'Ce champ est requis!']"></text-field>
                </v-col>
                <v-col cols="4" md="4">
                    <text-field label="Email" placeholder="Email" v-model="form.mail" isRequired :rules="[
                            (v) => !!v || 'Ce champ est requis!',
                            (v) =>
                            /^[a-z.-]+@[a-z.-]+\.[a-z]+$/i.test(v) ||
                            'Adresse Email invalide!',
                        ]"></text-field>
                </v-col>
            </v-row>

        </v-form>
    </v-card-text>
    <v-card-actions class="justify-end">
        <v-spacer></v-spacer>
        <v-btn dark small type="button" variant="outlined" color="red" @click="goBack">
            <v-icon :icon="icon.mdiCancel" left></v-icon> Annuler
        </v-btn>
        <v-btn small color="success" variant="outlined" @click="submit">
            <v-icon :icon="icon.mdiCheckCircle" left></v-icon> Enregistrer
        </v-btn>
    </v-card-actions>
</v-card>
</template>
