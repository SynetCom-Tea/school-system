<template>
<AuthenticatedLayout>
    
  <div class="generation-documents-modern">
    <!-- En-tête avec navigation -->
    <div class="header-section">
      <div class="header-content">
        <div class="header-icon">
          <v-icon color="#3c80e7" size="32">mdi-file-cog</v-icon>
        </div>
        <div class="header-text">
          <h1 class="header-title">Génération de Documents</h1>
          <p class="header-subtitle">Créez des documents personnalisés pour votre établissement</p>
        </div>
      </div>
      <v-chip color="primary" variant="flat" prepend-icon="mdi-shield-check">
        Section {{ sectionLabel }}
      </v-chip>
    </div>

    <!-- Carte principale -->
    <v-card class="main-card" elevation="2">
      <v-card-text class="pa-6">
        <!-- Section Type de Document -->
        <div class="form-section">
          <div class="section-header">
            <v-icon color="#3c80e7" class="me-2">mdi-file-document</v-icon>
            <h3 class="section-title">Type de Document</h3>
          </div>
          <v-select
            label="Sélectionnez le type de document *"
            :items="typesDocuments"
            v-model="form.type_document"
            item-title="label"
            item-value="value"
            :item-props="itemProps"
            variant="outlined"
            color="primary"
            prepend-icon="mdi-format-list-bulleted-type"
            clearable
            required
            :hint="selectedDocumentDescription"
            persistent-hint
          >
            <template v-slot:item="{ props, item }">
              <v-list-item v-bind="props" class="document-type-item">
                <template v-slot:prepend>
                  <div class="document-icon" :style="{ backgroundColor: item.raw.color + '20' }">
                    <v-icon :color="item.raw.color" size="24">{{ item.raw.icon }}</v-icon>
                  </div>
                </template>
                <v-list-item-title class="document-title">{{ item.raw.label }}</v-list-item-title>
                <v-list-item-subtitle class="document-description">{{ item.raw.description }}</v-list-item-subtitle>
              </v-list-item>
            </template>
          </v-select>
        </div>

        <!-- Section Filtres -->
        <div class="form-section" v-if="form.type_document">
          <div class="section-header">
            <v-icon color="#4CAF50" class="me-2">mdi-filter</v-icon>
            <h3 class="section-title">Filtres de Sélection</h3>
          </div>
          
          <v-row>
            <!-- Classe -->
            <v-col cols="12" md="6">
              <v-select
                label="Classe *"
                :items="classes"
                v-model="form.classe_id"
                item-title="libelle"
                item-value="id"
                @update:model-value="chargerEleves"
                variant="outlined"
                color="primary"
                prepend-icon="mdi-account-multiple"
                clearable
                required
                :loading="chargementClasses"
                :hint="selectedClasseInfo"
                persistent-hint
              >
                <template v-slot:item="{ props, item }">
                  <v-list-item v-bind="props">
                    <template v-slot:prepend>
                      <v-avatar color="blue-lighten-5" size="36">
                        <v-icon color="blue" size="18">mdi-account-multiple</v-icon>
                      </v-avatar>
                    </template>
                    <v-list-item-title>{{ item.raw.libelle }}</v-list-item-title>
                    <v-list-item-subtitle>{{ item.raw.niveau }}</v-list-item-subtitle>
                  </v-list-item>
                </template>
              </v-select>
            </v-col>

            <!-- Élève (conditionnel) -->
            <v-col cols="12" md="6" v-if="showEleveSelector && form.classe_id">
              <v-select
                label="Sélection d'élève"
                :items="eleves"
                v-model="form.eleve_id"
                item-title="nom_complet"
                item-value="id"
                variant="outlined"
                color="primary"
                prepend-icon="mdi-account"
                :loading="chargementEleves"
                clearable
                :hint="eleveSelectionHint"
                persistent-hint
              >
                <template v-slot:item="{ props, item }">
                  <v-list-item v-bind="props" class="student-item">
                    <template v-slot:prepend>
                      <v-avatar color="green-lighten-5" size="40">
                        <v-icon color="green" size="20">mdi-account-school</v-icon>
                      </v-avatar>
                    </template>
                    <v-list-item-title class="student-name">{{ item.raw.nom_complet }}</v-list-item-title>
                    <v-list-item-subtitle class="student-info">
                      <span class="matricule">Mle: {{ item.raw.matricule }}</span>
                      <v-chip size="x-small" color="grey-lighten-2" class="ml-2">
                        {{ item.raw.classe }}
                      </v-chip>
                    </v-list-item-subtitle>
                  </v-list-item>
                </template>
                
                <template v-slot:append-item v-if="eleves.length > 5">
                  <v-divider></v-divider>
                  <v-list-item class="text-caption text-medium-emphasis text-center">
                    {{ eleves.length }} élève(s) trouvé(s)
                  </v-list-item>
                </template>
              </v-select>
            </v-col>
          </v-row>
        </div>

        <!-- Section Matières (pour relevé de notes) -->
        <div class="form-section" v-if="form.type_document === 'releve_notes' && form.classe_id">
          <div class="section-header">
            <v-icon color="#FF9800" class="me-2">mdi-book-education</v-icon>
            <h3 class="section-title">Sélection des Matières</h3>
          </div>
          
          <div class="matieres-section">
            <v-select
              label="Matières à inclure"
              :items="matieres"
              v-model="form.matieres"
              multiple
              chips
              closable-chips
              variant="outlined"
              color="orange"
              prepend-icon="mdi-book-multiple"
              clearable
              :hint="`${form.matieres.length} matière(s) sélectionnée(s)`"
              persistent-hint
            >
              <template v-slot:selection="{ item, index }">
                <v-chip
                  v-if="index < 3"
                  variant="flat"
                  color="orange-lighten-4"
                  text-color="orange-darken-3"
                  size="small"
                  closable
                  @click:close="removeMatiere(item.value)"
                >
                  {{ item.title }}
                </v-chip>
                <span
                  v-if="index === 3"
                  class="text-grey text-caption ms-2"
                >
                  +{{ form.matieres.length - 3 }} autre(s)
                </span>
              </template>
            </v-select>
            
            <div class="matieres-actions" v-if="form.matieres.length > 0">
              <v-btn 
                size="small" 
                variant="text" 
                color="orange" 
                @click="selectAllMatieres"
                prepend-icon="mdi-select-all"
              >
                Toutes
              </v-btn>
              <v-btn 
                size="small" 
                variant="text" 
                color="grey" 
                @click="clearMatieres"
                prepend-icon="mdi-close"
              >
                Aucune
              </v-btn>
            </div>
          </div>
        </div>

        <!-- Section Options -->
        <div class="form-section" v-if="form.type_document">
          <div class="section-header">
            <v-icon color="#9C27B0" class="me-2">mdi-cog</v-icon>
            <h3 class="section-title">Options du Document</h3>
          </div>
          
          <v-card variant="outlined" class="options-card">
            <v-card-text>
              <v-row>
                <v-col cols="12" md="6">
                  <div class="option-group">
                    <v-checkbox
                      v-model="form.options"
                      value="include_logo"
                      color="primary"
                      density="comfortable"
                    >
                      <template v-slot:label>
                        <div class="option-label">
                          <v-icon color="primary" size="20" class="me-2">mdi-image</v-icon>
                          <div>
                            <div class="option-title">Logo de l'établissement</div>
                            <div class="option-description">Inclure le logo en en-tête</div>
                          </div>
                        </div>
                      </template>
                    </v-checkbox>
                    
                    <v-checkbox
                      v-model="form.options"
                      value="include_signature"
                      color="primary"
                      density="comfortable"
                    >
                      <template v-slot:label>
                        <div class="option-label">
                          <v-icon color="primary" size="20" class="me-2">mdi-signature</v-icon>
                          <div>
                            <div class="option-title">Zone de signature</div>
                            <div class="option-description">Ajouter une ligne pour signature</div>
                          </div>
                        </div>
                      </template>
                    </v-checkbox>
                  </div>
                </v-col>
                
                <v-col cols="12" md="6">
                  <div class="option-group">
                    <v-checkbox
                      v-model="form.options"
                      value="include_date"
                      color="primary"
                      density="comfortable"
                    >
                      <template v-slot:label>
                        <div class="option-label">
                          <v-icon color="primary" size="20" class="me-2">mdi-calendar</v-icon>
                          <div>
                            <div class="option-title">Date de génération</div>
                            <div class="option-description">Afficher la date du document</div>
                          </div>
                        </div>
                      </template>
                    </v-checkbox>
                    
                    <v-checkbox
                      v-model="form.options"
                      value="include_page_numbers"
                      color="primary"
                      density="comfortable"
                    >
                      <template v-slot:label>
                        <div class="option-label">
                          <v-icon color="primary" size="20" class="me-2">mdi-file-document</v-icon>
                          <div>
                            <div class="option-title">Numérotation des pages</div>
                            <div class="option-description">Ajouter les numéros de page</div>
                          </div>
                        </div>
                      </template>
                    </v-checkbox>
                  </div>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </div>

        <!-- Résumé de la génération -->
        <div class="summary-section" v-if="formValide">
          <v-alert
            color="primary"
            variant="tonal"
            border
            class="mb-4"
          >
            <template v-slot:prepend>
              <v-icon color="primary">mdi-information</v-icon>
            </template>
            <div class="summary-content">
              <div class="summary-title">Résumé de la génération</div>
              <div class="summary-details">
                <div class="summary-item">
                  <v-icon size="16" color="primary" class="me-1">mdi-file-document</v-icon>
                  <strong>{{ selectedDocumentLabel }}</strong>
                </div>
                <div class="summary-item">
                  <v-icon size="16" color="green" class="me-1">mdi-account-group</v-icon>
                  {{ selectedClasseLabel }} 
                  <span v-if="form.eleve_id">- 1 élève sélectionné</span>
                  <span v-else>- {{ eleves.length }} élèves</span>
                </div>
                <div v-if="form.type_document === 'releve_notes'" class="summary-item">
                  <v-icon size="16" color="orange" class="me-1">mdi-book-multiple</v-icon>
                  {{ form.matieres.length || matieres.length }} matière(s)
                </div>
              </div>
            </div>
          </v-alert>
        </div>
      </v-card-text>

      <!-- Actions -->
      <v-card-actions class="actions-section pa-4">
        <v-btn
          variant="text"
          color="grey"
          @click="reinitialiser"
          prepend-icon="mdi-refresh"
          :disabled="loading"
        >
          Réinitialiser
        </v-btn>
        
        <v-spacer></v-spacer>
        
        <v-btn
          color="primary"
          @click="genererDocument"
          :loading="loading"
          :disabled="!formValide"
          prepend-icon="mdi-download"
          size="large"
          class="generate-btn"
        >
          <template v-slot:loader>
            <v-progress-circular
              indeterminate
              size="20"
              width="2"
              color="white"
            ></v-progress-circular>
            <span class="ml-2">Génération...</span>
          </template>
          Générer le Document
        </v-btn>
      </v-card-actions>
    </v-card>

    <!-- Indicateur de statut -->
    <div class="status-indicator" v-if="loading">
      <v-progress-linear
        indeterminate
        color="primary"
        height="4"
      ></v-progress-linear>
      <div class="status-text text-caption text-center pa-2">
        Génération du document en cours...
      </div>
    </div>
  </div>
</AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router, useForm } from "@inertiajs/vue3";
import { computed } from "vue";
import { HalfCircleSpinner } from 'epic-spinners'
import {
  mdiChevronLeft,
  mdiChevronRight,
  mdiChevronDown,
  mdiAccountCircle,
  mdiAccountSchool,
  mdiCurrencyUsd,
  mdiDelete,
  mdiCash,
  mdiPrinter,
  mdiPlus,
  mdiClose,
  mdiMagnify,
  mdiSort,
  mdiArrowDown,
  mdiArrowUp,
  mdiHeart,
  mdiMinus,
  mdiCheck,
  mdiPencil,
  mdiAlertCircle,
  mdiFile,
} from "@mdi/js";
export default {
  name: 'GenerationDocumentsModern',
  props: {
    section: {
      type: String,
      required: true
    },
    classes: {
      type: Array,
      default: () => []
    },
    matieres: {
      type: Array,
      default: () => []
    },
    typesDocuments: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
      form: {
        type_document: '',
        classe_id: null,
        eleve_id: null,
        matieres: [],
        options: ['include_logo', 'include_signature', 'include_date', 'include_page_numbers']
      },
      eleves: [],
      chargementEleves: false,
      chargementClasses: false,
      loading: false
    }
  },
  computed: {
    formValide() {
      return this.form.type_document && this.form.classe_id;
    },
    showEleveSelector() {
      return ['certificat_scolarite', 'releve_notes'].includes(this.form.type_document);
    },
    selectedDocumentLabel() {
      const doc = this.typesDocuments.find(d => d.value === this.form.type_document);
      return doc ? doc.label : '';
    },
    selectedDocumentDescription() {
      const doc = this.typesDocuments.find(d => d.value === this.form.type_document);
      return doc ? doc.description : 'Sélectionnez un type de document';
    },
    selectedClasseLabel() {
      const classe = this.classes.find(c => c.id === this.form.classe_id);
      return classe ? classe.libelle : '';
    },
    selectedClasseInfo() {
      const classe = this.classes.find(c => c.id === this.form.classe_id);
      return classe ? `${classe.libelle} - ${classe.niveau}` : 'Sélectionnez une classe';
    },
    eleveSelectionHint() {
      if (this.form.eleve_id) {
        return 'Document généré pour un seul élève';
      }
      return this.eleves.length > 0 ? 
        `Laisser vide pour générer pour tous les élèves (${this.eleves.length})` : 
        'Aucun élève trouvé dans cette classe';
    },
    sectionLabel() {
      const sections = {
        '1': 'Primaire',
        '2': 'Secondaire', 
        '3': 'Supérieure',
        '4': 'Universitaire'
      };
      return sections[this.section] || this.section;
    }
  },
  methods: {
    itemProps(item) {
         const iconMapping = {
        'mdi-account-group': 'mdi-account-multiple',
        'mdi-file-document': 'mdi-file-document',
        'mdi-book-account': 'mdi-book-account',
        'mdi-folder-account': 'mdi-folder-account',
        'mdi-certificate': 'mdi-certificate',
        'mdi-cogs': 'mdi-cog'
    };
      return {
        title: item.label,
        subtitle: item.description,
        prependIcon: item.icon,
        color: item.color
      }
    },
    
    async chargerEleves() {
      if (!this.form.classe_id) {
        this.eleves = [];
        this.form.eleve_id = null;
        return;
      }

      this.chargementEleves = true;
      try {
        const response = await axios.get(`/scolarite/eleves/classe/${this.form.classe_id}`);
        this.eleves = response.data;
        this.form.eleve_id = null;
      } catch (error) {
        console.error('Erreur chargement élèves:', error);
        this.eleves = [];
        this.$toast.error('Erreur lors du chargement des élèves');
      } finally {
        this.chargementEleves = false;
      }
    },
    
    removeMatiere(matiere) {
      this.form.matieres = this.form.matieres.filter(m => m !== matiere);
    },
    
    selectAllMatieres() {
      this.form.matieres = [...this.matieres];
    },
    
    clearMatieres() {
      this.form.matieres = [];
    },
    
    reinitialiser() {
      this.form = {
        type_document: '',
        classe_id: null,
        eleve_id: null,
        matieres: [],
        options: ['include_logo', 'include_signature', 'include_date', 'include_page_numbers']
      };
      this.eleves = [];
    },
    
    async genererDocument() {
      if (!this.formValide) {
        this.$toast.warning('Veuillez remplir tous les champs obligatoires');
        return;
      }

      this.loading = true;
      try {
        const params = {
          ...this.form,
          section: this.section
        };

        const response = await axios.post('/scolarite/generer-document-parametrable', params, {
          responseType: 'blob',
          headers: {
            'Content-Type': 'application/json'
          },
          timeout: 60000 // 60 secondes timeout
        });
        
        // Extraire le nom du fichier
        const contentDisposition = response.headers['content-disposition'];
        let fileName = 'document.pdf';
        if (contentDisposition) {
          const fileNameMatch = contentDisposition.match(/filename="(.+)"/);
          if (fileNameMatch) {
            fileName = fileNameMatch[1];
          }
        }
        
        // Créer et télécharger le fichier
        const blob = new Blob([response.data], { type: 'application/pdf' });
        const url = window.URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', fileName);
        document.body.appendChild(link);
        link.click();
        link.remove();
        window.URL.revokeObjectURL(url);
        
        this.$toast.success('Document généré avec succès !');
        
      } catch (error) {
        console.error('Erreur génération document:', error);
        let message = 'Erreur lors de la génération du document';
        
        if (error.response && error.response.data) {
          if (error.response.data instanceof Blob) {
            const errorText = await error.response.data.text();
            try {
              const errorJson = JSON.parse(errorText);
              message = errorJson.error || message;
            } catch {
              message = errorText || message;
            }
          } else {
            message = error.response.data.error || message;
          }
        } else if (error.code === 'ECONNABORTED') {
          message = 'La génération a pris trop de temps. Veuillez réessayer.';
        }
        
        this.$toast.error(message);
      } finally {
        this.loading = false;
      }
    }
  },
  
  watch: {
    'form.type_document'() {
      // Réinitialiser les sélections quand le type de document change
      this.form.eleve_id = null;
      this.form.matieres = [];
    },
    
    'form.classe_id'() {
      // Réinitialiser la sélection d'élève quand la classe change
      this.form.eleve_id = null;
    }
  }
}
</script>

