<template>
  <AuthenticatedLayout>
    <div>
      <!-- Header simple -->
      <div style="color: black; padding: 20px; background: #f5f5f5; border-radius: 8px; margin-bottom: 20px;">
        <h1 style="margin: 0; display: flex; align-items: center;">
          <span style="margin-right: 10px; font-size: 24px;">👤</span>
          MODIFICATION INSCRIPTION - {{ inscription.apprenant?.nom }} {{ inscription.apprenant?.prenom }}
        </h1>
      </div>

      <div style="padding: 20px;">
        <!-- Navigation par onglets avec classes CSS -->
        <div class="tab-navigation">
          <button 
            @click="activeTab = 'apprenant'" 
            :class="['tab-button', { 'active': activeTab === 'apprenant' }]"
          >
            Informations Élève
          </button>
          <button 
            @click="activeTab = 'academique'" 
            :class="['tab-button', { 'active': activeTab === 'academique' }]"
          >
            Année Académique
          </button>
          <button 
            @click="activeTab = 'tuteurs'" 
            :class="['tab-button', { 'active': activeTab === 'tuteurs' }]"
          >
            Tuteurs
          </button>
          <button 
            @click="activeTab = 'documents'" 
            :class="['tab-button', { 'active': activeTab === 'documents' }]"
          >
            Documents
          </button>
        </div>

        <!-- Onglet Informations élève -->
        <div v-if="activeTab === 'apprenant'" style="border: 1px solid #ddd; padding: 20px; border-radius: 8px;">
          <h2 style="color: #7d002c;">Modifier les informations de l'élève</h2>
          <div style="margin: 10px">
            <v-alert
              v-model="alertFirst"
              border="start"
              variant="tonal"
              closable
              close-label="Close Alert"
              color="primary"
              type="info"
              title="Note"
            >
              <li>
                Le formulaire sera valide <strong>si et seulement si </strong>tous les
                champs obligatoires marqués par <span style="color: red">*</span> sont
                renseignés
              </li>
            </v-alert>

            <div v-if="!alertFirst" style="margin: auto; width: 50%; padding: 10px">
              <button
                style="height: 30px; background: #1976d2; color: white; border: none; padding: 5px 15px; border-radius: 4px; cursor: pointer;"
                @click="alertFirst = true"
              >
                Relire la note
              </button>
            </div>
          </div>
          
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <!-- Nom -->
            <div>
              <label style="display: block; margin-bottom: 5px; font-weight: bold;">
                Nom *
              </label>
              <input 
                type="text" 
                v-model="formApprenant.nom"
                style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                placeholder="Nom de l'élève"
              >
            </div>

            <!-- Prénom -->
            <div>
              <label style="display: block; margin-bottom: 5px; font-weight: bold;">
                Prénom *
              </label>
              <input 
                type="text" 
                v-model="formApprenant.prenom"
                style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                placeholder="Prénom de l'élève"
              >
            </div>

            <!-- Sexe -->
            <div>
              <label style="display: block; margin-bottom: 5px; font-weight: bold;">
                Sexe *
              </label>
              <select 
                v-model="formApprenant.sexe"
                style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
              >
                <option value="">Sélectionner</option>
                <option value="Masculin">Masculin</option>
                <option value="Féminin">Féminin</option>
              </select>
            </div>

            <!-- Date de naissance -->
            <div>
              <label style="display: block; margin-bottom: 5px; font-weight: bold;">
                Date de naissance
              </label>
              <input 
                type="date" 
                v-model="formApprenant.date_naissance"
                style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
              >
            </div>

            <!-- Lieu de naissance -->
            <div>
              <label style="display: block; margin-bottom: 5px; font-weight: bold;">
                Lieu de naissance
              </label>
              <input 
                type="text" 
                v-model="formApprenant.lieu_naissance"
                style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                placeholder="Lieu de naissance"
              >
            </div>

            <!-- Téléphone -->
            <div>
              <label style="display: block; margin-bottom: 5px; font-weight: bold;">
                Téléphone
              </label>
              <input 
                type="text" 
                v-model="formApprenant.telephone"
                style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                placeholder="Téléphone"
              >
            </div>
          </div>
        </div>

        <!-- Onglet Année académique -->
        <div v-if="activeTab === 'academique'" style="border: 1px solid #ddd; padding: 20px; border-radius: 8px;">
          <h2 style="color: #7d002c;">Modifier l'année académique</h2>
          <div style="margin: 10px">
            <v-alert
              v-model="alertFirst"
              border="start"
              variant="tonal"
              closable
              close-label="Close Alert"
              color="primary"
              type="info"
              title="Note"
            >
              <li>
                Le formulaire sera valide <strong>si et seulement si </strong>tous les
                champs obligatoires marqués par <span style="color: red">*</span> sont
                renseignés
              </li>
            </v-alert>

            <div v-if="!alertFirst" style="margin: auto; width: 50%; padding: 10px">
              <button
                style="height: 30px; background: #1976d2; color: white; border: none; padding: 5px 15px; border-radius: 4px; cursor: pointer;"
                @click="alertFirst = true"
              >
                Relire la note
              </button>
            </div>
          </div>
          <!-- Affichage de la classe actuelle -->
          <div v-if="classe_actuelle" style="background: #e8f5e8; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <h3 style="color: #2e7d32; margin: 0 0 10px 0;">📚 Classe actuelle</h3>
            <p style="margin: 5px 0;"><strong>Classe:</strong> {{ classe_actuelle.libelle }} ({{ classe_actuelle.code }})</p>
            <p style="margin: 5px 0;"><strong>Année:</strong> {{ annee_classe_actuelle?.libelle }}</p>
          </div>

          <!-- Carte d'information de l'élève -->
          <v-row style="margin-bottom: 20px;">
            <v-col md="1"></v-col>
            <v-col md="3">
              <v-card>
                <v-card-title class="subheading font-weight-bold">
                  {{ inscription.apprenant?.matricule || 'Élève' }}
                </v-card-title>
                <v-divider></v-divider>
                <v-list density="compact">
                  <v-list-item title="Nom & Prénom">
                    <v-list-item-subtitle>
                      {{ inscription.apprenant?.nom }} {{ inscription.apprenant?.prenom }}
                    </v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item title="Date et lieu de naissance">
                    <v-list-item-subtitle>
                      {{ formatDate(inscription.apprenant?.date_naissance) }} - {{ inscription.apprenant?.lieu_naissance }}
                    </v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item title="Téléphone">
                    <v-list-item-subtitle>
                      {{ inscription.apprenant?.telephone }}
                    </v-list-item-subtitle>
                  </v-list-item>
                </v-list>
              </v-card>
            </v-col>
            <v-col md="7">
              <v-row>
                <v-col cols="1"></v-col>
                <v-col :cols="type == '1' || type == '2' ? 4 : 3">
                  <label style="display: block; margin-bottom: 5px; font-weight: bold;">
                    Année académique *
                  </label>
                  <select 
                    v-model="formAnnee.annee"
                    style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                  >
                    <option value="">Sélectionner une année</option>
                    <option v-for="annee in annees" :key="annee.id" :value="annee.id">
                      {{ annee.libelle }}
                    </option>
                  </select>
                  <small v-if="formAnnee.annee" style="color: green;">
                    Actuel: {{ getAnneeLibelle(formAnnee.annee) }}
                  </small>
                </v-col>

                <v-col :cols="type == '1' || type == '2' ? 4 : 3">
                  <label style="display: block; margin-bottom: 5px; font-weight: bold;">
                    Niveau *
                  </label>
                  <select 
                    v-model="formAnnee.niveau"
                    style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                    @change="checkClasseExist(formAnnee.niveau)"
                  >
                    <option value="">Sélectionner un niveau</option>
                    <option v-for="niveau in niveaux" :key="niveau.id" :value="niveau.id">
                      {{ niveau.libelle }}
                    </option>
                  </select>
                  <small v-if="formAnnee.niveau" style="color: green;">
                    Actuel: {{ getNiveauLibelle(formAnnee.niveau) }}
                  </small>
                </v-col>

                <v-col cols="1"></v-col>
              </v-row>

              <v-row>
                <v-col cols="1"></v-col>
                
                <!-- Sélecteur de classe -->
                <v-col :cols="mdClasse" v-if="resultClasse.length > 0">
                  <label style="display: block; margin-bottom: 5px; font-weight: bold;">
                    Classe *
                  </label>
                  <select 
                    v-model="formAnnee.classe"
                    style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                  >
                    <option value="">Sélectionner une classe</option>
                    <option v-for="classe in resultClasse" :key="classe.classe.classe.id" :value="classe.classe.classe.id">
                      {{ classe.classe.classe.libelle }} ({{ classe.nbre }} élève(s))
                    </option>
                  </select>
                  <small v-if="formAnnee.classe" style="color: green;">
                    Actuel: {{ getCurrentClasseLibelle(formAnnee.classe) }}
                  </small>
                </v-col>

                <v-col cols="1"></v-col>
              </v-row>
            </v-col>
          </v-row>

          <!-- Message si aucune classe disponible -->
          <div v-if="formAnnee.niveau && resultClasse.length === 0" style="background: #fff3cd; padding: 15px; border-radius: 8px; margin-top: 20px;">
            <h4 style="color: #856404; margin: 0 0 10px 0;">ℹ️ Aucune classe disponible</h4>
            <p style="margin: 0; color: #856404;">
              Aucune classe n'existe pour ce niveau. Une nouvelle classe sera automatiquement créée lors de l'enregistrement.
            </p>
          </div>

          <!-- Avertissement si classe pleine -->
          <div v-if="resultClasse.length > 0 && resultClasse[resultClasse.length - 1]?.nbre >= nbre_limite_eleve" 
               style="background: #f8d7da; padding: 15px; border-radius: 8px; margin-top: 20px;">
            <h4 style="color: #721c24; margin: 0 0 10px 0;">⚠️ Classe pleine</h4>
            <p style="margin: 0; color: #721c24;">
              La classe "{{ resultClasse[resultClasse.length - 1].classe.classe.code }}" est pleine ({{ resultClasse[resultClasse.length - 1].nbre }} élèves).
              Voulez-vous <a href="#" @click.prevent="creerNouvelleClasse" style="color: #004980; text-decoration: underline;">créer une nouvelle classe</a> ?
            </p>
          </div>
        </div>

        <!-- Onglet Tuteurs -->
        <div v-if="activeTab === 'tuteurs'" style="border: 1px solid #ddd; padding: 20px; border-radius: 8px;">
          <h2 style="color: #7d002c;">Modifier les tuteurs</h2>
          <div style="margin: 10px">
            <v-alert
              v-model="alertFirst"
              border="start"
              variant="tonal"
              closable
              close-label="Close Alert"
              color="primary"
              type="info"
              title="Note"
            >
              <li>
                Le formulaire sera valide <strong>si et seulement si </strong>tous les
                champs obligatoires marqués par <span style="color: red">*</span> sont
                renseignés
              </li>
            </v-alert>

            <div v-if="!alertFirst" style="margin: auto; width: 50%; padding: 10px">
              <button
                style="height: 30px; background: #1976d2; color: white; border: none; padding: 5px 15px; border-radius: 4px; cursor: pointer;"
                @click="alertFirst = true"
              >
                Relire la note
              </button>
            </div>
          </div>
          <!-- Message si pas de tuteurs -->
          <div v-if="formTuteurs.tuteurs.length === 0" style="background: #fff3cd; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <p style="margin: 0; color: #856404;">Aucun tuteur trouvé. Veuillez en ajouter un.</p>
          </div>
          
          <div v-for="(tuteur, index) in formTuteurs.tuteurs" :key="index" 
               style="border: 1px solid #e0e0e0; padding: 15px; margin-bottom: 15px; border-radius: 8px;">
            <h4 style="margin-top: 0; color: #7d002c;">Tuteur {{ index + 1 }}</h4>
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 10px; align-items: end;">
              <!-- Nom tuteur -->
              <div>
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">
                  Nom *
                </label>
                <input 
                  type="text" 
                  v-model="tuteur.nom"
                  style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                  placeholder="Nom du tuteur"
                >
              </div>

              <!-- Prénom tuteur -->
              <div>
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">
                  Prénom *
                </label>
                <input 
                  type="text" 
                  v-model="tuteur.prenom"
                  style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                  placeholder="Prénom du tuteur"
                >
              </div>

              <!-- Téléphone tuteur -->
              <div>
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">
                  Téléphone *
                </label>
                <input 
                  type="text" 
                  v-model="tuteur.telephone"
                  style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                  placeholder="Téléphone"
                >
              </div>

              <!-- Bouton supprimer -->
              <div>
                <button 
                  @click="removeTuteur(index)"
                  style="background: #ff4444; color: white; border: none; padding: 8px 12px; border-radius: 4px; cursor: pointer;"
                  :disabled="formTuteurs.tuteurs.length === 1"
                  :title="formTuteurs.tuteurs.length === 1 ? 'Au moins un tuteur est requis' : 'Supprimer ce tuteur'"
                >
                  ×
                </button>
              </div>
            </div>
            
            <!-- Champs supplémentaires pour le tuteur -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 10px;">
              <!-- Sexe tuteur -->
              <div>
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">
                  Sexe
                </label>
                <select 
                  v-model="tuteur.sexe"
                  style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                >
                  <option value="">Sélectionner</option>
                  <option value="Masculin">Masculin</option>
                  <option value="Féminin">Féminin</option>
                </select>
              </div>

              <!-- Email tuteur -->
              <div>
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">
                  Email
                </label>
                <input 
                  type="email" 
                  v-model="tuteur.email"
                  style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                  placeholder="Email"
                >
              </div>
            </div>
          </div>

          <button 
            @click="addTuteur"
            style="background: #1976d2; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; margin-top: 10px;"
            :disabled="formTuteurs.tuteurs.length >= 3"
          >
            + Ajouter un tuteur ({{ formTuteurs.tuteurs.length }}/3)
          </button>
        </div>

        <!-- Onglet Documents -->
        <div v-if="activeTab === 'documents'" style="border: 1px solid #ddd; padding: 20px; border-radius: 8px;">
          <h2 style="color: #7d002c;">INFORMATIONS SUR LES DOCUMENTS</h2>
          
          <div style="margin: 10px">
            <v-alert
              v-model="alertFirst"
              border="start"
              variant="tonal"
              closable
              close-label="Close Alert"
              color="primary"
              type="info"
              title="Note"
            >
              <li>
                Le formulaire sera valide <strong>si et seulement si </strong>tous les
                champs obligatoires marqués par <span style="color: red">*</span> sont
                renseignés
              </li>
            </v-alert>

            <div v-if="!alertFirst" style="margin: auto; width: 50%; padding: 10px">
              <button
                style="height: 30px; background: #1976d2; color: white; border: none; padding: 5px 15px; border-radius: 4px; cursor: pointer;"
                @click="alertFirst = true"
              >
                Relire la note
              </button>
            </div>
          </div>

          <!-- Documents existants -->
          <div v-if="documentsExistants && documentsExistants.length > 0" style="margin-bottom: 30px;">
            <h3 style="color: #7d002c;">📄 Documents existants</h3>
            <div v-for="(document, index) in documentsExistants" :key="document.id" 
                style="border: 1px solid #e0e0e0; padding: 15px; margin-bottom: 15px; border-radius: 8px; background: #f9f9f9;">
              <div style="display: flex; justify-content: space-between; align-items: center;">
                <div style="flex: 1;">
                  <p style="margin: 0 0 5px 0; font-weight: bold;">
                    {{ getTypeDocumentLibelle(document.type_document_id) }}
                  </p>
                  <p style="margin: 0; color: #666;">
                    Fichier: {{ document.file_name || document.file }}
                  </p>
                  <p style="margin: 5px 0 0 0;">
                    <a v-if="document.file_url" :href="document.file_url" target="_blank" 
                      style="color: #1976d2; text-decoration: none;">
                      📎 Voir le document
                    </a>
                    <span v-else style="color: #999;">
                      📎 Aucun fichier disponible
                    </span>
                  </p>
                </div>
                <div>
                  <button 
                    @click="supprimerDocumentExistant(document.id, index)"
                    style="background: #ff4444; color: white; border: none; padding: 8px 12px; border-radius: 4px; cursor: pointer;"
                    title="Supprimer ce document"
                  >
                    × Supprimer
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Message si aucun document existant -->
          <div v-else-if="documentsExistants && documentsExistants.length === 0" style="margin-bottom: 20px; padding: 15px; background: #f5f5f5; border-radius: 8px;">
            <p style="margin: 0; color: #666; text-align: center;">
              Aucun document existant pour cet apprenant.
            </p>
          </div>

          <!-- Ajouter de nouveaux documents -->
          <div style="margin-top: 30px;">
            <h3 style="color: #7d002c;">➕ Ajouter de nouveaux documents</h3>
            
            <div v-for="(document, i) in formDocuments.documents" :key="i" style="margin-bottom: 20px; padding: 15px; border: 1px dashed #ccc; border-radius: 8px;">
              <div style="display: flex; align-items: start; gap: 20px;">
                <div style="flex: 1;">
                  <label style="display: block; margin-bottom: 5px; font-weight: bold;">
                    Type de fichier <span style="color: red">*</span>
                  </label>
                  <select 
                    v-model="document.type"
                    style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;"
                    @change="verify(document)"
                  >
                    <option value="">Sélectionner un type</option>
                    <option v-for="typeDoc in typeDocuments" :key="typeDoc.id" :value="typeDoc.type_document?.id">
                      {{ typeDoc.type_document?.libelle || 'Type inconnu' }}
                    </option>
                  </select>
                  <small v-if="!typeDocuments || typeDocuments.length === 0" style="color: orange;">
                    Aucun type de document disponible
                  </small>
                </div>
                
                <div style="flex: 1;">
                  <label style="display: block; margin-bottom: 5px; font-weight: bold;">
                    Fichier <span style="color: red">*</span>
                  </label>
                  <input 
                    type="file" 
                    @change="onFileChange($event, i)"
                    style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                    accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                  >
                  <small v-if="document.file_name" style="color: green;">
                    ✓ Fichier sélectionné: {{ document.file_name }}
                  </small>
                </div>
                
                <div style="margin-top: 25px;">
                  <button
                    type="button"
                    v-if="formDocuments.documents.length >= 2"
                    @click="removeDocument(i)"
                    style="background: #ff4444; color: white; border: none; padding: 10px 12px; border-radius: 4px; cursor: pointer;"
                    title="Supprimer cette ligne"
                  >
                    ×
                  </button>
                  <button
                    v-else
                    style="background: #ccc; color: white; border: none; padding: 10px 12px; border-radius: 4px; cursor: not-allowed;"
                    disabled
                    title="Impossible de supprimer - doit garder au moins un document"
                  >
                    ×
                  </button>
                </div>
              </div>
            </div>
            
            <div style="text-align: right; margin-top: 20px;">
              <button
                type="button"
                @click="addDocument"
                style="background: #1976d2; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-weight: bold;"
                title="Ajouter une nouvelle ligne"
              >
                + Ajouter un document
              </button>
            </div>
          </div>
        </div>

        <!-- Boutons d'action -->
        <div style="margin-top: 30px; display: flex; gap: 10px; justify-content: flex-end;">
          <button class="btn-cancel" @click="goBack">
            Annuler
          </button>
          <button class="btn-save" @click="submitForm">
            Enregistrer
          </button>
        </div>

        <!-- Debug -->
        <div v-if="debug" class="debug-section">
          <h3>Debug - Données actuelles:</h3>
          <pre>{{ JSON.stringify({
            apprenant: formApprenant,
            annee: formAnnee,
            tuteurs: formTuteurs,
            documents: formDocuments,
            documentsExistants: documentsExistants,
            classe_actuelle: classe_actuelle,
            annee_classe_actuelle: annee_classe_actuelle,
            resultClasse: resultClasse
          }, null, 2) }}</pre>
        </div>
      </div>
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
    inscription: {
      type: Object,
      default: () => ({})
    },
    type: [String, Number],
    niveaux: Array,
    cycles: Array,
    cycleFilieres: Array,
    typeFrais: Array,
    annees: Array,
    typeDocuments: {
      type: Array,
      default: () => []
    },
    documentsExistants: {
      type: Array,
      default: () => []
    },
    tuteurs: Array,
    classe_actuelle: Object,
    annee_classe_actuelle: Object,
    documents_apprenant: Array,
    nbre_limite_eleve: Number
  },
  data() {
    return {
      activeTab: 'apprenant',
      debug: false,
      alertFirst: true,
      tooltipModel: false,
      formApprenant: {
        nom: '',
        prenom: '',
        sexe: '',
        date_naissance: '',
        lieu_naissance: '',
        telephone: '',
      },
      formAnnee: {
        annee: null,
        niveau: null,
        classe: null
      },
      formTuteurs: {
        tuteurs: []
      },
      formDocuments: {
        documents: [],
        documents_supprimes: []
      },
      resultClasse: [],
      mdClasse: 4,
      etablissement_section_id: null
    };
  },
  computed: {
    // SUPPRIMEZ la computed property Title qui cause l'erreur
    // OU définissez section_id si nécessaire
  },
  methods: {
    
    // MÉTHODES ANNÉE ACADÉMIQUE
    async checkClasseExist(niveau) {
      if (niveau) {
        try {
          const response = await axios.get(
            route("getcheckClasse", {
              niveau: niveau,
              etabSection: this.etablissement_section_id
            })
          );
          
          console.log('Réponse API classes:', response.data);
          
          if (response.data === "ERREUR") {
            this.resultClasse = [];
          } else if(response.data.code == 1){
            this.resultClasse = response.data.result ?? [];
          } else {
            this.resultClasse = [];
          }

          if(this.resultClasse.length == 0){
            this.mdClasse = 0;
          } else {
            this.mdClasse = 4;
          }

          if(this.resultClasse.length > 0 && this.resultClasse[this.resultClasse.length - 1]?.nbre >= this.nbre_limite_eleve){
            this.$swal({
              title: 'Création d\'une nouvelle classe?',
              text: "Voulez-vous créer une nouvelle classe car ''" + this.resultClasse[this.resultClasse.length - 1].classe.classe.code + "'' est pleine !",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#004980',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Oui, créer!',
              cancelButtonText: 'Non!',
            }).then((result) => {
              if (result.isConfirmed) {
                router.get(route('classes.index', {type: this.type}));
              }
            });
          }

        } catch (error) {
          console.error('Erreur lors de la récupération des classes:', error);
          this.resultClasse = [];
        }
      }
    },

    creerNouvelleClasse() {
      router.get(route('classes.index', {type: this.type}));
    },

    getCurrentClasseLibelle(classeId) {
      const classe = this.resultClasse.find(c => c.classe.classe.id === classeId);
      return classe ? `${classe.classe.classe.libelle} (${classe.nbre} élève(s))` : 'Non trouvée';
    },

    formatDate(dateString) {
      if (!dateString) return '';
      const date = new Date(dateString);
      return date.toLocaleDateString('fr-FR');
    },

    // AJOUTEZ ces méthodes manquantes
    getAnneeLibelle(anneeId) {
      if (!this.annees || !Array.isArray(this.annees)) return 'Non trouvée';
      const annee = this.annees.find(a => a.id === anneeId);
      return annee ? annee.libelle : 'Non trouvée';
    },

    getNiveauLibelle(niveauId) {
      if (!this.niveaux || !Array.isArray(this.niveaux)) return 'Non trouvé';
      const niveau = this.niveaux.find(n => n.id === niveauId);
      return niveau ? niveau.libelle : 'Non trouvé';
    },

    // MÉTHODES TUTEURS
    addTuteur() {
      if (this.formTuteurs.tuteurs.length < 3) {
        this.formTuteurs.tuteurs.push({
          nom: '',
          prenom: '',
          telephone: '',
          sexe: '',
          email: ''
        });
      }
    },

    removeTuteur(index) {
      if (this.formTuteurs.tuteurs.length > 1) {
        this.formTuteurs.tuteurs.splice(index, 1);
      }
    },

    // MÉTHODES DOCUMENTS
    addDocument() {
      this.formDocuments.documents.push({
        type: null,
        file: null,
        file_name: ''
      });
    },

    removeDocument(index) {
      this.formDocuments.documents.splice(index, 1);
    },

    // onFileChange(event, index) {
    //   const file = event.target.files[0];
    //   if (file) {
    //     this.formDocuments.documents[index].file = file;
    //     this.formDocuments.documents[index].file_name = file.name;
    //   }
    // },

    onFileChange(event, index) {
    const file = event.target.files[0];
    if (file) {
        this.formDocuments.documents[index].file = file; // Doit être un objet File
        this.formDocuments.documents[index].file_name = file.name;
        console.log('📄 Fichier sélectionné:', file.name, 'Type:', typeof file, 'Instanceof File:', file instanceof File);
    } else {
        console.log('❌ Aucun fichier sélectionné');
    }
},

    supprimerDocumentExistant(documentId, index) {
      if (confirm('Êtes-vous sûr de vouloir supprimer ce document ?')) {
        // Utilisez this.documentsExistants directement (venant des props)
        this.documentsExistants.splice(index, 1);
        if (!this.formDocuments.documents_supprimes) {
          this.formDocuments.documents_supprimes = [];
        }
        this.formDocuments.documents_supprimes.push(documentId);
      }
    },

    async verify(element) {
      if (element && element.type) {
        const array = this.formDocuments.documents.filter(
          (el) => el.type === element.type
        );

        if (array.length > 1) {
          const index = this.formDocuments.documents.indexOf(element);
          this.removeDocument(index);
          alert("Le type de document existe déjà !");
        }
      }
    },

    isDocumentFormValid() {
      if (this.formDocuments.documents.length === 0) return true;
      
      return !this.formDocuments.documents.find(
        (el) => !el.type || !el.file
      );
    },

    getTypeDocumentLibelle(typeDocumentId) {
      if (!this.typeDocuments || !Array.isArray(this.typeDocuments)) return 'Type inconnu';
      
      // Rechercher dans typeDocuments (qui contient type_document en relation)
      const typeDoc = this.typeDocuments.find(td => 
        td.type_document && td.type_document.id == typeDocumentId
      );
      
      return typeDoc ? typeDoc.type_document.libelle : 'Type inconnu';
    },

    // MÉTHODES GÉNÉRALES
    goBack() {
      window.history.back();
    },

    getSection(type) {
      if (type == "1") {
        return "Primaire";
      } else if (type == "2") {
        return "Secondaire";
      } else if (type == "3") {
        return "Supérieure";
      } else {
        return "Universitaire";
      }
    },

    formatDateForInput(dateString) {
      if (!dateString) return '';
      const date = new Date(dateString);
      return date.toISOString().split('T')[0];
    },

    // submitForm() {
    //   // Validation basique
    //   if (!this.formApprenant.nom || !this.formApprenant.prenom || !this.formApprenant.sexe) {
    //     alert('Veuillez remplir les champs obligatoires de l\'apprenant');
    //     this.activeTab = 'apprenant';
    //     return;
    //   }

    //   if (!this.formAnnee.annee || !this.formAnnee.niveau) {
    //     alert('Veuillez remplir l\'année académique et le niveau');
    //     this.activeTab = 'academique';
    //     return;
    //   }

    //   // Validation des tuteurs
    //   const hasValidTuteur = this.formTuteurs.tuteurs.some(tuteur => 
    //     tuteur.nom && tuteur.prenom && tuteur.telephone
    //   );
      
    //   if (!hasValidTuteur) {
    //     alert('Veuillez ajouter au moins un tuteur avec tous les champs obligatoires remplis');
    //     this.activeTab = 'tuteurs';
    //     return;
    //   }

    //   // Validation des documents
    //   if (!this.isDocumentFormValid()) {
    //     alert('Veuillez remplir tous les champs obligatoires des documents');
    //     this.activeTab = 'documents';
    //     return;
    //   }

    //   // Préparer les données pour l'envoi
    //   const formData = new FormData();
      
    //   // Données de l'apprenant
    //   Object.keys(this.formApprenant).forEach(key => {
    //     formData.append(`apprenants[${key}]`, this.formApprenant[key] || '');
    //   });

    //   // Données académiques
    //   formData.append('annees[annee]', this.formAnnee.annee);
    //   formData.append('annees[niveau]', this.formAnnee.niveau);
    //   if (this.formAnnee.classe) {
    //     formData.append('annees[classe]', this.formAnnee.classe);
    //   }

    //   // Données des tuteurs
    //   this.formTuteurs.tuteurs.forEach((tuteur, index) => {
    //     formData.append(`tuteurs[tuteurs][${index}][nom]`, tuteur.nom || '');
    //     formData.append(`tuteurs[tuteurs][${index}][prenom]`, tuteur.prenom || '');
    //     formData.append(`tuteurs[tuteurs][${index}][telephone]`, tuteur.telephone || '');
    //     formData.append(`tuteurs[tuteurs][${index}][sexe]`, tuteur.sexe || '');
    //     formData.append(`tuteurs[tuteurs][${index}][email]`, tuteur.email || '');
    //   });

    //   // Données des documents
    //   this.formDocuments.documents.forEach((document, index) => {
    //     if (document.type && document.file) {
    //       formData.append(`documents[documents][${index}][type]`, document.type);
    //       formData.append(`documents[documents][${index}][file]`, document.file);
    //     }
    //   });

    //   // Documents à supprimer
    //   if (this.formDocuments.documents_supprimes && this.formDocuments.documents_supprimes.length > 0) {
    //     this.formDocuments.documents_supprimes.forEach((docId, index) => {
    //       formData.append(`documents[documents_supprimes][${index}]`, docId);
    //     });
    //   }

    //   formData.append('_method', 'PUT');
    //   formData.append('section', this.type);

    //   console.log('Envoi des données de modification...');

    //   // Envoyer la requête
    //   router.post(`/scolarite/inscriptions/${this.inscription.id}`, formData, {
    //     onSuccess: () => {
    //       alert('✅ Modification réussie !');
    //     },
    //     onError: (errors) => {
    //       alert('❌ Erreur lors de la modification');
    //       console.error('Erreurs:', errors);
    //     }
    //   });
    // }

submitForm() {
    // Validation basique
    if (!this.formApprenant.nom || !this.formApprenant.prenom || !this.formApprenant.sexe) {
        alert('Veuillez remplir les champs obligatoires de l\'apprenant');
        this.activeTab = 'apprenant';
        return;
    }

    if (!this.formAnnee.annee || !this.formAnnee.niveau) {
        alert('Veuillez remplir l\'année académique et le niveau');
        this.activeTab = 'academique';
        return;
    }

    // Validation des tuteurs
    const hasValidTuteur = this.formTuteurs.tuteurs.some(tuteur => 
        tuteur.nom && tuteur.prenom && tuteur.telephone
    );
    
    if (!hasValidTuteur) {
        alert('Veuillez ajouter au moins un tuteur avec tous les champs obligatoires remplis');
        this.activeTab = 'tuteurs';
        return;
    }

    // CORRECTION CRITIQUE : Utiliser FormData pour les fichiers
    const formData = new FormData();
    
    // Données de l'apprenant
    Object.keys(this.formApprenant).forEach(key => {
        formData.append(`apprenants[${key}]`, this.formApprenant[key] || '');
    });

    // Données académiques
    formData.append('annees[annee]', this.formAnnee.annee);
    formData.append('annees[niveau]', this.formAnnee.niveau);
    if (this.formAnnee.classe) {
        formData.append('annees[classe]', this.formAnnee.classe);
    }

    // Données des tuteurs
    this.formTuteurs.tuteurs.forEach((tuteur, index) => {
        formData.append(`tuteurs[tuteurs][${index}][nom]`, tuteur.nom || '');
        formData.append(`tuteurs[tuteurs][${index}][prenom]`, tuteur.prenom || '');
        formData.append(`tuteurs[tuteurs][${index}][tel]`, tuteur.telephone || '');
        formData.append(`tuteurs[tuteurs][${index}][sexe]`, tuteur.sexe || '');
        formData.append(`tuteurs[tuteurs][${index}][email]`, tuteur.email || '');
    });

    // CORRECTION : Données des documents - GESTION CORRECTE DES FICHIERS
    this.formDocuments.documents.forEach((document, index) => {
        if (document.type) {
            formData.append(`documents[documents][${index}][type]`, document.type);
            
            // Ajouter le fichier seulement s'il existe
            if (document.file instanceof File) {
                formData.append(`documents[documents][${index}][file]`, document.file);
                console.log('📤 Fichier ajouté à FormData:', document.file.name);
            } else {
                console.log('⚠️ Aucun fichier pour le document:', document.type);
            }
        }
    });

    // Documents à supprimer
    if (this.formDocuments.documents_supprimes && this.formDocuments.documents_supprimes.length > 0) {
        this.formDocuments.documents_supprimes.forEach((docId, index) => {
            formData.append(`documents[documents_supprimes][${index}]`, docId);
        });
    }

    formData.append('_method', 'PUT');
    formData.append('section', this.type);

    console.log('📤 Envoi des données de modification avec FormData...');

    // CORRECTION : Redirection après succès
    router.post(`/scolarite/inscriptions/${this.inscription.id}`, formData, {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: (page) => {
            console.log('✅ Succès - Réponse:', page);
            
            this.$swal({
                title: 'Succès!',
                text: 'Inscription modifiée avec succès!',
                icon: 'success',
                confirmButtonColor: '#004980'
            }).then((result) => {
                if (result.isConfirmed) {
                    // REDIRECTION VERS LA PAGE INDEX
                    router.visit(route('inscriptions.index', { section_id: this.type }), {
                        preserveScroll: true,
                        preserveState: true
                    });
                }
            });
        },
        onError: (errors) => {
            console.error('❌ Erreurs:', errors);
            this.$swal({
                title: 'Erreur!',
                text: 'Erreur lors de la modification: ' + (errors.message || 'Veuillez vérifier les données'),
                icon: 'error',
                confirmButtonColor: '#d33'
            });
        }
    });
}

  },
  
  watch: {
    typeDocuments: {
      handler(newVal) {
        console.log('🔄 Type documents mis à jour:', newVal);
      },
      immediate: true
    },
    
    documentsExistants: {
      handler(newVal) {
        console.log('🔄 Documents existants mis à jour:', newVal);
      },
      immediate: true
    }
  },
  mounted() {
    console.log('=== CHARGEMENT DES DONNÉES ===');
    console.log('Inscription:', this.inscription);
    console.log('Type:', this.type);
    console.log('Limite élèves:', this.nbre_limite_eleve);
    console.log('Documents existants:', this.documentsExistants);
    console.log('Type documents:', this.typeDocuments);

    // Récupérer l'ID de section d'établissement
    if (this.$page.props.sections && this.$page.props.sections[0]?.sections) {
      this.etablissement_section_id = this.$page.props.sections[0].sections.find(
        (el) => el.libelle == this.getSection(this.type)
      )?.id;
    }

    console.log('Etablissement section ID:', this.etablissement_section_id);

    // Chargement des tuteurs
    if (this.tuteurs && this.tuteurs.length > 0) {
      this.formTuteurs.tuteurs = this.tuteurs.map(tuteur => ({
        nom: tuteur.nom || '',
        prenom: tuteur.prenom || '',
        telephone: tuteur.tel || tuteur.telephone || '',
        sexe: tuteur.sexe || '',
        email: tuteur.email || ''
      }));
    } else {
      this.formTuteurs.tuteurs = [{
        nom: '',
        prenom: '',
        telephone: '',
        sexe: '',
        email: ''
      }];
    }

    // Pré-remplir les champs existants
    if (this.inscription) {
      const dateNaissance = this.inscription.apprenant?.date_naissance;
      const formattedDate = dateNaissance ? this.formatDateForInput(dateNaissance) : '';
      
      this.formApprenant = {
        nom: this.inscription.apprenant?.nom || '',
        prenom: this.inscription.apprenant?.prenom || '',
        sexe: this.inscription.apprenant?.sexe || '',
        date_naissance: formattedDate,
        lieu_naissance: this.inscription.apprenant?.lieu_naissance || '',
        telephone: this.inscription.apprenant?.telephone || ''
      };

      this.formAnnee = {
        annee: this.inscription.annee_id || null,
        niveau: this.inscription.niveau_id || null,
        classe: this.classe_actuelle?.id || null
      };

      // Charger les classes pour le niveau actuel
      if (this.inscription.niveau_id) {
        this.checkClasseExist(this.inscription.niveau_id);
      }
    }

    // Initialiser avec au moins un document vide
    if (this.formDocuments.documents.length === 0) {
      this.addDocument();
    }

    console.log('=== FIN CHARGEMENT ===');
  }
};
</script>

<style scoped>
.tab-navigation {
  display: flex;
  border-bottom: 1px solid #ccc;
  margin-bottom: 20px;
}

.tab-button {
  background: transparent;
  border: none;
  padding: 12px 24px;
  cursor: pointer;
  border-bottom: 2px solid transparent;
  transition: all 0.3s ease;
  font-size: 14px;
}

.tab-button:hover {
  background: #f5f5f5;
}

.tab-button.active {
  border-bottom: 2px solid #1976d2;
  color: #1976d2;
  font-weight: bold;
}

.btn-cancel {
  background: #6c757d;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 4px;
  cursor: pointer;
}

.btn-save {
  background: #1976d2;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 4px;
  cursor: pointer;
}

.btn-cancel:hover, .btn-save:hover {
  opacity: 0.9;
}

.debug-section {
  margin-top: 30px;
  border: 1px solid #ccc;
  padding: 15px;
  background: #f5f5f5;
  border-radius: 8px;
}

.debug-section h3 {
  margin-top: 0;
  color: #666;
}
</style>