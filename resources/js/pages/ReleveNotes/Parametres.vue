<template>
  <AuthenticatedLayout>
    <div class="parametres-container">
      <!-- En-tête -->
      <v-card class="header-card">
        <v-card-text class="header-content">
          <div class="header-icon">
            <v-icon color="#3c80e7" size="48">mdi-cog</v-icon>
          </div>
          <div class="header-text">
            <h1 class="header-title">Paramétrage du Relevé de Notes</h1>
            <p class="header-subtitle">Générez des fiches personnalisées par classe et par matière</p>
          </div>
        </v-card-text>
      </v-card>

      <!-- Carte de paramétrage -->
      <v-card class="parametres-card">
        <v-card-title class="parametres-header">
          <v-icon color="#3c80e7" class="me-2">mdi-tune</v-icon>
          Paramètres de Génération
        </v-card-title>

        <v-card-text>
          <v-form>
            <v-row>
              <!-- Sélection de la classe -->
              <v-col cols="12" md="6">
                <v-select
                  v-model="form.classe_id"
                  :items="classes"
                  item-title="libelle"
                  item-value="id"
                  label="Sélectionner la classe"
                  variant="outlined"
                  prepend-icon="mdi-account-multiple"
                  clearable
                  :hint="form.classe_id ? `${getElevesCount()} élèves dans cette classe` : 'Sélectionnez une classe'"
                  persistent-hint
                ></v-select>
              </v-col>

              <!-- Format de sortie -->
              <v-col cols="12" md="6">
                <div class="format-selection">
                  <label class="format-label">Format de sortie :</label>
                  <v-radio-group v-model="form.format" inline hide-details>
                    <v-radio value="par_matiere" color="primary">
                      <template v-slot:label>
                        <div class="format-option">
                          <v-icon color="primary" class="me-2">mdi-file-document</v-icon>
                          Fiche par matière
                        </div>
                      </template>
                    </v-radio>
                    <v-radio value="par_classe" color="secondary">
                      <template v-slot:label>
                        <div class="format-option">
                          <v-icon color="secondary" class="me-2">mdi-book-multiple</v-icon>
                          Toutes matières
                        </div>
                      </template>
                    </v-radio>
                  </v-radio-group>
                </div>
              </v-col>

              <!-- Sélection des matières -->
              <v-col cols="12">
                <v-card variant="outlined" class="matieres-card">
                  <v-card-title class="matieres-title">
                    <v-icon color="orange" class="me-2">mdi-book-education</v-icon>
                    Sélection des Matières
                    <v-chip size="small" color="orange" class="ms-2">
                      {{ form.matieres.length }} / {{ matieres.length }}
                    </v-chip>
                  </v-card-title>
                  
                  <v-card-text>
                    <div class="matieres-actions">
                      <v-btn @click="selectAll" size="small" variant="outlined" color="primary">
                        <v-icon start>mdi-select-all</v-icon>
                        Tout sélectionner
                      </v-btn>
                      <v-btn @click="deselectAll" size="small" variant="outlined" color="grey" class="ms-2">
                        <v-icon start>mdi-select-remove</v-icon>
                        Tout désélectionner
                      </v-btn>
                    </div>

                    <div class="matieres-grid">
                      <v-checkbox
                        v-for="matiere in matieres"
                        :key="matiere"
                        v-model="form.matieres"
                        :label="matiere"
                        :value="matiere"
                        color="primary"
                        density="compact"
                        hide-details
                      ></v-checkbox>
                    </div>
                  </v-card-text>
                </v-card>
              </v-col>

              <!-- Génération rapide -->
              <v-col cols="12">
                <v-card variant="outlined" class="quick-actions-card">
                  <v-card-title class="quick-actions-title">
                    <v-icon color="green" class="me-2">mdi-lightning-bolt</v-icon>
                    Génération Rapide
                  </v-card-title>
                  
                  <v-card-text>
                    <p class="quick-actions-description">
                      Générez rapidement une fiche individuelle pour chaque matière :
                    </p>
                    
                    <div class="quick-actions-grid">
                      <v-btn
                        v-for="matiere in matieres.slice(0, 8)"
                        :key="'quick-' + matiere"
                        @click="genererMatiereUnique(matiere)"
                        color="green"
                        variant="tonal"
                        size="small"
                        class="quick-action-btn"
                        :disabled="!form.classe_id"
                      >
                        <v-icon start size="small">mdi-download</v-icon>
                        {{ truncateMatiere(matiere) }}
                      </v-btn>
                    </div>
                    
                    <v-alert v-if="!form.classe_id" type="warning" density="compact" class="mt-3">
                      Sélectionnez d'abord une classe pour activer la génération rapide
                    </v-alert>
                  </v-card-text>
                </v-card>
              </v-col>
            </v-row>
          </v-form>
        </v-card-text>

        <v-card-actions class="parametres-actions">
          <v-btn 
            @click="$router.back()" 
            variant="text" 
            color="grey"
            prepend-icon="mdi-arrow-left"
          >
            Retour
          </v-btn>
          
          <v-spacer></v-spacer>
          
          <v-btn 
            @click="genererReleve" 
            color="primary" 
            size="large"
            :loading="loading"
            :disabled="!form.classe_id"
            prepend-icon="mdi-file-pdf-box"
          >
            Générer le Relevé PDF
          </v-btn>
        </v-card-actions>
      </v-card>

      <!-- Aperçu -->
      <v-card class="apercu-card">
        <v-card-title class="apercu-title">
          <v-icon color="info" class="me-2">mdi-eye</v-icon>
          Aperçu de la Sélection
        </v-card-title>
        
        <v-card-text>
          <div v-if="!form.classe_id" class="apercu-vide">
            <v-icon color="grey" size="64" class="mb-3">mdi-school-outline</v-icon>
            <h3 class="apercu-vide-title">Aucune classe sélectionnée</h3>
            <p class="apercu-vide-text">Veuillez sélectionner une classe pour voir l'aperçu</p>
          </div>
          
          <div v-else class="apercu-content">
            <div class="apercu-section">
              <v-icon color="primary" class="me-2">mdi-account-multiple</v-icon>
              <div>
                <div class="apercu-label">Classe sélectionnée</div>
                <div class="apercu-value">{{ getClasseLibelle(form.classe_id) }}</div>
              </div>
            </div>
            
            <div class="apercu-section">
              <v-icon color="orange" class="me-2">mdi-book-education</v-icon>
              <div>
                <div class="apercu-label">Matières sélectionnées</div>
                <div class="apercu-value">
                  <span v-if="form.matieres.length === 0 || form.matieres.length === matieres.length">
                    Toutes les matières ({{ matieres.length }})
                  </span>
                  <span v-else>
                    {{ form.matieres.length }} matière(s) sur {{ matieres.length }}
                  </span>
                </div>
              </div>
            </div>
            
            <div class="apercu-section">
              <v-icon color="secondary" class="me-2">mdi-format-list-bulleted</v-icon>
              <div>
                <div class="apercu-label">Format de sortie</div>
                <div class="apercu-value">
                  {{ form.format === 'par_matiere' ? '📄 Fiche individuelle par matière' : '📚 Toutes matières regroupées' }}
                </div>
              </div>
            </div>
            
            <v-divider class="my-4"></v-divider>
            
            <div class="apercu-summary">
              <v-chip color="primary" variant="flat" prepend-icon="mdi-information">
                {{ getElevesCount() }} élèves • {{ form.matieres.length || matieres.length }} matières
              </v-chip>
            </div>
          </div>
        </v-card-text>
      </v-card>
    </div>
  </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router } from "@inertiajs/vue3";

