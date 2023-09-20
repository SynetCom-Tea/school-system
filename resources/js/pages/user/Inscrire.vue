<template>
<v-container>
    <v-row align="center" justify="center" style="margin-top: 10%;" v-if="!changePage">
        <v-col cols="12" sm="4">
            <v-card class="login-card">
                <v-card-title class="text-center"> Vérification de numéro <br> attestation du bac </v-card-title>
                <v-card-text>
                    <v-form>
                        <v-card class="rounded-r-0" height="100%" shaped>
                            <v-img src="/logo.png" max-height="200"></v-img>
                        </v-card>
                        <br>
                        <br>
                        <div @mouseover="isHovered = true" @mouseleave="isHovered = false">
                            <text-field name="code" label="Entrer votre Numero attestation du bac" placeholder="Entrer votre Numero attestation du bac" v-model="form.code"></text-field>
                        </div>
                        <div v-if="isHovered" class="hover">
                            {{ errorMessage }}
                        </div>
                        <br>
                        <v-card-actions>
                            <v-btn style="color: green" @click="goTo">
                                Vous avez eu le bac ailleurs?
                            </v-btn>
                        </v-card-actions>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn dark small type="button" color="red" @click="goBack">
                                <v-icon :icon="icon.mdiCancel" left></v-icon>Annuler
                            </v-btn>
                            <v-btn small color="success" @click="enregistrer">
                                <v-icon :icon="icon.mdiCheckCircle" left></v-icon>Vérifier
                            </v-btn>
                        </v-card-actions>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
    <v-row align="center" justify="center" style="margin-top: 10%;" v-if="changePage">
        <v-col cols="12" sm="4">
            <v-card class="login-card">
                <v-card-title class="text-center">Creation de compte </v-card-title>
                <v-card-text>
                    <v-form>
                        <v-card class="rounded-r-0" height="100%" shaped>
                            <v-img src="/logo.png" max-height="200"></v-img>
                        </v-card>
                        <br>
                        <text-field name="nom" label="Nom *" placeholder="Nom *" v-model="formUser.nom"></text-field>
                        <text-field name="prenom" label="Prénom *" placeholder="Prénom *" v-model="formUser.prenom"></text-field>
                        <text-field name="email" label="Email *" placeholder="Email *" v-model="formUser.email"></text-field>
                        <input type="date" class="form-control  " v-model="formUser.date_naiss">
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn dark small type="button" color="red" @click="goBack">
                                <v-icon :icon="icon.mdiCancel" left></v-icon>Annuler
                            </v-btn>
                            <v-btn small color="success" @click="save">
                                <v-icon :icon="icon.mdiContentSave" left></v-icon>Enrgistrer
                            </v-btn>
                        </v-card-actions>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</v-container>
</template>

<script>
import {
    useForm,
    router
} from '@inertiajs/vue3';
import {
    mdiCancel,
    mdiCheckCircle,
    mdiContentSave
} from '@mdi/js';

export default {
    components: {
        mdiCancel,
        mdiCheckCircle,
        mdiContentSave,
    },
    props: ['codes', 'message'],
    data() {
        return {
            selectedDate: null,
            errorMessage: 'Entrer votre Numero attestation du bac.',
            isHovered: false,
            icon: {
                mdiCancel,
                mdiCheckCircle,
                mdiContentSave
            },
            changePage: false,
            form: useForm({
                code: '',
            }),
            formUser: useForm({
                nom: null,
                prenom: null,
                email: null,
                date_naiss: null,
            }),
        }
    },
    methods: {
        goBack() {
            router.get(route('login'))
        },
        goTo() {
            this.changePage = true
        },
        save() {
            this.formUser.post(route('etranger'))
        },
        enregistrer() {
            this.form.post(route('inscrire'), {
                onSuccess: () => {
                    if (this.$page.props.flashd.messages) {
                         toast.warning(this.$page.props.flashd.messages);
                    } 
                    this.form.reset()
                },
            });
        },
        inscrire() {
            form.post(route('inscrit'), {

            });
        },
        handlePaste(event) {
            event.preventDefault();
            toast.error('Vous ne pouvez pas coller');
        },
    },
    mounted() {
        // console.log(this.changePage)
    }
}
</script>

<style>
.hover {
    padding: 8px 16px;
    background-color: #19d347;
    color: #000;
}
</style>
