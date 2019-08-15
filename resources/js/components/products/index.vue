<template>
  <div>
    <div class="container">
      <div class="row justify-content-center">
        <!-- Products -->
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">Products</div>
            <div class="card-body">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Category</th>
                    <th scope="col">&nbsp;</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(product, index) in products" :key="index">
                      <td>{{ product.name }}</td>
                      <td>{{ product.price }}</td>
                      <td>{{ product.department.name }}</td>
                      <td>
                          <router-link :to="{ name: 'products.show', params: { id: product.id } }" class="btn btn-link">Visualizar</router-link>
                          <router-link :to="{ name: 'products.edit', params: { id: product.id } }" class="btn btn-link">Editar</router-link>
                          <a href="" @click.prevent="deleteProduct(product.id)" class="btn btn-link text-danger">Deletar</a>
                      </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- Filters & Actions -->
        <div class="col-md-4">
            <router-link :to="{ name: 'products.create' }" class="btn btn-primary btn-lg btn-block">
                Cadastrar Produto
            </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Swal from 'sweetalert2'

export default {
    data: () => ({
        products: []
    }),

    created() {
        this.getProducts()
    },

    methods: {
        getProducts() {
            axios.get('/api/products')
            .then(({ data }) => {
                this.products = data.data
            })
        },

        deleteProduct(id) {
          Swal.fire({
              title: 'Are you sure?',
              type: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.value) {
                 axios.delete(`/api/products/${id}`)
                 .then(() => {
                   this.getProducts()
                    Swal.fire(
                      'Deleted!',
                      'Your file has been deleted.',
                      'success'
                    )
                 })
              }
            })          
        }
    }
};
</script>