export default {
  components: {
    AuthenticatedLayout,
  },

  props: {
    section: String,
    classes: Array,
    matieres: Array,
    vSectionID: String
  },

  data() {
    return {
      loading: false,
      form: {
        classe_id: null,
        matieres: [],
        format: 'par_matiere'
      },
      // Données simulées pour le développement
      elevesParClasse: {
        1: 25,
        2: 30,
        3: 28,
        4: 22
      }
    };
  },

  methods: {
    selectAll() {
      this.form.matieres = [...this.matieres];
    },

    deselectAll() {
      this.form.matieres = [];
    },

    getClasseLibelle(classeId) {
      const classe = this.classes.find(c => c.id == classeId);
      return classe ? classe.libelle : 'Classe inconnue';
    },

    getElevesCount() {
      if (!this.form.classe_id) return 0;
      return this.elevesParClasse[this.form.classe_id] || 'Inconnu';
    },

    truncateMatiere(matiere) {
      return matiere.length > 15 ? matiere.substring(0, 15) + '...' : matiere;
    },

    async genererReleve() {
      if (!this.form.classe_id) {
        this.$toast.error('Veuillez sélectionner une classe');
        return;
      }

      this.loading = true;
      
      try {
        const params = new URLSearchParams({
          section: this.vSectionID,
          classe_id: this.form.classe_id,
          matieres: this.form.matieres,
          format: this.form.format
        });

         // Utiliser la route correcte
            const url = `/scolarite/releve-notes-vide-generer?${params}`;
            window.open(url, '_blank');
        
        this.$toast.success('Génération du relevé lancée');
      } catch (error) {
        console.error('Erreur génération:', error);
        this.$toast.error('Erreur lors de la génération');
      } finally {
        this.loading = false;
      }
    },

    genererMatiereUnique(matiere) {
      if (!this.form.classe_id) {
        this.$toast.warning('Veuillez d\'abord sélectionner une classe');
        return;
      }

      const url = `/scolarite/releve-notes-matiere/${this.form.classe_id}/${encodeURIComponent(matiere)}`;
      window.open(url, '_blank');
      
      this.$toast.info(`Génération de la fiche ${matiere}`);
    }
  },

  mounted() {
    // Sélectionner toutes les matières par défaut
    this.selectAll();
    
    // Sélectionner la première classe par défaut si disponible
    if (this.classes && this.classes.length > 0) {
      this.form.classe_id = this.classes[0].id;
    }
  }
};
</script>

