<script setup>
import avatar1 from '@/assets/avatar-1.png'
import { ref } from 'vue'
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { mdiContentSave } from "@mdi/js";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    nom: user.nom,
    prenom: user.prenom,
    email: user.email,
});


const refInputEl = ref()
const isAccountDeactivated = ref(false)
const validateAccountDeactivation = [v => !!v || 'Please confirm account desactivation']

const save = () => {
    //console.log(form);
      form.patch(route("profile.update"), {
        preverseScroll: true,
        onSuccess: () => {
          //toast.success("Votre compte a été mis à jour avec succes");
        },
      });
    };

</script>

<template>
  <v-row>
    <v-col cols="12">
      <v-card title="Détails du compte" elevation="6" rounded="lg" width="950" style="margin-left: auto; margin-right: auto;margin-top:10px;">
        <VDivider />

        <v-card-text>
          <!-- ðŸ‘‰ Form -->
          <form class="mt-6">
            <v-row>
              <!-- ðŸ‘‰ First Name -->
              <v-col
                md="6"
                cols="12"
              >
                
                <text-field
                        v-model="form.nom"
                  label="Nom"
                        isRequired
                        :rules="[
                            (v) => !!v || 'Ce champ est requis!'
                        ]"
                        ></text-field>
              </v-col>

              <!-- ðŸ‘‰ Last Name -->
              <v-col
                md="6"
                cols="12"
              >
                
                <text-field
                         v-model="form.prenom"
                  label="Prenom"
                        isRequired
                        :rules="[
                            (v) => !!v || 'Ce champ est requis!'
                        ]"
                        ></text-field>
              </v-col>

              <!-- ðŸ‘‰ Email -->
              <v-col
                cols="12"
                md="6"
              >
                <text-field
                        label="Identifiant"
                        v-model="form.email"
                        isRequired
                        disabled
                        :rules="[
                            (v) => !!v || 'Ce champ est requis!',
                            (v) =>
                            /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
                            'Adresse Email invalide!',
                        ]"
                        ></text-field>
              </v-col>

              <!-- ðŸ‘‰ Form Actions -->
              <v-col
                md="6"
                cols="12"
                class="py-2"
              >
              <v-responsive
                class="py-3"
                    
                >
                <v-btn color="primary" @click="save"> <VIcon
                  :icon="mdiContentSave"
                  class="d-sm-none"
                  :disabled="form.processing"
                />Enregistrer</v-btn>

                <v-btn style="margin-left: 10px;"
              @click="form.reset()"
              color="secondary"
              variant="tonal"
            >
              Annuler
            </v-btn>
              </v-responsive>
              </v-col>
              <v-col>
                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <v-alert v-if="form.recentlySuccessful" class="text-sm text-gray-600" type="success" border="start"
      variant="tonal">Enregistré.</v-alert>
                </Transition>
              </v-col>
            </v-row>
          </form>
        </v-card-text>
      </v-card>
    </v-col>

    <v-col cols="12">
      <!-- ðŸ‘‰ Delete Account -->
      <v-card title="Désactivation du compte" elevation="6" rounded="lg" width="950" style="margin-left: auto; margin-right: auto; margin-bottom:20px;">
        <v-card-text>
          <!-- ðŸ‘‰ Checkbox and Button  -->
          <v-alert
            color="warning"
            variant="tonal"
            class="mb-4"
          >
            <v-alert-title class="mb-1">
              Etes-vous sûr de vouloir désactiver votre compte?
            </v-alert-title>
            <p class="mb-0">
              Une fois le compte désactivé, vous ne pouvez pas revenir en arrière. Soyez certain SVP.
            </p>
          </v-alert>
          <div>
            <v-checkbox
              v-model="isAccountDeactivated"
              :rules="validateAccountDeactivation"
              label="Je confirme la désactivation de mon compte"
            />
          </div>

          <v-btn
            :disabled="!isAccountDeactivated"
            color="error"
            class="mt-3"
          >
            Désactiver mon compte
          </v-btn>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>
