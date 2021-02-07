<template>
  <div class="container my-5">
    <div class="row">
      <div class="col-md-6">
        <h2>Administrar Productos</h2>
      </div>
      <div class="col-md-6 text-right">
        <b-button variant="info" to="/products/nuevo">
          <i class="fa fa-plus"></i>
          Nuevo Producto
        </b-button>
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

    <div class="row mt-3 animate__animated animate__fadeIn" v-if="!cargando">
      <b-table 
      hover 
      show-empty
      responsive
      sort-icon-left
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
        <template #cell(actions)="data">
          <b-button 
          :to="{ name: 'products', params: { id: data.item.id }}"
          variant="outline-primary" 
          size="sm" 
          class="mr-2"> 
          <i class="fa fa-pencil"></i>
          </b-button>
          <b-button @click="eliminar(data.item.id)" variant="outline-danger" size="sm">
             <i class="fa fa-trash"></i>
          </b-button>           
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
import Swal from 'sweetalert2';
import { Global } from '../global/index'


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
      var url = `${Global.URL_API}/products`;
      Axios.get(url)
        .then((res) => {
          this.cargando = false;
          if (res.data) {
            this.products = res.data;
            this.rows = this.products.length;            
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
      },
    eliminar(id){
      Swal.fire({
        title: '¿Seguro de eliminar?',
        text: 'No podrás recuperar la información del producto.',        
        showCancelButton: true,
        confirmButtonText: `Eliminar`,        
      }).then((result) => {        
        if (result.isConfirmed) {
          var url = `${Global.URL_API}/products/${id}`;
          Axios.delete(url)
          .then(() => {  
                                  
            Swal.fire('Producto eliminado!', '', 'success')
            this.getProducts();
          })
          .catch((err) => {            
            console.log(err);
          });
        } 
      })
    }
  },
  data() {
    return {
      products: [],      
      fields: [
        { key: "id" ,       sortable: true },
        { key: "name" ,     sortable: true },
        { key: "category" , sortable: true },
        { key: "stock" ,    sortable: true },
        { key: "price" ,    sortable: true },
        { key: "actions" ,    class:  "text-right"},
      ],
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