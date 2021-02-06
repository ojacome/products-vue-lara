<template>
  <div class="container my-5">
    <div class="row">
      <div class="col-md-6 mx-auto">
        <b-card class="mt-3" header="Producto">
          <b-form  @submit.prevent="save()" @reset="onReset">
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
                required
              ></b-form-input>
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
                required
              ></b-form-input>
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
                required
              ></b-form-input>
            </b-form-group>

            <b-form-group id="input-group-3" label="Categoría" label-for="input-3">
              <b-form-select
                id="input-3"
                value-field="id"
                text-field="name"
                v-model="product.category_id"
                :options="categories"                
                required
              >
                <template #first>
                    <b-form-select-option :value="null" disabled>Elige la categoría</b-form-select-option>
                </template>   
              </b-form-select>
            </b-form-group>

            <b-button type="submit" variant="success">Guardar</b-button>
            <b-button type="reset" variant="secondary">Reset</b-button>
          </b-form>
        </b-card>
      </div>
    </div>
  </div>
</template>

<script>
import ProductModel from '../models/product.model'
import { Global } from '../global';
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  name: "Product",
  methods: {
      save(){          
          var url = `${Global.URL_API}/products`;                

          if(this.product.id !== ""){
            axios.patch(`${url}/${this.product.id}` , this.product)
            .then( res => {             
                Swal.fire(res.data.msg, '', 'success')
            })
            .catch( err => console.log(err))
          }
          else{    
            axios.post(url , this.product)
            .then( res => {             
                Swal.fire(res.data.msg, '', 'success')
            })
            .catch( err => console.log(err))
          }
      },
      getCategories(){
          var url = `${Global.URL_API}/categories`;

          axios.get(url)
          .then( res => {
              this.categories = res.data;              
          })
          .catch( err => console.log(err))            
      }, 
      getProduct(id){
          var url = `${Global.URL_API}/products/${id}`;

          axios.get(url)
          .then( res => {              
              this.product = res.data;              
          })
          .catch( err => console.log(err))            
      }, 
      onReset(){
          this.product.id = '';
          this.product.name = '';
          this.product.price = '';
          this.product.stock = '';
          this.product.category_id = null;
      }
  },
  data(){
      return{
          product: new ProductModel('', '', '', '', null),
          categories: [ ]
      }
  },
  mounted() {
      var id = this.$route.params.id;      
      this.getCategories();

      if(id !== "nuevo"){
        this.getProduct(id);
      }
  }

};
</script>

<style>
</style>