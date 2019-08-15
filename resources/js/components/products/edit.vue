<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Create Product</div>
          <div class="card-body">
            <form @submit.prevent="onSubmit" @keydown="form.onKeydown($event)">
              <alert-success :form="form" message="The product has been updated!"></alert-success>
              <div class="row">
                <!-- Product image -->
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Product image (optional)</label>
                  </div>
                </div>
                <!-- Product Name -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="productName">Product name:</label>
                    <input
                      type="text"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('name') }"
                      id="productName"
                      placeholder="Enter product name"
                      v-model="form.name"
                    />
                    <has-error :form="form" field="name"></has-error>
                  </div>
                </div>
                <!-- Product Price -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="productPrice">Product price:</label>
                    <input
                      type="number"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('price') }"
                      id="productPrice"
                      placeholder="Product price"
                      v-model="form.price"
                    />
                    <has-error :form="form" field="price"></has-error>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="productCategory">Product category:</label>
                    <select
                      id="productCategory"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('category') }"
                      v-model="form.category"
                    >
                       <option
                        :value="category.id"
                        v-for="(category, index) in categories"
                        :key="index"
                      >{{ category.name }}</option>
                    </select>
                    <has-error :form="form" field="category"></has-error>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="productDescription">Product description:</label>
                    <textarea-autosize
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('description') }"
                      v-model="form.description"
                      id="productDescription"
                      :min-height="100"
                    ></textarea-autosize>
                    <has-error :form="form" field="description"></has-error>
                  </div>
                </div>
              </div>
              <button class="btn btn-primary" type="submit" :disabled="form.busy">
                <span
                  class="spinner-border spinner-border-sm"
                  role="status"
                  aria-hidden="true"
                  v-if="form.busy"
                ></span>
                Update
              </button>
              <router-link :to="{ name: 'products' }" class="btn btn-link">Voltar</router-link>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import Tippy from "v-tippy";
import "v-tippy/dist/tippy.css";
import { Form, HasError, AlertSuccess } from "vform";
import objectToFormData from "object-to-formdata";

Vue.use(Tippy);
Vue.component(HasError.name, HasError);
Vue.component(AlertSuccess.name, AlertSuccess);

export default {
  data: () => ({
    categories: [],
    form: new Form({
      name: "",
      description: "",
      price: 0,
      category: null,
    })
  }),

  created() {
    this.getCategories();
    this.getProduct();
  },

  methods: {
    async getCategories() {
      await axios.get("/api/products_categories").then(({ data }) => {
        this.categories = data;
      });
    },

    async getProduct() {
      await axios
        .get(`/api/products/${this.$route.params.id}`)
        .then(({ data }) => {
          const product = data.data;
          this.form.keys().forEach(key => {
            this.form[key] = product[key];
          });
        })
        .catch(err => {});
    },

    async onSubmit() {
      await this.form.patch(`/api/products/${this.$route.params.id}`)
        .then(response => {});
    }
  }
};
</script>