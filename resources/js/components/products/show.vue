<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
             <li class="breadcrumb-item">
               <router-link :to="{ name: 'home' }">Home</router-link>
             </li>
            <li class="breadcrumb-item">
              <router-link :to="{ name: 'products' }">Products</router-link>
             </li>
            <li class="breadcrumb-item active" aria-current="page">
               Viewing Product {{ product.name }} (#{{ product.id }})
            </li>
          </ol>
        </nav>
        <div class="card">
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