<style scoped>
.generation-documents-modern {
  max-width: 1000px;
  margin: 0 auto;
  padding: 20px;
}

/* En-tête */
.header-section {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
  padding: 20px;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 12px;
  color: white;
}

.header-content {
  display: flex;
  align-items: center;
  gap: 16px;
}

.header-icon {
  background: rgba(255, 255, 255, 0.2);
  padding: 12px;
  border-radius: 12px;
  backdrop-filter: blur(10px);
}

.header-title {
  font-size: 1.5rem;
  font-weight: 600;
  margin: 0;
  color: white;
}

.header-subtitle {
  margin: 4px 0 0 0;
  opacity: 0.9;
  font-size: 0.9rem;
}

/* Carte principale */
.main-card {
  border-radius: 12px;
  overflow: hidden;
}

/* Sections du formulaire */
.form-section {
  margin-bottom: 32px;
}

.section-header {
  display: flex;
  align-items: center;
  margin-bottom: 16px;
  padding-bottom: 12px;
  border-bottom: 2px solid #f5f5f5;
}

.section-title {
  font-size: 1.1rem;
  font-weight: 600;
  color: #2c3e50;
  margin: 0;
}

/* Types de documents */
.document-type-item {
  border-radius: 8px;
  margin: 4px 0;
}

