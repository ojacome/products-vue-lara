<template>
  <div class="container my-5">
    <div class="row">
      <div class="col-md-6 mx-auto">
        <div class="row">
          <div class="col-md-6">
            <h2>Administrar Categorías</h2>
          </div>
          <div class="col-md-6 text-right">
            <b-button @click="showModal('nuevo')" variant="info"
              >Nueva Categoría</b-button
            >
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
            <b-button
              variant="outline-primary"
              @click="showModal(data.item.id)"
              size="sm"
              class="mr-2"
            >
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

    <b-modal
      id="modal-category"
      ref="modal-category"
      title="Categoría"
      @ok="handleOk"
    >
      <form ref="form" @submit.stop.prevent="handleSubmit">
        <b-form-group label="Nombre" label-for="name-input">
          <b-form-input
            id="name-input"
            placeholder="Nombre de la categoría"
            v-model="category.name"
            :state="$v.category.name.required && $v.category.name.minLength"
            required
          ></b-form-input>
          <b-form-invalid-feedback
            :state="$v.category.name.required && $v.category.name.minLength"
          >
            El nombre es requerido, mínimo 2 caracteres.
          </b-form-invalid-feedback>
        </b-form-group>
      </form>
    </b-modal>
  </div>
</template>

<script>
import axios from "axios";
import { Global } from "../global";
import Swal from "sweetalert2";
import Loading from "../components/loading.vue";
import CategoryModel from "../models/category.model";
import { required, minLength } from "vuelidate/lib/validators";

export default {
  components: { Loading },
  name: "Categories",
  mounted() {
    this.getCategories();
  },
  validations: {
    category: {
      name: { required, minLength: minLength(2) },
    },
  },
  data() {
    return {
      categories: [],
      category: new CategoryModel("", ""),
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
    handleOk(bvModalEvt) {
      // Prevent modal from closing
      bvModalEvt.preventDefault();
      // Trigger submit handler
      this.handleSubmit();
    },
    handleSubmit() {
      // validar formulario
      if (this.$v.$invalid) {
        return;
      }

      if (this.category.id !== "") {
        var url = `${Global.URL_API}/categories/${this.category.id}`;
        axios
          .patch(url, this.category)
          .then(() => {
            Swal.fire("Categoría actualizada!", "", "success");
            this.getCategories();
          })
          .catch((err) => {
            Swal.fire(err.response.data.msg, "", "warning");
          });
      } else {
        var url = `${Global.URL_API}/categories`;
        axios
          .post(url, this.category)
          .then(() => {
            Swal.fire("Categoría creada!", "", "success");
            this.getCategories();
          })
          .catch((err) => {
            Swal.fire(err.response.data.msg, "", "warning");
          });
      }

      // Hide the modal manually
      this.$nextTick(() => {
        this.$bvModal.hide("modal-category");
      });
    },
    showModal(id) {
      if (id === "nuevo") {
        this.category = new CategoryModel("", "");
      } else {
        this.category = this.categories.find((c) => c.id === id);
      }
      this.$refs["modal-category"].show();
    },
  },
};
</script>

<style>
</style>