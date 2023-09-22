<template>
<v-container>
    <v-row align="center" justify="center" style="margin-top: 10%">
        <v-col cols="12" sm="4">
            <v-card class="login-card">
                <v-card-title class="text-center">
                    Vérification de code
                </v-card-title>
                <v-card-text>
                    <v-form>
                        <v-card class="rounded-r-0" height="100%" shaped>
                            <v-img src="/logo.png" max-height="200"></v-img>
                        </v-card>
                        <br />
                        <br />
                        <div id="app">
                            <div class="verification-code">
                                <input v-for="index in 6" :key="index" ref="inputFields" v-model="verificationCode[index - 1]" @input="handleInput(index)" @keydown.delete="handleBackspace(index)" maxlength="1" />
                                <v-icon size="30px" color="orange" title="Rafraichir" @click="rafrechir" :icon="icon.mdiHistory">
                                </v-icon>
                            </div>
                            <br />
                            <v-alert variant="outlined" type="info" prominent border="top">
                                <template v-slot:title>
                                    Nota Bene:
                                </template>
                                - Saisissez votre code que nous vous avons
                                envoyé.
                                <br />
                                - Si vous n'avez pas reçu le code
                                <br />
                                Clickez
                                <v-btn @click="retour">
                                    <strong>ici</strong>
                                </v-btn>
                                pour réessayer!!!
                            </v-alert>
                        </div>
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
} from "@inertiajs/vue3";
import {
    mdiCancel,
    mdiCheckCircle,
    mdiEye,
    mdiHistory
} from "@mdi/js";

export default {
    components: {
        mdiCancel,
        mdiCheckCircle,
        mdiHistory,
    },
    data() {
        return {
            verificationCode: [6].fill(""),
            icon: {
                mdiCancel,
                mdiCheckCircle,
                mdiHistory,
            },
            form: useForm({
                code: "",
            }),
        };
    },
    methods: {
        rafrechir() {
            this.verificationCode = []
        },
        handleInput(index) {
            if (index < 6 && this.verificationCode[index - 1] !== "") {
                this.$refs.inputFields[index].focus();
            }
            this.form.code = this.verificationCode.join("");
            if (this.form.code.length == 6) {
                this.form.post(route("verifier"), {
                    onSuccess: () => {
                        if (this.$page.props.flashd.messages) {
                            toast.error(this.$page.props.flashd.messages);
                        }
                        this.verificationCode = [];
                    },
                });
            }
        },
        handleBackspace(index) {
            if (index > 1 && this.verificationCode[index - 1] === "") {
                this.$refs.inputFields[index - 2].focus();
            }
            this.form.code = "";
        },
        retour() {
            router.get(route("inscrit"));
        },
    },
    mounted() {
        if (this.$page.props.flash.message) {
            toast.info(this.$page.props.flash.message);
        }
    },
};
</script>

<style>
.hover {
    padding: 8px 16px;
    background-color: #19d347;
    color: #1d1a1a;
}

.verification-code {
    display: flex;
    justify-content: center;
}

input {
    width: 40px;
    height: 40px;
    text-align: center;
    font-size: 24px;
    border: 1px solid #f07c0f;
    margin: 0 5px;
    border-radius: 7px;
}
</style>
