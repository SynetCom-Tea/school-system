<template>
    <div id="bulletin">
        <h1>Bulletin de </h1>
    </div>
</template>

<script>
import { OutputType } from "jspdf-invoice-template/dist";
export default {
    props: {
        content: Object
    },
    watch: {
        'content.dataUriString': function () {
            this.preview()
        }
    },
    methods: {
        async preview() {
            import('pdfobject').then(PDFObject => {
                PDFObject.embed(OutputType.DataUriString, '#bulletin')
            })
        }
    },
    mounted() {
        this.preview()
    }
}
</script>

<style>
.pdfobject-container {
    height: 30rem;
    border: 1rem solid rgba(0, 0, 0, .1);
}
</style>
