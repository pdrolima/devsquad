export default {

    data: () => ({
        categories: []
    }),

    created() {
        this.getCategories()
    },

    methods: {
        async getCategories() {
            await axios.get("/api/products_categories")
            .then(({ data }) => {
                this.categories = data;
            }).catch((err) => {

            })
        },
    }
}