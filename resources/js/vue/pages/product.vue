<template>
  <div class="container my-5">
    <div class="row">
      <div class="col-md-6 mx-auto">
        <b-card class="mt-3" header="Producto">
          <b-form @submit.prevent="save()" @reset="onReset">
            <b-form-group
              id="input-group-1"
              label="Nombre del producto"
              label-for="input-1"
            >
              <b-form-input
                id="input-1"
                v-model="product.name"
                type="text"
                placeholder="Nombre..."
                :state="$v.product.name.required && $v.product.name.minLength"
                required
              ></b-form-input>

              <b-form-invalid-feedback :state="$v.product.name.required && $v.product.name.minLength">
                El nombre es requerido, mínimo 2 caracteres.
              </b-form-invalid-feedback>
            </b-form-group>

            <b-form-group
              id="input-group-2"
              label="Precio del producto"
              label-for="input-2"
            >
              <b-form-input
                id="input-2"
                type="number"
                step="any"
                v-model="product.price"
                placeholder="xx.xx"
                :state="$v.product.price.required"
                required
              ></b-form-input>
              <b-form-invalid-feedback :state="$v.product.price.required">
                El precio es requerido.
              </b-form-invalid-feedback>
            </b-form-group>

            <b-form-group
              id="input-group-2"
              label="Stock del producto"
              label-for="input-2"
            >
              <b-form-input
                id="input-2"
                type="number"
                v-model="product.stock"
                placeholder="stock"
                :state="$v.product.stock.required && $v.product.stock.minValue"
                required
              ></b-form-input>
              <b-form-invalid-feedback :state="$v.product.stock.required && $v.product.stock.minValue">
                El stock es requerido, mínimo (1)
              </b-form-invalid-feedback>
            </b-form-group>

            <b-form-group
              id="input-group-3"
              label="Categoría"
              label-for="input-3"
            >
              <b-form-select
                id="input-3"
                value-field="id"
                text-field="name"
                v-model="product.category_id"
                :options="categories"
                :state="$v.product.category_id.required"
                required
              >
                <template #first>
                  <b-form-select-option :value="null" disabled
                    >Elige la categoría</b-form-select-option
                  >
                </template>
              </b-form-select>
              <b-form-invalid-feedback :state="$v.product.category_id.required">
                La categoría es requerida.
              </b-form-invalid-feedback>
            </b-form-group>

            <b-button :disabled="$v.$invalid" type="submit" variant="success">Guardar</b-button>
            <b-button type="reset" variant="secondary">Reset</b-button>
          </b-form>
        </b-card>
      </div>
    </div>
  </div>
</template>

<script>
import ProductModel from "../models/product.model";
import { Global } from "../global";
import axios from "axios";
import Swal from "sweetalert2";
import { required, minLength, minValue } from 'vuelidate/lib/validators';


export default {
    name: "Product",
    validations: {
        product: {
            name:           { required , minLength: minLength(2) },
            price:          { required },
            stock:          { required , minValue: minValue(1)},
            category_id:    { required },            
        }
      },  
  methods: {
    save() {
      var url = `${Global.URL_API}/products`;

      if (this.product.id !== "") {
        axios
          .patch(`${url}/${this.product.id}`, this.product)
          .then((res) => {
            Swal.fire(res.data.msg, "", "success");
          })
          .catch((err) => console.log(err));
      } else {
        axios
          .post(url, this.product)
          .then((res) => {
            Swal.fire(res.data.msg, "", "success");
          })
          .catch((err) => console.log(err));
      }
    },
    getCategories() {
      var url = `${Global.URL_API}/categories`;

      axios
        .get(url)
        .then((res) => {
          this.categories = res.data;
        })
        .catch((err) => console.log(err));
    },
    getProduct(id) {
      var url = `${Global.URL_API}/products/${id}`;

      axios
        .get(url)
        .then((res) => {
          this.product = res.data;
        })
        .catch((err) => console.log(err));
    },
    onReset() {
      this.product.id = "";
      this.product.name = "";
      this.product.price = "";
      this.product.stock = "";
      this.product.category_id = null;
    },
  },
  data() {
    return {
      product: new ProductModel("", "", "", "", null),
      categories: [],
    };
  },
  mounted() {
    var id = this.$route.params.id;
    this.getCategories();

    if (id !== "nuevo") {
      this.getProduct(id);
    }
  }
};
</script>

<style>
</style>