<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { mdiDatabaseSync, mdiTimerSync } from "@mdi/js";

export default {
  layout: AuthenticatedLayout,
  props: ["sectionID"],
  data: () => ({
    icons: {
      mdiDatabaseSync,
      mdiTimerSync
    },
    overlay: false,
  }),
  watch: {
    overlay(val) {
        if (val) {
            // Si overlay est vrai, attendre pour le masquer
            setTimeout(() => {
                if (this.overlay) {
                // Si l'overlay est toujours affiché après 3 secondes, le masquer
                this.overlay = false;
                }
            }, 3000);
        }
    },
},
  methods: {
    async generateBulletin() {
      this.overlay = true; // Affiche l'overlay au début du traitement

      try {
        // Effectuez votre traitement, par exemple, une opération asynchrone
        // Exemple avec await this.$inertia.replace()
        const classe = 'VotreClasse';
        await this.$inertia.replace(this.$page.url, {
          data: { classe: classe }
        });

        // L'overlay reste visible après la fin du traitement si la page est cliquée dans le vide
      } catch (error) {
        console.error(error); // Gérez les erreurs potentielles ici
      } finally {
        this.overlay = false; // Cache l'overlay une fois le traitement terminé
      }
    },
 }
}
</script>

<template>
  <v-card>
    <Toolbar :icon="icons.mdiDatabaseSync" toolbarTitle="Génération des bulletins"></Toolbar>
    <v-card-text>
      <div class="text-center">
        <v-btn
          :append-icon="icons.mdiTimerSync"
          color="deep-purple-accent-4"
          @click="generateBulletin"
          :disabled="overlay" 
        >
          Générer
        </v-btn>

        <v-overlay :value="overlay" absolute fullscreen>
          <v-progress-circular
            color="primary"
            indeterminate
            size="64"
          ></v-progress-circular>
        </v-overlay>
      </div>
    </v-card-text>
  </v-card>
</template>
