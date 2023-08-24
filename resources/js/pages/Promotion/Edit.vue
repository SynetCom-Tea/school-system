<script>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { router, useForm } from '@inertiajs/vue3';
    import {
        mdiAccountSchool,
        mdiEmailOutline,
        mdiCancel,
        mdiCheckCircle,
        mdiPlusCircle,
        mdiCloseCircle,
        mdiReceiptTextSendOutline,
    } from '@mdi/js'
    export default{
        components: {
            mdiAccountSchool,
            mdiEmailOutline,
            mdiCancel,
            mdiCheckCircle,
            mdiPlusCircle,
            mdiCloseCircle,
            mdiReceiptTextSendOutline,
        },
        props: ["promotion", "annees", "classes"],
        layout: AuthenticatedLayout,
        data() {
            return {
                icon: {
                    mdiAccountSchool,
                    mdiEmailOutline,
                    mdiCancel,
                    mdiCheckCircle,
                    mdiPlusCircle,
                    mdiCloseCircle,
                    mdiReceiptTextSendOutline,
                },
                form: useForm({
                    date_debut: '',
                    date_fin: '',
                    annee_id: '',
                    classe_id: '',
                }),
            }
        },
        methods: {
            goBack(){
                router.get(route('promotions.index'))
                console.log()
            },
            async submit(){
                const { valid } = await this.$refs.form.validate()
                if(valid){
                 this.form.put(route('promotions.update', this.form.id), {
                   onFinish: () => this.form.reset(),
                });
                } 
            },
        },
        mounted() {
            // this.addRow()
        },
        created() {
            const promotion = this.promotion
            this.form.id = promotion.id
            this.form.date_debut = promotion.date_debut
            this.form.date_fin = promotion.date_fin
            this.form.annee_id = promotion.annee_id
            this.form.classe_id = promotion.classe_id
        }
    }
</script>
<template>
    <v-card>
        <page-toolbar :icon="icon.mdiReceiptTextSendOutline">Modifier Promotion</page-toolbar>
        <v-card-text>
            <v-form ref="form">
                <v-row>
                 <v-col md="6">
                    <text-field type="date" name="date_debut" label="Date début" v-model="form.date_debut" isRequired :rules="[v => !!v || 'Ce champ est requis!']" ></text-field>
                </v-col>
                <v-col md="6">
                    <text-field type="date" name="date_fin" label="Date fin" v-model="form.date_fin" :min="form.date_debut"></text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col md="6">
                    <select-field label="Année" :items="annees" item-title="annee" item-value="id" v-model="form.annee_id" isRequired :rules="[v => !!v || 'Ce champ est requis!']">
                    </select-field>
                </v-col>
                <v-col md="6">
                    <select-field label="Classes" item-title="libele" item-value="id" :items="classes" multiple chips v-model="form.classe_id" isRequired :rules="[v => v.length>0 || 'Ce champ est requis!']">
                    </select-field>
                </v-col>
            </v-row>
            <br>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn dark small type="button" color="red" @click="goBack">
                    <v-icon :icon="icon.mdiCancel" left></v-icon> Annuler
                </v-btn>
                <v-btn small color="success" @click="submit">
                    <v-icon :icon="icon.mdiCheckCircle" left></v-icon> Enregistrer
                </v-btn>
            </v-card-actions>
            </v-form>
        </v-card-text>
    </v-card>
</template>