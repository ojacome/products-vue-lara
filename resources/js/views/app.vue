<template>
  <div class="container">
    <h1>{{message}}</h1>
    <button class="btn btn-outline-success">Guardar</button>
    <b-button variant="danger">Button</b-button>
  </div>
</template>
<script>
const default_layout = "default";


export default {
  computed: {},
  data() {
      return {
          message:'Hello World'
      }
  }
};
</script>