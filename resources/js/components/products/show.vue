<template>
    
</template>

<script>
export default {

    data: () => ({
        product: {}
    }),

    created() {
        this.getProduct()
    },

    methods: {
        async getProduct() {
            await axios.get(`/api/products/${this.$route.params.id}`)
            .then(({ data }) => {
                this.product = data.data
            })
            .catch((err) => {

            })
        }
    }
}
</script>