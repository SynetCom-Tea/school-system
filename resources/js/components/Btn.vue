<template>
    <div class="custom-add-button">
      <v-btn x-small variant="outlined" color="rgb(125, 0, 44, 0.75)" @click="addItem">
        <slot></slot>
      </v-btn>
    </div>
</template>
<script>
export default {
    methods: {
        addItem() {
        // Handle the add action
        },
    },
};
</script>

<style scoped>
.custom-add-button {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 16px;
    font-size: 10px; /* Personnalisez la taille de la police */
    padding: 6px 12px; 
}
</style>