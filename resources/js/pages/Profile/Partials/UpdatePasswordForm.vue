<script setup>
import {
    useForm,
    usePage
} from '@inertiajs/vue3';
import {
    ref
} from 'vue';
import {
    mdiEyeOffOutline,
    mdiEyeOutline,
    mdiCircle
} from "@mdi/js";
const isCurrentPasswordVisible = ref(false)
const isNewPasswordVisible = ref(false)
const isConfirmPasswordVisible = ref(false)

const passwordRequirements = [
    'Minimum 8 caractères : plus c\'est long, mieux c\'est',
    'Au moins un caractère minuscule',
    'Au moins un chiffre, un symbole et une lettre majuscule',
]

const passwordInput = ref(null);
const currentPasswordInput = ref(null);
const user = usePage().props.auth.user;

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
    mdp: user.password,
});

const updatePassword = () => {
    console.log('mdp', form)
    //(v) => v === form.mdp || 'Mot de passe invalide!',
    form.put(route('password.update'), {
        preserveScroll: true,
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
        onFinish: () => form.reset(),
    });

};
</script>

<template>
<v-row>
    <!-- SECTION: Change Password -->
    <v-col cols="12">
        <v-card title="Changer le mot de passe" elevation="6" rounded="lg" width="950" style="margin-left: auto; margin-right: auto;margin-top:20px;margin-bottom:20px;">
            <form>
                <v-card-text>
                    <!-- ðŸ‘‰ Current Password -->
                    <v-row class="mb-3">
                        <v-col cols="12" md="6">
                            <!-- ðŸ‘‰ current password -->
                            <text-field v-model="form.current_password" :type="isCurrentPasswordVisible ? 'text' : 'password'" :append-inner-icon="isCurrentPasswordVisible ? mdiEyeOffOutline : mdiEyeOutline" label="Current Password" @click:append-inner="isCurrentPasswordVisible = !isCurrentPasswordVisible" isRequired :rules="[
                            (v) => !!v || 'Ce champ est requis!' 
                        ]"></text-field>
                        </v-col>
                        <v-col cols="12" md="6">
                            <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0" leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                                <v-alert v-if="form.recentlySuccessful" class="text-sm text-gray-600" type="success" border="start" variant="tonal">Modifié.</v-alert>
                            </Transition>
                        </v-col>
                    </v-row>

                    <!-- ðŸ‘‰ New Password -->
                    <v-row>
                        <v-col cols="12" md="6">
                            <!-- ðŸ‘‰ new password -->
                            <text-field v-model="form.password" :type="isNewPasswordVisible ? 'text' : 'password'" :append-inner-icon="isNewPasswordVisible ? mdiEyeOffOutline : mdiEyeOutline" label="New Password" @click:append-inner="isNewPasswordVisible = !isNewPasswordVisible" isRequired :rules="[
                            (v) => !!v || 'Ce champ est requis!', 
                            (v) => v.length > 7 || 'au moins 8 caractères',
                            v => /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/.test(v) || 'Doit contenir au moins une lettre minuscule, un nombre, un caractère spécial et une lettre majuscule',
                        ]"></text-field>
                        </v-col>

                        <v-col cols="12" md="6">
                            <!-- ðŸ‘‰ confirm password -->
                            <text-field v-model="form.password_confirmation" :type="isConfirmPasswordVisible ? 'text' : 'password'" :append-inner-icon="isConfirmPasswordVisible ? mdiEyeOffOutline : mdiEyeOutline" label="Confirm New Password" @click:append-inner="isConfirmPasswordVisible = !isConfirmPasswordVisible" isRequired :rules="[
                            (v) => !!v || 'Ce champ est requis!',
                            (v) => v === form.password || 'Mots de passe différents!',
                        ]"></text-field>
                        </v-col>
                    </v-row>
                </v-card-text>

                <!-- ðŸ‘‰ Password Requirements -->
                <v-card-text>
                    <p class="text-base font-weight-medium mt-2">
                        Exigences du mot de passe :
                    </p>

                    <ul class="d-flex flex-column gap-y-3">
                        <li v-for="item in passwordRequirements" :key="item" class="d-flex">
                            <div>
                                <v-icon size="7" :icon="mdiCircle" class="me-3"></v-icon>
                            </div>
                            <span class="font-weight-medium">{{ item }}</span>
                        </li>
                    </ul>
                </v-card-text>

                <!-- ðŸ‘‰ Action Buttons -->
                <v-card-actions class="d-flex flex-wrap gap-4">
                    <v-btn color="primary" variant="elevated" @click="updatePassword">Changer</v-btn>

                    <v-btn type="reset" color="secondary" variant="tonal">
                        Réinitialiser
                    </v-btn>
                </v-card-actions>
            </form>

        </v-card>
    </v-col>
    <!-- !SECTION -->
</v-row>
</template>
