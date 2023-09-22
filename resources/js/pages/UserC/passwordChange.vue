<template>
<v-container>
    <v-row align="center" justify="center" style="margin-top: 10%;">
        <v-col cols="12" sm="5">
            <v-card class="login-card">
                <v-card-title class="text-center">Changement du mot de passe </v-card-title>
                <v-card-text>
                    <v-form>
                        <v-card class="rounded-r-0" height="100%" shaped>
                            <v-img src="/logo.png" max-height="200"></v-img>
                        </v-card>
                        <br>
                        <br>
                        <text-field type="password" name="code" label="Nouveau mot de passe" placeholder="Nouveau mot de passe" v-model="form.new"></text-field>
                        <text-field type="password" name="code" label="confirmaion" placeholder="confirmaion" v-model="form.confirmation"></text-field>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn dark variant="outlined" small type="button" color="red" @click="goBack">
                                <v-icon :icon="icon.mdiCancel" left></v-icon>Annuler
                            </v-btn>
                            <v-btn small variant="outlined" color="success" @click="submit">
                                <v-icon :icon="icon.mdiCheckCircle" left></v-icon>Enrgistrer
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
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {
    useForm,
    router
} from '@inertiajs/vue3';
import {
    mdiCancel,
    mdiCheckCircle
} from '@mdi/js';

export default {
    components: {
        mdiCancel,
        mdiCheckCircle,
    },
    layout: AuthenticatedLayout,
    data() {
        return {
            icon: {
                mdiCancel,
                mdiCheckCircle
            },
            form: useForm({
                new: '',
                confirmation: '',
            }),
        }
    },
    methods: {
        submit() {
            if (this.form.new == this.form.confirmation) {
                this.form.put(route('change'), {
                    onSuccess: () => {
                        toast.error('le code de vérification n\'est pas valide');
                        this.form.reset()
                        // setTimeout(() => {
                        //     router.get(route('login'));
                        // }, 10000);
                    }
                })

            } else {
                toast.error('Vos deux mots de passes ne correspondent pas')
                this.form.reset()
            }
        }
    },
}
</script>

<style>
.hover {
    padding: 8px 16px;
    background-color: #19d347;
    color: #000;
}
</style>
