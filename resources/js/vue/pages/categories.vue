<template>
  <div class="container my-5">
    <div class="row">
      <div class="col-md-6 mx-auto">
        <div class="row">
          <div class="col-md-6">
            <h2>Administrar Categorías</h2>
          </div>
          <div class="col-md-6 text-right">
            <b-button variant="info">Nueva Categoría</b-button>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-3">
      <div class="col-md-6 mx-auto">
        <b-form inline>
          <label class="mr-sm-2" for="filter-input">Buscar: </label>
          <b-form-input
            id="filter-input"
            v-model="filter"
            type="search"
            placeholder="Nombre de la categoría"
          ></b-form-input>
        </b-form>
      </div>
    </div>

    <Loading v-if="cargando" />

    <div class="row mt-3" v-if="!cargando">
      <div class="col-md-6 mx-auto">
        <b-table
          hover
          show-empty
          responsive
          sort-icon-left
          :items="categories"
          :fields="fields"
          :filter="filter"
          :filter-included-fields="filterOn"
          :current-page="currentPage"
          :per-page="perPage"
          @filtered="onFiltered"
        >
          <template #cell(actions)="data">
            <b-button variant="outline-primary" size="sm" class="mr-2">
              Editar
            </b-button>
            <b-button
              @click="eliminar(data.item.id)"
              variant="outline-danger"
              size="sm"
            >
              Eliminar
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
  </div>
</template>

<script>
import axios from "axios";
import { Global } from "../global";
import Swal from "sweetalert2";
import Loading from "../components/loading.vue";

export default {
  components: { Loading },
  name: "Categories",
  mounted() {
    this.getCategories();
  },
  data() {
    return {
      categories: [],
      fields: [
        { key: "id", sortable: true },
        { key: "name", sortable: true },
        { key: "actions", class: "text-right" },
      ],
      filterOn: ["name"],
      rows: 1,
      currentPage: 1,
      perPage: 5,
      cargando: false,
      filter: null,
    };
  },
  methods: {
    getCategories() {
      this.cargando = true;
      var url = `${Global.URL_API}/categories`;
      axios
        .get(url)
        .then((res) => {
          this.cargando = false;
          if (res.data) {
            this.categories = res.data;
            console.log(this.categories);
            this.rows = this.categories.length;
          }
        })
        .catch((err) => {
          this.cargando = false;
          console.log(err);
        });
    },
    onFiltered(filteredItems) {
      this.rows = filteredItems.length;
      this.currentPage = 1;
    },
    eliminar(id) {
      Swal.fire({
        title: "¿Seguro de eliminar?",
        text: "No podrás recuperar la información de la categoría.",
        showCancelButton: true,
        confirmButtonText: `Eliminar`,
      }).then((result) => {
        if (result.isConfirmed) {
          var url = `${Global.URL_API}/categories/${id}`;
          axios
            .delete(url)
            .then(() => {
              Swal.fire("Categoría eliminada!", "", "success");
              this.getCategories();
            })
            .catch((err) => {              
              Swal.fire(err.response.data.msg, "", "warning");
            });
        }
      });
    },
  },
};
</script>

<style>
</style>