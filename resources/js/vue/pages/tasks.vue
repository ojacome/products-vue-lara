<template>
  <div class="container my-5">
      <div class="row">
          <div class="col-md-9 mx-auto">
              <h2>Tareas Programadas</h2>
          </div>
      </div>
      
      <div class="row" v-if="cargando" >
      <div class="col-md-9 mx-auto">
        <Loading />
      </div>
    </div>

    <div class="row mt-3 animate__animated animate__fadeIn" v-if="!cargando">
      <div class="col-md-9 mx-auto">
        <b-table
          hover
          responsive
          show-empty
          :items="tasks"
          :fields="fields"
        >          
        </b-table>        
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Loading from '../components/loading';
import { Global } from '../global';


export default {
    name: "Tasks",
    components: {
        Loading
    },
    data(){
        return {
            cargando: false,
            tasks: [],
            fields: [
                { key: "id", sortable: true },
                { key: "name", sortable: true },
                { 
                    key: "created_at", 
                    sortable: true,
                    formatter: value => {
                    return new Date(value)
                    }
                },
            ],
            intervalTask: null
        }
    },
    methods :{
        getTasks(){
            
                this.cargando = true;
                var url = `${Global.URL_API}/task`;
    
                axios.get( url )
                .then( res => {
                    console.log(res);
                    this.cargando = false;
                    this.tasks = res.data;
                    } )
                .catch( err => {
                    console.log(err.response.data);
                    this.cargando = false;
                    } )            
        }
    },
    mounted() {
        this.getTasks();

        this.intervalTask = setInterval(() =>{
            this.getTasks();
        }, 10000)
    },
    destroyed(){
        clearInterval(this.intervalTask);
    }
}
</script>