<style scoped>
.parametres-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
  display: grid;
  gap: 24px;
}

.header-card {
  border-radius: 12px;
  background: linear-gradient(135deg, #f8f9fa, #e9ecef);
}

.header-content {
  display: flex;
  align-items: center;
  padding: 24px !important;
}

.header-icon {
  margin-right: 20px;
}

.header-text {
  flex: 1;
}

.header-title {
  margin: 0 0 8px 0;
  color: #2c3e50;
  font-size: 28px;
  font-weight: 700;
}

.header-subtitle {
  margin: 0;
  color: #6c757d;
  font-size: 16px;
}

.parametres-card {
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.parametres-header {
  background: linear-gradient(135deg, #3c80e7, #2c6cc4);
  color: white;
  border-radius: 12px 12px 0 0;
  padding: 20px 24px;
  font-size: 18px;
  font-weight: 600;
}

.format-selection {
  padding: 8px 0;
}

.format-label {
  display: block;
  margin-bottom: 12px;
  font-weight: 500;
  color: #495057;
}

.format-option {
  display: flex;
  align-items: center;
  font-size: 14px;
}

.matieres-card {
  border-radius: 8px;
}

.matieres-title {
  background: #fff3cd;
  border-bottom: 1px solid #ffeaa7;
  padding: 16px 20px;
  font-size: 16px;
  font-weight: 600;
}

.matieres-actions {
  margin-bottom: 16px;
  text-align: center;
}

.matieres-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 8px;
  max-height: 300px;
  overflow-y: auto;
  padding: 12px;
  border: 1px solid #e9ecef;
  border-radius: 6px;
  background: #f8f9fa;
}

.quick-actions-card {
  border-radius: 8px;
}

.quick-actions-title {
  background: #d4edda;
  border-bottom: 1px solid #c3e6cb;
  padding: 16px 20px;
  font-size: 16px;
  font-weight: 600;
}

.quick-actions-description {
  margin: 0 0 16px 0;
  color: #495057;
  font-size: 14px;
}

.quick-actions-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
  gap: 8px;
}

.quick-action-btn {
  height: 36px;
}

.parametres-actions {
  padding: 20px 24px;
  border-top: 1px solid #e9ecef;
}

.apercu-card {
  border-radius: 12px;
  border: 2px solid #e3f2fd;
}

.apercu-title {
  background: #e3f2fd;
  border-bottom: 1px solid #bbdefb;
  padding: 16px 20px;
  font-size: 16px;
  font-weight: 600;
}

.apercu-vide {
  text-align: center;
  padding: 40px 20px;
  color: #6c757d;
}

.apercu-vide-title {
  margin: 0 0 8px 0;
  font-size: 18px;
  color: #495057;
}

.apercu-vide-text {
  margin: 0;
  font-size: 14px;
}

.apercu-content {
  padding: 8px;
}

.apercu-section {
  display: flex;
  align-items: center;
  padding: 12px;
  margin-bottom: 8px;
  background: #f8f9fa;
  border-radius: 6px;
  border-left: 4px solid #3c80e7;
}

.apercu-label {
  font-size: 12px;
  color: #6c757d;
  font-weight: 500;
  margin-bottom: 2px;
}

.apercu-value {
  font-size: 14px;
  color: #495057;
  font-weight: 600;
}

.apercu-summary {
  text-align: center;
}

/* Responsive */
@media (max-width: 768px) {
  .parametres-container {
    padding: 12px;
    gap: 16px;
  }
  
  .header-content {
    flex-direction: column;
    text-align: center;
  }
  
  .header-icon {
    margin-right: 0;
    margin-bottom: 16px;
  }
  
  .header-title {
    font-size: 24px;
  }
  
  .matieres-grid {
    grid-template-columns: 1fr;
  }
  
  .quick-actions-grid {
    grid-template-columns: 1fr;
  }
}
</style>