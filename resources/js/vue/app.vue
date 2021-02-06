<template>
  <div>  
    
    <Navbar/>    


    <router-view></router-view>



  </div>
</template>

<script>
import Navbar from './components/navbar';



export default {
  computed: {},
  components:{
    Navbar
  }   
};
</script>