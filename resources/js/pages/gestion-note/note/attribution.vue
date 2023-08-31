<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { router, usePage, useForm } from "@inertiajs/vue3";
export default {
    
    props: ['classes','evaluations','eleves'],
    layout: AuthenticatedLayout,
    data() {
        return {
            tabs: [],
            valid: null,
            dialogConfirmation: false,
            searchQuery: null,
            selectedClasse: null,
            selectedEvaluation: null,
            headers: [
              {
                  title: 'Id',
                  align: 'start',
                  key: 'id',
                  sortable: false,
              },
              { title: "Nom", align: "center", key: "nom_complete" },
              { title: "Note", align: "center", key: "note" },
            ],
            rules:{
                required: v => !!v || "Veuillez renseigner la note",
                validator: v=> !(Math.sign(v) == -1) ||  "La note doit être positif",
                max: v=> v <= 20 ||  "La note ne doit pas dépasser 20"
            },
            form: this.$inertia.form({
              notes: [],
              evaluation: null,
              classe: null,
            }),
        }
    },
    created(){
      // console.log(this.eleves)
      console.log(this.eleves)
      this.eleves.forEach(element => {
        console.log(element.note)
      });
    },
    methods: {
      rechercher(){
            router.replace(this.$page.url,{data:{classe:this.selectedClasse,evaluation:this.selectedEvaluation}});
      },
      requete(id){
          router.replace(this.$page.url,{data:{classe:id}});  
      },
      setNote(item){
        // console.log('item',item.key)
        this.form.notes[item.key] = item.note;
      },
      submit() {
            // this.form.notes = this.tabs.filter(el => el != null)
            this.form.classe = this.selectedClasse
            this.form.evaluation = this.selectedEvaluation
            console.log(this.form)
            this.form.post(route("note.save"), {
            preverseScroll: true,
            onSuccess: () => {
                this.isLoading = false;
                this.dialogConfirmation = false;
                this.form.reset();
            },
        });
      },
    },
    computed: {
      
    },
    }
</script>

<template>
  <Head title="Notes" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Attribution de notes</h2>
    </template>

    <v-card style="margin: 20px">
      <v-card-title>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">Attribution de notes</div>
          </div>
        </div>
      </v-card-title>
    </v-card>
    <v-form v-model="valid">

    <v-card style="margin: 20px">
      <v-card-title>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">Choisissez les criteres</div>
          </div>
        </div>
      </v-card-title>
      <v-row>
        <v-col md="2"></v-col>
        <v-col md="3">
            <v-autocomplete
                v-model="selectedClasse"
                :items="classes"
                item-title="classe_annee.classe.libelle"
                item-value="classe_annee.classe.id"
                @update:modelValue="requete(selectedClasse)"
                outlined
                required
                dense
                chips
                small-chips
                label="Classes"
            ></v-autocomplete>
        </v-col>
        <v-col md="3" v-if="$page.props.evaluations != null">
            <v-select
                v-model="selectedEvaluation"
                :items="$page.props.evaluations ? $page.props.evaluations : null"
                item-title="type_evaluation.libelle"
                item-value="id"
                outlined
                required
                dense
                chips
                small-chips
                label="Evaluations"
            ></v-select>
        </v-col>
        <v-col md="2">
            <v-btn
            color="primary"
            @click="rechercher()"
            :loading="form.processing"
            :disabled="!selectedClasse || !selectedEvaluation"
            >
                Rechercher
            </v-btn>
        </v-col>
        <v-col md="2"></v-col>
    </v-row>
      <!-- <FiltreAffichageNote :classes="classes" :evaluations="evaluations"></FiltreAffichageNote> -->
    </v-card>


    <v-card style="margin: 20px" v-if="eleves.length != 0">
      <v-card-title>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">Saisissez les notes</div>
          </div>
        </div>
      </v-card-title>
      <!-- <v-data-table :items="props.notes" :headers="headers" :search="search"></v-data-table> -->
      <!-- <TableauAttributionNote :items="eleves" :headers="headers"></TableauAttributionNote> -->
      <v-text-field 
          v-model="searchQuery"
          label="Recherche"
          placeholder="Recherche...">
      </v-text-field>
      <v-data-table
          :items="eleves"
          :headers="headers"
          :search="searchQuery"
      >
          <template v-slot:item.note="{ item, index }">
              <v-text-field
                  v-model="item.note"
                  type="text"
                  outlined
                  @change="setNote(item)"
                  dense
                  :rules="[rules.required, rules.validator, rules.max]"
                  style="max-width: 300px"
              ></v-text-field>
          </template>
      </v-data-table>
      <v-card-actions>
        <v-spacer />
            <v-btn
                :disabled="form.processing"
                color="error"
                @click="dialogConfirmation = false"
            >
                Annuler
            </v-btn>
            <v-btn
                :loading="form.processing"
                :disabled="!valid || !selectedClasse || !selectedEvaluation"
                color="green"
                @click="dialogConfirmation = true"
            >
                Valider
            </v-btn>
        </v-card-actions>
        <v-dialog v-model="dialogConfirmation" max-width="500px" height="700px">
        <v-card>
            <v-card-title class="text-h6">Confirmation</v-card-title>
            <v-card-text class="text-h6">Êtes-vous sûr de vouloir sauvegarder ces notes de:<strong> test  </strong> ?</v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn
                    :disabled="form.processing"
                    text
                    color="error"
                    @click="dialogConfirmation = false"
                >
                    Non
                </v-btn>
                <v-btn
                    :loading="form.processing"
                    text
                    color="#8D6E63"
                    @click="submit"
                >
                    Oui
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
    </v-card>
  </v-form>
  </AuthenticatedLayout>
</template>