.document-icon {
  width: 40px;
  height: 40px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 12px;
}

.document-title {
  font-weight: 500;
  font-size: 0.95rem;
}

.document-description {
  font-size: 0.8rem;
  opacity: 0.7;
}

/* Élèves */
.student-item {
  border-left: 3px solid #4CAF50;
  margin: 2px 0;
}

.student-name {
  font-weight: 500;
  font-size: 0.9rem;
}

.student-info {
  display: flex;
  align-items: center;
  font-size: 0.8rem;
}

.matricule {
  font-family: 'Courier New', monospace;
  background: #f5f5f5;
  padding: 2px 6px;
  border-radius: 4px;
}

/* Matières */
.matieres-section {
  position: relative;
}

.matieres-actions {
  display: flex;
  gap: 8px;
  margin-top: 8px;
}

/* Options */
.options-card {
  border-radius: 8px;
}

.option-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.option-label {
  display: flex;
  align-items: flex-start;
  gap: 8px;
}

.option-title {
  font-weight: 500;
  font-size: 0.9rem;
}

.option-description {
  font-size: 0.8rem;
  opacity: 0.7;
  margin-top: 2px;
}

/* Résumé */
.summary-content {
  padding: 8px 0;
}

.summary-title {
  font-weight: 600;
  margin-bottom: 8px;
  font-size: 0.95rem;
}

