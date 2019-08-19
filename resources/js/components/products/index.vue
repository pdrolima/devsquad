<template>
  <div>
    <div class="container">
      <div class="row justify-content-center">
        <!-- Products -->
        <div class="col-md-12"></div>
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">Products</div>
            <div class="card-body">
              <input
                type="text"
                v-model="filters.name"
                class="form-control mb-4"
                placeholder="Filter by name"
              />
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
                      <router-link
                        :to="{ name: 'products.show', params: { id: product.id } }"
                        class="btn btn-link"
                      >Visualizar</router-link>
                      <router-link
                        :to="{ name: 'products.edit', params: { id: product.id } }"
                        class="btn btn-link"
                      >Editar</router-link>
                      <a
                        href
                        @click.prevent="deleteProduct(product.id)"
                        class="btn btn-link text-danger"
                      >Deletar</a>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="d-flex justify-content-center">
                <pagination :data="dataSet" v-on:pagination-change-page="getProducts"></pagination>
              </div>
            </div>
          </div>
        </div>
        <!-- Filters & Actions -->
        <div class="col-md-4">
          <router-link
            :to="{ name: 'products.create' }"
            class="btn btn-primary btn-lg btn-block"
          >Cadastrar Produto</router-link>
          <router-link
            :to="{ name: 'products.import' }"
            class="btn btn-light btn-lg btn-block"
          >Importar produtos</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Swal from "sweetalert2";

export default {
  data: () => ({
    products: [],
    dataSet: {},
    filters: {
      name: ""
    }
  }),

  created() {
    this.getProducts();
  },

  methods: {
    getProducts(page) {
      axios.get(this.url(page)).then(({ data }) => {
        this.products = data.data;
        this.dataSet = data;
      });
    },

    url(page) {
      if (!page) {
        let query = location.search.match(/page=(\d+)/);
        page = query ? query[1] : 1;
      }

      return `/api/products?page=${page}${this.buildFiltersUrl(this.filters)}`;
    },

    deleteProduct(id) {
      Swal.fire({
        title: "Are you sure?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!"
      }).then(result => {
        if (result.value) {
          axios.delete(`/api/products/${id}`).then(() => {
            this.getProducts();
            Swal.fire("Deleted!", "Your file has been deleted.", "success");
          });
        }
      });
    },
    buildFiltersUrl (data) {
      let url = '';
      for (let key in data) {
        if (data.hasOwnProperty(key)) {
          url += (data[key]) ? `&${key}=${encodeURI(data[key])}` : ''
        }
      }
      return url;
    }
  },

   watch: {
    filters: {
      handler(val) {
        this.getProducts();
      },
      deep: true
    }
  }
};
</script>