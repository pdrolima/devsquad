<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Viewing Product: {{ product.name }} (#{{ product.id }})   </div>
          <div class="card-body">
            <div class="d-flex flex-wrap">
                <img :src="product.image" :alt="product.name" class="flex-1 w-25">
                <dl class="flex-column p-5">
                    <dt>Product name</dt>
                    <dd>{{ product.name }}</dd>
                    <dt>Product price</dt>
                    <dd>$ {{ product.price }}</dd>
                    <dt>Product category</dt>
                    <dd>{{ product.department.name }}</dd>
                    <dt>Product description</dt>
                    <dd>{{ product.description }}</dd>
                </dl>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: () => ({
    product: {}
  }),

  created() {
    this.getProduct();
  },

  methods: {
    async getProduct() {
      await axios
        .get(`/api/products/${this.$route.params.id}`)
        .then(({ data }) => {
          this.product = data.data;
        })
        .catch(err => {});
    }
  }
};
</script>