.summary-details {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.summary-item {
  display: flex;
  align-items: center;
  font-size: 0.85rem;
}

/* Actions */
.actions-section {
  background: #f8f9fa;
  border-top: 1px solid #e9ecef;
}

.generate-btn {
  min-width: 200px;
  font-weight: 600;
}

/* Indicateur de statut */
.status-indicator {
  margin-top: 16px;
  border-radius: 8px;
  overflow: hidden;
  background: #f8f9fa;
}

.status-text {
  background: #e3f2fd;
  color: #1565c0;
}

/* Responsive */
@media (max-width: 768px) {
  .generation-documents-modern {
    padding: 16px;
  }
  
  .header-section {
    flex-direction: column;
    gap: 12px;
    text-align: center;
  }
  
  .header-content {
    flex-direction: column;
    text-align: center;
  }
  
  .summary-details {
    flex-direction: column;
  }
  
  .generate-btn {
    min-width: auto;
    width: 100%;
  }
}

/* Animations */
.v-select {
  transition: all 0.3s ease;
}

.v-select:focus-within {
  transform: translateY(-1px);
}

/* États de chargement */
.v-progress-linear {
  border-radius: 4px;
}

/* Amélioration des chips */
.v-chip {
  transition: all 0.2s ease;
}

.v-chip:hover {
  transform: scale(1.05);
}
</style>