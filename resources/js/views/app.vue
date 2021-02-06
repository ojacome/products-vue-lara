<template>
  <div>
    <b-navbar toggleable="lg" type="dark" variant="info">
      <b-navbar-brand href="#">ProductsApp</b-navbar-brand>

      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
          <b-nav-item href="#">Link</b-nav-item>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>

    <div class="container mt-5">
      <div class="row">
        <div class="col-md-6">
          <h2>Administrar Productos</h2>
        </div>
        <div class="col-md-6 text-right">
          <button class="btn btn-primary">Nuevo Producto</button>
        </div>
      </div>

      <div class="row mt-5">
        <b-table hover :items="products" :fields="fields" >
          <!-- A custom formatted column -->
          <template #cell(category)="data">
            {{ data.value.name }}
          </template>
          <template #cell(actions)>            
            <b-button size="sm" class="mr-2">
              Editar
            </b-button>
            <b-button size="sm">
              Eliminar
            </b-button>
          </template>
        </b-table>
      </div>
    </div>
  </div>
</template>
<script>
const default_layout = "default";
import Axios from 'axios';

export default {
  computed: {},
  mounted(){
    this.getProducts();
  },
  methods: {
    getProducts() {
      var url = "http://localhost:8000/api/products";
      Axios.get(url)
        .then((res) => {          
          if (res.data) {
            this.products = res.data.data;
            console.log(this.products);
          }
        })
        .catch((err) => {
          console.log(err);
        });
    }
  },
  data() {
    return {
      products: [],
      fields: ['id', 'name','category', 'stock', 'price', 'actions'],      
    };
  },
};
</script>