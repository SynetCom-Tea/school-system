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
    mdiClipboardEditOutline,
} from '@mdi/js'
export default {
    layout: AuthenticatedLayout,
    props: ["section_id", "niveaux","matieres"],
    data() {
        return {
            icon: {
                mdiPlus,
                mdiSchool,
                mdiAccountSchool,
                mdiCheckCircle,
                mdiCancel,
                mdiClipboardEditOutline,
            },
        
            form: useForm({
                volume_horaire: '',
                coefficient: '',
                niveau_id: '',
                matiere_id: '',
            }),
        }
    },
    created() {
        
    },
    methods: {

        goBack() {
            router.get(route('affectations.index', this.section_id))
        },
        async submit() {
            const {
                valid
            } = await this.$refs.form.validate()
            if (valid) {
                console.log(this.form)
                this.form.post(route('affectations.store',this.section_id), {
                    onFinish: () => {
                        this.close()
                        this.$swal({
                            icon: 'success',
                            title: 'Enregistrement',
                            text: 'Niveau_Matière créé avec succès!',
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
    <Toolbar :icon="icon.mdiClipboardEditOutline" toolbarTitle="Affectation de matière aux niveaux"></Toolbar>

    <v-card-text>
        <v-form ref="form">
                <v-row>
                    <v-col cols="6" md="6">
                    <Select
                        label="Matière"
                        :items="matieres"
                        variant="outlined"
                        item-value="id"
                        item-title="nom"
                        v-model="form.matiere_id"
                        isRequired
                        :rules="[(v) => !!v || 'Ce champ est requis!']"
                        >
                    </Select>
                    </v-col>
                    <v-col cols="6" md="6">
                    <Select
                        label="Niveaux"
                        :items="niveaux"
                        variant="outlined"
                        item-value="id"
                        item-title="libelle"
                        v-model="form.niveau_id"
                        multiple
                        ships
                        isRequired
                        :rules="[(v) => !!v || 'Ce champ est requis!']"
                        >
                    ></Select>
                    </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="6" md="6">
                            <TextField
                            type="number"
                            label="Volume_Horaire"
                            placeholder="Volume_Horaire"
                            v-model="form.volume_horaire"
                            isRequired
                            :rules="[(v) => !!v || 'Ce champ est requis!']"
                            ></TextField>
                        </v-col>
                        <v-col cols="6" md="6">
                            <TextField
                            type="number"
                            label="Coefficient"
                            placeholder="Coefficient"
                            v-model="form.coefficient"
                            isRequired
                            :rules="[(v) => !!v || 'Ce champ est requis!']"
                            ></TextField>
                        </v-col>
                        
            </v-row>          
        </v-form>
        </v-card-text>
        <v-card-actions class="justify-end">
      <v-spacer></v-spacer>
      <v-btn dark small type="button" color="red" @click="goBack">
        <v-icon :icon="icon.mdiCancel" left></v-icon> Annuler
      </v-btn>
      <v-btn small color="primary" @click="submit">
        <v-icon :icon="icon.mdiCheckCircle" left></v-icon> Enregistrer
      </v-btn>
    </v-card-actions>
</v-card>
</template>
