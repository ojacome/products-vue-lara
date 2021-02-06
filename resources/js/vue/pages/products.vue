<template>
  <div class="container my-5">
    <div class="row">
      <div class="col-md-6">
        <h2>Administrar Productos</h2>
      </div>
      <div class="col-md-6 text-right">
        <button class="btn btn-info">Nuevo Producto</button>
      </div>
    </div>

    <div class="row mt-3">
      <div class="col-md-6">        
        <b-form inline>
          <label class="mr-sm-2" for="filter-input">Buscar: </label>
          <b-form-input
            id="filter-input"
            v-model="filter"
            type="search"
            placeholder="Nombre del producto"
          ></b-form-input>
        </b-form>
      </div>
    </div>

    <Loading v-if="cargando"/>

    <div class="row mt-3" v-if="!cargando">
      <b-table 
      hover 
      show-empty
      :items="products" 
      :fields="fields" 
      :filter="filter"
      :filter-included-fields="filterOn"
      :current-page="currentPage"
      :per-page="perPage"      
      @filtered="onFiltered">
        <!-- A custom formatted column -->
        <template #cell(category)="data">
          {{ data.value.name }}
        </template>
        <template #cell(actions)>
          <b-button size="sm" class="mr-2"> Editar </b-button>
          <b-button size="sm"> Eliminar </b-button>
        </template>
      </b-table>

      <b-pagination
        v-model="currentPage"
        :total-rows="rows"
        :per-page="perPage"
        align="fill"    
        pills     
        class="my-0"
      ></b-pagination>
    </div>

  </div>
</template>

<script>
import Axios from "axios";
import Loading from '../components/loading';

export default {
  name: "Products",
  components: {
    Loading,
  },
  mounted(){
      this.getProducts();
  },
  methods: {
    getProducts() {
      this.cargando = true;
      var url = "http://localhost:8000/api/products";
      Axios.get(url)
        .then((res) => {
          this.cargando = false;
          if (res.data) {
            this.products = res.data;
            this.rows = this.products.length;
            console.log(this.products);
          }
        })
        .catch((err) => {
          this.cargando = false;
          console.log(err);
        });
    },
    onFiltered(filteredItems) {        
        this.rows = filteredItems.length
        this.currentPage = 1
      }
  },
  data() {
    return {
      products: [],
      fields: ["id", "name", "category", "stock", "price", "actions"],
      filterOn: ["name"],
      rows: 1,
      currentPage: 1,
      perPage: 15,
      cargando: false,
      filter: null,
    };
  },
};
</script>

<style>
</style>