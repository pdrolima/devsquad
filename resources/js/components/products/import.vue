<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Import Products</div>
          <div class="card-body">
            <form @submit.prevent="onSubmit" @keydown="form.onKeydown($event)">
              <alert-success :form="form" :message="message"></alert-success>
              <div class="row">
                <!-- Product image -->
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Select products CSV file</label>
                    <div class="d-block">
                      <input
                        ref="input"
                        name="image"
                        type="file"
                        style="display: none;"
                        :class="{ 'is-invalid': form.errors.has('file') }"
                        @change="addFile()"
                      />
                      <a
                        v-tippy
                        class="btn btn-light"
                        title="Choose a image for the product"
                        @click="openFileDialog"
                      >
                        <i class="flaticon-attachment" />
                        Choose a file
                      </a>
                    </div>
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
                Upload
              </button>
              <router-link :to="{ name: 'products' }" class="btn btn-link">
                Voltar
              </router-link>
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
import { Form, HasError, AlertSuccess} from "vform";
import objectToFormData from 'object-to-formdata'

Vue.use(Tippy);
Vue.component(HasError.name, HasError);
Vue.component(AlertSuccess.name, AlertSuccess)

export default {
  data: () => ({
    form: new Form({
      productsFile: null
    }),
    message: '',
  }),

  methods: {
    async onSubmit() {
      await this.form.submit('post', '/api/products_import', {
          transformRequest: [function (data, headers) {
                return objectToFormData(data)
              }],
      })
      .then(({ data }) => {
          this.message = data.message;
      });
    },

    openFileDialog() {
      this.$refs.input.click();
    },

    addFile() {
      this.form.productsFile = this.$refs.input.files[0]
    }
  }
};
</script>