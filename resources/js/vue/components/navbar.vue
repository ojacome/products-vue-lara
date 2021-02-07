<template>
  <div>
    <b-navbar toggleable="lg" type="dark" variant="info">
      <b-navbar-brand to="/">ProductsApp</b-navbar-brand>

      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
          <b-nav-item active-class="active"  to="/products">Products</b-nav-item>
        </b-navbar-nav>
        <b-navbar-nav>
          <b-nav-item active-class="active"  to="/categories">Categories</b-nav-item>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
  </div>
</template>

<script>
export default {
    name: "NavBar"
};
</script>

<style>
</style>